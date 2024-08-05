<?php

namespace App\Http\Controllers\visitor;

use Illuminate\Http\Request;
use App\Models\VisitorsDetails;
use App\Http\Controllers\Controller;

class VisitorFormController extends Controller
{
    public function index()
    {
        $visitors = VisitorsDetails::latest()->paginate(10);
        return view('visitor.index', compact('visitors'));
    }


    public function visitorForm()
    {
        return view('visitor.visitorForm');
    }

    public function storsssse()
    {

        return redirect('visitor.form')->with('success', 'Your Information Updated Successfully');
    }

    public function store(Request $request)
    {
        // return $request;

        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'mobileNo' => 'required',
            'businessName' => 'required',
            'businessCategory' => 'required',
            'product' => 'required',
            'networkingGroup' => 'required',
            'circleMeet' => 'required',
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
            $visitor->status = 'Active';

            $visitor->save();

            return redirect()->route('visitor.form')->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
