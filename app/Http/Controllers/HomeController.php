<?php

namespace App\Http\Controllers;

use App\Mail\MeetingInvitation as MailMeetingInvitation;
use App\Models\BillingAddress;
use App\Models\BusinessCategory;
use App\Models\City;
use App\Models\MeetingInvitation;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\Testimonial;
use App\Models\Training;
use App\Models\TrainingRegister;
use App\Models\User;
use App\Models\Connection;
use App\Models\ContactDetails;
use App\Models\Country;
use App\Models\State;
use App\Models\TopsProfile;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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


    public function index()
    {
        $count = Schedule::where('status', 'Active')->count();
        $currentDate = Carbon::now()->toDateString();

        $currentDate = Carbon::now();

        $nearestTraining = Training::where('status', 'Active')
            ->whereDate('date', '>=', $currentDate)
            ->whereHas('trainers.user')
            ->with('trainers.user')
            ->whereHas('trainersTrainings.user')
            // ->with('trainersTrainings.user')
            // ->whereNotNull('data') // Add this line to filter out records where 'data' is not null
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
            // business category

            $testimonials = Testimonial::where('memberId', Auth::user()->member->id)->with('sender')->orderBy('id', 'DESC')->take(3)->get();
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


            // Determine the table name based on the slug


            return view('home', compact('count', 'nearestTraining', 'findRegister', 'testimonials', 'meeting', 'businessCategory', 'myInvites'));
        }
        return view('home', compact('count', 'nearestTraining',  'businessCategory', 'myInvites', 'findRegister'));
    }

    public function trainingRegister($trainingId, $trainerId)
    {
        $register = new TrainingRegister();
        $register->userId = Auth::user()->id;
        $register->trainingId = $trainingId;
        $register->trainerId = $trainerId;
        $register->save();
        return redirect()->back()->with('success', 'Training Registered Successfully');
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
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while sending the invitation. Please try again.');
        }
    }


    public function invitationPay($firstName, $lastName, $amount)
    {
        $amounts =  $amount;
        $data = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'amount' => $amount
        ];
        if (!session()->has("data")) {
            session(["data" => $data]);
        }


        return view('invitationPay', compact('data'));
    }

    public function findMember()
    {
        return view('find');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $members = Member::where('userId', '!=', Auth::user()->id)
            ->where('firstName', 'like', '%' . $query . '%')
            ->orWhere('lastName', 'like', '%' . $query . '%')
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
                ->first();

            // Alternatively, if you want to get all connections related to the authenticated user:
            // $connections = Connection::where('userId', $aid)->get();

            return view('foundPersonDetails', compact('member', 'connection', 'memberStatus'));
        } catch (\Throwable $th) {
            // In case of an error, redirect to servererror view
            return view('servererror');
        }
    }

    public function accepted($id)
    {
        $connection = Connection::find($id);

        $connection->status = 'Accepted';
        $connection->save();

        return redirect()->back()->with('success', 'Connection request accepted');
    }

    public function rejected($id)
    {
        $connection = Connection::find($id);

        $connection->status = 'Rejected';
        $connection->save();

        return redirect()->back()->with('error', 'Connection request rejected');
    }
}
