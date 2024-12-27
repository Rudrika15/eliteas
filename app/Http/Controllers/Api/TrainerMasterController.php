<?php

namespace App\Http\Controllers\Api;

use App\Models\TrainerMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Utils;

class TrainerMasterController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trainers = TrainerMaster::where('status', 'Active')->get();
            return Utils::sendResponse(['trainers' => $trainers], 'Trainers retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $trainer = TrainerMaster::findOrFail($id);
            return Utils::sendResponse(['trainer' => $trainer], 'Trainer retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'trainerName' => 'required',
        ]);

        try {
            $trainer = new TrainerMaster();
            $trainer->trainerName = $request->trainerName;
            $trainer->status = 'Active';
            $trainer->save();

            return Utils::sendResponse(['trainer' => $trainer], 'Trainer Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'trainerName' => 'required',
        ]);

        try {
            $trainer = TrainerMaster::find($id);

            if (!$trainer) {
                return Utils::errorResponse(['error' => 'Trainer not found.'], 'Not Found', 404);
            }

            $trainer->trainerName = $request->trainerName;
            $trainer->status = 'Active';
            $trainer->save();

            return Utils::sendResponse(['trainer' => $trainer], 'Trainer Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $trainer = TrainerMaster::find($id);

            if (!$trainer) {
                return Utils::errorResponse(['error' => 'Trainer not found.'], 'Not Found', 404);
            }

            $trainer->status = 'Deleted';
            $trainer->save();

            return Utils::sendResponse([], 'Trainer Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
