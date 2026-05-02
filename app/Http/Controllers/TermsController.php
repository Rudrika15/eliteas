<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    // ✅ Preview PDF
    public function preview()
    {
        $user = auth()->user();
        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            abort(404, 'Member not found');
        }

        $data = [
            'name' => $member->firstName . ' ' . $member->lastName,
            'date' => now()->format('d-m-Y'),
            'signature' => $member->signature ?? null
        ];

        return view('terms.preview', $data);
    }
    public function download()
    {
        $user = auth()->user();
        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            abort(404, 'Member not found');
        }

        $data = [
            'name' => $member->firstName . ' ' . $member->lastName,
            'date' => now()->format('d-m-Y'),
            'signature' => $member->signature ?? null
        ];

        $pdf = Pdf::loadView('pdf.terms', $data);

        return $pdf->stream('terms.pdf'); // 👈 THIS is used in iframe
    }

    public function accept()
    {
        $user = auth()->user();
        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            abort(404, 'Member not found');
        }

        $member->terms_accepted = 1;
        $member->save();


        $data = [
            'name' => $member->firstName . ' ' . $member->lastName,
            'date' => now()->format('d-m-Y'),
            'signature' => $member->signature ?? null
        ];

        $pdf = Pdf::loadView('pdf.terms', $data)->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);


        $fileName = 'terms' . '.pdf';
        $filePath = public_path('pdfs/' . $fileName);

        file_put_contents($filePath, $pdf->output());

        Mail::send('emails.terms', [], function ($message) use ($user, $filePath) {
            $message->to($user->email)
                ->subject('Confirmation of Terms & Conditions Acceptance')
                ->attach($filePath);
        });


        return redirect()->route('home')->with('success', 'Accepted!');
    }
}
