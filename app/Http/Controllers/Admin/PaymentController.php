<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\User;
use Razorpay\Api\Api;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Razorpay;
use App\Utils\ErrorLogger;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Mail\MembershipRenewed;
use App\Mail\WelcomeMemberEmail;
use App\Models\TrainingRegister;
use App\Models\MeetingInvitation;
use App\Models\MemberSubscriptions;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate the request inputs
            $request->validate([
                // 'paymentId' => 'required|string',
                // 'amount' => 'required|numeric',
                // 'trainingId' => 'required|integer',
                // 'trainerId' => 'required|integer',
                // 'date' => 'required|date',
            ]);

            // Store the payment ID in the table
            $payment = new Razorpay();
            $payment->r_payment_id = $request->input('paymentId');
            $payment->user_email = Auth::user()->email;
            $payment->amount = $request->input('amount') / 100;
            $payment->save();

            // Register for the training
            $register = new TrainingRegister();
            $register->userId = Auth::user()->id;
            $register->trainingId = $request->input('trainingId');
            $register->trainerId = $request->input('trainerId');
            $register->save();

            // Store the payment details
            $allPayments = new AllPayments();
            $allPayments->memberId = $register->userId;
            $allPayments->amount = $payment->amount;
            $allPayments->paymentType = 'RazorPay'; // Hardcoded for RazorPay
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Training Register';
            $allPayments->remarks = $payment->r_payment_id;
            $allPayments->save();

            // Return a success response
            return response()->json(['message' => 'Payment ID stored successfully'], 200);
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Return an error response
            return response()->json(['message' => 'Failed to store payment ID'], 500);
        }
    }


    public function invitePayment(Request $request)
    {
        try {
            // Validate the request inputs
            $request->validate([
                'paymentId' => 'required|string',
                'email' => 'required|email',
                'amount' => 'required|numeric',
            ]);

            // Store the payment information
            $payment = new Razorpay();
            $payment->r_payment_id = $request->input('paymentId');
            $payment->user_email = $request->input('email');
            $payment->amount = $request->input('amount') / 100;
            $payment->save();

            // Update the meeting invitation status
            $invitation = MeetingInvitation::where('email', $request->input('email'))->first();
            if ($invitation) {
                $invitation->paymentStatus = 'Accepted';
                $invitation->save();
            } else {
                return redirect("/")->with("error", "Invitation not found for the provided email");
            }

            // Clear session data
            session()->forget('data');

            // Redirect with success message
            return redirect("/")->with("success", "Payment done");

            // Optionally, return JSON response
            // return response()->json(['message' => 'Payment done'], 200);

        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());

            // Redirect with error message
            return redirect("/")->with("error", "Failed to complete payment");
        }
    }


    public function membershipPayment(Request $request)
    {
        try {
            // Debugging: Log the incoming request data
            Log::info('Incoming request data:', $request->all());

            // Validate the request
            $request->validate([
                'paymentId' => 'required|string',
                'email' => 'required|email',
                'amount' => 'required|numeric',
            ]);

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
            $subscription = MemberSubscriptions::firstOrNew(['userId' => $user->id]);
            $subscription->userId = $user->id;
            $subscription->paymentId = $payment->r_payment_id;

            // Get the member
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                if ($member->membershipType == 'Supreme - Yearly') {
                    $subscription->validity = now()->addYear()->format('Y-m-d');
                } elseif ($member->membershipType == 'Prestige Lifetime') {
                    $subscription->validity = Carbon::now()->addYears(5)->format('Y-m-d');
                }

                $subscription->membershipType = $member->membershipType;
                $subscription->status = 'Active';
                $subscription->save();

                // Debugging: Confirm MemberSubscription save
                Log::info('Member subscription saved:', $subscription->toArray());
            } else {
                Log::error('Member not found for user ID:', ['userId' => $user->id]);
                return response()->json(['error' => 'Member not found'], 404);
            }

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
            $contactNo = $user->contactNo;
            Mail::to($user->email)->send(new WelcomeMemberEmail($user, $contactNo));

            return response()->json(['success' => true, 'message' => 'Payment processed successfully']);
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Debugging: Log the exception
            Log::error('Error processing payment:', ['error' => $th->getMessage()]);

            return response()->json(['error' => 'Failed to process payment'], 500);
        }
    }



    public function allPayments()
    {
        try {
            // Fetch paginated results
            $payments = AllPayments::where('status', 'Active')
                ->paginate(10);

            // Transform amounts after pagination
            $payments->getCollection()->transform(function ($payment) {
                $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
                return $payment;
            });

            return view('admin.paymentHistory.index', compact('payments'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }



    public function circleAdminPaymentHistory()
    {
        try {
            $user = auth()->user();
            $circleId = $user->member->circle->id;
            $circleMembers = Member::where('circleId', $circleId)->pluck('userId')->toArray();

            // Fetch paginated results
            $payments = AllPayments::where('status', 'Active')
                ->whereIn('memberId', $circleMembers)
                ->paginate(10);

            // Transform amounts after pagination
            foreach ($payments as $payment) {
                $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
            }

            return view('admin.paymentHistory.circleAdminPaymentHistory', compact('payments'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function myAllPayments()
    {
        try {
            // Fetch paginated results
            $myAllPayments = AllPayments::where('status', 'Active')
                ->where('memberId', auth()->id())

                ->paginate(10);

            // Transform amounts after pagination
            foreach ($myAllPayments as $payment) {
                $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
            }

            return view('admin.paymentHistory.userIndex', compact('myAllPayments'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }



    public function pendingPayments()
    {
        try {
            // Fetch pending payments from the database
            // $pendingPayments = Payment::where('status', 'Pending')->get();

            // Return the view with pending payments data
            return view('pendingPayments', compact('pendingPayments'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Optionally, you can return a view or response indicating an error
            return view('servererror');
        }
    }



    public function renewMembership($userId)
    {
        try {
            // Find the user by ID
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['message' => 'User not found!'], 404);
            }

            // Add your logic to renew the membership here
            // Example: extend membership validity by one year
            $subscription = MemberSubscriptions::where('userId', $userId)->first();

            if ($subscription) {
                if ($subscription->membershipType == 'Supreme - Yearly') {
                    $subscription->validity = now()->addYear()->format('Y-m-d');
                } elseif ($subscription->membershipType == 'Prestige Lifetime') {
                    $subscription->validity = now()->addYears(5)->format('Y-m-d');
                }
                $subscription->save();
            } else {
                return response()->json(['message' => 'Subscription not found!'], 404);
            }

            // Send an email to the user
            Mail::to($user->email)->send(new MembershipRenewed($user));

            session()->flash('success', 'Membership renewal email sent!');
            return redirect()->back();
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return an error response or redirect
            return response()->json(['message' => 'Failed to renew membership'], 500);
        }
    }
}
