<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.create');
            }
            $tickets = SupportTicket::orderByDesc('created_at')->paginate(10);
            return view('admin.support.index', compact('tickets'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.index');
            }
            return view('admin.support.create');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function myIndex(Request $request)
    {
        try {
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.index');
            }
            $tickets = SupportTicket::where('userId', Auth::id())->orderByDesc('created_at')->paginate(10);
            return view('admin.support.memberIndex', compact('tickets'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {


        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'priority' => 'required|in:Low,Medium,High',
            'attachment' => 'nullable|file|max:5120',
        ]);

        try {
            $ticket = new SupportTicket();
            $ticket->userId = Auth::id();
            $ticket->subject = $request->subject;
            $ticket->description = $request->description;
            $ticket->priority = $request->priority;
            $ticket->status = 'Open';

            if ($request->hasFile('attachment')) {
                $dir = public_path('support_attachments');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $fileName = time() . '_' . $request->attachment->getClientOriginalName();
                $request->attachment->move($dir, $fileName);
                $ticket->attachment = $fileName;
            }

            $ticket->save();

            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.index')->with('success', 'Ticket created successfully');
            }
            return redirect()->route('support.myIndex')->with('success', 'Ticket created successfully');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.index');
            }
            $ticket = SupportTicket::findOrFail($id);
            if ($ticket->userId !== Auth::id()) {
                return redirect()->route('support.create');
            }
            return view('admin.support.edit', compact('ticket'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Medium,High',
            'status' => 'required|in:Open,In Progress,Closed',
            'attachment' => 'nullable|file|max:5120',
        ]);

        try {
            $ticket = SupportTicket::findOrFail($id);
            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.index');
            }
            if ($ticket->userId !== Auth::id()) {
                return redirect()->route('support.create');
            }
            $ticket->subject = $request->subject;
            $ticket->description = $request->description;
            $ticket->priority = $request->priority;
            $ticket->status = $request->status;

            if ($request->hasFile('attachment')) {
                $dir = public_path('support_attachments');
                if (!is_dir($dir)) {
                    @mkdir($dir, 0775, true);
                }
                $fileName = time() . '_' . $request->attachment->getClientOriginalName();
                $request->attachment->move($dir, $fileName);
                $ticket->attachment = $fileName;
            }

            $ticket->save();

            if (Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.index')->with('success', 'Ticket updated successfully');
            }
            return redirect()->route('support.myIndex')->with('success', 'Ticket updated successfully');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function delete($id)
    {
        try {
            if (!Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.create');
            }
            $ticket = SupportTicket::findOrFail($id);
            $ticket->delete();
            return redirect()->route('support.index')->with('success', 'Ticket deleted successfully');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function adminUpdateStatus(Request $request)
    {
        try {
            if (!Auth::user()->hasRole('Admin')) {
                return redirect()->route('support.create');
            }
            $request->validate([
                'id' => 'required|integer|exists:support_tickets,id',
                'status' => 'required|in:Open,In Progress,Closed',
            ]);
            $ticket = SupportTicket::findOrFail($request->id);
            $ticket->status = $request->status;
            $ticket->save();
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'status' => $ticket->status]);
            }
            return redirect()->route('support.index')->with('success', 'Status updated');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false], 500);
            }
            return view('servererror');
        }
    }
}
