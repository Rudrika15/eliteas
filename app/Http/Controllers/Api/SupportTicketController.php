<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SupportTicketNotification;
use App\Models\SupportTicket;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        try {
            $tickets = SupportTicket::where('userId', Auth::id())
                ->orderByDesc('created_at')
                ->get();

            return Utils::sendResponse($tickets, 'Support tickets retrieved successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return Utils::errorResponses($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'priority' => 'required|in:Low,Medium,High',
            'attachment' => 'nullable|file|max:5120',
        ]);

        if ($validator->fails()) {
            return Utils::sendResponse(['errors' => $validator->errors()], 'Validation Error');
        }

        try {
            $ticket = new SupportTicket;
            $ticket->userId = Auth::id();
            $ticket->subject = $request->subject;
            $ticket->description = $request->description;
            $ticket->priority = 'Low';
            $ticket->status = 'Open';

            if ($request->hasFile('attachment')) {
                $dir = public_path('support_attachments');
                if (! is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $fileName = time().'_'.$request->attachment->getClientOriginalName();
                $request->attachment->move($dir, $fileName);
                $ticket->attachment = $fileName;
            }

            $ticket->save();

            // // Send email to admins
            // $adminEmails = \App\Models\User::whereHas('roles', function ($q) {
            //     $q->where('name', 'Admin');
            // })->pluck('email');

            // if ($adminEmails->isNotEmpty()) {
            //     Mail::to($adminEmails)->queue(new SupportTicketNotification($ticket));
            // }

            // Send email to specific email ID
            $adminEmail = 'care.ubncommunity@gmail.com';

            Mail::to($adminEmail)->queue(new SupportTicketNotification($ticket));

            return Utils::sendResponse($ticket, 'Ticket created successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return Utils::errorResponses($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function show($id)
    {
        try {
            $ticket = SupportTicket::where('id', $id)->where('userId', Auth::id())->first();

            if (! $ticket) {
                return Utils::errorResponses('Ticket not found or unauthorized access', 'Ticket not found', 404);
            }

            return Utils::sendResponse($ticket, 'Ticket retrieved successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return Utils::errorResponses($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'priority' => 'required|in:Low,Medium,High',
            // 'status' => 'required|in:Open,In Progress,Closed',
            'attachment' => 'nullable|file|max:5120',
        ]);

        if ($validator->fails()) {
            return Utils::sendResponse(['errors' => $validator->errors()], 'Validation Error');
        }

        try {
            $ticket = SupportTicket::where('id', $id)->where('userId', Auth::id())->first();

            if (! $ticket) {
                return Utils::errorResponses('Ticket not found or unauthorized access', 'Ticket not found', 404);
            }

            $ticket->subject = $request->subject;
            $ticket->description = $request->description;
            $ticket->priority = 'Low';
            $ticket->status = 'Open';

            if ($request->hasFile('attachment')) {
                $dir = public_path('support_attachments');
                if (! is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $fileName = time().'_'.$request->attachment->getClientOriginalName();
                $request->attachment->move($dir, $fileName);
                $ticket->attachment = $fileName;
            }

            $ticket->save();

            return Utils::sendResponse($ticket, 'Ticket updated successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return Utils::errorResponses($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
