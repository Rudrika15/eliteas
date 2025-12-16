<?php

namespace App\Exports;

use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CircleMemberAggregateExport implements FromCollection, WithHeadings
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

    public function collection()
    {
        if (!$this->circleId) {
            return collect();
        }

        $members = Member::where('status', 'Active')
            ->where('circleId', $this->circleId)
            ->select('id', 'userId', 'firstName', 'lastName', 'circleId')
            ->with('circle:id,circleName')
            ->get();

        return $members->map(function ($m) {
            $uid = $m->userId;

            $ibm = CircleCall::where('status', 'Active')->where('memberId', $uid);
            if ($this->startDate) {
                $ibm->whereDate('created_at', '>=', $this->startDate);
            }
            if ($this->endDate) {
                $ibm->whereDate('created_at', '<=', $this->endDate);
            }
            $ibmCount = $ibm->get()->unique('id')->count();

            $ref = CircleMeetingMembersReference::where('status', 'Active')->where('referenceGiverId', $uid);
            if ($this->startDate) {
                $ref->whereDate('created_at', '>=', $this->startDate);
            }
            if ($this->endDate) {
                $ref->whereDate('created_at', '<=', $this->endDate);
            }
            $refCount = $ref->get()->unique('id')->count();

            $bus = CircleMeetingMembersBusiness::where('status', 'Active')->where('businessGiverId', $uid);
            if ($this->startDate) {
                $bus->whereDate('created_at', '>=', $this->startDate);
            }
            if ($this->endDate) {
                $bus->whereDate('created_at', '<=', $this->endDate);
            }
            $busRows = $bus->get()->unique('id');

            return [
                'Circle' => $m->circle->circleName ?? '-',
                'Member Name' => $m->firstName . ' ' . $m->lastName,
                // 'Member User ID' => $uid,
                'IBM Count' => $ibmCount,
                'Reference Count' => $refCount,
                'Business Count' => $busRows->count(),
                'Business Total Amount' => $busRows->sum('amount'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Circle',
            'Member Name',
            // 'Member User ID',
            'IBM Count',
            'Reference Count',
            'Business Count',
            'Business Total Amount',
        ];
    }
}

