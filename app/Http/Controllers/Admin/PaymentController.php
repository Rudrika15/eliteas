<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Razorpay;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Mail\WelcomeMemberEmail;
use App\Models\TrainingRegister;
use App\Models\MeetingInvitation;
use App\Models\MemberSubscriptions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\MembershipRenewed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
            $subscription = new MemberSubscriptions();
            $subscription->userId = $user->id;
            $subscription->paymentId = $payment->r_payment_id;

            // Get the member
            $member = Member::where('userId', $user->id)->first();
            if ($member->membershipType == 'Monthly') {
                $subscription->validity = now()->addMonth()->format('Y-m-d');
            }
            if ($member->membershipType == 'Yearly') {
                $subscription->validity = Carbon::now()->addDay('365')->format('Y-m-d');
                // now()->addYear()->format('Y-m-d');
            }

            $subscription->membershipType = $member->membershipType;

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

            // Send welcome email to user after successful payment
            $user = User::where('email', $payment->user_email)->first();
            $rowPassword = $user->password;
            Mail::to($user->email)->send(new WelcomeMemberEmail($user, $rowPassword));

            return response()->json(['success' => true, 'message' => 'Payment processed successfully']);
        } catch (\Exception $e) {
            // Debugging: Log the exception
            Log::error('Error processing payment:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to process payment'], 500);
        }
    }


    public function allPayments()
    {
        $payments = AllPayments::where('status', 'Active')->get();
        return view('admin.paymentHistory.index', compact('payments'));
    }

    public function circleAdminPaymentHistory()
    {
        $user = auth()->user();

        $circleId = $user->member->circle->id;

        $circleMembers = Member::where('circleId', $circleId)->pluck('userId')->toArray();

        $payments = AllPayments::where('status', 'Active')
            ->whereIn('memberId', $circleMembers)
            ->get();
        // return $circleMembersIds = $circleMembers->pluck('id')->toArray();

        // $payments = AllPayments::where('status', 'Active')
        //     // ->where('memberId', $circleId)
        //     ->get();

        return view('admin.paymentHistory.circleAdminPaymentHistory', compact('payments'));
    }


    public function myAllPayments()
    {
        $myAllPayments = AllPayments::where('status', 'Active')
            ->where('memberId', auth()->id())
            ->get();
        return view('admin.paymentHistory.userIndex', compact('myAllPayments'));
    }

    public function pendingPayments()
    {
        return view('pendingPayments');
    }


    public function renewMembership($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        // Add your logic to renew the membership here
        // Example: extend membership validity by one year
        // $subscription = $user->subscription;
        // $subscription->validity = \Carbon\Carbon::now()->addYear();
        // $subscription->save();

        // Send an email to the user
        Mail::to($user->email)->send(new MembershipRenewed($user));

        session()->flash('success', 'Membership renewal email sent!');
        return redirect()->back();

    }
}
