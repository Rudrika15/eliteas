<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AllPayments;
use App\Models\MeetingInvitation;
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

        $allPayments = new AllPayments();
        $allPayments->memberId = $register->userId;
        $allPayments->amount = $payment->amount;
        // $allPayments->paymentType = $request->input('paymentType'); //ask how to get paymentType - cash or cheque
        $allPayments->paymentType = 'RazorPay'; //ask how to get paymentType - cash or cheque
        // $allPayments->date = now()->format('d-m-Y');
        $allPayments->date = $request->input('date');
        $allPayments->paymentMode = 'Training Register';
        $allPayments->remarks = $payment->r_payment_id;
        $allPayments->save();

        return response()->json(['message' => 'Payment ID stored successfully'], 200);
    }

    public function invitePayment(Request $request)
    {
        $payment = new Razorpay();
        $payment->r_payment_id = $request->input('paymentId');
        $payment->user_email = $request->input('email');
        $payment->amount = $request->input('amount') / 100;
        $payment->save();

        $invitation = MeetingInvitation::where('email', $request->input('email'))->first();
        $invitation->paymentStatus = 'Accepted';
        $invitation->save();
        session()->forget('data');
        return redirect("/")->with("success","Payment done");

        // return response()->json(['message' => 'Payment done'], 200);
    }
}
