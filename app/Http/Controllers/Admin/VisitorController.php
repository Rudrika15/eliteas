<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\VisitorRemarks;
use App\Models\VisitorsDetails;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitorController extends Controller
{

    // public function __construct()
    // {
    //     // Apply middleware for circle type-related permissions
    //     $this->middleware('permission:event-type-index', ['only' => ['index', 'view']]);
    //     $this->middleware('permission:event-type-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:event-type-edit', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:event-type-delete', ['only' => ['delete']]);
    // }

    public function index(Request $request)
    {
        try {
            $visitors = VisitorsDetails::paginate(10);
            $businessCategories = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            return view('admin.visitor.index', compact('visitors', 'businessCategories'));
        } catch (\Throwable $th) {
            // throw $th;
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
            $businessCategories = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            return view('admin.visitor.create', compact('businessCategories'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {

        try {
            $visitors = new VisitorsDetails();
            $visitors->firstName = $request->firstName;
            $visitors->lastName = $request->lastName;
            $visitors->mobileNo = $request->mobileNo;
            $visitors->email = $request->email;
            $visitors->businessName = $request->businessName;
            $visitors->businessCategory = $request->businessCategory;
            $visitors->invitedBy = $request->invitedBy;
            $visitors->city = $request->city;
            $visitors->status = 'Active';
            $visitors->save();

            $visitorRemarks = new VisitorRemarks();
            $visitorRemarks->visitorId = $visitors->id;
            $visitorRemarks->userId = Auth::user()->id;
            $visitorRemarks->remarks = $request->remarks;
            $visitors->date = Carbon::now();
            $visitorRemarks->save();


            return redirect()->route('visitors.index')->with('success', 'Visitor Created Successfully!');
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
            $visitors = VisitorsDetails::find($id);
            $businessCategories = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            return view('admin.visitor.edit', compact('visitors', 'businessCategories'));
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
            'id' => 'required|exists:visitors_details,id',
        ]);

        try {
            $visitors = VisitorsDetails::find($request->id);

            if (!$visitors) {
                return redirect()->route('visitors.index')->with('error', 'Visitor not found.');
            }

            $visitors->firstName = $request->firstName;
            $visitors->lastName = $request->lastName;
            $visitors->mobileNo = $request->mobileNo;
            $visitors->email = $request->email;
            $visitors->businessName = $request->businessName;
            $visitors->businessCategory = $request->businessCategory;
            $visitors->invitedBy = $request->invitedBy;
            $visitors->city = $request->city;
            $visitors->status = 'Active';
            $visitors->save();


            return redirect()->route('visitors.index')->with('success', 'Visitor updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('visitors.index')->with('error', 'Failed to update Visitor details.');
        }
    }

    public function updateStatus(Request $request)
    {
        try {

            $visitor = VisitorsDetails::findOrFail($request->id);
            $visitor->status = $request->status;
            $visitor->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }




    public function remarksView(Request $request, $id)
    {
        try {
            $visitors = VisitorsDetails::find($id);
            $visitorRemarks = VisitorRemarks::where('visitorId', $id)->get();
            return view('admin.visitor.remarks', compact('visitors', 'visitorRemarks'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function remarksUpdate(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:visitors_details,id',
        ]);

        try {
            $visitors = VisitorsDetails::find($request->id);

            if (!$visitors) {
                return redirect()->route('visitors.index')->with('error', 'Visitor not found.');
            }

            $visitors = new VisitorRemarks();
            $visitors->visitorId = $request->id;
            $visitors->userId = Auth::user()->id;
            $visitors->remarks = $request->remarks;
            $visitors->date = Carbon::now();
            $visitors->save();

            return redirect()->route('visitors.index')->with('success', 'Follow-Up added successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('visitors.index')->with('error', 'Failed to add Follow-Up.');
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $visitors = VisitorsDetails::find($id);

            if (!$visitors) {
                return redirect()->route('visitors.index')->with('error', 'Visitor not found.');
            }

            $visitors->status = 'Deleted';
            $visitors->save();

            return redirect()->route('visitors.index')->with('success', 'Visitor deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('visitors.index')->with('error', 'Failed to delete Visitor.');
        }
    }
}
