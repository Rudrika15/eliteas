<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;

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
                ->get();

            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member References retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function receivedRef(Request $request)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();


            return Utils::sendResponse(['busGiver' => $busGiver], 'Circle Meeting Member References retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }



    // For showing a single data
    public function view(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member Reference retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function create()
    // {
    //     try {
    //         $circlemeeting = CircleMeeting::where('status', 'Active')->get();
    //         $members = Member::where('status', 'Active')->get();
    //         return view('admin.refGiver.create', compact('circlemeeting', 'members'));
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function create(Request $request)
    {
        $this->validate($request, []);

        try {
            $refGiver = new CircleMeetingMembersReference();

            $refGiver->referenceGiverId = Auth::user()->id;
            $refGiver->memberId = $request->memberId;

            // if ($request->group == 'internal')
            //     $refGiver->contactName = $request->contactNameInternal;
            // else
            $refGiver->contactName = $request->contactNameExternal;

            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';

            $refGiver->save();

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = Auth::user()->id;
            $busGiver->loginMemberId = $refGiver->memberId;
            $busGiver->amount = $request->amount;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            return Utils::sendResponse([], 'Circle Meeting Member Reference created successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function edit($id)
    // {
    //     try {
    //         $refGiver = CircleMeetingMembersReference::find($id);
    //         $member = Member::all();
    //         return view('admin.refGiver.edit', compact('refGiver', 'member'));
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function update(Request $request)
    {
        $this->validate($request, []);

        try {
            $id = $request->id;
            $refGiver = CircleMeetingMembersReference::find($id);

            $refGiver->memberId = $request->memberId;
            $refGiver->contactName = $request->contactNameExternal;
            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';

            $refGiver->save();
            return Utils::sendResponse([], 'Circle Meeting Member Reference updated successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete($id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::find($id);
            $refGiver->status = "Deleted";
            $refGiver->save();

            return Utils::sendResponse([], 'Circle Meeting Member Reference deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
