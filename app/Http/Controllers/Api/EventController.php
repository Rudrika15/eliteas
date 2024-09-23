<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Event;
use App\Models\Member;
use App\Models\Razorpay;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\EventRegister;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function eventRegister(Request $request, $eventId)
    {
        try {
            $eventregister = new EventRegister();
            $eventregister->userId = Auth::user()->id;
            $eventregister->eventId = $eventId;
            $eventregister->personName = $request->personName;
            $eventregister->personEmail = $request->personEmail;
            $eventregister->personContact = $request->personContact;
            $eventregister->save();

            return Utils::sendResponse([], 'Event Registered Successfully', 200);
        } catch (\Throwable $th) {

            // Return with an error message
            return Utils::errorResponse(['error' => 'Failed to register for the Event. Please try again.'], 'Internal Server Error', 500);
        }
    }

    public function index(Request $request)
{
    try {
        // Get the authenticated user based on the Bearer token
        $authUser = auth()->user();

        // Check if the user exists and get their member ID from the members table
        $memberId = Member::where('userId', $authUser->id)->value('id');

        if (!$memberId) {
            return Utils::errorResponse([
                'error' => 'Member not found.'
            ], 'Not Found', 404);
        }

        // Get the nearest upcoming event that is associated with the member and exclude past events
        $event = Event::with(['circle', 'registrations' => function($query) use ($memberId) {
            // Get the registration details from event_registers table for the member
            $query->where('memberId', $memberId);
        }])
        ->where('status', 'Active')
        ->where('event_date', '>=', now()) // Only get upcoming events
        ->orderBy('event_date', 'ASC') // Order by nearest date
        ->first(); // Get the closest event

        // Check if no upcoming event is found
        if (!$event) {
            return Utils::sendResponse([
                'message' => 'No events for now.'
            ], 'No upcoming events', 200);
        }

        // Return the response with the nearest event and its registration details
        return Utils::sendResponse([
            'event' => $event
        ], 'Nearest event retrieved successfully', 200);
        
    } catch (\Throwable $th) {
        // Return with an error message
        return Utils::errorResponse([
            'error' => 'Failed to retrieve event. Please try again.'
        ], 'Internal Server Error', 500);
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

            return Utils::sendResponse([], 'Your data is saved successfully.', 201);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to save your data. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }
    public function checkRegistration(Request $request)
    {
        try {
            $eventId = $request->input('eventId');
            $memberId = Auth::user()->member->id;

            $isRegistered = EventRegister::where('eventId', $eventId)
                ->where('memberId', $memberId)
                ->exists();

            return Utils::sendResponse([
                'isRegistered' => $isRegistered
            ], 'Registration check completed successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Something went wrong. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    public function checkRegistrationUser(Request $request)
    {
        try {
            $email = $request->input('personEmail');
            $eventId = $request->input('eventId');

            $isRegistered = EventRegister::where('eventId', $eventId)
                ->where('personEmail', $email)
                ->exists();

            return Utils::sendResponse([
                'isRegistered' => $isRegistered
            ], 'Registration check completed successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Something went wrong. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    public function eventRegisterList(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);
            $registerList = EventRegister::where('eventId', $id)->get();

            return Utils::sendResponse([
                'event' => $event,
                'registerList' => $registerList
            ], 'Event registration list retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to retrieve event registration list. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    public function eventPaymentForMember(Request $request)
    {
        try {
            // Validate the request

            // Store the payment ID in the table
            $payment = new Razorpay();
            $payment->r_payment_id = $request->input('paymentId');
            $payment->user_email = Auth::user()->email;
            $payment->amount = $request->input('amount') / 100;
            $payment->save();

            // Register for the event
            $eventPayment = new EventRegister();
            $eventPayment->eventId = $request->eventId;
            $eventPayment->memberId = Auth::user()->member->id;
            $eventPayment->paymentStatus = 'paid';
            $eventPayment->save();

            // Store the payment details
            $allPayments = new AllPayments();
            $allPayments->memberId = $eventPayment->memberId;
            $allPayments->amount = $payment->amount;
            $allPayments->paymentType = 'RazorPay'; // Hardcoded for RazorPay
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Event Register Payment';
            $allPayments->remarks = $payment->r_payment_id;
            $allPayments->save();

            // Return a success response
            return Utils::sendResponse([], 'Payment received successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to store payment ID. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    public function userEventPayment(Request $request)
    {
        try {

            // Store the payment ID in the table
            $payment = new Razorpay();
            $payment->r_payment_id = $request->input('paymentId');
            $payment->user_email = $request->personEmail;
            $payment->amount = $request->input('amount') / 100;
            $payment->save();

            // Register for the event
            $eventPayment = new EventRegister();
            $eventPayment->eventId = $request->eventId;
            $eventPayment->personName = $request->personName;
            $eventPayment->personEmail = $request->personEmail;
            $eventPayment->personContact = $request->personContact;
            $eventPayment->paymentStatus = 'paid';
            $eventPayment->save();

            // Store the payment details
            $allPayments = new AllPayments();
            $allPayments->amount = $payment->amount;
            $allPayments->paymentType = 'RazorPay'; // Hardcoded for RazorPay
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Event Register Payment';
            $allPayments->remarks = $payment->r_payment_id;
            $allPayments->save();

            // Return a success response
            return Utils::sendResponse([], 'Payment received successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to store payment ID. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }
}
