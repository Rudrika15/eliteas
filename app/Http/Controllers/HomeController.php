<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Schedule;
use App\Models\Training;
use App\Models\TrainingRegister;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // ->whereHas('trainers.user')
            ->with('trainers.user')
            ->orderBy('date', 'asc')
            ->first();

        $findRegister = TrainingRegister::where('userId', Auth::user()->id)
            ->where('trainingId', $nearestTraining->id)
            ->where('trainerId', $nearestTraining->trainers->user->id)
            ->get();

        // upcoming circle meetings
        $myCircle = Member::where('userId', Auth::user()->id)->first();


        $meeting = Schedule::where('circleId', $myCircle->circleId)->where('date', '>=', $currentDate)
            ->with('circle.franchise')
            ->where('status', 'Active')->first();

        return view('home', compact('count', 'nearestTraining', 'findRegister', 'meeting'));
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
}
