<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CircleMeetingsAttendances;
use App\Models\MeetingInvitation;
use App\Models\Schedule;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function memberAttendance(Request $request)
    {
        try {
            $user = auth()->user();
            $circleMembers = $user->member->circle->members;
            $meetingId = $request->id;
            $circleId = Schedule::where('id', $meetingId)->first()->circleId;
            $meetingInvitations = MeetingInvitation::where('meetingId', $meetingId)->get();

            return Utils::sendResponse(
                ['circleMembers' => $circleMembers, 'meetingInvitations' => $meetingInvitations, 'meetingId' => $meetingId, 'circleId' => $circleId],
                'Attendance data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function invitedAttendance(Request $request)
    {
        try {

            $user = auth()->user();
            // $circleMembers = $user->member->circle->members;
            $meetingId = $request->id;
            $circleId = Schedule::where('id', $meetingId)->first()->circleId;
            $meetingInvitations = MeetingInvitation::where('meetingId', $meetingId)->get();

            return Utils::sendResponse(
                ['meetingInvitations' => $meetingInvitations, 'meetingId' => $meetingId, 'circleId' => $circleId],
                'Invited attendance data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function meetingSchedules(Request $request)
    {
        try {
            $user = auth()->user();
            $schedules = Schedule::where('circleId', $user->member->circle->id)
                ->orderBy('date', 'desc')
                ->where('date', '<', now())
                ->get();

            return Utils::sendResponse(['schedules' => $schedules], 'Meeting schedules retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function attendanceList(Request $request)
    {
        try {
            $user = auth()->user();
            $attendanceList = CircleMeetingsAttendances::where('circleId', $user->member->circle->id)->get();

            return Utils::sendResponse(['attendanceList' => $attendanceList], 'Attendance list retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function attendanceStore(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'circleId' => 'required|integer',
                'meetingId' => 'required|integer',
                'attendance' => 'nullable|array',
                'attendance.*' => 'nullable|in:Present,Absent,Late,Medical,Sub',
                'userId' => 'nullable|array',
                'userId.*' => 'integer|exists:users,id',
            ]);

            $circleId = (int) $validatedData['circleId'];
            $meetingId = (int) $validatedData['meetingId'];

            $attendanceMap = $request->input('attendance');
            if (is_array($attendanceMap)) {
                foreach ($attendanceMap as $userId => $status) {
                    $userId = (int) $userId;
                    $status = is_string($status) ? trim($status) : null;

                    $attendance = CircleMeetingsAttendances::where('circleId', $circleId)
                        ->where('meetingId', $meetingId)
                        ->where('userId', $userId)
                        ->first();

                    if (! $status) {
                        if ($attendance) {
                            $attendance->delete();
                        }

                        continue;
                    }

                    if (! $attendance) {
                        $attendance = new CircleMeetingsAttendances;
                        $attendance->circleId = $circleId;
                        $attendance->meetingId = $meetingId;
                        $attendance->userId = $userId;
                    }

                    $attendance->status = $status;
                    $attendance->save();
                }
            } else {
                $userIds = $request->input('userId', []);

                foreach ($userIds as $userId) {
                    $attendance = new CircleMeetingsAttendances;
                    $attendance->userId = $userId ?? null;
                    $attendance->circleId = $circleId;
                    $attendance->meetingId = $meetingId;
                    $attendance->status = 'Present';
                    $attendance->save();
                }
            }

            return Utils::sendResponse([], 'Attendance successfully recorded', 200);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function invitedAttendanceStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'personName' => 'array',
                'personName.*' => 'string',
                'circleId' => 'required|integer',
                'meetingId' => 'required|integer',
            ]);

            $personNames = $request->input('personName', []);
            $circleId = $request->circleId;
            $meetingId = $request->meetingId;

            foreach ($personNames as $index => $personName) {
                $personName = is_string($personName) ? trim($personName) : null;
                if (! $personName) {
                    continue;
                }

                $attendance = CircleMeetingsAttendances::where('circleId', $circleId)
                    ->where('meetingId', $meetingId)
                    ->where('name', $personName)
                    ->first();

                if (! $attendance) {
                    $attendance = new CircleMeetingsAttendances;
                    $attendance->circleId = $circleId;
                    $attendance->meetingId = $meetingId;
                    $attendance->name = $personName;
                }

                $attendance->status = 'Present';
                $attendance->save();
            }

            return Utils::sendResponse([], 'Invited attendance successfully recorded', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
