<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

class LeaderBoardController extends Controller
{

    // public function __construct()
    // {
    //     // Apply middleware for event-related permissions
    //     $this->middleware('permission:max-meetings', ['only' => ['maxMeetings']]);
    //     $this->middleware('permission:max-business', ['only' => ['maxBusiness']]);
    //     $this->middleware('permission:max-refferal', ['only' => ['maxRefferal']]);
    //     $this->middleware('permission:max-reference', ['only' => ['maxReference']]);
    //     $this->middleware('permission:max-visitor', ['only' => ['maxVisitor']]);
    //     $this->middleware('permission:circle-wise-leaderboard', ['only' => ['circleWiseLeaserboard']]);
    // }



    public function maxMeetings(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                ->where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->first();

            $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
                return [
                    'member' => $group->first()->member,
                    'count' => $group->count()
                ];
            })->sortByDesc('count');

            return view('admin.leaderboards.meetingIndex', compact('circlecalls'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function maxBusiness(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
                return [
                    'user' => $group->first()->users,
                    'amount' => $group->sum('amount'),
                    'count' => $group->count()
                ];
            })->sortByDesc('amount');

            return view('admin.leaderboards.businessIndex', compact('busGiver'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    // public function maxBusinessAscending(Request $request)
    // {
    //     try {
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
    //             return [
    //                 'user' => $group->first()->users,
    //                 'amount' => $group->sum('amount')
    //             ];
    //         })->sortBy('amount');

    //         return view('admin.leaderboards.businessIndex', compact('busGiver'));
    //     } catch (\Throwable $th) {
    //         throw $th;
    //         return view('servererror');
    //     }
    // }


    public function maxReference(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->whereYear('created_at', $previousYear)
                ->whereMonth('created_at', $previousMonth)
                ->get();

            $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) {
                return [
                    'user' => $group->first()->refGiverName,
                    'count' => $group->count()
                ];
            })->sortByDesc('count');

            return view('admin.leaderboards.referenceIndex', compact('refGiver'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function maxRefferal(Request $request)
    {
        try {
            // $previousMonth = Carbon::now()->subMonth()->month;
            // $previousYear = Carbon::now()->subMonth()->year;

            // $refGiver = CircleMeetingMembersReference::where('status', 'Active')
            //     ->whereYear('created_at', $previousYear)
            //     ->whereMonth('created_at', $previousMonth)
            //     ->get();

            // $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) {
            //     return [
            //         'user' => $group->first()->refGiverName,
            //         'count' => $group->count()
            //     ];
            // })->sortByDesc('count');

            return view('admin.leaderboards.refferalIndex');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function maxVisitor(Request $request)
    {
        try {
            // $previousMonth = Carbon::now()->subMonth()->month;
            // $previousYear = Carbon::now()->subMonth()->year;

            // $refGiver = CircleMeetingMembersReference::where('status', 'Active')
            //     ->whereYear('created_at', $previousYear)
            //     ->whereMonth('created_at', $previousMonth)
            //     ->get();

            // $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) {
            //     return [
            //         'user' => $group->first()->refGiverName,
            //         'count' => $group->count()
            //     ];
            // })->sortByDesc('count');

            return view('admin.leaderboards.visitorIndex');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    //circle wise leaderboard



    // public function circleWiseLeaderboard(Request $request)
    // {
    //     try {
    //         // Get all circles for the dropdown
    //         $circles = Circle::all();

    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         // Get selected circle ID from the request
    //         $selectedCircleId = $request->circleId;

    //         $circlecalls = null;

    //         if ($selectedCircleId) {
    //             // Fetch active circle calls based on the selected circle
    //             $circlecalls = CircleCall::with(['member', 'meetingPerson'])
    //                 ->where('status', 'Active')
    //                 ->whereYear('date', $previousYear)
    //                 ->whereMonth('date', $previousMonth)
    //                 ->get();

    //             // Filter members based on the selected circle ID
    //             $circlecalls = $circlecalls->filter(function ($call) use ($selectedCircleId) {
    //                 return $call->member->circleId == $selectedCircleId;
    //             })->groupBy('memberId')->map(function ($group) {
    //                 return [
    //                     'member' => $group->first()->member,
    //                     'count' => $group->count(),
    //                 ];
    //             })->sortByDesc('count');
    //         }

    //         return view('admin.leaderboards.circleWiseLeaderboard', compact('circlecalls', 'circles', 'selectedCircleId'));
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return view('servererror');
    //     }
    // }


    // public function circleWiseLeaderboard(Request $request)
    // {
    //     try {
    //         // Get all circles for the dropdown
    //         $circles = Circle::all();

    //         // Get the selected circle ID from the request
    //         $selectedCircleId = $request->input('circleId');

    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         // Initialize variables for circle calls and business givers
    //         $circlecalls = null;
    //         $busGiver = null;

    //         // Check if a circle is selected
    //         if ($selectedCircleId) {
    //             // Fetch active circle calls based on the selected circle
    //             $circlecalls = CircleCall::with(['member', 'meetingPerson'])
    //                 ->where('status', 'Active')
    //                 ->whereYear('date', $previousYear)
    //                 ->whereMonth('date', $previousMonth)
    //                 ->get();

    //             // Filter and group circle calls by memberId and count the calls
    //             $circlecalls = $circlecalls->filter(function ($call) use ($selectedCircleId) {
    //                 return $call->member->circleId == $selectedCircleId;
    //             })->groupBy('memberId')->map(function ($group) {
    //                 return [
    //                     'member' => $group->first()->member,
    //                     'count' => $group->count(),
    //                 ];
    //             })->sortByDesc('count');

    //             // Fetch all active business givers from the previous month
    //             $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //                 ->whereMonth('date', $previousMonth)
    //                 ->get();

    //             // Group by businessGiverId, sum the amount, and count the meetings, then filter by circleId
    //             $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($selectedCircleId) {
    //                 // Get the user (business giver) from the first entry of the group
    //                 $user = $group->first()->users;

    //                 // Fetch the circleId from the Members table
    //                 $member = Member::where('userId', $user->id)->first();
    //                 $circleId = $member->circleId ?? null;

    //                 // Only include the user if their circleId matches the selected circleId
    //                 if ($circleId == $selectedCircleId) {
    //                     return [
    //                         'user' => $user,
    //                         'amount' => $group->sum('amount'),
    //                         'count' => $group->count(),
    //                         'circle' => $member->circle // Assuming you have a circle relationship in the Member model
    //                     ];
    //                 }
    //                 return null;
    //             })->filter()->sortByDesc('amount'); // Filter out null values and sort by amount
    //         }

    //         // Return the view with both circle calls and business givers data
    //         return view('admin.leaderboards.circleWiseLeaderboard', compact('circlecalls', 'busGiver', 'circles', 'selectedCircleId'));
    //     } catch (\Throwable $th) {
    //         // Log error and return error view
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return view('servererror');
    //     }
    // }


    // public function circleWiseLeaderboard(Request $request)
    // {
    //     try {
    //         // Get all circles for the dropdown
    //         $circles = Circle::where('status', 'Active')->get();

    //         // Get the selected circle ID from the request
    //         $selectedCircleId = $request->input('circleId');

    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         // Initialize variables for circle calls, business givers, and reference givers
    //         $circlecalls = null;
    //         $busGiver = null;
    //         $refGiver = null;

    //         // Check if a circle is selected
    //         if ($selectedCircleId) {
    //             // Fetch active circle calls based on the selected circle
    //             $circlecalls = CircleCall::with(['member', 'meetingPerson'])
    //                 ->where('status', 'Active')
    //                 ->whereYear('date', $previousYear)
    //                 ->whereMonth('date', $previousMonth)
    //                 ->get();

    //             // Filter and group circle calls by memberId and count the calls
    //             $circlecalls = $circlecalls->filter(function ($call) use ($selectedCircleId) {
    //                 return $call->member->circleId == $selectedCircleId;
    //             })->groupBy('memberId')->map(function ($group) {
    //                 return [
    //                     'member' => $group->first()->member,
    //                     'count' => $group->count(),
    //                 ];
    //             })->sortByDesc('count');

    //             // Fetch all active business givers from the previous month
    //             $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //                 ->whereYear('date', $previousYear)
    //                 ->whereMonth('date', $previousMonth)
    //                 ->get();

    //             // Group by businessGiverId, sum the amount, and count the meetings, then filter by circleId
    //             $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($selectedCircleId) {
    //                 // Get the user (business giver) from the first entry of the group
    //                 $user = $group->first()->users;

    //                 // Fetch the circleId from the Members table
    //                 $member = Member::where('userId', $user->id)->first();
    //                 $circleId = $member->circleId ?? null;

    //                 // Only include the user if their circleId matches the selected circleId
    //                 if ($circleId == $selectedCircleId) {
    //                     return [
    //                         'user' => $user,
    //                         'amount' => $group->sum('amount'),
    //                         'count' => $group->count(),
    //                         'circle' => $member->circle // Assuming you have a circle relationship in the Member model
    //                     ];
    //                 }
    //                 return null;
    //             })->filter()->sortByDesc('amount'); // Filter out null values and sort by amount

    //             // Fetch all active reference givers from the previous month
    //             $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //                 ->whereYear('created_at', $previousYear)
    //                 ->whereMonth('created_at', $previousMonth)
    //                 ->get();

    //             // Group by referenceGiverId, count the references, and filter by circleId
    //             $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) use ($selectedCircleId) {
    //                 // Get the user (reference giver) from the first entry of the group
    //                 $user = $group->first()->refGiverName;

    //                 // Fetch the circleId from the Members table
    //                 $member = Member::where('userId', $group->first()->referenceGiverId)->first();
    //                 $circleId = $member->circleId ?? null;

    //                 // Only include the user if their circleId matches the selected circleId
    //                 if ($circleId == $selectedCircleId) {
    //                     return [
    //                         'user' => $user,
    //                         'count' => $group->count(),
    //                         'circle' => $member->circle // Assuming you have a circle relationship in the Member model
    //                     ];
    //                 }
    //                 return null;
    //             })->filter()->sortByDesc('count'); // Filter out null values and sort by count
    //         }

    //         // Return the view with circle calls, business givers, reference givers, and circles data
    //         return view('admin.leaderboards.circleWiseLeaderboard', compact('circlecalls', 'busGiver', 'refGiver', 'circles', 'selectedCircleId'));
    //     } catch (\Throwable $th) {
    //         // Log error and return error view
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return view('servererror');
    //     }
    // }

    public function circleWiseLeaderboard(Request $request)
    {
        try {
            // Get all circles for the dropdown
            $circles = Circle::where('status', 'Active')->get();

            // Get the selected circle ID from the request
            $selectedCircleId = $request->input('circleId');

            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            // Initialize variables for circle calls, business givers, and reference givers
            $circlecalls = null;
            $busGiver = null;
            $refGiver = null;

            // Check if a circle is selected
            if ($selectedCircleId) {
                // Fetch active circle calls based on the selected circle
                $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                    ->where('status', 'Active')
                    ->whereYear('date', $previousYear)
                    ->whereMonth('date', $previousMonth)
                    ->get();

                // Filter and group circle calls by memberId and get only the highest count per member
                $circlecalls = $circlecalls->filter(function ($call) use ($selectedCircleId) {
                    return $call->member->circleId == $selectedCircleId;
                })->groupBy('memberId')->map(function ($group) {
                    return [
                        'member' => $group->first()->member,
                        'count' => $group->count(),  // Count total circle calls
                    ];
                })->sortByDesc('count')->take(1);  // Get the highest circle call record per user

                // Fetch all active business givers from the previous month
                $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->whereYear('date', $previousYear)
                    ->whereMonth('date', $previousMonth)
                    ->get();

                // Group by businessGiverId, get only the highest amount, and count the meetings, then filter by circleId
                $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($selectedCircleId) {
                    // Get the user (business giver) from the first entry of the group
                    $user = $group->first()->users;

                    // Fetch the circleId from the Members table
                    $member = Member::where('userId', $user->id)->first();
                    $circleId = $member->circleId ?? null;

                    // Only include the user if their circleId matches the selected circleId
                    if ($circleId == $selectedCircleId) {
                        return [
                            'user' => $user,
                            'amount' => $group->max('amount'),  // Get highest amount for this business giver
                            'count' => $group->count(),
                            'circle' => $member->circle // Assuming you have a circle relationship in the Member model
                        ];
                    }
                    return null;
                })->filter()->sortByDesc('amount')->take(1); // Get the highest record per user and filter nulls

                // Fetch all active reference givers from the previous month
                $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                    ->whereYear('created_at', $previousYear)
                    ->whereMonth('created_at', $previousMonth)
                    ->get();

                // Group by referenceGiverId, get only the highest count, and filter by circleId
                $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) use ($selectedCircleId) {
                    // Get the user (reference giver) from the first entry of the group
                    $user = $group->first()->refGiverName;

                    // Fetch the circleId from the Members table
                    $member = Member::where('userId', $group->first()->referenceGiverId)->first();
                    $circleId = $member->circleId ?? null;

                    // Only include the user if their circleId matches the selected circleId
                    if ($circleId == $selectedCircleId) {
                        return [
                            'user' => $user,
                            'count' => $group->max('count'),  // Get highest count for this reference giver
                            'circle' => $member->circle // Assuming you have a circle relationship in the Member model
                        ];
                    }
                    return null;
                })->filter()->sortByDesc('count')->take(1);  // Get the highest reference record per user
            }

            // Return the view with circle calls, business givers, reference givers, and circles data
            return view('admin.leaderboards.circleWiseLeaderboard', compact('circlecalls', 'busGiver', 'refGiver', 'circles', 'selectedCircleId'));
        } catch (\Throwable $th) {
            // Log error and return error view
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }
}
