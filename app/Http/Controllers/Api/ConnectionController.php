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
use App\Models\CircleMeetingMembersBusiness;
use App\Models\Testimonial;
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
            $userId = Auth::id();

            $connections = Connection::where('memberId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName', 'contactNo');
                    },
                    'members' => function ($query) {
                        $query->select('userId', 'id', 'profilePhoto', 'companyName', 'circleId', 'businessCategoryId')
                            ->with([
                                'circle:id,circleName',
                                'bCategory:id,categoryName'
                            ]);
                    }
                ])
                ->get();

            if ($connections->isEmpty()) {
                return Utils::sendResponse(null, 'No pending connections requests', 200);
            }

            // Loop through connections and calculate induction count based on members->id == sponsoredBy
            $connections->transform(function ($connection) {
                $sponsorMemberId = optional($connection->members)->id;
                $connection->induction_count = Member::where('sponsoredBy', $sponsorMemberId)->count();
                return $connection;
            });

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
                        $query->select('id', 'email', 'firstName', 'lastName', 'contactNo');
                    },
                    'receiverMember' => function ($query) {
                        $query->select('userId', 'id', 'profilePhoto', 'companyName', 'circleId', 'businessCategoryId')
                            ->with([
                                'circle:id,circleName',
                                'bCategory:id,categoryName'
                            ]);
                    }
                ])
                ->get();

            if ($connections->isEmpty()) {
                return Utils::sendResponse(null, 'No pending connection requests sent', 200);
            }

            // Calculate induction count based on receiverMember->id == sponsoredBy
            $connections->transform(function ($connection) {
                $receiverMemberId = optional($connection->receiverMember)->id;
                $connection->induction_count = Member::where('sponsoredBy', $receiverMemberId)->count();
                return $connection;
            });

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
                        $query->select('id', 'email', 'firstName', 'lastName', 'contactNo');
                    },
                    'members' => function ($query) {
                        $query->select('userId', 'id', 'profilePhoto', 'companyName', 'circleId', 'businessCategoryId')
                            ->with([
                                'circle:id,circleName',
                                'bCategory:id,categoryName'
                            ]);
                    }
                ])
                ->get();

            if ($connections->isEmpty()) {
                return Utils::sendResponse(null, 'No pending connections requests', 200);
            }

            // Add induction_count for each connection
            $connections->transform(function ($connection) {
                $memberId = optional($connection->members)->id;
                $connection->induction_count = Member::where('sponsoredBy', $memberId)->count();
                return $connection;
            });

            return Utils::sendResponse(['connections' => $connections], 'My Connections Requests retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function myConnections(Request $request)
    {
        try {
            $userId = Auth::user()->id;

            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)
                    ->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                ->with(['member' => function ($query) {
                    $query->select('id', 'userId', 'profilePhoto', 'circleId', 'businessCategoryId')
                        ->with([
                            'user:id,email,firstName,lastName,contactNo',
                            'circle:id,circleName',
                            'bCategory:id,categoryName'
                        ]);
                }])
                ->get();

            if ($connections->isEmpty()) {
                return Utils::sendResponse(null, 'No Connections Found', 200);
            }

            $connections->transform(function ($connection) {
                $memberId = optional($connection->member)->id;
                $connection->induction_count = Member::where('sponsoredBy', $memberId)->count();
                return $connection;
            });

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

            // Send notification to only one user 
            $users = User::where('id', $memberId)->whereNotNull('fcm_token')->get();
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


    // public function search(Request $request)
    // {
    //     try {
    //         $find = $request->input('find');

    //         // Get the authenticated user's userId
    //         $authUserId = Auth::user()->id;

    //         $members = User::where('status', 'Active') // Ensure the user is active
    //             ->whereHas('member', function ($q) use ($find, $authUserId) {
    //                 $q->where('status', 'Active') // Ensure the member is active
    //                     ->where('userId', '!=', $authUserId) // Exclude the logged-in user's member data
    //                     ->where(function ($q) use ($find) {
    //                         $q->where('firstName', 'like', '%' . $find . '%')
    //                             ->orWhere('lastName', 'like', '%' . $find . '%')
    //                             ->orWhereHas('circle', function ($q) use ($find) {
    //                                 $q->where('circleName', 'like', '%' . $find . '%');
    //                             });
    //                     });
    //             })
    //             ->with([
    //                 'member',
    //                 'member.circle' => function ($q) {
    //                     $q->select('id', 'circleName', 'cityId')
    //                         ->with(['city' => function ($q) {
    //                             $q->select('id', 'cityName');
    //                         }]);
    //                 },
    //                 'member.bCategory' => function ($q) {
    //                     $q->select('id', 'categoryName');
    //                 },
    //                 'member.connections' => function ($q) use ($authUserId) {
    //                     $q->where('userId', $authUserId);
    //                 }
    //             ])
    //             ->get();

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
            $authUserId = Auth::id();

            // Get the logged-in user's member record to find their circle
            $authMember = Member::where('userId', $authUserId)->first();
            $authCircleId = $authMember ? $authMember->circleId : null;

            $members = User::where('status', 'Active')
                ->whereHas('member', function ($q) use ($find, $authUserId) {
                    $q->where('status', 'Active')
                        ->where('userId', '!=', $authUserId)
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
                        $q->select('id', 'circleName', 'cityId')->with('city:id,cityName');
                    },
                    'member.bCategory:id,categoryName',
                    'member.connections' => function ($q) use ($authUserId) {
                        $q->where('userId', $authUserId);
                    }
                ])
                ->get();

            // Loop through members to determine connection_status and induction_count
            foreach ($members as $user) {
                $member = $user->member;

                if (!$member) {
                    $user->connection_status = 'Not Connected';
                    $user->induction_count = 0;
                    continue;
                }

                // Count of members sponsored by this member
                $user->induction_count = Member::where('sponsoredBy', $member->id)->count();

                if ($authCircleId !== null && $member->circleId == $authCircleId) {
                    $user->connection_status = 'Connected';
                } else {
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





    public function chatConnectionSearch(Request $request)
    {
        try {
            $userId = Auth::id();
            $keyword = $request->input('keyword');

            // Get the authenticated user's Member record
            $member = Member::where('userId', $userId)->first();

            if (!$member || !$member->circleId) {
                return Utils::errorResponse(['error' => 'User does not belong to any circle.'], 'No Circle Found', 404);
            }

            $circleId = $member->circleId;

            // === Fetch Connections (excluding auth user) ===
            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)
                    ->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                ->with(['member' => function ($query) use ($keyword, $userId) {
                    $query->select('id', 'userId', 'profilePhoto')
                        ->whereHas('user', function ($q) use ($userId) {
                            $q->where('id', '!=', $userId); // Exclude auth user
                        })
                        ->with(['user' => function ($q) use ($keyword, $userId) {
                            $q->select('id', 'firstName', 'lastName', 'email')
                                ->where('id', '!=', $userId) // Exclude auth user again for safety
                                ->when($keyword, function ($q) use ($keyword) {
                                    $q->where(function ($subQuery) use ($keyword) {
                                        $subQuery->where('firstName', 'like', '%' . $keyword . '%')
                                            ->orWhere('lastName', 'like', '%' . $keyword . '%');
                                    });
                                });
                        }]);
                }])
                ->get();

            // === Fetch Circle & Active Members (excluding auth user) ===
            $circle = Circle::with([
                'members' => function ($query) use ($keyword, $userId) {
                    $query->where('status', 'Active')
                        ->whereHas('user', function ($q) use ($userId) {
                            $q->where('id', '!=', $userId); // Exclude auth user
                        })
                        ->with(['user:id,firstName,lastName,email', 'bCategory:id,categoryName'])
                        ->when($keyword, function ($q) use ($keyword) {
                            $q->whereHas('user', function ($userQuery) use ($keyword) {
                                $userQuery->where('firstName', 'like', '%' . $keyword . '%')
                                    ->orWhere('lastName', 'like', '%' . $keyword . '%');
                            });
                        });
                },
                'city:id,cityName'
            ])->findOrFail($circleId);

            return Utils::sendResponse([
                'message' => 'Chat connections and circle members retrieved successfully.',
                'connections' => $connections,
                'circle' => $circle,
                'members' => $circle->members,
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function requestAction(Request $request)
    {
        try {
            $connection = Connection::find($request->input('connectionId'));

            if (!$connection) {
                return Utils::errorResponse(['error' => 'Connection not found.'], 'Not Found', 404);
            }

            if ($request->input('action') === 'Rejected') {
                $connection->delete();
                return Utils::sendResponse(['message' => 'Connection request rejected and deleted successfully.'], 200);
            }

            $connection->status = $request->input('action');
            $connection->save();

            return Utils::sendResponse(['message' => 'Connection request action completed successfully.'], 200);
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


    // public function viewMemberProfile(Request $request)
    // {
    //     try {
    //         $authUserId = Auth::user()->id; // Get authenticated user ID

    //         $member = Member::where('userId', $request->input('userId'))
    //             ->with('user', 'circle', 'billingAddress', 'contactDetails', 'topsProfile', 'connections', 'bCategory')
    //             ->first();

    //         if ($member) {
    //             // Get authenticated user's circleId
    //             $authUserCircleId = Member::where('userId', $authUserId)->value('circleId');

    //             // Check if both users belong to the same circle
    //             $isSameCircle = ($authUserCircleId == $member->circleId);

    //             // Check connection status from `connections` relationship
    //             $connectionStatus = $member->connections->first() ? $member->connections->first()->status : null;

    //             if ($isSameCircle || $connectionStatus === 'Accepted') {
    //                 $member->status = 'Connected';
    //             } elseif ($connectionStatus === 'Pending') {
    //                 $member->status = 'Pending';
    //             } else {
    //                 $member->status = null;
    //             }

    //             // Get businessCategoryName
    //             $member->businessCategoryName = $member->bCategory ? $member->bCategory->categoryName : null;
    //         }

    //         return Utils::sendResponse([
    //             'message' => 'Member Profile',
    //             // 'connectionStatus' => $connectionStatus,
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
            $authUserId = Auth::id();

            $member = Member::where('userId', $request->input('userId'))
                ->with('user', 'circle', 'billingAddress', 'contactDetails', 'topsProfile', 'connections', 'bCategory')
                ->first();

            if (!$member) {
                return Utils::sendResponse([
                    'message' => 'Member not found',
                    'member' => null
                ], 404);
            }

            $authUserCircleId = Member::where('userId', $authUserId)->value('circleId');
            $isSameCircle = ($authUserCircleId == $member->circleId);

            $connection = Connection::where(function ($query) use ($authUserId, $member) {
                $query->where('userId', $authUserId)
                    ->where('memberId', $member->userId);
            })->orWhere(function ($query) use ($authUserId, $member) {
                $query->where('userId', $member->userId)
                    ->where('memberId', $authUserId);
            })->first();

            $connectionStatus = $connection?->status;

            if ($isSameCircle || $connectionStatus === 'Accepted') {
                $member->status = 'Connected';
            } elseif ($connectionStatus === 'Pending') {
                $member->status = 'Pending';
            } else {
                $member->status = null;
            }

            // Add business category name
            $member->businessCategoryName = $member->bCategory?->categoryName;

            // ✅ Add induction count
            $member->induction_count = Member::where('sponsoredBy', $member->id)->count();

            // Add Testimonial
            $member->testimonials = Testimonial::where('memberId', $member->id)
                ->with('user:id,firstName,lastName')
                ->get() ?? [];


            return Utils::sendResponse([
                'message' => 'Member Profile',
                'member' => $member
            ], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }





    // public function getCircleMembers(Request $request, $id = null)
    // {
    //     try {
    //         $businessMeetings = CircleMeetingMembersBusiness::with('member')->where('status', 'Active')->get();

    //         if ($id) {
    //             $circle = Circle::with([
    //                 'members' => function ($query) {
    //                     $query->where('status', 'Active')
    //                         ->with([
    //                             'bCategory:id,categoryName',
    //                             'user:id,email,contactNo'
    //                         ]);
    //                 },
    //                 'city:id,cityName'
    //             ])->findOrFail($id);

    //             $circle->totalBusinessAmount = 0;

    //             foreach ($circle->members as $member) {
    //                 $member->businessAmount = 0;
    //                 $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
    //             }

    //             foreach ($businessMeetings as $meeting) {
    //                 $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //                 if ($businessGiverCircleId == $circle->id) {
    //                     $circle->totalBusinessAmount += $meeting->amount;

    //                     foreach ($circle->members as $member) {
    //                         if ($member->userId == $meeting->member->userId) {
    //                             $member->businessAmount += $meeting->amount;
    //                         }
    //                     }
    //                 }
    //             }

    //             return response()->json([
    //                 'success' => true,
    //                 'circle' => $circle,
    //             ]);
    //         }

    //         $circles = Circle::where('status', 'Active')
    //             ->with([
    //                 'members' => function ($query) {
    //                     $query->where('status', 'Active')
    //                         ->with([
    //                             'bCategory:id,categoryName',
    //                             'user:id,email,contactNo'
    //                         ]);
    //                 },
    //                 'city:id,cityName'
    //             ])
    //             ->withCount(['members' => function ($query) {
    //                 $query->where('status', 'Active');
    //             }])
    //             ->get();

    //         foreach ($circles as $circle) {
    //             $circle->totalBusinessAmount = 0;

    //             foreach ($circle->members as $member) {
    //                 $member->businessAmount = 0;
    //                 $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
    //             }

    //             foreach ($businessMeetings as $meeting) {
    //                 $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //                 if ($businessGiverCircleId == $circle->id) {
    //                     $circle->totalBusinessAmount += $meeting->amount;

    //                     foreach ($circle->members as $member) {
    //                         if ($member->id == $meeting->member->id) {
    //                             $member->businessAmount += $meeting->amount;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'circles' => $circles,
    //         ]);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json([
    //             'success' => false,
    //             'error' => 'An error occurred. Please try again later.',
    //         ], 500);
    //     }
    // }



    public function getCircleMembers(Request $request, $id = null)
    {
        try {

            $businessMeetings = CircleMeetingMembersBusiness::with('member')->where('status', 'Active')->get();

            if ($id) {

                $circle = Circle::with([
                    'members' => function ($query) {
                        $query->where('status', 'Active')
                            ->with([
                                'bCategory:id,categoryName',
                                'user:id,email,contactNo'
                            ]);
                    },
                    'city:id,cityName'
                ])->findOrFail($id);


                $circle->totalBusinessAmount = 0;

                foreach ($circle->members as $member) {
                    $member->businessAmount = 0;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
                }

                foreach ($businessMeetings as $meeting) {
                    $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
                    if ($businessGiverCircleId == $circle->id) {
                        $circle->totalBusinessAmount += $meeting->amount;

                        foreach ($circle->members as $member) {
                            if ($member->userId == $meeting->loginMemberId) {
                                $member->businessAmount += $meeting->amount;
                            }
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    'circle' => $circle,
                ]);
            }


            $circles = Circle::where('status', 'Active')
                ->with([
                    'members' => function ($query) {
                        $query->where('status', 'Active')
                            ->with([
                                'bCategory:id,categoryName',
                                'user:id,email,contactNo'
                            ]);
                    },
                    'city:id,cityName'
                ])
                ->withCount(['members' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->get();


            foreach ($circles as $circle) {
                $circle->totalBusinessAmount = 0;

                foreach ($circle->members as $member) {
                    $member->businessAmount = 0;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
                }

                foreach ($businessMeetings as $meeting) {
                    $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
                    if ($businessGiverCircleId == $circle->id) {
                        $circle->totalBusinessAmount += $meeting->amount;

                        foreach ($circle->members as $member) {
                            if ($member->id == $meeting->loginMemberId) {
                                $member->businessAmount += $meeting->amount;
                            }
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'circles' => $circles,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            Log::error('Error in getCircleMembers', ['message' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'error' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }


    // public function getCircleMembers(Request $request, $id = null)
    // {
    //     try {
    //         // Step 1: Get all active business meetings & filter loginMember with Active status
    //         $businessMeetings = CircleMeetingMembersBusiness::with('member')
    //             ->where('status', 'Active')
    //             ->get()
    //             ->filter(function ($meeting) {
    //                 $loginMember = Member::where('userId', $meeting->loginMemberId)
    //                     ->where('status', 'Active')
    //                     ->first();
    //                 return $loginMember !== null;
    //             });

    //         // Step 2: If specific circle ID provided
    //         if ($id) {
    //             $circle = Circle::with([
    //                 'members' => function ($query) {
    //                     $query->where('status', 'Active')
    //                         ->with([
    //                             'bCategory:id,categoryName',
    //                             'user:id,email,contactNo'
    //                         ]);
    //                 },
    //                 'city:id,cityName'
    //             ])->findOrFail($id);

    //             $circle->totalBusinessAmount = 0;

    //             foreach ($circle->members as $member) {
    //                 $member->businessAmount = 0;
    //                 $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
    //             }

    //             foreach ($businessMeetings as $meeting) {
    //                 $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //                 if ($businessGiverCircleId == $circle->id) {
    //                     $circle->totalBusinessAmount += $meeting->amount;

    //                     foreach ($circle->members as $member) {
    //                         if ($member->userId == $meeting->loginMemberId) {
    //                             $member->businessAmount += $meeting->amount;
    //                         }
    //                     }
    //                 }
    //             }

    //             return response()->json([
    //                 'success' => true,
    //                 'circle' => $circle,
    //             ]);
    //         }

    //         // Step 3: If no specific circle, get all active circles
    //         $circles = Circle::where('status', 'Active')
    //             ->with([
    //                 'members' => function ($query) {
    //                     $query->where('status', 'Active')
    //                         ->with([
    //                             'bCategory:id,categoryName',
    //                             'user:id,email,contactNo'
    //                         ]);
    //                 },
    //                 'city:id,cityName'
    //             ])
    //             ->withCount(['members' => function ($query) {
    //                 $query->where('status', 'Active');
    //             }])
    //             ->get();

    //         foreach ($circles as $circle) {
    //             $circle->totalBusinessAmount = 0;

    //             foreach ($circle->members as $member) {
    //                 $member->businessAmount = 0;
    //                 $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
    //             }

    //             foreach ($businessMeetings as $meeting) {
    //                 $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //                 if ($businessGiverCircleId == $circle->id) {
    //                     $circle->totalBusinessAmount += $meeting->amount;

    //                     foreach ($circle->members as $member) {
    //                         if ($member->userId == $meeting->loginMemberId) {
    //                             $member->businessAmount += $meeting->amount;
    //                         }
    //                     }
    //                 }
    //             }
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'circles' => $circles,
    //         ]);
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         Log::error('Error in getCircleMembers', ['message' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);
    //         return response()->json([
    //             'success' => false,
    //             'error' => 'An error occurred. Please try again later.',
    //         ], 500);
    //     }
    // }




    // public function getCategoryMembers($id = null)
    // {
    //     try {
    //         // If ID is provided, show details for the specific category and its active members
    //         if ($id) {
    //             // Fetch category details
    //             $category = BusinessCategory::where('id', $id)
    //                 ->where('status', 'Active')
    //                 ->firstOrFail();

    //             // Fetch active members related to this category
    //             $members = Member::where('businessCategoryId', $id)
    //                 ->where('status', 'Active')
    //                 ->with(['circle' => function ($query) {
    //                     $query->select('id', 'circleName', 'cityId')
    //                         ->with(['city' => function ($query) {
    //                             $query->select('id', 'cityName');
    //                         }]);
    //                 }])
    //                 ->get();

    //             // Return the category and its members as JSON
    //             return response()->json([
    //                 'category' => $category,
    //                 'members' => $members,
    //             ]);
    //         }

    //         // If no ID is provided, return the list of categories with active members
    //         $categories = BusinessCategory::where('status', 'Active')
    //             ->whereHas('members', function ($query) {
    //                 $query->where('status', 'Active'); // Only consider active members
    //             })
    //             ->withCount(['members' => function ($query) {
    //                 $query->where('status', 'Active'); // Count only active members
    //             }])
    //             ->with(['members' => function ($query) {
    //                 $query->where('status', 'Active'); // Load only active members
    //             }])
    //             ->get();

    //         // Return the list of categories with member count and members as JSON
    //         return response()->json([
    //             'categories' => $categories,
    //         ]);
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json([
    //             'error' => 'An error occurred. Please try again later.',
    //         ], 500);
    //     }
    // }


    public function getCategoryMembers($id = null)
    {
        try {
            $businessMeetings = CircleMeetingMembersBusiness::with('member')->where('status', 'Active')->get();

            if ($id) {
                // Fetch category details
                $category = BusinessCategory::where('id', $id)
                    ->where('status', 'Active')
                    ->firstOrFail();

                // Fetch active members of this category
                $members = Member::where('businessCategoryId', $id)
                    ->where('status', 'Active')
                    ->with([
                        'circle:id,circleName',
                        'user:id,email,contactNo,firstName,lastName',
                        'bCategory:id,categoryName',
                    ])
                    ->get();

                // Initialize total business amount
                $totalBusinessAmount = 0;

                foreach ($members as $member) {
                    // Set default values
                    $member->businessAmount = 0;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count();

                    // Calculate business amount
                    foreach ($businessMeetings as $meeting) {
                        if ($meeting->member->id === $member->id) {
                            $member->businessAmount += $meeting->amount;
                            $totalBusinessAmount += $meeting->amount;
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    'members' => $members,
                ]);
            }

            // Fetch all categories with their active members
            $categories = BusinessCategory::where('status', 'Active')
                ->whereHas('members', function ($query) {
                    $query->where('status', 'Active');
                })
                ->withCount(['members' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->with(['members' => function ($query) {
                    $query->where('status', 'Active')
                        ->with([
                            'circle:id,circleName',
                            'user:id,email,contactNo,firstName,lastName'
                        ]);
                }])
                ->get();

            foreach ($categories as $category) {
                $category->totalBusinessAmount = 0;

                foreach ($category->members as $member) {
                    $member->businessAmount = 0;
                    $member->induction_count = Member::where('sponsoredBy', $member->id)->count();

                    foreach ($businessMeetings as $meeting) {
                        if ($meeting->member->id === $member->id) {
                            $member->businessAmount += $meeting->amount;
                            $category->totalBusinessAmount += $meeting->amount;
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'categories' => $categories,
            ]);
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred. Please try again later.',
            ], 500);
        }
    }
}
