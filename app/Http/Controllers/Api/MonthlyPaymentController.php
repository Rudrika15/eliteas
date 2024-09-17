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
            $monthly = MonthlyPayment::where('memberId', Auth::user()->member->id)->firstOrFail();
            $monthly->status = 'paid';
            $monthly->paymentDate = now();
            $monthly->save();

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
}
