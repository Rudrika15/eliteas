<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VisitorsExport implements FromView
{
    protected $visitors;

    public function __construct($visitors)
    {
        $this->visitors = $visitors;
    }

    public function view(): View
    {
        return view('exports.visitors', [
            'visitors' => $this->visitors,
        ]);
    }
}
