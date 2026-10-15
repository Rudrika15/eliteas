<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\DuePayment;
use App\Models\Member;
use App\Models\Razorpay;
use App\Models\AllPayments;
use App\Models\User;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class DuePaymentController extends Controller
{
    /**
     * Display a listing of due payments from the dedicated due_payments table.
     */
    public function index(Request $request)
    {
        try {
            // Fetch all active circles for filter and modal dropdowns
            $circles = Circle::where('status', 'Active')
                ->orderBy('circleName', 'asc')
                ->get();

            // Fetch records from dedicated due_payments table
            $duePayments = DuePayment::with(['member.circle'])
                ->orderBy('id', 'desc')
                ->get();

            $subscriptions = [];

            foreach ($duePayments as $dp) {
                $member = $dp->member;
                $circleName = $dp->circle_name ?: ($member && $member->circle ? $member->circle->circleName : 'Digital Member');
                $memberName = $member ? trim("{$member->firstName} {$member->lastName}") : ('Member #' . $dp->member_id);
                $companyName = $member ? ($member->companyName ?? '') : '';

                $first = $member ? trim($member->firstName ?? '') : 'D';
                $last = $member ? trim($member->lastName ?? '') : 'P';
                $initials = strtoupper(substr($first, 0, 1) . substr($last, 0, 1)) ?: 'DP';

                $subscriptions[] = [
                    'id' => $dp->id,
                    'circle_name' => $circleName,
                    'member_name' => $memberName,
                    'company_name' => $companyName,
                    'user_id' => $dp->userId ?: ($dp->user_id ?: ($member ? $member->userId : null)),
                    'userId' => $dp->userId ?: ($dp->user_id ?: ($member ? $member->userId : null)),
                    'initials' => $initials,
                    'payment_type' => $dp->payment_type ?: 'Due Payment',
                    'amount' => (float) $dp->amount,
                    'status' => $dp->status ?: 'Active',
                    'date' => $dp->date,
                ];
            }

            // Return JSON response if requested via API
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'circles' => $circles,
                    'due_payments' => $subscriptions,
                ]);
            }

            return view('admin.duePayment.index', compact('circles', 'subscriptions'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
            }
            return view('servererror');
        }
    }

    /**
     * Get dynamic list of members for a specific circle or Digital Member (AJAX/API).
     */
    public function getMembersByCircle($circleId)
    {
        try {
            if ($circleId === 'digital_member' || $circleId === 'digital' || $circleId === '0') {
                $members = Member::where('status', '!=', 'Deleted')
                    ->where(function ($q) {
                        $q->whereNull('circleId')
                          ->orWhere('circleId', 0)
                          ->orWhere('membershipType', 'Digital Membership');
                    })
                    ->orderBy('firstName', 'asc')
                    ->get();
            } else {
                $members = Member::where('circleId', $circleId)
                    ->where('status', '!=', 'Deleted')
                    ->orderBy('firstName', 'asc')
                    ->get();
            }

            $formatted = $members->map(function ($m) {
                $first = trim($m->firstName ?? '');
                $last = trim($m->lastName ?? '');
                $initials = strtoupper(substr($first, 0, 1) . substr($last, 0, 1)) ?: 'MB';

                return [
                    'id' => $m->id,
                    'userId' => $m->userId,
                    'name' => trim("$first $last") ?: ('Member #' . $m->id),
                    'company' => $m->companyName ?? '',
                    'initials' => $initials,
                ];
            });

            return response()->json([
                'success' => true,
                'members' => $formatted,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch members: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created due payment into the dedicated due_payments table (AJAX/API).
     */
    public function store(Request $request)
    {
        $request->validate([
            'circle_id' => 'required',
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:1',
            'payment_type' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
            'payment_date' => 'nullable|date',
        ]);

        try {
            $member = Member::with('circle')->findOrFail($request->member_id);

            if ($request->circle_id === 'digital_member' || empty($member->circleId) || $member->membershipType === 'Digital Membership') {
                $circleName = 'Digital Member';
                $circleId = 'digital_member';
            } else {
                $circleName = $member->circle ? $member->circle->circleName : 'Digital Member';
                $circleId = (string) ($member->circleId ?: $request->circle_id);
            }

            $paymentType = $request->payment_type ?: 'Due Payment';

            // Create entry in dedicated due_payments table
            $duePayment = new DuePayment();
            $duePayment->circle_id = $circleId;
            $duePayment->circle_name = $circleName;
            $duePayment->member_id = $member->id;
            $duePayment->userId = $member->userId ?: null;
            $duePayment->payment_type = $paymentType;
            $duePayment->amount = $request->amount;
            $duePayment->status = $request->status ?: 'Active';
            $duePayment->date = $request->payment_date ?: now()->format('Y-m-d');
            $duePayment->save();

            $first = trim($member->firstName ?? '');
            $last = trim($member->lastName ?? '');
            $initials = strtoupper(substr($first, 0, 1) . substr($last, 0, 1)) ?: 'MB';

            return response()->json([
                'success' => true,
                'message' => "Due Payment for {$member->firstName} added successfully!",
                'data' => [
                    'id' => $duePayment->id,
                    'circle_name' => $circleName,
                    'member_name' => trim("$first $last"),
                    'company_name' => $member->companyName ?? '',
                    'user_id' => $duePayment->user_id ?: $duePayment->userId,
                    'userId' => $duePayment->userId ?: $duePayment->user_id,
                    'initials' => $initials,
                    'payment_type' => $duePayment->payment_type,
                    'amount' => (float) $duePayment->amount,
                    'formatted_amount' => number_format($duePayment->amount, 0),
                    'status' => $duePayment->status,
                    'date' => $duePayment->date,
                ],
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add due payment: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Show edit data for a due payment (AJAX/API).
     */
    public function edit($id)
    {
        try {
            $duePayment = DuePayment::with('member')->findOrFail($id);
            $member = $duePayment->member;

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $duePayment->id,
                    'circle_id' => $duePayment->circle_id,
                    'circle_name' => $duePayment->circle_name,
                    'member_id' => $duePayment->member_id,
                    'member_name' => $member ? trim("{$member->firstName} {$member->lastName}") : '',
                    'userId' => $duePayment->userId ?: ($member ? $member->userId : null),
                    'payment_type' => $duePayment->payment_type,
                    'amount' => (float) $duePayment->amount,
                    'status' => $duePayment->status,
                    'date' => $duePayment->date,
                ],
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Due payment not found: ' . $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Update an existing due payment record (AJAX/API).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'status' => 'required|in:Active,Inactive,Paid',
            'circle_id' => 'nullable',
            'member_id' => 'nullable|exists:members,id',
            'payment_type' => 'nullable|string',
            'payment_date' => 'nullable|date',
        ]);

        try {
            $duePayment = DuePayment::findOrFail($id);

            if ($request->filled('member_id') && $request->member_id != $duePayment->member_id) {
                $member = Member::with('circle')->findOrFail($request->member_id);
                $duePayment->member_id = $member->id;
                $duePayment->userId = $member->userId ?: null;

                if ($request->circle_id === 'digital_member' || empty($member->circleId) || $member->membershipType === 'Digital Membership') {
                    $duePayment->circle_name = 'Digital Member';
                    $duePayment->circle_id = 'digital_member';
                } else {
                    $duePayment->circle_name = $member->circle ? $member->circle->circleName : 'Digital Member';
                    $duePayment->circle_id = (string) ($member->circleId ?: $request->circle_id);
                }
            } elseif ($request->filled('circle_id')) {
                if ($request->circle_id === 'digital_member') {
                    $duePayment->circle_name = 'Digital Member';
                    $duePayment->circle_id = 'digital_member';
                } else {
                    $circle = Circle::find($request->circle_id);
                    if ($circle) {
                        $duePayment->circle_name = $circle->circleName;
                        $duePayment->circle_id = (string) $circle->id;
                    }
                }
            }

            if ($request->filled('payment_type')) {
                $duePayment->payment_type = $request->payment_type;
            }
            $duePayment->amount = $request->amount;
            $duePayment->status = $request->status;
            if ($request->filled('payment_date')) {
                $duePayment->date = $request->payment_date;
            }
            $duePayment->save();

            $member = $duePayment->member;
            $first = $member ? trim($member->firstName ?? '') : 'M';
            $last = $member ? trim($member->lastName ?? '') : '';
            $initials = strtoupper(substr($first, 0, 1) . substr($last, 0, 1)) ?: 'DP';

            return response()->json([
                'success' => true,
                'message' => 'Due payment updated successfully!',
                'data' => [
                    'id' => $duePayment->id,
                    'circle_name' => $duePayment->circle_name,
                    'member_name' => $member ? trim("$first $last") : ('Member #' . $duePayment->member_id),
                    'user_id' => $duePayment->userId,
                    'userId' => $duePayment->userId,
                    'initials' => $initials,
                    'payment_type' => $duePayment->payment_type,
                    'amount' => (float) $duePayment->amount,
                    'formatted_amount' => number_format($duePayment->amount, 0),
                    'status' => $duePayment->status,
                    'date' => $duePayment->date,
                ],
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update due payment: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove a due payment entry from due_payments table (AJAX/API).
     */
    public function destroy($id)
    {
        try {
            $duePayment = DuePayment::findOrFail($id);
            $duePayment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Due payment entry has been removed successfully.',
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete due payment: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Process Razorpay payment for an active Due Payment (AJAX/API).
     */
    public function payDuePayment(Request $request)
    {
        $request->validate([
            'paymentId' => 'required|string',
            'amount' => 'required|numeric|min:1',
            'due_payment_id' => 'nullable',
        ]);

        try {
            $user = auth()->user();
            if (!$user && $request->due_payment_id) {
                $dp = DuePayment::find($request->due_payment_id);
                if ($dp && $dp->userId) {
                    $user = User::find($dp->userId);
                } elseif ($dp && $dp->member_id) {
                    $m = Member::find($dp->member_id);
                    if ($m && $m->userId) {
                        $user = User::find($m->userId);
                    }
                }
            }

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized or session expired. Please refresh and try again.'], 401);
            }

            // Find the due payment
            $duePayment = null;
            if ($request->due_payment_id) {
                $duePayment = DuePayment::find($request->due_payment_id);
            }

            if (!$duePayment) {
                $member = Member::where('userId', $user->id)->first();
                $duePayment = DuePayment::where('status', 'Active')
                    ->where(function ($q) use ($user, $member) {
                        $q->where('userId', $user->id);
                        if ($member) {
                            $q->orWhere('member_id', $member->id);
                        }
                    })
                    ->latest()
                    ->first();
            }

            if (!$duePayment) {
                // Check if it was already marked as Paid
                if ($request->due_payment_id) {
                    $paidDp = DuePayment::where('id', $request->due_payment_id)->where('status', 'Paid')->first();
                    if ($paidDp) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Payment already verified and cleared!',
                        ]);
                    }
                }
                return response()->json(['success' => false, 'message' => 'Active due payment record not found.'], 404);
            }

            // Record in Razorpay table
            $razorpay = new Razorpay();
            $razorpay->r_payment_id = $request->paymentId;
            $razorpay->user_email = $user->email ?? 'noreply@ubn.org';
            $razorpay->amount = (float) $request->amount;
            $razorpay->save();

            // Mark DuePayment status as Paid
            $duePayment->status = 'Paid';
            $duePayment->save();

            // Record in AllPayments table
            $allPayments = new AllPayments();
            $allPayments->memberId = $duePayment->member_id ?: ($user->member ? $user->member->id : 0);
            $allPayments->amount = $duePayment->amount;
            $allPayments->paymentType = 'RazorPay';
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Due Payment';
            $allPayments->remarks = $request->paymentId;
            $allPayments->save();

            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'Due payment of ₹ ' . number_format($duePayment->amount, 0) . ' completed successfully!',
                'data' => [
                    'due_payment_id' => $duePayment->id,
                    'payment_id' => $request->paymentId,
                    'amount' => (float) $duePayment->amount,
                    'status' => $duePayment->status,
                ],
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Payment processing failed: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Get active due payment details for the authenticated user/member (API/Frontend).
     */
    public function getActiveDuePayment(Request $request)
    {
        try {
            $user = auth()->user();
            if (!$user && $request->filled('user_id')) {
                $user = User::find($request->user_id);
            }

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'success' => false,
                    'message' => 'Unauthorized user.',
                ], 401);
            }

            // Admin users do not have due payment blocking
            if (method_exists($user, 'hasRole') && $user->hasRole('Admin')) {
                return response()->json([
                    'status' => true,
                    'success' => true,
                    'has_due_payment' => false,
                    'message' => 'Admin user has no due payment restrictions.',
                    'data' => null,
                ]);
            }

            $member = Member::with('circle')->where('userId', $user->id)->first();

            $activeDuePayment = DuePayment::where('status', 'Active')
                ->where(function ($q) use ($user, $member) {
                    $q->where('userId', $user->id);
                    if ($member) {
                        $q->orWhere('member_id', $member->id);
                    }
                })
                ->latest()
                ->first();

            if (!$activeDuePayment) {
                return response()->json([
                    'status' => true,
                    'success' => true,
                    'has_due_payment' => false,
                    'message' => 'No active due payment found.',
                    'data' => null,
                ]);
            }

            $circleName = $activeDuePayment->circle_name ?: ($member && $member->circle ? $member->circle->circleName : 'Digital Member');
            $memberName = $member ? trim("{$member->firstName} {$member->lastName}") : trim("{$user->firstName} {$user->lastName}");

            $adminUser = User::role('Admin')->first();

            return response()->json([
                'status' => true,
                'success' => true,
                'has_due_payment' => true,
                'message' => 'Active due payment retrieved successfully.',
                'data' => [
                    'due_payment_id' => $activeDuePayment->id,
                    'id' => $activeDuePayment->id,
                    'member_id' => $activeDuePayment->member_id,
                    'user_id' => $activeDuePayment->userId ?: $user->id,
                    'member_name' => $memberName ?: 'Member',
                    'circle_name' => $circleName,
                    'payment_type' => $activeDuePayment->payment_type ?? 'Due Payment',
                    'description' => $activeDuePayment->payment_type ?? 'Due Payment',
                    'amount' => (float) $activeDuePayment->amount,
                    'formatted_amount' => '₹ ' . number_format($activeDuePayment->amount, 0),
                    'amount_in_paise' => (int) round($activeDuePayment->amount * 100),
                    'status' => $activeDuePayment->status,
                    'payment_date' => $activeDuePayment->date,
                    'razorpay_key' => env('RAZORPAY_KEY'),
                    'currency' => 'INR',
                    'admin_contact' => [
                        'name' => $adminUser ? trim("{$adminUser->firstName} {$adminUser->lastName}") : 'UBN Admin',
                        'email' => $adminUser->email ?? 'admin@ubn.org',
                        'phone' => $adminUser->contactNo ?? ($adminUser->phone ?? '+91 98765 43210'),
                    ],
                ],
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => 'Failed to fetch active due payment: ' . $th->getMessage(),
            ], 500);
        }
    }
}
