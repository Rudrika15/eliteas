<?php

namespace App\Http\Controllers\Admin;

use App\Models\CircleCall;
use App\Utils\ErrorLogger;
use App\Models\Testimonial;
use App\Http\Controllers\Controller;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use Illuminate\Http\Request;

class CircleMemberActivityController extends Controller
{
    public function activity(Request $request, $id)
    {
        try {

            $circlecall = CircleCall::where('memberId', $id)->get();

            $refGiver = CircleMeetingMembersReference::where('memberId', $id)->get();

            $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', $id)->get();

            $testimonials = Testimonial::where('memberId', $id)->get();

            return view('admin.circlemember.activity', compact('circlecall', 'refGiver', 'busGiver', 'testimonials'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    

}
