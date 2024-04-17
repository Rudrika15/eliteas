<?php

namespace App\Http\Controllers\Api;

use App\Models\Training;
use App\Models\TrainerMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trainings = Training::with('trainer')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();

            return Utils::sendResponse(['trainings' => $trainings], 'Trainings retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $training = Training::with('trainer')->findOrFail($id);
            return Utils::sendResponse(['training' => $training], 'Training retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trainerId' => 'required',
            'topic' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $training = new Training();
            $training->trainerId = $request->trainerId;
            $training->topic = $request->topic;
            $training->status = 'Active';
            $training->save();

            return Utils::sendResponse(['training' => $training], 'Training Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'trainerId' => 'required',
            'topic' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $training = Training::find($id);

            if (!$training) {
                return Utils::errorResponse(['error' => 'Training not found.'], 'Not Found', 404);
            }

            $training->trainerId = $request->trainerId;
            $training->topic = $request->topic;
            $training->status = 'Active';
            $training->save();

            return Utils::sendResponse(['training' => $training], 'Training Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $training = Training::find($id);

            if (!$training) {
                return Utils::errorResponse(['error' => 'Training not found.'], 'Not Found', 404);
            }

            $training->status = 'Deleted';
            $training->save();

            return Utils::sendResponse([], 'Training Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
