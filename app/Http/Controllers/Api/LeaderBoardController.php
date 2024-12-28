<?php

namespace App\Http\Controllers\Api;

use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\Member;
use App\Utils\ErrorLogger;
use App\Utils\Utils;


class LeaderBoardController extends Controller
{
    public function maxMeetings(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                ->where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
                return [
                    'member' => $group->first()->member,
                    'count' => $group->count()
                ];
            })->sortByDesc('count')->values();

            return Utils::sendResponse(
                ['circlecalls' => $circlecalls],
                'Meeting data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
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
            })->sortByDesc('amount')->values();

            return Utils::sendResponse(
                ['busGiver' => $busGiver],
                'Business data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

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
            })->sortByDesc('count')->values();

            return Utils::sendResponse(
                ['refGiver' => $refGiver],
                'Reference data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxRefferal(Request $request)
    {
        try {
            return Utils::sendResponse(
                [],
                'Referral data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxVisitor(Request $request)
    {
        try {
            return Utils::sendResponse(
                [],
                'Visitor data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function circleWiseLeaderboardAPI(Request $request)
    {
        try {
            // Get all circles for the dropdown
            $circles = Circle::where('status', 'Active')->get();

            // Get the selected circle ID from the request query parameter (for GET) or body (for POST)
            $selectedCircleId = $request->input('circleId');

            if (!$selectedCircleId) {
                return response()->json(['error' => 'circleId is required'], 400);
            }

            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            // Initialize variables for circle calls, business givers, and reference givers
            $circlecalls = null;
            $busGiver = null;
            $refGiver = null;

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
                    'count' => $group->count(), // Count the total circle calls
                ];
            })->sortByDesc('count')->take(1); // Get the highest circle call record per user

            // Fetch all active business givers from the previous month
            $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            // Group business givers by businessGiverId, get only the highest amount, and count the meetings, then filter by circleId
            $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($selectedCircleId) {
                $user = $group->first()->users;
                $member = Member::where('userId', $user->id)->first();
                $circleId = $member->circleId ?? null;

                if ($circleId == $selectedCircleId) {
                    return [
                        'user' => $user,
                        'amount' => $group->max('amount'), // Get highest amount for this business giver
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

            // Group reference givers by referenceGiverId, get only the highest count, and filter by circleId
            $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) use ($selectedCircleId) {
                $user = $group->first()->refGiverName;
                $member = Member::where('userId', $group->first()->referenceGiverId)->first();
                $circleId = $member->circleId ?? null;

                if ($circleId == $selectedCircleId) {
                    return [
                        'user' => $user,
                        'count' => $group->max('count'), // Get highest count for this reference giver
                        'circle' => $member->circle // Assuming you have a circle relationship in the Member model
                    ];
                }
                return null;
            })->filter()->sortByDesc('count')->take(1); // Get the highest reference record per user

            // Return the result as JSON
            return response()->json([
                'circlecalls' => $circlecalls,
                'busGiver' => $busGiver,
                'refGiver' => $refGiver,
                'circles' => $circles,
                'selectedCircleId' => $selectedCircleId
            ]);
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a server error response
            return response()->json(['error' => 'Server error. Please try again later.'], 500);
        }
    }
}
