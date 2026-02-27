<?php

namespace App\Exports;

use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ReportController;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromView;

class CircleVPReportExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        // Call the same logic from ReportController but reuse data only
        $controller = app(AdminReportController::class);
        $response = $controller->vpReport($this->request);

        // Extract variables passed to blade
        $data = $response->getData();

        // Return a simple table view for Excel
        return view('exports.vpReport', (array) $data);
    }
}
