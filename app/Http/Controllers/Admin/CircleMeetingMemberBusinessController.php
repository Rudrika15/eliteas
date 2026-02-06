<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Member;
use App\Models\Schedule;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use App\Models\BusinessAmount;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Circle;
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\City; // Added City model import

class CircleMeetingMemberBusinessController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle call-related permissions
        $this->middleware('permission:circle-meeting-member-business-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:circle-meeting-member-business-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:circle-meeting-member-business-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:circle-meeting-member-business-delete', ['only' => ['delete']]);
        $this->middleware('permission:edit-payment', ['only' => ['editPayment']]);
        $this->middleware('permission:update-payment', ['only' => ['updatePayment']]);
    }

    // public function index(Request $request)
    // {
    //     try {
    //         $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->paginate(10);

    //         // Format the amount with commas
    //         $busGiver->transform(function ($item) {
    //             $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
    //             return $item;
    //         });

    //         $busGiveByOther = CircleMeetingMembersBusiness::with('loginMember')
    //             ->where('businessGiverId', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->paginate(10);

    //             // Format the amount with commas
    //             $busGiveByOther->transform(function ($item) {
    //                 $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
    //                 return $item;
    //             });

    //         $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();

    //         $circleMember = Member::with('circle')
    //             ->where('status', 'Active')
    //             ->orderBy('firstName', 'ASC')
    //             ->get();


    //         $circlemeeting = CircleMeeting::where('status', 'Active')->get();

    //         return view('admin.circlebusiness.index', compact('busGiver', 'busGiveByOther', 'circlemeeting', 'circles', 'circleMember'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         return view('servererror');
    //     }
    // }


    public function index(Request $request)
    {
        try {
            if (auth()->user()->hasRole('Member')) {

                // Lock Logic Setup
                $user = Auth::user();
                $memberAuth = Member::where('userId', $user->id)->first();
                $circleId = $memberAuth ? $memberAuth->circleId : null;
                $schedules = collect();
                $isLocked = false;

                if ($circleId) {
                    $schedules = Schedule::where('circleId', $circleId)->orderBy('date', 'asc')->get();
                    $nextMeeting = $schedules->first(function ($item) {
                        return $item->date >= Carbon::now()->format('Y-m-d');
                    });
                    $isLocked = $nextMeeting ? $nextMeeting->is_locked : false;
                }

                // For Member
                $busGiver = CircleMeetingMembersBusiness::with('reference')
                    ->where('loginMemberId', Auth::user()->id)
                    ->where('status', 'Active')
                    ->orderBy('id', 'DESC')
                    ->paginate(10, ['*'], 'page_received');

                // Transform underlying collection items
                $busGiver->getCollection()->transform(function ($item) use ($schedules) {
                    $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
                    // Lock Logic
                    $dateToCheck = $item->date ? $item->date : $item->created_at->format('Y-m-d');
                    $meeting = $schedules->first(function ($s) use ($dateToCheck) {
                        return $s->date >= $dateToCheck;
                    });
                    $item->is_locked_row = $meeting ? $meeting->is_locked : false;
                    return $item;
                });

                $busGiveByOther = CircleMeetingMembersBusiness::with(['loginMember', 'reference'])
                    ->where('businessGiverId', Auth::user()->id)
                    ->where('status', 'Active')
                    ->orderBy('id', 'DESC')
                    ->paginate(10, ['*'], 'page_given');

                // Transform underlying collection items
                $busGiveByOther->getCollection()->transform(function ($item) use ($schedules) {
                    $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
                    // Lock Logic
                    $dateToCheck = $item->date ? $item->date : $item->created_at->format('Y-m-d');
                    $meeting = $schedules->first(function ($s) use ($dateToCheck) {
                        return $s->date >= $dateToCheck;
                    });
                    $item->is_locked_row = $meeting ? $meeting->is_locked : false;
                    return $item;
                });

                $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();
                $circleMember = Member::with('circle')
                    ->where('status', 'Active')
                    ->orderBy('firstName', 'ASC')
                    ->get();
                $circlemeeting = CircleMeeting::where('status', 'Active')->get();

                $minDate = Carbon::now()->subDays(15)->format('Y-m-d');
                $maxDate = Carbon::now()->format('Y-m-d');

                return view('admin.circlebusiness.index', compact('busGiver', 'busGiveByOther', 'circlemeeting', 'circles', 'circleMember', 'isLocked', 'minDate', 'maxDate'));
            }

            // Default unauthorized
            return redirect()->back()->with('error', 'Unauthorized access.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }





    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            return response()->json($busGiver);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
    public function create(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::find($id);
            $minDate = Carbon::now()->subDays(15)->format('Y-m-d');
            $maxDate = Carbon::now()->format('Y-m-d');
            return view('admin.circlebusiness.create', compact('busGiver', 'minDate', 'maxDate'));
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
            // 'dateTime' => 'required',
            // 'totalMeeting' => 'required',
            // 'refGiven' => 'required',
            // 'refTaken' => 'required',
            // 'busGiven' => 'required',
            // 'busTaken' => 'required',
            // 'hotelName' => 'required',
       // ]);
        try {
            // Lock Check
            $dateToCheck = $request->date ? $request->date : Carbon::now()->format('Y-m-d');
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $dateToCheck)
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'The meeting for this date is locked. You cannot add new entries.');
                }
            }

            $busGiver = new CircleMeetingMembersBusiness();
            // $busGiver->memberId = $request->memberId;
            $busGiver->businessGiverId = $request->businessGiverId;
            $busGiver->loginMemberId = $request->loginMemberId;
            $busGiver->amount = $request->amount;
            $busGiver->date = $request->date;
            $busGiver->remarks = $request->remarks;
            $busGiver->status = 'Active';

            if ($request->filled('referenceId')) {
                $busGiver->referenceId = $request->referenceId;
            }
            $busGiver->save();

            // return redirect()->route('busGiver.index')->with('success', 'Created Successfully!');
            return redirect()->back()->with('success', 'Created Successfully!');
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
            $busGiver = CircleMeetingMembersBusiness::find($id);
            $paymentHistory = BusinessAmount::where('circleMeetingMemberBusinessId', $id)->get();
            return view('admin.circlebusiness.edit', compact('busGiver', 'paymentHistory'));
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
        $this->validate($request, []);
        try {
            $id = $request->id;
            $busGiver = CircleMeetingMembersBusiness::find($id);

            // Lock Check
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                 // Check based on ORIGINAL date
                 $dateToCheck = $busGiver->date ? $busGiver->date : $busGiver->created_at->format('Y-m-d');
                 $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $dateToCheck)
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'This record is locked and cannot be updated.');
                }
            }

            // return $busGiver;
            // $busGiver->memberId = $request->memberId;
            $busGiver->referenceId = $request->referenceId;
            $busGiver->businessGiverId = $request->businessGiverId;
            $busGiver->loginMemberId = $request->loginMemberId;
            $busGiver->amount += $request->amount;
            $busGiver->date = $request->date;
            $busGiver->status = 'Active';
            $busGiver->update();

            $businessAmount = new BusinessAmount();
            $businessAmount->circleMeetingMemberBusinessId = $id;
            $businessAmount->amount = $request->amount;
            $businessAmount->date = Carbon::now()->toDateString();
            $businessAmount->status = 'Active';
            $businessAmount->save();


            return redirect()->route('busGiver.index')->with('success', ' Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function editPayment(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::find($id);

            $payment = BusinessAmount::findOrFail($id);

            return view('admin.circlebusiness.updatePayment', compact('payment', 'busGiver'));
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }


    public function updatePayment(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'date' => 'required|date',
            ]);

            // Find the payment record by ID
            $payment = BusinessAmount::findOrFail($id);

            // Update the payment amount
            if ($request->amount) {
                $payment->amount += $request->amount;
            } else {
                $payment->amount -= $request->removeAmount;
            }

            // Update other payment details
            $payment->date = $request->date;
            $payment->status = 'Active';
            $payment->save();

            // Find the business giver record and update
            $busGiver = CircleMeetingMembersBusiness::find($request->circleMeetingMemberBusinessId);
            $busGiver->amount += $request->amount;
            $busGiver->amount -= $request->removeAmount;
            $busGiver->date = $request->date;
            $busGiver->status = 'Active';
            $busGiver->save();

            // Redirect with success message
            return redirect()->route('busGiver.index')->with('success', 'Payment updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->back()->with('error', 'Failed to update payment.');
        }
    }


    function delete(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::find($id);

            // Lock Check
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                 // Check based on ORIGINAL date
                 $dateToCheck = $busGiver->date ? $busGiver->date : $busGiver->created_at->format('Y-m-d');
                 $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $dateToCheck)
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'This record is locked and cannot be deleted.');
                }
            }

            $busGiver->status = "Deleted";
            $busGiver->save();

            return redirect()->route('busGiver.index')->with('success', ' Deleted Successfully!');
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
