<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
                ->paginate(10);

            $callWith = CircleCall::with('member')
                ->where('meetingPersonId', Auth::user()->id)
                ->with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('admin.circlecall.index', compact('circlecall', 'callWith'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            //
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
            $circleMember = CircleMember::where('status', '!=', 'Deleted')->with('circle')->with('member')->get();
            // $member = Member::where('status', '!=', 'Deleted')->get();
            $member = User::whereHas('roles', function ($q) {
                $q->where('name', 'Member');
            })->with('member.circle')->get();

            // return $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)->where('status', 'Active')->get(['date']);
            $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('status', 'Active')
                ->where('date')
                ->pluck('date'); // Pluck all 'date' values from the query result

            $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('date', '<', now())
                ->orderBy('date', 'desc')
                ->pluck('date')
                ->first();
            return view('admin.circlecall.create', compact('member', 'circleMember', 'scheduleDate', 'lastDate'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    function getCircle(Request $request): JsonResponse
    {
        $query = $request->input('q');

        $circles = Circle::where('circleName', 'LIKE', '%' . $query . '%')
            ->where('status', 'Active') // Add condition to get only active circles
            ->get();

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
        $members = Member::where('circleId', $circleId)
            ->whereHas('user', function ($q) {
                $q->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['Member', 'Trainer']);
                });
            })
            ->with('user')
            ->with('contact')
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
        $validator = Validator::make($request->all(), [
            'meetingPersonId' => 'required',
            'meetingPlace' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
            'date' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $circlecall = new CircleCall();
            $circlecall->memberId = Auth::user()->id;
            $circlecall->meetingPersonId = $request->meetingPersonId;
            $circlecall->meetingPlace = $request->meetingPlace;
            $circlecall->date = $request->date;
            $circlecall->remarks = $request->remarks;
            $circlecall->status = 'Active';

            $circlecall->save();

            return redirect()->route('circlecall.index')->with('success', 'Data Added Successfully!');
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
            $circlecall = CircleCall::find($id);
            $member = Member::where('status', '!=', 'Deleted')->get();
            $circleMember = CircleMember::where('status', '!=', 'Deleted')->get();

            // Fetch all 'date' values from the query result
            $scheduleDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('status', 'Active')
                ->pluck('date');

            // Fetch the most recent date before the current date
            $lastDate = Schedule::where('circleId', Auth::user()->member->circle->id)
                ->where('date', '<', now())
                ->orderBy('date', 'desc')
                ->pluck('date')
                ->first();

            return view('admin.circlecall.edit', compact('circlecall', 'scheduleDate', 'lastDate', 'circleMember', 'member'));
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a custom error view
            return view('servererror');
        }
    }


    public function update(Request $request)
    {
        try {
            $id = $request->id;
            $circlecall = CircleCall::find($id);
            $circlecall->meetingPersonId = $request->meetingPersonId;
            $circlecall->meetingPlace = $request->meetingPlace;
            $circlecall->remarks = $request->remarks;
            $circlecall->status = 'Active';

            $circlecall->save();

            return redirect()->route('circlecall.index')->with('success', 'Circle Call Updated Successfully!');
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
            $call = CircleCall::find($id);
            $call->status = "Deleted";
            $call->save();

            return redirect()->route('circlecall.index')->with('Success', 'Circle call Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
}
