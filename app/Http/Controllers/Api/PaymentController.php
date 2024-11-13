<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AllPayments;
use App\Models\Member;
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
                ->paginate(10);

            // Transform amounts after pagination
            $payments->getCollection()->transform(function ($payment) {
                $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
                return $payment;
            });

            return Utils::sendResponse(['payments' => $payments], 'Payment history retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Log the error and return an error response
            ErrorLogger::logError($th, request()->fullUrl());
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
