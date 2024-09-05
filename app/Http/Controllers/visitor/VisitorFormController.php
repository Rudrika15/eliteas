<?php

namespace App\Http\Controllers\visitor;

use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\VisitorsDetails;
use App\Http\Controllers\Controller;

class VisitorFormController extends Controller
{

    public function storsssse()
    {

        return redirect('visitor.form')->with('success', 'Your Information Updated Successfully');
    }

    public function index()
    {
        try {
            $visitors = VisitorsDetails::latest()->paginate(10);
            return view('visitor.index', compact('visitors'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view or message
            return view('servererror')->with('error', 'Failed to load visitors');
        }
    }

    public function visitorForm()
    {
        return view('visitor.visitorForm');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'mobileNo' => 'required',
            'businessName' => 'required',
            'businessCategory' => 'required',
            'invitedBy' => 'required',
        ]);

        try {
            $visitor = new VisitorsDetails();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;
            $visitor->businessCategory = $request->businessCategory;
            $visitor->product = $request->product;
            $visitor->networkingGroup = $request->networkingGroup;
            $visitor->circleMeet = $request->circleMeet;
            $visitor->invitedBy = $request->invitedBy;
            $visitor->knowUs = $request->knowUs;
            $visitor->status = 'Active';

            $visitor->save();

            return redirect()->route('visitor.form')->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a generic error view or message
            return redirect()->route('visitor.form')->with('error', 'Failed to submit your information');
        }
    }

    public function updateRemark(Request $request)
    {
        try {
            $visitor = VisitorsDetails::find($request->id);
            if ($visitor) {
                $visitor->remarks = $request->remarks;
                $visitor->save();

                return response()->json(['success' => true]);
            }

            return response()->json(['success' => false, 'message' => 'Visitor not found']);
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a generic error response
            return response()->json(['success' => false, 'message' => 'Failed to update remarks']);
        }
    }

}
