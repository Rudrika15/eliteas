<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    private function generatePdf($user)
    {
        return Pdf::loadView('terms.master', [
            'name' => $user->name,
            'date' => now()->format('d-m-Y'),
            'signature' => null
        ]);
    }
}
