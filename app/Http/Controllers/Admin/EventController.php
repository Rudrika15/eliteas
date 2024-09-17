<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\EventRegister;

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
            $circle = Circle::where('status', 'Active')->get();
            return view('admin.event.create', compact('circle'));
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
            $event = Event::find($id);
            $circle = Circle::where('status', 'Active')->get();
            return view('admin.event.edit', compact('event', 'circle'));
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

    public function eventLink($slug)
    {
        try {
            $event = Event::where('event_slug', $slug)->firstOrFail();
            return view('admin.event.eventLink', compact('event'));
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function storeUserDetails(Request $request)
    {
        try {
            $eventReg = new EventRegister();
            $eventReg->eventId = $request->eventId;
            $eventReg->personName = $request->personName;
            $eventReg->personEmail = $request->personEmail;
            $eventReg->personContact = $request->personContact;
            $eventReg->save();

            return redirect()->back()->with('success', 'Your data is saved successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    // public function checkEmail(Request $request)
    // {
    //     $email = $request->input('personemail');
    //     $eventId = $request->input('eventId');

    //     // Check if the email is already registered for the event
    //     $registered = Eventregister::where('eventId', $eventId)
    //         ->where('personEmail', $email)
    //         ->exists();

    //     return response()->json(['registered' => $registered]);
    // }

    // In EventController.php
    public function checkRegistration(Request $request)
    {
        try {
            $email = $request->input('personEmail');
            $eventId = $request->input('eventId');

            $isRegistered = Eventregister::where('eventId', $eventId)
                ->where('personEmail', $email)
                ->exists();

            return response()->json(['isRegistered' => $isRegistered]);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }


    public function eventRegisterList(Request $request, $id)
    {
        try {
            $event = Event::find($id);
            $registerList = EventRegister::paginate(10);
            return view('admin.event.eventRegistrationList', compact('event', 'registerList'));
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
