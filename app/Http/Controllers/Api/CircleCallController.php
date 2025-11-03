<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Circle;
use App\Models\Member;
use App\Models\CircleCall;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class CircleCallController extends Controller
{
    // public function index(Request $request)
    // {
    //     try {
    //         $userId = Auth::id();

    //         $circleCalls = CircleCall::with('members')
    //             ->where('memberId', $userId)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->get();

    //         return Utils::sendResponse(['circleCalls' => $circleCalls], 'Circle Calls retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    public function callNotify()
    {
        $users = User::where('fcm_token', '!=', null)->get();

        $title = 'IBM';
        $body = 'Circle Call Reminder';


        $serviceAccountPath = storage_path('app/public/ubn_notification.json');
        $factory = (new Factory)->withServiceAccount($serviceAccountPath);
        $messaging = $factory->createMessaging();

        $messages = [];
        foreach ($users as $user) {
            if ($user->fcm_token) {
                $message = CloudMessage::withTarget('token', $user->fcm_token)
                    ->withNotification(Notification::create($title, $body));
                try {
                    $messaging->send($message);
                    $messages[] = $message;
                    Log::info('Notification sent to token: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error('Token not found: ' . $user->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                    Log::error('Invalid argument error with token: ' . $user->fcm_token);
                } catch (\Exception $e) {
                    Log::error('General error sending to token: ' . $user->fcm_token . '. Error: ' . $e->getMessage());
                }
            }
        }
        if (count($messages) > 0) {
            Log::info('Circle Call notifications sent successfully');
            return response()->json(['message' => 'Circle Call notifications sent successfully']);
        } else {
            Log::error('No notifications sent');
            return response()->json(['message' => 'No notifications sent'], 404);
        }
    }

    // public function index(Request $request)
    // {
    //     try {
    //         $userId = Auth::id();

    //         $member = Member::where('userId', $userId)->first();

    //         if (!$member) {
    //             return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
    //         }

    //         // $circleCalls = CircleCall::with('members')
    //         //     ->with('meetingPerson')
    //         //     ->where('memberId', $member->id)
    //         //     ->where('status', 'Active')
    //         //     ->orderBy('id', 'DESC')
    //         //     ->get();

    //         $circleCalls = CircleCall::with('meetingPerson')
    //             // ->where('memberId', $userId)
    //             ->with('circle')
    //             ->where('memberId', $userId)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->get();

    //         // foreach ($circleCalls as $circleCall) {
    //         //     $circleCall->meetingPersonId = $circleCall->member->firstName;
    //         // }

    //         $member->induction_count = Member::where('sponsoredBy', $member->id)->count();

    //         return Utils::sendResponse(['circleCalls' => $circleCalls], 'Circle Calls retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    public function index(Request $request)
    {
        try {
            $userId = Auth::id();

            $member = Member::where('userId', $userId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $circleCalls = CircleCall::with([
                'meetingPerson.circle' => function ($query) {
                    $query->select('id', 'circleName');
                }
            ])
                ->where('memberId', $userId) // fixed here
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



    // public function recievedBusinessMeet(Request $request)

    // {
    //     try {
    //         $userId = Auth::id();

    //         $member = Member::where('userId', $userId)->first();

    //         if (!$member) {
    //             return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
    //         }

    //         // $circleCalls = CircleCall::with('members')
    //         //     ->with('meetingPerson')
    //         //     ->where('memberId', $member->id)
    //         //     ->where('status', 'Active')
    //         //     ->orderBy('id', 'DESC')
    //         //     ->get();

    //         $callWith = CircleCall::with('member')
    //             //->with('meetingPerson')
    //             // ->where('memberId', $userId)
    //             ->where('meetingPersonId', $userId)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->get();

    //         // foreach ($circleCalls as $circleCall) {
    //         //     $circleCall->meetingPersonId = $circleCall->member->firstName;
    //         // }


    //         return Utils::sendResponse(['circleCalls' => $callWith], 'Received Circle Calls retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }



    public function recievedBusinessMeet(Request $request)
    {
        try {
            $userId = Auth::id();

            $member = Member::where('userId', $userId)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
            }

            $callWith = CircleCall::with([
                'member.circle' => function ($query) {
                    $query->select('id', 'circleName');
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

            return Utils::sendResponse(['circleCalls' => $callWith], 'Received Circle Calls retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }







    // public function recievedBusinessMeet(Request $request)
    // {
    //     try {
    //         $callWith = CircleCall::with('member')
    //             ->where('meetingPersonId', Auth::user()->id)
    //             ->with('member')
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC');

    //         return Utils::sendResponse(['callWith' => $callWith], 'Circle Call retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    public function show(Request $request, $id)
    {
        try {
            $circleCall = CircleCall::with('members')->findOrFail($id);
            return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'meetingPersonId' => 'required',
    //         'meetingPlace' => 'required',
    //         'meetingImage' => 'mimes:jpeg,jpg,png,gif',
    //         'date' => 'required',
    //         'remarks' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
    //     }

    //     try {
    //         $memberId = Auth::user()->id;
    //         $member = Member::where('userId', $memberId)->first();

    //         if (!$member) {
    //             return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
    //         }

    //         $circleCall = new CircleCall();
    //         $circleCall->memberId = $memberId;
    //         $circleCall->meetingPersonId = $request->input('meetingPersonId');
    //         $circleCall->meetingPlace = $request->input('meetingPlace');

    //         // $circleCall->meetingImage = $request->input('meetingImage');

    //         if ($request->meetingImage) {
    //             $circleCall->meetingImage = time() . '.' . $request->meetingImage->extension();
    //             $request->meetingImage->move(public_path('meetingImage'), $circleCall->meetingImage);
    //         }

    //         $circleCall->date = $request->input('date');
    //         $circleCall->remarks = $request->input('remarks');
    //         $circleCall->status = 'Active';
    //         $circleCall->save();




    //         return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call Created Successfully!', 201);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'meetingPersonId' => 'required',
    //         'meetingPlace' => 'required',
    //         'meetingImage' => 'mimes:jpeg,jpg,png,gif',
    //         'date' => 'required',
    //         'remarks' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
    //     }

    //     try {
    //         $memberId = Auth::user()->id;
    //         $member = Member::where('userId', $memberId)->first();

    //         if (!$member) {
    //             return Utils::errorResponse(['error' => 'Member not found for the authenticated user'], 'Not Found', 404);
    //         }

    //         $circleCall = new CircleCall();
    //         $circleCall->memberId = $memberId;
    //         $circleCall->meetingPersonId = $request->input('meetingPersonId');
    //         $circleCall->meetingPlace = $request->input('meetingPlace');

    //         if ($request->meetingImage) {
    //             $circleCall->meetingImage = time() . '.' . $request->meetingImage->extension();
    //             $request->meetingImage->move(public_path('meetingImage'), $circleCall->meetingImage);
    //         }

    //         $circleCall->date = $request->input('date');
    //         $circleCall->remarks = $request->input('remarks');
    //         $circleCall->status = 'Active';
    //         $circleCall->save();


    //         // Send notification to the specified user
    //         $meetingPersonId = $request->input('meetingPersonId');
    //         $user = User::find($meetingPersonId);

    //         if ($user && $user->fcm_token) {
    //             $title = 'IBM';
    //             $body = $user->firstName . ' ' . $user->lastName . ' has Created IBM with you.';

    //             $serviceAccountPath = storage_path('app/public/ubn_notification.json');
    //             $factory = (new Factory)->withServiceAccount($serviceAccountPath);
    //             $messaging = $factory->createMessaging();

    //             $message = CloudMessage::withTarget('token', $user->fcm_token)
    //                 ->withNotification(Notification::create($title, $body));

    //             try {
    //                 $messaging->send($message);
    //                 Log::info('Notification sent to token: ' . $user->fcm_token);
    //                 // $notificationSent = true;
    //             } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
    //                 Log::error('Token not found: ' . $user->fcm_token);
    //             } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
    //                 Log::error('Invalid argument error with token: ' . $user->fcm_token);
    //             } catch (\Exception $e) {
    //                 Log::error('General error sending to token: ' . $user->fcm_token . '. Error: ' . $e->getMessage());
    //             }
    //         } else {
    //             Log::error('No FCM token found for user ID: ' . $meetingPersonId);
    //         }

    //         return Utils::sendResponse(['circleCall' => $circleCall], 'Circle Call Created Successfully!', 201);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    public function create(Request $request)
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




    public function update(Request $request, $id)
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

    public function delete($id)
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


    public function searchmember(Request $request)
    {
        $userId = $request->user()->id;

        if ($request->has('global') && $request->input('global')) {
            $members = Member::where('userId', '!=', $userId)->get();
            return Utils::sendResponse($members, 'All Members Retrieved Successfully!', 200);
        } else {
            $member = Member::where('userId', $userId)->first();

            if ($member) {
                $circleId = $member->circleId;

                $members = Member::where('circleId', $circleId)
                    ->where('userId', '!=', $userId)
                    ->get();

                return Utils::sendResponse($members, 'Members from your Circle Retrieved Successfully!', 200);
            } else {
                return Utils::errorResponse(['error' => 'User not authenticated'], 'Unauthorized', 401);
            }
        }
    }
}
