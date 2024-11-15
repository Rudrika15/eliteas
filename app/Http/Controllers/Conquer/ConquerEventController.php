<?php

namespace App\Http\Controllers\Conquer;

use App\Http\Controllers\Controller;
use App\Models\ConquerEvent;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class ConquerEventController extends Controller
{

    // public function __construct()
    // {
    //     // Apply middleware for city-related permissions
    //     $this->middleware('permission:con-event-index', ['only' => ['index', 'view']]);
    //     $this->middleware('permission:con-event-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:con-event-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:con-event-delete', ['only' => ['delete']]);
    // }


    public function index(Request $request)
    {
        try {
            $event = ConquerEvent::where('status', 'Active')->orderBy('id', 'DESC')->paginate(10);
            return view('conquer.events.index', compact('event'));
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
            return view('conquer.events.create');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        try {
            $event = new ConquerEvent();
            $event->title = $request->title;

            if ($request->eventImage) {
                $event->eventImage = time() . '.' . $request->eventImage->extension();
                $request->eventImage->move(public_path('conEventImage'), $event->eventImage);
            }

            $event->event_date = $request->event_date;
            $event->event_details = $request->event_details;
            $event->ubn_fees = $request->ubn_fees;
            $event->outsiders_fees = $request->outsiders_fees;
            $event->slot_date = $request->slot_date;
            $event->venue = $request->venue;
            $event->status = 'Active';
            $event->save();

            return redirect()->route('conquer.events.index')->with('success', 'Event Created Successfully!');
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
            $event = ConquerEvent::find($id);
            return view('conquer.events.edit', compact('event'));
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
        // return $request;

        try {
            $id = $request->id;
            $event = ConquerEvent::find($id);
            if ($event) {
                $event->title = $request->title;

                if ($request->eventImage) {
                    $event->eventImage = time() . '.' . $request->eventImage->extension();
                    $request->eventImage->move(public_path('conEventImage'), $event->eventImage);
                }


                $event->event_date = $request->event_date;
                $event->event_details = $request->event_details;
                $event->ubn_fees = $request->ubn_fees;
                $event->outsiders_fees = $request->outsiders_fees;
                $event->slot_date = $request->slot_date;
                $event->venue = $request->venue;
                $event->status = 'Active';
                $event->save();

                return redirect()->route('conquer.events.index')->with('success', 'Event Updated Successfully!');
            } else {
                return back()->with('error', 'Event Not Found!');
            }
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    function delete(Request $request, $id)
    {
        try {
            $event = ConquerEvent::find($id);
            $event->status = "Deleted";
            $event->save();
            return redirect()->route('conquer.events.index')->with('success', 'Event Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
}
