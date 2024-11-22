<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegister;
use App\Models\Slot;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class SlotController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle type-related permissions
        $this->middleware('permission:slot-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:slot-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:slot-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:slot-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        try {
            $slot = Slot::where('status', 'Active')->paginate(10);
            return view('admin.slot.index', compact('slot'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function userListView(Request $request, $id)
    {
        try {

            $event = Event::findOrFail($id);
            $users = EventRegister::where('eventId', $id)
                ->where('status', 'Active')
                ->get();

            $slots = Slot::where('status', 'Active')->get();

            if ($users->isEmpty()) {
                return redirect()->back()->with('message', 'No active users found for this event.');
            }

            return view('admin.slot.viewMembers', compact('users', 'event', 'slots'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function userListViewforVisitors(Request $request, $id)
    {
        try {

            $event = Event::findOrFail($id);
            $users = EventRegister::where('eventId', $id)
                ->where('status', 'Active')
                ->get();

            $slots = Slot::where('status', 'Active')->get();

            if ($users->isEmpty()) {
                return redirect()->back()->with('message', 'No active users found for this event.');
            }

            return view('admin.slot.viewMembersForVisitors', compact('users', 'event', 'slots'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }


    public function create(Request $request)
    {
        try {
            return view('admin.slot.create');
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
            $slot = new Slot();
            $slot->start_time = $request->start_time;
            $slot->end_time = $request->end_time;
            $slot->save();

            return redirect()->route('slot.index')->with('success', 'Event Type Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $slot = Slot::find($id);
            return view('admin.slot.edit', compact('slot'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:slots,id',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
            $slot = Slot::find($request->id);

            if (!$slot) {
                return redirect()->route('slot.index')->with('error', 'Slot not found.');
            }

            $slot->start_time = $request->start_time;
            $slot->end_time = $request->end_time;
            $slot->status = 'Active';
            $slot->save();

            return redirect()->route('slot.index')->with('success', 'Slot updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('slot.index')->with('error', 'Failed to update Slot details.');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $slot = Slot::find($id);

            if (!$slot) {
                return redirect()->route('slot.index')->with('error', 'Slot not found.');
            }

            $slot->status = 'Deleted';
            $slot->save();

            return redirect()->route('slot.index')->with('success', 'Slot deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('slot.index')->with('error', 'Failed to delete Slot.');
        }
    }
}
