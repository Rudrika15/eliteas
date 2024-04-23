<?php

namespace App\Http\Controllers\Api;

use App\Models\CircleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleTypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circleTypes = CircleType::where('status', 'Active')->get();
            return Utils::sendResponse(['circleTypes' => $circleTypes], 'Circle Types retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circleType = CircleType::findOrFail($id);
            return Utils::sendResponse(['circleType' => $circleType], 'Circle Type retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'circleTypeName' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleType = new CircleType();
            $circleType->circleTypeName = $request->circleTypeName;
            $circleType->status = 'Active';
            $circleType->save();

            return Utils::sendResponse(['circleType' => $circleType], 'Circle Type Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'circleTypeName' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleType = CircleType::find($id);

            if (!$circleType) {
                return Utils::errorResponse(['error' => 'Circle Type not found.'], 'Not Found', 404);
            }

            $circleType->circleTypeName = $request->circleTypeName;
            $circleType->status = 'Active';
            $circleType->save();

            return Utils::sendResponse(['circleType' => $circleType], 'Circle Type Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circleType = CircleType::find($id);

            if (!$circleType) {
                return Utils::errorResponse(['error' => 'Circle Type not found.'], 'Not Found', 404);
            }

            $circleType->status = 'Deleted';
            $circleType->save();

            return Utils::sendResponse([], 'Circle Type Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
