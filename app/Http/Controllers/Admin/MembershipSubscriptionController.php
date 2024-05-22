<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\membershipType;
use App\Http\Controllers\Controller;
use App\Models\MemberSubscriptions;

class MembershipSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $subscriptions = MemberSubscriptions::where('userId', $userId)->where('status', 'Active')->get();
            return view('admin.mysubscriptions.index', compact('subscriptions', 'userId'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    
    public function memberData(Request $request)
    {
        try {
            $allSubscriptions = MemberSubscriptions::where('status', 'Active')->get();
            return view('admin.mysubscriptions.adminIndex', compact('allSubscriptions'));
        } catch (\Throwable $th) {
            throw $th;
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


}

