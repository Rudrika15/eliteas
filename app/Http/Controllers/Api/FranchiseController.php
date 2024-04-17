<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Franchise;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $franchises = Franchise::where('status', 'Active')->get();
            return Utils::sendResponse(['franchises' => $franchises], 'Franchises retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $franchise = Franchise::findOrFail($id);
            return Utils::sendResponse(['franchise' => $franchise], 'Franchise retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => 'Franchise not found'], 'Not Found', 404);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'franchiseName' => 'required',
            'franchiseContactDetails' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $franchise = new Franchise();
            $franchise->franchiseName = $request->franchiseName;
            $franchise->franchiseContactDetails = $request->franchiseContactDetails;
            $franchise->status = 'Active';
            $franchise->save();

            return Utils::sendResponse(['franchise' => $franchise], 'Franchise Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'franchiseName' => 'required',
            'franchiseContactDetails' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $franchise = Franchise::find($id);

            if (!$franchise) {
                return Utils::errorResponse(['error' => 'Franchise not found.'], 'Not Found', 404);
            }

            $franchise->franchiseName = $request->franchiseName;
            $franchise->franchiseContactDetails = $request->franchiseContactDetails;
            $franchise->status = 'Active';
            $franchise->save();

            return Utils::sendResponse(['franchise' => $franchise], 'Franchise Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $franchise = Franchise::find($id);

            if (!$franchise) {
                return Utils::errorResponse(['error' => 'Franchise not found.'], 'Not Found', 404);
            }

            $franchise->status = 'Deleted';
            $franchise->save();

            return Utils::sendResponse([], 'Franchise Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
