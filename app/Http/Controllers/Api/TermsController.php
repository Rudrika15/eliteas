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
        try {
            $user = $request->user();

            $member = Member::where('userId', $user->id)->first();

            if (!$member) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            // ✅ Prevent duplicate
            if ($member->terms_accepted) {
                return response()->json(['message' => 'Already accepted'], 400);
            }

            // ✅ Update
            $member->terms_accepted = 1;
            $member->save();

            // ✅ Data
            $data = [
                'name' => $member->firstName . ' ' . $member->lastName,
                'date' => now()->format('d-m-Y'),
                'signature' => $member->signature
            ];

            // ✅ Generate PDF
            $pdf = Pdf::loadView('pdf.terms', $data)
                ->setPaper('A4', 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true
                ]);

            // ✅ Send Email WITHOUT saving file
           Mail::send([], [], function ($message) use ($user,$pdf) {

                $message->to($user->email)
                    ->subject('Confirmation of Terms & Conditions Acceptance')
                    ->attachData($pdf->output(), 'terms.pdf')
                    ->html('
                    <p>Dear Member,</p>

                    <p>We hope you are doing well.</p>

                    <p>
                        This is to formally acknowledge and confirm that you have read,
                        understood, and accepted the Terms and Conditions associated
                        with <strong>UBN Community</strong>.
                    </p>

                    <p>
                        Your acceptance signifies your agreement to comply with all the
                        guidelines, policies, and operational standards outlined therein.
                    </p>

                    <p>
                        We appreciate your trust and look forward to a successful journey together.
                    </p>

                    <p>
                        Warm regards,<br>
                        <strong>UBN Team</strong>
                    </p>
                ');
            });

            // ✅ OPTIONAL: return PDF in same response (for preview in app)
           return response()->json([
              'success' => true,
              'message' => 'Terms And Conditions Accepted Successfully'
          ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
