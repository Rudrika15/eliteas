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
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;

class CircleMeetingMemberBusinessController extends Controller
{

    // public function __construct()
    // {
    //     // Apply middleware for circle call-related permissions
    //     $this->middleware('permission:circle-meeting-member-business-index', ['only' => ['index', 'view']]);
    //     $this->middleware('permission:circle-meeting-member-business-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:circle-meeting-member-business-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:circle-meeting-member-business-delete', ['only' => ['delete']]);
    //     $this->middleware('permission:edit-payment', ['only' => ['editPayment']]);
    //     $this->middleware('permission:update-payment', ['only' => ['updatePayment']]);
    // }

    public function index(Request $request)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            // Format the amount with commas
            $busGiver->transform(function ($item) {
                $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
                return $item;
            });

            $busGiveByOther = CircleMeetingMembersBusiness::where('businessGiverId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            // Format the amount with commas
            $busGiveByOther->transform(function ($item) {
                $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
                return $item;
            });
            return view('admin.circlebusiness.index', compact('busGiver', 'busGiveByOther'));
        } catch (\Throwable $th) {
            // throw $th;
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
            return view('admin.circlebusiness.create', \compact('busGiver'));
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
        ]);
        try {
            $busGiver = new CircleMeetingMembersBusiness();
            // $busGiver->memberId = $request->memberId;
            $busGiver->businessGiverId = $request->businessGiverId;
            $busGiver->loginMemberId = $request->loginMemberId;
            $busGiver->amount = $request->amount;
            $busGiver->date = $request->date;
            $busGiver->remarks = $request->remarks;
            $busGiver->status = 'Active';

            $busGiver->save();

            return redirect()->route('busGiver.index')->with('success', 'Created Successfully!');
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

            // return $busGiver;
            // $busGiver->memberId = $request->memberId;
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
