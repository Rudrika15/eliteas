<?php

namespace App\Http\Controllers\Admin;


use Carbon\Carbon;
use App\Models\Member;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

class CircleMeetingMemberReferenceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->with('members')
                ->with('refGiverName')
                ->where('referenceGiverId', Auth::user()->id)
                ->paginate(10);

            // $referenceByOther = CircleMeetingMembersReference::where('status', 'Active')
            //     ->orderBy('id', 'DESC')
            //     ->with('members')
            //     ->with('refGiverName')
            //     ->where('memberId', Auth::user()->id)
            //     ->paginate(10);

            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            return view('admin.refGiver.index', compact('refGiver', 'busGiver'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
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
            $circlemeeting = CircleMeeting::where('status', 'Active')->get();
            $members = Member::where('status', 'Active')->get();
            return view('admin.refGiver.create', compact('circlemeeting', 'members'));
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
        $this->validate($request, [
            // 'dateTime' => 'required',
            // 'totalMeeting' => 'required',
            // 'refGiven' => 'required',
            // 'refTaken' => 'required',
            // 'busGiven' => 'required',
            // 'busTaken' => 'required',
            // 'hotelName' => 'required',
        ]);


        // return $request;
        try {
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

            $refGiver->save();


            $busGiver = new CircleMeetingMembersBusiness();
            // $busGiver->memberId = $request->memberId;
            $busGiver->businessGiverId = Auth::user()->id;
            $busGiver->loginMemberId = $refGiver->memberId;
            $busGiver->amount = $request->amount;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

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

    public function edit(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::find($id);
            $member = Member::all();
            return view('admin.refGiver.edit', compact('refGiver', 'member'));
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
