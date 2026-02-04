<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CircleAttendanceCombinedExport implements FromView
{
    protected $circleActivityData;
    protected $attendanceData;
    protected $startDate;
    protected $endDate;
    protected $circleName;

    public function __construct($circleActivityData, $attendanceData, $startDate, $endDate, $circleName)
    {
        $this->circleActivityData = $circleActivityData;
        $this->attendanceData = $attendanceData;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->circleName = $circleName;
    }

    public function view(): View
    {
        return view('exports.circleAttendanceCombined', [
            'activityReportData' => $this->circleActivityData,
            'attendanceReportData' => $this->attendanceData,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'circleName' => $this->circleName
        ]);
    }
}
