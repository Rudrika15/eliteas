<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Circle;
use App\Models\Schedule;
use App\Models\Franchise;
use App\Models\CircleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;

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
                ->get();
            return view('admin.circle.index', compact('circle'));
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
            return view('servererror');
        }
    }
    public function create()
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
            throw $th;
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
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        try {
            $circle = new Circle();
            $circle->circleName = $request->circleName;
            $circle->franchiseId = $request->franchiseId;
            $circle->cityId = $request->cityId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->meetingDay;
            $circle->numberOfMeetings = $request->numberOfMeetings;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->start_date = $request->start_date;
            $circle->end_date = $request->end_date;
            $circle->status = 'Active';
            $circle->save();

            // Logic for creating scheduled meetings
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $weekNumbers = json_decode($circle->weekNo); // Fetch week numbers from the Circle model
            $meetingDay = $circle->meetingDay; // Fetch meeting day from the Circle model

            $currentDate = $startDate->copy()->startOfMonth();
            while ($currentDate <= $endDate) {
                foreach ($weekNumbers as $weekNumber) {
                    // Find the first occurrence of the meeting day in this month
                    $firstOccurrence = $currentDate->copy()->firstOfMonth();
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

                    // Ensure the resulting meeting day is within the month
                    if ($meetingDate->month != $firstOccurrence->month) {
                        // If the resulting meeting day is in the next month, reset to the first occurrence of the meeting day
                        $meetingDate = $firstOccurrence->copy()->addMonths(1);
                        while ($meetingDate->dayOfWeek != $meetingDay) {
                            $meetingDate->addDay();
                        }
                    }

                    if ($meetingDate && $meetingDate->lte($endDate)) {
                        $schedule = new Schedule();
                        $schedule->circleId = $circle->id;
                        $schedule->day = $meetingDate->dayOfWeek; // Store the day of the week
                        $schedule->date = $meetingDate->format('Y-m-d');
                        $schedule->save();
                    }
                }
                $currentDate->addMonth();
            }

            return redirect()->route('circle.index')->with('success', 'Circle Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }






    public function edit($id)
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
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'circleName' => 'required|unique:circles,circleName,' . $request->id,
            'cityId' => 'required',
            'franchiseId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            // 'meetingTime' => 'required',
            'weekNo' => 'required|array', // Ensure weekNo is an array
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        try {
            $id = $request->id;
            $circle = Circle::find($id);
            $circle->circleName = $request->circleName;
            $circle->cityId = $request->cityId;
            $circle->franchiseId = $request->franchiseId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->meetingDay;
            // $circle->meetingTime = $request->meetingTime;
            $circle->start_date = $request->start_date;
            $circle->end_date = $request->end_date;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->status = 'Active';
            $circle->save();

            return redirect()->route('circle.index')->with('success', 'Circle Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $circle = Circle::find($id);
            $circle->status = "Deleted";
            $circle->save();

            return redirect()->route('circle.index')->with('Success', 'Circle Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    
    public function showByCircle(Request $request, $id)
    {
        try {
            $circle = Circle::findOrFail($id);
            $schedules = Schedule::where('circleId', $circle->id)->get();
            return view('admin.circle.show', compact('circle', 'schedules'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
