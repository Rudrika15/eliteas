<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MemberReportExport;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    // public function ibm(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     if (!$startDate && !$endDate) {
    //         $ibms = collect();
    //     } else {

    //         $query = CircleCall::with('member')
    //             ->where('status', 'active');

    //         if ($startDate) {
    //             $query->where('created_at', '>=', $startDate);
    //         }
    //         if ($endDate) {
    //             $query->where('created_at', '<=', $endDate);
    //         }

    //         $ibms = $query->get()
    //             ->groupBy('memberId')
    //             ->map(function ($group) {
    //                 $member = $group->first()->member;
    //                 return [
    //                     'memberId' => $member->id,
    //                     'memberName' => $member->firstName . ' ' . $member->lastName,
    //                     'member_count' => $group->count(),
    //                 ];
    //             })
    //             ->sortByDesc('member_count')
    //             ->values();
    //     }

    //     return view('admin.report.ibm', compact('ibms'));
    // }


    public function ibm(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $circleId = $request->input('circleId');

        // Fetch all circles for the dropdown
        $circles = Circle::where('status', 'Active')->select('id', 'circleName')->get();

        if (!$startDate && !$endDate && !$circleId) {
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

            if ($circleId) {
                $query->whereHas('member', function ($q) use ($circleId) {
                    $q->where('circleId', $circleId);
                });
            }

            $ibms = $query->get()
                ->groupBy('memberId')
                ->map(function ($group) {
                    $member = $group->first()->member;
                    return [
                        'memberId' => $member->id,
                        'memberName' => $member->firstName . ' ' . $member->lastName,
                        'circleName' => $member->circle->circleName,
                        'member_count' => $group->count(),
                    ];
                })
                ->sortByDesc('member_count')
                ->values();
        }

        return view('admin.report.ibm', compact('ibms', 'circles'));
    }



    // public function reference(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     if (!$startDate && !$endDate) {
    //         $refrences = collect();
    //     } else {
    //         $query = CircleMeetingMembersReference::with('refGiver')
    //             ->where('status', 'Active');

    //         if ($startDate) {
    //             $query->where('created_at', '>=', $startDate);
    //         }
    //         if ($endDate) {
    //             $query->where('created_at', '<=', $endDate);
    //         }

    //         $refrences = $query->get()
    //             ->groupBy('referenceGiverId')
    //             ->map(function ($group) {
    //                 $giver = $group->first()->refGiverName;
    //                 return [
    //                     'referenceGiverId' => $giver->id,
    //                     'referenceGiverName' => $giver->firstName . ' ' . $giver->lastName,
    //                     'reference_count' => $group->count(),
    //                 ];
    //             })
    //             ->sortByDesc('reference_count')
    //             ->values();
    //     }

    //     return view('admin.report.reference', compact('refrences'));
    // }


    public function reference(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $circleId = $request->input('circleId');

        // Fetch all circles for the dropdown
        // $circles = Circle::select('id', 'circleName')->get();
        $circles = Circle::where('status', 'Active')->select('id', 'circleName')->get();


        if (!$startDate && !$endDate && !$circleId) {
            $refrences = collect();
        } else {
            $query = CircleMeetingMembersReference::with('refGiver')
                ->where('status', 'Active');

            if ($startDate) {
                $query->where('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->where('created_at', '<=', $endDate);
            }

            if ($circleId) {
                $query->whereHas('refGiver', function ($q) use ($circleId) {
                    $q->where('circleId', $circleId);
                });
            }

            $refrences = $query->get()
                ->groupBy('referenceGiverId')
                ->map(function ($group) {
                    $giver = $group->first()->refGiver;
                    return [
                        'referenceGiverId' => $giver->userId,
                        'referenceGiverName' => $giver->firstName . ' ' . $giver->lastName,
                        'reference_count' => $group->count(),
                    ];
                })
                ->sortByDesc('reference_count')
                ->values();
        }

        return view('admin.report.reference', compact('refrences', 'circles'));
    }






    // public function business(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');

    //     if (!$startDate && !$endDate) {
    //         $business = collect();
    //     } else {
    //         $query = CircleMeetingMembersBusiness::with('businessGiver')
    //             ->where('status', 'Active');

    //         if ($startDate) {
    //             $query->where('created_at', '>=', $startDate);
    //         }
    //         if ($endDate) {
    //             $query->where('created_at', '<=', $endDate);
    //         }

    //         $business = $query->get()
    //             ->groupBy('businessGiverId')
    //             ->map(function ($group) {
    //                 $giver = $group->first()->businessGiver;
    //                 return [
    //                     'businessGiverId' => $giver->id,
    //                     'businessGiver' => $giver->firstName . ' ' . $giver->lastName,
    //                     'business_count' => $group->count(),
    //                     'total_amount' => $group->sum('amount'),
    //                 ];
    //             })
    //             ->sortByDesc('total_amount')
    //             ->values();
    //     }


    //     return view('admin.report.business', compact('business'));
    // }


    public function business(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $circleId = $request->input('circleId');

        // Fetch all circles for the dropdown
        // $circles = Circle::select('id', 'circleName')->get();
        $circles = Circle::where('status', 'Active')->select('id', 'circleName')->get();


        if (!$startDate && !$endDate && !$circleId) {
            $business = collect();
        } else {
            $query = CircleMeetingMembersBusiness::with('member')
                ->where('status', 'Active');

            if ($startDate) {
                $query->whereRaw('DATE(created_at) >= ?', [$startDate]);
            }
            if ($endDate) {
                $query->whereRaw('DATE(created_at) <= ?', [$endDate]);
            }
            if ($circleId) {
                $query->whereHas('member', function ($q) use ($circleId) {
                    $q->where('circleId', $circleId);
                });
            }


            $business = $query->get()
                ->groupBy('businessGiverId')
                ->map(function ($group) {
                    $giver = $group->first()->member;
                    return [
                        'businessGiverId' => $giver->userId,
                        'member' => $giver->firstName . ' ' . $giver->lastName,
                        'business_count' => $group->count(),
                        'total_amount' => $group->sum('amount'),
                    ];
                })
                ->sortByDesc('total_amount')
                ->values();
        }

        return view('admin.report.business', compact('business', 'circles'));
    }



    // public function getJoiningMembers(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');
    //     $circleId = $request->input('circleId');

    //     $circles = Circle::where('status', 'Active')->pluck('circleName', 'id');

    //     $query = Member::query()->where('status', 'Active');

    //     if ($circleId) {
    //         $query->where('circleId', $circleId);
    //     }

    //     if ($startDate) {
    //         $query->where('created_at', '>=', $startDate);
    //     }

    //     if ($endDate) {
    //         $query->where('created_at', '<=', $endDate);
    //     }

    //     // Fetch data
    //     $members = $query->get()
    //         ->groupBy('circleId')
    //         ->map(function ($group) {
    //             $circle = $group->first()->circle;
    //             return [
    //                 'circleId' => $circle->id,
    //                 'circleName' => $circle->circleName,
    //                 'member_count' => $group->count(),
    //             ];
    //         })
    //         ->sortByDesc('member_count')
    //         ->values();

    //     return view('admin.report.joining', compact('members', 'circles'));
    // }


    public function getJoiningMembers(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $circleId = $request->input('circleId');

        // Fetch all active circles
        $circles = Circle::where('status', 'Active')->pluck('circleName', 'id');

        // Base query for active members
        $query = Member::query()->where('status', 'Active');

        // Apply circle filter if provided
        if ($circleId) {
            $query->where('circleId', $circleId);
        }

        // Apply date filters if provided
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        // Fetch data, group by circle, and count members
        $members = $query->with('circle') // Eager load circle relationship
            ->get()
            ->groupBy('circleId')
            ->map(function ($group) {
                $circle = $group->first()->circle;
                return [
                    'circleName' => $circle->circleName, // Use circle name here
                    'member_count' => $group->count(),
                ];
            })
            ->sortByDesc('member_count') // Sort by member count
            ->values(); // Reset keys

        return view('admin.report.joining', compact('members', 'circles'));
    }

    // public function memberWiseReport(Request $request)
    // {
    //     $circle = Circle::where('status', 'Active')->get();
    //     $member = Member::where('status', 'Active')->get();

    //     $selectedMemberId = $request->input('memberId');
    //     // $selectedMemberId = 8;

    //     $business = collect();
    //     $reference = collect();
    //     $circleCall = collect();

    //     $totalBusinessAmount = 0;
    //     $totalIbmCount = 0;
    //     $totalReferenceCount = 0;

    //     $selectedMember = null;
    //     if ($selectedMemberId) {
    //         $selectedMember = Member::where('userId', $selectedMemberId)->first();
    //     }


    //     if ($selectedMemberId) {
    //         $circleCall = CircleCall::where('status', 'Active')
    //             ->where('memberId', $selectedMemberId)
    //             ->get();

    //         $business = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->where('businessGiverId', $selectedMemberId)
    //             ->get();

    //         $reference = CircleMeetingMembersReference::where('status', 'Active')
    //             ->where('referenceGiverId', $selectedMemberId)
    //             ->get();

    //         // ✅ Calculate Totals
    //         $totalBusinessAmount = $business->sum('amount');
    //         $totalIbmCount = $circleCall->count();
    //         $totalReferenceCount = $reference->count();
    //     }

    //     return view('admin.report.memberReport', compact('circle', 'member', 'business', 'reference', 'circleCall', 'selectedMemberId', 'totalBusinessAmount', 'totalIbmCount', 'totalReferenceCount', 'selectedMember'));
    // }


    // public function memberWiseReport(Request $request)
    // {
    //     $circle = Circle::where('status', 'Active')->get();
    //     $member = Member::where('status', 'Active')->get();

    //     $selectedMemberId = $request->input('memberId');
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     $business = collect();
    //     $reference = collect();
    //     $circleCall = collect();

    //     $totalBusinessAmount = 0;
    //     $totalIbmCount = 0;
    //     $totalReferenceCount = 0;

    //     $selectedMember = null;
    //     if ($selectedMemberId) {
    //         $selectedMember = Member::where('userId', $selectedMemberId)->first();
    //     }

    //     if ($selectedMemberId) {
    //         $circleCall = CircleCall::with(['meetingPersonReport:id,firstName,lastName'])
    //             ->where('status', 'Active')
    //             ->where('memberId', $selectedMemberId);

    //         $business = CircleMeetingMembersBusiness::with(['loginMember:id,firstName,lastName'])
    //             ->where('status', 'Active')
    //             ->where('businessGiverId', $selectedMemberId);

    //         $reference = CircleMeetingMembersReference::with(['refGiverName:id,firstName,lastName'])
    //             ->where('status', 'Active')
    //             ->where('referenceGiverId', $selectedMemberId);

    //         if ($startDate) {
    //             $circleCall->whereDate('created_at', '>=', $startDate);
    //             $business->whereDate('created_at', '>=', $startDate);
    //             $reference->whereDate('created_at', '>=', $startDate);
    //         }

    //         if ($endDate) {
    //             $circleCall->whereDate('created_at', '<=', $endDate);
    //             $business->whereDate('created_at', '<=', $endDate);
    //             $reference->whereDate('created_at', '<=', $endDate);
    //         }

    //         $circleCall = $circleCall->get();
    //         $business = $business->get();
    //         $reference = $reference->get();

    //         $totalBusinessAmount = $business->sum('amount');
    //         $totalIbmCount = $circleCall->count();
    //         $totalReferenceCount = $reference->count();
    //     }

    //     return view('admin.report.memberReport', compact(
    //         'circle',
    //         'member',
    //         'business',
    //         'reference',
    //         'circleCall',
    //         'selectedMemberId',
    //         'selectedMember',
    //         'totalBusinessAmount',
    //         'totalIbmCount',
    //         'totalReferenceCount',
    //         'startDate',
    //         'endDate'
    //     ));
    // }


    public function memberWiseReport(Request $request)
    {
        $circle = Circle::where('status', 'Active')->get();
        $member = Member::where('status', 'Active')->get();

        $selectedMemberId = $request->input('memberId');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $business = collect();
        $reference = collect();
        $circleCall = collect();

        $totalBusinessAmount = 0;
        $totalIbmCount = 0;
        $totalReferenceCount = 0;

        $selectedMember = null;
        if ($selectedMemberId) {
            $selectedMember = Member::where('userId', $selectedMemberId)->first();
        }

        if ($selectedMemberId) {
            // IBM (Circle Calls)
            $circleCallQuery = CircleCall::with(['meetingPersonReport:id,firstName,lastName'])
                ->where('status', 'Active')
                ->where('memberId', $selectedMemberId);

            // Business
            $businessQuery = CircleMeetingMembersBusiness::with(['loginMember:id,firstName,lastName'])
                ->where('status', 'Active')
                ->where('businessGiverId', $selectedMemberId);

            // Reference
            $referenceQuery = CircleMeetingMembersReference::with(['refGiverName:id,firstName,lastName'])
                ->where('status', 'Active')
                ->where('referenceGiverId', $selectedMemberId);

            // Apply date filters

            if ($startDate) {
                $circleCallQuery->whereRaw('DATE(created_at) >= ?', [$startDate]);
                $businessQuery->whereRaw('DATE(created_at) >= ?', [$startDate]);
                $referenceQuery->whereRaw('DATE(created_at) >= ?', [$startDate]);
            }

            if ($endDate) {
                $circleCallQuery->whereRaw('DATE(created_at) <= ?', [$endDate]);
                $businessQuery->whereRaw('DATE(created_at) <= ?', [$endDate]);
                $referenceQuery->whereRaw('DATE(created_at) <= ?', [$endDate]);
            }


            // Execute queries
            $circleCall = $circleCallQuery->get();
            $business = $businessQuery->get();
            $reference = $referenceQuery->get();

            // Totals
            $totalBusinessAmount = $business->sum('amount');
            $totalIbmCount = $circleCall->count();
            $totalReferenceCount = $reference->count();
        }

        // Export to Excel if requested
        if ($request->has('export') && $selectedMember) {
            $memberName = Str::slug($selectedMember->firstName . ' ' . $selectedMember->lastName);
            $fileName = 'member_report_' . $memberName . '.xlsx';

            return Excel::download(new MemberReportExport($selectedMemberId, $startDate, $endDate), $fileName);
        }

        return view('admin.report.memberReport', compact(
            'circle',
            'member',
            'business',
            'reference',
            'circleCall',
            'selectedMemberId',
            'selectedMember',
            'totalBusinessAmount',
            'totalIbmCount',
            'totalReferenceCount',
            'startDate',
            'endDate'
        ));
    }
}
