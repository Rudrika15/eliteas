<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\MeetingInvitation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingInvitation as MailMeetingInvitation;
use App\Utils\Utils; // Assuming you have a Utils class for response handling

class MeetingInvitationController extends Controller
{
    public function invitation(Request $request)
    {
        try {
            $request->validate([
                'personName' => 'required',
                'personEmail' => 'required|email',
                'personContact' => 'required',
                'businessCategoryId' => 'required',
                'meetingId' => 'required|exists:schedules,id',
            ]);

            $invitation = new MeetingInvitation();
            $invitation->meetingId = $request->meetingId;
            $invitation->invitedMemberId = Auth::id();
            $invitation->personName = $request->personName;
            $invitation->personEmail = $request->personEmail;
            $invitation->personContact = $request->personContact;
            $invitation->businessCategoryId = $request->businessCategoryId;
            $invitation->save();

            $fees = Schedule::with('circle.city')->find($request->meetingId);
            $invitedPerson = Auth::user();
            $data = [
                'personName' => $request->personName,
                'personEmail' => $request->personEmail,
                'invitedPersonFirstName' => $invitedPerson->firstName,
                'invitedPersonLastName' => $invitedPerson->lastName,
                'amount' => $fees->circle->city->amount
            ];

            Mail::to($request->personEmail)->send(new MailMeetingInvitation($data));

            return Utils::sendResponse([], 'Invitation sent successfully', 200);
        } catch (\Exception $e) {
            return Utils::errorResponse($e->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function index(Request $request)
    {
        try {
            $authId = $request->user()->id;
            $meetingsInvitation = MeetingInvitation::where('invitedMemberId', $authId)->get();
            return Utils::sendResponse(['meetingsInvitation' => $meetingsInvitation], 'Meetings Invitations retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function getMeetingForCircle(Request $request)
    {
        try {
            $myCircle = Auth::user()->member->circleId;

            $today = Carbon::today();

            $meeting = Schedule::where('circleId', $myCircle)
                ->with('circle.members')
                ->with('circle.franchise')
                ->where('status', 'Active')
                ->where('date', '>', $today)
                ->orderBy('date', 'asc')
                ->first();

            $meetingData = [];
            if ($meeting) {
                $meetingData = $meeting->toArray();
                $meetingData['circle'] = $meeting->circle->toArray();
                $members = [];
                foreach ($meeting->circle->members as $member) {
                    $members[] = [
                        'id' => $member->id,
                        'name' => $member->firstName . ' ' . $member->lastName,
                        'email' => $member->email,
                        'contact' => $member->contactNo,
                    ];
                }
                $meetingData['circle']['members'] = $members;
                $meetingData['circle']['franchise'] = $meeting->circle->franchise->toArray();
            }

            return Utils::sendResponse($meetingData, 'Upcoming Circle Meeting Retrieved Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }



}
