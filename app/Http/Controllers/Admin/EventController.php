<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Notifications;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\EventRegister;
use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Models\SlotBooking;
use App\Models\User;
use App\Models\VisitorEventRegister;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class EventController extends Controller
{

    public function __construct()
    {
        // Apply middleware for event-related permissions
        $this->middleware('permission:event-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:event-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:event-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:event-delete', ['only' => ['delete']]);
        // $this->middleware('permission:event-register', ['only' => ['eventRegister', 'storeUserDetails']]);
        $this->middleware('permission:event-view-register-list', ['only' => ['eventRegisterList']]);
        // $this->middleware('permission:event-link', ['only' => ['eventLink']]);
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
    public function eventIndex(Request $request)
    {
        try {
            $event = Event::with('circle')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('visitor.visitorEventIndex', compact('event'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function eventDetails($id)
    {
        $event = Event::findOrFail($id);

        $totalRegisterCount = VisitorEventRegister::where('eventId', $id)->count()
            + EventRegister::where('eventId', $id)->count();

        $findEventRegister = EventRegister::where('memberId', Auth::user()->member->id)
            ->where('eventId', $event->id)
            ->get();

        return view('admin.event.eventDetails', compact('event', 'totalRegisterCount', 'findEventRegister'));
    }


    public function memberEventIndex(Request $request)
    {
        try {
            $event = Event::with('circle')
                ->where('status', 'Active')
                ->whereDate('event_date', '>=', Carbon::today())
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('admin.event.memberEventIndex', compact('event'));
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
            $event->visitorFees = $request->visitorFees;
            $event->event_details = $request->event_details;
            $event->save();

            $event = Event::find($event->id);

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



            $event->qr_code = $qrCodePath;
            $event->eventStatus = 'Draft';
            $event->status = 'Active';
            $event->save();

            return redirect()->route('event.index')->with('success', 'Event Created Successfully!');
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

    public function update(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'title' => 'required',
            'event_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {

            $id = $request->id;
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
            $event->visitorFees = $request->visitorFees;
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
            // $event->eventStatus = 'Draft';
            $event->status = 'Active';
            $event->save();

            // Redirect with success message
            return redirect()->route('event.index')->with('success', 'Event Updated Successfully!');
        } catch (\Throwable $th) {
            // Log any errors and show a server error page
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    //     public function updateStatus(Request $request, $id)
    // {
    //     $event = Event::find($id);

    //     if ($event) {
    //         $event->eventStatus = $request->eventStatus;
    //         $event->save();

    //         return response()->json(['success' => true]);
    //     }

    //     return response()->json(['success' => false]);
    // }

    public function updateStatus(Request $request, $id)
    {
        $event = Event::find($id);

        if ($event) {
            $event->eventStatus = $request->eventStatus;
            $event->save();

            // Check if eventStatus is changed to "Publish"
            if ($request->eventStatus === 'Publish') {
                // Prepare notification details
                $title = "New Event Published";
                $body = "The event '{$event->title}' has been published. Don't miss it!";

                // Store notification in the database
                $notification = new Notifications();
                $notification->title = $title;
                $notification->body = $body;
                $notification->data = json_encode([
                    'event_id' => $event->id,
                    'event_title' => $event->title,
                ]);
                $notification->save();

                // Send notifications to all users
                $users = User::whereNotNull('fcm_token')->get();
                $serviceAccountPath = storage_path('app/public/ubn_notification.json');
                $factory = (new Factory)->withServiceAccount($serviceAccountPath);
                $messaging = $factory->createMessaging();

                foreach ($users as $user) {
                    if (!empty($user->fcm_token)) {
                        $message = CloudMessage::withTarget('token', $user->fcm_token)
                            ->withNotification(Notification::create($title, $body));

                        try {
                            $messaging->send($message);
                            Log::info('Notification sent to token: ' . $user->fcm_token);
                        } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                            Log::error('Token not found: ' . $user->fcm_token);
                        } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                            Log::error('Invalid argument error with token: ' . $user->fcm_token);
                        } catch (\Exception $e) {
                            Log::error('General error sending to token: ' . $user->fcm_token . '. Error: ' . $e->getMessage());
                        }
                    }
                }
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }




    // public function delete($id)
    // {
    //     try {
    //         $event = Event::find($id);
    //         if (!$event) {
    //             return response()->json(['success' => false, 'message' => 'Event not found.'], 404);
    //         }

    //         $event->status = "Deleted";
    //         $event->save();

    //         return response()->json(['success' => true, 'message' => 'Event deleted successfully!']);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
    //     }
    // }



    public function delete(Request $request, $id)
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
            throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
            // return "error found";
        }
    }


    // public function eventRegistrationListMembers()
    // {
    //     try {
    //         return view('admin.event.eventRegistrationListMembers');
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError(
    //             $th,
    //             request()->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }



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

            return redirect()->back()->with('success', 'You are registered successfully for this event.');
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

    // public function checkRegistration(Request $request)
    // {
    //     try {
    //         $email = $request->input('personEmail');
    //         $eventId = $request->input('eventId');

    //         $isRegistered = Eventregister::where('eventId', $eventId)
    //             ->where('personEmail', $email)
    //             ->exists();

    //         return response()->json(['isRegistered' => $isRegistered]);
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         return response()->json(['error' => 'Something went wrong.'], 500);
    //     }
    // }


    public function checkRegistration(Request $request)
    {
        try {
            // Validate the input data
            $request->validate([
                'email' => 'required|email',
                'eventId' => 'required|integer'
            ]);

            // Fetch the user by email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['isRegistered' => false]);
            }

            // Fetch the active event
            $event = Event::find($request->eventId);

            if (!$event) {
                return response()->json(['isRegistered' => false]);
            }

            // Check if the user is already registered for the event
            $member = Member::where('userId', $user->id)->first();
            if (!$member) {
                return response()->json(['isRegistered' => false]);
            }

            $registration = EventRegister::where('memberId', $member->id)
                ->where('eventId', $event->id)
                ->first();

            // Return whether the user is already registered
            return response()->json(['isRegistered' => $registration ? true : false]);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['isRegistered' => false]);
        }
    }



    public function eventRegisterList(Request $request, $id)
    {
        try {
            $event = Event::find($id);

            $registerList = EventRegister::where('eventId', $id)->where('status', 'Active')->paginate(10);
            $registerListVisitor = VisitorEventRegister::where('eventId', $id)->where('status', 'Active')->paginate(10);

            $registerLists = $registerList->merge($registerListVisitor);

            return view('admin.event.eventRegistrationList', compact('event', 'registerList', 'registerLists'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function eventRegistrationListMembers(Request $request, $id)
    {
        try {
            $event = Event::find($id);

            $registerList = EventRegister::where('eventId', $id)->get();
            $registerListVisitor = VisitorEventRegister::where('eventId', $id)->get();

            $registerLists = $registerList->merge($registerListVisitor);

            return view('admin.event.eventRegistrationListMembers', compact('event', 'registerList', 'registerLists'));
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

        if ($request->bookingStatus === 'Rejected') {
            $slotBooking->status = 'Deleted';
            $slotBooking->save();
            return back()->with('success', 'Slot Booking status updated successfully.');
        }

        $slotBooking->bookingStatus = $request->bookingStatus;
        $slotBooking->save();

        return back()->with('success', 'Booking status updated successfully.');
    }



    public function storeaddEventMember(Request $request)
    {
        try {
            $eventReg = new EventRegister();
            $eventReg->eventId = $request->eventId;
            $eventReg->memberId = $request->memberId;
            $eventReg->personName = $request->personName;
            $eventReg->personEmail = $request->personEmail;
            $eventReg->personContact = $request->personContact;

            if ($request->has('refMemberId')) {
                $eventReg->refMemberId = $request->refMemberId;
            }
            if ($request->has('invitedBy2')) {
                $eventReg->invitedBy = $request->invitedBy2;
            }

            $eventReg->paymentStatus = $request->paymentStatus;
            $eventReg->save();

            return redirect()->back()->with('success', 'Details saved successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function createAddEventMember(Request $request)
    {
        try {
            $circles = Circle::where('status', 'Active')->get();

            $circleMember = Member::with('circle')
                ->where('status', 'Active')
                ->get(); // Ensure 'circleId' is included


            return view('admin.event.addMember', compact('circles', 'circleMember'));
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function getMembers($circleId)
    {
        $members = Member::where('circleId', $circleId)->get(); // Adjust column names as per your database
        return response()->json($members);
    }


    public function updateEventPaymentStatus(Request $request)
    {
        try {
            $register = EventRegister::findOrFail($request->id); // Replace with your actual model
            $register->PaymentStatus = $request->paymentStatus;
            $register->save();

            return response()->json(['success' => true, 'message' => 'Payment status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update payment status.']);
        }
    }
}
