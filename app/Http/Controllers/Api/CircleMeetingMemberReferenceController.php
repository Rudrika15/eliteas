<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CircleMeeting;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\Member;
use App\Models\User;
use App\Models\Notifications;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class CircleMeetingMemberReferenceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->with('members')
                ->with('refGiverName')
                ->with('members.circle:id,circleName')
                ->where('referenceGiverId', Auth::user()->id)
                ->get();

            $refGiver->transform(function ($item) {
                if ($item->members) {
                    $item->members->induction_count = Member::where('sponsoredBy', $item->members->id)->count();
                } else {
                    $item->induction_count = 0;
                }

                return $item;
            });

            return Utils::sendResponse(['refGiver' => $refGiver], 'Circle Meeting Member References retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function receivedRef(Request $request)
    {
        try {
            // $busGiver = CircleMeetingMembersBusiness::where('loginMemberId', Auth::user()->id)
            //     ->where('status', 'Active')
            //     ->orderBy('id', 'DESC')
            //     ->get();

            $refReceiver = CircleMeetingMembersReference::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->with('refGiver')
                ->with('refGiver.circle:id,circleName')
                ->where('memberId', Auth::user()->id)
                ->get();

            $refReceiver->transform(function ($item) {
                if ($item->refGiver) {
                    $item->refGiver->induction_count = Member::where('sponsoredBy', $item->refGiver->id)->count() ?? 0;
                }

                return $item;
            });

            return Utils::sendResponse(['refReceiver' => $refReceiver], 'Circle Meeting Member References retrieved successfully', 200);
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

    // public function create(Request $request)
    // {
    //     $this->validate($request, []);

    //     try {
    //         $refGiver = new CircleMeetingMembersReference();

    //         $refGiver->referenceGiverId = Auth::user()->id;
    //         $refGiver->memberId = $request->memberId;

    //         // if ($request->group == 'internal')
    //         //     $refGiver->contactName = $request->contactNameInternal;
    //         // else
    //         $refGiver->contactName = $request->contactNameExternal;

    //         $refGiver->contactNo = $request->contactNo;
    //         $refGiver->email = $request->email;
    //         $refGiver->scale = $request->scale;
    //         $refGiver->description = $request->description;
    //         $refGiver->status = 'Active';

    //         $refGiver->save();

    //         $busGiver = new CircleMeetingMembersBusiness();
    //         $busGiver->businessGiverId = Auth::user()->id;
    //         $busGiver->loginMemberId = $refGiver->memberId;
    //         $busGiver->amount = $request->amount;
    //         $busGiver->remarks = $request->remarks;
    //         $busGiver->date = Carbon::now()->toDateString();
    //         $busGiver->status = 'Active';
    //         $busGiver->save();

    //         return Utils::sendResponse([], 'Circle Meeting Member Reference created successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function create(Request $request)
    {
        $this->validate($request, []);

        try {
            $refGiver = new CircleMeetingMembersReference;

            $refGiver->referenceGiverId = Auth::user()->id;
            $refGiver->memberId = $request->memberId;

            $refGiver->contactName = $request->contactNameExternal;
            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';

            $refGiver->save();

            // $busGiver = new CircleMeetingMembersBusiness();
            // $busGiver->businessGiverId = Auth::user()->id;
            // $busGiver->loginMemberId = $refGiver->memberId;
            // $busGiver->amount = $request->amount;
            // $busGiver->remarks = $request->remarks;
            // $busGiver->date = Carbon::now()->toDateString();
            // $busGiver->status = 'Active';
            // $busGiver->save();

            // Send notification to the specified member
            $memberId = $request->memberId;
            $user = User::where('id', $memberId)->where('status', 'Active')->first();
            $sender = Auth::user();
            $senderName = $sender->firstName . ' ' . $sender->lastName;
            $title = 'Reference';

            $body = 'A new reference has been created for you by ' . $senderName;
            Notifications::create([
                'title' => $title,
                'body' => $body,
                'data' => json_encode([
                    'type' => 'reference_created',
                    'userId' => $sender->id, // sender
                    'memberId' => $memberId, // receiver
                    'reference_id' => $refGiver->id
                ])
            ]);

            if ($user && $user->fcm_token) {
                $title = 'Reference';
                $body = 'A new reference has been created for you by ' . $user->firstName . ' ' . $user->lastName . '.';

                $serviceAccountPath = storage_path('app/public/ubn_notification.json');
                $factory = (new Factory)->withServiceAccount($serviceAccountPath);
                $messaging = $factory->createMessaging();

                $message = CloudMessage::withTarget('token', $user->fcm_token)
                    ->withNotification(Notification::create($title, $body));

                try {
                    $messaging->send($message);
                    Log::info('Notification sent to token: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error('Token not found: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                    Log::error('Invalid argument error with token: ' . $user->fcm_token);
                } catch (\Exception $e) {
                    Log::error('General error sending to token: ' . $user->fcm_token . '. Error: ' . $e->getMessage());
                }
            } else {
                Log::error('No FCM token found for user ID: ' . $memberId);
            }

            return Utils::sendResponse([], 'Circle Meeting Member Reference created successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function refByOtherStore(Request $request)
    {

        try {
            // Validate the request
            $this->validate($request, [
                // Add necessary validation rules if required
                // 'dateTime' => 'required',
                // 'totalMeeting' => 'required',
                // 'refGiven' => 'required',
                // 'refTaken' => 'required',
                // 'busGiven' => 'required',
                // 'busTaken' => 'required',
                // 'hotelName' => 'required',
            ]);

            $busGiver = new CircleMeetingMembersBusiness;
            $busGiver->businessGiverId = $request->memberId;
            $busGiver->loginMemberId = Auth::user()->id;
            $busGiver->amount = $request->amount;
            $busGiver->remarks = $request->remarks;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            if ($request->create_reference == 1) {

                $refGiver = new CircleMeetingMembersReference;
                $refGiver->referenceGiverId = $request->memberId;
                $refGiver->memberId = Auth::user()->id;

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

                $busGiver->referenceId = $refGiver->id;
                $busGiver->save();
            }

            return Utils::sendResponse(
                [
                    'refGiver' => $refGiver,
                    'busGiver' => $busGiver,
                ],
                'Circle Meeting Member Reference and Business created successfully',
                201
            );
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return Utils::errorResponse(
                ['error' => $th->getMessage()],
                'Internal Server Error',
                500
            );
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
            $refGiver->status = 'Deleted';
            $refGiver->save();

            return Utils::sendResponse([], 'Circle Meeting Member Reference deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
