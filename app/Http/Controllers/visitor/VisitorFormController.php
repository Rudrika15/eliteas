<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\MeetingInvitation;
use App\Models\Visitor;
use App\Models\VisitorsDetails;
use App\Models\VisitorForm;
use App\Models\Member;
use App\Models\Schedule;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
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
        $businessCategory = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();

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
            $visitor = new VisitorsDetails;
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;
            $visitor->createdBy = Auth::user()->id;
            $visitor->circleMeet = $request->circleMeet;

            // Determine business category and assign it to the visitor
            if ($request->businessCategory == 'other') {
                // If 'other', assign the otherCategory value and check if already exists
                $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();
                if (! $business) {
                    $business = new BusinessCategory;
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
            $visitor->isUser = 'No';

            // Save the visitor information
            $visitor->save();

            $invitation = new MeetingInvitation;
            $invitation->meetingId = $request->meetingId;
            $invitation->invitedMemberId = $visitor->invitedBy;
            $invitation->personName = $request->firstName.' '.$request->lastName;
            $invitation->personEmail = null;
            $invitation->personContact = $visitor->mobileNo;
            $invitation->businessCategoryId = $visitor->businessCategory;
            // $invitation->personEmail = 'Unpaid';
            $invitation->save();

            return redirect()->back()->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            // Log the error
            throw $th;
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a generic error view or message
            return redirect()->back()->with('error', 'Failed to submit your information');
        }
    }

    public function visitorsFormView()
    {
        $businessCategory = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();

        return view('visitor.visitorForms', compact('businessCategory'));
    }

    public function visitorStore(Request $request)
    {
        try {
            // Create a new VisitorsDetails object
            $visitor = new VisitorsDetails;
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;

            // Determine business category and assign it to the visitor
            if ($request->businessCategory == 'other') {
                // If 'other', assign the otherCategory value and check if already exists
                $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();
                if (! $business) {
                    $business = new BusinessCategory;
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

            if ($request->profilePhoto) {
                $visitor->profilePhoto = time().'.'.$request->profilePhoto->extension();
                $request->profilePhoto->move(public_path('ProfilePhoto'), $visitor->profilePhoto);
            }
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

    public function showEncryptedVisitorForm(Request $request)
    {
        try {
            $code = $request->query('code');
            if (!$code) {
                return view('servererror')->with('error', 'Invalid Form Link');
            }

            $formId = Crypt::decryptString($code);
            $visitorForm = VisitorForm::with('circle')->findOrFail($formId);

            $businessCategory = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            $members = Member::where('status', 'Active')->where('circleId', $visitorForm->circle_id)->orderBy('firstName', 'asc')->get();
            if ($members->isEmpty()) {
                $members = Member::where('status', 'Active')->orderBy('firstName', 'asc')->get();
            }

            return view('visitor.publicRegisterForm', compact('visitorForm', 'businessCategory', 'members', 'code'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror')->with('error', 'Invalid or expired visitor form link.');
        }
    }

    public function storeEncryptedVisitorForm(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'mobileNo' => 'required',
            'email' => 'required|email',
            'businessName' => 'required',
            'businessCategory' => 'required',
            'invitedBy' => 'required',
        ]);

        try {
            $formId = Crypt::decryptString($request->code);
            $visitorForm = VisitorForm::with('circle')->findOrFail($formId);

            // Business category handling
            if ($request->businessCategory == 'other') {
                $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();
                if (!$business) {
                    $business = new BusinessCategory();
                    $business->categoryName = $request->otherCategory;
                    $business->status = 'Active';
                    $business->save();
                }
                $bCategoryId = $business->id;
            } else {
                $bCategoryId = $request->businessCategory;
            }

            // Fetch latest meeting schedule ID for this circle
            $latestSchedule = Schedule::where('circleId', $visitorForm->circle_id)->orderBy('id', 'desc')->first();
            $meetingId = $latestSchedule ? $latestSchedule->id : 0;

            // 1. Insert into visitors_details table
            $visitor = new VisitorsDetails();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->email = $request->email;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;
            $visitor->businessCategory = $bCategoryId;
            $visitor->product = $request->product;
            $visitor->networkingGroup = $request->networkingGroup;
            $visitor->circleMeet = $visitorForm->circle->circleName ?? '';
            $visitor->circleId = $visitorForm->circle_id;
            $visitor->meetingId = $meetingId;
            $visitor->invitedBy = $request->invitedBy ?? 0;
            $visitor->knowUs = $request->knowUs ?? $request->knowsUs;
            $visitor->status = 'Active';
            $visitor->isUser = 'No';
            $visitor->save();

            // 2. Insert into meeting_invitations table
            try {
                $invitation = new MeetingInvitation();
                $invitation->meetingId = $meetingId;
                $invitation->invitedMemberId = is_numeric($visitor->invitedBy) ? (int)$visitor->invitedBy : 0;
                $invitation->personName = $request->firstName . ' ' . $request->lastName;
                $invitation->personEmail = $request->email;
                $invitation->personContact = $request->mobileNo;
                $invitation->businessCategoryId = $bCategoryId;
                $invitation->paymentStatus = 'paid';
                $invitation->save();
            } catch (\Throwable $ex) {
                \Illuminate\Support\Facades\Log::error('MeetingInvitation creation error: ' . $ex->getMessage());
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration completed successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'Your Registration has been Submitted Successfully!');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit registration. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to submit your registration.');
        }
    }
}

