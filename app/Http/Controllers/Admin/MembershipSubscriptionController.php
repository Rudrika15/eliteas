<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\membershipType;
use App\Http\Controllers\Controller;
use App\Models\MemberSubscription;

class MembershipSubscriptionController extends Controller
{
    public function index(Request $request)
    {
        try {
            $userId = $request->user()->id;
            $subscriptions = MemberSubscription::where('userId', $userId)->where('status', 'Active')->get();
            return view('admin.mysubscriptions.index', compact('subscriptions', 'userId'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
