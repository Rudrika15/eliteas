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
            $today = Carbon::today()->toDateString();

            $birthdayMembers = Member::with('user')
                ->where('status', 'Active')
                ->whereDate('birthDate', $today)
                ->orderBy('firstName', 'ASC')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Today birthday members fetched successfully.',
                'data' => $birthdayMembers,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while fetching today birthdays.',
            ], 500);
        }
    }
}
