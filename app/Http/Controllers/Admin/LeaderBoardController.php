<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Country;
use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

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
}
