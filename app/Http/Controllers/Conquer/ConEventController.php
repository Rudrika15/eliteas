<?php

namespace App\Http\Controllers\Conquer;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\ConquerEvent;
use App\Models\VisitorsDetails;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class ConEventController extends Controller
{
    public function main()
    {
        $event = ConquerEvent::where('status', 'Active')->first();
        return view('conquer.mainPage.main', compact('event'));
    }

    public function visitor()
    {
        $businessCategory = BusinessCategory::where('status', 'Active')->get();
        return view('conquer.mainPage.visitor', compact('businessCategory'));
    }

    public function conquerVisitorStore(Request $request)
    {
        try {
            // Create a new VisitorsDetails object
            $visitor = new VisitorsDetails();
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;

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
                $visitor->businessCategory = $request->businessCategory;
            }

            $visitor->status = 'Active';

            // Save the visitor information
            $visitor->save();

            return redirect()->back()->with('success', 'Your Information Submitted Successfully!');
        } catch (\Throwable $th) {
            // Log the error
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            // Return a generic error view or message
            return redirect()->back()->with('error', 'Failed to submit your information');
        }
    }
}
