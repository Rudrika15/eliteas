<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\membershipType;
use App\Http\Controllers\Controller;
use App\Models\MemberSubscriptions;

class MembershipSubscriptionController extends Controller
{
    public function MembershipHistory(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $subscriptions = MemberSubscriptions::where('userId', $userId)
                ->where('status', 'Active')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'subscriptions' => $subscriptions,
                    'userId' => $userId
                ],
                'message' => 'Subscriptions retrieved successfully'
            ], 200);
        } catch (\Throwable $th) {
            // Log the error for debugging
            Log::error('Error retrieving subscriptions:', ['error' => $th->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Server error. Please try again later.'
            ], 500);
        }
    }



}

