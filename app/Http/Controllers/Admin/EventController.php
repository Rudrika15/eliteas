<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Circle;

class EventController extends Controller
{
    public function index(Request $request)
    {
        try {
            $event = Event::with('circle')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('admin.event.index', compact('event'));
        } catch (\Throwable $th) {
            throw $th;
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
            $circle = Circle::where('status', 'Active')->get();
            return view('admin.event.create', compact('circle'));
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
        try {
            $event = new Event();
            $event->title = $request->title;
            $event->circleId = $request->circleId;
            $event->venue = $request->venue;
            $event->event_date = $request->event_date;
            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->amount = $request->amount;
            $event->status = 'Active';

            $event->save();

            return redirect()->route('event.create')->with('success', 'Event Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
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
            $event = Event::find($id);
            $circle = Circle::where('status', 'Active')->get();
            return view('admin.event.edit', compact('event', 'circle'));
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        try {
            $id = $request->id;
            $event = Event::find($id);
            if ($event) {
                $event->title = $request->title;
                $event->circleId = $request->circleId;
                $event->venue = $request->venue;
                $event->event_date = $request->event_date;
                $event->start_time = $request->start_time;
                $event->end_time = $request->end_time;
                $event->amount = $request->amount;
                $event->status = 'Active';

                $event->save();

                return redirect()->route('event.index')->with('success', 'Event Updated Successfully!');
            } else {
                return back()->with('error', 'Event Not Found!');
            }
        } catch (\Throwable $th) {
            throw $th;
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
            $event = Event::find($id);
            $event->status = "Deleted";
            $event->save();
            return redirect()->route('event.index')->with('success', 'Event Deleted Successfully!');
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
