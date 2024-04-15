<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Utils\Utils;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\CircleMeeting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

class CircleMeetingMemberReferenceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $memberId = Auth::id();

            $member = Member::where('userId', $memberId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $refGivers = CircleMeetingMembersReference::where('memberId', $member->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();

            return Utils::sendResponse(['refGivers' => $refGivers], 'Circle Meeting Members Reference retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);
            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member Reference retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'memberId' => 'required',
            'contactNo' => 'required',
            'email' => 'required|email',
            'scale' => 'required',
            'description' => 'required',
            'group' => 'required|in:internal,external',
            'contactNameInternal' => 'required_if:group,internal',
            'contactNameExternal' => 'required_if:group,external',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $refGiver = new CircleMeetingMembersReference();
            $refGiver->referenceGiverId = Auth::user()->id;
            $refGiver->memberId = $request->memberId;

            if ($request->group == 'internal') {
                $refGiver->contactName = $request->contactNameInternal;
            } else {
                $refGiver->contactName = $request->contactNameExternal;
            }

            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';
            $refGiver->save();

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = Auth::user()->id;
            $busGiver->loginMemberId = $refGiver->memberId;
            // $busGiver->amount = $request->amount;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            return redirect()->route('refGiver.index')->with('success', 'Created Successfully!');
        } catch (\Throwable $th) {
            return redirect()->route('servererror');
        }
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'contactName' => 'required',
            'contactNo' => 'required',
            'email' => 'required|email',
            'scale' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $refGiver = CircleMeetingMembersReference::findOrFail($id);

            // Check if the authenticated user is authorized to update this record
            $memberId = Auth::id();
            $member = Member::where('userId', $memberId)->first();

            if (!$member || $refGiver->memberId != $member->id) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized', 403);
            }

            $refGiver->contactName = $request->contactName;
            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->save();

            // Update related business record
            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', $refGiver->memberId)->first();

            if (!$busGiver) {
                return Utils::errorResponse(['error' => 'Business record not found'], 'Not Found', 404);
            }

            $busGiver->businessGiverId = Auth::id();
            $busGiver->amount = $request->amount;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->save();

            return Utils::sendResponse(['refGiver' => $refGiver, 'busGiver' => $busGiver], 'Circle Meeting Member Reference Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $memberId = Auth::id();
            $member = Member::where('userId', $memberId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $refGiver = CircleMeetingMembersReference::findOrFail($id);

            if ($refGiver->memberId != $member->id) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized', 403);
            }

            $refGiver->delete();

            return Utils::sendResponse([], 'Circle Meeting Member Reference Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
