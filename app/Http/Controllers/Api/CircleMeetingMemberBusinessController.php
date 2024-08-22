<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Utils\Utils;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\BusinessAmount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CircleMeetingMembersBusiness;

class CircleMeetingMemberBusinessController extends Controller
{
    public function index(Request $request)
    {
        try {
            $busGivers = CircleMeetingMembersBusiness::with([
                'users:id,firstName,lastName,email',
                'member:userId,profilePhoto',
                'businessAmounts' // Include business amounts relationship
            ])
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->get();



            return Utils::sendResponse(['busGivers' => $busGivers], 'Circle Meeting Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function recievedBus(Request $request)
    {
        try {
            $busRecieved = CircleMeetingMembersBusiness::where('businessGiverId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['busRecieved' => $busRecieved], 'Circle Meeting Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
    



    
    public function paymentHistory(Request $request)
    {
        try {
            $paymentHistory = BusinessAmount::where('status', 'Active')
                ->where('circleMeetingMemberBusinessId')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['paymentHistory' => $paymentHistory], 'Circle Meeting Members Business Payment History retrieved successfully', 200);
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
            'remarks' => 'required',
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
        try {
            $id = $request->id;
            $busGiver = CircleMeetingMembersBusiness::find($id);

            // Check if the business giver exists
            if (!$busGiver) {
                return Utils::errorResponse([], 'Circle Meeting Member Business not found', 404);
            }

            // Retrieve memberId using userId
            $userId = $busGiver->businessGiverId;
            $member = Member::where('userId', $userId)->first();

            // Check if the member exists
            if (!$member) {
                return Utils::errorResponse([], 'Member not found', 404);
            }

            // Get the user associated with the member
            $user = User::find($userId);

            // Check if the user exists
            if (!$user) {
                return Utils::errorResponse([], 'User not found', 404);
            }

            // Update business giver amount and status
            $busGiver->amount += $request->amount;
            $busGiver->status = 'Active';
            $busGiver->save();

            $businessAmount = new BusinessAmount();
            $businessAmount->circleMeetingMemberBusinessId = $id;
            $businessAmount->amount = $request->amount;
            $businessAmount->date = Carbon::now()->toDateString();
            $businessAmount->status = 'Active';
            $businessAmount->save();

            return Utils::sendResponse([
                'busGiver' => $busGiver,
                'businessAmount' => $businessAmount,
                'userId' => $user->id,
                'profilePhoto' => $member->profilePhoto,
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'email' => $user->email
            ], 'Circle Meeting Member Business Updated Successfully!', 200);
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
