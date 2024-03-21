<?php

namespace App\Http\Controllers\Api;

use App\Models\CircleMeetingMembersBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class CircleMeetingMemberBusinessController extends Controller
{
    public function index(Request $request)
    {
        try {
            $busGivers = CircleMeetingMembersBusiness::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['busGivers' => $busGivers], 'Circle Meeting Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            return Utils::sendResponse(['busGiver' => $busGiver], 'Circle Meeting Member Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'businessGiver' => 'required',
            'loginMember' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->fill($request->all());
            $busGiver->status = 'Active';
            $busGiver->save();

            return Utils::sendResponse(['busGiver' => $busGiver], 'Circle Meeting Member Business Created Successfully!', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'businessGiver' => 'required',
            'loginMember' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            $busGiver->fill($request->all());
            $busGiver->save();

            return Utils::sendResponse(['busGiver' => $busGiver], 'Circle Meeting Member Business Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            $busGiver->status = "Deleted";
            $busGiver->save();

            return Utils::sendResponse([], 'Circle Meeting Member Business Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
