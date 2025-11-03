<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Event;
use App\Models\Member;
use App\Models\Razorpay;
use App\Models\AllPayments;
use Illuminate\Http\Request;
use App\Models\EventRegister;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\SlotBooking;
use App\Models\VisitorEventRegister;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{

    public function memberEventIndexd(Request $request)
    {
        try {
            $event = Event::with('circle')
                ->where('status', 'Active')
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

    public function memberEventIndex(Request $request)
    {
        try {
            $event = Event::with('circle')
                ->where('status', 'Active')
                ->where('eventStatus', 'Publish')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['Event' => $event], 'Event Data Fetched Successfully', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return Utils::errorResponse(['error' => 'Failed to fetch Event Data. Please try again.'], 'Internal Server Error', 500);
        }
    }

    public function memberSlotBookingRequests(Request $request, $id)
    {
        try {
            $memberId = Auth::user()->id;
            // Fetch the event
            $event = Event::where('id', $id)->where('eventStatus', 'Publish')->first();
            if (!$event) {
                return Utils::errorResponse(['error' => 'Event not found or not published.'], 'Event Not Found', 404);
            }
            // Fetch the member's slot bookings for the event
            $slotBooking = SlotBooking::select('id', 'eventId', 'slotId', 'userId', 'regMemberId', 'bookingStatus', 'date')
                ->where('eventId', $id)
                ->with(['slots' => function ($query) {
                    $query->select('id', 'start_time', 'end_time');
                }])
                ->where('bookingStatus', 'Pending')
                ->where('status', 'Active')
                ->where('regMemberId', $memberId)
                ->with(['user' => function ($query) {
                    $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto');
                }])
                ->get();
            return Utils::sendResponse([
                //'event' => $event,
                'slotBooking' => $slotBooking,
            ], 'Slot Booking Data Fetched Successfully', 200);
        } catch (\Throwable $th) {
            // Log the error and return a JSON response
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return Utils::errorResponse(['error' => 'Failed to fetch Slot Booking Data. Please try again.'], 'Internal Server Error', 500);
        }
    }

    public function slotBookingUpdateStatus(Request $request, $id)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'bookingStatus' => 'required|in:Pending,Approved,Rejected',
            ]);

            // Find the slot booking
            $slotBooking = SlotBooking::findOrFail($id);

            // Update the booking status
            if ($validatedData['bookingStatus'] === 'Rejected') {
                $slotBooking->status = 'Deleted';
                $slotBooking->save();
            } else {
                $slotBooking->bookingStatus = $validatedData['bookingStatus'];
                $slotBooking->save();
            }

            // Return a success response
            return Utils::sendResponse(
                ['slotBooking' => $slotBooking],
                'Booking status updated successfully.',
                200
            );
        } catch (\Throwable $th) {
            // Log the error and handle server exceptions
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return Utils::errorResponse(
                ['error' => 'Failed to update booking status. Please try again.'],
                'Internal Server Error',
                500
            );
        }
    }




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

    // public function index(Request $request)
    // {
    //     try {
    //         // Get the authenticated user based on the Bearer token
    //         $authUser = auth()->user();

    //         // Check if the user exists and get their member ID from the members table
    //             $memberId = Member::where('userId', $authUser->id)->value('id');

    //         if (!$memberId) {
    //             return Utils::errorResponse([
    //                 'error' => 'Member not found.'
    //             ], 'Not Found', 404);
    //         }

    //         // Get the nearest upcoming event that is associated with the member and exclude past events
    //         $event = Event::with(['circle', 'registrations' => function ($query) use ($memberId) {
    //             // Get the registration details from event_registers table for the member
    //             $query->where('memberId', $memberId);
    //         }])
    //             ->where('status', 'Active')
    //             ->where('eventStatus', 'Publish')
    //             ->whereDate('event_date', '>=', now()->format('Y-m-d')) // Only get upcoming events including today
    //             ->orderBy('event_date', 'ASC') // Order by nearest date
    //             ->get(); // Get the closest event

    //         // Check if no upcoming event is found
    //         if (!$event) {
    //             return Utils::sendResponse([
    //                 'message' => 'No events for now.'
    //             ], 'No upcoming events', 200);
    //         }

    //         // Create the signed URL for the event link
    //         $signedUrl = URL::signedRoute('event.link', [
    //             'slug' => $event->event_slug, // Correct the parameter name to match the route
    //             'ref' => $memberId // Using the correct member ID here
    //         ], now()->addMinutes(60));

    //         // Return the response with the nearest event and its registration details
    //         return Utils::sendResponse([
    //             'event' => $event,
    //             'eventLink' => $signedUrl
    //         ], 'Nearest event retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Log the error for debugging purposes
    //         Log::error('Error retrieving event: ' . $th->getMessage());
    //         // Return with an error message
    //         return Utils::errorResponse([
    //             'error' => 'Failed to retrieve event. Please try again.'
    //         ], 'Internal Server Error', 500);
    //     }
    // }


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

            // Get all future events that are associated with the member and exclude past events
            $events = Event::with(['circle', 'registrations' => function ($query) use ($memberId) {
                // Get the registration details from event_registers table for the member
                $query->where('memberId', $memberId);
            }])
                ->where('status', 'Active')
                ->where('eventStatus', 'Publish')
                ->whereDate('event_date', '>=', now()->format('Y-m-d')) // Only get upcoming events including today
                ->orderBy('event_date', 'ASC') // Order by date in ascending order (from the earliest)
                ->get(); // Get all future events

            // Check if no future events are found
            if ($events->isEmpty()) {
                return Utils::sendResponse([
                    'message' => 'No upcoming events for now.'
                ], 'No upcoming events', 200);
            }

            // Create signed URLs for the events' links
            // $eventLinks = $events->map(function ($event) use ($memberId) {
            //     return [
            //         'eventSlug' => $event->event_slug,
            //         'eventLink' => URL::signedRoute('event.link', [
            //             'slug' => $event->event_slug, // Correct the parameter name to match the route
            //             'ref' => $memberId // Using the correct member ID here
            //         ], now()->addMinutes(4320))
            //     ];
            // });

            $eventLinks = $events->map(function ($event) use ($memberId) {
                return [
                    'eventSlug' => $event->event_slug,
                    'eventLink' => URL::signedRoute('event.link', [
                        'slug' => $event->event_slug,
                        'ref' => $memberId
                    ]) // No expiry parameter now
                ];
            });


            // Return the response with the future events and their registration details
            return Utils::sendResponse([
                'events' => $events->map(function ($event) use ($memberId) {
                    // Convert the event to an array
                    $eventArray = $event->toArray();

                    // Generate the event link
                    // $eventLink = [
                    //     'eventLink' => URL::signedRoute('event.link', [
                    //         'slug' => $event->event_slug, // Ensure parameter name matches the route
                    //         'ref' => $memberId // Using the correct member ID
                    //     ], now()->addMinutes(4320))
                    // ];

                    $eventLink = [
                        'eventLink' => URL::signedRoute('event.link', [
                            'slug' => $event->event_slug, // Ensure parameter name matches the route
                            'ref' => $memberId // Using the correct member ID
                        ])
                    ];


                    // Reorder the array to place eventLink before registrations
                    $reorderedEvent = array_merge(
                        array_slice($eventArray, 0, array_search('registrations', array_keys($eventArray)), true),
                        $eventLink,
                        array_slice($eventArray, array_search('registrations', array_keys($eventArray)), null, true)
                    );

                    return $reorderedEvent;
                })
            ], 'Upcoming events retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Error retrieving events: ' . $th->getMessage());
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to retrieve events. Please try again.'
            ], 'Internal Server Error', 500);
        }
    }

    // public function eventDetails(Request $request, $id = null)
    // {
    //     try {
    //         if ($id) {
    //             // Get specific event by ID with related circle and all registrations
    //             $event = Event::with(['circle', 'registrations.members' => function ($query) {
    //                 $query->select('id', 'userId', 'firstName', 'lastName');
    //             }])
    //                 ->where('status', 'Active')
    //                 ->where('eventStatus', 'Publish')
    //                 ->whereDate('event_date', '>=', now()->format('Y-m-d'))
    //                 ->find($id);

    //             if (!$event) {
    //                 return Utils::errorResponse([
    //                     'error' => 'Event not found or inactive.'
    //                 ], 'Not Found', 404);
    //             }

    //             return Utils::sendResponse([
    //                 'event' => $event,
    //                 'registration_count' => $event->registrations->count()
    //             ], 'Event details retrieved successfully', 200);
    //         }

    //         // If no ID, return all future or current events
    //         $events = Event::with(['circle', 'registrations'])
    //             ->where('status', 'Active')
    //             ->where('eventStatus', 'Publish')
    //             ->whereDate('event_date', '>=', now()->format('Y-m-d'))
    //             ->orderBy('event_date', 'ASC')
    //             ->get();

    //         return Utils::sendResponse([
    //             'events' => $events->map(function ($event) {
    //                 return [
    //                     'id' => $event->id,
    //                     'eventName' => $event->event_name,
    //                     'eventDate' => $event->event_date,
    //                     'eventStatus' => $event->eventStatus,
    //                     'circle' => $event->circle,
    //                     'registration_count' => $event->registrations->count(),
    //                     'registrations' => $event->registrations
    //                 ];
    //             })
    //         ], 'Events retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }


    // public function eventDetails(Request $request, $id)
    // {
    //     try {
    //         // Get the authenticated user
    //         $authUser = auth()->user();

    //         // Get the member ID from the members table
    //         $memberId = Member::where('userId', $authUser->id)->value('id');

    //         if (!$memberId) {
    //             return Utils::errorResponse([
    //                 'error' => 'Member not found.'
    //             ], 'Not Found', 404);
    //         }

    //         // Get specific event by ID with related circle and all registrations
    //         $event = Event::with(['circle', 'registrations.members' => function ($query) {
    //             $query->select('id', 'userId', 'firstName', 'lastName');
    //         }])
    //             ->where('status', 'Active')
    //             ->where('eventStatus', 'Publish')
    //             ->whereDate('event_date', '>=', now()->format('Y-m-d'))
    //             ->find($id);

    //         if (!$event) {
    //             return Utils::errorResponse([
    //                 'error' => 'Event not found or inactive.'
    //             ], 'Not Found', 404);
    //         }

    //         // Generate signed link
    //         $eventLink = URL::signedRoute('event.link', [
    //             'slug' => $event->event_slug,
    //             'ref' => $memberId
    //         ], now()->addMinutes(60));

    //         return Utils::sendResponse([
    //             'event' => $event,
    //             'eventLink' => $eventLink,
    //             'registration_count' => $event->registrations->count()
    //         ], 'Event details retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }

    public function eventDetails(Request $request, $id)
    {
        try {
            // Get the authenticated user
            $authUser = auth()->user();

            // Get the member ID from the members table
            $memberId = Member::where('userId', $authUser->id)->value('id');

            if (!$memberId) {
                return Utils::errorResponse([
                    'error' => 'Member not found.'
                ], 'Not Found', 404);
            }

            // Get specific event by ID with related circle and all registrations
            $event = Event::with(['circle', 'registrations.members' => function ($query) {
                $query->select('id', 'userId', 'firstName', 'lastName');
            }])
                ->where('status', 'Active')
                ->where('eventStatus', 'Publish')
                ->whereDate('event_date', '>=', now()->format('Y-m-d'))
                ->find($id);

            if (!$event) {
                return Utils::errorResponse([
                    'error' => 'Event not found or inactive.'
                ], 'Not Found', 404);
            }

            // Check if the member is registered for this event
            $isRegistered = $event->registrations()->where('memberId', $memberId)->exists();

            // Generate signed link
            $eventLink = URL::signedRoute('event.link', [
                'slug' => $event->event_slug,
                'ref' => $memberId
            ], now()->addMinutes(60));

            return Utils::sendResponse([
                'event' => $event,
                'eventLink' => $eventLink,
                'registration_count' => $event->registrations->count(),
                'isRegistered' => $isRegistered
            ], 'Event details retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }


    // public function eventDetails(Request $request, $id = null)
    // {
    //     try {
    //         // Get the authenticated user
    //         $authUser = auth()->user();

    //         // Get the member ID from the members table
    //         $memberId = Member::where('userId', $authUser->id)->value('id');

    //         if (!$memberId) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Member not found.',
    //                 'data' => null
    //             ], 404);
    //         }

    //         // If specific event ID is passed
    //         if ($id) {
    //             // Get the event with circle and member data
    //             $event = Event::with([
    //                 'circle',
    //                 'registrations.members' => function ($query) {
    //                     $query->select('id', 'userId', 'firstName', 'lastName');
    //                 }
    //             ])
    //                 ->where('status', 'Active')
    //                 ->where('eventStatus', 'Publish')
    //                 ->whereDate('event_date', '>=', now()->format('Y-m-d'))
    //                 ->find($id);

    //             if (!$event) {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Event not found or inactive.',
    //                     'data' => null
    //                 ], 404);
    //             }

    //             // Generate signed link
    //             $eventLink = URL::signedRoute('event.link', [
    //                 'slug' => $event->event_slug,
    //                 'ref' => $memberId
    //             ], now()->addMinutes(60));

    //             // Return cleaned single event response
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Event details retrieved successfully',
    //                 'data' => [
    //                     'id' => $event->id,
    //                     'eventName' => $event->eventName,
    //                     'eventDate' => $event->event_date,
    //                     'eventStatus' => $event->eventStatus,
    //                     'circle' => $event->circle,
    //                     'registration_count' => $event->registrations->count(),
    //                     'eventLink' => $eventLink,
    //                     'registrations' => $event->registrations->map(function ($reg) {
    //                         return [
    //                             'id' => $reg->id,
    //                             'memberId' => $reg->memberId,
    //                             'member' => $reg->members
    //                         ];
    //                     }),
    //                 ]
    //             ], 200);
    //         }

    //         // If no ID is passed, return all upcoming events
    //         $events = Event::with([
    //             'circle',
    //             'registrations.members' => function ($query) {
    //                 $query->select('id', 'userId', 'firstName', 'lastName');
    //             }
    //         ])
    //             ->where('status', 'Active')
    //             ->where('eventStatus', 'Publish')
    //             ->whereDate('event_date', '>=', now()->format('Y-m-d'))
    //             ->orderBy('event_date', 'ASC')
    //             ->get();

    //         // Return mapped list of events
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Events retrieved successfully',
    //             'data' => $events->map(function ($event) use ($memberId) {
    //                 return [
    //                     'id' => $event->id,
    //                     'eventName' => $event->eventName,
    //                     'eventDate' => $event->event_date,
    //                     'eventStatus' => $event->eventStatus,
    //                     'circle' => $event->circle,
    //                     'registration_count' => $event->registrations->count(),
    //                     'eventLink' => URL::signedRoute('event.link', [
    //                         'slug' => $event->event_slug,
    //                         'ref' => $memberId
    //                     ], now()->addMinutes(60)),
    //                     'registrations' => $event->registrations->map(function ($reg) {
    //                         return [
    //                             'id' => $reg->id,
    //                             'memberId' => $reg->memberId,
    //                             'member' => $reg->members
    //                         ];
    //                     }),
    //                 ];
    //             })
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Internal Server Error',
    //             'data' => null,
    //             'error' => $th->getMessage()
    //         ], 500);
    //     }
    // }



    public function storeUserDetails(Request $request)
    {
        try {
            $eventReg = new EventRegister();

            $isRegistered = EventRegister::where('memberId', auth()->user()->member->id)
                ->where('eventId', $request->eventId)
                ->exists();

            if ($isRegistered) {
                return Utils::errorResponse([
                    'error' => 'You are already registered for this event.'
                ], 'Already Registered', 400);
            }

            $eventReg->memberId = auth()->user()->member->id;
            $eventReg->eventId = $request->eventId;
            $eventReg->paymentStatus = 'Event Is Free';
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
            $registerList = EventRegister::where('eventId', $id)
                ->with([
                    'members' => function ($query) {
                        $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto', 'circleId', 'businessCategoryId');
                    },
                    'members.circle' => function ($query) {
                        $query->select('id', 'circleName', 'cityId')
                            ->with(['city' => function ($query) {
                                $query->select('id', 'cityName');
                            }]);
                    },
                    'members.bCategory' => function ($query) {
                        $query->select('id', 'categoryName');
                    }
                ])
                ->get();
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

    public function handleEventRegistration(Request $request)
    {
        try {
            $eventPayment = new EventRegister();
            $eventPayment->eventId = $request->eventId;
            $eventPayment->memberId = Auth::user()->member->id;
            $eventPayment->paymentStatus = 'unpaid';
            $eventPayment->save();

            // Return a success response
            return Utils::sendResponse([], 'You are registered for the event', 200);
        } catch (\Throwable $th) {
            // Return with an error message
            return Utils::errorResponse([
                'error' => 'Failed to register for the event, please try again.'
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


    public function eventPaymentVisitor(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'paymentId' => 'required|string',
                'amount' => 'required',
                'eventId' => 'required|integer',
            ]);

            $visitorId = Auth()->id();

            // Store the payment ID in the Razorpay payments table
            $payment = new Razorpay();
            $payment->r_payment_id = $validatedData['paymentId'];
            $payment->amount = $validatedData['amount']  / 100; // Convert paise to rupees
            $payment->save();

            // Register for the event
            $eventPayment = new VisitorEventRegister();
            $eventPayment->eventId = $visitorId;
            $eventPayment->visitorId = $visitorId;
            $eventPayment->paymentStatus = 'paid';
            $eventPayment->save();

            // Store the payment details in the AllPayments table
            $allPayments = new AllPayments();
            $allPayments->amount = $payment->amount;
            $allPayments->paymentType = 'RazorPay';
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Event Register Visitor Payment';
            $allPayments->remarks = $payment->r_payment_id;
            $allPayments->save();

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'Payment received successfully',
                'data' => [
                    'payment_id' => $payment->r_payment_id,
                    'amount' => $payment->amount,
                ],
            ], 200);
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Return an error response
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment',
                'error' => $th->getMessage(),
            ], 500);
        }
    }
}
