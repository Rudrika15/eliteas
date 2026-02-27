<?php

namespace App\Exports;

use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MemberReportExport implements FromView
{
    protected $memberId;

    protected $startDate;

    protected $endDate;

    public function __construct($memberId, $startDate = null, $endDate = null)
    {
        $this->memberId = $memberId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $member = User::find($this->memberId);

        $startDate = $this->startDate;
        $endDate = $this->endDate;

        $circleCall = CircleCall::with(['meetingPersonReport', 'member'])
            ->where('status', 'Active')
            ->where(function ($q) {
                $q->where('memberId', $this->memberId)
                    ->orWhere('meetingPersonId', $this->memberId);
            })
            ->when($this->startDate, fn ($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn ($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->get()
            ->map(function ($call) {
                if ($call->meetingPersonId == $this->memberId) {
                    $call->setRelation('meetingPersonReport', $call->member);
                }

                return $call;
            });

        $business = CircleMeetingMembersBusiness::with('loginMember')
            ->where('status', 'Active')
            ->where('businessGiverId', $this->memberId)
            ->when($this->startDate, fn ($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn ($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->get();

        $reference = CircleMeetingMembersReference::with('refReceiver')
            ->where('status', 'Active')
            ->where('referenceGiverId', $this->memberId)
            ->when($this->startDate, fn ($q) => $q->whereDate('created_at', '>=', $this->startDate))
            ->when($this->endDate, fn ($q) => $q->whereDate('created_at', '<=', $this->endDate))
            ->get();

        return view('admin.report.memberReportExcel', [
            'member' => $member,
            'circleCall' => $circleCall,
            'business' => $business,
            'reference' => $reference,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
