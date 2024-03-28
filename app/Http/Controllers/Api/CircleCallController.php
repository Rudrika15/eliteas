<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Circle;
use App\Models\Member;
use App\Models\CircleCall;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CircleCallController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circleCalls = CircleCall::with('members')
            ->where('status', 'Active')
            ->orderBy('id', 'DESC')
            ->get();
            return Utils::sendResponse(['circleCalls' => $circleCalls], 'Circle Calls retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circleCall = CircleCall::with('members')->findOrFail($id);
            return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meetingPersonId' => 'required',
            'meetingPlace' => 'required',
            'date' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleCall = new CircleCall();
            $circleCall->memberId = Auth::user()->id;
            $circleCall->meetingPersonId = $request->meetingPersonId;
            $circleCall->meetingPlace = $request->meetingPlace;
            $circleCall->date = $request->date;
            $circleCall->remarks = $request->remarks;
            $circleCall->status = 'Active';
            $circleCall->save();

            return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call Created Successfully!', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meetingPersonId' => 'required',
            'meetingPlace' => 'required',
            'date' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleCall = CircleCall::findOrFail($id);
            $circleCall->fill($request->all());
            $circleCall->save();

            return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circleCall = CircleCall::findOrFail($id);
            $circleCall->delete();

            return Utils::sendResponse([], 'Circle Call Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
    public function searchmember(Request $request)
    {
        $userId = $request->user()->id;

        if ($request->has('global') && $request->input('global')) {
            $members = Member::where('userId', '!=', $userId)->get();
            return Utils::sendResponse($members, 'All Members Retrieved Successfully!', 200);
        } else {
            $member = Member::where('userId', $userId)->first();

            if ($member) {
                $circleId = $member->circleId;

                $members = Member::where('circleId', $circleId)
                    ->where('userId', '!=', $userId)
                    ->get();

                return Utils::sendResponse($members, 'Members from your Circle Retrieved Successfully!', 200);
            } else {
                return Utils::errorResponse(['error' => 'User not authenticated'], 'Unauthorized', 401);
            }
        }
    }

    }
