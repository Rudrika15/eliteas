<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\CircleMeetingsAttendances;
use App\Models\MeetingInvitation;
use App\Models\Schedule;
use App\Models\Testimonial;
use App\Models\TrainingRegister;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct()
    {
        // Applying middleware based on specific methods for attendance management
        $this->middleware('permission:attendance-take|attendance-list|attendance-create|attendance-edit', ['only' => ['takeAttendance', 'lockMeeting']]);
        $this->middleware('permission:invited-attendance-take|invited-attendance-list|invited-attendance-create|invited-attendance-edit', ['only' => ['invitedAttendance']]);
        $this->middleware('permission:meeting-schedule-view|meeting-schedule-list', ['only' => ['meetingSchedules']]);
        $this->middleware('permission:attendance-list-view', ['only' => ['attendanceList']]);
        $this->middleware('permission:attendance-store|attendance-store-create', ['only' => ['attendanceStore', 'updateStatus']]);
        $this->middleware('permission:attendance-invite-store|attendance-invite-create', ['only' => ['invitedAttendanceStore', 'updateInvitedStatus']]);
    }

    public function lockMeeting(Request $request)
    {
        try {
            $schedule = Schedule::findOrFail($request->id);
            $schedule->is_locked = ! $schedule->is_locked;
            $schedule->save();

            return redirect()->back()->with('success', 'Meeting lock status updated.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }

    public function takeAttendance(Request $request)
    {
        try {
            $user = auth()->user();

            // $circleMembers = $user->member->circle->members;
            $circleMembers = $user->member->circle->members()->where('status', 'Active')->get();
            $circleUserIds = $circleMembers->pluck('userId')->toArray();

            $meetingId = $request->id;

            $currentSchedule = Schedule::find($meetingId);
            $circleId = $currentSchedule->circleId;

            // Calculate date range (Last Meeting to Current Meeting)
            $previousSchedule = Schedule::where('circleId', $circleId)
                ->where('date', '<', $currentSchedule->date)
                ->orderBy('date', 'desc')
                ->first();

            $endDate = Carbon::parse($currentSchedule->date)->endOfDay();
            $startDate = $previousSchedule
                ? Carbon::parse($previousSchedule->date)->addDay()->startOfDay()
                : Carbon::parse($currentSchedule->date)->subDays(15)->startOfDay();

            $lastMeetingId = $previousSchedule ? $previousSchedule->id : null;

            // Calculate stats for each member
            $memberStats = [];
            foreach ($circleMembers as $member) {
                $uid = $member->userId;

                // IBM (1-2-1) Count
                $ibmCount = CircleCall::where('status', 'active')
                    ->where(function ($q) use ($uid) {
                        $q->where('memberId', $uid)
                            ->orWhere('meetingPersonId', $uid);
                    })
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                // Ref Given Inside
                $refGivenInside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('referenceGiverId', $uid)
                    ->whereIn('memberId', $circleUserIds)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                // Ref Given Outside
                $refGivenOutside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('referenceGiverId', $uid)
                    ->whereNotIn('memberId', $circleUserIds)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                // Ref Received Inside
                $refReceivedInside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('memberId', $uid)
                    ->whereIn('referenceGiverId', $circleUserIds)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                // Ref Received Outside
                $refReceivedOutside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('memberId', $uid)
                    ->whereNotIn('referenceGiverId', $circleUserIds)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                // Business Given
                $businessGiven = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->where('businessGiverId', $uid)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->sum('amount');

                // Business Received
                $businessReceived = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->where('loginMemberId', $uid)
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->sum('amount');

                // Training
                $trainingCount = TrainingRegister::where('userId', $uid)
                    ->where('status', 'Active')
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                // Testimonial Given
                $testimonialGiven = Testimonial::where('userId', $uid)
                    ->where('status', 'Active')
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                $testimonialReceived = Testimonial::where('memberId', $uid)
                    ->where('status', 'Active')
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();

                $currentStatus = CircleMeetingsAttendances::where('meetingId', $meetingId)
                    ->where('circleId', $circleId)
                    ->where('userId', $uid)
                    ->value('status');

                $lastStatus = 'N/A';
                if ($lastMeetingId) {
                    $att = CircleMeetingsAttendances::where('meetingId', $lastMeetingId)
                        ->where('userId', $uid)
                        ->first();
                    $lastStatus = $att ? $att->status : '-';
                }

                $memberStats[$uid] = [
                    'ibm' => $ibmCount,
                    'ref_given_inside' => $refGivenInside,
                    'ref_given_outside' => $refGivenOutside,
                    'ref_received_inside' => $refReceivedInside,
                    'ref_received_outside' => $refReceivedOutside,
                    'business_given' => $businessGiven,
                    'business_received' => $businessReceived,
                    'training' => $trainingCount,
                    'testimonial_given' => $testimonialGiven,
                    'testimonial_received' => $testimonialReceived,
                    'present' => $currentStatus === 'Present' ? 'Y' : '-',
                    'absent' => $currentStatus === 'Absent' ? 'Y' : '-',
                    'late' => $currentStatus === 'Late' ? 'Y' : '-',
                    'medical' => $currentStatus === 'Medical' ? 'Y' : '-',
                    'substitute' => $currentStatus === 'Sub' ? 'Y' : '-',
                    'last_att' => $lastStatus,
                ];
            }

            $meetingInvitations = MeetingInvitation::where('meetingId', $meetingId)
                ->get();

            return view('admin.attendance.index', compact('circleMembers', 'meetingInvitations', 'meetingId', 'circleId', 'memberStats', 'currentSchedule'));
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
                ->where('status', 'Active')
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
            ]);

            $circleId = (int) $validatedData['circleId'];
            $meetingId = (int) $validatedData['meetingId'];

            // Loop through the attendance data and save each record
            if (isset($validatedData['attendance'])) {
                foreach ($validatedData['attendance'] as $userId => $status) {
                    CircleMeetingsAttendances::updateOrCreate(
                        [
                            'circleId' => $circleId,
                            'meetingId' => $meetingId,
                            'userId' => $userId,
                        ],
                        [
                            'status' => $status,
                        ]
                    );
                }
            }

            return redirect()->route('attendance.takeAttendance', ['id' => $meetingId])->with('success', 'Attendance recorded successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|in:Present,Absent,Late,Medical,Sub',
            ]);

            // Find the attendance record
            $attendance = CircleMeetingsAttendances::findOrFail($id);

            // Update the status
            $attendance->status = $request->status;
            $attendance->save();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Attendance status updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function invitedAttendanceStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'circleId' => 'required|integer|exists:circles,id',
                'meetingId' => 'required|integer|exists:schedules,id',
                'attendance' => 'nullable|array',
                'attendance.*' => 'nullable|in:Present,Absent,Late,Medical,Sub',
                'userId' => 'nullable|array',
                'userId.*' => 'integer|exists:meeting_invitations,id',
            ]);

            $circleId = (int) $validatedData['circleId'];
            $meetingId = (int) $validatedData['meetingId'];

            // Loop through the attendance data and save each record
            if (isset($validatedData['attendance'])) {
                foreach ($validatedData['attendance'] as $index => $status) {
                    $userId = $validatedData['userId'][$index];

                    MeetingInvitation::updateOrCreate(
                        [
                            // 'circleId' => $circleId,
                            'meetingId' => $meetingId,
                            'id' => $userId,
                        ],
                        [
                            'attendance_status' => $status,
                        ]
                    );
                }
            }

            return redirect()->route('attendance.attendanceList')->with('success', 'Attendance recorded successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function updateInvitedStatus(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'status' => 'required|in:Present,Absent,Late,Medical,Sub',
            ]);

            // Find the attendance record
            $attendance = MeetingInvitation::findOrFail($id);

            // Update the status
            $attendance->attendance_status = $request->status;
            $attendance->save();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Attendance status updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }
}
