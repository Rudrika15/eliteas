<?php

namespace App\Exports;

use App\Models\Circle;
use App\Models\Member;
use App\Models\MemberSubscriptions;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RenewalMembersExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $circleId;

    public function __construct($startDate = null, $endDate = null, $circleId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->circleId = $circleId;
    }

    public function collection()
    {
        // Base query for active members
        $query = Member::query()->where('status', 'Active');

        // Apply circle filter if provided
        if ($this->circleId) {
            $query->where('circleId', $this->circleId);
        }

        // Apply date filters if provided
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        // Fetch members with circle
        $members = $query->with('circle')->get();

        // Fetch subscriptions
        $subscriptionsByUserId = MemberSubscriptions::whereIn(
            'userId',
            $members->pluck('userId')->filter()->unique()->values()
        )
            ->get()
            ->keyBy('userId');

        // Map data for export
        return $members->map(function ($member) use ($subscriptionsByUserId) {
            $validityRaw = optional($subscriptionsByUserId->get($member->userId))->validity;
            $validityDate = null;

            if ($validityRaw) {
                try {
                    $validityDate = preg_match('/^\d{2}-\d{2}-\d{4}$/', $validityRaw)
                        ? Carbon::createFromFormat('d-m-Y', $validityRaw)
                        : Carbon::parse($validityRaw);
                } catch (\Throwable $th) {
                    $validityDate = null;
                }
            }

            return [
                'Circle Name' => $member->circle ? $member->circle->circleName : 'Unknown Circle',
                'Member Name' => $member->firstName . ' ' . $member->lastName,
                'Joining Date' => $member->created_at->format('d-m-Y'),
                'Renewal Date' => $validityDate ? $validityDate->format('d-m-Y') : '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Circle Name',
            'Member Name',
            'Joining Date',
            'Renewal Date',
        ];
    }
}
