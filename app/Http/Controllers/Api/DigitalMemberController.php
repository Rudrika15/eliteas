<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\City;
use App\Models\Connection;
use App\Models\Member;
use App\Models\User;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Carbon\Carbon;
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
                                ->orWhere('lastName', 'like', '%' . $find . '%')
                                ->orWhereHas('city', function ($cityQuery) use ($find) {
                                    $cityQuery->where('cityName', 'like', '%' . $find . '%');
                                });
                        });
                })
                ->with([
                    'member' => function ($q) {
                        // ✅ Include basic member info only
                        $q->select('id', 'userId', 'cityId', 'businessCategoryId', 'status', 'sponsoredBy');
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

            $message = "Search results for '$find'";

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

    // public function getCityMembers(Request $request, $id = null)
    // {
    //     try {
    //         $businessMeetings = CircleMeetingMembersBusiness::with('member')
    //             ->where('status', 'Active')
    //             ->get();

    //         if ($id) {
    //             // ✅ Get members based on cityId
    //             $city = City::with([
    //                 'members' => function ($query) {
    //                     $query->where('status', 'Active')
    //                         ->with([
    //                             'bCategory:id,categoryName',
    //                             'user:id,email,contactNo'
    //                         ]);
    //                 }
    //             ])->findOrFail($id);

    //             $city->totalBusinessAmount = 0;

    //             foreach ($city->members as $member) {
    //                 $member->businessAmount = 0;
    //                 $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
    //             }

    //             foreach ($businessMeetings as $meeting) {
    //                 $businessGiverCityId = Member::where('userId', $meeting->businessGiverId)->value('cityId');
    //                 if ($businessGiverCityId == $city->id) {
    //                     $city->totalBusinessAmount += $meeting->amount;

    //                     foreach ($city->members as $member) {
    //                         if ($member->userId == $meeting->loginMemberId) {
    //                             $member->businessAmount += $meeting->amount;
    //                         }
    //                     }
    //                 }
    //             }

    //             return response()->json([
    //                 'success' => true,
    //                 'city' => $city,
    //             ]);
    //         }

    //         // ✅ Get all active cities with members
    //         $cities = City::where('status', 'Active')
    //             ->with([
    //                 'members' => function ($query) {
    //                     $query->where('status', 'Active')
    //                         ->with([
    //                             'bCategory:id,categoryName',
    //                             'user:id,email,contactNo'
    //                         ]);
    //                 }
    //             ])
    //             ->withCount(['members' => function ($query) {
    //                 $query->where('status', 'Active');
    //             }])
    //             ->get();

    //         foreach ($cities as $city) {
    //             $city->totalBusinessAmount = 0;

    //             foreach ($city->members as $member) {
    //                 $member->businessAmount = 0;
    //                 $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
    //             }

    //             foreach ($businessMeetings as $meeting) {
    //                 $businessGiverCityId = Member::where('userId', $meeting->businessGiverId)->value('cityId');
    //                 if ($businessGiverCityId == $city->id) {
    //                     $city->totalBusinessAmount += $meeting->amount;

    //                     foreach ($city->members as $member) {
    //                         if ($member->userId == $meeting->loginMemberId) {
    //                             $member->businessAmount += $meeting->amount;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'cities' => $cities,
    //         ]);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         Log::error('Error in getCityMembers', [
    //             'message' => $th->getMessage(),
    //             'trace' => $th->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'error' => 'An error occurred. Please try again later.',
    //         ], 500);
    //     }
    // }

    public function getCityMembers(Request $request, $id = null)
    {
        try {
            $authUserId = Auth::id();
            $businessMeetings = CircleMeetingMembersBusiness::with('member')
                ->where('status', 'Active')
                ->get();

            if ($id) {
                // ✅ Get members based on cityId
                $city = City::with([
                    'members' => function ($query) {
                        $query->where('status', 'Active')
                            ->with([
                                'bCategory:id,categoryName',
                                'user:id,email,contactNo'
                            ]);
                    }
                ])->findOrFail($id);

                $city->totalBusinessAmount = 0;

                foreach ($city->members as $member) {
                    $member->businessAmount = 0;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
                    $connection = Connection::where(function ($query) use ($authUserId, $member) {
                        $query->where('userId', $authUserId)->where('memberId', $member->userId)
                            ->orWhere(function ($query) use ($authUserId, $member) {
                                $query->where('userId', $member->userId)->where('memberId', $authUserId);
                            });
                    })->first();
                    if ($connection && $connection->status === 'Accepted') {
                        $member->connection_status = 'Connected';
                    } else {
                        $member->connection_status = $connection ? $connection->status : 'Not Connected';
                    }
                }

                foreach ($businessMeetings as $meeting) {
                    $businessGiverCityId = Member::where('userId', $meeting->businessGiverId)->value('cityId');
                    if ($businessGiverCityId == $city->id) {
                        $city->totalBusinessAmount += $meeting->amount;

                        foreach ($city->members as $member) {
                            if ($member->userId == $meeting->loginMemberId) {
                                $member->businessAmount += $meeting->amount;
                            }
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    'city' => $city,
                ]);
            }

            // ✅ Get all active cities with members
            $cities = City::where('status', 'Active')
                ->with([
                    'members' => function ($query) {
                        $query->where('status', 'Active')
                            ->with([
                                'bCategory:id,categoryName',
                                'user:id,email,contactNo'
                            ]);
                    }
                ])
                ->withCount(['members' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->get();

            foreach ($cities as $city) {
                $city->totalBusinessAmount = 0;

                foreach ($city->members as $member) {
                    $member->businessAmount = 0;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
                    $connection = Connection::where(function ($query) use ($authUserId, $member) {
                        $query->where('userId', $authUserId)->where('memberId', $member->userId)
                            ->orWhere(function ($query) use ($authUserId, $member) {
                                $query->where('userId', $member->userId)->where('memberId', $authUserId);
                            });
                    })->first();
                    if ($connection && $connection->status === 'Accepted') {
                        $member->connection_status = 'Connected';
                    } else {
                        $member->connection_status = $connection ? $connection->status : 'Not Connected';
                    }
                }

                foreach ($businessMeetings as $meeting) {
                    $businessGiverCityId = Member::where('userId', $meeting->businessGiverId)->value('cityId');
                    if ($businessGiverCityId == $city->id) {
                        $city->totalBusinessAmount += $meeting->amount;

                        foreach ($city->members as $member) {
                            if ($member->userId == $meeting->loginMemberId) {
                                $member->businessAmount += $meeting->amount;
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'cities' => $cities,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            Log::error('Error in getCityMembers', [
                'message' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }


    public function getCityMemberCount()
    {
        try {
            $cities = City::withCount([
                'members as member_count' => function ($query) {
                    $query->where('status', 'Active');
                }
            ])
                ->whereHas('members', function ($q) {
                    $q->where('status', 'Active');
                })
                ->get(['id', 'cityName']);

            return response()->json([
                'success' => true,
                'data' => $cities
            ]);
        } catch (\Throwable $th) {
            Log::error('City Member Count Error', [
                'message' => $th->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Something went wrong'
            ], 500);
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

            return Utils::sendResponse(['circleCall' => $circleCall], 'City Call Created Successfully!', 201);
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

            return Utils::sendResponse(['circleCall' => $circleCall], 'City Call Updated Successfully!', 200);
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
                return Utils::errorResponse(['error' => 'IBM not found'], 'Not Found', 404);
            }

            if ($circleCall->memberId != $memberId) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized', 403);
            }

            $circleCall->status = "Deleted";
            $circleCall->save();

            return Utils::sendResponse([], 'IBM Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function recievedDigitalBusinessMeet(Request $request)
    {
        try {
            $userId = Auth::id();

            $member = Member::where('userId', $userId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $callWith = CircleCall::with([
                'member.city' => function ($query) {
                    $query->select('id', 'cityName');
                }
            ])
                ->where('meetingPersonId', $userId)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();

            // Add induction count to each member
            $callWith->transform(function ($call) {
                if ($call->member) {
                    $call->member->induction_count = Member::where('sponsoredBy', $call->member->id)->count() ?? 0;
                }
                return $call;
            });

            return Utils::sendResponse(['cityCalls' => $callWith], 'Received City Calls retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function recievedBusDigital(Request $request)
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

            return Utils::sendResponse(['busRecieved' => $busRecieved], 'Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function refBusCreateDigital(Request $request)
    {
        $this->validate($request, []);

        try {
            // Save reference giver
            $refGiver = new CircleMeetingMembersReference();
            $refGiver->referenceGiverId = Auth::user()->id;
            $refGiver->memberId = $request->memberId;
            $refGiver->contactName = $request->contactNameExternal;
            $refGiver->contactNo = $request->contactNo;
            $refGiver->email = $request->email;
            $refGiver->scale = $request->scale;
            $refGiver->description = $request->description;
            $refGiver->status = 'Active';
            $refGiver->save();

            // Save business giver
            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = Auth::user()->id;
            $busGiver->loginMemberId = $refGiver->memberId;
            $busGiver->amount = $request->amount;
            $busGiver->remarks = $request->remarks;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            // Send notification to the specified member (city-based, no circle)
            $memberId = $request->memberId;
            $user = User::find($memberId);

            if ($user && $user->fcm_token) {
                $title = 'Reference';
                $body = 'A new reference has been created for you by ' . Auth::user()->firstName . ' ' . Auth::user()->lastName . '.';

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

            return Utils::sendResponse([], 'Member Reference created successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function digitalBusinessindex(Request $request)
    {
        try {
            $busGiven = CircleMeetingMembersBusiness::with([
                'users:id,firstName,lastName,email',
                'member' => function ($q) {
                    $q->select('id', 'userId', 'cityId', 'sponsoredBy', 'profilePhoto', 'companyName');
                },
                'member.city:id,cityName',
                'businessAmounts'
            ])
                ->where('loginMemberId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderByDesc('id')
                ->get();

            // Add induction count to member
            $busGiven->transform(function ($item) {
                if ($item->member) {
                    $item->member->induction_count = Member::where('sponsoredBy', $item->member->id)->count() ?? 0;
                }
                return $item;
            });

            return Utils::sendResponse(['busGiven' => $busGiven], 'Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    //reference
    public function digitalMemberReferenceUpdate(Request $request)
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
            return Utils::sendResponse([], ' Reference updated successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function digitalMemberReferenceIndex(Request $request)
    {
        try {
            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->with('members')
                ->with('refGiverName')
                ->with('members.city:id,cityName') // city instead of circle
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

            return Utils::sendResponse(['refGiver' => $refGiver], 'References retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // business create

    public function digitalMemberRefByOtherStore(Request $request)
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

            $refGiver = new CircleMeetingMembersReference();
            $refGiver->referenceGiverId = $request->referenceGiverId;
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

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = $refGiver->referenceGiverId;
            $busGiver->loginMemberId = Auth::user()->id;
            $busGiver->amount = $request->amount;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            return Utils::sendResponse(
                [
                    'refGiver' => $refGiver,
                    'busGiver' => $busGiver,
                ],
                'Reference and Business created successfully',
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


    public function deleteDigitalMemberReference($id)
    {
        try {
            $refGiver = CircleMeetingMembersReference::find($id);
            $refGiver->status = "Deleted";
            $refGiver->save();

            return Utils::sendResponse([], 'Reference deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    // public function cityWiseDigitalMember(Request $request)
    // {
    //     try {
    //         $cities = City::where('status', 'Active')->get();

    //         $response = $cities->map(function ($city) {
    //             $members = Member::where('cityId', $city->id)->get();

    //             $memberData = $members->map(function ($member) {
    //                 return [
    //                     'id' => $member->id,
    //                     'userId' => $member->userId,
    //                     'firstName' => $member->firstName,
    //                     'lastName' => $member->lastName,
    //                     'contactDetails' => [], // can be filled later
    //                     'induction_count' => Member::where('sponsoredBy', $member->id)->count(),
    //                 ];
    //             });

    //             return [
    //                 'cityData' => [
    //                     'id' => $city->id,
    //                     'name' => $city->cityName,
    //                 ],
    //                 'memberData' => $memberData,
    //             ];
    //         });

    //         return Utils::sendResponse($response, 'Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage(),
    //         ], 'Internal Server Error', 500);
    //     }
    // }


    public function cityWiseDigitalMember(Request $request)
    {
        try {
            $cities = City::where('status', 'Active')->get();

            $response = $cities->map(function ($city) {
                $members = Member::where('cityId', $city->id)->get();

                $memberData = $members->map(function ($member) {
                    $memberContactDetails = $member->contactDetails()
                        ->select('id', 'memberId', 'mobileNo', 'email')
                        ->get()
                        ->toArray();

                    return [
                        'id' => $member->id,
                        'userId' => $member->userId,
                        'firstName' => $member->firstName,
                        'lastName' => $member->lastName,
                        'contactDetails' => $memberContactDetails,
                        'induction_count' => Member::where('sponsoredBy', $member->id)->count(),
                    ];
                });

                return [
                    'cityData' => [
                        'id' => $city->id,
                        'name' => $city->cityName,
                    ],
                    'memberData' => $memberData,
                ];
            });

            return Utils::sendResponse($response, 'Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage(),
            ], 'Internal Server Error', 500);
        }
    }

    public function getCityCount()
    {
        try {

            // All DISTINCT city IDs from Member and Circle tables
            $memberCities = Member::distinct()->pluck('cityId');
            $circleCities = Circle::distinct()->pluck('cityId');

            // Merge both, remove duplicates
            $allCities = $memberCities->merge($circleCities)->unique();

            // Count
            $cityCount = $allCities->count();

            // Prepare response in same structure as cityWiseDigitalMember()
            $response = [
                'cityData' => [
                    'total_cities' => $cityCount,
                ]
            ];

            return Utils::sendResponse($response, 'City count retrieved successfully', 200);
        } catch (\Throwable $th) {

            return Utils::errorResponse([
                'error' => $th->getMessage(),
            ], 'Internal Server Error', 500);
        }
    }
}
