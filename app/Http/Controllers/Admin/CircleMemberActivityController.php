<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

class CircleMemberActivityController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('permission:circle-member-activity', ['only' => ['activity']]);
    // }



    public function activity(Request $request, $id)
    {
        try {
            // Fetch member details based on the provided id
            $member = Member::find($id);

            // Retrieve related data for the member
            $circlecall = CircleCall::where('memberId', $id)->paginate(5);
            $refGiver = CircleMeetingMembersReference::where('memberId', $id)->paginate(5);
            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', $id)->paginate(5);
            $testimonials = Testimonial::where('memberId', $id)->paginate(5);

            // Pass the member and the related data to the view
            return view('admin.circlemember.activity', compact('member', 'circlecall', 'refGiver', 'busGiver', 'testimonials'));
        } catch (\Throwable $th) {
            // Log the error and return the error view
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }
}
