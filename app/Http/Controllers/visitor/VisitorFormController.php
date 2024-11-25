<?php

namespace App\Http\Controllers\visitor;

use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\VisitorsDetails;
use App\Models\BusinessCategory;
use App\Models\MeetingInvitation;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Support\Facades\URL;
use Throwable;

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
        $businessCategory = BusinessCategory::all();
        return view('visitor.visitorForm', compact('businessCategory'));
    }

    //     public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'firstName' => 'required',
    //         'lastName' => 'required',
    //         'mobileNo' => 'required',
    //         'businessName' => 'required',
    //         'businessCategory' => 'required',
    //         // 'invitedBy' => 'required',
    //     ]);

    //     try {
    //         // Create a new VisitorsDetails object
    //         $visitor = new VisitorsDetails();
    //         $visitor->firstName = $request->firstName;
    //         $visitor->lastName = $request->lastName;
    //         $visitor->mobileNo = $request->mobileNo;
    //         $visitor->businessName = $request->businessName;

    //         // Determine business category and assign it to the visitor
    //         if ($request->businessCategory == 'other') {
    //             // If 'other', assign the otherCategory value
    //             $visitor->businessCategory = $request->otherCategory; // Make sure VisitorsDetails has this property
    //         } else {
    //             // Otherwise, assign the selected business category
    //             $visitor->businessCategory = $request->businessCategory;
    //         }

    //         // Save to the BusinessCategory model (if you want to save the category separately)
    //         $business = new BusinessCategory();
    //         $business->categoryName = $visitor->businessCategory; // Save the appropriate category
    //         $business->save();

    //         // Assign additional properties to the visitor
    //         $visitor->product = $request->product;
    //         $visitor->networkingGroup = $request->networkingGroup;
    //         $visitor->circleMeet = $request->circleMeet;
    //         $visitor->invitedBy = $request->invitedBy;
    //         $visitor->knowUs = $request->knowsUs; // Make sure this matches the field name
    //         $visitor->status = 'Active';

    //         // Save the visitor information
    //         $visitor->save();

    //         return redirect()->route('visitor.form')->with('success', 'Your Information Submitted Successfully!');
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError($th, $request->fullUrl());

    //         // Return a generic error view or message
    //         return redirect()->route('visitor.form')->with('error', 'Failed to submit your information');
    //     }
    // }

    public function store(Request $request)
    {
        try {
            // Create a new VisitorsDetails object
            $visitor = new VisitorsDetails();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;

            // Determine business category and assign it to the visitor
            if ($request->businessCategory == 'other') {
                // If 'other', assign the otherCategory value and check if already exists
                $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();
                if (!$business) {
                    $business = new BusinessCategory();
                    $business->categoryName = $request->otherCategory;
                    $business->save();
                }
                $visitor->businessCategory = $business->id;
            } else {
                // Otherwise, assign the selected business category
                $visitor->businessCategory = $request->businessCategory;
            }

            // Assign additional properties to the visitor
            $visitor->product = $request->product;
            $visitor->networkingGroup = $request->networkingGroup;
            $visitor->circleMeet = $request->circleMeet;
            $visitor->invitedBy = $request->invitedBy;
            $visitor->knowUs = $request->knowsUs; // Make sure this matches the field name
            $visitor->meetingId = $request->meetingId;
            $visitor->status = 'Active';

            // Save the visitor information
            $visitor->save();

            $invitation = new MeetingInvitation();
            $invitation->meetingId = $request->meetingId;
            $invitation->invitedMemberId = $visitor->invitedBy;
            $invitation->personName = $request->firstName . ' ' . $request->lastName;
            $invitation->personEmail = null;
            $invitation->personContact = $visitor->mobileNo;
            $invitation->businessCategoryId = $visitor->businessCategory;
            $invitation->personEmail = 'Unpaid';
            $invitation->save();


            return redirect()->back()->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            // Return a generic error view or message
            return redirect()->back()->with('error', 'Failed to submit your information');
        }
    }


    public function visitorsFormView()
    {
        $businessCategory = BusinessCategory::all();
        return view('visitor.visitorForms', compact('businessCategory'));
    }



    public function visitorStore(Request $request)
    {
        try {
            // Create a new VisitorsDetails object
            $visitor = new VisitorsDetails();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;

            // Determine business category and assign it to the visitor
            if ($request->businessCategory == 'other') {
                // If 'other', assign the otherCategory value and check if already exists
                $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();
                if (!$business) {
                    $business = new BusinessCategory();
                    $business->categoryName = $request->otherCategory;
                    $business->save();
                }
                $visitor->businessCategory = $business->id;
            } else {
                // Otherwise, assign the selected business category
                $visitor->businessCategory = $request->businessCategory;
            }

            // Assign additional properties to the visitor
            $visitor->product = $request->product;
            $visitor->networkingGroup = $request->networkingGroup;
            $visitor->circleMeet = $request->circleMeet;
            $visitor->invitedBy = $request->invitedBy;
            $visitor->knowUs = $request->knowsUs; // Make sure this matches the field name
            $visitor->status = 'Active';

            // Save the visitor information
            $visitor->save();


            return redirect()->route('visitors.form.view')->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            // Log the error
            throw $th;
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a generic error view or message
            return redirect()->route('visitors.form.view')->with('error', 'Failed to submit your information');
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

    // public function updateVisitorProfile(Request $request)
    // {
    //     return view('visitor.profile');
    // }

    public function updateVisitorProfile($id = 0)
    {
        try {
            if ($id === 0) {
                $id = session('visitor_id');
            }

            // Fetch profile data based on the provided $id
            $visitor = Visitor::where('id', '=', $id)->first();
            $businessCategory = BusinessCategory::where('status', 'Active')->get();

            return view('visitor.profile', compact('visitor', 'businessCategory'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            // In case of an error, redirect to servererror view
            return view('servererror');
        }
    }


    public function profileUpdate(Request $request)
    {
        // return $request;

        try {

            $id = $request->input('id');
            $visitor = Visitor::find($id);

            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->email = $request->email;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessCategory = $request->businessCategory;
            $visitor->birthDate = $request->birthDate;
            $visitor->gender = $request->gender;
            $visitor->save();


            return redirect()->route('visitor.profile')->with('success', 'Profile Updated Successfully!');
        } catch (Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
}
