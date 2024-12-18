<?php

namespace App\Http\Controllers\Admin;

use App\Models\Circle;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\CircleMeetingMember;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\CircleMember;

class CircleMeetingMembersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $meetingmember = CircleMeetingMember::with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlemeetingmember.index', compact('meetingmember'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $meetingmember = CircleMeetingMember::findOrFail($id);
            return response()->json($meetingmember);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $member = Member::where('status', 'Active')->get();
            return view('admin.circlemeetingmember.create', compact('member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'memberId' => 'required',
            'attandance' => 'required',
        ]);
        try {
            $meetingmember = new CircleMeetingMember();
            $meetingmember->memberId = $request->memberId;
            $meetingmember->attandance = $request->attandance;
            $meetingmember->status = 'Active';

            $meetingmember->save();

            return redirect()->route('meetingmember.index')->with('success', 'Circle Member Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $meetingmember = CircleMeetingMember::find($id);
            $member = Member::where('status', 'Active')->get();
            return view('admin.circlemeetingmember.edit', compact('meetingmember', 'member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'memberId' => 'required',
            'attandance' => 'required',

        ]);
        try {
            $id = $request->id;
            $meetingmember = CircleMeetingMember::find($id);
            $meetingmember->memberId = $request->memberId;
            $meetingmember->attandance = $request->attandance;
            $meetingmember->status = 'Active';

            $meetingmember->save();


            return redirect()->route('meetingmember.index')->with('success', 'Circle Member Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $meetingmember = CircleMeetingMember::find($id);
            $meetingmember->status = "Deleted";
            $meetingmember->save();

            return redirect()->route('meetingmember.index')->with('success', 'Circle Member Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
