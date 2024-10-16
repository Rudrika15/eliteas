<?php

namespace App\Http\Controllers\Admin;

use App\Models\Circle;
use App\Models\Member;
use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

class AllActivityController extends Controller
{

    function __construct()
    {
        // Applying middleware based on the specific methods for IBM, Reference, and Business.
        $this->middleware('permission:ibm-list|ibm-create|ibm-edit|ibm-delete', ['only' => ['ibm']]);
        $this->middleware('permission:reference-list|reference-create|reference-edit|reference-delete', ['only' => ['reference']]);
        $this->middleware('permission:business-list|business-create|business-edit|business-delete', ['only' => ['business']]);
        $this->middleware('permission:ibm-index-vp', ['only' => ['ibmVp']]);
        $this->middleware('permission:refrence-index-vp', ['only' => ['refrenceVp']]);
        $this->middleware('permission:business-slip-index-vp', ['only' => ['businessVp']]);
    }

    public function ibm()
    {
        $ibms = CircleCall::where('status', 'Active')->paginate(10);
        return view('admin.allactivity.ibm', compact('ibms'));
    }

    public function refrence()
    {
        $refrences = CircleMeetingMembersReference::where('status', 'Active')->paginate(10);
        return view('admin.allactivity.reference', compact('refrences'));
    }

    public function business()
    {
        $businesses = CircleMeetingMembersBusiness::where('status', 'Active')->paginate(10);
        return view('admin.allactivity.businessSlip', compact('businesses'));
    }


    public function ibmVp(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            // Get member.id and circleId from members table based on the authenticated user's id
            $member = Member::select('id', 'circleId')
                ->where('userId', $userId)
                ->first();

            $memberId = $member->id;
            $circleId = $member->circleId;

            // Get the start and end dates from the request (if provided)
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Fetch circle calls, apply date filtering if both dates are provided
            $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                ->where('status', 'Active')
                ->whereHas('member', function ($query) use ($circleId) {
                    $query->where('circleId', $circleId);
                })
                ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate]);
                })
                ->get();

            return view('admin.allactivityforvp.ibm', compact('circlecalls', 'startDate', 'endDate'));
        } catch (\Throwable $th) {
            // Log error and return error view
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }




    public function refrenceVp(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            // Get member.id and circleId from members table based on the authenticated user's id
            $member = Member::select('id', 'circleId')
                ->where('userId', $userId)
                ->first();

            $memberId = $member->id;
            $circleId = $member->circleId;

            // Query references with optional date filtering
            $query = CircleMeetingMembersReference::with(['members'])
                ->where('status', 'Active')
                ->whereHas('members', function ($query) use ($circleId) {
                    $query->where('circleId', $circleId);
                });

            // Filter by start date and end date if provided
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $refrences = $query->get();

            return view('admin.allactivityforvp.reference', compact('refrences'));
        } catch (\Throwable $th) {
            // Log error and return error view
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function businessVp(Request $request)
    {
        try {
            $userId = auth()->user()->id;

            // Get member.id and circleId from members table based on the authenticated user's id
            $member = Member::select('id', 'circleId')
                ->where('userId', $userId)
                ->first();

            $memberId = $member->id;
            $circleId = $member->circleId;

            // Query businesses with optional date filtering
            $query = CircleMeetingMembersBusiness::with(['members'])
                ->where('status', 'Active')
                ->whereHas('member', function ($query) use ($circleId) {
                    $query->where('circleId', $circleId);
                });

            // Filter by start date and end date if provided
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = Carbon::parse($request->start_date)->startOfDay();
                $endDate = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            $businesses = $query->paginate(10);

            return view('admin.allactivityforvp.businessSlip', compact('businesses'));
        } catch (\Throwable $th) {
            // Log error and return error view
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }









    // public function activityAllByCircle(Request $request)
    // {
    //     try {
    //         // Get the authenticated user
    //         $authUser = auth()->user();

    //         // Get the member ID and circle ID based on the authenticated user
    //         $memberId = $authUser->member->id;
    //         $selectedCircleId = $authUser->member->circleId;

    //         // Initialize variables for circle calls, business givers, and reference givers
    //         $circlecalls = null;
    //         $busGiver = null;
    //         $refGiver = null;

    //         // Check if a circle is selected
    //         if ($selectedCircleId) {
    //             // Fetch active circle calls based on the selected circle
    //             return                 $circlecalls = CircleCall::with(['member', 'meetingPerson'])
    //                 ->where('status', 'Active')
    //                 ->get();


    //             // Fetch all active business givers from the previous month
    //             $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //                 ->get();

    //             // Group by businessGiverId, get only the highest amount, and count the meetings, then filter by circleId
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
    //                         'amount' => $group->max('amount'),  // Get highest amount for this business giver
    //                         'count' => $group->count(),
    //                         'circle' => $member->circle // Assuming you have a circle relationship in the Member model
    //                     ];
    //                 }
    //                 return null;
    //             })->filter()->sortByDesc('amount')->take(1); // Get the highest record per user and filter nulls

    //             // Fetch all active reference givers from the previous month
    //             $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //                 ->get();

    //             // Group by referenceGiverId, get only the highest count, and filter by circleId
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
    //                         'count' => $group->max('count'),  // Get highest count for this reference giver
    //                         'circle' => $member->circle // Assuming you have a circle relationship in the Member model
    //                     ];
    //                 }
    //                 return null;
    //             })->filter()->sortByDesc('count')->take(1);  // Get the highest reference record per user
    //         }

    //         // Return the view with circle calls, business givers, reference givers, and circles data
    //         return view('admin.leaderboards.circleWiseLeaderboard', compact('circlecalls', 'busGiver', 'refGiver', 'circles', 'selectedCircleId'));
    //     } catch (\Throwable $th) {
    //         throw $th;
    //         // Log error and return error view
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return view('servererror');
    //     }
    // }
}
// }
