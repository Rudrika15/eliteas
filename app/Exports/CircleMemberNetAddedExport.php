<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CircleMemberNetAddedExport implements FromArray, WithStrictNullComparison
{
    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function array(): array
    {
        $data = [];

        // Header
        $data[] = [
            'Circle Name',
            'Last Month Members',
            'Current Month Added',
            'Current Month Deleted',
            'Net Change'
        ];

        foreach ($this->report as $row) {

            $data[] = [
                $row['circleName'] ?? '-',
                $row['last_month_members'] ?? 0,
                $row['current_added'] ?? 0,
                $row['current_deleted'] ?? 0,
                $row['net_change'] ?? 0,
            ];
        }

        return $data;
    }
}
