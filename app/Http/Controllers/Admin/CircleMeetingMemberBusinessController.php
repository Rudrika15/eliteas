<?php

namespace App\Http\Controllers\Admin;


use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;

class CircleMeetingMemberBusinessController extends Controller
{
    public function index(Request $request)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlebusiness.index', compact('busGiver'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            return response()->json($busGiver);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            // $circlemeeting = CircleMeeting::where('status', 'Active')->get();
            // $member = Member::where('status', 'Active')->get();
            return view('admin.circlebusiness.create');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            // 'dateTime' => 'required',
            // 'totalMeeting' => 'required',
            // 'refGiven' => 'required',
            // 'refTaken' => 'required',
            // 'busGiven' => 'required',
            // 'busTaken' => 'required',
            // 'hotelName' => 'required',
        ]);
        try {
            $busGiver = new CircleMeetingMembersBusiness();
            // $busGiver->memberId = $request->memberId;
            $busGiver->businessGiver = $request->businessGiver;
            $busGiver->loginMember = $request->loginMember;
            $busGiver->amount = $request->amount;
            $busGiver->date = $request->date;
            $busGiver->status = 'Active';

            $busGiver->save();

            return redirect()->route('busGiver.index')->with('success', ' Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::find($id);
            return view('admin.circlebusiness.edit', compact('busGiver'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, []);
        try {
            $id = $request->id;
            $busGiver = CircleMeetingMembersBusiness::find($id);
            // $busGiver->memberId = $request->memberId;
            $busGiver->businessGiver = $request->businessGiver;
            $busGiver->loginMember = $request->loginMember;
            $busGiver->amount = $request->amount;
            $busGiver->date = $request->date;
            $busGiver->status = 'Active';

            $busGiver->save();


            return redirect()->route('busGiver.index')->with('success', ' Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::find($id);
            $busGiver->status = "Deleted";
            $busGiver->save();

            return redirect()->route('busGiver.index')->with('success', ' Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }
}
