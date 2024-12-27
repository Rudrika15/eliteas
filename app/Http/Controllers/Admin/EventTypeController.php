<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle type-related permissions
        $this->middleware('permission:event-type-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:event-type-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-type-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-type-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        try {
            $eventType = EventType::where('status', 'Active')->paginate(10);
            return view('admin.eventType.index', compact('eventType'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            $eventType = EventType::all();
            return view('admin.eventType.create', compact('eventType'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'eventTypeName' => 'required',
        ]);

        try {
            $eventType = new EventType();
            $eventType->eventTypeName = $request->eventTypeName;
            $eventType->status = 'Active';
            $eventType->save();

            return redirect()->route('eventType.index')->with('success', 'Event Type Created Successfully!');
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
            $eventType = EventType::find($id);
            return view('admin.eventType.edit', compact('eventType'));
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
            'id' => 'required|exists:event_types,id',
            'eventTypeName' => 'required',
        ]);

        try {
            $eventType = EventType::find($request->id);

            if (!$eventType) {
                return redirect()->route('eventType.index')->with('error', 'Circle Type not found.');
            }

            $eventType->eventTypeName = $request->eventTypeName;
            $eventType->status = 'Active';
            $eventType->save();

            return redirect()->route('eventType.index')->with('success', 'Circle Type updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('eventType.index')->with('error', 'Failed to update Circle Type details.');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $eventType = EventType::find($id);

            if (!$eventType) {
                return redirect()->route('eventType.index')->with('error', 'Circle Type not found.');
            }

            $eventType->status = 'Deleted';
            $eventType->save();

            return redirect()->route('eventType.index')->with('success', 'Circle Type deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('eventType.index')->with('error', 'Failed to delete Circle Type.');
        }
    }
}
