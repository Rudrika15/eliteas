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

        $findRegister = TrainingRegister::where('userId', Auth::user()->id)
            ->where('trainingId', $nearestTraining->id)
            ->where('trainerId', $nearestTraining->trainers->user->id)
            ->get();
        $testimonials = Testimonial::where('memberId', Auth::user()->member->id)->with('sender')->orderBy('id', 'DESC')->take(3)->get();
        $myCircle = Auth::user()->member->circleId;
        $meeting = Schedule::where('circleId', Auth::user()->member->circleId)
            ->with('circle.members')
            ->with('circle.franchise')
            ->where('status', 'Active')->first();

        // business category
        $businessCategory = BusinessCategory::all();

        $myInvites = MeetingInvitation::where('invitedMemberId', Auth::user()->id)->get();
        return view('home', compact('count', 'nearestTraining', 'findRegister', 'testimonials', 'meeting', 'businessCategory', 'myInvites'));
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

        $personName = $request->personName;
        $personEmail = $request->email;
        $invitedPerson = User::where('id', Auth::user()->id)->first();
        Mail::to($request->personEmail)->send(new MailMeetingInvitation($personName, $personEmail, $invitedPerson));
        return redirect()->back()->with('success', 'Invitation Sent Successfully');
    }
}
