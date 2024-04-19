<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Franchise;
use App\Models\MeetingInvitation;
use Illuminate\Support\Facades\Validator;
use App\Utils\Utils;

class MeetingInvitationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $authId = $request->user()->id;
            $meetingsInvitation = MeetingInvitation::where('invitedMemberId', $authId)->get();
            return Utils::sendResponse(['meetingsInvitation' => $meetingsInvitation], 'Meetings Invitation retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

}
