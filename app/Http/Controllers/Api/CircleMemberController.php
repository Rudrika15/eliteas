<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleMemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circleMembers = CircleMember::with('circle')
                ->with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['circleMembers' => $circleMembers], 'Circle members retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circleMember = CircleMember::findOrFail($id);
            return Utils::sendResponse(['circleMember' => $circleMember], 'Circle member retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'circleId' => 'required',
            'memberId' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleMember = new CircleMember();
            $circleMember->circleId = $request->circleId;
            $circleMember->memberId = $request->memberId;
            $circleMember->status = 'Active';

            $circleMember->save();

            return Utils::sendResponse(['circleMember' => $circleMember], 'Circle Member Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'circleId' => 'required',
            'memberId' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleMember = CircleMember::find($id);

            if (!$circleMember) {
                return Utils::errorResponse(['error' => 'Circle Member not found.'], 'Not Found', 404);
            }

            $circleMember->circleId = $request->circleId;
            $circleMember->memberId = $request->memberId;
            $circleMember->status = 'Active';
            $circleMember->save();

            return Utils::sendResponse(['circleMember' => $circleMember], 'Circle Member Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circleMember = CircleMember::find($id);

            if (!$circleMember) {
                return Utils::errorResponse(['error' => 'Circle Member not found.'], 'Not Found', 404);
            }

            $circleMember->status = 'Deleted';
            $circleMember->save();

            return Utils::sendResponse([], 'Circle Member Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
