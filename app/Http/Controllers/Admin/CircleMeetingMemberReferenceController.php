<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Circle;
use App\Models\Member;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\Schedule;
use App\Models\CircleMeetingMembersReference;
use App\Models\City;
use App\Models\BusinessAmount;

class CircleMeetingMemberReferenceController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle call-related permissions
        $this->middleware('permission:circle-meeting-member-reference-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:circle-meeting-member-reference-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:circle-meeting-member-reference-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:circle-meeting-member-reference-delete', ['only' => ['delete']]);
        $this->middleware('permission:get-member-details', ['only' => ['getMemberDetails']]);
    }


    // public function index(Request $request)
    // {
    //     try {
    //         return $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->with('members')
    //             ->with('members.circle:id,circleName')
    //             ->with('refGiverName')
    //             ->where('referenceGiverId', Auth::user()->id)
    //             ->paginate(10);

    //         // $referenceByOther = CircleMeetingMembersReference::where('status', 'Active')
    //         //     ->orderBy('id', 'DESC')
    //         //     ->with('members')
    //         //     ->with('refGiverName')
    //         //     ->where('memberId', Auth::user()->id)
    //         //     ->paginate(10);

    //         $busGiver = CircleMeetingMembersBusiness::with('businessGiverMember')
    //             ->with('businessGiverMember.circle:id,circleName')
    //             ->where('loginMemberId', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->paginate(10);


    //         $busGiven->transform(function ($item) {
    //             if ($item->member) {
    //                 $item->member->induction_count = Member::where('sponsoredBy', $item->member->id)->count() ?? 0;
    //             }
    //             return $item;
    //         });


    //         return view('admin.refGiver.index', compact('refGiver', 'busGiver'));
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
    //     try {

    //         if (auth()->user()->hasRole('Member')) {
    //             // Fetch reference givers
    //             $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //                 ->orderBy('id', 'DESC')
    //                 ->with('members')
    //                 ->with('members.circle:id,circleName')
    //                 ->with('refGiverName')
    //                 ->where('referenceGiverId', Auth::user()->id)
    //                 ->get();

    //             // Transform directly on the collection
    //             $refGiver->transform(function ($item) {
                    if ($item->members) {
                        $item->members->induction_count = Member::where('sponsoredBy', $item->members->id)->count() ?? 0;
                    }
                    return $item;
                });

                $minDate = Carbon::now()->subDays(15)->format('Y-m-d');
                $maxDate = Carbon::now()->format('Y-m-d');

                $lastLockedMeeting = $schedules->where('is_locked', true)
                    ->where('date', '>=', $minDate)
                    ->where('date', '<', $maxDate)
                    ->sortByDesc('date')
                    ->first();

                if ($lastLockedMeeting) {
                    $minDate = Carbon::parse($lastLockedMeeting->date)->addDay()->format('Y-m-d');
                }

                // Fetch business givers
    //             $busGiver = CircleMeetingMembersBusiness::with('businessGiverMember')
    //                 ->with('businessGiverMember.circle:id,circleName')
    //                 ->where('loginMemberId', Auth::user()->id)
    //                 ->where('status', 'Active')
    //                 ->orderBy('id', 'DESC')
    //                 ->get();

    //             $busGiver->transform(function ($item) {
    //                 if ($item->businessGiverMember) {
    //                     $item->businessGiverMember->induction_count = Member::where('sponsoredBy', $item->businessGiverMember->id)->count() ?? 0;
    //                 }
    //                 return $item;
    //             });

    //             $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();

    //             $circleMember = Member::with('circle')
    //                 ->where('status', 'Active')
    //                 ->orderBy('firstName', 'ASC')
    //                 ->get(); // Ensure 'circleId' is included


    //             $circlemeeting = CircleMeeting::where('status', 'Active')->get();
    //         }

    //         return view('admin.refGiver.index', compact('refGiver', 'busGiver', 'circles', 'circleMember', 'circlemeeting'));
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }




    public function index(Request $request)
    {
        try {
            // For normal Member
            if (auth()->user()->hasRole('Member')) {

                // Get Member and Circle ID for Lock Logic
                $user = Auth::user();
                $memberAuth = Member::where('userId', $user->id)->first();
                $circleId = $memberAuth ? $memberAuth->circleId : null;

                $isLocked = false;
                $schedules = collect();

                if ($circleId) {
                    $schedules = Schedule::where('circleId', $circleId)->orderBy('date', 'asc')->get();
                    // Check if current period (next meeting) is locked for "Create" button
                    $nextMeeting = $schedules->first(function ($item) {
                        return $item->date >= Carbon::now()->format('Y-m-d');
                    });
                    $isLocked = $nextMeeting ? $nextMeeting->is_locked : false;
                }

                $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                    ->orderBy('id', 'DESC')
                    ->with('members')
                    ->with('members.circle:id,circleName')
                    ->with('refGiverName')
                    ->where('referenceGiverId', Auth::user()->id)
                    ->paginate(10, ['*'], 'page_ref');

                $refGiver->getCollection()->transform(function ($item) use ($schedules) {
                    if ($item->members) {
                        $item->members->induction_count = Member::where('sponsoredBy', $item->members->id)->count() ?? 0;
                    }
                    // Lock logic for row
                    $meeting = $schedules->first(function ($s) use ($item) {
                        return $s->date >= $item->created_at->format('Y-m-d');
                    });
                    $item->is_locked_row = $meeting ? $meeting->is_locked : false;

                    return $item;
                });

                $refReceiver = CircleMeetingMembersReference::where('status', 'Active')
                    ->orderBy('id', 'DESC')
                    ->with('refGiver')
                    ->with('refGiver.circle:id,circleName')
                    ->where('memberId', Auth::user()->id)
                    ->paginate(10);

                $refReceiver->transform(function ($item) {
                    if ($item->refGiver) {
                        $item->refGiver->induction_count = Member::where('sponsoredBy', $item->refGiver->id)->count() ?? 0;
                    }
                    return $item;
                });

                $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();

                $circleMember = Member::with('circle')
                    ->where('status', 'Active')
                    ->orderBy('firstName', 'ASC')
                    ->get();

                $circlemeeting = CircleMeeting::where('status', 'Active')->get();

                $minDate = Carbon::now()->subDays(15)->format('Y-m-d');
                $maxDate = Carbon::now()->format('Y-m-d');

                $lastLockedMeeting = $schedules->where('is_locked', true)
                    ->where('date', '>=', $minDate)
                    ->where('date', '<', $maxDate)
                    ->sortByDesc('date')
                    ->first();

                if ($lastLockedMeeting) {
                    $minDate = Carbon::parse($lastLockedMeeting->date)->addDay()->format('Y-m-d');
                }

                return view('admin.refGiver.index', compact('refGiver', 'refReceiver', 'circles', 'circleMember', 'circlemeeting', 'isLocked', 'minDate', 'maxDate'));
            }
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }


    // public function index(Request $request)
    // {
    //     try {

    //         // For normal Member
    //         if (auth()->user()->hasRole('Member')) {

    //             $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //                 ->orderBy('id', 'DESC')
    //                 ->with('members')
    //                 ->with('members.circle:id,circleName')
    //                 ->with('refGiverName')
    //                 ->where('referenceGiverId', Auth::user()->id)
    //                 ->paginate(10);

    //             $refGiver->transform(function ($item) {
    //                 if ($item->members) {
    //                     $item->members->induction_count = Member::where('sponsoredBy', $item->members->id)->count() ?? 0;
    //                 }
    //                 return $item;
    //             });

    //             $busGiver = CircleMeetingMembersBusiness::with('businessGiverMember')
    //                 ->with('businessGiverMember.circle:id,circleName')
    //                 ->where('loginMemberId', Auth::user()->id)
    //                 ->where('status', 'Active')
    //                 ->orderBy('id', 'DESC')
    //                 ->paginate(10);

    //             $busGiver->transform(function ($item) {
    //                 if ($item->businessGiverMember) {
    //                     $item->businessGiverMember->induction_count = Member::where('sponsoredBy', $item->businessGiverMember->id)->count() ?? 0;
    //                 }
    //                 return $item;
    //             });

    //             $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();

    //             $circleMember = Member::with('circle')
    //                 ->where('status', 'Active')
    //                 ->orderBy('firstName', 'ASC')
    //                 ->get();

    //             $circlemeeting = CircleMeeting::where('status', 'Active')->get();

    //             return view('admin.refGiver.index', compact('refGiver', 'busGiver', 'circles', 'circleMember', 'circlemeeting'));
    //         }

    //         // For Digital Member
    //         // if (auth()->user()->hasRole('Digital Member')) {

    //         //     $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //         //         ->orderBy('id', 'DESC')
    //         //         ->with('members')
    //         //         ->with('refGiverName')
    //         //         ->where('referenceGiverId', Auth::user()->id)
    //         //         ->get();

    //         //     $refGiver->transform(function ($item) {
    //         //         if ($item->members) {
    //         //             $item->members->induction_count = Member::where('sponsoredBy', $item->members->id)->count() ?? 0;
    //         //         }
    //         //         return $item;
    //         //     });

    //         //     $busGiver = CircleMeetingMembersBusiness::with('businessGiverMember')
    //         //         ->where('loginMemberId', Auth::user()->id)
    //         //         ->where('status', 'Active')
    //         //         ->orderBy('id', 'DESC')
    //         //         ->get();

    //         //     $busGiver->transform(function ($item) {
    //         //         if ($item->businessGiverMember) {
    //         //             $item->businessGiverMember->induction_count = Member::where('sponsoredBy', $item->businessGiverMember->id)->count() ?? 0;
    //         //         }
    //         //         return $item;
    //         //     });

    //         //     $cities = City::where('status', 'Active')->orderBy('cityName', 'ASC')->get();

    //         //     $circleMember = Member::where('userId', '!=', Auth::user()->id)
    //         //         ->where('circleId', null)
    //         //         ->where('status', 'Active')
    //         //         ->orderBy('firstName', 'ASC')
    //         //         ->get();

    //         //     $circlemeeting = CircleMeeting::where('status', 'Active')->get();

    //         //     return view('admin.refGiver.index', compact('refGiver', 'busGiver', 'cities', 'circleMember', 'circlemeeting'));
    //         // }
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         return view('servererror');
    //     }
    // }



    public function addBusinessAmount(Request $request, $id)
    {
        try {
            $reference = CircleMeetingMembersReference::where('status', 'Active')->findOrFail($id);

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = $reference->referenceGiverId;
            $busGiver->loginMemberId = Auth::user()->id;
            $busGiver->setRelation('loginMember', Auth::user());

            $minDate = Carbon::now()->subDays(15)->format('Y-m-d');
            $maxDate = Carbon::now()->format('Y-m-d');

            return view('admin.circlebusiness.create', compact('busGiver', 'reference', 'minDate', 'maxDate'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }



    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            return response()->json($refGiver);
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

            $circles = Circle::where('status', 'Active')->orderBy('circleName', 'asc')->get();

            $circleMember = Member::with('circle')
                ->where('status', 'Active')
                ->orderBy('firstName', 'asc')
                ->get(); // Ensure 'circleId' is included


            $circlemeeting = CircleMeeting::where('status', 'Active')->get();
            // $members = Member::where('status', 'Active')->get();
            return view('admin.refGiver.create', compact('circlemeeting', 'circles', 'circleMember'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function refByOther(Request $request)
    {
        try {

            $circles = Circle::where('status', 'Active')->orderBy('circleName', 'asc')->get();

            $circleMember = Member::with('circle')
                ->where('status', 'Active')
                ->orderBy('firstName', 'asc')
                ->get();


            $circlemeeting = CircleMeeting::where('status', 'Active')->get();
            // $members = Member::where('status', 'Active')->get();
            return view('admin.refGiver.refByOther', compact('circlemeeting', 'circles', 'circleMember'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function getMemberDetails(Request $request)
    {
        $memberName = $request->input('memberName');

        // Assuming you have a Member model and 'email' and 'contactNo' fields in your database table
        $member = Member::where('firstName', $memberName)->first();

        return response()->json([
            'email' => $member->email,
            'contactNo' => $member->contactNo,
        ]);
    }

    public function store(Request $request)
    {

        // $this->validate($request, [
        //     // 'dateTime' => 'required',
        //     // 'totalMeeting' => 'required',
        //     // 'refGiven' => 'required',
        //     // 'refTaken' => 'required',
        //     // 'busGiven' => 'required',
        //     // 'busTaken' => 'required',
        //     // 'hotelName' => 'required',
        // ]);

        if ($request->group === 'external') {
            $this->validate($request, [
                'contactNameExternal' => 'required|string',
                'contactNo' => 'required',
            ]);
        }


        // return $request;
        try {
            // Lock Check
            $dateToCheck = $request->date ? $request->date : Carbon::now()->format('Y-m-d');
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $dateToCheck)
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'The meeting for this date is locked. You cannot add new entries.');
                }
            }

            $refGiver = new CircleMeetingMembersReference();

            $refGiver->referenceGiverId = Auth::user()->id;
            $refGiver->memberId = $request->memberId;

            if ($request->group == 'internal')
                $refGiver->contactName = $request->contactNameInternal;
            else
                $refGiver->contactName = $request->contactNameExternal;

            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';

            // Set created_at/updated_at based on date
            $refGiver->created_at = $request->date ? Carbon::parse($request->date) : Carbon::now();
            $refGiver->updated_at = $request->date ? Carbon::parse($request->date) : Carbon::now();

            $refGiver->save();


            // $busGiver = new CircleMeetingMembersBusiness();
            // // $busGiver->memberId = $request->memberId;
            // $busGiver->businessGiverId = Auth::user()->id;
            // $busGiver->loginMemberId = $refGiver->memberId;
            // $busGiver->amount = $request->amount;
            // $busGiver->date = Carbon::now()->toDateString();
            // $busGiver->status = 'Active';
            // $busGiver->save();

            // return redirect()->route('refGiver.index')->with('success', ' Created Successfully!');
            return redirect()->back()->with('success', ' Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function refByOtherStore(Request $request)
    {
        if ($request->group === 'external') {
            $this->validate($request, [
                'contactNameExternal' => 'required|string',
                'contactNo' => 'required',
            ]);
        }


        // return $request;
        try {
            // Lock Check
            $dateToCheck = $request->date ? $request->date : Carbon::now()->format('Y-m-d');
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $dateToCheck)
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'The meeting for this date is locked. You cannot add new entries.');
                }
            }

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = $request->memberId;
            $busGiver->loginMemberId = Auth::user()->id;
            $busGiver->amount = $request->amount;
            $busGiver->remarks = $request->remarks;
            $busGiver->date = $request->date ? $request->date : Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            if ($request->create_reference == 1) {
                $refGiver = new CircleMeetingMembersReference();

                $refGiver->referenceGiverId = $request->memberId;
                $refGiver->memberId = Auth::user()->id;

                if ($request->group == 'internal')
                    $refGiver->contactName = $request->contactNameInternal;
                else
                    $refGiver->contactName = $request->contactNameExternal;

                $refGiver->contactNo = $request->contactNo;
                $refGiver->email = $request->email;
                $refGiver->scale = $request->scale;
                $refGiver->description = $request->description;
                $refGiver->status = 'Active';

                // Set created_at/updated_at based on date
                $refGiver->created_at = $request->date ? Carbon::parse($request->date) : Carbon::now();
                $refGiver->updated_at = $request->date ? Carbon::parse($request->date) : Carbon::now();

                $refGiver->save();

                $busGiver->referenceId = $refGiver->id;
                $busGiver->save();
            }

            return redirect()->route('refGiver.index')->with('success', ' Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    // public function edit(Request $request, $id)
    // {
    //     try {

    //         if (auth()->user()->hasRole('Member')) {

    //             $refGiver = CircleMeetingMembersReference::find($id);
    //             // $refGiver = CircleMeetingMembersReference::where('id', $id)->first();
    //             $member = Member::where('status', 'Active')->orderBy('firstName', 'asc')->get();
    //             $circles = Circle::where('status', 'Active')->orderBy('circleName', 'asc')->get();
    //         }

    //         if (auth()->user()->hasRole('Digital Member')) {
    //             $refGiver = CircleMeetingMembersReference::find($id);
    //             // $refGiver = CircleMeetingMembersReference::where('id', $id)->first();
    //             $member = Member::where('status', 'Active')->orderBy('firstName', 'asc')->get();
    //             $cities = City::where('status', 'Active')->orderBy('cityName', 'asc')->get();
    //         }

    //         return view('admin.refGiver.edit', compact('refGiver', 'member', 'cities'));
    //         // return view('admin.refGiver.edit_form', compact('refGiver', 'member', 'circles'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }


    public function edit(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            $member = collect(); // initialize to avoid undefined variable
            $circles = collect();
            $cities = collect();

            if (auth()->user()->hasRole('Member')) {
                $member = Member::where('status', 'Active')
                    ->orderBy('firstName', 'asc')
                    ->get();

                $circles = Circle::where('status', 'Active')
                    ->orderBy('circleName', 'asc')
                    ->get();
            }

            if (auth()->user()->hasRole('Digital Member')) {
                $member = Member::where('status', 'Active')
                    ->orderBy('firstName', 'asc')
                    ->get();

                $cities = City::where('status', 'Active')
                    ->orderBy('cityName', 'asc')
                    ->get();
            }

            return view('admin.refGiver.edit', compact('refGiver', 'member', 'circles', 'cities'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }


    public function update(Request $request)
    {
        $this->validate($request, [
            // 'dateTime' => 'required',
            // 'totalMeeting' => 'required',
            // 'refGiven' => 'required',
            // 'refTaken' => 'required',
            // 'busGiven' => 'required',
            // 'busTaken' => 'required',
            // 'hotelName' => 'required',

        ]);
        try {
            // return $id;
            $id = $request->id;
            $refGiver = CircleMeetingMembersReference::find($id);

            // Lock Check
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $refGiver->created_at->format('Y-m-d'))
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'This record is locked and cannot be updated.');
                }
            }


            $refGiver->memberId = $request->memberId;

            // $refGiver->referenceGiver = $request->referenceGiver;
            $refGiver->contactName = $request->contactNameExternal;
            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';

            $refGiver->save();
            return redirect()->route('refGiver.index')->with('success', ' Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    function delete(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::find($id);

            // Lock Check
            $user = Auth::user();
            $member = Member::where('userId', $user->id)->first();
            if ($member) {
                $schedule = Schedule::where('circleId', $member->circleId)
                    ->where('date', '>=', $refGiver->created_at->format('Y-m-d'))
                    ->orderBy('date', 'asc')
                    ->first();
                if ($schedule && $schedule->is_locked) {
                    return redirect()->back()->with('error', 'This record is locked and cannot be deleted.');
                }
            }

            $refGiver->status = "Deleted";
            $refGiver->save();

            return redirect()->route('refGiver.index')->with('success', ' Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
}
