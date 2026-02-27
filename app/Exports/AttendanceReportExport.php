<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendanceReportExport implements FromView
{
    protected $reportData;

    protected $startDate;

    protected $endDate;

    protected $circleName;

    public function __construct($reportData, $startDate, $endDate, $circleName)
    {
        $this->reportData = $reportData;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->circleName = $circleName;
    }

    public function view(): View
    {
        return view('exports.attendanceReport', [
            'reportData' => $this->reportData,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'circleName' => $this->circleName,
        ]);
    }
}
