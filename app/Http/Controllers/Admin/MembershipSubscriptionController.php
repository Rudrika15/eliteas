<?php

namespace App\Http\Controllers\Admin;

use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\MembershipType;
use App\Models\MemberSubscriptions;
use App\Exports\SubscriptionsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class MembershipSubscriptionController extends Controller
{


    // public function __construct()
    // {
    //     // Apply middleware for event-related permissions
    //     $this->middleware('permission:member-subscription-index', ['only' => ['index']]);
    //     $this->middleware('permission:member-subscription-member-data', ['only' => ['memberData']]);
    //     $this->middleware('permission:member-subscription-export', ['only' => ['exportSubscriptions']]);
    // }


    public function index(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $subscriptions = MemberSubscriptions::where('userId', $userId)
                ->where('status', 'Active')
                ->with('allPayments') // Ensure allPayments relationship is loaded
                ->paginate(10);

            // Format the amounts for allPayments relationship
            foreach ($subscriptions as $subscription) {
                if ($subscription->allPayments instanceof \Illuminate\Support\Collection) {
                    $subscription->allPayments->transform(function ($payment) {
                        $payment->amount = isset($payment->amount) ? number_format($payment->amount, 2) : '-';
                        return $payment;
                    });
                }
            }

            return view('admin.mysubscriptions.index', compact('subscriptions', 'userId'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }




    public function memberData(Request $request)
    {
        try {
            $membershipType = membershipType::where('status', 'Active')->get();
            $allSubscriptions = MemberSubscriptions::where('status', 'Active')->paginate(10);
            return view('admin.mysubscriptions.adminIndex', compact('allSubscriptions', 'membershipType'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    // public function checkMembershipValidity()
    // {
    //     try {
    //         $today = date('Y-m-d');
    //         $subscriptions = MemberSubscriptions::where('status', 'Active')->get();
    //         foreach ($subscriptions as $subscription) {
    //             $endDate = date('Y-m-d', strtotime($subscription->endDate));
    //             if (strtotime($endDate, time()) < strtotime($today)) {
    //                 $subscription->status = 'Expired';
    //                 $subscription->save();
    //             }
    //         }
    //     } catch (\Throwable $th) {
    //         throw $th;
    //         return view('servererror');
    //     }
    // }


    public function exportSubscriptions(Request $request)
    {
        try {
            $membershipType = $request->input('membershipType');
            return Excel::download(new SubscriptionsExport($membershipType), 'subscriptions.xlsx');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->back()->with('error', 'Failed to export subscriptions');
        }
    }
}
