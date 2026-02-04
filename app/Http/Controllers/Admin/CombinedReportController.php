<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Circle;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersReference;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\TrainingRegister;
use App\Models\Testimonial;
use App\Models\CircleMeetingsAttendances;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CircleAttendanceCombinedExport;

class CombinedReportController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $authMember = Member::where('userId', $user->id)->first();

        $circleId = $authMember ? $authMember->circleId : null;
        $circleName = '';
        if ($circleId) {
            $circle = Circle::find($circleId);
            $circleName = $circle ? $circle->circleName : '';
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $circleActivityData = collect();
        $attendanceData = collect();

        if ($circleId) {
            $members = Member::where('circleId', $circleId)
                ->where('status', 'Active')
                ->get();

            $circleUserIds = $members->pluck('userId')->toArray();

            foreach ($members as $member) {
                $uid = $member->userId;

                $ibmCount = CircleCall::where('status', 'Active')
                    ->where(function ($q) use ($uid) {
                        $q->where('memberId', $uid)
                            ->orWhere('meetingPersonId', $uid);
                    })
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $refGivenInside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('referenceGiverId', $uid)
                    ->whereIn('memberId', $circleUserIds)
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $refGivenOutside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('referenceGiverId', $uid)
                    ->whereNotIn('memberId', $circleUserIds)
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $refReceivedInside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('memberId', $uid)
                    ->whereIn('referenceGiverId', $circleUserIds)
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $refReceivedOutside = CircleMeetingMembersReference::where('status', 'Active')
                    ->where('memberId', $uid)
                    ->whereNotIn('referenceGiverId', $circleUserIds)
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $businessGiven = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->where('businessGiverId', $uid)
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->sum('amount');

                $businessReceived = CircleMeetingMembersBusiness::where('status', 'Active')
                    ->where('loginMemberId', $uid)
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->sum('amount');

                $trainingCount = TrainingRegister::where('userId', $uid)
                    ->where('status', 'Active')
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $testimonialGiven = Testimonial::where('userId', $uid)
                    ->where('status', 'Active')
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $testimonialReceived = Testimonial::where('memberId', $uid)
                    ->where('status', 'Active')
                    ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
                    ->count();

                $circleActivityData->push([
                    'member_name' => $member->firstName . ' ' . $member->lastName,
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
                ]);

                $stats = CircleMeetingsAttendances::where('userId', $member->userId)
                    ->where('circle_meetings_attendances.circleId', $circleId)
                    ->join('schedules', 'circle_meetings_attendances.meetingId', '=', 'schedules.id')
                    ->when($startDate, fn($q) => $q->whereDate('schedules.date', '>=', $startDate))
                    ->when($endDate, fn($q) => $q->whereDate('schedules.date', '<=', $endDate))
                    ->selectRaw("
                        SUM(CASE WHEN circle_meetings_attendances.status = 'Present' THEN 1 ELSE 0 END) as present_count,
                        SUM(CASE WHEN circle_meetings_attendances.status = 'Absent' THEN 1 ELSE 0 END) as absent_count,
                        SUM(CASE WHEN circle_meetings_attendances.status = 'Late' THEN 1 ELSE 0 END) as late_count,
                        SUM(CASE WHEN circle_meetings_attendances.status = 'Medical' THEN 1 ELSE 0 END) as medical_count,
                        SUM(CASE WHEN circle_meetings_attendances.status = 'Sub' THEN 1 ELSE 0 END) as sub_count
                    ")
                    ->first();

                $attendanceData->push([
                    'circle_name' => $circleName,
                    'member_name' => $member->firstName . ' ' . $member->lastName,
                    'present' => $stats->present_count ?? 0,
                    'absent' => $stats->absent_count ?? 0,
                    'late' => $stats->late_count ?? 0,
                    'medical' => $stats->medical_count ?? 0,
                    'substitute' => $stats->sub_count ?? 0,
                ]);
            }
        }

        if ($request->has('export')) {
            return Excel::download(
                new CircleAttendanceCombinedExport($circleActivityData, $attendanceData, $startDate, $endDate, $circleName),
                'circle_attendance_report.xlsx'
            );
        }

        return view('admin.report.circleAttendanceCombined', [
            'circleActivityData' => $circleActivityData,
            'attendanceData' => $attendanceData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
