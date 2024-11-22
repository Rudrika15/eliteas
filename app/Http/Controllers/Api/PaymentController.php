<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AllPayments;
use App\Models\Member;
use App\Models\MemberSubscriptions;
use App\Utils\ErrorLogger;

class PaymentController extends Controller
{
    public function circleAdminPaymentHistory(Request $request)
    {
        try {
            $user = auth()->user();

            // Ensure the user has an associated member and circle
            if (!$user->member || !$user->member->circle) {
                return Utils::errorResponse([], 'User does not belong to a circle', 404);
            }

            $circleId = $user->member->circle->id;

            // Get all circle member IDs
            $circleMembers = Member::where('circleId', $circleId)->pluck('userId')->toArray();

            // Fetch paginated payments
            $payments = AllPayments::where('status', 'Active')
                ->whereIn('memberId', $circleMembers)
                ->get();

            // Transform amounts after pagination
            // $payments->getCollection()->transform(function ($payment) {
            //     $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
            //     return $payment;
            // });

            return Utils::sendResponse(['payments' => $payments], 'Payment history retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Log the error and return an error response
            ErrorLogger::logError($th, request()->fullUrl());
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function mySubscription(Request $request)
    {
        try {
            // Get user ID from the authenticated user
            $userId = $request->user()->id;

            // Retrieve subscriptions for the authenticated user with 'Active' status
            $subscriptions = MemberSubscriptions::where('userId', $userId)
                ->where('status', 'Active')
                ->with('allPayments') // Eager load 'allPayments' relationship
                ->get();

            // Format the amounts for 'allPayments' relationship
            foreach ($subscriptions as $subscription) {
                if ($subscription->allPayments instanceof \Illuminate\Support\Collection) {
                    $subscription->allPayments->transform(function ($payment) {
                        $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
                        return $payment;
                    });
                }
            }

            // Return a successful response with the formatted subscriptions data
            return Utils::sendResponse([
                'subscriptions' => $subscriptions,
                'userId' => $userId,
            ], 'Subscriptions retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error response
            return Utils::errorResponses([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }

    public function getAllPayments(Request $request)
    {
        try {
            // Fetch paginated results
            $myAllPayments = AllPayments::where('status', 'Active')
                ->where('memberId', auth()->id())
                ->get();

            // Transform amounts after pagination
            foreach ($myAllPayments as $payment) {
                $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
            }

            // Return success response
            return Utils::sendResponse(
                ['payments' => $myAllPayments],
                'Payments retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            // Log error and return error response
            ErrorLogger::logError($th, $request->fullUrl());
            return Utils::errorResponse('An error occurred while retrieving payments', 'Internal Server Error', 500);
        }
    }
}
