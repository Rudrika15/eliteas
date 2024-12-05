<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ibm(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        if (!$startDate && !$endDate) {
            $ibms = collect();
        } else {

            $query = CircleCall::with('member')
                ->where('status', 'active');

            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('created_at', '<=', $endDate);
            }

            $ibms = $query->get()
                ->groupBy('memberId')
                ->map(function ($group) {
                    $member = $group->first()->member;
                    return [
                        'memberId' => $member->id,
                        'memberName' => $member->firstName . ' ' . $member->lastName,
                        'member_count' => $group->count(),
                    ];
                })
                ->sortByDesc('member_count')
                ->values();
        }

        return view('admin.report.ibm', compact('ibms'));
    }

    public function reference(Request $request)
{
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    if (!$startDate && !$endDate) {
        $refrences = collect();
    } else {
        $query = CircleMeetingMembersReference::with('refGiverName')
            ->where('status', 'Active');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        $refrences = $query->get()
            ->groupBy('referenceGiverId')
            ->map(function ($group) {
                $giver = $group->first()->refGiverName;
                return [
                    'referenceGiverId' => $giver->id,
                    'referenceGiverName' => $giver->firstName . ' ' . $giver->lastName,
                    'reference_count' => $group->count(),
                ];
            })
            ->sortByDesc('reference_count')
            ->values();
    }

    return view('admin.report.reference', compact('refrences'));
}


public function business(Request $request)
{
    $startDate = $request->input('startDate');
    $endDate = $request->input('endDate');

    if (!$startDate && !$endDate) {
        $business = collect();
    } else {
        $query = CircleMeetingMembersBusiness::with('businessGiver')
            ->where('status', 'Active');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        $business = $query->get()
            ->groupBy('businessGiverId')
            ->map(function ($group) {
                $giver = $group->first()->businessGiver;
                return [
                    'businessGiverId' => $giver->id,
                    'businessGiver' => $giver->firstName . ' ' . $giver->lastName,
                    'business_count' => $group->count(),
                    'total_amount' => $group->sum('amount'),
                ];
            })
            ->sortByDesc('total_amount')
            ->values();
    }


    return view('admin.report.business', compact('business'));
}

}

