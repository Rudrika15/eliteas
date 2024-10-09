<?php

namespace App\Http\Controllers\Admin;


use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use App\Models\MeetingInvitation;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class CircleMeetingController extends Controller
{


    // public function __construct()
    // {
    //     // Apply middleware for circle call-related permissions
    //     $this->middleware('permission:circle-meeting-index', ['only' => ['index', 'view']]);
    //     $this->middleware('permission:circle-meeting-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:circle-meeting-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:circle-meeting-delete', ['only' => ['delete']]);
    //     $this->middleware('permission:invited-person-list', ['only' => ['invitedPersonList']]);
    // }


    public function index(Request $request)
    {
        try {
            $circlemeeting = CircleMeeting::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlemeeting.index', compact('circlemeeting'));
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
            $circlemeeting = CircleMeeting::findOrFail($id);
            return response()->json($circlemeeting);
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
            $circlemeeting = CircleMeeting::where('status', 'Active')->get();
            return view('admin.circlemeeting.create', compact('circlemeeting'));
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
            'dateTime' => 'required',
            'totalMeeting' => 'required',
            'refGiven' => 'required',
            'refTaken' => 'required',
            'busGiven' => 'required',
            'busTaken' => 'required',
            'hotelName' => 'required',
        ]);
        try {
            $circlemeeting = new CircleMeeting();
            $circlemeeting->dateTime = $request->dateTime;
            $circlemeeting->totalMeeting = $request->totalMeeting;
            $circlemeeting->refGiven = $request->refGiven;
            $circlemeeting->refTaken = $request->refTaken;
            $circlemeeting->busGiven = $request->busGiven;
            $circlemeeting->busTaken = $request->busTaken;
            $circlemeeting->hotelName = $request->hotelName;
            $circlemeeting->status = 'Active';

            $circlemeeting->save();

            return redirect()->route('circlemeeting.index')->with('success', 'Circle Meeting Created Successfully!');
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
            $circlemeeting = CircleMeeting::find($id);
            return view('admin.circlemeeting.edit', compact('circlemeeting'));
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
        $this->validate($request, [
            'dateTime' => 'required',
            'totalMeeting' => 'required',
            'refGiven' => 'required',
            'refTaken' => 'required',
            'busGiven' => 'required',
            'busTaken' => 'required',
            'hotelName' => 'required',

        ]);
        try {
            $id = $request->id;
            $circlemeeting = CircleMeeting::find($id);
            $circlemeeting->dateTime = $request->dateTime;
            $circlemeeting->totalMeeting = $request->totalMeeting;
            $circlemeeting->refGiven = $request->refGiven;
            $circlemeeting->refTaken = $request->refTaken;
            $circlemeeting->busGiven = $request->busGiven;
            $circlemeeting->busTaken = $request->busTaken;
            $circlemeeting->hotelName = $request->hotelName;
            $circlemeeting->status = 'Active';

            $circlemeeting->save();


            return redirect()->route('circlemeeting.index')->with('success', 'Circle Meeting Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    function delete(Request $request, $id)
    {
        try {
            $circlemeeting = CircleMeeting::find($id);
            $circlemeeting->status = "Deleted";
            $circlemeeting->save();

            return redirect()->route('circlemeeting.index')->with('success', 'Circle Meeting Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function invitedPersonList()
    {
        try {
            $invitedPersonList = MeetingInvitation::all();
            return view('admin.circleMeeting.invitedPersonList', compact('invitedPersonList'));
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }
}
