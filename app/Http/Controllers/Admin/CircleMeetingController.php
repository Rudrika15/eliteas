<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\CircleMeeting;
use App\Models\MeetingInvitation;

class CircleMeetingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circlemeeting = CircleMeeting::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlemeeting.index', compact('circlemeeting'));
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $circlemeeting = CircleMeeting::where('status', 'Active')->get();
            return view('admin.circlemeeting.create', compact('circlemeeting'));
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $circlemeeting = CircleMeeting::find($id);
            return view('admin.circlemeeting.edit', compact('circlemeeting'));
        } catch (\Throwable $th) {
            throw $th;
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
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $circlemeeting = CircleMeeting::find($id);
            $circlemeeting->status = "Deleted";
            $circlemeeting->save();
            
            return redirect()->route('circlemeeting.index')->with('success', 'Circle Meeting Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function invitedPersonList()
    {
        $invitedPersonList = MeetingInvitation::all();
        return view('admin.circleMeeting.invitedPersonList', compact('invitedPersonList'));
    }

}
