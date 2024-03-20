<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Member;
use App\Models\CircleCall;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CircleCallController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circlecall = CircleCall::with('members')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['circlecall' => $circlecall], 'Circle Calls retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $circlecall = CircleCall::with('members')->findOrFail($id);
            return Utils::sendResponse(['circlecall' => $circlecall], 'Circle Call retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meetingPerson' => 'required',
            'meetingPlace' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circlecall = new CircleCall();
            $circlecall->fill($request->all());
            $circlecall->status = 'Active';
            $circlecall->save();

            return Utils::sendResponse(['circlecall' => $circlecall], 'Circle Call Created Successfully!', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meetingPerson' => 'required',
            'meetingPlace' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circlecall = CircleCall::findOrFail($id);
            $circlecall->fill($request->all());
            $circlecall->save();

            return Utils::sendResponse(['circlecall' => $circlecall], 'Circle Call Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circlecall = CircleCall::findOrFail($id);
            $circlecall->delete();

            return Utils::sendResponse([], 'Circle Call Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
