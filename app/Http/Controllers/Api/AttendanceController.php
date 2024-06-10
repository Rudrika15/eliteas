<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingsAttendances;
use App\Models\MeetingInvitation;
use App\Models\Schedule;
use App\Utils\Utils;

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
                'userId' => 'array',
                'userId.*' => 'integer|exists:users,id',
                // 'personName' => 'array',
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
            ]);

            $userIds = $request->input('userId', []);
            $circleId = $request->circleId;
            $meetingId = $request->meetingId;

            foreach ($userIds as $index => $userId) {
                $attendance = new CircleMeetingsAttendances();
                $attendance->userId = $userId ?? null;
                $attendance->circleId = $circleId;
                $attendance->meetingId = $meetingId;
                $attendance->status = 'Present';
                $attendance->save();
            }

            return Utils::sendResponse([], 'Attendance successfully recorded', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function invitedAttendanceStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'personName' => 'array',
                'personName.*' => 'string',
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
            ]);

            $personNames = $request->input('personName', []);
            $circleId = $request->circleId;
            $meetingId = $request->meetingId;

            foreach ($personNames as $index => $personName) {
                $attendance = new CircleMeetingsAttendances();
                $attendance->circleId = $circleId;
                $attendance->meetingId = $meetingId;
                $attendance->name = $personName ?? null;
                $attendance->status = 'Present';
                $attendance->save();
            }

            return Utils::sendResponse([], 'Invited attendance successfully recorded', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
