<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\BusinessCategory;
use App\Models\Circle;
use App\Models\CircleCall;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Models\City;
use App\Models\Connection;
use App\Models\ContactDetails;
use App\Models\Help;
use App\Models\MeetingInvitation;
use App\Models\Member;
use App\Models\ResourceCategory;
use App\Models\Schedule;
use App\Models\TopsProfile;
use App\Models\Training;
use App\Models\User;
use App\Models\VisitorsDetails;
use App\Utils\Utils;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    // public function login(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'email' => 'required|email',
    //             'password' => 'required',
    //         ]);

    //         if ($validator->fails()) {
    //             return Utils::sendResponse(['errors' => $validator->errors()], 'Invalid Input', 422);
    //         }

    //         $user = User::where('email', $request->email)->first();

    //         if (!$user || $user->status === 'deleted') {
    //             return Utils::errorResponses(['error' => 'Account Disabled'], 'Your account has been deleted. Please contact support for assistance.', 403);
    //         }

    //         if (Auth::attempt($request->only('email', 'password'))) {
    //             $user = Auth::user();
    //             $token = $user->createToken('authToken')->plainTextToken;

    //             return Utils::sendResponse(['token' => $token, 'user' => $user], 'Success', 200);
    //         }

    //         return Utils::errorResponses(['error' => 'Unauthorized Access'], 'Email or Password does not match with our records', 401);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponses(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return Utils::sendResponse(['errors' => $validator->errors()], 'Invalid Input', 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return Utils::errorResponses(['error' => 'Account Not Found'], 'Invalid email address. Please enter the correct email');
            }

            if ($user->status === 'deleted') {
                return Utils::errorResponses(['error' => 'Account Deleted'], 'Your account has been deleted.');
            }

            $userPassword = $user->password;
            if (! Hash::check($request->password, $userPassword)) {
                return Utils::errorResponses(['error' => 'Unauthorized Access'], 'Incorrect password. Please try again.');
            }


            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                $roles = Auth::user()->getRoleNames();
                $token = $user->createToken('authToken')->plainTextToken;

                return Utils::sendResponse(['token' => $token, 'user' => $user, 'roles' => $roles], 'Success', 200);
            }

            return Utils::errorResponses(['error' => 'Unauthorized Access'], 'Email or Password does not match with our records', 401);
        } catch (\Throwable $th) {
            return Utils::errorResponses(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function induction($id)
    {
        try {

            $memberInduction = Member::where('sponsoredBy', $id)->count();
            if (! $memberInduction) {
                return Utils::errorResponses(['error' => 'Member not found'], 'Not Found', 404);
            }

            return Utils::sendResponse(['count' => $memberInduction], 'Success', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponses(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function homeCounts()
    // {
    //     try {
    //         $membersCount = Member::where('status', 'Active')->count();
    //         $circleCount = Circle::where('status', 'Active')->count();
    //         $cityCount = Circle::where('status', 'Active')
    //             ->select('cityId')
    //             ->distinct()
    //             ->count('cityId');

    //         return Utils::sendResponse(['membersCount' => $membersCount, 'circleCount' => $circleCount, 'cityCount' => $cityCount], 'Success', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponses(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function homeCounts()
    {
        try {
            $membersCount = Member::where('status', 'Active')->count();
            $circleCount = Circle::where('status', 'Active')->count();

            // ✅ Same city count logic (Members + Circles)
            $memberCities = Member::where('status', 'Active')
                ->whereNotNull('cityId')
                ->distinct()
                ->pluck('cityId')
                ->toArray();

            $circleCities = Circle::where('status', 'Active')
                ->whereNotNull('cityId')
                ->distinct()
                ->pluck('cityId')
                ->toArray();

            $cityCount = count(array_unique(array_merge($memberCities, $circleCities)));

            return Utils::sendResponse([
                'membersCount' => $membersCount,
                'circleCount' => $circleCount,
                'cityCount' => $cityCount,
            ], 'Success', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponses(
                ['error' => $th->getMessage()],
                'Internal Server Error',
                500
            );
        }
    }

    public function membersActivityCount(Request $request, $id)
    {
        try {
            $member = Member::where('userId', $id)->get();

            if (! $member) {
                return Utils::errorResponses(['error' => 'Member not found'], 'Not Found', 404);
            }

            // Get the count of each activity
            $totalMeetingCount = CircleCall::where('memberId', $id)->where('status', 'Active')->count();
            $refReceivedCount = CircleMeetingMembersReference::where('memberId', $id)->where('status', 'Active')->count();
            $busTakenCount = CircleMeetingMembersBusiness::where('loginMemberId', $id)->where('status', 'Active')->count();
            $busTaken = CircleMeetingMembersBusiness::where('loginMemberId', $id)->where('status', 'Active')->get();
            // $busTakenCount = $busTaken->count();
            $busTakenAmount = $busTaken->sum('amount');

            // get the another count (viceVersa)
            $busGiverCount = CircleMeetingMembersBusiness::where('businessGiverId', $id)->where('status', 'Active')->count();
            $refGiverCount = CircleMeetingMembersReference::where('referenceGiverId', $id)->where('status', 'Active')->count();

            return Utils::sendResponse([
                'totalMeetingCount' => $totalMeetingCount,
                'refReceivedCount' => $refReceivedCount,
                'busTakenCount' => $busTakenCount,
                'businessAmount' => $busTakenAmount,
                'busGiverCount' => $busGiverCount,
                'refGiverCount' => $refGiverCount,
            ], 'Success', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponses(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // lead board
    // public function maxMeetings(Request $request)
    // {
    //     try {
    //         $authUserId = auth()->id();
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $authMember = Member::where('userId', $authUserId)->first();

    //         $circlecalls = CircleCall::with([
    //             'member' => function ($query) {
    //                 $query->select('id', 'userId', 'firstname', 'lastname', 'businessCategoryId', 'circleId', 'profilephoto')
    //                     ->with(['bCategory:id,categoryName', 'circle:id,circleName']);
    //             },
    //             'meetingPerson'
    //         ])
    //             ->where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) use ($authUserId, $authMember) {
    //             $member = $group->first()->member;
    //             $inductionCount = Member::where('sponsoredBy', $member->id)->count();

    //             // Default status
    //             $connectionStatus = 'Not Connected';

    //             // Check if same circle
    //             if ($authMember && $member && $authMember->circleId === $member->circleId) {
    //                 $connectionStatus = 'Connected';
    //             } else {
    //                 // Check connection table
    //                 $connection = Connection::where('memberId', $member->userId)
    //                     ->where('userId', $authUserId)
    //                     ->first();

    //                 if ($connection) {
    //                     $connectionStatus = $connection->status; // 'Pending' or 'Connected'
    //                 }
    //             }

    //             return [
    //                 'member' => [
    //                     'id' => $member->id,
    //                     'userId' => $member->userId,
    //                     'firstName' => $member->firstname,
    //                     'lastName' => $member->lastname,
    //                     'profilePhoto' => $member->profilephoto,
    //                     'businessCategoryId' => $member->businessCategoryId,
    //                     'businessCategory' => $member->bCategory->categoryName ?? null,
    //                     'circleId' => $member->circleId,
    //                     'circle' => $member->circle->circleName ?? null,
    //                     'induction_count' => $inductionCount,
    //                     'connectionStatus' => $connectionStatus,
    //                 ],
    //                 'count' => $group->count()
    //             ];
    //         })->sortByDesc('count')->values();

    //         return Utils::sendResponse(
    //             ['circlecalls' => $circlecalls],
    //             'Meeting data retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function maxMeetings(Request $request)
    {
        try {
            $authUser = auth()->user();
            $authUserId = $authUser->id;

            // Get authenticated member
            $authMember = Member::where('userId', $authUserId)->first();
            if (! $authMember) {
                return response()->json(['message' => 'Member not found'], 404);
            }

            // Get cityId from circle
            $cityId = Circle::where('id', $authMember->circleId)->value('cityId');
            if (! $cityId) {
                return response()->json(['message' => 'City not found'], 404);
            }

            // Get previous month/year
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            // Get all members whose circle belongs to same city
            $circleIdsInCity = Circle::where('cityId', $cityId)->pluck('id')->toArray();

            // Get CircleCalls only for those members
            $circlecalls = CircleCall::with([
                'member' => function ($query) {
                    $query->select('id', 'userId', 'firstname', 'lastname', 'businessCategoryId', 'circleId', 'profilephoto')
                        ->with(['bCategory:id,categoryName', 'circle:id,circleName']);
                },
                'meetingPerson',
            ])
                ->whereHas('member', function ($query) use ($circleIdsInCity) {
                    $query->whereIn('circleId', $circleIdsInCity);
                })
                ->where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            // Group and transform the data
            $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) use ($authUserId, $authMember) {
                $member = $group->first()->member;
                $inductionCount = Member::where('sponsoredBy', $member->id)->count();

                $connectionStatus = 'not_connected';

                $connection = Connection::where(function ($query) use ($authUserId, $member) {
                    $query->where('userId', $authUserId)
                        ->where('memberId', $member->userId);
                })->orWhere(function ($query) use ($authUserId, $member) {
                    $query->where('userId', $member->userId)
                        ->where('memberId', $authUserId);
                })->first();

                if ($connection) {

                    if ($connection->status == 'Accepted') {
                        $connectionStatus = 'connected';
                    } elseif ($connection->status == 'Pending') {

                        if ($connection->userId == $authUserId) {
                            $connectionStatus = 'request_sent';
                        } else {
                            $connectionStatus = 'request_received';
                        }
                    } elseif ($connection->status == 'Rejected') {
                        $connectionStatus = 'not_connected';
                    }
                }

                return [
                    'member' => [
                        'id' => $member->id,
                        'userId' => $member->userId,
                        'firstName' => $member->firstname,
                        'lastName' => $member->lastname,
                        'profilePhoto' => $member->profilephoto,
                        'businessCategoryId' => $member->businessCategoryId,
                        'businessCategory' => $member->bCategory->categoryName ?? null,
                        'businessCategory' => $member->bCategory->categoryName ?? null,
                        'circleId' => $member->circleId,
                        'circle' => $member->circle->circleName ?? null,
                        'induction_count' => $inductionCount,
                        'connectionStatus' => $connectionStatus,
                    ],
                    'count' => $group->count(),
                ];
            })->sortByDesc('count')->values();

            return Utils::sendResponse(
                ['circlecalls' => $circlecalls],
                'Meeting data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function maxBusiness(Request $request)
    // {
    //     try {
    //         $authUserId = auth()->id(); // Get authenticated user ID
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $authMember = Member::where('userId', $authUserId)->first();

    //         $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($authUserId, $authMember) {
    //             $user = $group->first()->users;

    //             if (!$user) {
    //                 return null; // Skip if user not found
    //             }

    //             $member = $user->member()->select('id', 'circleId', 'businessCategoryId', 'profilePhoto', 'userId')->first();

    //             if (!$member) {
    //                 return null; // Skip if member not found
    //             }

    //             $circle = Circle::find($member->circleId);
    //             $businessCategory = BusinessCategory::find($member->businessCategoryId);
    //             $inductionCount = Member::where('sponsoredBy', $member->id)->count();

    //             // Default connection status
    //             $connectionStatus = 'Not Connected';

    //             // If same circle, mark as connected
    //             if ($authMember && $member && $authMember->circleId === $member->circleId) {
    //                 $connectionStatus = 'Connected';
    //             } else {
    //                 // Check connection table
    //                 $connection = Connection::where('memberId', $member->userId)
    //                     ->where('userId', $authUserId)
    //                     ->first();

    //                 if ($connection) {
    //                     $connectionStatus = $connection->status; // 'Pending' or 'Connected'
    //                 }
    //             }

    //             return [
    //                 'user' => [
    //                     'id' => $user->id,
    //                     'firstName' => $user->firstName,
    //                     'lastName' => $user->lastName,
    //                     'email' => $user->email,
    //                 ],
    //                 'member' => [
    //                     'id' => $member->id,
    //                     'profilePhoto' => $member->profilePhoto,
    //                     'induction_count' => $inductionCount,
    //                     'connectionStatus' => $connectionStatus,
    //                 ],
    //                 'amount' => $group->sum('amount'),
    //                 'count' => $group->count(),
    //                 'circle' => $circle ? [
    //                     'id' => $circle->id,
    //                     'circleName' => $circle->circleName
    //                 ] : null,
    //                 'businessCategory' => $businessCategory ? [
    //                     'id' => $businessCategory->id,
    //                     'categoryName' => $businessCategory->categoryName
    //                 ] : null
    //             ];
    //         })
    //             ->filter()
    //             ->sortByDesc('amount')
    //             ->values();

    //         return Utils::sendResponse(
    //             ['busGiver' => $busGiver],
    //             'Business data retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function maxBusiness(Request $request)
    {
        try {
            $authUserId = auth()->id();
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $authMember = Member::where('userId', $authUserId)->first();

            if (! $authMember) {
                return response()->json(['message' => 'Authenticated member not found'], 404);
            }

            // Get cityId from circle
            $cityId = Circle::where('id', $authMember->circleId)->value('cityId');
            if (! $cityId) {
                return response()->json(['message' => 'City not found'], 404);
            }

            // Get all circle IDs in the same city
            $circleIdsInCity = Circle::where('cityId', $cityId)->pluck('id')->toArray();

            // Fetch business givers data
            $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($authUserId, $authMember, $circleIdsInCity) {
                $user = $group->first()->users;

                if (! $user) {
                    return null;
                }

                $member = $user->member()->select('id', 'circleId', 'businessCategoryId', 'profilePhoto', 'userId')->first();

                if (! $member || ! in_array($member->circleId, $circleIdsInCity)) {
                    return null; // Skip if member not in same city
                }

                $circle = Circle::find($member->circleId);
                $businessCategory = BusinessCategory::find($member->businessCategoryId);
                $inductionCount = Member::where('sponsoredBy', $member->id)->count();

                $connectionStatus = 'not_connected';

                $connection = Connection::where(function ($query) use ($authUserId, $member) {
                    $query->where('userId', $authUserId)
                        ->where('memberId', $member->userId);
                })->orWhere(function ($query) use ($authUserId, $member) {
                    $query->where('userId', $member->userId)
                        ->where('memberId', $authUserId);
                })->first();

                if ($connection) {

                    if ($connection->status == 'Accepted') {
                        $connectionStatus = 'connected';
                    } elseif ($connection->status == 'Pending') {

                        if ($connection->userId == $authUserId) {
                            $connectionStatus = 'request_sent';
                        } else {
                            $connectionStatus = 'request_received';
                        }
                    } elseif ($connection->status == 'Rejected') {
                        $connectionStatus = 'not_connected';
                    }
                }

                return [
                    'user' => [
                        'id' => $user->id,
                        'firstName' => $user->firstName,
                        'lastName' => $user->lastName,
                        'email' => $user->email,
                    ],
                    'member' => [
                        'id' => $member->id,
                        'profilePhoto' => $member->profilePhoto,
                        'induction_count' => $inductionCount,
                        'connectionStatus' => $connectionStatus,
                    ],
                    'amount' => $group->sum('amount'),
                    'count' => $group->count(),
                    'circle' => $circle ? [
                        'id' => $circle->id,
                        'circleName' => $circle->circleName,
                    ] : null,
                    'businessCategory' => $businessCategory ? [
                        'id' => $businessCategory->id,
                        'categoryName' => $businessCategory->categoryName,
                    ] : null,
                ];
            })
                ->filter()
                ->sortByDesc('amount')
                ->values();

            return Utils::sendResponse(
                ['busGiver' => $busGiver],
                'Business data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function maxBusiness(Request $request)
    // {
    //     try {
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
    //             ->whereYear('date', $previousYear)
    //             ->whereMonth('date', $previousMonth)
    //             ->get();

    //         $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
    //             $user = $group->first()->users;
    //             $member = $user->member()->select('circleId', 'businessCategoryId', 'profilePhoto')->first();
    //             $circle = Circle::find($member->circleId);
    //             $businessCategory = BusinessCategory::find($member->businessCategoryId);

    //             return [
    //                 'user' => $user,
    //                 'member' => $member,
    //                 'amount' => $group->sum('amount'),
    //                 'count' => $group->count(),
    //                 'circle' => [
    //                     'id' => $circle->id,
    //                     'circleName ' => $circle->circleName
    //                 ],
    //                 'businessCategory' => [
    //                     'id' => $businessCategory->id,
    //                     'categoryName' => $businessCategory->categoryName
    //                 ]
    //             ];
    //         })->sortByDesc('amount')->values();

    //         return Utils::sendResponse(
    //             ['busGiver' => $busGiver],
    //             'Business data retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function maxReference(Request $request)
    // {
    //     try {
    //         $authUserId = auth()->id(); // Get the authenticated user ID
    //         $previousMonth = Carbon::now()->subMonth()->month;
    //         $previousYear = Carbon::now()->subMonth()->year;

    //         $authMember = Member::where('userId', $authUserId)->first();

    //         $refGiver = CircleMeetingMembersReference::where('status', 'Active')
    //             ->whereYear('created_at', $previousYear)
    //             ->whereMonth('created_at', $previousMonth)
    //             ->get()
    //             ->groupBy('referenceGiverId')
    //             ->map(function ($group) use ($authUserId, $authMember) {
    //                 $referenceGiverId = $group->first()->referenceGiverId ?? null;

    //                 if (!$referenceGiverId) {
    //                     return null;
    //                 }

    //                 $user = User::find($referenceGiverId);

    //                 if ($user && $user->status === 'Active') {
    //                     $member = Member::where('userId', $referenceGiverId)
    //                         ->where('status', 'Active')
    //                         ->first();

    //                     if (!$member) {
    //                         return null;
    //                     }

    //                     $inductionCount = Member::where('sponsoredBy', $member->id)->count();

    //                     // Determine connection status
    //                     $connectionStatus = 'Not Connected';

    //                     if ($authMember && $member->circleId === $authMember->circleId) {
    //                         $connectionStatus = 'Connected';
    //                     } else {
    //                         $connection = Connection::where('memberId', $member->userId)
    //                             ->where('userId', $authUserId)
    //                             ->first();

    //                         if ($connection) {
    //                             $connectionStatus = $connection->status; // 'Pending' or 'Connected'
    //                         }
    //                     }

    //                     return [
    //                         'user' => [
    //                             'id' => $user->id,
    //                             'firstName' => $user->firstName,
    //                             'lastName' => $user->lastName,
    //                             'email' => $user->email,
    //                         ],
    //                         'count' => $group->count(),
    //                         'induction_count' => $inductionCount,
    //                         'connectionStatus' => $connectionStatus,
    //                         'businessCategoryId' => $member->businessCategoryId,
    //                         'businessCategory' => $member->bcategory->categoryName ?? null,
    //                         'circleId' => $member->circleId,
    //                         'circle' => $member->circle->circleName ?? null,
    //                         'profilePhoto' => $member->profilePhoto,
    //                     ];
    //                 }

    //                 return null;
    //             })
    //             ->filter()
    //             ->sortByDesc('count')
    //             ->first();

    //         if (!$refGiver) {
    //             return Utils::sendResponse(
    //                 null,
    //                 'No Reference Lead Board to show for now.',
    //                 404
    //             );
    //         }

    //         return Utils::sendResponse(
    //             ['refGiver' => $refGiver],
    //             'Reference data retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function maxReference(Request $request)
    {
        try {
            $authUserId = auth()->id(); // Get the authenticated user ID
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $authMember = Member::where('userId', $authUserId)->first();

            if (! $authMember) {
                return response()->json(['message' => 'Authenticated member not found'], 404);
            }

            // Get cityId from the user's circle
            $cityId = Circle::where('id', $authMember->circleId)->value('cityId');
            if (! $cityId) {
                return response()->json(['message' => 'City not found'], 404);
            }

            // All circle IDs in the same city
            $circleIdsInCity = Circle::where('cityId', $cityId)->pluck('id')->toArray();

            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->whereYear('created_at', $previousYear)
                ->whereMonth('created_at', $previousMonth)
                ->get()
                ->groupBy('referenceGiverId')
                ->map(function ($group) use ($authUserId, $authMember, $circleIdsInCity) {
                    $referenceGiverId = $group->first()->referenceGiverId ?? null;

                    if (! $referenceGiverId) {
                        return null;
                    }

                    $user = User::find($referenceGiverId);

                    if ($user && $user->status === 'Active') {
                        $member = Member::where('userId', $referenceGiverId)
                            ->where('status', 'Active')
                            ->first();

                        if (! $member || ! in_array($member->circleId, $circleIdsInCity)) {
                            return null; // Skip if member not in same city
                        }

                        $inductionCount = Member::where('sponsoredBy', $member->id)->count();

                        // Determine connection status
                        $connectionStatus = 'not_connected';

                        $connection = Connection::where(function ($query) use ($authUserId, $member) {
                            $query->where('userId', $authUserId)
                                ->where('memberId', $member->userId);
                        })->orWhere(function ($query) use ($authUserId, $member) {
                            $query->where('userId', $member->userId)
                                ->where('memberId', $authUserId);
                        })->first();

                        // if ($connection) {

                        //     if ($connection->status == 'Accepted') {
                        //         $connectionStatus = 'connected';
                        //     } elseif ($connection->status == 'Pending') {

                        //         if ($connection->userId == $authUserId) {
                        //             $connectionStatus = 'request_sent';
                        //         } else {
                        //             $connectionStatus = 'request_received';
                        //         }
                        //     } elseif ($connection->status == 'Rejected') {
                        //         $connectionStatus = 'not_connected';
                        //     }
                        // }
                        if ($connection) {
                            if ($connection->status == 'Accepted') {
                                $connectionStatus = 'connected';
                            } elseif ($connection->status == 'Pending') {

                                if ($connection->userId == $authUserId) {
                                    // YOU sent request
                                    $connectionStatus = 'request_sent';
                                } else {
                                    // YOU received request
                                    $connectionStatus = 'request_received';
                                }
                            } elseif ($connection->status == 'Rejected') {
                                $connectionStatus = 'not_connected';
                            }
                        } else {
                            $connectionStatus = 'not_connected';
                        }

                        return [
                            'user' => [
                                'id' => $user->id,
                                'firstName' => $user->firstName,
                                'lastName' => $user->lastName,
                                'email' => $user->email,
                            ],
                            'count' => $group->count(),
                            'induction_count' => $inductionCount,
                            'connectionStatus' => $connectionStatus,
                            'businessCategoryId' => $member->businessCategoryId,
                            'businessCategory' => $member->bcategory->categoryName ?? null,
                            'circleId' => $member->circleId,
                            'circle' => $member->circle->circleName ?? null,
                            'profilePhoto' => $member->profilePhoto,
                        ];
                    }

                    return null;
                })
                ->filter()
                ->sortByDesc('count')
                ->first(); // only the top one as per your current logic

            if (! $refGiver) {
                return Utils::sendResponse(
                    null,
                    'No Reference Lead Board to show for now.',
                    404
                );
            }

            return Utils::sendResponse(
                ['refGiver' => $refGiver],
                'Reference data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxRefferal(Request $request)
    {
        try {
            return Utils::sendResponse(
                [],
                'Referral data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxVisitor(Request $request)
    {
        try {
            return Utils::sendResponse(
                [],
                'Visitor data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function getMaxData(Request $request)
    {
        try {

            $maxMeetings = $this->maxMeetings($request);

            $maxBusiness = $this->maxBusiness($request);

            $maxReference = $this->maxReference($request);

            $maxRefferal = $this->maxRefferal($request);

            $maxVisitor = $this->maxVisitor($request);

            $response = [
                'maxMeetings' => json_decode($maxMeetings->content(), true),
                'maxBusiness' => json_decode($maxBusiness->content(), true),
                'maxReference' => json_decode($maxReference->content(), true),
                'maxRefferal' => json_decode($maxRefferal->content(), true),
                'maxVisitor' => json_decode($maxVisitor->content(), true),
            ];

            return Utils::sendResponse($response, 'All data retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // Max data for particular auth user

    public function maxMeetingsUser(Request $request)
    {
        try {
            $authUser = Auth::user();

            $member = Member::where('userId', $authUser->id)->first();
            if (! $member) {
                return Utils::sendResponse([], 'Member not found', 404);
            }

            $circlecalls = CircleCall::with(['member' => function ($query) {
                $query->select('id', 'userId', 'firstname', 'lastname', 'businesscategoryId', 'profilephoto');
            }, 'meetingPerson'])
                ->where('status', 'Active')
                ->where('memberId', $member->id)
                ->get();

            $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
                return [
                    'member' => $group->first()->member,
                    'count' => $group->count(),
                ];
            })->sortByDesc('count')->values();

            return Utils::sendResponse(
                ['circlecalls' => $circlecalls],
                'Meeting data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxBusinessUser(Request $request)
    {
        try {
            $authUser = Auth::user();

            $member = Member::where('userId', $authUser->id)->first();
            if (! $member) {
                return Utils::sendResponse([], 'Member not found', 404);
            }

            $busGiver = CircleMeetingMembersBusiness::where('businessGiverId', $authUser->id)->get();

            $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) use ($member) {
                return [
                    'user' => $group->first()->users,
                    'amount' => $group->sum('amount'),
                    'count' => $group->count(),
                    'businessCategoryId' => $member->businessCategoryId,
                    'businessCategory' => $member->bCategory->categoryName,
                    'circleId' => $member->circleId,
                    'circle' => $member->circle->circleName,
                ];
            })->sortByDesc('amount')->values();

            return Utils::sendResponse(
                ['busGiver' => $busGiver],
                'Business data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxReferenceUser(Request $request)
    {
        try {
            $authUser = Auth::user();

            $member = Member::where('userId', $authUser->id)->first();
            if (! $member) {
                return Utils::sendResponse([], 'Member not found', 404);
            }
            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->where('referenceGiverId', $authUser->id)
                ->get();

            $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) use ($member) {
                return [
                    'user' => $group->first()->refGiverName,
                    'count' => $group->count(),
                    'businessCategoryId' => $member->businessCategoryId,
                    'businessCategory' => $member->bcategory->categoryName,
                    'circleId' => $member->circleId,
                    'circle' => $member->circle->circleName,
                ];
            })->sortByDesc('count')->values();

            return Utils::sendResponse(
                ['refGiver' => $refGiver],
                'Reference data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxRefferalUser(Request $request)
    {
        try {
            $authUser = Auth::user();

            $member = Member::where('userId', $authUser->id)->first();
            if (! $member) {
                return Utils::sendResponse([], 'Member not found', 404);
            }

            return Utils::sendResponse(
                [],
                'Referral data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function maxVisitorUser(Request $request)
    {
        try {
            $authUser = Auth::user();

            $member = Member::where('userId', $authUser->id)->first();
            if (! $member) {
                return Utils::sendResponse([], 'Member not found', 404);
            }

            return Utils::sendResponse(
                [],
                'Visitor data retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function getMaxDataUser(Request $request)
    {
        try {

            $maxMeetingsUser = $this->maxMeetingsUser($request);

            $maxBusinessUser = $this->maxBusinessUser($request);

            $maxReferenceUser = $this->maxReferenceUser($request);

            $maxRefferalUser = $this->maxRefferalUser($request);

            $maxVisitorUser = $this->maxVisitorUser($request);

            $response = [
                'maxMeetings' => json_decode($maxMeetingsUser->content(), true),
                'maxBusiness' => json_decode($maxBusinessUser->content(), true),
                'maxReference' => json_decode($maxReferenceUser->content(), true),
                'maxRefferal' => json_decode($maxRefferalUser->content(), true),
                'maxVisitor' => json_decode($maxVisitorUser->content(), true),
            ];

            return Utils::sendResponse($response, 'All data retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    //max indution member api 
    public function maxInduction(Request $request)
    {
        try {
            $authUserId = auth()->id();
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $authMember = Member::where('userId', $authUserId)->first();

            if (! $authMember) {
                return response()->json(['message' => 'Authenticated member not found'], 404);
            }

            // Get cityId from the user's circle
            $cityId = Circle::where('id', $authMember->circleId)->value('cityId');
            if (! $cityId) {
                return response()->json(['message' => 'City not found'], 404);
            }

            // All circle IDs in the same city
            $circleIdsInCity = Circle::where('cityId', $cityId)->pluck('id')->toArray();

            // Get Highest Induction
            $induction = Member::where('status', 'Active')
                ->whereYear('created_at', $previousYear)
                ->whereMonth('created_at', $previousMonth)
                ->whereNotNull('sponsoredBy')
                ->get()
                ->groupBy('sponsoredBy')
                ->map(function ($group) use ($authUserId, $authMember, $circleIdsInCity) {
                    $sponsorId = $group->first()->sponsoredBy;

                    if (! $sponsorId) {
                        return null;
                    }

                    // sponsorId is member ID, we need to find the member and then user
                    $member = Member::with(['circle', 'bCategory'])
                        ->where('id', $sponsorId)
                        ->where('status', 'Active')
                        ->first();

                    if (! $member || ! in_array($member->circleId, $circleIdsInCity)) {
                        return null; // Skip if member not in same city
                    }

                    $user = User::find($member->userId);

                    if ($user && $user->status === 'Active') {
                        $inductionCount = Member::where('sponsoredBy', $member->id)->count();

                        // Determine connection status
                        $connectionStatus = 'not_connected';

                        $connection = Connection::where(function ($query) use ($authUserId, $member) {
                            $query->where('userId', $authUserId)
                                ->where('memberId', $member->userId);
                        })->orWhere(function ($query) use ($authUserId, $member) {
                            $query->where('userId', $member->userId)
                                ->where('memberId', $authUserId);
                        })->first();

                        if ($connection) {

                            if ($connection->status == 'Accepted') {
                                $connectionStatus = 'connected';
                            } elseif ($connection->status == 'Pending') {

                                if ($connection->userId == $authUserId) {
                                    $connectionStatus = 'request_sent';
                                } else {
                                    $connectionStatus = 'request_received';
                                }
                            } elseif ($connection->status == 'Rejected') {
                                $connectionStatus = 'not_connected';
                            }
                        }

                        return [
                            'user' => [
                                'id' => $user->id,
                                'firstName' => $user->firstName,
                                'lastName' => $user->lastName,
                                'email' => $user->email,
                            ],
                            'count' => $group->count(),
                            'induction_count' => $inductionCount,
                            'connectionStatus' => $connectionStatus,
                            'businessCategoryId' => $member->businessCategoryId,
                            'businessCategory' => $member->bcategory->categoryName ?? null,
                            'circleId' => $member->circleId,
                            'circle' => $member->circle->circleName ?? null,
                            'profilePhoto' => $member->profilePhoto,
                        ];
                    }

                    return null;
                })
                ->filter()
                ->sortByDesc('count')
                ->first();

            if (! $induction) {
                return Utils::sendResponse(
                    null,
                    'No Induction Lead Board to show for now.',
                    404
                );
            }

            return Utils::sendResponse(
                ['induction' => $induction],
                'Max induction member retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function index(Request $request)
    {
        try {
            $trainings = Training::with('trainer')
                ->where('status', 'Active')
                ->where('date', '>=', Carbon::now()->subDays(1))
                // ->where('date', '>', now()->toDateString())
                ->get();

            return Utils::sendResponse(['trainings' => $trainings], 'Trainings retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    // Personal Details

    // public function profile(Request $request)
    // {
    //     $user = Auth::user();

    //     $member = Member::where('userId', $user->id)->first();

    //     if ($member) {
    //         $billingAddress = BillingAddress::where('memberId', $member->id)->first();
    //         $contactDetails = ContactDetails::where('memberId', $member->id)->first();
    //         $topsProfile = TopsProfile::where('memberId', $member->id)->first();

    //         $businessCategory = [
    //             'businessCategoryId' => $member->businessCategoryId,
    //             'businessCategory' => $member->bCategory->categoryName,
    //         ];

    //         $circle = [
    //             'circleId' => $member->circleId,
    //             'circle' => $member->circle->circleName,
    //         ];

    //         return response()->json([
    //             'user' => $user,
    //             'member' => $member,
    //             'billingAddress' => $billingAddress,
    //             'contactDetails' => $contactDetails,
    //             'topsProfile' => $topsProfile,
    //             'businessCategory' => $businessCategory,
    //             'circle' => $circle,
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'Member not found'], 404);
    //     }
    // }

    public function profile(Request $request)
    {
        $user = Auth::user();

        $member = Member::where('userId', $user->id)->first();

        if (! $member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $billingAddress = BillingAddress::where('memberId', $member->id)->first();
        $contactDetails = ContactDetails::where('memberId', $member->id)->first();
        $topsProfile = TopsProfile::where('memberId', $member->id)->first();

        $businessCategory = [
            'businessCategoryId' => $member->businessCategoryId,
            'businessCategory' => $member->bCategory->categoryName ?? null,
        ];

        if ($user->hasRole('Member')) {
            $circle = [
                'circleId' => $member->circleId,
                'circle' => $member->circle->circleName ?? null,
            ];
        } else {
            $circle = null; // for Digital Member
        }

        return response()->json([
            'user' => $user,
            'member' => $member,
            'billingAddress' => $billingAddress,
            'contactDetails' => $contactDetails,
            'topsProfile' => $topsProfile,
            'businessCategory' => $businessCategory,
            'circle' => $circle,
        ]);
    }

    public function billingAddressUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return Utils::errorResponse($request->all(), 'Invalid Input');
        }

        $user = Auth::user();
        $member = $user->member;
        $billingAddress = BillingAddress::where('memberId', $member->id)->first();

        if ($billingAddress) {
            $billingAddress->update($request->all());

            return Utils::sendResponse([$billingAddress, 'message' => 'Billing Address data updated successfully'], 200);
        } else {
            return Utils::errorResponse(['error' => 'Billing Address not found'], 404);
        }
    }

    public function contactDetailsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return Utils::errorResponse($request->all(), 'Invalid Input');
        }

        $user = Auth::user();
        $member = $user->member;

        $contactDetails = ContactDetails::where('memberId', $member->id)->first();

        if ($contactDetails) {
            $contactDetails->update($request->all());

            return Utils::sendResponse([$contactDetails, 'message' => 'Contact Details data updated successfully'], 200);
        } else {
            return Utils::errorResponse(['error' => 'Contact Details not found'], 404);
        }
    }

    public function topsProfileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return Utils::errorResponse($request->all(), 'Invalid Input');
        }

        $user = Auth::user();
        $member = $user->member;

        $topsProfile = TopsProfile::where('memberId', $member->id)->first();

        if ($topsProfile) {
            $topsProfile->update($request->all());

            return Utils::sendResponse([$topsProfile, 'message' => 'Tops Profile data updated successfully'], 200);
        } else {
            return Utils::errorResponse(['error' => 'Tops Profile not found'], 404);
        }
    }

    // public function memberUpdate(Request $request)
    // {

    //     $user = Auth::user();

    //     $member = Member::where('userId', $user->id)->first();

    //     if (! $member) {
    //         return Utils::errorResponse(['error' => 'Member not found'], 404);
    //     }
    //     $member->title = $request->input('title', $member->title);
    //     $member->firstName = $request->input('firstName', $member->firstName);
    //     $member->lastName = $request->input('lastName', $member->lastName);
    //     // $member->username = $request->input('username', $member->username);
    //     $member->suffix = $request->input('suffix', $member->suffix);
    //     $member->displayName = $request->input('displayName', $member->displayName);
    //     $member->gender = $request->input('gender', $member->gender);
    //     $member->companyName = $request->input('companyName', $member->companyName);
    //     $member->gstRegiState = $request->input('gstRegiState', $member->gstRegiState);
    //     $member->gstinPan = $request->input('gstinPan', $member->gstinPan);
    //     $member->industry = $request->input('industry', $member->industry);
    //     $member->classification = $request->input('classification', $member->classification);
    //     $member->chapter = $request->input('chapter', $member->chapter);
    //     $member->renewalDueDate = $request->input('renewalDueDate', $member->renewalDueDate);
    //     $member->membershipStatus = $request->input('membershipStatus', $member->membershipStatus);
    //     $member->keyWords = $request->input('keyWords', $member->keyWords);
    //     $member->language = $request->input('language', $member->language);
    //     $member->timeZone = $request->input('timeZone', $member->timeZone);
    //     // $member->webSite = $request->input('web Site', $member->webSite);
    //     // $member->addressLine1 = $request->input('addressLine1', $member->addressLine1);
    //     // $member->addressLine2 = $request->input('addressLine2', $member->addressLine2);


    //     if ($request->hasFile('profilePhoto')) {
    //         $file = $request->file('profilePhoto');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         if ($member->profilePhoto) {
    //             $filePath = public_path('ProfilePhoto/') . $member->profilePhoto;
    //             if (file_exists($filePath)) {
    //                 unlink($filePath);
    //             }
    //         }
    //         $file->move(public_path('ProfilePhoto'), $filename);
    //         $member->profilePhoto = $filename;
    //     }

    //     if ($request->hasFile('companyLogo')) {
    //         $file = $request->file('companyLogo');
    //         $filename = time() . '.' . $file->getClientOriginalExtension();
    //         if ($member->companyLogo) {
    //             $filePath = public_path('CompanyLogo/') . $member->companyLogo;
    //             if (file_exists($filePath)) {
    //                 unlink($filePath);
    //             }
    //         }
    //         $file->move(public_path('CompanyLogo'), $filename);
    //         $member->companyLogo = $filename;
    //     }

    //     $member->goals = $request->input('goals', $member->goals);
    //     $member->accomplishment = $request->input('accomplishment', $member->accomplishment);
    //     $member->interests = $request->input('interests', $member->interests);
    //     $member->networks = $request->input('networks', $member->networks);
    //     $member->skills = $request->input('skills', $member->skills);
    //     $member->myBusiness = $request->input('myBusiness', $member->myBusiness);
    //     $member->webSite = $request->input('web Site', $member->webSite);
    //     $member->showWebsite = $request->input('showWebsite', $member->showWebsite);
    //     $member->socialLinks = $request->input('socialLinks', $member->socialLinks);
    //     $member->showSocialLinks = $request->input('showSocialLinks', $member->showSocialLinks);
    //     $member->receiveUpdates = $request->input('receiveUpdates', $member->receiveUpdates);
    //     $member->shareRevenue = $request->input('shareRevenue', $member->shareRevenue);

    //     // $contactDetails = ContactDetails::where('userId', $member->userId)->first();
    //      $contactDetails = ContactDetails::where('memberId', $member->id)->first();

    //     if ($contactDetails) {
    //         $contactDetails->addressLine1 = $request->input('addressLine1', $contactDetails->addressLine1);
    //         $contactDetails->addressLine2 = $request->input('addressLine2', $contactDetails->addressLine2);
    //         $contactDetails->save();
    //     }

    //     $member->save();

    //     return Utils::sendResponse([$member, 'message' => 'Member Profile data updated successfully'], 200);
    // }
    public function memberUpdate(Request $request)
    {
        try {


            $user = Auth::user();

            $member = Member::where('userId', $user->id)->first();

            if (!$member) {
                return Utils::errorResponse(['error' => 'Member not found'], 404);
            }

            /* ================= MEMBER DATA UPDATE ================= */

            $member->title = $request->input('title', $member->title);
            $member->firstName = $request->input('firstName', $member->firstName);
            $member->lastName = $request->input('lastName', $member->lastName);
            $member->suffix = $request->input('suffix', $member->suffix);
            $member->displayName = $request->input('displayName', $member->displayName);
            $member->gender = $request->input('gender', $member->gender);
            $member->companyName = $request->input('companyName', $member->companyName);
            $member->gstRegiState = $request->input('gstRegiState', $member->gstRegiState);
            $member->gstinPan = $request->input('gstinPan', $member->gstinPan);
            $member->industry = $request->input('industry', $member->industry);
            $member->classification = $request->input('classification', $member->classification);
            $member->chapter = $request->input('chapter', $member->chapter);
            $member->renewalDueDate = $request->input('renewalDueDate', $member->renewalDueDate);
            $member->membershipStatus = $request->input('membershipStatus', $member->membershipStatus);
            $member->keyWords = $request->input('keyWords', $member->keyWords);
            $member->language = $request->input('language', $member->language);
            $member->timeZone = $request->input('timeZone', $member->timeZone);

            /* ================= PROFILE PHOTO ================= */

            if ($request->hasFile('profilePhoto')) {

                $file = $request->file('profilePhoto');
                $filename = time() . '_' . $file->getClientOriginalName();

                if ($member->profilePhoto) {
                    $oldPath = public_path('ProfilePhoto/' . $member->profilePhoto);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $file->move(public_path('ProfilePhoto'), $filename);
                $member->profilePhoto = $filename;
            }

            /* ================= COMPANY LOGO ================= */

            if ($request->hasFile('companyLogo')) {

                $file = $request->file('companyLogo');
                $filename = time() . '_' . $file->getClientOriginalName();

                if ($member->companyLogo) {
                    $oldPath = public_path('CompanyLogo/' . $member->companyLogo);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                $file->move(public_path('CompanyLogo'), $filename);
                $member->companyLogo = $filename;
            }

            /* ================= OTHER MEMBER FIELDS ================= */

            $member->goals = $request->input('goals', $member->goals);
            $member->accomplishment = $request->input('accomplishment', $member->accomplishment);
            $member->interests = $request->input('interests', $member->interests);
            $member->networks = $request->input('networks', $member->networks);
            $member->skills = $request->input('skills', $member->skills);
            $member->myBusiness = $request->input('myBusiness', $member->myBusiness);
            $member->webSite = $request->input('webSite', $member->webSite);
            $member->showWebsite = $request->input('showWebsite', $member->showWebsite);
            $member->socialLinks = $request->input('socialLinks', $member->socialLinks);
            $member->showSocialLinks = $request->input('showSocialLinks', $member->showSocialLinks);
            $member->receiveUpdates = $request->input('receiveUpdates', $member->receiveUpdates);
            $member->shareRevenue = $request->input('shareRevenue', $member->shareRevenue);

            /* ================= CONTACT DETAILS UPDATE ================= */

            $contactDetails = ContactDetails::where('memberId', $member->id)->first();
            if ($contactDetails) {

                // $contactDetails->addressLine1 = $request->input('addressLine1', $contactDetails->addressLine1);
                // $contactDetails->addressLine2 = $request->input('addressLine2', $contactDetails->addressLine2);
                $contactDetails->addressLine1 = $request->addressLine1;
                $contactDetails->addressLine2 = $request->addressLine2;
                $contactDetails->save();
            }

            /* ================= SAVE MEMBER ================= */

            $member->save();

            return Utils::sendResponse([
                'member' => $member,
                'message' => 'Member profile updated successfully'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    // memberList

    public function circleWiseMember(Request $request)
    {
        try {
            $circlesData = [];
            $circles = Circle::where('status', 'Active')->get();

            foreach ($circles as $circle) {
                $circleData = [
                    'id' => $circle->id,
                    'name' => $circle->circleName,
                    // Add more fields as needed
                ];

                // Fetch members for the current circle
                $circleMembers = $circle->members()->select('id', 'circleId', 'firstName', 'lastName')->get();

                $membersData = [];

                foreach ($circleMembers as $member) {
                    // Fetch contact details for each member
                    $memberContactDetails = $member->contactDetails()->select('id', 'memberId', 'mobileNo', 'email')->get()->toArray();

                    $membersData[] = [
                        'id' => $member->id,
                        'firstName' => $member->firstName,
                        'lastName' => $member->lastName,
                        'contactDetails' => $memberContactDetails,
                    ];
                }

                $circlesData[] = [
                    'circle' => $circleData,
                    'members' => $membersData,
                ];
            }

            // You can return data using Utils::sendResponse for API response
            return Utils::sendResponse($circlesData, 'Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Handle exceptions and return error response
            return Utils::errorResponse([
                'error' => $th->getMessage(),
            ], 'Internal Server Error', 500);
        }
    }

    // public function iindex(Request $request)
    // {
    //     try {
    //         $circleMembers = Member::with('circle')
    //         // ->with('member')
    //         ->where('status', 'Active')
    //         ->orderBy('id', 'DESC')
    //         ->get();
    //         return Utils::sendResponse(['circleMembers' => $circleMembers], 'Circle members retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // suggested members
    // public function categoryWiseMember(Request $request)
    // {
    //     try {
    //         $categoryData = []; // Initialize the array to hold business category data

    //         // Check if the user is authenticated
    //         if (!auth()->check()) {
    //             return Utils::errorResponse([], 'Unauthorized', 401);
    //         }

    //         // Get authenticated user
    //         $user = auth()->user();

    //         // Get user's memberId and businessCategoryId
    //         $authMemberId = $user->member->id; // Assuming the user has a related member
    //         $authBusinessCategoryId = $user->member->businessCategoryId; // Assuming 'businessCategoryId' exists on 'members' table

    //         // Fetch members who belong to the same business category as the authenticated user, excluding the logged-in user
    //         $members = Member::where('businessCategoryId', $authBusinessCategoryId)
    //             ->where('id', '!=', $authMemberId) // Exclude the logged-in user's member data
    //             ->with(['circle' => function ($query) {
    //                 $query->where('status', 'Active');
    //             }])
    //             ->where('status', 'Active')
    //             ->get();

    //         foreach ($members as $member) {
    //             // Fetch the category for the current member
    //             $businessCategory = BusinessCategory::find($member->businessCategoryId); // Fetching the related category object

    //             if ($businessCategory && $businessCategory->status === 'Active') {
    //                 // Populate the category data only once
    //                 if (empty($categoryData)) {
    //                     $categoryData = [
    //                         'businessCategoryId' => $businessCategory->id,
    //                         'businessCategoryName' => $businessCategory->categoryName,
    //                         'members' => [], // Initialize the members array inside categoryData
    //                     ];
    //                 }

    //                 // Add member data to the members array within categoryData
    //                 $categoryData['members'][] = [
    //                     'authMemberId' => $authMemberId,
    //                     'userId' => $member->userId,
    //                     'memberId' => $member->id,
    //                     'firstName' => $member->firstName,
    //                     'lastName' => $member->lastName,
    //                     'profilePhoto' => $member->profilePhoto,
    //                     'circle' => $member->circle->circleName,
    //                     'companyName' => $member->companyName,
    //                     // Add any other fields you need here
    //                 ];
    //             }
    //         }

    //         // Return the consolidated category data array, which includes member data
    //         return Utils::sendResponse($categoryData, 'Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Handle exceptions and return error response
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }

    public function categoryWiseMember(Request $request)
    {
        try {
            $categoryData = []; // Initialize the array to hold business category data

            // Check if the user is authenticated
            if (! auth()->check()) {
                return Utils::errorResponse([], 'Unauthorized', 401);
            }

            // Get authenticated user
            $user = auth()->user();

            $authMemberId = $user->member->id; // Assuming the user has a related member
            $authBusinessCategoryId = $user->member->businessCategoryId; // Assuming 'businessCategoryId' exists on 'members' table

            // Fetch members who belong to the same business category as the authenticated user, excluding the logged-in user
            $members = Member::where('businessCategoryId', $authBusinessCategoryId)
                ->where('id', '!=', $authMemberId) // Exclude the logged-in user's member data
                ->where('status', 'Active') // Ensure the member is active
                ->whereHas('user', function ($query) {
                    $query->where('status', 'Active'); // Ensure the associated user is active
                })
                ->with(['circle' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->get();

            foreach ($members as $member) {
                $businessCategory = BusinessCategory::find($member->businessCategoryId);

                if ($businessCategory && $businessCategory->status === 'Active') {

                    if (empty($categoryData)) {
                        $categoryData = [
                            'businessCategoryId' => $businessCategory->id,
                            'businessCategoryName' => $businessCategory->categoryName,
                            'members' => [],
                        ];
                    }

                    $categoryData['members'][] = [
                        'authMemberId' => $authMemberId,
                        'userId' => $member->userId,
                        'memberId' => $member->id,
                        'firstName' => $member->firstName,
                        'lastName' => $member->lastName,
                        'profilePhoto' => $member->profilePhoto,
                        // 'circle' => $member->circle->circleName,
                        'circle' => $member->circle->circleName ?? $member->cityId,
                        'companyName' => $member->companyName,
                    ];
                }
            }

            return Utils::sendResponse($categoryData, 'Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse([
                'error' => $th->getMessage(),
            ], 'Internal Server Error', 500);
        }
    }

    // public function allMembers(Request $request)
    // {
    //     try {
    //         $allmembers = Member::where('status', 'Active')
    //             ->with('user')
    //             ->with('circle:id,circleName')
    //             ->get();

    //         return Utils::sendResponse(
    //             ['allmembers' => $allmembers],
    //             'All members retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function allMembers(Request $request)
    // {
    //     try {
    //         // Check if the user is authenticated
    //         if (!auth()->check()) {
    //             return Utils::errorResponse([], 'Unauthorized', 401);
    //         }

    //         // Get the authenticated user's member ID
    //         $authMemberId = auth()->user()->member->id; // Assuming the user has a related member

    //         // Fetch all active members, excluding the authenticated user's data
    //         $allmembers = Member::where('status', 'Active')
    //         ->where('id', '!=', $authMemberId) // Exclude the authenticated user's member data
    //             ->with('user')
    //             ->with('circle:id,circleName')
    //             ->get();

    //         return Utils::sendResponse(
    //             ['allmembers' => $allmembers],
    //             'All members retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function allMembers(Request $request)
    // {
    //     try {
    //         // Check if the user is authenticated
    //         if (!auth()->check()) {
    //             return Utils::errorResponse([], 'Unauthorized', 401);
    //         }

    //         // Get the authenticated user's member ID
    //         $authMemberId = auth()->user()->member->id; // Assuming the user has a related member

    //         // Fetch all active members, excluding the authenticated user's data, and ensure related user is also active
    //         $allmembers = Member::where('status', 'Active')
    //             ->where('id', '!=', $authMemberId) // Exclude the authenticated user's member data
    //             ->whereHas('user', function ($query) {
    //                 $query->where('status', 'Active'); // Ensure the related user is active
    //             })
    //             ->with('user')
    //             ->with('circle:id,circleName')
    //             ->get();

    //         return Utils::sendResponse(
    //             ['allmembers' => $allmembers],
    //             'All members retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function allMembers(Request $request)
    // {
    //     try {
    //         if (!auth()->check()) {
    //             return Utils::errorResponse([], 'Unauthorized', 401);
    //         }

    //         $authMember = auth()->user()->member;
    //         $authMemberId = $authMember->id;
    //         $authCircleId = $authMember->circleId;

    //         // Get all active members from the same circle
    //         $allmembers = Member::where('status', 'Active')
    //             ->where('id', '!=', $authMemberId)
    //             ->where('circleId', $authCircleId)
    //             ->whereHas('user', function ($query) {
    //                 $query->where('status', 'Active');
    //             })
    //             ->with('user')
    //             ->with(['circle:id,circleName,cityId', 'circle.city:id,cityName'])
    //             ->get();

    //         // Get business meeting records
    //         $businessMeetings = CircleMeetingMembersBusiness::with(['member'])
    //             ->where('status', 'Active')
    //             ->get();

    //         // Calculate total business amount for the circle
    //         $totalBusinessAmount = 0;
    //         foreach ($businessMeetings as $meeting) {
    //             $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //             if ($businessGiverCircleId == $authCircleId) {
    //                 $totalBusinessAmount += $meeting->amount;
    //             }
    //         }

    //         return Utils::sendResponse(
    //             [
    //                 'allmembers' => $allmembers,
    //                 'totalBusinessAmount' => $totalBusinessAmount,
    //             ],
    //             'All members and total business amount retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function allMembers(Request $request)
    // {
    //     try {
    //         if (!auth()->check()) {
    //             return Utils::errorResponse([], 'Unauthorized', 401);
    //         }

    //         $authMember = auth()->user()->member;
    //         $authMemberId = $authMember->id;
    //         $authCircleId = $authMember->circleId;

    //         // Get all active members from the same circle
    //         $allmembers = Member::where('status', 'Active')
    //             ->where('id', '!=', $authMemberId)
    //             ->where('circleId', $authCircleId)
    //             ->whereHas('user', function ($query) {
    //                 $query->where('status', 'Active');
    //             })
    //             ->with('user')
    //             ->with(['circle:id,circleName,cityId', 'circle.city:id,cityName'])
    //             ->get();

    //         // Get business meeting records
    //         $businessMeetings = CircleMeetingMembersBusiness::with(['member'])
    //             ->where('status', 'Active')
    //             ->get();

    //         // Calculate total business amount for the circle and member's business amounts
    //         $totalBusinessAmount = 0;
    //         foreach ($businessMeetings as $meeting) {
    //             $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
    //             if ($businessGiverCircleId == $authCircleId) {
    //                 $totalBusinessAmount += $meeting->amount;

    //                 // Loop through members and attach the business amount for each member
    //                 foreach ($allmembers as $member) {
    //                     if ($member->id == $meeting->member->id) {
    //                         // Initialize the member's business amount if not set
    //                         if (!isset($member->businessAmount)) {
    //                             $member->businessAmount = 0;
    //                         }
    //                         $member->businessAmount += $meeting->amount;
    //                     }
    //                 }
    //             }
    //         }

    //         return Utils::sendResponse(
    //             [
    //                 'allmembers' => $allmembers,
    //                 'totalBusinessAmount' => $totalBusinessAmount,
    //             ],
    //             'All members and total business amount retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function allMembers(Request $request)
    {
        try {
            if (! auth()->check()) {
                return Utils::errorResponse([], 'Unauthorized', 401);
            }

            $authMember = auth()->user()->member;
            $authMemberId = $authMember->id;
            $authCircleId = $authMember->circleId;

            // Get all active members from the same circle
            $allmembers = Member::where('status', 'Active')
                ->where('id', '!=', $authMemberId)
                ->where('circleId', $authCircleId)
                ->whereHas('user', function ($query) {
                    $query->where('status', 'Active');
                })
                ->with('user')
                ->with(['circle:id,circleName,cityId', 'circle.city:id,cityName'])
                ->get();

            // 🔹 Initialize businessAmount = 0 and append induction_count for all members
            foreach ($allmembers as $member) {
                $member->businessAmount = 0;
                $member->induction_count = Member::where('sponsoredBy', $member->id)->count();
            }

            // Get business meeting records
            $businessMeetings = CircleMeetingMembersBusiness::with(['member'])
                ->where('status', 'Active')
                ->get();

            // Calculate total business amount for the circle and member's business amounts
            $totalBusinessAmount = 0;
            foreach ($businessMeetings as $meeting) {
                $businessGiverCircleId = Member::where('userId', $meeting->businessGiverId)->value('circleId');
                if ($businessGiverCircleId == $authCircleId) {
                    $totalBusinessAmount += $meeting->amount;

                    foreach ($allmembers as $member) {
                        if ($member->id == $meeting->member->id) {
                            $member->businessAmount += $meeting->amount;
                        }
                    }
                }
            }

            return Utils::sendResponse(
                [
                    'allmembers' => $allmembers,
                    'totalBusinessAmount' => $totalBusinessAmount,
                ],
                'All members and total business amount retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function allMembers(Request $request)
    // {
    //     try {
    //         if (!auth()->check()) {
    //             return Utils::errorResponse([], 'Unauthorized', 401);
    //         }

    //         $authMember = auth()->user()->member;
    //         $authMemberId = $authMember->id;
    //         $authCircleId = $authMember->circleId;

    //         $allmembers = Member::where('status', 'Active')
    //             ->where('id', '!=', $authMemberId)
    //             ->where('circleId', $authCircleId)
    //             ->whereHas('user', function ($query) {
    //                 $query->where('status', 'Active');
    //             })
    //             ->with('user')
    //             ->with('circle:id,circleName')
    //             ->get();

    //         return Utils::sendResponse(
    //             ['allmembers' => $allmembers],
    //             'All members retrieved successfully',
    //             200
    //         );
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // member by userId
    public function getUserDetails(Request $request, $userId)
    {
        try {
            // Fetch the member by user ID
            $member = Member::where('userId', $userId)
                ->with(['user', 'circle:id,circleName', 'bcategory:id,categoryName'])
                ->first();

            // If member is not found, return a not found response
            if (! $member) {
                return Utils::errorResponse(['error' => 'Member not found'], 'Not Found', 404);
            }

            // Fetch related data from other tables using memberId
            $contactDetails = ContactDetails::where('memberId', $member->id)->first();
            $topsProfile = TopsProfile::where('memberId', $member->id)->first();
            $billingAddress = BillingAddress::where('memberId', $member->id)->first();

            // Combine all the data into a single response
            $userDetails = [
                'member' => $member,
                'contactDetails' => $contactDetails,
                'topsProfile' => $topsProfile,
                'billingAddress' => $billingAddress,
            ];

            return Utils::sendResponse(
                ['userDetails' => $userDetails],
                'User details retrieved successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Check if the current password matches the stored password
            if (! Hash::check($request->current_password, Auth::user()->password)) {
                return Utils::errorResponse(
                    ['current_password' => 'The current password does not match our records.'],
                    'Validation Error',
                    422
                );
            }

            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            return Utils::sendResponse(
                null,
                'Password successfully changed!',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse(
                ['error' => $th->getMessage()],
                'Internal Server Error',
                500
            );
        }
    }

    public function totalCounts()
    {
        try {
            $totalBusiness = CircleMeetingMembersBusiness::where('status', 'Active')->sum('amount');
            $totalReferences = CircleMeetingMembersReference::where('status', 'Active')->count();
            $totalIbms = CircleCall::where('status', 'Active')->count();

            return Utils::sendResponse([
                'total_business' => $totalBusiness,
                'total_references' => $totalReferences,
                'total_ibms' => $totalIbms,
            ], 'Total Counts fetched successfully', 200);
        } catch (\Throwable $e) {
            return Utils::errorResponse(
                ['error' => $e->getMessage()],
                'Internal Server Error',
                500
            );
        }
    }

    public function storeVisitorApi(Request $request)
    {
        try {

            $request->validate([
                'firstName' => 'required|string',
                'mobileNo' => 'required',
                'meetingId' => 'required',
            ]);

            $visitor = new VisitorsDetails;
            $visitor->firstName = $request->firstName;
            $visitor->lastName = $request->lastName;
            $visitor->mobileNo = $request->mobileNo;
            $visitor->businessName = $request->businessName;

            // Business category
            if ($request->businessCategory == 'other') {
                $business = BusinessCategory::where('categoryName', $request->otherCategory)->first();

                if (! $business) {
                    $business = new BusinessCategory;
                    $business->categoryName = $request->otherCategory;
                    $business->save();
                }

                $visitor->businessCategory = $business->id;
            } else {
                $visitor->businessCategory = $request->businessCategory;
            }

            $visitor->product = $request->product;
            $visitor->networkingGroup = $request->networkingGroup;
            $visitor->circleMeet = $request->circleMeet;
            $visitor->invitedBy = $request->invitedBy;
            $visitor->knowUs = $request->knowUs;
            $visitor->meetingId = $request->meetingId;
            $visitor->status = 'Active';
            $visitor->save();

            // Invitation
            $invitation = new MeetingInvitation;
            $invitation->meetingId = $visitor->meetingId;
            $invitation->invitedMemberId = $visitor->invitedBy;
            $invitation->personName = $visitor->firstName . ' ' . $visitor->lastName;
            $invitation->personEmail = null;
            $invitation->personContact = $visitor->mobileNo;
            $invitation->businessCategoryId = $visitor->businessCategory;
            $invitation->save();

            return Utils::sendResponse(
                ['visitor_id' => $visitor->id],
                'Information submitted successfully',
                200
            );
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Failed to submit information', 500);
        }
    }

    public function myStats()
    {
        try {
            $authUserId = Auth::id();

            // Received References
            $myReceivedReferences = CircleMeetingMembersReference::where('memberId', $authUserId)
                ->where('status', 'Active')
                ->count();

            // Given References
            $myGivenReferences = CircleMeetingMembersReference::where('referenceGiverId', $authUserId)
                ->where('status', 'Active')
                ->count();

            // Given Business Amount
            $myGivenBusiness = CircleMeetingMembersBusiness::where('businessGiverId', $authUserId)
                ->where('status', 'Active')
                ->sum('amount');

            // Received Business Amount
            $myReceivedBusiness = CircleMeetingMembersBusiness::where('loginMemberId', $authUserId)
                ->where('status', 'Active')
                ->sum('amount');

            // IBM Count
            $myIbmCount = CircleCall::where('memberId', $authUserId)
                ->where('status', 'Active')
                ->count();

            return Utils::sendResponse([
                'received_references' => $myReceivedReferences,
                'given_references' => $myGivenReferences,
                'given_business' => $myGivenBusiness,
                'received_business' => $myReceivedBusiness,
                'ibm_count' => $myIbmCount,
            ], 'My stats fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    //active meeting schedule by circle 
    public function activeMeetingSchedules()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return Utils::sendResponse([], 'User not found', 404);
            }

            $member = Member::where('userId', $user->id)->first();

            if (!$member) {
                return Utils::sendResponse([], 'Member profile not found', 404);
            }

            $circleId = $member->circleId;

            if (!$circleId) {
                return Utils::sendResponse([], 'Circle not found for this member', 404);
            }

            $schedules = Schedule::where('circleId', $circleId)
                ->where('status', 'Active')
                ->orderBy('date', 'desc')
                ->get();

            return Utils::sendResponse($schedules, 'Meeting schedules fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    //resoucrse index api 
    public function resourceIndex(Request $request)
    {
        try {
            $categories = ResourceCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            $selectedCategoryId = $request->resourceCatId;

            $query = Help::where('status', 'Active');
            if ($selectedCategoryId) {
                $query->where('resourceCatId', $selectedCategoryId);
            }

            $help = $query->get();

            return Utils::sendResponse([
                'categories' => $categories,
                'help' => $help,
                'selectedCategoryId' => $selectedCategoryId
            ], 'Resources fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
    public function markAsRead(Request $request, $id)
    {
        try {
            $notification = Notifications::find($id);

            if (!$notification) {
                return Utils::errorResponse(
                    ['error' => 'Notification not found'],
                    'Notification not found',
                    404
                );
            }

            // ✅ Mark as read
            if (!$notification->is_read) {
                $notification->is_read = 1;
                $notification->save();
            }

            return Utils::sendResponse([
                'notification_id' => $notification->id,
                'is_read' => $notification->is_read,
            ], 'Notification marked as read successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(
                $th->getMessage(),
                'Internal Server Error',
                500
            );
        }
    }
    //top networkers
    public function topNetworkers()
    {
        try {
            // Top Influencers (Inductions > 8)
            $topInfluencers = Member::withCount('sponsees')
                ->having('sponsees_count', '>', 8)
                ->orderByDesc('sponsees_count')
                ->with(['circle', 'bCategory']) // Load related data for display
                ->get();

            // Crorepati Givers (Business Given > 1 Crore)
            $crorepatiGiversRaw = CircleMeetingMembersBusiness::select('businessGiverId', DB::raw('SUM(amount) as total_amount'))
                ->where('status', 'Active')
                ->groupBy('businessGiverId')
                ->having('total_amount', '>', 10000000)
                ->orderByDesc('total_amount')
                ->with(['businessGiverMember' => function ($query) {
                    $query->select('id', 'userId', 'firstName', 'lastName', 'profilePhoto', 'companyName', 'circleId', 'businessCategoryId');
                    $query->with('circle:id,circleName', 'bCategory:id,categoryName');
                }])
                ->get();

            // Filter out if member is null (e.g. user deleted but business record exists)
            $crorepatiGivers = $crorepatiGiversRaw->filter(function ($item) {
                return $item->businessGiverMember != null;
            })->values(); // Re-index the collection

            return Utils::sendResponse([
                'topInfluencers' => $topInfluencers,
                'crorepatiGivers' => $crorepatiGivers
            ], 'Top Networkers fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

<<<<<<< HEAD
    public function vacantCategories(Request $request)
=======
public function vacantCategories(Request $request)
>>>>>>> 822757d9f93a84366513e8717afea468b32b5eb1
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return Utils::sendResponse([], 'User not found', 404);
            }

            $member = Member::where('userId', $user->id)->first();

            if (!$member) {
                return Utils::sendResponse([], 'Member profile not found', 404);
            }

            $circleId = $member->circleId;

            if (!$circleId) {
                return Utils::sendResponse([], 'Circle not found for this member', 404);
            }

            $businessCategoryId = Circle::where('id', $circleId)->value('businessCategoryId');

            // Decode JSON properly instead of explode
            $businessCategoryIdArray = $businessCategoryId ? json_decode($businessCategoryId, true) : [];

            $businessCategories = collect(); // Default empty collection

            if (!empty($businessCategoryIdArray)) {
                $businessCategories = BusinessCategory::whereIn('id', $businessCategoryIdArray)->get();
            }

            $categoryNames = $businessCategories->pluck('categoryName');

            return Utils::sendResponse($categoryNames, 'Vacant categories fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
