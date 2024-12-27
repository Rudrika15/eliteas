<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use App\Models\Event;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    // public function __construct()
    // {
    //     // Apply middleware for coupon-related permissions
    //     $this->middleware('permission:coupon-index', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:coupon-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:coupon-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:coupon-delete', ['only' => ['delete']]);
    // }


    public function index(Request $request)
    {
        try {
            $coupon = Coupons::where('status', 'Active')->paginate(10);
            return view('admin.coupon.index', compact('coupon'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $events = Event::where('status', 'Active')->get();
            $coupon = Coupons::where('status', 'Active')->get();
            return view('admin.coupon.create', compact('coupon','events'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'eventId' => 'required',
            'amount' => 'required',
        ]);

        try {
            $coupon = new Coupons();
            $coupon->eventId = $request->eventId;
            $coupon->couponName = $request->couponName;
            $coupon->couponCode = $request->couponCode;
            $coupon->amount = $request->amount;
            $coupon->status = 'Active';
            $coupon->save();

            return redirect()->route('coupon.index')->with('success', 'Coupon Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $events = Event::where('status', 'active')->get();
            $coupon = Coupons::find($id);
            return view('admin.coupon.edit', compact('coupon', 'events'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:countries,id',
        ]);

        try {
            $coupon = Coupons::find($request->id);

            if (!$coupon) {
                return redirect()->route('coupon.index')->with('error', 'coupon not found.');
            }

            $coupon->eventId = $request->eventId;
            $coupon->couponName = $request->couponName;
            $coupon->couponCode = $request->couponCode;
            $coupon->amount = $request->amount;
            $coupon->status = 'Active';
            $coupon->save();

            return redirect()->route('coupon.index')->with('success', 'coupon details updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('coupon.index')->with('error', 'Failed to update coupon details.');
        }
    }


    public function delete($id)
    {
        try {
            $coupon = Coupons::find($id);

            if (!$coupon) {
                return redirect()->route('coupon.index')->with('error', 'coupon not found.');
            }

            $coupon->status = 'Deleted';
            $coupon->save();

            return redirect()->route('coupon.index')->with('success', 'coupon deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('coupon.index')->with('error', 'Failed to delete coupon.');
        }
    }

    public function validateCouponCode(Request $request)
{
    $couponCode = $request->input('couponCode');
    $eventId = $request->input('eventId');

    // Find the coupon from the database
    $coupon = Coupons::where('couponCode', $couponCode)->where('eventId', $eventId)->where('status', 'Active')->first();

    if ($coupon) {
        return response()->json([
            'success' => true,
            'discount' => $coupon->amount // Assuming discount is in INR
        ]);
    } else {
        return response()->json(['success' => false]);
    }
}

}
