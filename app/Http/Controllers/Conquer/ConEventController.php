<?php

namespace App\Http\Controllers\Conquer;

use App\Http\Controllers\Controller;
use App\Mail\ConEventRegistrationMail;
use App\Mail\VisitorRegisteredMail;
use App\Models\BusinessCategory;
use App\Models\ConquerEvent;
use App\Models\EventRegister;
use App\Models\Event;
use App\Models\User;
use App\Models\VisitorsDetails;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ConEventController extends Controller
{
    public function main()
    {
        $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();
        return view('conquer.mainPage.main', compact('event'));
    }

    // public function thankYou()
    // {
    //     $event = ConquerEvent::where('status', 'Active')->first();
    //     return view('conquer.mainPage.thankYou', compact('event'));
    // }


    // public function thankYou(Request $request)
    // {
    //     // Get userId and eventId from the URL
    //     $userId = $request->query('userId');
    //     $eventId = $request->query('eventId');

    //     // Validate the presence of userId and eventId
    //     if (!$userId || !$eventId) {
    //         return redirect()->back()->with('error', 'Invalid data provided.');
    //     }

    //     // Fetch the user from the database
    //     $user = User::find($userId); // Assuming your user model is `User`

    //     if (!$user) {
    //         return redirect()->back()->with('error', 'User not found.');
    //     }

    //     // Fetch the event details from the database
    //     $eventRecord = ConquerEvent::find($eventId);

    //     if (!$eventRecord) {
    //         return redirect()->back()->with('error', 'Event not found.');
    //     }

    //     $event = new EventRegister();
    //     $event->userId = $userId;
    //     $event->eventId = $eventId;
    //     $event->save(); // Save the record into the database

    //     $eventDetails = [
    //         'Event' => $eventRecord->title,         // Dynamic event name from DB
    //         'Date' => $eventRecord->event_date,         // Dynamic event date from DB
    //         'Venue' => $eventRecord->venue ?? 'Not Decided Yet', // Dynamic event location from DB
    //     ];

    //     Mail::to($user->email)->send(new ConEventRegistrationMail($userId, $eventDetails));
    //     return view('conquer.mainPage.thankYou', compact('userId', 'eventId'));
    // }


    public function thankYou(Request $request)
    {
        // Get userId and eventId from the URL
        $userId = $request->query('userId');
        $eventId = $request->query('eventId');

        // Validate the presence of userId and eventId
        if (!$userId || !$eventId) {
            return redirect()->back()->with('error', 'Invalid data provided.');
        }

        // Fetch the user from the database
        $user = User::find($userId); // Assuming your user model is `User`

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Fetch the event details from the database
        $eventRecord = Event::find($eventId);

        if (!$eventRecord) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Check if the user is already registered for the event
        $existingRegistration = EventRegister::where('userId', $userId)
            ->where('eventId', $eventId)
            ->first();

        if ($existingRegistration) {
            // If the user is already registered, show a message
            return redirect()->back()->with('message', 'You are already registered for this event.');
        }

        // If not already registered, create a new registration record
        $event = new EventRegister();
        $event->userId = $userId;
        $event->eventId = $eventId;
        $event->save(); // Save the record into the database

        // Prepare event details
        $eventDetails = [
            'title' => $eventRecord->title,         // Event title
            'event_date' => $eventRecord->event_date,         // Event date
            'venue' => $eventRecord->venue ?? 'Not Decided Yet', // Event venue
        ];

        // Send the email
        Mail::to($user->email)->send(new ConEventRegistrationMail($user, $eventDetails));

        // Return the thank you page
        return view('conquer.mainPage.thankYou', compact('userId', 'eventId'));
    }


    // public function thankYouUser(Request $request)
    // {
    //     // Get eventId and email from the URL
    //     return $eventId = $request->eventId;
    //     $email = $request->email;

    //     // Validate the presence of eventId and email
    //     if (!$eventId || !$email) {
    //         return redirect()->back()->with('error', 'Invalid data provided.');
    //     }

    //     // Fetch the visitor's record based on the email and eventId
    //     $visitor = EventRegister::where('email', $email)
    //         ->where('eventId', $eventId)
    //         ->first();

    //     if (!$visitor) {
    //         return redirect()->back()->with('error', 'Visitor not found.');
    //     }

    //     // Fetch the event details from the database
    //     $eventRecord = ConquerEvent::find($eventId);

    //     if (!$eventRecord) {
    //         return redirect()->back()->with('error', 'Event not found.');
    //     }

    //     // Prepare event details
    //     $eventDetails = [
    //         'title' => $eventRecord->title,         // Event title
    //         'event_date' => $eventRecord->event_date, // Event date
    //         'venue' => $eventRecord->venue ?? 'Not Decided Yet', // Event venue
    //         'firstName' => $visitor->firstName,    // Visitor's first name
    //         'lastName' => $visitor->lastName,    // Visitor's last name
    //     ];

    //     // Send the email
    //     Mail::to($email)->send(new VisitorRegisteredMail($eventDetails));

    //     return view('conquer.mainPage.thankYouUser', compact('eventId'));
    // }



    public function visitor()
    {
        $event = Event::where('status', 'Active')->first();
        $businessCategory = BusinessCategory::where('status', 'Active')->get();
        return view('conquer.mainPage.visitor', compact('businessCategory', 'event'));
    }

    public function conEventLogin(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Fetch user from the database
        $user = User::where('email', $request->email)->first();

        // Fetch the active event
        $event = Event::where('status', 'Active')->first();

        // Check if user exists and password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Authentication successful
            return redirect()->route('main.event.thankYou', [
                'userId' => $user->id, // Pass authenticated userId
                'eventId' => $event->id ?? null, // Pass active eventId (if any)
            ]);
        } else {
            // Authentication failed
            return redirect()->back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput(); // Retain old inputs
        }
    }

    public function handleVisitorRegistration(Request $request)
    {
        try {
            // Validate the required fields
            $request->validate([
                'eventId' => 'required|exists:conquer_events,id',
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'mobileNo' => 'required|digits:10',
                'email' => 'required|email|max:255',
                'businessCategory' => 'required|string',
            ]);

            // Check if the visitor already exists
            $existingVisitor = VisitorsDetails::where('email', $request->email)
                ->where('eventId', $request->eventId)
                ->first();

            if ($existingVisitor) {
                return redirect()->back()->with('error', 'You are already registered for this event.');
            }

            // Create a new visitor record
            $visitor = new VisitorsDetails();
            $visitor->eventId = $request->eventId;
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->contactNo;
            $visitor->email = $request->email;
            $visitor->password = bcrypt(123456);
            $visitor->status = 'Active';

            // Handle business category
            if ($request->businessCategory === 'other') {
                // Check or create the new business category
                $business = BusinessCategory::firstOrCreate(
                    ['categoryName' => $request->otherCategory]
                );
                $visitor->businessCategory = $business->id;
            } else {
                $visitor->businessCategory = $request->businessCategory;
            }

            // Save the visitor record
            $visitor->save();

            // Fetch the event details
            $eventRecord = Event::find($request->eventId);

            if (!$eventRecord) {
                return redirect()->back()->with('error', 'Event not found.');
            }

            // Prepare event details for the email
            $eventDetails = [
                'title' => $eventRecord->title,
                'event_date' => $eventRecord->event_date,
                'venue' => $eventRecord->venue ?? 'Not Decided Yet',
                'firstName' => $visitor->firstName,
                'lastName' => $visitor->lastName,
            ];

            // Send the confirmation email
            Mail::to($request->email)->send(new VisitorRegisteredMail($eventDetails));

            // Redirect to the Thank You page
            return view('conquer.mainPage.thankYouUser', [
                'eventId' => $request->eventId,
            ])->with('success', 'Your information was submitted successfully!');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, $request->fullUrl());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to submit your information.');
        }
    }



    // public function conquerVisitorStore(Request $request)
    // {
    //     try {
    //         // Create a new VisitorsDetails object
    //         $visitor = new EventRegister();
    //         $visitor->eventId = $request->eventId;
    //         $visitor->firstName = $request->firstName;
    //         $visitor->lastName = $request->lastName;
    //         $visitor->contactNo = $request->contactNo;
    //         $visitor->email = $request->email;

    //         // Determine business category and assign it to the visitor
    //         if ($request->businessCategory == 'other') {
    //             // If 'other', assign the otherCategory value and check if already exists
    //             $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();
    //             if (!$business) {
    //                 $business = new BusinessCategory();
    //                 $business->categoryName = $request->otherCategory;
    //                 $business->save();
    //             }
    //             $visitor->businessCategory = $business->id;
    //         } else {
    //             $visitor->businessCategory = $request->businessCategory;
    //         }

    //         $visitor->status = 'Active';

    //         // Save the visitor information
    //         $visitor->save();

    //         // Redirect to a "Thank You" page
    //         return redirect()->route('main.event.thankYouUser')->with('success', 'Your Information Submitted Successfully!');
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         throw $th;
    //         ErrorLogger::logError($th, $request->fullUrl());

    //         // Return a generic error view or message
    //         return redirect()->back()->with('error', 'Failed to submit your information');
    //     }
    // }


    public function eventLogin()
    {
        $event = Event::where('status', 'Active')->first();
        return view('conquer.mainPage.eventLogin', compact('event'));
    }

    public function conquerUserStore(Request $request)
    {
        try {
            // Create a new VisitorsDetails object
            $visitor = new EventRegister();
            $visitor->eventId = $request->eventId;
            $visitor->userId = $request->userId;
            $visitor->status = 'Active';

            // Save the visitor information
            $visitor->save();

            return redirect()->back()->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            // Return a generic error view or message
            return redirect()->back()->with('error', 'Failed to submit your information');
        }
    }
}
