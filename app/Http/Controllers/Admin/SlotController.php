<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegister;
use App\Models\Member;
use App\Models\Slot;
use App\Models\SlotBooking;
use App\Models\Visitor;
use App\Models\VisitorEventRegister;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlotController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle type-related permissions
        $this->middleware('permission:slot-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:slot-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:slot-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:slot-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        try {
            $slot = Slot::where('status', 'Active')->paginate(10);
            return view('admin.slot.index', compact('slot'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function userListView(Request $request, $id)
    {
        try {

            $event = Event::findOrFail($id);

            $users = EventRegister::where('eventId', $id)
                ->where('status', 'Active')
                ->where('memberId', '!=', Auth::user()->member ? Auth::user()->member->id : null)
                ->get()
                ->map(function ($user) {
                    $user->type = 'member'; // Add a type key
                    return $user;
                });

            $visitors = VisitorEventRegister::where('eventId', $id)
                ->where('status', 'Active')
                ->get()
                ->map(function ($visitor) {
                    $visitor->type = 'visitor'; // Add a type key
                    return $visitor;
                });

            $visitorsUsers = $users->merge($visitors);

            $slots = Slot::where('status', 'Active')->get();

            $slotBooking = SlotBooking::where('eventId', $id)
                ->where('status', 'Active')
                ->get();


            return view('admin.slot.viewMembers', compact('users', 'event', 'slots', 'visitorsUsers', 'slotBooking'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function userListViewforVisitors(Request $request, $id)
    {
        try {
            $event = Event::findOrFail($id);

            $users = EventRegister::where('eventId', $id)
                ->where('status', 'Active')
                ->get()
                ->map(function ($user) {
                    $user->type = 'member'; // Add a type key
                    return $user;
                });

            $visitors = VisitorEventRegister::where('eventId', $id)
                ->where('status', 'Active')
                ->where('visitorId', '!=', session()->get('visitor_id'))
                ->get()
                ->map(function ($visitor) {
                    $visitor->type = 'visitor'; // Add a type key
                    return $visitor;
                });

            $visitorsUsers = $users->merge($visitors);

            $slotBooking = SlotBooking::where('eventId', $id)
                ->where('status', 'Active')
                ->get();

            $slots = Slot::where('status', 'Active')->get();

            return view('admin.slot.viewMembersForVisitors', compact('users', 'event', 'slots', 'slotBooking', 'visitorsUsers'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }


    // public function profileViewMember(Request $request)
    // {
    //     try {

    //         $id = $request->id;

    //         return view('visitor.profileView');
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }


    public function profileViewMember(Request $request)
    {
        try {
            $id = $request->id;
            $member = Member::find($id);
            return view('visitor.profileView', compact('member'));
        } catch (\Throwable $th) {
            // Log error and return a server error view
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function profileViewUser(Request $request)
    {
        try {
            $id = $request->id;
            $visitor = Visitor::find($id);
            return view('visitor.userProfileView', compact('visitor'));
        } catch (\Throwable $th) {
            // Log error and return a server error view
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
            return view('admin.slot.create');
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
            $slot = new Slot();
            $slot->start_time = $request->start_time;
            $slot->end_time = $request->end_time;
            $slot->save();

            return redirect()->route('slot.index')->with('success', 'Event Type Created Successfully!');
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
            $slot = Slot::find($id);
            return view('admin.slot.edit', compact('slot'));
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
        $this->validate($request, [
            'id' => 'required|exists:slots,id',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try {
            $slot = Slot::find($request->id);

            if (!$slot) {
                return redirect()->route('slot.index')->with('error', 'Slot not found.');
            }

            $slot->start_time = $request->start_time;
            $slot->end_time = $request->end_time;
            $slot->status = 'Active';
            $slot->save();

            return redirect()->route('slot.index')->with('success', 'Slot updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('slot.index')->with('error', 'Failed to update Slot details.');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $slot = Slot::find($id);

            if (!$slot) {
                return redirect()->route('slot.index')->with('error', 'Slot not found.');
            }

            $slot->status = 'Deleted';
            $slot->save();

            return redirect()->route('slot.index')->with('success', 'Slot deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('slot.index')->with('error', 'Failed to delete Slot.');
        }
    }

    public function slotBookingVisitor(Request $request)
    {

        $this->validate($request, [
            'slotId' => 'required',
            'eventId' => 'required',
        ]);

        try {
            $slot = new SlotBooking();
            $slot->eventId = $request->eventId;
            $slot->slotId = $request->slotId;
            $slot->visitorId = $request->visitorId;
            $slot->regMemberId = $request->regMemberId;
            $slot->date = date('Y-m-d');
            $slot->bookingStatus = 'Pending';
            $slot->status = 'Active';
            $slot->save();

            return back()->with('success', 'Booking Successfull!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function visitorSlotBookingRequests(Request $request, $id)
    {
        try {

            $visitorId = session()->get('visitor_id');

            $event = Event::find($id);

            $slotBooking = SlotBooking::where('eventId', $id)->where('regMemberId', $visitorId)->paginate(10);

            return view('visitor.visitorSlotBookingList', compact('slotBooking', 'event'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function visitorSlotBookingRequestedList(Request $request, $id)
    {
        try {

            $visitorId = session()->get('visitor_id');

            $event = Event::find($id);

            $slotBooking = SlotBooking::where('eventId', $id)->where('regMemberId', $visitorId)->paginate(10);

            return view('visitor.visitorSlotBookingList', compact('slotBooking', 'event'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }





    public function memberSlotBookingRequests(Request $request, $id)
    {

        try {

            $memberId = Auth::user()->member->id;

            $event = Event::find($id);

            $slotBooking = SlotBooking::where('eventId', $id)->where('regMemberId', $memberId)->paginate(10);

            return view('admin.event.memberSlotBookingList', compact('slotBooking', 'event'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function slotBookingMember(Request $request)
    {

        $user = auth()->user()->member->id;

        $this->validate($request, [
            'slotId' => 'required',
            'eventId' => 'required',
        ]);

        try {
            $slot = new SlotBooking();
            $slot->eventId = $request->eventId;
            $slot->slotId = $request->slotId;
            $slot->userId = $user;
            $slot->regMemberId = $request->regMemberId;
            $slot->date = date('Y-m-d');
            $slot->bookingStatus = 'Pending';
            $slot->status = 'Active';
            $slot->save();

            return back()->with('success', 'Booking Successfull!');
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
