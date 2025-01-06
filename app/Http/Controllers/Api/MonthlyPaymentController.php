<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Razorpay;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\MonthlyPayment;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\Member;
use App\Models\User;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\Auth;

class MonthlyPaymentController extends Controller
{
    public function monthlyPaymentStore(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'paymentId' => 'required|string',
                'amount' => 'required|integer',
            ]);

            // Store the payment ID in the Razorpay table
            $payment = new Razorpay();
            $payment->r_payment_id = $request->input('paymentId');
            $payment->user_email = Auth::user()->email;
            $payment->amount = $request->input('amount') / 100;
            $payment->save();

            // Update the MonthlyPayment status
            $monthly = MonthlyPayment::where('memberId', Auth::user()->member->id)
                ->where('status', 'unpaid')
                ->update([
                    'status' => 'paid',
                    'paymentDate' => now(),
                    'updated_at' => now(),
                ]);

            // Store the payment details in AllPayments
            $allPayments = new AllPayments();
            $allPayments->memberId = Auth::user()->member->id;
            $allPayments->amount = $payment->amount;
            $allPayments->paymentType = 'RazorPay'; // Hardcoded for RazorPay
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Monthly Payment';
            $allPayments->remarks = $payment->r_payment_id;
            $allPayments->save();

            // Return a success response
            return Utils::sendResponse([], 'Payment ID stored successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to store payment ID. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    public function monthlyPaymentIndex()
    {
        try {
            // Get the authenticated user based on the Bearer token
            $authUser = auth()->user();

            // Get the member's ID from the authenticated user
            $memberId = $authUser->member->id;

            // Get all unpaid monthly payments for the member
            $unpaidPayments = MonthlyPayment::where('memberId', $memberId)
                ->where('status', 'unpaid') // Only unpaid payments
                ->orderBy('month', 'ASC') // Order by the unpaid months
                ->get();

            // Check if there are any unpaid payments
            if ($unpaidPayments->isEmpty()) {
                return Utils::sendResponse([], 'No unpaid monthly payments found.', 200);
            }

            // Assume each unpaid month is 1500 currency units
            $monthlyAmount = 1500;

            // Calculate the total amount for unpaid months
            $totalUnpaidAmount = $unpaidPayments->count() * $monthlyAmount;

            // Prepare the response data
            $response = [
                'unpaidPayments' => $unpaidPayments, // All unpaid payment details
                'unpaidMonths' => $unpaidPayments->pluck('month'), // List of unpaid months
                'totalAmount' => $totalUnpaidAmount // Total amount based on unpaid months
            ];

            // Return the response with the total unpaid amount, unpaid months, and user details
            return Utils::sendResponse($response, 'Monthly payments and user details retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Handle any exceptions and return an error message
            return Utils::errorResponse([
                'error' => 'Failed to retrieve monthly payments. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    public function updatePaymentStatus(Request $request)
    {
        try {
            // Validate the incoming request data (if necessary)
            $request->validate([
                'id' => 'required|exists:monthly_payments,id',
                'status' => 'required|in:paid,unpaid',
            ]);

            // Find the payment record
            $payment = MonthlyPayment::where('id', $request->id)->first();

            if ($payment) {
                // Update the status in the 'monthly_payments' table
                $monthlyPayment = MonthlyPayment::find($request->id);
                $monthlyPayment->status = 'paid';
                $monthlyPayment->paymentDate = now()->format('Y-m-d');
                $monthlyPayment->updated_at = now();
                $monthlyPayment->save();

                // Add record to the AllPayments table
                $allMonthly = new AllPayments();
                $allMonthly->memberId = $payment->memberId;
                $allMonthly->paymentType = 'Offline';
                $allMonthly->date = now()->format('Y-m-d');
                $allMonthly->paymentMode = 'CASH';
                $allMonthly->amount = 1500; // Assuming 'amount' is a field in the 'monthly_payments' table
                $allMonthly->remarks = 'CASH';
                $allMonthly->status = 'Active';
                $allMonthly->updated_at = now();
                $allMonthly->created_at = now();
                $allMonthly->save();

                // Return success response
                return Utils::sendResponse(
                    ['success' => true],
                    'Payment status updated and payment recorded successfully',
                    200
                );
            }

            // If payment not found
            return Utils::errorResponse('Payment record not found', 'Not Found', 404);
        } catch (\Throwable $th) {
            // Log error and return error response
            ErrorLogger::logError($th, $request->fullUrl());
            return Utils::errorResponse('An error occurred while updating payment status', 'Internal Server Error', 500);
        }
    }

    public function monthlyPayments(Request $request)
    {
        try {
            // Authenticate the user
            if (!auth()->check()) {
                return Utils::errorResponse('Unauthorized', 'Unauthorized', 401);
            }

            // Get the authenticated user
            $userId = auth()->id();

            // Fetch the circleId from the members table based on the authenticated user
            $member = Member::where('userId', $userId)->first();

            if (!$member) {
                return Utils::errorResponse('Member not found', 'Not Found', 404);
            }

            $circleId = $member->circleId;

            // Retrieve the 'status' from the request if provided
            $status = $request->input('status');

            // Retrieve circles where status is 'Active'
            $circles = Circle::where('status', 'Active')->get();

            // Fetch monthly payments filtered by circleId and status if provided
            if ($status) {
                $monthlyPayments = MonthlyPayment::where('circleId', $circleId)
                    ->where('status', $status)
                    ->get();
            } else {
                // If no status is selected, show all monthly payments for the user's circleId
                $monthlyPayments = MonthlyPayment::where('circleId', $circleId)
                    ->get();
            }

            // Get the member's name based on memberId
            foreach ($monthlyPayments as $payment) {
                $memberDetails = Member::find($payment->memberId);

                if ($memberDetails) {
                    // Get the userId from members table to fetch name from users table
                    $user = User::find($memberDetails->userId);

                    if ($user) {
                        // Add the name to the payment data
                        $payment->memberName = $user->firstName . ' ' . $user->lastName;
                    } else {
                        $payment->memberName = 'Unknown User'; // In case user not found
                    }
                } else {
                    $payment->memberName = 'Unknown Member'; // In case member not found
                }
            }

            // Return success response with the data
            return Utils::sendResponse(
                [
                    'monthlyPayments' => $monthlyPayments,
                    'status' => $status,
                    'circles' => $circles
                ],
                'Monthly payments retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            // Log the error and return a response for unexpected errors
            ErrorLogger::logError($th, $request->fullUrl());
            return Utils::errorResponse('An error occurred while fetching monthly payments', 'Internal Server Error', 500);
        }
    }
}
