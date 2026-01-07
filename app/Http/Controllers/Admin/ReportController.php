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
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Exports\CircleVPReportExport;

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


    // public function ibm(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');
    //     $circleId = $request->input('circleId');

    //     // Fetch all circles for the dropdown
    //     $circles = Circle::where('status', 'Active')->select('id', 'circleName')->get();

    //     if (!$startDate && !$endDate && !$circleId) {
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

    //         if ($circleId) {
    //             $query->whereHas('member', function ($q) use ($circleId) {
    //                 $q->where('circleId', $circleId);
    //             });
    //         }

    //         $ibms = $query->get()
    //             ->groupBy('memberId')
    //             ->map(function ($group) {
    //                 $member = $group->first()->member;
    //                 return [
    //                     'memberId' => $member->id,
    //                     'memberName' => $member->firstName . ' ' . $member->lastName,
    //                     'circleName' => $member->circle->circleName,
    //                     'member_count' => $group->count(),
    //                 ];
    //             })
    //             ->sortByDesc('member_count')
    //             ->values();
    //     }

    //     return view('admin.report.ibm', compact('ibms', 'circles'));
    // }


    public function ibm(Request $request)
{
    $startDate = $request->input('startDate');
    $endDate   = $request->input('endDate');
    $circleId  = $request->input('circleId');

    // Dropdown circles
    $circles = Circle::where('status', 'Active')
        ->select('id', 'circleName')
        ->get();

    if (!$startDate && !$endDate && !$circleId) {
        $ibms = collect();
    } else {

        $query = CircleCall::where('status', 'active');

        // Date filters
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Circle filter
        if ($circleId) {
            $query->where(function ($q) use ($circleId) {
                $q->whereHas('member', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                })->orWhereHas('meetingPerson', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                });
            });
        }

        $ibms = $query->get()
            ->flatMap(function ($item) {
                return [
                    ['member_id' => $item->memberId],
                    ['member_id' => $item->meetingPersonId],
                ];
            })
            ->groupBy('member_id')
            ->map(function ($group, $memberId) use ($circleId) {
                // memberId here is actually the User ID from CircleCall
                $member = Member::with('circle')->where('userId', $memberId)->first();

                if (!$member) {
                    return null;
                }

                if ($circleId && $member->circleId != $circleId) {
                    return null;
                }

                return [
                    'memberId'      => $member->id,
                    'memberName'    => $member->firstName . ' ' . $member->lastName,
                    'circleName'    => $member->circle->circleName ?? '',
                    'member_count'  => $group->count(),
                ];
            })

            // 🔹 CHANGE 4: remove null rows
            ->filter()

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


    // public function getJoiningMembers(Request $request)
    // {
    //     $startDate = $request->input('startDate');
    //     $endDate = $request->input('endDate');
    //     $circleId = $request->input('circleId');

    //     // Fetch all active circles
    //     $circles = Circle::where('status', 'Active')->pluck('circleName', 'id');

    //     // Base query for active members
    //     $query = Member::query()->where('status', 'Active');

    //     // Apply circle filter if provided
    //     if ($circleId) {
    //         $query->where('circleId', $circleId);
    //     }

    //     // Apply date filters if provided
    //     if ($startDate) {
    //         $query->where('created_at', '>=', $startDate);
    //     }

    //     if ($endDate) {
    //         $query->where('created_at', '<=', $endDate);
    //     }

    //     // Fetch data, group by circle, and count members
    //     $members = $query->with('circle') // Eager load circle relationship
    //         ->get()
    //         ->groupBy('circleId')
    //         ->map(function ($group) {
    //             $circle = $group->first()->circle;
    //             return [
    //                 'circleName' => $circle->circleName, // Use circle name here
    //                 'member_count' => $group->count(),
    //             ];
    //         })
    //         ->sortByDesc('member_count') // Sort by member count
    //         ->values(); // Reset keys

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
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Fetch data, group by circle, and include member names
        $members = $query->with('circle')
            ->get()
            ->groupBy('circleId')
            ->map(function ($group) {
                $circle = $group->first()->circle;

                return [
                    'circleName' => $circle ? $circle->circleName : 'Unknown Circle',
                    'member_count' => $group->count(),
                    'member_list' => $group->map(function ($member) {
                        return [
                            'full_name' => $member->firstName . ' ' . $member->lastName,
                            'joined_date' => $member->created_at->format('d-m-Y'),
                        ];
                    })->toArray(),
                ];
            })
            ->sortByDesc('member_count')
            ->values();



        return view('admin.report.joining', compact('members', 'circles'));
    }
    
    
    public function getJoiningMembersRenewalDate(Request $request)
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
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Fetch data, group by circle, and include member names
        $members = $query->with('circle')
            ->get()
            ->groupBy('circleId')
            ->map(function ($group) {
                $circle = $group->first()->circle;

                return [
                    'circleName' => $circle ? $circle->circleName : 'Unknown Circle',
                    'member_count' => $group->count(),
                    'member_list' => $group->map(function ($member) {
                        return [
                            'full_name' => $member->firstName . ' ' . $member->lastName,
                            'joined_date' => $member->created_at->format('d-m-Y'),
                        ];
                    })->toArray(),
                ];
            })
            ->sortByDesc('member_count')
            ->values();



        return view('admin.report.renewalMembers', compact('members', 'circles'));
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
            $circleCall = CircleCall::with(['meetingPersonReport:id,firstName,lastName'])
                ->where('status', 'Active')
                ->where('memberId', $selectedMemberId);

            $business = CircleMeetingMembersBusiness::with(['loginMember:id,firstName,lastName'])
                ->where('status', 'Active')
                ->where('businessGiverId', $selectedMemberId);

            $reference = CircleMeetingMembersReference::with(['refGiverName:id,firstName,lastName'])
                ->where('status', 'Active')
                ->where('referenceGiverId', $selectedMemberId);

            if ($startDate) {
                $circleCall->whereDate('created_at', '>=', $startDate);
                $business->whereDate('created_at', '>=', $startDate);
                $reference->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $circleCall->whereDate('created_at', '<=', $endDate);
                $business->whereDate('created_at', '<=', $endDate);
                $reference->whereDate('created_at', '<=', $endDate);
            }

            $circleCall = $circleCall->get();
            $business = $business->get();
            $reference = $reference->get();

            $totalBusinessAmount = $business->sum('amount');
            $totalIbmCount = $circleCall->count();
            $totalReferenceCount = $reference->count();
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
    //         // IBM (Circle Calls)
    //         $circleCallQuery = CircleCall::with(['meetingPersonReport:id,firstName,lastName', 'member:id,firstName,lastName'])
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($selectedMemberId) {
    //                 $q->where('memberId', $selectedMemberId)
    //                     ->orWhere('meetingPersonId', $selectedMemberId);
    //             });

    //         // Business
    //         $businessQuery = CircleMeetingMembersBusiness::with(['loginMember', 'businessGiver'])
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($selectedMemberId) {
    //                 $q->where('businessGiverId', $selectedMemberId)
    //                     ->orWhere('loginMemberId', $selectedMemberId);
    //             });

    //         // Reference
    //         $referenceQuery = CircleMeetingMembersReference::with(['refGiverName:id,firstName,lastName', 'refReceiver'])
    //             ->where('status', 'Active')
    //             ->where(function ($q) use ($selectedMemberId) {
    //                 $q->where('referenceGiverId', $selectedMemberId)
    //                     ->orWhere('memberId', $selectedMemberId);
    //             });

    //         if ($startDate) {
    //             $circleCallQuery->whereDate('created_at', '>=', $startDate);
    //             $businessQuery->whereDate('created_at', '>=', $startDate);
    //             $referenceQuery->whereDate('created_at', '>=', $startDate);
    //         }

    //         if ($endDate) {
    //             $circleCallQuery->whereDate('created_at', '<=', $endDate);
    //             $businessQuery->whereDate('created_at', '<=', $endDate);
    //             $referenceQuery->whereDate('created_at', '<=', $endDate);
    //         }

    //         $circleCall = $circleCallQuery->get();
    //         $business = $businessQuery->get();
    //         $reference = $referenceQuery->get();

    //         // Totals
    //         $totalBusinessAmount = $business->sum('amount');
    //         $totalIbmCount = $circleCall->count();
    //         $totalReferenceCount = $reference->count();
    //     }

    //     // Export to Excel if requested
    //     if ($request->has('export') && $selectedMember) {
    //         $memberName = Str::slug($selectedMember->firstName . ' ' . $selectedMember->lastName);
    //         $fileName = 'member_report_' . $memberName . '.xlsx';

    //         return Excel::download(new MemberReportExport($selectedMemberId, $startDate, $endDate), $fileName);
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




    //report for VP role -
    public function vpReport(Request $request)
    {
        // ✅ Get logged in user
        $userId = auth()->id();
        $member = Member::where('userId', $userId)->first();

        if (!$member) {
            return back()->with('error', 'You are not assigned to any circle.');
        }

        $circleId = $member->circleId;
        $circle = Circle::findOrFail($circleId);

        // ✅ Date filters
        $startDate = $request->input('startDate');
        $endDate   = $request->input('endDate');

        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $end   = $endDate ? Carbon::parse($endDate)->endOfDay() : Carbon::now()->endOfDay();

        /* ------------------ 1. Circle Calls ------------------ */
        $circleCalls = CircleCall::where('status', 'Active')
            ->when($start, fn($q) => $q->whereBetween('date', [$start, $end]))
            ->where(function ($q) use ($circleId) {
                $q->whereHas('member', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                })->orWhereHas('meetingPerson', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                });
            })
            ->get();

        $totalCircleCalls = $circleCalls->count();

        /* ------------------ 2. IBM ------------------ */
        $ibms = CircleCall::where('status', 'Active')
            ->when($start, fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->where(function ($q) use ($circleId) {
                $q->whereHas('member', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                })->orWhereHas('meetingPerson', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                });
            })
            ->get()
            ->flatMap(function ($item) {
                return [
                    ['member_id' => $item->memberId],
                    ['member_id' => $item->meetingPersonId],
                ];
            })
            ->groupBy('member_id')
            ->map(function ($group, $memberId) use ($circleId) {
                $member = Member::with('circle')->where('userId', $memberId)->first();

                if (!$member) {
                    return null;
                }

                if ($member->circleId != $circleId) {
                    return null;
                }

                return [
                    'memberId' => $member->id,
                    'memberName' => $member->firstName . ' ' . $member->lastName,
                    'circleName' => $member->circle->circleName ?? '',
                    'member_count' => $group->count(),
                ];
            })
            ->filter()
            ->sortByDesc('member_count')
            ->take(10) // ✅ only top 5 IBM
            ->values();

        $totalIbmParticipations = CircleCall::where('status', 'Active')
            ->when($start, fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->where(function ($q) use ($circleId) {
                $q->whereHas('member', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                })->orWhereHas('meetingPerson', function ($sq) use ($circleId) {
                    $sq->where('circleId', $circleId);
                });
            })
            ->get()
            ->flatMap(function ($item) {
                return [
                    ['member_id' => $item->memberId],
                    ['member_id' => $item->meetingPersonId],
                ];
            })
            ->groupBy('member_id')
            ->map(function ($group, $memberId) use ($circleId) {
                $member = Member::where('userId', $memberId)->first();
                if (!$member || $member->circleId != $circleId) {
                    return null;
                }
                return ['member_count' => $group->count()];
            })
            ->filter()
            ->sum('member_count');

        /* ------------------ 3. References ------------------ */
        $references = CircleMeetingMembersReference::with('refGiver')
            ->where('status', 'Active')
            ->when($start, fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->whereHas('refGiver', function ($q) use ($circleId) {
                $q->where('circleId', $circleId);
            })
            ->get();

        $totalReferences = $references->count();

        $refReport = $references->groupBy('referenceGiverId')
            ->map(function ($group) {
                $giver = $group->first()->refGiver;
                return [
                    'referenceGiverId' => $giver->userId,
                    'referenceGiverName' => $giver->firstName . ' ' . $giver->lastName,
                    'reference_count' => $group->count(),
                ];
            })
            ->sortByDesc('reference_count')
            ->take(10) // ✅ only top 5
            ->values();

        /* ------------------ 4. Business ------------------ */
        $businessMeetings = CircleMeetingMembersBusiness::with('member')
            ->where('status', 'Active')
            ->when($start, fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->whereHas('member', function ($q) use ($circleId) {
                $q->where('circleId', $circleId);
            })
            ->get();

        $totalBusinessAmount = $businessMeetings->sum('amount');

        $businessReport = $businessMeetings->groupBy('businessGiverId')
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
            ->take(10) // ✅ only top 5
            ->values();

        return view('admin.report.VPReport', compact(
            'circle',
            'startDate',
            'endDate',
            'totalCircleCalls',
            'totalIbmParticipations',
            'ibms',
            'refReport',
            'totalReferences',
            'businessReport',
            'totalBusinessAmount'
        ));
    }


    // ✅ Export Excel
    public function exportVpReport(Request $request)
    {
        return Excel::download(new \App\Exports\CircleVPReportExport($request), 'circle_report_vp.xlsx');
    }

    public function circleMemberReport(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $circleId = $request->input('circleId');

        $circles = Circle::where('status', 'Active')->select('id', 'circleName')->get();

        $report = collect();
        $details = [];

        if ($circleId) {
            $members = Member::where('status', 'Active')
                ->where('circleId', $circleId)
                ->select('id', 'userId', 'firstName', 'lastName', 'circleId')
                ->with('circle:id,circleName')
                ->get();

            $report = $members->map(function ($m) use ($startDate, $endDate, &$details) {
                $uid = $m->userId;

                $ibmQuery = CircleCall::where('status', 'Active')
                    ->where('memberId', $uid);
                if ($startDate) {
                    $ibmQuery->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $ibmQuery->whereDate('created_at', '<=', $endDate);
                }
                $ibmRows = $ibmQuery->with('meetingPersonReport')->get()->unique('id');
                $ibmCount = $ibmRows->count();

                $refQuery = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('referenceGiverId', $uid);
                if ($startDate) {
                    $refQuery->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $refQuery->whereDate('created_at', '<=', $endDate);
                }
                $refRows = $refQuery->with('refReceiver')->get()->unique('id');
                $refCount = $refRows->count();

                $busQuery = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->where('businessGiverId', $uid);
                if ($startDate) {
                    $busQuery->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $busQuery->whereDate('created_at', '<=', $endDate);
                }
                $busRows = $busQuery->with('loginMember')->get()->unique('id');

                $details[$uid] = [
                    'ibms' => $ibmRows->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'with_name' => ($r->meetingPersonReport->firstName ?? '') . ' ' . ($r->meetingPersonReport->lastName ?? ''),
                            'date' => optional($r->created_at)->format('Y-m-d'),
                        ];
                    })->values(),
                    'references' => $refRows->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'to_name' => ($r->refReceiver->firstName ?? '') . ' ' . ($r->refReceiver->lastName ?? ''),
                            'contact_name' => $r->contactName ?? '',
                            'date' => optional($r->created_at)->format('Y-m-d'),
                        ];
                    })->values(),
                    'businesses' => $busRows->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'to_name' => ($r->loginMember->firstName ?? '') . ' ' . ($r->loginMember->lastName ?? ''),
                            'amount' => $r->amount,
                            'date' => optional($r->created_at)->format('Y-m-d'),
                        ];
                    })->values(),
                ];

                return [
                    'circleName' => $m->circle->circleName ?? '-',
                    'memberUserId' => $uid,
                    'memberName' => $m->firstName . ' ' . $m->lastName,
                    'ibm_count' => $ibmCount,
                    'reference_count' => $refCount,
                    'business_count' => $busRows->count(),
                    'business_total_amount' => $busRows->sum('amount'),
                ];
            });
        }

        if ($request->has('export') && $circleId) {
            if ($request->input('export') === 'detail') {
                return Excel::download(new \App\Exports\CircleMemberDetailExport($circleId, $startDate, $endDate), 'circle_member_report_detail.xlsx');
            }
            return Excel::download(new \App\Exports\CircleMemberAggregateExport($circleId, $startDate, $endDate), 'circle_member_report.xlsx');
        }

        return view('admin.report.circleMemberReport', compact('circles', 'report', 'details', 'circleId', 'startDate', 'endDate'));
    }

    public function exportCircleMemberReport(Request $request)
    {
        $circleId = $request->input('circleId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        return Excel::download(new \App\Exports\CircleMemberAggregateExport($circleId, $startDate, $endDate), 'circle_member_report.xlsx');
    }

    public function renewalReport(Request $request)
    {
        $circleId = $request->input('circleId');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        
    }


}
