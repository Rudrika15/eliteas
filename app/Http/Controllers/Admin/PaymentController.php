<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Razorpay;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\TrainingRegister;
use App\Models\MeetingInvitation;
use App\Models\MemberSubscription;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        return redirect("/")->with("success", "Payment done");

        // return response()->json(['message' => 'Payment done'], 200);
    }

    public function membershipPayment(Request $request)
    {
        try {
            // Debugging: Log the incoming request data
            Log::info('Incoming request data:', $request->all());

            // Store Razorpay payment
            $payment = new Razorpay();
            $payment->r_payment_id = $request->input('paymentId');
            $payment->user_email = $request->input('email');
            $payment->amount = $request->input('amount') / 100;
            $payment->save();

            // Debugging: Confirm Razorpay payment save
            Log::info('Razorpay payment saved:', $payment->toArray());

            // Find the user
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                Log::error('User not found for email:', ['email' => $request->input('email')]);
                return response()->json(['error' => 'User not found'], 404);
            }

            // Store MemberSubscription
            $subscription = new MemberSubscription();
            $subscription->userId = $user->id;
            $subscription->paymentId = $payment->r_payment_id;
            if ($request->membershipType == 'Monthly') {
                $subscription->validity = now()->addMonths(1)->format('Y-m-d');
            } elseif ($request->membershipType == 'Year') {
                $subscription->validity = now()->addYear(1)->format('Y-m-d');
            } else {
                $subscription->validity = "null";
            }
            $subscription->membershipType = $request->membershipType;
            $subscription->status = 'Active';
            $subscription->save();

            // Debugging: Confirm MemberSubscription save
            Log::info('Member subscription saved:', $subscription->toArray());

            // Store AllPayments
            $allPayments = new AllPayments();
            $allPayments->memberId = $subscription->userId;
            $allPayments->amount = $payment->amount;
            $allPayments->paymentType = 'RazorPay'; // Assume RazorPay for this example
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Membership Subscription';
            $allPayments->remarks = $payment->r_payment_id;
            $allPayments->save();

            // Debugging: Confirm AllPayments save
            Log::info('All payments saved:', $allPayments->toArray());

            return response()->json(['success' => true, 'message' => 'Payment processed successfully']);
        } catch (\Exception $e) {
            // Debugging: Log the exception
            Log::error('Error processing payment:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to process payment'], 500);
        }
    }
}
