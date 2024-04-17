<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Razorpay;
use App\Models\TrainingRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function store(Request $request)
    {

        // Store the payment ID in the table
        $payment = new Razorpay();
        $payment->r_payment_id = $request->input('paymentId');
        $payment->user_email = Auth::user()->email;
        $payment->amount = $request->input('amount') / 100;
        $payment->save();

        $register = new TrainingRegister();
        $register->userId = Auth::user()->id;
        $register->trainingId = $request->input('trainingId');
        $register->trainerId = $request->input('trainerId');
        $register->save();

        return response()->json(['message' => 'Payment ID stored successfully'], 200);
    }
}
