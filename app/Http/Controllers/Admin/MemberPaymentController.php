<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use App\Models\Member;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\MemberPayment;

class MemberPaymentController extends Controller
{
    public function index(Request $request)
    {
        try {

            $payment = MemberPayment::where('status', 'Active')->get();
            return view('admin.payment.index', compact('payment'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $payment = MemberPayment::with('country')->findOrFail($id);
            return response()->json($payment);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $member = Member::where('status', '!=', 'Deleted')->get();
            return view('admin.state.create', compact('member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'stateName' => 'required',
        ]);
        try {
            $payment = new MemberPayment();
            $payment->countryId = $request->countryId;
            $payment->paymentName = $request->paymentName;
            $payment->status = 'Active';

            $payment->save();

            return redirect()->route('state.index')->with('success', 'State Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $state = State::find($id);
            $country = Country::where('status', '!=', 'Deleted')->get();
            return view('admin.state.edit', compact('country', 'state'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'stateName' => 'required',

        ]);
        try {
            $id = $request->id;
            $state = State::find($id);
            $state->countryId = $request->countryId;
            $state->stateName = $request->stateName;
            $state->status = 'Active';

            $state->save();


            return redirect()->route('state.index')->with('success', 'State Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $state = State::find($id);
            $state->status = "Deleted";
            $state->save();
            $response = [
                'success' => true,
                'message' => 'State Deleted Successfully!',
            ];

            return response()->json($response);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
