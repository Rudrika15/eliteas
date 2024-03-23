<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use App\Models\CircleMeetingMembersReference;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleMeetingMemberReferenceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $refGivers = CircleMeetingMembersReference::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['refGivers' => $refGivers], 'Circle Meeting Members Reference retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member Reference retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'memberId' => 'required',
            'referenceGiver' => 'required',
            'contactName' => 'required',
            'contactNo' => 'required',
            'email' => 'required|email',
            'scale' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $refGiver = new CircleMeetingMembersReference();
            $refGiver->fill($request->all());
            $refGiver->status = 'Active';
            $refGiver->save();

            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member Reference Created Successfully!', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'memberId' => 'required',
            'referenceGiver' => 'required',
            'contactName' => 'required',
            'contactNo' => 'required',
            'email' => 'required|email',
            'scale' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            $refGiver->fill($request->all());
            $refGiver->save();

            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member Reference Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            $refGiver->delete();

            return Utils::sendResponse([], 'Circle Meeting Member Reference Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
