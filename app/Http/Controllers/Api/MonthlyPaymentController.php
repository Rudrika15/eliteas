<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Razorpay;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\MonthlyPayment;
use App\Http\Controllers\Controller;
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
            $allPayments->memberId = $monthly->memberId;
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


    

}
