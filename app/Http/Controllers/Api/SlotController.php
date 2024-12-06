<?php

namespace App\Http\Controllers\Api;

use App\Models\CircleType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slot;
use App\Models\SlotBooking;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class SlotController extends Controller
{
    public function slotBookingVisitorAPI(Request $request)
{
    // Validate request data
    $this->validate($request, [
        'slotId' => 'required',
        'eventId' => 'required',
    ]);

    try {
        // Create a new SlotBooking record
        $slot = new SlotBooking();
        $slot->eventId = $request->eventId;
        $slot->slotId = $request->slotId;
        $slot->visitorId = $request->visitorId;
        $slot->regMemberId = $request->regMemberId;
        $slot->date = now()->toDateString();
        $slot->bookingStatus = 'Pending';
        $slot->status = 'Active';
        $slot->save();

        // Return success response
        return Utils::sendResponse([
            'message' => 'Booking Successful!',
            'slotBooking' => $slot
        ], 'Success');
    } catch (\Throwable $th) {
        // Log error and return server error response
        ErrorLogger::logError($th, $request->fullUrl());

        return Utils::errorResponse(
            ['error' => 'An error occurred while processing the booking.'],
            'Server Error',
            500
        );
    }
}


public function slotBookingMemberAPI(Request $request)
{
    try {
        $userId = $request->user()->id;

        $this->validate($request, [
            'slotId' => 'required',
            'eventId' => 'required',

        ]);

        // Create a new SlotBooking
        $slot = new SlotBooking();
        $slot->eventId = $request->eventId;
        $slot->slotId = $request->slotId;
        $slot->userId = $userId;
        $slot->regMemberId = $request->regMemberId;
        $slot->bookingStatus = 'Pending';
        $slot->status = 'Active';
        $slot->save();

        // Return success response
        return Utils::sendResponse([
            'message' => 'Booking Successful!',
            'slotBooking' => $slot
        ], 'Success');
    } catch (\Throwable $th) {
        // Log error and return error response
        ErrorLogger::logError($th, $request->fullUrl());

        return Utils::errorResponse(
            ['error' => 'An error occurred while processing the booking.'],
            'Server Error',
            500
        );
    }
}

public function slotIndex(Request $request)
    {
        try {

            // Get the nearest upcoming event that is associated with the member and exclude past events
            $slot = Slot::where('status', 'Active')->get();

            // Return the response with the nearest event and its registration details
            return Utils::sendResponse([
                'slot' => $slot,
            ], 'Slot Retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => 'Failed to retrieve slot. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }


}
