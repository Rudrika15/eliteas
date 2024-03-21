<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CircleMeeting;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleMeetingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circleMeetings = CircleMeeting::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['circleMeetings' => $circleMeetings], 'Circle meetings retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circleMeeting = CircleMeeting::findOrFail($id);
            return Utils::sendResponse(['circleMeeting' => $circleMeeting], 'Circle meeting retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateTime' => 'required',
            'totalMeeting' => 'required',
            'refGiven' => 'required',
            'refTaken' => 'required',
            'busGiven' => 'required',
            'busTaken' => 'required',
            'hotelName' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleMeeting = new CircleMeeting();
            $circleMeeting->dateTime = $request->dateTime;
            $circleMeeting->totalMeeting = $request->totalMeeting;
            $circleMeeting->refGiven = $request->refGiven;
            $circleMeeting->refTaken = $request->refTaken;
            $circleMeeting->busGiven = $request->busGiven;
            $circleMeeting->busTaken = $request->busTaken;
            $circleMeeting->hotelName = $request->hotelName;
            $circleMeeting->status = 'Active';

            $circleMeeting->save();

            return Utils::sendResponse(['circleMeeting' => $circleMeeting], 'Circle Meeting Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'dateTime' => 'required',
            'totalMeeting' => 'required',
            'refGiven' => 'required',
            'refTaken' => 'required',
            'busGiven' => 'required',
            'busTaken' => 'required',
            'hotelName' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleMeeting = CircleMeeting::find($id);

            if (!$circleMeeting) {
                return Utils::errorResponse(['error' => 'Circle Meeting not found.'], 'Not Found', 404);
            }

            $circleMeeting->dateTime = $request->dateTime;
            $circleMeeting->totalMeeting = $request->totalMeeting;
            $circleMeeting->refGiven = $request->refGiven;
            $circleMeeting->refTaken = $request->refTaken;
            $circleMeeting->busGiven = $request->busGiven;
            $circleMeeting->busTaken = $request->busTaken;
            $circleMeeting->hotelName = $request->hotelName;
            $circleMeeting->status = 'Active';
            $circleMeeting->save();

            return Utils::sendResponse(['circleMeeting' => $circleMeeting], 'Circle Meeting Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circleMeeting = CircleMeeting::find($id);

            if (!$circleMeeting) {
                return Utils::errorResponse(['error' => 'Circle Meeting not found.'], 'Not Found', 404);
            }

            $circleMeeting->status = 'Deleted';
            $circleMeeting->save();

            return Utils::sendResponse([], 'Circle Meeting Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
