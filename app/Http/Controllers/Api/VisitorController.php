<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SpecificAsk;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use App\Models\CircleCall;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class VisitorController extends Controller
{
    public function visitorLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::sendResponse($request->all(), 'Invalid Input');
        }

        // Fetch visitor from the Visitor table
        $visitor = Visitor::where('email', $request->email)->first();

        if ($visitor && Hash::check($request->password, $visitor->password)) {
            // Generate a token manually
            $token = $visitor->createToken('authToken')->plainTextToken;

            return Utils::sendResponse([
                'token' => $token,
                'visitor' => $visitor
            ], 'Success');
        }

        return Utils::sendResponse(['error' => 'Unauthorized'], 401);
    }

    

}
