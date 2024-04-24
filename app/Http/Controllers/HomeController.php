<?php

namespace App\Http\Controllers;

use App\Mail\MeetingInvitation as MailMeetingInvitation;
use App\Models\BusinessCategory;
use App\Models\MeetingInvitation;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\Testimonial;
use App\Models\Training;
use App\Models\TrainingRegister;
use App\Models\User;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $nearestTraining = Training::where('status', 'Active')
            ->whereDate('date', '>=', $currentDate)
            ->whereHas('trainers.user')
            ->with('trainers.user')
            ->orderBy('date', 'asc')
            ->first();
        $businessCategory = BusinessCategory::all();


        $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)->get();





        $findRegister = TrainingRegister::where('userId', Auth::user()->id)
            ->where('trainingId', $nearestTraining->id)
            ->where('trainerId', $nearestTraining->trainers->user->id)
            ->get();

        if (!Auth::user()->hasRole('Admin')) {
            // business category

            $testimonials = Testimonial::where('memberId', Auth::user()->member->id)->with('sender')->orderBy('id', 'DESC')->take(3)->get();
            $myCircle = Auth::user()->member->circleId;
            $meeting = Schedule::where('circleId', Auth::user()->member->circleId)
                ->with('circle.members')
                ->with('circle.franchise')
                ->where('status', 'Active')->first();

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

    public  function invitation(Request $request)
    {
        $request->validate([
            'personName' => 'required',
            'personEmail' => 'required',
            'personContact' => 'required',
            'businessCategoryId' => 'required',
        ]);

        $invitation = new MeetingInvitation();
        $invitation->meetingId = $request->meetingId;
        $invitation->invitedMemberId = Auth::user()->id;
        $invitation->personName = $request->personName;
        $invitation->personEmail = $request->personEmail;
        $invitation->personContact = $request->personContact;
        $invitation->businessCategoryId = $request->businessCategoryId;
        $invitation->save();

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

        Mail::to($request->personEmail)->send(new MailMeetingInvitation($data));
        return redirect()->back()->with('success', 'Invitation Sent Successfully');
    }


    public function invitationPay($personName, $personEmail, $invitedPersonFirstName, $invitedPersonLastName, $amount)
    {
        $amounts =  $amount;
        $data = [
            'personName' => $personName,
            'personEmail' => $personEmail,
            'invitedPersonFirstName' => $invitedPersonFirstName,
            'invitedPersonLastName' => $invitedPersonLastName,
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
        $members = Member::where('firstName', 'like', '%' . $query . '%')
            ->orWhere('lastName', 'like', '%' . $query . '%')
            ->orWhereHas('circle', function ($q) use ($query) {
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
}
