<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\CircleCall;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CircleCallController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circlecall = CircleCall::with('member')
                ->where('memberId', Auth::user()->id)
                ->with('meetingPerson')
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
            //
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $circleMember = CircleMember::where('status', '!=', 'Deleted')->with('circle')->with('member')->get();
            // $member = Member::where('status', '!=', 'Deleted')->get();
            $member = User::whereHas('roles', function ($q) {
                $q->where('name', 'Member');
            })->with('member.circle')->get();

            // return $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)->where('status', 'Active')->get(['date']);
            $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('status', 'Active')
                ->pluck('date'); // Pluck all 'date' values from the query result

            return view('admin.circlecall.create', compact('member', 'circleMember', 'scheduleDate'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    function getCircle(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $circles = Circle::where('circleName', 'LIKE', '%' . $query . '%')->get();

        $userCircle = Member::where('userId', Auth::user()->id)->with('circle')->first();

        $userCircleName = $userCircle ? $userCircle->circle->circleName : null;

        return response()->json([
            'circles' => $circles,
            'userCircleName' => $userCircleName,
        ]);
    }
    public function getCircleMembers(Request $request)
    {

        $circleId = $request->input('circleId');
        $members = Member::where('circleId', $circleId)->with('user')->with('contact')
            ->where('userId', '!=', Auth::user()->id)
            ->get();
        return response()->json($members);
    }
    function getMember(Request $request): JsonResponse
    {
        $query = $request->input('q');
        $all = $request->input('all');

        $data = [];

        $myCircle = Member::where('userId', Auth::user()->id)->with('circle')->first();

        // Search all members if the checkbox is checked
        if ($all) {
            $data = User::whereHas('roles', function ($q) {
                $q->where('name', 'Member');
            })
                ->where('firstName', 'LIKE', '%' . $query . '%')
                ->where('id', '!=', Auth::user()->id)
                ->with('member.circle') // Include circle information
                ->get();
        } else {
            $data = User::whereHas('roles', function ($q) {
                $q->where('name', 'Member');
            })
                ->whereHas('member', function ($q) use ($myCircle) {
                    $q->where('circleId', $myCircle->circle->id);
                })
                ->where('firstName', 'LIKE', '%' . $query . '%')
                ->where('id', '!=', Auth::user()->id)
                ->with('member.circle') // Include circle information
                ->get();
        }


        return response()->json($data);
    }
    function getMemberForRef(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $data = [];

        $data = User::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })
            ->where('firstName', 'LIKE', '%' . $query . '%')
            ->where('id', '!=', Auth::user()->id)
            ->with('member.circle') // Include circle information
            ->get();


        return response()->json($data);
    }
    function getMemberForRefGiver(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $data = [];

        $data = User::whereHas('roles', function ($q) {
            $q->where('name', 'Member');
        })
            ->where('firstName', 'LIKE', '%' . $query . '%')
            ->where('id', '!=', Auth::user()->id)
            ->with('member.circle')
            ->get();


        return response()->json($data);
    }


    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'meetingPersonId' => 'required',
            'meetingPlace' => 'required',
            'date' => 'required',
            'remarks' => 'required',
        ]);
        try {
            $circlecall = new CircleCall();
            $circlecall->memberId = Auth::user()->id;
            $circlecall->meetingPersonId = $request->meetingPersonId;
            $circlecall->meetingPlace = $request->meetingPlace;
            $circlecall->date = $request->date;
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
