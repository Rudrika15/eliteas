<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SpecificAsk;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use App\Models\CircleCall;
use App\Models\Event;
use App\Models\EventRegister;
use App\Models\Slot;
use App\Models\SlotBooking;
use App\Models\Visitor;
use App\Models\VisitorEventRegister;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class VisitorController extends Controller
{
    public function visitorLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::sendResponse($request->all(), 'Invalid Input');
        }

        $visitor = Visitor::where('email', $request->email)->first();

        if ($visitor && Hash::check($request->password, $visitor->password)) {
            unset($visitor->password); // Remove the password from the visitor object
            return Utils::sendResponse([
                'visitor' => $visitor
            ], 'Success');
        }
        return Utils::sendResponse(['error' => 'Unauthorized'], 401);
    }

    public function eventAttendance(Request $request)
{
    // Validate the incoming data
    $validator = Validator::make($request->all(), [
        'eventId' => 'required|exists:events,id',  // Ensure the event exists
        'type' => 'required|in:user,visitor',  // Type should either be 'user' or 'visitor'
        'userId' => 'nullable|exists:users,id',  // Optional, check if user exists
        'visitorId' => 'nullable|exists:visitors,id',  // Optional, check if visitor exists
    ]);

    // If validation fails, return the response using the Utils::sendResponse method
    if ($validator->fails()) {
        return Utils::sendResponse($request->all(), 'Invalid Input');
    }

    // Retrieve the event
    $event = Event::findOrFail($request->eventId);

    // Case 1: If the type is 'user', mark attendance for the user
    if ($request->type === 'user' && $request->has('userId')) {
        $userId = $request->userId;
        $member = Member::where('userId', $userId)->first();
        if (!$member) {
            return Utils::sendResponse(['error' => 'User not found'], 404);
        }

        // Check if the user has already registered for this event
        $attendance = EventRegister::where('eventId', $event->id)
                                   ->where('memberId', $member->id)
                                   ->first();

        if ($attendance) {
            // Update attendance status or mark as present
            $attendance->attendance = 'Present';  // Assuming you use 'status' to mark attendance
            $attendance->save();

            // Return response using Utils::sendResponse
            return Utils::sendResponse([
                'attendance' => $attendance,
                'message' => 'User attendance marked successfully!',
            ], 'Success');
        } else {
            return Utils::sendResponse([], 'User not registered for this event', 404);
        }
    }

    // Case 2: If the type is 'visitor', mark attendance for the visitor
    if ($request->type === 'visitor' && $request->has('visitorId')) {
        $visitorId = $request->visitorId;

        // Check if the visitor has already registered for this event
        $attendance = VisitorEventRegister::where('eventId', $event->id)
                                          ->where('visitorId', $visitorId)
                                          ->first();

        if ($attendance) {
            // Update attendance status or mark as present
            $attendance->attendance = 'Present';  // Assuming you use 'status' to mark attendance
            $attendance->save();

            // Return response using Utils::sendResponse
            return Utils::sendResponse([
                'attendance' => $attendance,
                'message' => 'Visitor attendance marked successfully!',
            ], 'Success');
        } else {
            return Utils::sendResponse([], 'Visitor not registered for this event', 404);
        }
    }

    // If the type is not 'user' or 'visitor', return an error response
    return Utils::sendResponse([], 'Invalid type specified', 400);
}


public function eventIndex(Request $request){

    $events = Event::where('eventStatus', 'Publish')->where('status', 'Active')->get();

    $visitorId = $request->visitorId;

    if(!$visitorId){
        return Utils::errorResponse([
            'error' => 'Please provide visitorId.'
        ], 'Bad Request', 400);
    }

    $eventRegisterList = VisitorEventRegister::where('visitorId', $visitorId)->get();


    if(count($events) > 0){
        return Utils::sendResponse([
            'events' => $events,
            'eventRegisterList' => $eventRegisterList
        ], 'Success');
    } else {
        return Utils::errorResponse([
            'error' => 'No events found for the visitor.'
        ], 'Not Found', 404);
    }
}

public function getUserListForVisitors(Request $request, $id)
{
    try {
        $event = Event::find($id);

        if (!$event) {
            return Utils::errorResponse(
                ['error' => 'Event not found.'],
                'Not Found',
                404
            );
        }

        // Fetch active users registered for the event
        $users = EventRegister::where('eventId', $id)
            ->where('status', 'Active')
            ->get()
            ->map(function ($user) {
                $user->type = 'member'; // Add a type key
                return $user;
            });

        // Fetch active visitors for the event excluding the current visitor
        $visitors = VisitorEventRegister::where('eventId', $id)
            ->where('status', 'Active')
            ->where('visitorId', '!=', session()->get('visitor_id'))
            ->get()
            ->map(function ($visitor) {
                $visitor->type = 'visitor'; // Add a type key
                return $visitor;
            });

        // Merge users and visitors
        $visitorsUsers = $users->merge($visitors);

        // Fetch slot bookings and active slots
        $slotBooking = SlotBooking::where('eventId', $id)
            ->where('status', 'Active')
            ->get();

        $slots = Slot::where('status', 'Active')->get();

        // Return the data as a JSON response
        return Utils::sendResponse([
            'event' => $event,
            'users' => $users,
            'visitorsUsers' => $visitorsUsers,
            'slotBooking' => $slotBooking,
            'slots' => $slots
        ], 'Success');
    } catch (\Throwable $th) {
        ErrorLogger::logError($th, $request->fullUrl());

        return Utils::errorResponse(
            ['error' => 'An error occurred while fetching data.'],
            'Server Error',
            500
        );
    }
}


public function getUserListForMembers(Request $request, $id)
{
    try {
        $event = Event::find($id);

        if (!$event) {
            return Utils::errorResponse(
                ['error' => 'Event not found.'],
                'Not Found',
                404
            );
        }

        // Fetch active users excluding the authenticated user's member ID
        $users = EventRegister::where('eventId', $id)
            ->where('status', 'Active')
            ->where('memberId', '!=', Auth::user()->member ? Auth::user()->member->id : null)
            ->get()
            ->map(function ($user) {
                $user->type = 'member'; // Add a type key
                return $user;
            });

        // Fetch active visitors for the event
        $visitors = VisitorEventRegister::where('eventId', $id)
            ->where('status', 'Active')
            ->get()
            ->map(function ($visitor) {
                $visitor->type = 'visitor'; // Add a type key
                return $visitor;
            });

        // Merge users and visitors
        $visitorsUsers = $users->merge($visitors);

        // Fetch active slots and slot bookings for the event
        $slots = Slot::where('status', 'Active')->get();
        $slotBooking = SlotBooking::where('eventId', $id)
            ->where('status', 'Active')
            ->get();

        // Return the data as a JSON response
        return Utils::sendResponse([
            'event' => $event,
            'users' => $users,
            'visitorsUsers' => $visitorsUsers,
            'slots' => $slots,
            'slotBooking' => $slotBooking
        ], 'Success');
    } catch (\Throwable $th) {
        throw $th;
        ErrorLogger::logError($th, $request->fullUrl());

        return Utils::errorResponse(
            ['error' => 'An error occurred while fetching data.'],
            'Server Error',
            500
        );
    }
}



}
