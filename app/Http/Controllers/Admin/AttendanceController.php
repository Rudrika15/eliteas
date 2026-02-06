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

    function __construct()
    {
        // Applying middleware based on specific methods for attendance management
        $this->middleware('permission:attendance-take|attendance-list|attendance-create|attendance-edit', ['only' => ['takeAttendance']]);
        $this->middleware('permission:invited-attendance-take|invited-attendance-list|invited-attendance-create|invited-attendance-edit', ['only' => ['invitedAttendance']]);
        $this->middleware('permission:meeting-schedule-view|meeting-schedule-list', ['only' => ['meetingSchedules']]);
        $this->middleware('permission:attendance-list-view', ['only' => ['attendanceList']]);
        $this->middleware('permission:attendance-store|attendance-store-create', ['only' => ['attendanceStore', 'updateStatus']]);
        $this->middleware('permission:attendance-invite-store|attendance-invite-create', ['only' => ['invitedAttendanceStore', 'updateInvitedStatus']]);
    }

    public function takeAttendance(Request $request)
    {
        try {
            $user = auth()->user();

            // $circleMembers = $user->member->circle->members;
            $circleMembers = $user->member->circle->members()->where('status', 'Active')->get();

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
                ->when($request->id, function ($query) use ($request) {
                    return $query->where('meetingId', $request->id);
                })
                ->paginate(10);

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
            $validatedData = $request->validate([
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
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

                    if (!$status) {
                        if ($attendance) {
                            $attendance->delete();
                        }
                        continue;
                    }

                    if (!$attendance) {
                        $attendance = new CircleMeetingsAttendances();
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
                    $attendance = new CircleMeetingsAttendances();
                    $attendance->userId = $userId ?? null;
                    $attendance->circleId = $circleId;
                    $attendance->meetingId = $meetingId;
                    $attendance->status = 'Present';
                    $attendance->save();
                }
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

    public function updateStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
                'userId' => 'required|integer|exists:users,id',
                'status' => 'nullable|in:Present,Absent,Late,Medical,Sub',
            ]);

            $circleId = (int) $validatedData['circleId'];
            $meetingId = (int) $validatedData['meetingId'];
            $userId = (int) $validatedData['userId'];
            $status = $validatedData['status'] ?? null;

            $attendance = CircleMeetingsAttendances::where('circleId', $circleId)
                ->where('meetingId', $meetingId)
                ->where('userId', $userId)
                ->first();

            if (!$status) {
                if ($attendance) {
                    $attendance->delete();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Attendance cleared',
                ]);
            }

            if (!$attendance) {
                $attendance = new CircleMeetingsAttendances();
                $attendance->circleId = $circleId;
                $attendance->meetingId = $meetingId;
                $attendance->userId = $userId;
            }

            $attendance->status = $status;
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Attendance saved',
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance',
            ], 500);
        }
    }

    public function updateInvitedStatus(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
                'personName' => 'required|string',
                'status' => 'nullable|in:Present,Absent,Late,Medical,Sub',
                'checked' => 'nullable|boolean',
            ]);

            $circleId = (int) $validatedData['circleId'];
            $meetingId = (int) $validatedData['meetingId'];
            $personName = trim($validatedData['personName']);
            $status = $validatedData['status'] ?? null;
            $checked = array_key_exists('checked', $validatedData) ? (bool) $validatedData['checked'] : null;

            if ($personName === '') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid person name',
                ], 422);
            }

            $attendance = CircleMeetingsAttendances::where('circleId', $circleId)
                ->where('meetingId', $meetingId)
                ->where('name', $personName)
                ->first();

            if ($checked !== null) {
                if (!$checked) {
                    if ($attendance) {
                        $attendance->delete();
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Attendance cleared',
                    ]);
                }

                $status = 'Present';
            }

            if (!$status) {
                if ($attendance) {
                    $attendance->delete();
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Attendance cleared',
                ]);
            }

            if (!$attendance) {
                $attendance = new CircleMeetingsAttendances();
                $attendance->circleId = $circleId;
                $attendance->meetingId = $meetingId;
                $attendance->name = $personName;
            }

            $attendance->status = $status;
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Attendance saved',
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance',
            ], 500);
        }
    }


    public function invitedAttendanceStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
                'attendance' => 'nullable|array',
                'attendance.*.name' => 'nullable|string',
                'attendance.*.status' => 'nullable|in:Present,Absent,Late,Medical,Sub',
                'personName' => 'nullable|array',
                'personName.*' => 'string',
            ]);

            $circleId = (int) $validatedData['circleId'];
            $meetingId = (int) $validatedData['meetingId'];

            $attendanceRows = $request->input('attendance');
            if (is_array($attendanceRows)) {
                foreach ($attendanceRows as $row) {
                    $personName = isset($row['name']) && is_string($row['name']) ? trim($row['name']) : null;
                    $status = isset($row['status']) && is_string($row['status']) ? trim($row['status']) : null;

                    if (!$personName) {
                        continue;
                    }

                    $attendance = CircleMeetingsAttendances::where('circleId', $circleId)
                        ->where('meetingId', $meetingId)
                        ->where('name', $personName)
                        ->first();

                    if (!$status) {
                        if ($attendance) {
                            $attendance->delete();
                        }
                        continue;
                    }

                    if (!$attendance) {
                        $attendance = new CircleMeetingsAttendances();
                        $attendance->circleId = $circleId;
                        $attendance->meetingId = $meetingId;
                        $attendance->name = $personName;
                    }

                    $attendance->status = $status;
                    $attendance->save();
                }
            } else {
                $personNames = $request->input('personName', []);

                foreach ($personNames as $personName) {
                    $personName = is_string($personName) ? trim($personName) : null;
                    if (!$personName) {
                        continue;
                    }

                    $attendance = CircleMeetingsAttendances::where('circleId', $circleId)
                        ->where('meetingId', $meetingId)
                        ->where('name', $personName)
                        ->first();

                    if (!$attendance) {
                        $attendance = new CircleMeetingsAttendances();
                        $attendance->circleId = $circleId;
                        $attendance->meetingId = $meetingId;
                        $attendance->name = $personName;
                    }

                    $attendance->status = 'Present';
                    $attendance->save();
                }
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
