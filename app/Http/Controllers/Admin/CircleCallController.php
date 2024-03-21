<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\CircleCall;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CircleCallController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circlecall = CircleCall::with('members')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlecall.index', compact('circlecall'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $circleMember = CircleMember::where('status', '!=', 'Deleted')->with('circle')->with('member')->get();
            $member = Member::where('status', '!=', 'Deleted')->get();
            return view('admin.circlecall.create', compact('member', 'circleMember'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            // 'circleMemberId' => 'required',
            'meetingPerson' => 'required',
            'meetingPlace' => 'required',
            'remarks' => 'required',
        ]);
        try {
            $circlecall = new CircleCall();
            $circlecall->circleMemberId = $request->circleMemberId;
            $circlecall->memberId = $request->memberId;
            $circlecall->meetingPerson = $request->meetingPerson;
            $circlecall->meetingPlace = $request->meetingPlace;
            $circlecall->remarks = $request->remarks;
            $circlecall->status = 'Active';


            $circlecall->save();

            return redirect()->route('circlecall.index')->with('success', 'Circle Call Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $circlecall = CircleCall::find($id);
            $member = Member::where('status', '!=', 'Deleted')->get();
            $circleMember = CircleMember::where('status', '!=', 'Deleted')->get();
            return view('admin.circlecall.edit', compact('circlecall', 'circleMember', 'member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'memberId' => 'required',
            'meetingPerson' => 'required',
            'meetingPlace' => 'required',
            'remarks' => 'required',
        ]);
        try {
            $id = $request->id;
            $circlecall = CircleCall::find($id);
            $circlecall->memberId = $request->memberId;
            $circlecall->meetingPerson = $request->meetingPerson;
            $circlecall->meetingPlace = $request->meetingPlace;
            $circlecall->remarks = $request->remarks;
            $circlecall->status = 'Active';
            $circlecall->save();


            return redirect()->route('circlecall.index')->with('success', 'Circle Call Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $call = CircleCall::find($id);
            $call->status = "Deleted";
            $call->save();

            return redirect()->route('circlecall.index')->with('Success', 'Circle call Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
