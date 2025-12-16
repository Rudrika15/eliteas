<?php

namespace App\Exports;

use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CircleMemberDetailExport implements FromView
{
    protected $circleId;
    protected $startDate;
    protected $endDate;

    public function __construct($circleId, $startDate = null, $endDate = null)
    {
        $this->circleId = $circleId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $members = Member::where('status', 'Active')
            ->where('circleId', $this->circleId)
            ->select('id', 'userId', 'firstName', 'lastName')
            ->get();

        $data = $members->map(function ($m) {
            $uid = $m->userId;

            $ibm = CircleCall::with('meetingPersonReport')
                ->where('status', 'Active')
                ->where('memberId', $uid)
                ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
                ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
                ->get()
                ->unique('id');

            $ref = CircleMeetingMembersReference::with('refReceiver')
                ->where('status', 'Active')
                ->where('referenceGiverId', $uid)
                ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
                ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
                ->get()
                ->unique('id');

            $bus = CircleMeetingMembersBusiness::with('loginMember')
                ->where('status', 'Active')
                ->where('businessGiverId', $uid)
                ->when($this->startDate, fn($q) => $q->whereDate('created_at', '>=', $this->startDate))
                ->when($this->endDate, fn($q) => $q->whereDate('created_at', '<=', $this->endDate))
                ->get()
                ->unique('id');

            return [
                'member' => $m,
                'ibm' => $ibm,
                'reference' => $ref,
                'business' => $bus,
            ];
        });

        return view('admin.report.circleMemberDetailExcel', [
            'data' => $data,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
    }
}

