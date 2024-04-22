<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Razorpay;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use App\Models\TrainingRegister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
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

    // public function trainingRegister(Request $request, $trainingId, $trainerId)
    // {
    //     try {
    //         $register = new TrainingRegister();
    //         $register->userId = Auth::user()->id;
    //         $register->trainingId = $trainingId;
    //         $register->trainerId = $trainerId;
    //         $register->save();

    //         return Utils::sendResponse([], 'Training Registered Successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse($th->getMessage(), 'Error Registering Training', 500);
    //     }
    // }


    public function trainingRegister(Request $request)
    {
        try {
            $trainingId = $request->trainingId;
            $trainerId = $request->trainerId;

            $register = new TrainingRegister();
            $register->userId = Auth::user()->id;
            $register->trainingId = $trainingId;
            $register->trainerId = $trainerId;
            $register->save();

            $payment = new Razorpay();
            $payment->r_payment_id = $request->paymentId;
            $payment->user_email = Auth::user()->email;
            $payment->amount = $request->amount;
            $payment->save();

            return response()->json(['message' => 'Training Registered Successfully'], 200);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json(['error' => 'Error Registering Training'], 500);
        }
    }
}
