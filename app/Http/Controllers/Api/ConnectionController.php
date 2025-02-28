<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Utils\Utils;
use App\Models\Member;
use App\Models\Connection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\Circle;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class ConnectionController extends Controller
{
    public function receivedConnectionsRequests(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $connections = Connection::where('memberId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName');
                    },
                    'members' => function ($query) {
                        $query->select('id', 'userId', 'profilePhoto');
                    }
                ])
                ->get();
            // check if there are any connections
            if ($connections->isEmpty()) {
                return Utils::sendResponse([], 'No pending connections requests', 200);
            }
            return Utils::sendResponse(['connections' => $connections], 'My Connections Requests retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function sentConnectionsRequests(Request $request)
    {
        try {
            $userId = Auth::id();

            $connections = Connection::where('userId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'receiver' => function ($query) { 
                        $query->select('id', 'email', 'firstName', 'lastName');
                    },
                    'receiverMember' => function ($query) { 
                        $query->select('userId', 'id', 'profilePhoto');
                    }
                ])
                ->get();

            if ($connections->isEmpty()) {
                return Utils::sendResponse([], 'No pending connection requests sent', 200);
            }

            return Utils::sendResponse(['connections' => $connections], 'Sent connection requests retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }




    public function ConnectionsRequests(Request $request)
    {
        try {

            $userId = Auth::user()->id;
            $connections = Connection::where('memberId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName');
                    },
                    'members' => function ($query) {
                        $query->select('id', 'userId', 'profilePhoto');
                    }
                ])
                ->get();
            // check if there are any connections
            if ($connections->isEmpty()) {
                return Utils::sendResponse([], 'No pending connections requests', 200);
            }
            return Utils::sendResponse(['connections' => $connections], 'My Connections Requests retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function myConnections(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            // Fetch connections where the authenticated user is either the userId or memberId
            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)
                    ->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                // ->with(['user:id,firstName,lastName,email', 'member:id,userId,profilePhoto'])
                ->with(['member' => function ($query) {
                    $query->select('id', 'userId', 'profilePhoto')
                        ->with('user:id,email,firstName,lastName');
                }])
                ->get();
            // Include connected user's details for convenience
            // $connections->each(function ($connection) {
            //     $connection->connectedUser = $connection->connected_user;
            // });
            return Utils::sendResponse(['connections' => $connections], 'My Connections retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function sendRequest(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $memberId = $request->input('memberId');
            $isExist = Connection::where('memberId', $memberId)->where('userId', $userId)->first();
            if ($isExist) {
                return Utils::sendResponse(['message' => 'You have already sent the request'], 200);
            }
            $connections = new Connection();
            $connections->memberId = $memberId;
            $connections->userId = $userId;
            $connections->status = 'Pending';
            $connections->save();

            // Fetch the name of the user with the provided memberId
            $member = User::find($memberId);
            if (!$member) {
                return Utils::errorResponse(['message' => 'Member not found'], 'Not Found', 404);
            }
            $memberName = $member->firstName . ' ' . $member->lastName;

            // Send notification to all users
            $users = User::whereNotNull('fcm_token')->get();
            $title = 'Network';
            $body = 'A new connection request has been received by ' . $memberName;

            $serviceAccountPath = storage_path('app/public/ubn_notification.json');
            $factory = (new Factory)->withServiceAccount($serviceAccountPath);
            $messaging = $factory->createMessaging();

            foreach ($users as $user) {
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
            }

            return Utils::sendResponse([$memberId => $connections, 'message' => 'Connection Request sent Successfully'], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }



    // public function search(Request $request)
    // {
    //     try {
    //         $find = $request->input('find');
    //         $members = User::whereHas('member', function ($q) use ($find) {
    //             $q->where('firstName', 'like', '%' . $find . '%')
    //                 ->orWhere('lastName', 'like', '%' . $find . '%')
    //                 ->orWhereHas('circle', function ($q) use ($find) {
    //                     $q->where('circleName', 'like', '%' . $find . '%');
    //                 });
    //         })
    //             ->with(['member', 'member.circle', 'member.connections' => function ($q) {
    //                 $q->where('userId', Auth::user()->id);
    //             }])
    //             ->get();
    //         // ->map(function ($member) {
    //         //     $connection = $member->connections->first();
    //         //     $status = $connection ? $connection->status : null;
    //         //     $member['status'] = $status == 'Accepted' ? 'Connected' : ($status == 'Pending' ? 'Pending' : null);
    //         //     // unset($member['connections']);
    //         //     return $member;
    //         // });

    //         $message = "Search results for '$find'";

    //         return Utils::sendResponse([
    //             'message' => $message,
    //             'members' => $members
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }


    public function search(Request $request)
    {
        try {
            $find = $request->input('find');

            // Get the authenticated user's userId
            $authUserId = Auth::user()->id;

            $members = User::where('status', 'Active') // Ensure the user is active
                ->whereHas('member', function ($q) use ($find, $authUserId) {
                    $q->where('status', 'Active') // Ensure the member is active
                        ->where('userId', '!=', $authUserId) // Exclude the logged-in user's member data
                        ->where(function ($q) use ($find) {
                            $q->where('firstName', 'like', '%' . $find . '%')
                                ->orWhere('lastName', 'like', '%' . $find . '%')
                                ->orWhereHas('circle', function ($q) use ($find) {
                                    $q->where('circleName', 'like', '%' . $find . '%');
                                });
                        });
                })
                ->with([
                    'member',
                    'member.circle' => function ($q) {
                        $q->select('id', 'circleName', 'cityId')
                            ->with(['city' => function ($q) {
                                $q->select('id', 'cityName');
                            }]);
                    },
                    'member.bCategory' => function ($q) {
                        $q->select('id', 'categoryName');
                    },
                    'member.connections' => function ($q) use ($authUserId) {
                        $q->where('userId', $authUserId);
                    }
                ])
                ->get();

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




    public function requestAction(Request $request)
    {
        try {
            $connection = Connection::find($request->input('connectionId'));
            $connection->status = $request->input('action');
            $connection->save();
            return Utils::sendResponse(['message' => 'Connection Request Action done Successfully.'], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function removeConnection(Request $request)
    {
        try {
            $connection = Connection::find($request->input('connectionId'));

            if (!$connection) {
                return Utils::errorResponse(['error' => 'Connection not found.'], 'Not Found', 404);
            }

            $connection->delete();

            return Utils::sendResponse(['message' => 'Connection Removed Successfully.'], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    // public function viewMemberProfile(Request $request)
    // {
    //     try {

    //         $user = Auth::user()->id;
    //         $member = Member::where('userId', $request->input('userId'))
    //             ->with('user', 'circle', 'billingAddress', 'contactDetails', 'topsProfile', 'connections', 'bCategory')
    //             ->first();

    //         if ($member) {
    //             // Check if the authenticated user's circleId matches the member's circleId
    //             $authUserCircleId = Member::where('userId', $user)->value('circleId');
    //             $member->status = ($authUserCircleId == $member->circleId) ? 'Connected' : null;

    //             $status = $member->connections->isEmpty() ? null : $member->connections->first()->status;
    //             $member->status = $status == 'Accepted' ? 'Connected' : ($status == 'Pending' ? 'Pending' : null);

    //             // Get businessCategoryName
    //             $member->businessCategoryName = $member->bCategory ? $member->bCategory->categoryName : null;
    //         }

    //         return Utils::sendResponse([
    //             'message' => 'Member Profile',
    //             'connectionStatus ' => $member ? $member->connections->first() : null,
    //             'member' => $member
    //         ], 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }


    public function viewMemberProfile(Request $request)
    {
        try {
            $authUserId = Auth::user()->id; // Get authenticated user ID

            $member = Member::where('userId', $request->input('userId'))
                ->with('user', 'circle', 'billingAddress', 'contactDetails', 'topsProfile', 'connections', 'bCategory')
                ->first();

            if ($member) {
                // Get authenticated user's circleId
                $authUserCircleId = Member::where('userId', $authUserId)->value('circleId');

                // Check if both users belong to the same circle
                $isSameCircle = ($authUserCircleId == $member->circleId);

                // Check connection status from `connections` relationship
                $connectionStatus = $member->connections->first() ? $member->connections->first()->status : null;

                if ($isSameCircle || $connectionStatus === 'Accepted') {
                    $member->status = 'Connected';
                } elseif ($connectionStatus === 'Pending') {
                    $member->status = 'Pending';
                } else {
                    $member->status = null;
                }

                // Get businessCategoryName
                $member->businessCategoryName = $member->bCategory ? $member->bCategory->categoryName : null;
            }

            return Utils::sendResponse([
                'message' => 'Member Profile',
                'connectionStatus' => $connectionStatus,
                'member' => $member
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }


    public function getCircleMembers($id = null)
    {
        try {
            // If ID is provided, show details for the specific circle
            if ($id) {
                // Fetch circle details and related active members
                $circle = Circle::with(['members' => function ($query) {
                    $query->where('status', 'Active') // Fetch only active members
                        ->with('bCategory:id,categoryName'); // Fetch category name
                }, 'city' => function ($query) {
                    $query->select('id', 'cityName'); // Fetch city name
                }])->findOrFail($id);

                // Return the circle and its active members as JSON
                return response()->json([
                    'circle' => $circle,
                    'members' => $circle->members,
                ]);
            }

            // If no ID is provided, return the list of circles
            $circles = Circle::where('status', 'Active')
                ->with(['city' => function ($query) {
                    $query->select('id', 'cityName');
                }])
                ->withCount(['members' => function ($query) {
                    $query->where('status', 'Active'); // Count only active members if needed
                }])
                ->get();

            // Return the list of circles with member count as JSON
            return response()->json([
                'circles' => $circles,
            ]);
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'error' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }


    public function getCategoryMembers($id = null)
    {
        try {
            // If ID is provided, show details for the specific category and its active members
            if ($id) {
                // Fetch category details
                $category = BusinessCategory::where('id', $id)
                    ->where('status', 'Active')
                    ->firstOrFail();

                // Fetch active members related to this category
                $members = Member::where('businessCategoryId', $id)
                    ->where('status', 'Active')
                    ->with(['circle' => function ($query) {
                        $query->select('id', 'circleName', 'cityId')
                            ->with(['city' => function ($query) {
                                $query->select('id', 'cityName');
                            }]);
                    }])
                    ->get();

                // Return the category and its members as JSON
                return response()->json([
                    'category' => $category,
                    'members' => $members,
                ]);
            }

            // If no ID is provided, return the list of categories with active members
            $categories = BusinessCategory::where('status', 'Active')
                ->whereHas('members', function ($query) {
                    $query->where('status', 'Active'); // Only consider active members
                })
                ->withCount(['members' => function ($query) {
                    $query->where('status', 'Active'); // Count only active members
                }])
                ->with(['members' => function ($query) {
                    $query->where('status', 'Active'); // Load only active members
                }])
                ->get();

            // Return the list of categories with member count and members as JSON
            return response()->json([
                'categories' => $categories,
            ]);
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'error' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }
}
