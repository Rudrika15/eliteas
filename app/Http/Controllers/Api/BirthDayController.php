<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BirthDayController extends Controller
{
    public function todayBirthdays(Request $request)
    {
        try {
            $today = Carbon::today();

            $birthdayMembers = Member::with('user')
                ->where('status', 'Active')
                ->whereNotNull('birthDate')
                ->whereMonth('birthDate', $today->month)
                ->whereDay('birthDate', $today->day)
                ->orderBy('firstName', 'ASC')
                ->get();

            return response()->json([
                'status' => true,
                'server_date' => $today->toDateString(),
                'month' => $today->month,
                'day' => $today->day,
                'count' => $birthdayMembers->count(),
                'data' => $birthdayMembers,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
