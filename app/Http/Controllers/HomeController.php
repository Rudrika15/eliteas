<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Utils\Utils;
use App\Models\Event;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\Message;
use App\Models\Location;
use App\Models\Schedule;
use App\Models\Training;
use App\Models\CircleCall;
use App\Models\Connection;
use App\Utils\ErrorLogger;
use App\Models\Testimonial;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\EventRegister;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Models\MonthlyPayment;
use App\Models\BusinessCategory;
use App\Models\TrainingRegister;
use App\Models\MeetingInvitation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Mail\MeetingInvitation as MailMeetingInvitation;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    // public function index()
    // {
    //     $count = Schedule::where('status', 'Active')->count();
    //     $currentDate = Carbon::now()->toDateString();

    //     $currentDate = Carbon::now();

    //     $nearestTraining = Training::where('status', 'Active')
    //         ->whereDate('date', '>=', $currentDate)
    //         ->whereHas('trainers.user')
    //         ->with('trainers.user')
    //         ->whereHas('trainersTrainings.user')
    //         // ->with('trainersTrainings.user')
    //         // ->whereNotNull('data') // Add this line to filter out records where 'data' is not null
    //         ->orderBy('date', 'asc')
    //         ->first();



    //     $businessCategory = BusinessCategory::where('status', 'Active')->get();


    //     $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)->get();


    //     if ($nearestTraining) {
    //         $findRegister = TrainingRegister::where('userId', Auth::user()->id)
    //             ->where('trainingId', $nearestTraining->id)
    //             ->where('trainerId', $nearestTraining->trainersTrainings->user->id)
    //             ->get();
    //     } else {
    //         $findRegister = [];
    //     }




    //     if (!Auth::user()->hasRole('Admin')) {
    //         // business category

    //         $testimonials = Testimonial::where('memberId', Auth::user()->member->id)->with('sender')->orderBy('id', 'DESC')->take(3)->get();
    //         $myCircle = Auth::user()->member->circleId;
    //         $meeting = Schedule::where('circleId', Auth::user()->member->circleId)
    //             ->with('circle.members')
    //             ->with('circle.franchise')
    //             ->where('status', 'Active')
    //             ->where('date', '>=', \today())
    //             ->first();

    //         if ($meeting) {
    //             $meeting->date = Carbon::parse($meeting->date);
    //         } else {
    //             return view('home', ['meeting' => 'No meeting found for now']);
    //         }

    //         $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)
    //             ->where('meetingId', $meeting->id)
    //             ->get();


    //         // Determine the table name based on the slug

    //         //max 1:1 call
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $circlecalls = CircleCall::with(['member', 'meetingPerson'])
    //             ->where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
    //             return [
    //                 'member' => $group->first()->member,
    //                 'count' => $group->count()
    //             ];
    //         })->sortByDesc('count')->first(); // Return only the first (highest count) record

    //         //max business
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
    //             $user = $group->first()->users;
    //             $member = $user->member()->select('circleId', 'businessCategoryId', 'profilePhoto')->first();
    //             $circle = Circle::find($member->circleId);
    //             $businessCategory = BusinessCategory::find($member->businessCategoryId);

    //             return [
    //                 'user' => $user,
    //                 'member' => $member,
    //                 'amount' => $group->sum('amount'),
    //                 'count' => $group->count(),
    //                 'circle' => [
    //                     'id' => $circle->id,
    //                     'circleName' => $circle->circleName,
    //                 ],
    //                 'businessCategory' => [
    //                     'id' => $businessCategory->id,
    //                     'categoryName' => $businessCategory->categoryName,
    //                 ],
    //             ];
    //         })->sortByDesc('amount')->first();

    //         //reference

    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //             ->whereYear('created_at', $previousYear)
    //             ->whereMonth('created_at', $previousMonth)
    //             ->get()
    //             ->groupBy('referenceGiverId')
    //             ->map(function ($group) {

    //                 $referenceGiverId = $group->first()->referenceGiverId ?? null;

    //                 if ($referenceGiverId === null) {
    //                     return null;
    //                 }

    //                 $user = User::find($referenceGiverId);

    //                 if ($user && $user->status === 'Active') {
    //                     $member = Member::where('userId', $referenceGiverId)->where('status', 'Active')->first();

    //                     return [
    //                         'user' => $user,
    //                         'count' => $group->count(),
    //                         'businessCategoryId' => $member ? $member->businessCategoryId : null,
    //                         'businessCategory' => $member ? $member->bcategory->categoryName : null,
    //                         'circleId' => $member ? $member->circleId : null,
    //                         'circle' => $member ? $member->circle->circleName : null,
    //                         'profilePhoto' => $member ? $member->profilePhoto : null,
    //                     ];
    //                 }

    //                 return null;
    //             })
    //             ->filter()
    //             ->sortByDesc('count')
    //             ->first();

    //         //chat Module
    //         // $chat = Message::where('senderId', Auth::user()->id)
    //         //     ->orWhere('receiverId', Auth::user()->id)
    //         //     ->get();


    //         return view('home', compact('count', 'circlecalls', 'busGiver', 'refGiver', 'nearestTraining', 'findRegister', 'testimonials', 'meeting', 'businessCategory', 'myInvites'));
    //     }
    //     return view('home', compact('count', 'nearestTraining',  'businessCategory', 'myInvites', 'findRegister'));
    // }

    public function index()
    {
        try {
            $count = Schedule::where('status', 'Active')->count();
            $currentDate = Carbon::now()->toDateString();
            $currentDate = Carbon::now();

            $nearestTraining = Training::where('status', 'Active')
                ->whereDate('date', '>=', $currentDate)
                ->whereHas('trainers.user')
                ->with('trainers.user')
                ->whereHas('trainersTrainings.user')
                ->orderBy('date', 'asc')
                ->first();

            $businessCategory = BusinessCategory::where('status', 'Active')->get();

            $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)->get();

            if ($nearestTraining) {
                $findRegister = TrainingRegister::where('userId', Auth::user()->id)
                    ->where('trainingId', $nearestTraining->id)
                    ->where('trainerId', $nearestTraining->trainersTrainings->user->id)
                    ->get();
            } else {
                $findRegister = [];
            }

            if (!Auth::user()->hasRole('Admin')) {
                $testimonials = Testimonial::where('memberId', Auth::user()->member->id)
                    ->with('sender')
                    ->orderBy('id', 'DESC')
                    ->take(3)
                    ->get();

                $myCircle = Auth::user()->member->circleId;
                $meeting = Schedule::where('circleId', Auth::user()->member->circleId)
                    ->with('circle.members')
                    ->with('circle.franchise')
                    ->where('status', 'Active')
                    ->where('date', '>=', \today())
                    ->first();

                if ($meeting) {
                    $meeting->date = Carbon::parse($meeting->date);
                } else {
                    return view('home', ['meeting' => 'No meeting found for now']);
                }

                $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)
                    ->where('meetingId', $meeting->id)
                    ->get();

                $previousMonth = Carbon::now()->subMonth()->month;
                $previousYear = Carbon::now()->subMonth()->year;

                $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                    ->where('status', 'Active')
                    ->whereYear('date', $previousYear)
                    ->whereMonth('date', $previousMonth)
                    ->get();

                $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
                    return [
                        'member' => $group->first()->member,
                        'count' => $group->count()
                    ];
                })->sortByDesc('count')->first();

                $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->whereYear('date', $previousYear)
                    ->whereMonth('date', $previousMonth)
                    ->get();

                $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
                    $user = $group->first()->users;
                    $member = $user->member()->select('circleId', 'businessCategoryId', 'profilePhoto')->first();
                    $circle = Circle::find($member->circleId);
                    $businessCategory = BusinessCategory::find($member->businessCategoryId);

                    return [
                        'user' => $user,
                        'member' => $member,
                        'amount' => $group->sum('amount'),
                        'count' => $group->count(),
                        'circle' => [
                            'id' => $circle->id,
                            'circleName' => $circle->circleName,
                        ],
                        'businessCategory' => [
                            'id' => $businessCategory->id,
                            'categoryName' => $businessCategory->categoryName,
                        ],
                    ];
                })->sortByDesc('amount')->first();

                $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                    ->whereYear('created_at', $previousYear)
                    ->whereMonth('created_at', $previousMonth)
                    ->get()
                    ->groupBy('referenceGiverId')
                    ->map(function ($group) {
                        $referenceGiverId = $group->first()->referenceGiverId ?? null;

                        if ($referenceGiverId === null) {
                            return null;
                        }

                        $user = User::find($referenceGiverId);

                        if ($user && $user->status === 'Active') {
                            $member = Member::where('userId', $referenceGiverId)->where('status', 'Active')->first();

                            return [
                                'user' => $user,
                                'count' => $group->count(),
                                'businessCategoryId' => $member ? $member->businessCategoryId : null,
                                'businessCategory' => $member ? $member->bcategory->categoryName : null,
                                'circleId' => $member ? $member->circleId : null,
                                'circle' => $member ? $member->circle->circleName : null,
                                'profilePhoto' => $member ? $member->profilePhoto : null,
                            ];
                        }

                        return null;
                    })
                    ->filter()
                    ->sortByDesc('count')
                    ->first();

                $monthlyPayments = MonthlyPayment::where('status', 'unpaid')
                    ->where('memberId', Auth::user()->member->id)
                    ->get();

                $nearestEvents = Event::where('status', 'Active')
                ->whereDate('event_date', '>=', $currentDate)
                ->orderBy('event_date', 'asc')
                ->first();

                if ($nearestEvents) {
                    $findEventRegister = EventRegister::where('memberId', Auth::user()->member->id)
                        ->where('eventId', $nearestEvents->id)
                        ->get();
                } else {
                    $findEventRegister = [];
                }


                return view('home', compact('count', 'monthlyPayments', 'nearestEvents', 'findEventRegister', 'circlecalls', 'busGiver', 'refGiver', 'nearestTraining', 'findRegister', 'testimonials', 'meeting', 'businessCategory', 'myInvites'));
            }

            return view('home', compact('count', 'nearestTraining', 'businessCategory', 'myInvites', 'findRegister'));
        } catch (\Throwable $th) {
            // Log the error
            throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            // Return a generic error view or message
            return view('servererror')->with('error', 'Failed to load the dashboard');
        }
    }



    public function trainingRegister($trainingId, $trainerId)
    {
        try {
            $register = new TrainingRegister();
            $register->userId = Auth::user()->id;
            $register->trainingId = $trainingId;
            $register->trainerId = $trainerId;
            $register->save();

            return redirect()->back()->with('success', 'Training Registered Successfully');
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to register for the training. Please try again.');
        }
    }


    public function eventRegister($eventId, Request $request)
    {
        try {
            $eventregister = new EventRegister();
            $eventregister->userId = Auth::user()->id;
            $eventregister->eventId = $eventId;
            $eventregister->personName = $request->personName;
            $eventregister->personEmail = $request->personEmail;
            $eventregister->personContact = $request->personContact;
            $eventregister->save();

            return redirect()->back()->with('success', 'Event Registered Successfully');
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to register for the Event. Please try again.');
        }
    }



    public function invitation(Request $request)
    {
        try {
            $request->validate([
                'personName' => 'required',
                'personEmail' => 'required',
                'personContact' => 'required|max:10',
                'businessCategoryId' => 'required',
            ]);

            if (strlen($request->personContact) <= 10) {
                $invitation = new MeetingInvitation();
                $invitation->meetingId = $request->meetingId;
                $invitation->invitedMemberId = Auth::user()->id;
                $invitation->personName = $request->personName;
                $invitation->personEmail = $request->personEmail;
                $invitation->personContact = $request->personContact;
                $invitation->businessCategoryId = $request->businessCategoryId;
                $invitation->save();
            }

            $fees = Schedule::where('id', $request->meetingId)->with('circle.city')->first();
            $personName = $request->personName;
            $personEmail = $request->personEmail;
            $invitedPerson = User::where('id', Auth::user()->id)->first();
            $invitedPersonFirstName = $invitedPerson->firstName;
            $invitedPersonLastName = $invitedPerson->lastName;
            $amount = $fees->circle->city->amount;
            $data = [
                'personName' => $personName,
                'personEmail' => $personEmail,
                'invitedPersonFirstName' => $invitedPersonFirstName,
                'invitedPersonLastName' => $invitedPersonLastName,
                'amount' => $amount
            ];

            if (isset($invitation)) {
                Mail::to($request->personEmail)->send(new MailMeetingInvitation($data));
                return redirect()->back()->with('success', 'Invitation Sent Successfully');
            }
            return redirect()->back()->with('error', 'Please Enter Correct Number');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->back()->with('error', 'An error occurred while sending the invitation. Please try again.');
        }
    }


    public function invitationPay($firstName, $lastName, $amount)
    {
        try {
            $amounts = $amount;
            $data = [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'amount' => $amount
            ];
            if (!session()->has("data")) {
                session(["data" => $data]);
            }
            return view('invitationPay', compact('data'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to load invitation payment details. Please try again.');
        }
    }

    public function findMember()
    {
        try {
            return view('find');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to load member search page. Please try again.');
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $members = Member::where('userId', '!=', Auth::user()->id)
                ->where(function ($q) use ($query) {
                    $q->where('firstName', 'like', '%' . $query . '%')
                        ->orWhere('lastName', 'like', '%' . $query . '%');
                })
                ->whereHas('circle', function ($q) use ($query) {
                    $q->where('circleName', 'like', '%' . $query . '%');
                })
                ->with('user', 'circle')
                ->get();
            $message = "Search results for '$query'";

            return response()->json([
                'message' => $message,
                'members' => $members
            ]);
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return response()->json(['error' => 'Failed to perform search. Please try again.'], 500);
        }
    }





    public function foundPersonDetails($id)
    {
        try {
            $aid = Auth::id(); // Get the ID of the authenticated user
            $member = Member::find($id);


            // Find connection based on the authenticated user's ID and member ID
            $connection = Connection::where('userId', $aid)
                ->orWhere('memberId', $aid)
                ->first();

            $memberStatus = Connection::where('memberId', $member->userId)
                ->orWhere('userId', $member->userId)
                ->first();
            // Alternatively, if you want to get all connections related to the authenticated user:
            // $connections = Connection::where('userId', $aid)->get();

            return view('foundPersonDetails', compact('member', 'connection', 'memberStatus'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            // In case of an error, redirect to servererror view
            return view('servererror');
        }
    }

    public function accepted($id)
    {
        try {
            $connection = Connection::findOrFail($id);
            $connection->status = 'Accepted';
            $connection->save();

            return redirect()->back()->with('success', 'Connection request accepted');
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to accept connection request. Please try again.');
        }
    }

    public function rejected($id)
    {
        try {
            $connection = Connection::findOrFail($id);
            $connection->status = 'Rejected';
            $connection->save();

            return redirect()->back()->with('error', 'Connection request rejected');
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return redirect()->back()->with('error', 'Failed to reject connection request. Please try again.');
        }
    }

    public function userDetails()
    {
        try {
            $ip = request()->ip(); // Dynamic IP address get
            $ipData = \Location::get($ip);
            return view('location', compact('ipData'));
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return with an error message
            return view('location', ['ipData' => null])->with('error', 'Failed to retrieve location information. Please try again.');
        }
    }
}
