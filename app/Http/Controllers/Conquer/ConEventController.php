<?php

namespace App\Http\Controllers\Conquer;

use App\Http\Controllers\Controller;
use App\Mail\ConEventRegistrationMail;
use App\Mail\VisitorRegisteredMail;
use App\Models\AllPayments;
use App\Models\BusinessCategory;
use App\Models\ConquerEvent;
use App\Models\EventRegister;
use App\Models\Event;
use App\Models\Member;
use App\Models\Razorpay;
use App\Models\User;
use App\Models\Visitor;
use App\Models\VisitorEventRegister;
use App\Models\VisitorsDetails;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConEventController extends Controller
{
    public function main()
    {
        $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();
        $currentDate = now();

        return view('conquer.mainPage.main', compact('event', 'currentDate'));
    }



    public function eventLogin()
    {
        // $event = Event::where('status', 'Active')->first();
        $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();
        return view('conquer.mainPage.eventLogin', compact('event'));
    }

    public function visitorLoginCheck(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Fetch visitor from the database
        $visitor = Visitor::where('email', $request->email)->first();

        // Validate the existence of the visitor
        if (!$visitor || !Hash::check($request->password, $visitor->password)) {
            return redirect()->back()->withErrors([
                'email' => 'Invalid credentials. Please check your email and password.',
            ])->withInput();
        }

        // Store visitor details in session
        session([
            'visitor_id' => $visitor->id,
            'visitor_name' => $visitor->firstName . ' ' . $visitor->lastName,
            'visitor_email' => $visitor->email,
        ]);

        $visitorId = session('visitor_id');
        $visitorName = session('visitor_name');
        $visitorEmail = session('visitor_email');

        // dd($visitorId, $visitorName, $visitorEmail); // Debug and see session data


        // Redirect to the dashboard with a success message\
        return redirect()->route('visitor.dashboard');
    }


    public function logoutVisitor()
    {
        session()->flush(); // Clears all session data
        return redirect()->route('main.event')->with('success', 'You have been logged out successfully.');
    }

    public function visitorDashboard()
    {
        $currentDate = Carbon::now();
        $nearestEvents = Event::where('status', 'Active')
            ->whereDate('event_date', '>=', $currentDate)
            ->orderBy('event_date', 'desc')
            ->first();


        $totalRegisterCount = VisitorEventRegister::where('eventId', $nearestEvents->id)->count() + EventRegister::where('eventId', $nearestEvents->id)->count();

        // if ($nearestEvents) {
        //     $findEventRegister = VisitorEventRegister::where('visitorId', Auth::user()->member->id)
        //         ->where('eventId', $nearestEvents->id)
        //         ->get();
        // } else {
        //     $findEventRegister = [];
        // }
        return view('visitor.visitorDashboard', compact('nearestEvents', 'totalRegisterCount'));
    }



    // public function conEventLogin(Request $request)
    // {

    //     // Validate the incoming request
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6',
    //     ]);

    //     // Fetch user from the database
    //     $user = User::where('email', $request->email)->first();

    //     // Fetch the active event
    //     $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();

    //     // Validate the existence of the event
    //     if (!$event) {
    //         return redirect()->back()->withErrors([
    //             'email' => 'No active event found.',
    //         ])->withInput();
    //     }

    //     // Check if user exists and password matches
    //     if ($user && Hash::check($request->password, $user->password)) {
    //         // Fetch the corresponding member record
    //         $member = Member::where('userId', $user->id)->first();

    //         if (!$member) {
    //             return redirect()->back()->withErrors([
    //                 'email' => 'No member record found for the authenticated user.',
    //             ])->withInput();
    //         }

    //         $memberId = $member->id;
    //         $eventId = $event->id;


    //         // Check if the member is already registered for the event
    //         $existingRegistration = EventRegister::where('memberId', $memberId)
    //             ->where('eventId', $eventId)
    //             ->first();

    //         if ($existingRegistration) {
    //             return redirect()->back()->with('message', 'You are already registered for this event.');
    //         }

    //         $eventRecord = Event::find($request->eventId);

    //         if (!$eventRecord) {
    //             return redirect()->back()->with('error', 'Event not found.');
    //         }

    //         if ($eventRecord->fees > 0) {
    //             // Create a new Razorpay record
    //             $razorpay = new Razorpay();
    //             $razorpay->r_payment_id = $request->paymentId;
    //             $razorpay->user_email = null;
    //             $razorpay->amount = $request->amount / 100;
    //             $razorpay->save();
    //         }

    //         // Register the member for the event
    //         $registration = new EventRegister();
    //         $registration->memberId = $memberId;
    //         $registration->eventId = $eventId;
    //         $registration->save();

    //         // Prepare event details for email
    //         $eventDetails = [
    //             'title' => $event->title,
    //             'event_date' => $event->event_date,
    //             'venue' => $event->venue ?? 'Not Decided Yet',
    //         ];

    //         // Send confirmation email
    //         // Mail::to($user->email)->send(new ConEventRegistrationMail($user, $eventDetails));

    //         // Redirect to the thank you page
    //         return view('conquer.mainPage.thankYou', compact('memberId', 'eventId'))
    //             ->with('success', 'You have successfully registered for the event.');
    //     } else {
    //         // Authentication failed
    //         return redirect()->back()->withErrors([
    //             'email' => 'The provided credentials do not match our records.',
    //         ])->withInput();
    //     }
    // }


//     public function conEventLogin(Request $request)
// {
//     try {
//         // Validate the incoming request
//         $request->validate([
//             'email' => 'required|email',
//             'password' => 'required|min:6',
//         ]);

//         // Fetch user from the database
//         $user = User::where('email', $request->email)->first();

//         // Fetch the active event
//         $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();

//         // Validate the existence of the event
//         if (!$event) {
//             return redirect()->back()->withErrors([
//                 'email' => 'No active event found.',
//             ])->withInput();
//         }

//         // Check if user exists and password matches
//         if ($user && Hash::check($request->password, $user->password)) {
//             // Fetch the corresponding member record
//             $member = Member::where('userId', $user->id)->first();

//             if (!$member) {
//                 return redirect()->back()->withErrors([
//                     'email' => 'No member record found for the authenticated user.',
//                 ])->withInput();
//             }

//             $memberId = $member->id;
//             $eventId = $event->id;

//             // Check if the member is already registered for the event
//             $existingRegistration = EventRegister::where('memberId', $memberId)
//                 ->where('eventId', $eventId)
//                 ->first();

//             if ($existingRegistration) {
//                 return redirect()->back()->with('message', 'You are already registered for this event.');
//             }

//             // Fetch the event record
//             $eventRecord = Event::find($request->eventId);

//             if (!$eventRecord) {
//                 return redirect()->back()->with('error', 'Event not found.');
//             }

//             if ($eventRecord->fees > 0) {

//                 $razorpay = new Razorpay();
//                 $razorpay->r_payment_id = $request->paymentId;
//                 $razorpay->user_email = null;
//                 $razorpay->amount = $request->amount / 100;
//                 $razorpay->save();

//                 $registration = new EventRegister();
//                 $registration->memberId = $memberId;
//                 $registration->eventId = $eventId;
//                 $registration->save();

//                 $allPayments = new AllPayments();
//                 $allPayments->memberId = $registration->memberId;
//                 $allPayments->amount = $razorpay->amount;
//                 $allPayments->paymentType = 'RazorPay'; // Hardcoded for RazorPay
//                 $allPayments->date = now()->format('Y-m-d');
//                 $allPayments->paymentMode = 'Event Register Payment';
//                 $allPayments->remarks = $razorpay->r_payment_id;
//                 $allPayments->save();

//                 // Return success for payment details
//                 return response()->json(['success' => 'Payment details stored successfully'], 200);
//             }

//             // Handle free event logic
//             if ($eventRecord->fees == 0) {
//                 // Register the member for the event
//                 $registration = new EventRegister();
//                 $registration->memberId = $memberId;
//                 $registration->eventId = $eventId;
//                 $registration->save();

//                 return view('conquer.mainPage.thankYouUser', [
//                     'eventId' => $request->eventId,
//                 ])->with('success', 'Your information was submitted successfully!');
//             }

//             // Prepare event details for email
//             $eventDetails = [
//                 'title' => $event->title,
//                 'event_date' => $event->event_date,
//                 'venue' => $event->venue ?? 'Not Decided Yet',
//             ];

//             // Send confirmation email
//             // Mail::to($user->email)->send(new ConEventRegistrationMail($user, $eventDetails));

//             // Redirect to the thank you page
//             return view('conquer.mainPage.thankYou', compact('memberId', 'eventId'))
//                 ->with('success', 'You have successfully registered for the event.');
//         } else {
//             // Authentication failed
//             return redirect()->back()->withErrors([
//                 'email' => 'The provided credentials do not match our records.',
//             ])->withInput();
//         }
//     } catch (\Exception $e) {
//         // Log the error for debugging purposes
//         Log::error('Error during event login: ' . $e->getMessage(), [
//             'request_data' => $request->all(),
//             'exception' => $e
//         ]);

//         // Redirect back with an error message
//         return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
//     }
// }


public function conEventLogin(Request $request)
{
    try {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Fetch user from the database
        $user = User::where('email', $request->email)->first();

        // Fetch the active event
        $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();

        // Validate the existence of the event
        if (!$event) {
            return redirect()->back()->withErrors([
                'email' => 'No active event found.',
            ])->withInput();
        }

        // Check if user exists and password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Fetch the corresponding member record
            $member = Member::where('userId', $user->id)->first();

            if (!$member) {
                return redirect()->back()->withErrors([
                    'email' => 'No member record found for the authenticated user.',
                ])->withInput();
            }

            $memberId = $member->id;
            $eventId = $event->id;

            // Check if the member is already registered for the event
            $existingRegistration = EventRegister::where('memberId', $memberId)
                ->where('eventId', $eventId)
                ->first();

            if ($existingRegistration) {
                return redirect()->back()->with('message', 'You are already registered for this event.');
            }

            // Fetch the event record
            $eventRecord = Event::find($request->eventId);

            if (!$eventRecord) {
                return redirect()->back()->with('error', 'Event not found.');
            }

            // If event has fees, proceed to payment
            if ($eventRecord->fees > 0) {
                // Store payment details (razorpay or another service)
                $razorpay = new Razorpay();
                $razorpay->r_payment_id = $request->paymentId;
                $razorpay->user_email = null;
                $razorpay->amount = $request->amount / 100;
                $razorpay->save();

                $registration = new EventRegister();
                $registration->memberId = $memberId;
                $registration->eventId = $eventId;
                $registration->save();

                $allPayments = new AllPayments();
                $allPayments->memberId = $registration->memberId;
                $allPayments->amount = $razorpay->amount;
                $allPayments->paymentType = 'RazorPay';
                $allPayments->date = now()->format('Y-m-d');
                $allPayments->paymentMode = 'Event Register Payment';
                $allPayments->remarks = $razorpay->r_payment_id;
                $allPayments->save();

                return response()->json(['success' => 'Payment details stored successfully'], 200);
            }

            // Handle free event logic
            if ($eventRecord->fees == 0) {
                // Register the member for the event
                $registration = new EventRegister();
                $registration->memberId = $memberId;
                $registration->eventId = $eventId;
                $registration->save();

                return view('conquer.mainPage.thankYou', [
                    'eventId' => $request->eventId,
                ])->with('success', 'Your information was submitted successfully!');
            }

            // Other logic (sending confirmation email, etc.)
            return view('conquer.mainPage.thankYou', compact('memberId', 'eventId'))
                ->with('success', 'You have successfully registered for the event.');

        } else {
            // Authentication failed
            return redirect()->back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->withInput();
        }
    } catch (\Exception $e) {
        // Log the error for debugging purposes
        Log::error('Error during event login: ' . $e->getMessage(), [
            'request_data' => $request->all(),
            'exception' => $e
        ]);

        // Redirect back with an error message
        return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
    }
}





    public function visitor()
    {
        // $event = Event::where('status', 'Active')->first();
        $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();
        $businessCategory = BusinessCategory::where('status', 'Active')->get();
        return view('conquer.mainPage.visitor', compact('businessCategory', 'event'));
    }


    public function registerFromVisitor(Request $request)
    {


        $visitorId = session('visitor_id');

        $visitors = VisitorEventRegister::where('visitorId', $visitorId)
            ->where('eventId', $request->eventId)
            ->first();

        if ($visitors) {
            return redirect()->back()->with('error', 'You are already registered for this event.');
        }

        $visitor = new VisitorEventRegister();
        $visitor->visitorId = $visitorId;
        $visitor->eventId = $request->eventId;
        $visitor->save();

        return redirect()->back()->with('success', 'You have successfully registered for the event.');
    }


    // public function handleVisitorRegistration(Request $request)
    // {
    //     try {
    //         // Validate the required fields
    //         $request->validate([
    //             'eventId' => 'required|exists:events,id',
    //             'firstName' => 'required|string|max:255',
    //             'lastName' => 'required|string|max:255',
    //             'mobileNo' => 'required|digits:10',
    //             'email' => 'required|email|max:255',
    //             'businessCategory' => 'required|string',
    //         ]);

    //         // Check if the visitor already exists
    //         $existingVisitor = VisitorsDetails::where('email', $request->email)
    //             ->where('eventId', $request->eventId)
    //             ->first();

    //         if ($existingVisitor) {
    //             return redirect()->back()->with('error', 'You are already registered for this event.');
    //         }

    //         // Create a new visitor record
    //         $visitor = new VisitorsDetails();
    //         $visitor->eventId = $request->eventId;
    //         $visitor->firstName = $request->firstName;
    //         $visitor->lastName = $request->lastName;
    //         $visitor->mobileNo = $request->contactNo;
    //         $visitor->email = $request->email;
    //         $visitor->password = bcrypt(123456);
    //         $visitor->status = 'Active';

    //         // Handle business category
    //         if ($request->businessCategory === 'other') {
    //             // Check or create the new business category
    //             $business = BusinessCategory::firstOrCreate(
    //                 ['categoryName' => $request->otherCategory]
    //             );
    //             $visitor->businessCategory = $business->id;
    //         } else {
    //             $visitor->businessCategory = $request->businessCategory;
    //         }

    //         // Save the visitor record
    //         $visitor->save();

    //         // Fetch the event details
    //         $eventRecord = Event::find($request->eventId);

    //         if (!$eventRecord) {
    //             return redirect()->back()->with('error', 'Event not found.');
    //         }

    //         // Prepare event details for the email
    //         $eventDetails = [
    //             'title' => $eventRecord->title,
    //             'event_date' => $eventRecord->event_date,
    //             'venue' => $eventRecord->venue ?? 'Not Decided Yet',
    //             'firstName' => $visitor->firstName,
    //             'lastName' => $visitor->lastName,
    //         ];

    //         // Send the confirmation email
    //         Mail::to($request->email)->send(new VisitorRegisteredMail($eventDetails));

    //         // Redirect to the Thank You page
    //         return view('conquer.mainPage.thankYouUser', [
    //             'eventId' => $request->eventId,
    //         ])->with('success', 'Your information was submitted successfully!');
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError($th, $request->fullUrl());

    //         // Redirect back with error message
    //         return redirect()->back()->with('error', 'Failed to submit your information.');
    //     }
    // }

    public function visitorLogin()
    {
        $event = Event::where('status', 'Active')->orderBy('created_at', 'desc')->first();
        return view('visitor.visitorLogin', compact('event'));
    }


    public function handleVisitorRegistration(Request $request)
    {
        try {
            // Validate the required fields
            $request->validate([
                'eventId' => 'required|exists:events,id',
                'firstName' => 'required|string|max:255',
                'lastName' => 'required|string|max:255',
                'mobileNo' => 'required|digits:10',
                'email' => 'required|email|max:255',
                'businessCategory' => 'required|string',
            ]);

            // Check if the visitor already exists in the Visitors table
            $existingVisitor = Visitor::where('email', $request->email)->first();

            if ($existingVisitor) {
                // Check if they are already registered for this event
                $alreadyRegistered = VisitorEventRegister::where('eventId', $request->eventId)
                    ->where('visitorId', $existingVisitor->id)
                    ->exists();

                if ($alreadyRegistered) {
                    return redirect()->back()->with('error', 'You are already registered for this event.');
                }

                // If visitor exists but not registered for this event
                return redirect()->back()->with('error', 'You are already registered as a user. Please log in to register for this event.');
            }

            // Create a new visitor record if not already in the Visitors table
            $visitor = new Visitor();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->email = $request->email;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->birthDate = $request->birthDate;
            $visitor->gender = $request->gender;
            $visitor->businessCategory = $request->businessCategory;
            $visitor->password = bcrypt(123456); // Default password
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

            // Save the new visitor
            $visitor->save();

            // Fetch the event details
            $eventRecord = Event::find($request->eventId);

            if (!$eventRecord) {
                return redirect()->back()->with('error', 'Event not found.');
            }

            if ($eventRecord->fees > 0) {
                // Create a new Razorpay record
                $razorpay = new Razorpay();
                $razorpay->r_payment_id = $request->paymentId;
                $razorpay->user_email = null;
                $razorpay->amount = $request->amount / 100;
                $razorpay->save();
            }

            // Create a new VisitorEventRegister record
            $eventRegister = new VisitorEventRegister();
            $eventRegister->eventId = $request->eventId;
            $eventRegister->visitorId = $visitor->id;
            $eventRegister->PaymentStatus = 'Paid';
            $eventRegister->save();

            // Prepare event details for the email
            $eventDetails = [
                'title' => $eventRecord->title,
                'event_date' => $eventRecord->event_date,
                'venue' => $eventRecord->venue ?? 'Not Decided Yet',
                'firstName' => $visitor->firstName,
                'lastName' => $visitor->lastName,
                'email' => $visitor->email,
                'password' => '123456',
            ];

            // Send the confirmation email
            // Mail::to($visitor->email)->send(new VisitorRegisteredMail($eventDetails));

            // Redirect to the Thank You page
            if ($eventRecord->fees == 0) {
                return view('conquer.mainPage.thankYouUser', [
                    'eventId' => $request->eventId,
                ])->with('success', 'Your information was submitted successfully!');
            } else {
                return response()->json(['success' => 'Payment details stored successfully'], 200);
            }
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, $request->fullUrl());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to submit your information.');
        }
    }


    public function thankYouUser()
    {

        return view('conquer.mainPage.thankYouUser');
    }
    public function thankYou()
    {
        return view('conquer.mainPage.thankYou');
    }




    // public function conquerUserStore(Request $request)
    // {
    //     try {
    //         // Create a new VisitorsDetails object
    //         $visitor = new EventRegister();
    //         $visitor->eventId = $request->eventId;
    //         $visitor->userId = $request->userId;
    //         $visitor->status = 'Active';

    //         // Save the visitor information
    //         $visitor->save();

    //         return redirect()->back()->with('success', 'Your Information Submitted Successfully!');
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         // Return a generic error view or message
    //         return redirect()->back()->with('error', 'Failed to submit your information');
    //     }
    // }
}
