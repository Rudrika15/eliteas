<?php

namespace App\Http\Controllers\Admin;

use App\Models\CircleCall;
use App\Models\CircleMeetingMembersReference;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\Testimonial;

class CircleMemberActivityController extends Controller
{
    public function activity($id)
    {
        try {

            $circlecall = CircleCall::where('memberId', $id)->get();

            $refGiver = CircleMeetingMembersReference::where('memberId', $id)->get();

            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', $id)->get();

            $testimonials = Testimonial::where('memberId', $id)->get();

            return view('admin.circlemember.activity', compact('circlecall', 'refGiver', 'busGiver', 'testimonials'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    

}
