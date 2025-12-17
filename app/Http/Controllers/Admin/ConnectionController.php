<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use App\Models\Connection;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\Circle;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\City;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{

    public function __construct()
    {
        // Apply middleware for connection-related permissions
        $this->middleware('permission:connection-connect', ['only' => ['connect']]);
        $this->middleware('permission:connection-requests', ['only' => ['connectionRequests']]);
        $this->middleware('permission:connection-view', ['only' => ['myConnections']]);
        $this->middleware('permission:connection-accept', ['only' => ['accept']]);
        $this->middleware('permission:connection-reject', ['only' => ['reject']]);
        $this->middleware('permission:connection-remove', ['only' => ['removeConnection']]);
    }

    // public function circleList()
    // {
    //     try {
    //         // Fetch circles with member counts
    //         $circles = Circle::where('status', 'Active')
    //             ->with(['city' => function ($query) {
    //                 $query->select('id', 'cityName');
    //             }])
    //             ->withCount(['members' => function ($query) {
    //                 $query->where('status', 'Active'); // Count only active members if needed
    //             }])
    //             ->get();

    //         return view('admin.connection.circleList', compact('circles'));
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError(
    //             $th,
    //             request()->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }


    public function circleList(Request $request)
    {
        try {

            $authId = Auth::id();
            $authMember = Member::where('userId', $authId)->first();
            $authCircleId = $authMember ? $authMember->circleId : null;

           $authCircle = $authCircleId
    ? Circle::where('status', 'Active')
        ->withCount('members')
        ->with('city')
        ->find($authCircleId)
    : null;


            // $businessMeetings = CircleMeetingMembersBusiness::with('member')
            //     ->where('status', 'Active')
            //     ->get();



            $circles = Circle::where('status', 'Active')
                ->orderBy('circleName', 'asc')
                ->with('city:id,cityName')
                ->withCount(['members' => fn($q) => $q->where('status', 'Active')])
                ->get();

            $businessMeetings = CircleMeetingMembersBusiness::with('member')
                ->where('status', 'Active')
                ->get();

            $circles->each(function ($circle) use ($businessMeetings) {
                $filtered = $businessMeetings->filter(
                    fn($m) =>
                    Member::where('userId', $m->businessGiverId)->value('circleId') == $circle->id
                );
                $circle->totalBusinessAmount = $filtered->sum('amount');
            });

            // Calculate business amount
            if ($authCircle) {
                $filtered = $businessMeetings->filter(function ($m) use ($authCircle) {
                    $circleId = Member::where('userId', $m->businessGiverId)->value('circleId');
                    return $circleId == $authCircle->id;
                });

                $authCircle->totalBusinessAmount = $filtered->sum('amount');
            }

            $defaultCircle = $circles->first(); // first circle to show members initially
            $members = $defaultCircle
                ? Circle::with(['members' => function ($q) {
                    $q->where('status', 'Active');
                }])->find($defaultCircle->id)->members
                : collect();

            return view('admin.connection.circleList', compact('circles', 'members', 'defaultCircle', 'authCircle', 'authCircleId'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function cityList(Request $request)
    {
        try {
            // ✅ Get all city IDs from members and circles
            $memberCityIds = Member::whereNotNull('cityId')->pluck('cityId')->toArray();
            $circleCityIds = Circle::whereNotNull('cityId')->pluck('cityId')->toArray();

            // ✅ Merge and get unique city IDs
            $allCityIds = array_unique(array_merge($memberCityIds, $circleCityIds));

            // ✅ Get only those active cities
            $cities = City::where('status', 'Active')
                ->whereIn('id', $allCityIds)
                ->orderBy('cityName', 'asc')
                ->get();

            $members = Member::where('status', 'Active')
                ->where('circleId', null)
                ->get();


            return view('admin.connection.cityList', compact('cities', 'members'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    // public function cityList(Request $request)
    // {
    //     try {

    //         $cities = City::where('status', 'Active')
    //             ->orderBy('cityName', 'asc')
    //             ->get();

    //         $members = Member::where('status', 'Active')
    //             ->where('circleId', null)
    //             ->get();


    //         return view('admin.connection.cityList', compact('cities', 'members'));
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return view('servererror');
    //     }
    // }


    public function getCityMembers($cityId)
    {
        try {
            $members = Member::where('cityId', $cityId)
                ->where('circleId', null)
                ->where('status', 'Active')
                ->get();

            return view('admin.connection.digitalmember.member-cards', compact('members'))->render();
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    // public function getMembers($circleId)
    // {
    //     $circle = Circle::with(['members.user', 'members.bCategory'])->find($circleId);

    //     if (!$circle) {
    //         return response()->json(['error' => 'Circle not found'], 404);
    //     }

    //     return view('partials.member-cards', ['members' => $circle->members, 'circleName' => $circle->circleName]);
    // }


    public function getMembers($circleId)
    {
        $circle = Circle::with(['members.user', 'members.bCategory'])->find($circleId);

        if (!$circle) {
            return response()->json(['error' => 'Circle not found'], 404);
        }

        $authId = Auth::id();
        $authMember = Member::where('userId', $authId)->first();
        $authCircleId = $authMember ? $authMember->circleId : null;

        $members = $circle->members;

        $members->each(function ($member) use ($authId, $authCircleId) {
            // Check if the member is in the same circle
            if ($authCircleId !== null && $member->circleId == $authCircleId) {
                $member->connection_status = 'Connected';
            } else {
                // Fetch actual connection status
                $connection = Connection::where(function ($query) use ($authId, $member) {
                    $query->where('userId', $authId)->where('memberId', $member->userId)
                        ->orWhere(function ($query) use ($authId, $member) {
                            $query->where('userId', $member->userId)->where('memberId', $authId);
                        });
                })->first();

                $member->connection_status = $connection ? $connection->status : 'Not Connected';
            }

            // If connection exists and is 'Accepted', always mark as 'Connected'
            if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
                $member->connection_status = 'Connected';
            }
        });

        // 🔄 Add induction count
        $members->map(function ($member) {
            $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
            return $member;
        });

        return view('partials.member-cards', [
            'members' => $circle->members,
            'circleName' => $circle->circleName,
            'authCircleId' => $authCircleId, // ✅ pass this to the view
            'success' => 'Request Sent Successfully!'
        ]);
    }


    // public function circleList()
    // {
    //     try {
    //         // Fetch circles with member counts and total business amounts
    //         $circles = Circle::where('status', 'Active')
    //             ->with(['city' => function ($query) {
    //                 $query->select('id', 'cityName');
    //             }])
    //             ->withCount(['members' => function ($query) {
    //                 $query->where('status', 'Active'); // Count only active members if needed
    //             }])
    //             ->get();

    //         // Fetch business meetings
    //         $businessMeetings = CircleMeetingMembersBusiness::with(['member'])
    //             ->where('status', 'Active')
    //             ->get();

    //         // Add total business amount to each circle
    //         $circles->each(function ($circle) use ($businessMeetings) {
    //             $filteredBusinessMeetings = $businessMeetings->filter(function ($meeting) use ($circle) {
    //                 $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //                 return $businessGiverCircleId == $circle->id;
    //             });

    //             // Calculate and add the total business amount
    //             $circle->totalBusinessAmount = $filteredBusinessMeetings->sum('amount');
    //         });

    //         return view('admin.connection.circleList', compact('circles'));
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError(
    //             $th,
    //             request()->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }


    // public function showMembers($id)
    // {
    //     try {
    //         $circle = Circle::with(['members' => function ($query) {
    //             $query->where('status', 'Active'); // Fetch only active members
    //         }])->findOrFail($id);

    //         $members = $circle->members;

    //         $authId = Auth::id(); // Get authenticated user ID

    //         // Fetch the authenticated user's circle ID from the Members table
    //         $authMember = Member::where('userId', $authId)->first();
    //         $authCircleId = $authMember ? $authMember->circleId : null;

    //         $members->each(function ($member) use ($authId, $authCircleId) {
    //             // Check if the member is in the same circle
    //             if ($authCircleId !== null && $member->circleId == $authCircleId) {
    //                 $member->connection_status = 'Connected';
    //             } else {
    //                 // Fetch actual connection status
    //                 $connection = Connection::where(function ($query) use ($authId, $member) {
    //                     $query->where('userId', $authId)->where('memberId', $member->userId)
    //                         ->orWhere(function ($query) use ($authId, $member) {
    //                             $query->where('userId', $member->userId)->where('memberId', $authId);
    //                         });
    //                 })->first();

    //                 $member->connection_status = $connection ? $connection->status : 'Not Connected';
    //             }

    //             // If connection exists and is 'Accepted', always mark as 'Connected'
    //             if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
    //                 $member->connection_status = 'Connected';
    //             }
    //         });

    //         return view('admin.connection.circleWiseMembers', compact('circle', 'members', 'authCircleId'));
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError(
    //             $th,
    //             request()->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }



    // public function categoryList()
    // {
    //     try {
    //         $category = BusinessCategory::where('status', 'Active')->paginate(20);
    //         return view('admin.connection.categoryList', compact('category'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             request()->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }

    public function categoryList()
    {
        try {
            // Fetch categories that have members in the members table
            $categories = BusinessCategory::where('status', 'Active')
                ->orderBy('categoryName', 'asc')
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

            return view('admin.connection.categoryList', compact('categories'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function categoryListForDigitalMember()
    {
        try {
            $categories = BusinessCategory::where('status', 'Active')
                ->orderBy('categoryName', 'asc')
                ->whereHas('members', function ($query) {
                    $query->where('status', 'Active');
                })
                ->withCount(['members' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->with(['members' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->get();

            return view('admin.connection.digitalmember.categoryList', compact('categories'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    // public function showCategoryWiseMembers($id)
    // {
    //     try {
    //         $authId = Auth::id(); // Get authenticated user ID

    //         // Fetch the authenticated user's circle ID from the Members table
    //         $authMember = Member::where('userId', $authId)->first();
    //         $authCircleId = $authMember ? $authMember->circleId : null;

    //         // Fetch category details
    //         $category = BusinessCategory::where('id', $id)->where('status', 'Active')->firstOrFail();

    //         // Fetch active members related to this category
    //         $members = Member::where('businessCategoryId', $id)
    //             ->where('status', 'Active')
    //             ->get();

    //         $members->each(function ($member) use ($authId, $authCircleId) {
    //             // Check if the member is in the same circle
    //             if ($authCircleId !== null && $member->circleId == $authCircleId) {
    //                 $member->connection_status = 'Connected';
    //             } else {
    //                 // Fetch actual connection status
    //                 $connection = Connection::where(function ($query) use ($authId, $member) {
    //                     $query->where('userId', $authId)->where('memberId', $member->userId)
    //                         ->orWhere(function ($query) use ($authId, $member) {
    //                             $query->where('userId', $member->userId)->where('memberId', $authId);
    //                         });
    //                 })->first();

    //                 $member->connection_status = $connection ? $connection->status : 'Not Connected';
    //             }

    //             // If connection exists and is 'Accepted', always mark as 'Connected'
    //             if ($member->connection_status !== 'Connected' && isset($connection) && $connection->status === 'Accepted') {
    //                 $member->connection_status = 'Connected';
    //             }
    //         });

    //         return view('admin.connection.categoryWiseMembers', compact('category', 'members', 'authCircleId'));
    //     } catch (\Throwable $th) {
    //         // Log the error
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return view('servererror');
    //     }
    // }


    // public function categoryMembers($categoryId)
    // {
    //     try {
    //         $authId = Auth::id();
    //         $authMember = Member::where('userId', $authId)->first();
    //         $authCircleId = $authMember ? $authMember->circleId : null;

    //         $category = BusinessCategory::with(['members' => function ($query) {
    //             $query->where('status', 'Active');
    //         }])->find($categoryId);

    //         if (!$category) {
    //             return response()->json(['message' => 'Category not found.'], 404);
    //         }

    //         foreach ($category->members as $member) {
    //             if ($authCircleId !== null && $member->circleId == $authCircleId) {
    //                 $member->connection_status = 'Connected';
    //             } else {
    //                 $connection = Connection::where(function ($query) use ($authId, $member) {
    //                     $query->where('userId', $authId)->where('memberId', $member->userId)
    //                         ->orWhere(function ($query) use ($authId, $member) {
    //                             $query->where('userId', $member->userId)->where('memberId', $authId);
    //                         });
    //                 })->first();

    //                 $member->connection_status = $connection ? $connection->status : 'Not Connected';

    //                 if ($connection && $connection->status === 'Accepted') {
    //                     $member->connection_status = 'Connected';
    //                 }
    //             }
    //         }

    //         return view('partials.member-cards', ['members' => $category->members], compact('authCircleId'));
    //     } catch (\Throwable $th) {
    //         ErrorLogger::logError($th, request()->fullUrl());
    //         return response()->json(['message' => 'Server error'], 500);
    //     }
    // }


//     public function categoryMembers($categoryId)
// {
//     try {
//         $authId = Auth::id();
//         $authMember = Member::where('userId', $authId)
//             ->where('status', 'Active')
//             ->first();

//         $authCircleId = $authMember ? $authMember->circleId : null;

//         $category = BusinessCategory::with([
//             'members' => function ($query) {
//                 $query->where('status', 'Active')
//                       ->whereHas('user', function ($q) {
//                           $q->where('status', 'Active');
//                       });
//             }
//         ])->find($categoryId);

//         if (!$category) {
//             return response()->json(['message' => 'Category not found.'], 404);
//         }

//         foreach ($category->members as $member) {
//             if ($authCircleId !== null && $member->circleId == $authCircleId) {
//                 $member->connection_status = 'Connected';
//             } else {
//                 $connection = Connection::where(function ($query) use ($authId, $member) {
//                     $query->where('userId', $authId)
//                           ->where('memberId', $member->userId)
//                           ->orWhere(function ($query) use ($authId, $member) {
//                               $query->where('userId', $member->userId)
//                                     ->where('memberId', $authId);
//                           });
//                 })->first();

//                 $member->connection_status = ($connection && $connection->status === 'Accepted')
//                     ? 'Connected'
//                     : ($connection->status ?? 'Not Connected');
//             }
//         }

//         return view('partials.member-cards', ['members' => $category->members], compact('authCircleId'));
//     } catch (\Throwable $th) {
//         ErrorLogger::logError($th, request()->fullUrl());
//         return response()->json(['message' => 'Server error'], 500);
//     }
// }


// public function categoryMembers($categoryId)
// {
//     try {
//         $authId = Auth::id();

//         $authMember = Member::where('userId', $authId)
//             ->where('status', 'Active')
//             ->first();

//         $authCircleId = $authMember ? $authMember->circleId : null;

//         $category = BusinessCategory::with([
//             'members' => function ($query) {
//                 $query->where('status', 'Active')
//                       ->whereHas('user', function ($q) {
//                           $q->where('status', 'Active');
//                       });
//             }
//         ])->find($categoryId);

//         if (!$category) {
//             return response()->json(['message' => 'Category not found.'], 404);
//         }

//         foreach ($category->members as $member) {

//             $connection = Connection::where(function ($query) use ($authId, $member) {
//                 $query->where('userId', $authId)
//                       ->where('memberId', $member->userId)
//                       ->orWhere(function ($query) use ($authId, $member) {
//                           $query->where('userId', $member->userId)
//                                 ->where('memberId', $authId);
//                       });
//             })->first();

//             $member->connection_status =
//                 ($connection && $connection->status === 'Accepted')
//                 ? 'Connected'
//                 : ($connection->status ?? 'Not Connected');
//         }

//         return view('partials.member-cards', [
//             'members' => $category->members
//         ], compact('authCircleId'));

//     } catch (\Throwable $th) {
//         ErrorLogger::logError($th, request()->fullUrl());
//         return response()->json(['message' => 'Server error'], 500);
//     }
// }


    public function categoryMembers($categoryId)
    {
        try {
            $authId = Auth::id();
            $authMember = Member::where('userId', $authId)->first();
            $authCircleId = $authMember ? $authMember->circleId : null;

            $category = BusinessCategory::with([
                'members' => function ($query) use ($authId) {
                    $query->where('status', 'Active')
                          ->where('userId', '!=', $authId)
                          ->whereHas('user', function ($q) {
                              $q->where('status', 'Active');
                          })
                          ->with(['user', 'bCategory', 'circle']);
                }
            ])->find($categoryId);

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }

        foreach ($category->members as $member) {

            $connection = Connection::where(function ($query) use ($authId, $member) {
                $query->where('userId', $authId)
                      ->where('memberId', $member->userId)
                      ->orWhere(function ($query) use ($authId, $member) {
                          $query->where('userId', $member->userId)
                                ->where('memberId', $authId);
                      });
            })->first();

            if ($member->circleId !== null && $authCircleId !== null && $member->circleId == $authCircleId) {
                $member->connection_status = 'Connected';
            } elseif ($member->circleId !== null && $connection && $connection->status === 'Accepted') {
                $member->connection_status = 'Connected';
            } else {
                $member->connection_status = $connection ? $connection->status : 'Not Connected';
            }
        }

            return view('partials.member-cards', [
                'members' => $category->members,
                'authCircleId' => $authCircleId,
            ]);

        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return response()->json(['message' => 'Server error'], 500);
        }
    }







    public function connect(Request $request)
    {
        $member = Member::find($request->input('memberId'));
        $memberId = $member->userId;
        $userId = Auth::user()->id;

        // $connection = Connection::where('memberId', $memberId)
        //     ->orWhere('userId', $userId)
        //     ->first();

        //     if ($connection) {

        //         return response()->json(['message' => 'You are already sent']);
        //     }

        $connection = new Connection();
        $connection->memberId = $memberId;
        $connection->userId = $userId;
        $connection->save();

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Connection request sent successfully!'
        ]);
    }

    public function connectionRequests()
    {
        try {
            // Get the authenticated user's ID
            $userId = Auth::user()->id;

            // Query to get connection requests
            $connections = Connection::whereHas('member', function ($query) use ($userId) {
                $query->where('memberId', $userId);
            })
                ->with('member')
                ->where('status', 'Pending')
                ->paginate(10);

            // Return the view with the connections data
            return view('admin.connection.connections', compact('connections'));
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a custom error view or redirect with an error message
            return view('servererror');
        }
    }

    public function sentConnectionRequests()
    {
        try {
            // Get the authenticated user's ID
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
                ->paginate(10);

            // Return the view with the connections data
            return view('admin.connection.sentConnectionRequests', compact('connections'));
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a custom error view or redirect with an error message
            return view('servererror');
        }
    }




    // public function myConnections()
    // {
    //     $userId = Auth::id();

    //     // Fetch connections where the authenticated user is either the userId or memberId
    //     $connections = Connection::where(function ($query) use ($userId) {
    //         $query->where('userId', $userId)
    //             ->orWhere('memberId', $userId);
    //     })
    //         ->where('status', 'Accepted')
    //         ->with(['user:id,firstName,lastName,email'])
    //         ->paginate(10);

    //     // Include connected user's details for convenience
    //     $connections->each(function ($connection) {
    //         $connection->connectedUser = $connection->connected_user;
    //     });

    //     return view('admin.connection.myConnection', compact('connections'));
    // }
    // public function myConnections()
    // {
    //     try {
    //         $userId = Auth::id();

    //         // Fetch connections where the authenticated user is either the userId or memberId
    //         $connections = Connection::where(function ($query) use ($userId) {
    //             $query->where('userId', $userId)
    //                 ->orWhere('memberId', $userId);
    //         })
    //             ->where('status', 'Accepted')
    //             ->with(['user:id,firstName,lastName,email'])
    //             ->paginate(10);

    //         // Include connected user's details for convenience
    //         $connections->each(function ($connection) {
    //             $connection->connectedUser = $connection->connected_user;
    //         });

    //         // Fetch circleId from member table based on the userId
    //         $circleId = Member::where('userId', $userId)->pluck('circleId')->first();

    //         // Fetch all members with the same circleId
    //         $myConnections = Member::where('circleId', $circleId)->where('userId', '!=', $userId)->paginate(10);

    //         return view('admin.connection.myConnection', compact('connections', 'myConnections'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         // Log the error using the ErrorLogger utility
    //         ErrorLogger::logError($th, request()->fullUrl());

    //         return view('servererror');
    //     }
    // }

    public function myConnectionsOld()
    {
        try {
            $userId = Auth::id();


            // Fetch connections where the authenticated user is either the userId or memberId
            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)
                    ->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                ->with(['user:id,firstName,lastName,email'])
                ->get();

            // Include connected user's details for convenience
            $connections->each(function ($connection) {
                $connection->connectedUser = $connection->connected_user;
            });

            // Fetch circleId from member table based on the userId
            $circleId = Member::where('userId', $userId)->pluck('circleId')->first();

            // Fetch all members with the same circleId
            $myConnections = Member::where('circleId', $circleId)->where('userId', '!=', $userId)->paginate(10);

            return view('admin.connection.myConnection', compact('connections', 'myConnections'));
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }


    public function myConnections()
    {
        try {
            $userId = Auth::id();

            // My Connections
            $connections = Connection::where(function ($query) use ($userId) {
                $query->where('userId', $userId)->orWhere('memberId', $userId);
            })
                ->where('status', 'Accepted')
                ->with([
                    'user:id,firstName,lastName,email,contactNo',
                    'receiver:id,firstName,lastName,email,contactNo',
                    'members:id,userId,profilePhoto,circleId,companyName,companyLogo,keyWords,businessCategoryId',
                    'member:id,userId,profilePhoto,circleId,companyName,companyLogo,keyWords,businessCategoryId'
                ])
                ->get();

            $connections->each(function ($connection) {
                $connection->connectedUser = $connection->connected_user;
                $connection->connectedMember = $connection->connected_member;
            });

            // Sent Requests
            $sentRequests = Connection::where('userId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'receiver' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName', 'contactNo');
                    },
                    'receiverMember' => function ($query) {
                        $query->select('userId', 'id', 'profilePhoto', 'circleId', 'companyName', 'companyLogo', 'keyWords', 'businessCategoryId');
                    }
                ])
                ->get();

            // Received Requests
            $receivedRequests = Connection::where('memberId', $userId)
                ->where('status', 'Pending')
                ->with([
                    'user' => function ($query) {
                        $query->select('id', 'email', 'firstName', 'lastName', 'contactNo');
                    },
                    'members' => function ($query) {
                        $query->select('id', 'userId', 'profilePhoto', 'circleId', 'companyName', 'companyLogo', 'keyWords', 'businessCategoryId');
                    }
                ])
                ->get();

            return view('admin.connection.myConnection', compact(
                'connections',
                'sentRequests',
                'receivedRequests'
            ));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function myCircleConnections()
    {
        try {
            $userId = Auth::id();

            // Fetch circleId from member table based on the userId
            $circleId = Member::where('userId', $userId)->pluck('circleId')->first();

            // Fetch all members with the same circleId
            $myConnections = Member::where('circleId', $circleId)->where('userId', '!=', $userId)->paginate(10);

            // Add induction_count to each member
            $myConnections->getCollection()->transform(function ($member) {
                $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
                return $member;
            });

            return view('admin.connection.myCircleConnection', compact('myConnections'));
        } catch (\Throwable $th) {
            // throw $th;
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }




    public function accept($id)
    {
        try {
            $connection = Connection::findOrFail($id);

            $connection->status = "Accepted";
            $connection->save();

            return redirect()->route('connection.myConnections')
                ->with('success', 'Accepted Successfully');
        } catch (\Throwable $th) {
            // throw $th;

            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('connection.myConnections')
                ->with('error', 'Failed to accept connection.');
        }
    }

    public function reject($id)
    {
        try {
            $connection = Connection::findOrFail($id);

            $connection->delete();

            return redirect()->route('connection.myConnections')
                ->with('success', 'Rejected Successfully');
        } catch (\Throwable $th) {
            // throw $th;

            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('connection.myConnections')
                ->with('error', 'Failed to reject connection.');
        }
    }

    public function removeConnection($id)
    {
        try {
            $connection = Connection::findOrFail($id);

            $connection->delete();

            return redirect()->route('connection.myConnections')
                ->with('success', 'Connection Removed Successfully');
        } catch (\Throwable $th) {
            // throw $th;

            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('connection.myConnections')
                ->with('error', 'Failed to remove connection.');
        }
    }
}
