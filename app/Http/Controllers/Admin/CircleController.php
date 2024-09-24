<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\Schedule;
use App\Models\Franchise;
use App\Models\CircleType;
use App\Utils\ErrorLogger;
use Illuminate\Support\Str;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Mail\MeetingInvitation;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class CircleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circle = Circle::with('circleType')
                ->with('city')->where('status', '!=', 'Deleted')
                ->with('franchise')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('admin.circle.index', compact('circle'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $circle = Circle::findOrFail($id);
            return response()->json($circle);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }
    public function create(Request $request)
    {
        try {
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            $city = City::where('status', '!=', 'Deleted')->get();
            $circle = Circle::where('status', '!=', 'Deleted')->get();
            $franchise = Franchise::where('status', '!=', 'Deleted')->get();
            $circletype = CircleType::where('status', '!=', 'Deleted')->get();
            return view('admin.circle.create', compact('circle', 'franchise', 'city', 'circletype', 'countries', 'states', 'cities'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function store(Request $request)

    {
        $this->validate($request, [
            'circleName' => 'required|unique:circles',
            'franchiseId' => 'required',
            'cityId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            'numberOfMeetings' => 'required',
            'weekNo' => 'required|array', // Ensure weekNo is an array
        ]);

        try {
            $circle = new Circle();
            $circle->circleName = $request->circleName;
            $circle->franchiseId = $request->franchiseId;
            $circle->cityId = $request->cityId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->input('meetingDay');
            $circle->numberOfMeetings = $request->numberOfMeetings;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->status = 'Active';
            $circle->save();

            // Logic for creating scheduled meetings
            $currentDate = Carbon::now();
            $weekNumbers = json_decode($circle->weekNo); // Fetch week numbers from the Circle model
            $meetingDay = $circle->meetingDay; // Fetch meeting day from the Circle model

            // Function to schedule meetings for a given month
            $scheduleMeetingsForMonth = function ($date) use ($circle, $weekNumbers, $meetingDay) {
                $startOfMonth = $date->copy()->startOfMonth();
                $futureMeetingFound = false; // Flag to check if any future meetings are found

                foreach ($weekNumbers as $weekNumber) {
                    // Find the first occurrence of the meeting day in this month
                    $firstOccurrence = $startOfMonth->copy()->firstOfMonth();
                    while ($firstOccurrence->dayOfWeek != $meetingDay) {
                        $firstOccurrence->addDay();
                    }

                    $meetingDate = null; // Initialize $meetingDate variable

                    // Check which week number is selected and calculate meeting dates accordingly
                    if ($weekNumber === 'Week 1') {
                        $meetingDate = $firstOccurrence->copy();
                    } elseif ($weekNumber === 'Week 2') {
                        $meetingDate = $firstOccurrence->copy()->addWeek();
                    } elseif ($weekNumber === 'Week 3') {
                        $meetingDate = $firstOccurrence->copy()->addWeeks(2);
                    } elseif ($weekNumber === 'Week 4') {
                        $meetingDate = $firstOccurrence->copy()->addWeeks(3);
                    }

                    // Ensure the resulting meeting day is within the month and in the future
                    if ($meetingDate && $meetingDate->month == $startOfMonth->month) {
                        if ($meetingDate->isFuture()) {
                            $futureMeetingFound = true; // Future meeting found
                            
                            // Create a basic slug using the circle name and meeting date
                            $slug = Str::slug($circle->circleName . '-' . $meetingDate->format('Y-m-d'));
                    
                            // Check if the slug already exists
                            if (Schedule::where('cm_slug', $slug)->exists()) {
                                // If it exists, append a unique identifier
                                $slug = $slug . '-' . uniqid();
                            }
                    
                            // Create and save the new schedule
                            $schedule = new Schedule();
                            $schedule->circleId = $circle->id;
                            $schedule->day = $meetingDate->dayOfWeek; // Store the day of the week
                            $schedule->date = $meetingDate->format('Y-m-d');
                            $schedule->cm_slug = $slug; // Store the generated slug
                            $schedule->save();
                        }
                    }
                    
                }

                return $futureMeetingFound;
            };

            // Check if any future meetings can be scheduled for the current month
            $futureMeetingsScheduled = $scheduleMeetingsForMonth($currentDate);

            // If no future meetings were scheduled for the current month, schedule for the next month
            if (!$futureMeetingsScheduled) {
                $nextMonth = $currentDate->copy()->addMonth();
                $scheduleMeetingsForMonth($nextMonth);
            } else {
                // Check if the current month is almost over
                if ($currentDate->day > 20) {
                    // Schedule meetings for the next month
                    $nextMonth = $currentDate->copy()->addMonth();
                    $scheduleMeetingsForMonth($nextMonth);
                }
            }

            return redirect()->route('circle.index')->with('success', 'Circle Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }




    public function edit(Request $request, $id)
    {
        try {
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            $circle = Circle::find($id);
            $franchise = Franchise::where('status', '!=', 'Deleted')->get();
            $city = City::where('status', '!=', 'Deleted')->get();
            $circletype = CircleType::where('status', '!=', 'Deleted')->get();
            return view('admin.circle.edit', compact('franchise', 'circletype', 'city', 'circle', 'countries', 'states', 'cities'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function update(Request $request)
    {
        // return request()->all();
        $this->validate($request, [
            // 'circleName' => 'required|unique:circles,circleName,' . $request->id,
            'franchiseId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            'numberOfMeetings' => 'required',
            // 'weekNo' => 'required|array', // Ensure weekNo is an array
        ]);

        try {
            $id = $request->id;
            $circle = Circle::findOrFail($id);
            $circle->circleName = $request->circleName;
            $circle->franchiseId = $request->franchiseId;
            $circle->cityId = $request->cityId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->input('meetingDay');
            $circle->numberOfMeetings = $request->numberOfMeetings;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->status = 'Active';
            $circle->save();

            return redirect()->route('circle.index')->with('success', 'Circle Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            // Find the circle by ID
            $circle = Circle::find($id);

            // Check if the circle exists
            if ($circle) {
                // Set the circle status to "Deleted"
                $circle->status = "Deleted";
                $circle->save();

                // Update the status of related schedules to "Deleted"
                Schedule::where('circleId', $id)->update(['status' => 'Deleted']);

                // Redirect with success message
                return redirect()->route('circle.index')->with('Success', 'Circle and associated schedules updated successfully!');
            } else {
                // If the circle is not found, redirect with an error message
                return redirect()->route('circle.index')->with('Error', 'Circle not found!');
            }
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            // Handle any exceptions and show the server error page
            return view('servererror');
        }
    }



    public function showByCircle(Request $request, $id)
    {
        try {
            $circle = Circle::findOrFail($id);
            $schedules = Schedule::where('circleId', $circle->id)->paginate(10);
            return view('admin.circle.show', compact('circle', 'schedules'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function memberList(Request $request, $id)
    {
        try {
            $circle = Circle::findOrFail($id);
            $members = Member::where('circleId', $circle->id)->paginate(10);
            return view('admin.circle.memberList', compact('circle', 'members'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    ///generate new meetings

    public function generateMeetings(Request $request, $circleId)
    {
        try {
            $circle = Circle::findOrFail($circleId);

            // Logic for creating scheduled meetings
            $currentDate = Carbon::now();
            $weekNumbers = json_decode($circle->weekNo); // Fetch week numbers from the Circle model
            $meetingDay = $circle->meetingDay; // Fetch meeting day from the Circle model

            // Function to schedule meetings for a given month
            $scheduleMeetingsForMonth = function ($date) use ($circle, $weekNumbers, $meetingDay) {
                $startOfMonth = $date->copy()->startOfMonth();
                $futureMeetingFound = false; // Flag to check if any future meetings are found

                foreach ($weekNumbers as $weekNumber) {
                    // Find the first occurrence of the meeting day in this month
                    $firstOccurrence = $startOfMonth->copy()->firstOfMonth();
                    while ($firstOccurrence->dayOfWeek != $meetingDay) {
                        $firstOccurrence->addDay();
                    }

                    $meetingDate = null; // Initialize $meetingDate variable

                    // Check which week number is selected and calculate meeting dates accordingly
                    if ($weekNumber === 'Week 1') {
                        $meetingDate = $firstOccurrence->copy();
                    } elseif ($weekNumber === 'Week 2') {
                        $meetingDate = $firstOccurrence->copy()->addWeek();
                    } elseif ($weekNumber === 'Week 3') {
                        $meetingDate = $firstOccurrence->copy()->addWeeks(2);
                    } elseif ($weekNumber === 'Week 4') {
                        $meetingDate = $firstOccurrence->copy()->addWeeks(3);
                    } elseif ($weekNumber === 'Week 5') {
                        $meetingDate = $firstOccurrence->copy()->addWeeks(4);
                    }

                    if ($meetingDate && $meetingDate->greaterThan($date)) {
                        // Check if meeting already exists for this date
                        $existingMeeting = Schedule::where('circleId', $circle->id)
                            ->whereDate('date', $meetingDate->format('Y-m-d'))
                            ->first();
                    
                        if (!$existingMeeting) {
                            // Create a basic slug using the circle name and meeting date
                            $slug = Str::slug($circle->circleName . '-' . $meetingDate->format('Y-m-d'));
                    
                            // Check if the slug already exists
                            if (Schedule::where('cm_slug', $slug)->exists()) {
                                // If it exists, append a unique identifier
                                $slug = $slug . '-' . uniqid();
                            }
                    
                            // Create and save the new schedule
                            $schedule = new Schedule();
                            $schedule->circleId = $circle->id;
                            $schedule->day = $meetingDate->dayOfWeek; // Store the day of the week
                            $schedule->date = $meetingDate->format('Y-m-d');
                            $schedule->venue = null;
                            $schedule->meetingTime = null; // Example time
                            $schedule->remarks = null;
                            $schedule->status = 'Active';
                            $schedule->cm_slug = $slug; // Store the generated slug
                            $schedule->save();
                    
                            $futureMeetingFound = true;
                        }
                    }
                    
                }

                return $futureMeetingFound;
            };

            // Generate meetings for the month
            $futureMeetingsFound = false;
            $currentMonth = $currentDate->month;
            $currentYear = $currentDate->year;
            $startDate = Carbon::createFromDate($currentYear, $currentMonth, 1)->startOfMonth()->addMonth();
            $endDate = Carbon::createFromDate($currentYear, $currentMonth, $currentDate->daysInMonth)->endOfMonth();

            while (!$futureMeetingsFound) {
                $futureMeetingsFound = $scheduleMeetingsForMonth($startDate);
                $startDate->addMonth();
            }

            if ($futureMeetingsFound) {
                return redirect()->back()->with('success', 'Meetings for the next month have been generated.');
            } else {
                return redirect()->back()->with('error', 'Meetings for the next month have already been generated.');
            }
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }
}
