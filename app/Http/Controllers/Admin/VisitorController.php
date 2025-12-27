<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VisitorsExport;
use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\Member;
use App\Models\Schedule;
use App\Models\VisitorRemarks;
use App\Models\VisitorsDetails;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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

    // public function index(Request $request)
    // {
    //     try {
    //         $visitors = VisitorsDetails::paginate(10);
    //         $businessCategories = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
    //         return view('admin.visitor.index', compact('visitors', 'businessCategories'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }

    // public function index(Request $request)
    // {
    //     $query = VisitorsDetails::query();

    //     // Apply filters
    //     if ($request->filled('name')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('firstName', 'like', '%' . $request->name . '%')
    //                 ->orWhere('lastName', 'like', '%' . $request->name . '%');
    //         });
    //     }

    //     if ($request->filled('business_category')) {
    //         $query->whereHas('bCategory', function ($q) use ($request) {
    //             $q->where('categoryName', 'like', '%' . $request->business_category . '%');
    //         });
    //     }

    //     if ($request->filled('city')) {
    //         $query->where('city', 'like', '%' . $request->city . '%');
    //     }

    //     $visitors = $query->paginate(10);

    //     $categories = BusinessCategory::pluck('categoryName', 'id');
    //     $cities = VisitorsDetails::select('city')->distinct()->pluck('city');

    //     return view('admin.visitor.index', compact('visitors', 'categories', 'cities'));
    // }


    // public function index(Request $request)
    // {
    //     // $query = VisitorsDetails::query();
    //     $query = VisitorsDetails::where('isUser', 'No'); // Filter where isUser = 'No'

    //     // Apply filters
    //     if ($request->filled('name')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('firstName', 'like', '%' . $request->name . '%')
    //                 ->orWhere('lastName', 'like', '%' . $request->name . '%');
    //         });
    //     }

    //     if ($request->filled('business_category')) {
    //         $query->whereHas('bCategory', function ($q) use ($request) {
    //             $q->where('categoryName', $request->business_category);
    //         });
    //     }

    //     if ($request->filled('city')) {
    //         $query->where('city', $request->city);
    //     }

    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     $visitors = $query->paginate(10)->appends($request->query());

    //     $categories = BusinessCategory::where('status', 'Active')->pluck('categoryName', 'id');
    //     $cities = VisitorsDetails::distinct()->pluck('city');

    //     return view('admin.visitor.index', compact('visitors', 'categories', 'cities'));
    // }

    // public function index(Request $request)
    // {
    //     $query = VisitorsDetails::where('isUser', 'No');

    //     // Apply filters
    //     if ($request->filled('name')) {
    //         $query->where(function ($q) use ($request) {
    //             $q->where('firstName', 'like', '%' . $request->name . '%')
    //                 ->orWhere('lastName', 'like', '%' . $request->name . '%');
    //         });
    //     }

    //     if ($request->filled('business_category')) {
    //         $query->whereHas('bCategory', function ($q) use ($request) {
    //             $q->where('categoryName', $request->business_category);
    //         });
    //     }

    //     if ($request->filled('city')) {
    //         $query->where('city', $request->city);
    //     }

    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     if ($request->has('export') && $request->export == 'excel') {
    //         return Excel::download(new VisitorsExport($query->get()), 'visitors.xlsx');
    //     }

    //     $visitors = $query->paginate(10)->appends($request->query());
    //     $categories = BusinessCategory::where('status', 'Active')->pluck('categoryName', 'id');
    //     $cities = VisitorsDetails::distinct()->pluck('city');

    //     return view('admin.visitor.index', compact('visitors', 'categories', 'cities'));
    // }


    public function index(Request $request)
{
    $query = VisitorsDetails::where('isUser', 'No');

    // ✅ VP restriction
    if (auth()->user()->hasRole('Vice President')) {

        // get circleId from members table
        $circleId = Member::where('userId', auth()->id())->value('circleId');

        $query->where('createdBy', auth()->id())
              ->where('circleId', $circleId);
    }

    // Filters
    if ($request->filled('name')) {
        $query->where(function ($q) use ($request) {
            $q->where('firstName', 'like', '%' . $request->name . '%')
              ->orWhere('lastName', 'like', '%' . $request->name . '%');
        });
    }

    if ($request->filled('business_category')) {
        $query->whereHas('bCategory', function ($q) use ($request) {
            $q->where('categoryName', $request->business_category);
        });
    }

    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->has('export') && $request->export == 'excel') {
        return Excel::download(new VisitorsExport($query->get()), 'visitors.xlsx');
    }

    $visitors = $query->paginate(10)->appends($request->query());
    $categories = BusinessCategory::where('status', 'Active')->pluck('categoryName', 'id');
    $cities = VisitorsDetails::distinct()->pluck('city');

    return view('admin.visitor.index', compact('visitors', 'categories', 'cities'));
}


//     public function index(Request $request)
// {
//     $query = VisitorsDetails::where('isUser', 'No');

//     // ✅ Role based filter
//     if (auth()->user()->hasRole('Vice President')) {
//         $query->where('circleId', auth()->user()->circleId);
//     }

//     // Apply filters
//     if ($request->filled('name')) {
//         $query->where(function ($q) use ($request) {
//             $q->where('firstName', 'like', '%' . $request->name . '%')
//               ->orWhere('lastName', 'like', '%' . $request->name . '%');
//         });
//     }

//     if ($request->filled('business_category')) {
//         $query->whereHas('bCategory', function ($q) use ($request) {
//             $q->where('categoryName', $request->business_category);
//         });
//     }

//     if ($request->filled('city')) {
//         $query->where('city', $request->city);
//     }

//     if ($request->filled('status')) {
//         $query->where('status', $request->status);
//     }

//     if ($request->has('export') && $request->export == 'excel') {
//         return Excel::download(new VisitorsExport($query->get()), 'visitors.xlsx');
//     }

//     $visitors = $query->paginate(10)->appends($request->query());
//     $categories = BusinessCategory::where('status', 'Active')->pluck('categoryName', 'id');
//     $cities = VisitorsDetails::distinct()->pluck('city');

//     return view('admin.visitor.index', compact('visitors', 'categories', 'cities'));
// }




    public function RoleWiseIndex(Request $request)
    {
        $userId = Auth::id();

        // Step 1: Get the user's circle and city ID
        $circle = DB::table('circles')
            ->join('members', 'circles.id', '=', 'members.circleId')
            ->where('members.userId', $userId)
            ->first(['circles.id as circleId', 'circles.cityId']);

        if (!$circle) {
            abort(404, 'Circle not found for the user.');
        }

        $cityId = $circle->cityId;

        // Step 2: Get the city name from the `cities` table using `cityId`
        $cityName = DB::table('cities')->where('id', $cityId)->value('cityName');

        if (!$cityName) {
            abort(404, 'City not found for the specified city ID.');
        }

        // Step 3: Fetch data from `visitor_details` where the city matches the city name
        $query = VisitorsDetails::query();

        // Apply the city filter
        $query->where('city', $cityName);

        // Optional filters (e.g., name and business category)
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstName', 'like', '%' . $request->name . '%')
                    ->orWhere('lastName', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('business_category')) {
            $query->whereHas('bCategory', function ($q) use ($request) {
                $q->where('categoryName', 'like', '%' . $request->business_category . '%');
            });
        }

        // Step 4: Get the paginated results
        $visitors = $query->paginate(10);

        // Step 5: Get categories and distinct cities for dropdowns
        $categories = BusinessCategory::orderBy('categoryName', 'asc')->pluck('categoryName', 'id');
        $cities = VisitorsDetails::select('city')->distinct()->pluck('city');

        // Step 6: Return the view
        return view('admin.visitor.circleDirectorIndex', compact('visitors', 'categories', 'cities'));
    }






    // public function create(Request $request)
    // {
    //     try {
    //         $businessCategories = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
    //         // $meetingList = Schedule::where('circleId', auth()->user()->circleId)->get();
    //         return $meetingList = Schedule::where('circleId', auth()->user()->circleId)
    //         ->where(function ($q) {
    //         $q->whereDate('date', '>=', Carbon::now()) // upcoming
    //         ->orWhereBetween('date', [
    //           Carbon::now()->subMonth()->startOfMonth(), // last month start
    //           Carbon::now()->endOfMonth()                 // current month end
    //       ]);
    //     })
    // ->orderBy('date', 'asc')
    // ->get();
    //         return view('admin.visitor.create', compact('businessCategories', 'meetingList'));
    //     } catch (\Throwable $th) {
    //         //throe $th;
    //         ErrorLogger::logError($th, $request->fullUrl());

    //         return view('servererror');
    //     }
    // }


    public function create(Request $request)
{
    try {
        // Business categories
        $businessCategories = BusinessCategory::where('status', 'Active')
            ->orderBy('categoryName', 'asc')
            ->get();

        // Get circleId from members table
        $circleId = Member::where('userId', auth()->id())->value('circleId');

        // Meetings list
        $meetingList = Schedule::where('circleId', $circleId)
            ->where(function ($q) {
                $q->whereDate('date', '>=', Carbon::today()) // upcoming
                  ->orWhereBetween('date', [
                      Carbon::now()->subMonth()->startOfMonth(), // last month
                      Carbon::now()->endOfMonth()                 // current month
                  ]);
            })
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.visitor.create', compact('businessCategories', 'meetingList'));

    } catch (\Throwable $th) {
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
            $visitors->createdBy = Auth::user()->id;
            $visitors->circleId = Member::where('userId', auth()->id())->value('circleId');
            $visitors->meetingId = $request->meetingId;
            $visitors->otherDetails = $request->otherDetails;
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
            $visitors->otherDetails = $request->otherDetails;
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

            $visitors->delete();

            return redirect()->route('visitors.index')->with('success', 'Visitor deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('visitors.index')->with('error', 'Failed to delete Visitor.');
        }
    }
}
