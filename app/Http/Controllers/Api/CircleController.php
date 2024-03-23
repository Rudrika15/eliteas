<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Franchise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleType;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circles = Circle::with('circleType')
                ->with('city')
                ->with('franchise')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['circles' => $circles], 'Circles retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circle = Circle::findOrFail($id);
            return Utils::sendResponse(['circle' => $circle], 'Circle retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'circleName' => 'required',
            'franchiseId' => 'required',
            'cityId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            'meetingTime' => 'required',
            'numberOfMeetings' => 'required',
            // 'weekNo' => 'required|array', // Ensure weekNo is an array
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circle = new Circle();
            $circle->circleName = $request->circleName;
            $circle->franchiseId = $request->franchiseId;
            $circle->cityId = $request->cityId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->meetingDay;
            $circle->meetingTime = $request->meetingTime;
            $circle->numberOfMeetings = $request->numberOfMeetings;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->start_date = $request->start_date;
            $circle->end_date = $request->end_date;
            $circle->status = 'Active';

            $circle->save();

            return Utils::sendResponse(['circle' => $circle], 'Circle Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'circleName' => 'required',
            'cityId' => 'required',
            'franchiseId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            'meetingTime' => 'required',
            // 'weekNo' => 'required|array', // Ensure weekNo is an array
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circle = Circle::find($id);

            if (!$circle) {
                return Utils::errorResponse(['error' => 'Circle not found.'], 'Not Found', 404);
            }

            $circle->circleName = $request->circleName;
            $circle->cityId = $request->cityId;
            $circle->franchiseId = $request->franchiseId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->meetingDay;
            $circle->meetingTime = $request->meetingTime;
            $circle->start_date = $request->start_date;
            $circle->end_date = $request->end_date;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->status = 'Active';
            $circle->save();

            return Utils::sendResponse(['circle' => $circle], 'Circle Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circle = Circle::find($id);

            if (!$circle) {
                return Utils::errorResponse(['error' => 'Circle not found.'], 'Not Found', 404);
            }

            $circle->status = 'Deleted';
            $circle->save();

            return Utils::sendResponse([], 'Circle Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
