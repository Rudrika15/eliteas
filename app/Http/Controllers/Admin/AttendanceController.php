<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\MeetingInvitation;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingsAttendances;

class AttendanceController extends Controller
{
    public function takeAttendance(Request $request)
    {
        try {
            $user = auth()->user();

            $circleMembers = $user->member->circle->members;

            $meetingId = $request->id;

            $circleId = Schedule::where('id', $meetingId)->first()->circleId;

            $meetingInvitations = MeetingInvitation::where('meetingId', $meetingId)
                ->get();

            return view('admin.attendance.index', compact('circleMembers', 'meetingInvitations', 'meetingId', 'circleId'));
        } catch (\Throwable $th) {
            // Log the error using the utility class
            ErrorLogger::logError($th, $request->fullUrl());
            // Return a custom error view
            return view('servererror'); // Ensure this view exists
        }
    }


    public function invitedAttendance(Request $request)
    {
        try {
            $user = auth()->user();

            $circleMembers = $user->member->circle->members;

            $meetingId = $request->id;

            $circleId = Schedule::where('id', $meetingId)->first()->circleId;

            $meetingInvitations = MeetingInvitation::where('meetingId', $meetingId)
                ->get();

            return view('admin.attendance.invitedIndex', compact('circleMembers', 'meetingInvitations', 'meetingId', 'circleId'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            // Optionally log the error or handle it
            return view('servererror'); // Ensure this view exists
        }
    }

    public function meetingSchedules(Request $request)
    {
        try {
            $user = auth()->user();

            $schedules = Schedule::where('circleId', auth()->user()->member->circle->id)
                ->orderBy('date', 'desc')
                ->where('date', '<', now())
                ->paginate(10);

            return view('admin.attendance.meetingSchedule', compact('schedules'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function attendanceList(Request $request)
    {
        try {
            $user = auth()->user();

            $attendanceList = CircleMeetingsAttendances::where('circleId', auth()->user()->member->circle->id)
                ->get();

            return view('admin.attendance.attendanceList', compact('attendanceList'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }


    public function attendanceStore(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'userId' => 'array',
                'userId.*' => 'integer|exists:users,id',
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
            ]);

            $userIds = $request->input('userId', []);
            $circleId = $validatedData['circleId'];
            $meetingId = $validatedData['meetingId'];

            // Store attendance records
            foreach ($userIds as $index => $userId) {
                $attendance = new CircleMeetingsAttendances();
                $attendance->userId = $userId ?? null;
                $attendance->circleId = $circleId;
                $attendance->meetingId = $meetingId;
                $attendance->status = 'Present';
                $attendance->save();
            }

            return redirect()->route('attendance.meetingSchedules')->with('success', 'Attendance successfully recorded.');
        } catch (\Throwable $th) {
            // Log the error using a utility class or directly
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            // Optionally, handle the error (e.g., show an error message)
            return redirect()->back()->withErrors(['error' => 'An error occurred while recording attendance.']);
        }
    }


    public function invitedAttendanceStore(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'personName' => 'array',
                'personName.*' => 'string',
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
            ]);

            $personNames = $request->input('personName', []);
            $circleId = $request->circleId;
            $meetingId = $request->meetingId;

            foreach ($personNames as $personName) {
                $attendance = new CircleMeetingsAttendances();
                $attendance->circleId = $circleId;
                $attendance->meetingId = $meetingId;
                $attendance->name = $personName ?? null;
                $attendance->status = 'Present';
                $attendance->save();
            }

            return redirect()->route('attendance.meetingSchedules')->with('success', 'Attendance successfully recorded.');
        } catch (\Throwable $th) {
            // Log the error or handle it (optional)
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            // Return a custom error view
            return redirect()->back()->withErrors(['error' => 'An error occurred while recording attendance.']);
        }
    }
}
