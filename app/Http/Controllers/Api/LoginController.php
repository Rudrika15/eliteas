<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Utils\Utils;
use App\Models\Member;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::sendResponse($request->all(), 'Invalid Input');
        }

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return Utils::sendResponse(['token' => $token, 'user' => $user], 'Success');
        }

        return Utils::sendResponse(['error' => 'Unauthorized'], 401);
    }


    public function profile(Request $request)
    {
        $user = Auth::user();

        // Retrieve the member record associated with the authenticated user
        $member = Member::where('userId', $user->id)->first();

        if ($member) {
            // Retrieve related records
            $billingAddress = BillingAddress::where('memberId', $member->id)->first();
            $contactDetails = ContactDetails::where('memberId', $member->id)->first();
            $topsProfile = TopsProfile::where('memberId', $member->id)->first();

            // Return the data in your API response
            return response()->json([
                'user' => $user,
                'member' => $member,
                'billingAddress' => $billingAddress,
                'contactDetails' => $contactDetails,
                'topsProfile' => $topsProfile,
            ]);
        } else {
            // Handle the case where member record is not found
            return response()->json(['error' => 'Member not found'], 404);
        }
        // return Utils::sendResponse($responseData, "Profile Data");

    }
}
