<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    // ✅ Get Terms Data (Preview for App)
    public function preview(Request $request)
    {
        $user = $request->user();
        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        return response()->json([
            'name' => $member->firstName . ' ' . $member->lastName,
            'date' => now()->format('d-m-Y'),
            'signature' => $member->signature
        ]);
    }

    // ✅ Download PDF (API)
    public function download(Request $request)
    {
        $user = $request->user();
        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $data = [
            'name' => $member->firstName . ' ' . $member->lastName,
            'date' => now()->format('d-m-Y'),
            'signature' => $member->signature
        ];

        $pdf = Pdf::loadView('pdf.terms', $data);

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="terms.pdf"');
    }

    // ✅ Accept Terms (API)
    public function accept(Request $request)
    {
        $user = $request->user();
        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->terms_accepted = 1;
        $member->save();

        $data = [
            'name' => $member->firstName . ' ' . $member->lastName,
            'date' => now()->format('d-m-Y'),
            'signature' => $member->signature
        ];

        $pdf = Pdf::loadView('pdf.terms', $data)->setPaper('A4', 'portrait');

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        $fileName = 'terms_' . $user->id . '.pdf';
        $filePath = public_path('pdfs/' . $fileName);

        file_put_contents($filePath, $pdf->output());

        // 📧 Send Mail
        Mail::raw('Terms Accepted', function ($message) use ($user, $filePath) {
            $message->to($user->email)
                ->subject('Terms Accepted')
                ->attach($filePath);
        });

        return response()->json([
            'message' => 'Terms accepted successfully',
            'pdf_url' => asset('pdfs/' . $fileName)
        ]);
    }
}
