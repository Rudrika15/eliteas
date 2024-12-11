<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\VisitorsDetails;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

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
            $visitors = VisitorsDetails::where('status', 'Active')->paginate(10);
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
            $visitors->remarks = $request->remarks;
            $visitors->city = $request->city;
            $visitors->status = 'Active';
            $visitors->save();

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
            return view('admin.visitor.edit', compact( 'visitors', 'businessCategories'));
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
            $visitors->remarks = $request->remarks;
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
