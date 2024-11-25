<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Circle;
use App\Models\Member;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\EventRegister;
use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Models\SlotBooking;
use App\Models\VisitorEventRegister;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventController extends Controller
{

    public function __construct()
    {
        // Apply middleware for event-related permissions
        $this->middleware('permission:event-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['delete']]);
        $this->middleware('permission:event-register', ['only' => ['eventRegister', 'storeUserDetails']]);
        $this->middleware('permission:event-view-register-list', ['only' => ['eventRegisterList']]);
        $this->middleware('permission:event-link', ['only' => ['eventLink']]);
    }


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
            $eventType = EventType::where('status', 'Active')->get();
            return view('admin.event.create', compact('circle', 'eventType'));
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
        // return $request;

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
            $event->is_slot = $request->is_slot;
            $event->slot_date = $request->slot_date;

            $uniqueId = time();

            if ($request->hasFile('event_thumb')) {
                $event->event_thumb = $uniqueId . '_thumb.' . $request->event_thumb->extension();
                $request->event_thumb->move(public_path('Event'), $event->event_thumb);
            }

            if ($request->hasFile('event_banner')) {
                $event->event_banner = $uniqueId . '_banner.' . $request->event_banner->extension();
                $request->event_banner->move(public_path('Event'), $event->event_banner);
            }

            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->fees = $request->fees;
            $event->event_details = $request->event_details;

            // Generate QR Code with event details
            $qrData = json_encode([
                'id' => $event->id,
                'title' => $event->title,
                'date' => \Carbon\Carbon::createFromFormat('Y-m-d', $event->event_date)->format('d-m-Y'),
                'venue' => $event->venue ?? 'Not decided yet',
            ]);

            // Define the directory and ensure it exists
            $qrCodeDir = public_path('eventQR');
            if (!file_exists($qrCodeDir)) {
                mkdir($qrCodeDir, 0755, true); // Create directory if it doesn't exist
            }

            // Define the path to save the SVG file
            $qrCodePath = 'eventQR/' . $event->id . '.svg';

            // Generate the SVG content and save it to a file
            $qrSvg = QrCode::format('svg')->size(300)->generate($qrData);
            file_put_contents(public_path($qrCodePath), $qrSvg);

            // Save the QR code path in the database
            $event->qr_code = $qrCodePath;

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
            $eventType = EventType::where('status', 'Active')->get();
            return view('admin.event.edit', compact('event', 'circle', 'eventType'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $this->validate($request, [
            'title' => 'required',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
            // Find the event by ID
            $event = Event::findOrFail($id);

            // Update the event details
            $event->title = $request->title;
            $event->circleId = $request->circleId;
            $event->venue = $request->venue;
            $event->event_date = $request->event_date;
            $event->is_slot = $request->is_slot;
            $event->slot_date = $request->slot_date;

            $uniqueId = time();

            // Check and update the event thumbnail if a new file is uploaded
            if ($request->hasFile('event_thumb')) {
                // Delete old thumbnail if it exists
                if ($event->event_thumb && file_exists(public_path('Event/' . $event->event_thumb))) {
                    unlink(public_path('Event/' . $event->event_thumb));
                }

                $event->event_thumb = $uniqueId . '_thumb.' . $request->event_thumb->extension();
                $request->event_thumb->move(public_path('Event'), $event->event_thumb);
            }

            // Check and update the event banner if a new file is uploaded
            if ($request->hasFile('event_banner')) {
                // Delete old banner if it exists
                if ($event->event_banner && file_exists(public_path('Event/' . $event->event_banner))) {
                    unlink(public_path('Event/' . $event->event_banner));
                }

                $event->event_banner = $uniqueId . '_banner.' . $request->event_banner->extension();
                $request->event_banner->move(public_path('Event'), $event->event_banner);
            }

            // Update the other event details
            $event->start_time = $request->start_time;
            $event->end_time = $request->end_time;
            $event->fees = $request->fees;
            $event->event_details = $request->event_details;

            // Delete the old QR code if it exists
            if ($event->qr_code && file_exists(public_path($event->qr_code))) {
                unlink(public_path($event->qr_code));
            }

            // Generate QR Code with event details
            $qrData = json_encode([
                'id' => $event->id,
                'title' => $event->title,
                'date' => \Carbon\Carbon::createFromFormat('Y-m-d', $event->event_date)->format('d-m-Y'),
                'venue' => $event->venue ?? 'Not decided yet',
            ]);

            // Define the directory and ensure it exists
            $qrCodeDir = public_path('eventQR');
            if (!file_exists($qrCodeDir)) {
                mkdir($qrCodeDir, 0755, true); // Create directory if it doesn't exist
            }

            // Define the path to save the new SVG file
            $qrCodePath = 'eventQR/' . $event->id . '.svg';

            // Generate the SVG content and save it to a file
            $qrSvg = QrCode::format('svg')->size(300)->generate($qrData);
            file_put_contents(public_path($qrCodePath), $qrSvg);

            // Save the new QR code path in the database
            $event->qr_code = $qrCodePath;

            // Update the event status if needed
            $event->status = 'Active';

            // Save the updated event
            $event->save();

            // Redirect with success message
            return redirect()->route('event.edit', $event->id)->with('success', 'Event Updated Successfully!');
        } catch (\Throwable $th) {
            // Log any errors and show a server error page
            ErrorLogger::logError($th, $request->fullUrl());
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
            $eventReg->refMemberId = $request->refMemberId;
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
    public function eventRegister(Request $request)
    {
        try {
            $eventRegister = new EventRegister();
            $eventRegister->eventId = $request->eventId;
            $eventRegister->memberId = Auth::user()->member->id;
            $eventRegister->PaymentStatus = "Event Is Free";
            $eventRegister->save();

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

            $registerList = EventRegister::where('eventId', $id)->paginate(10);
            $registerListVisitor = VisitorEventRegister::where('eventId', $id)->paginate(10);

            $registerLists = $registerList->merge($registerListVisitor);



            return view('admin.event.eventRegistrationList', compact('event', 'registerList', 'registerLists', 'slotBooking'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function slotBookingList(Request $request, $id)
    {
        try {
            $event = Event::find($id);
            $slotBooking = SlotBooking::where('eventId', $id)->paginate(10);
            return view('admin.event.slotBookingList', compact('event', 'slotBooking'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function slotBookingUpdateStatus(Request $request, $id)
    {
        $request->validate([
            'bookingStatus' => 'required|in:Pending,Approved,Rejected',
        ]);

        $slotBooking = SlotBooking::findOrFail($id);
        $slotBooking->bookingStatus = $request->bookingStatus;
        $slotBooking->save();

        return back()->with('success', 'Booking status updated successfully.');
    }
}
