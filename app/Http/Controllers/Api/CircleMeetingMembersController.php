<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMember;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleMeetingMembersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $meetingMembers = CircleMeetingMember::with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['meetingMembers' => $meetingMembers], 'Circle Meeting Members retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $meetingMember = CircleMeetingMember::findOrFail($id);
            return Utils::sendResponse(['meetingMember' => $meetingMember], 'Circle Meeting Member retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'memberId' => 'required',
            'attandance' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $meetingMember = new CircleMeetingMember();
            $meetingMember->memberId = $request->memberId;
            $meetingMember->attandance = $request->attandance;
            $meetingMember->status = 'Active';

            $meetingMember->save();

            return Utils::sendResponse(['meetingMember' => $meetingMember], 'Circle Meeting Member Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'memberId' => 'required',
            'attandance' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $meetingMember = CircleMeetingMember::find($id);

            if (!$meetingMember) {
                return Utils::errorResponse(['error' => 'Circle Meeting Member not found.'], 'Not Found', 404);
            }

            $meetingMember->memberId = $request->memberId;
            $meetingMember->attandance = $request->attandance;
            $meetingMember->status = 'Active';
            $meetingMember->save();

            return Utils::sendResponse(['meetingMember' => $meetingMember], 'Circle Meeting Member Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $meetingMember = CircleMeetingMember::find($id);

            if (!$meetingMember) {
                return Utils::errorResponse(['error' => 'Circle Meeting Member not found.'], 'Not Found', 404);
            }

            $meetingMember->status = 'Deleted';
            $meetingMember->save();

            return Utils::sendResponse([], 'Circle Meeting Member Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
