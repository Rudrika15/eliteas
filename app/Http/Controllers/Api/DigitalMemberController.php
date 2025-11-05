<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\City;
use App\Models\Connection;
use App\Models\Member;
use App\Models\User;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class DigitalMemberController extends Controller
{
    public function getCities(Request $request)
    {
        try {
            $cities = City::where('status', 'Active')->get();

            return Utils::sendResponse(['cities' => $cities], 'Cities retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function digitalMemberSearch(Request $request)
    {
        try {
            $find = $request->input('find');
            $authUserId = Auth::id();

            // Get the logged-in user's member record
            $authMember = Member::where('userId', $authUserId)->first();

            $members = User::where('status', 'Active')
                ->whereHas('member', function ($q) use ($find, $authUserId) {
                    $q->where('status', 'Active')
                        ->where('userId', '!=', $authUserId)
                        // ✅ Only members with no circle and with a city
                        ->whereNull('circleId')
                        ->whereNotNull('cityId')
                        ->where(function ($q) use ($find) {
                            $q->where('firstName', 'like', '%' . $find . '%')
                                ->orWhere('lastName', 'like', '%' . $find . '%');
                        });
                })
                ->with([
                    'member' => function ($q) {
                        // ✅ Include basic member info only
                        $q->select('id', 'userId', 'cityId', 'bCategoryId', 'status', 'sponsoredBy');
                    },
                    'member.city:id,cityName', // ✅ Keep city info since circle removed
                    'member.bCategory:id,categoryName',
                    'member.connections' => function ($q) use ($authUserId) {
                        $q->where('userId', $authUserId);
                    }
                ])
                ->get();

            // ✅ Loop through members to determine connection_status and induction_count
            foreach ($members as $user) {
                $member = $user->member;

                if (!$member) {
                    $user->connection_status = 'Not Connected';
                    $user->induction_count = 0;
                    continue;
                }

                // Count of members sponsored by this member
                $user->induction_count = Member::where('sponsoredBy', $member->id)->count();

                // ✅ Determine connection status
                $connection = Connection::where(function ($query) use ($authUserId, $member) {
                    $query->where('userId', $authUserId)->where('memberId', $member->userId)
                        ->orWhere(function ($query) use ($authUserId, $member) {
                            $query->where('userId', $member->userId)->where('memberId', $authUserId);
                        });
                })->first();

                if ($connection && $connection->status === 'Accepted') {
                    $user->connection_status = 'Connected';
                } else {
                    $user->connection_status = $connection ? $connection->status : 'Not Connected';
                }
            }

            $message = "Search results for '$find' (Members with city but no circle)";

            return Utils::sendResponse([
                'message' => $message,
                'members' => $members
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }

    // ibm module apis

    public function ibmIndex(Request $request)
    {
        try {
            $userId = Auth::id();

            $member = Member::where('userId', $userId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $circleCalls = CircleCall::with([
                'meetingPerson' // 👈 only this — removed 'meetingPerson.circle'
            ])
                ->where('memberId', $userId)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();


            // Add induction count to each meetingPerson
            $circleCalls->transform(function ($call) {
                if ($call->meetingPerson) {
                    $call->meetingPerson->induction_count = Member::where('sponsoredBy', $call->meetingPerson->id)->count() ?? 0;
                }
                return $call;
            });

            return Utils::sendResponse([
                'circleCalls' => $circleCalls,
            ], 'Circle Calls retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function ibmCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meetingPersonId' => 'required',
            'meetingPlace' => 'required',
            'meetingImage' => 'mimes:jpeg,jpg,png,gif',
            'date' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $memberId = Auth::user()->id;
            $member = Member::where('userId', $memberId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $circleCall = new CircleCall();
            $circleCall->memberId = $memberId;
            $circleCall->meetingPersonId = $request->input('meetingPersonId');
            $circleCall->meetingPlace = $request->input('meetingPlace');

            if ($request->meetingImage) {
                $circleCall->meetingImage = time() . '.' . $request->meetingImage->extension();
                $request->meetingImage->move(public_path('meetingImage'), $circleCall->meetingImage);
            }

            $circleCall->date = $request->input('date');
            $circleCall->remarks = $request->input('remarks');
            $circleCall->status = 'Active';
            $circleCall->save();

            // Send notification to the specified user
            $meetingPersonId = $request->input('meetingPersonId');
            $user = User::find($meetingPersonId);

            if ($user && $user->fcm_token) {
                $title = 'IBM';
                $sender = Auth::user();
                $body = $sender->firstName . ' ' . $sender->lastName . ' has Created IBM with you.';

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
                Log::error('No FCM token found for user ID: ' . $meetingPersonId);
            }

            return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call Created Successfully!', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function ibmUpdate(Request $request, $id)
    {

        // return $request;

        $validator = Validator::make($request->all(), [
            'meetingPersonId' => 'required',
            'meetingPlace' => 'required',
            'meetingImage' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'date' => 'required',
            'remarks' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $memberId = Auth::user()->id;
            $member = Member::where('userId', $memberId)->with('circle')->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $circleCall = CircleCall::find($id);

            if (!$circleCall) {
                return Utils::errorResponse(['error' => 'Circle Call not found'], 'Not Found', 404);
            }

            if ($circleCall->memberId != $member->userId) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized', 403);
            }

            $circleCall->meetingPersonId = $request->input('meetingPersonId');
            $circleCall->meetingPlace = $request->input('meetingPlace');

            if ($request->meetingImage) {
                $circleCall->meetingImage = time() . '.' . $request->meetingImage->extension();
                $request->meetingImage->move(public_path('meetingImage'), $circleCall->meetingImage);
            }

            $circleCall->date = $request->input('date');
            $circleCall->remarks = $request->input('remarks');
            $circleCall->save();

            return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function ibmDelete($id)
    {
        try {
            $memberId = Auth::user()->id;
            $member = Member::where('userId', $memberId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $circleCall = CircleCall::find($id);

            if (!$circleCall) {
                return Utils::errorResponse(['error' => 'Circle Call not found'], 'Not Found', 404);
            }

            if ($circleCall->memberId != $memberId) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized', 403);
            }

            $circleCall->status = "Deleted";
            $circleCall->save();

            return Utils::sendResponse([], 'Circle Call Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function recievedBus(Request $request)
    {
        try {
            $busRecieved = CircleMeetingMembersBusiness::with([
                'loginMember.user:id,firstName,lastName',
                'loginMember.member' => function ($q) {
                    $q->select('id', 'userId', 'sponsoredBy', 'profilePhoto', 'cityId');
                },
                'loginMember.member.city:id,cityName', // city instead of circle
                'businessAmounts'
            ])
                ->where('businessGiverId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->get();

            // Add induction count to loginMember's member
            $busRecieved->transform(function ($item) {
                if ($item->loginMember && $item->loginMember->member) {
                    $member = $item->loginMember->member;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count() ?? 0;
                }
                return $item;
            });

            return Utils::sendResponse(['busRecieved' => $busRecieved], 'Circle Meeting Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function cityWiseMember(Request $request)
    {
        try {
            $cityData = [];

            if (!auth()->check()) {
                return Utils::errorResponse([], 'Unauthorized', 401);
            }

            $user = auth()->user();
            $authMemberId = $user->member->id;
            $authCityId = $user->member->cityId;

            $members = Member::where('cityId', $authCityId)->get();

            foreach ($members as $member) {
                $city = City::find($member->cityId);

                if ($city && $city->status === 'Active') {
                    if (empty($cityData)) {
                        $cityData = [
                            'cityId' => $city->id,
                            'cityName' => $city->cityName,
                            'members' => [],
                        ];
                    }

                    $cityData['members'][] = [
                        'authMemberId' => $authMemberId,
                        'memberId' => $member->id,
                        'firstName' => $member->firstName,
                        'lastName' => $member->lastName,
                        'induction_count' => Member::where('sponsoredBy', $member->id)->count(),
                    ];
                }
            }
            return Utils::sendResponse($cityData, 'Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }
}
