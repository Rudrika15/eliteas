<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Utils\Utils;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\BusinessAmount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use App\Utils\ErrorLogger;

class CircleMeetingMemberBusinessController extends Controller
{
    // public function index(Request $request)
    // {
    //     try {
    //         $busGivers = CircleMeetingMembersBusiness::with([
    //             'users:id,firstName,lastName,email',
    //             'member:userId,profilePhoto',
    //             'businessAmounts' // Include business amounts relationship
    //         ])
    //             ->where('status', 'Active')
    //             ->orderByDesc('id')
    //             ->get();



    //         return Utils::sendResponse(['busGivers' => $busGivers], 'Circle Meeting Members Business retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function index(Request $request)
    // {
    //     try {
    //         $busGiven = CircleMeetingMembersBusiness::with([
    //             'users:id,firstName,lastName,email',
    //             'member:userId,profilePhoto,circleId',
    //             'businessAmounts' // Include business amounts relationship
    //         ])
    //             ->where('loginMemberId', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->orderByDesc('id')
    //             ->get();

    //         return Utils::sendResponse(['busGiven' => $busGiven], 'Circle Meeting Members Business retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function index(Request $request)
    {
        try {
            $busGiven = CircleMeetingMembersBusiness::with([
                'users:id,firstName,lastName,email',
                'member' => function ($q) {
                    $q->select('id', 'userId', 'circleId', 'sponsoredBy', 'profilePhoto', 'companyName');
                },
                'member.circle:id,circleName',
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

            return Utils::sendResponse(['busGiven' => $busGiven], 'Circle Meeting Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    // public function recievedBus(Request $request)
    // {
    //     try {
    //         $busRecieved = CircleMeetingMembersBusiness::where('businessGiverId', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->get();
    //         return Utils::sendResponse(['busRecieved' => $busRecieved], 'Circle Meeting Members Business retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function recievedBus(Request $request)
    // {
    //     try {
    //         return $busRecieved = CircleMeetingMembersBusiness::with([
    //             // 'users:id,firstName,lastName', // for businessGiverId
    //             // 'member:userId,profilePhoto', // for businessGiverId
    //             'loginMember.user:id,firstName,lastName', // for loginMemberId
    //             'loginMember.member:userId,profilePhoto', // for loginMemberId
    //             'businessAmounts'
    //         ])
    //             ->where('businessGiverId', Auth::user()->id)
    //             ->where('status', 'Active')
    //             ->orderByDesc('id')
    //             ->get();

    //         return Utils::sendResponse(['busRecieved' => $busRecieved], 'Circle Meeting Members Business retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    public function recievedBus(Request $request)
    {
        try {
            $busRecieved = CircleMeetingMembersBusiness::with([
                'loginMember.user:id,firstName,lastName',
                'loginMember.member' => function ($q) {
                    $q->select('id', 'userId', 'circleId', 'sponsoredBy', 'profilePhoto');
                },
                'loginMember.member.circle:id,circleName',
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


    public function businessReceived(Request $request)
    {
        try {

            if (!auth()->user()->hasRole('Member')) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized access', 403);
            }

            $busReceived = CircleMeetingMembersBusiness::with(['reference', 'member.circle:id,circleName'])
                ->where('loginMemberId', auth()->id())
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();

            // $busReceived->getCollection()->transform(function ($item) {
            //     $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
            //     return $item;
            // });

            $busReceived->transform(function ($item) {
                $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
                return $item;
            });


            return Utils::sendResponse(
                ['business_received' => $busReceived],
                'Business received list',
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


    public function businessGiven(Request $request)
    {
        try {

            if (!auth()->user()->hasRole('Member')) {
                return Utils::errorResponse(['error' => 'Unauthorized'], 'Unauthorized access', 403);
            }

            $busGiven = CircleMeetingMembersBusiness::with(['loginMember.member', 'reference'])
                ->where('businessGiverId', auth()->id())
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();

            // $busGiven->getCollection()->transform(function ($item) {
            //     $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
            //     return $item;
            // });

            $busGiven->transform(function ($item) {
                $item->amount = isset($item->amount) ? number_format($item->amount, 2) : '-';
                return $item;
            });


            return Utils::sendResponse(
                ['business_given' => $busGiven],
                'Business given list',
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





    public function busGiven(Request $request)
    {
        try {
            $busGiven = CircleMeetingMembersBusiness::where('loginMemberId', Auth::user()->id)
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['busGiven' => $busGiven], 'Circle Meeting Members Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }




    public function paymentHistory(Request $request)
    {
        try {
            $paymentHistory = BusinessAmount::where('status', 'Active')
                ->where('circleMeetingMemberBusinessId')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['paymentHistory' => $paymentHistory], 'Circle Meeting Members Business Payment History retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function view(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            return Utils::sendResponse(['busGiver' => $busGiver], 'Circle Meeting Member Business retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'businessGiver' => 'required',
    //         'loginMember' => 'required',
    //         'amount' => 'required',
    //         'date' => 'required',
    //         'remarks' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
    //     }

    //     try {
    //         $busGiver = new CircleMeetingMembersBusiness();
    //         $busGiver->fill($request->all());
    //         $busGiver->status = 'Active';
    //         $busGiver->save();

    //         return Utils::sendResponse(['busGiver' => $busGiver], 'Circle Meeting Member Business Created Successfully!', 201);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    // public function create(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'businessGiverId' => 'required',
    //         'loginMemberId'   => 'required',
    //         'amount'          => 'required',
    //         'date'            => 'required',
    //         'remarks'         => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return Utils::errorResponse(
    //             ['error' => $validator->errors()->first()],
    //             'Invalid Input',
    //             400
    //         );
    //     }

    //     try {
    //         $busGiver = new CircleMeetingMembersBusiness();
    //         $busGiver->businessGiverId = $request->businessGiverId;
    //         $busGiver->loginMemberId   = $request->loginMemberId;
    //         $busGiver->amount          = $request->amount;
    //         $busGiver->date            = $request->date;
    //         $busGiver->remarks         = $request->remarks;
    //         $busGiver->status          = 'Active';

    //         if ($request->filled('referenceId')) {
    //             $busGiver->referenceId = $request->referenceId;
    //         }
    //         $busGiver->save();

    //         return Utils::sendResponse(
    //             ['busGiver' => $busGiver],
    //             'Created Successfully!',
    //             201
    //         );
    //     } catch (\Throwable $th) {

    //         return Utils::errorResponse(
    //             ['error' => $th->getMessage()],
    //             'Internal Server Error',
    //             500
    //         );
    //     }
    // }


    public function create(Request $request)
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

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->businessGiverId = $request->businessGiverId;
            $busGiver->loginMemberId = Auth::user()->id;
            $busGiver->amount = $request->amount;
            $busGiver->remarks = $request->remarks;
            $busGiver->date = Carbon::now()->toDateString();
            $busGiver->status = 'Active';
            $busGiver->save();

            $refGiver = null;

            if ($request->create_reference == 1) {

                $refGiver = new CircleMeetingMembersReference();
                $refGiver->referenceGiverId = $busGiver->businessGiverId;
                $refGiver->memberId = Auth::user()->id;

                // if ($request->group == 'internal') {
                //     $refGiver->contactName = $request->contactNameInternal;
                // } else {
                //     $refGiver->contactName = $request->contactNameExternal;
                // }

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


    public function addBusinessAmountApi(Request $request, $id)
    {
        try {
            $reference = CircleMeetingMembersReference::where('status', 'Active')
                ->findOrFail($id);

            $busGiver = new CircleMeetingMembersBusiness();
            $busGiver->referenceId = $reference->id;
            $busGiver->businessGiverId = $reference->referenceGiverId;
            $busGiver->loginMemberId = Auth::id();
            $busGiver->amount = $request->amount;
            $busGiver->date = $request->date;
            $busGiver->remarks = $request->remarks;
            $busGiver->status = 'Active';

            $busGiver->save();

            return Utils::sendResponse(
                [
                    'busGiver' => $busGiver,
                    'reference' => $reference
                ],
                'Business Amount Added Successfully!',
                201
            );
        } catch (\Throwable $th) {

            return Utils::errorResponse(
                ['error' => $th->getMessage()],
                'Internal Server Error',
                500
            );
        }
    }




    public function update(Request $request, $id)
    {
        try {
            $id = $request->id;
            $busGiver = CircleMeetingMembersBusiness::find($id);

            // Check if the business giver exists
            if (!$busGiver) {
                return Utils::errorResponse([], 'Circle Meeting Member Business not found', 404);
            }

            // Retrieve memberId using userId
            $userId = $busGiver->businessGiverId;
            $member = Member::where('userId', $userId)->first();

            // Check if the member exists
            if (!$member) {
                return Utils::errorResponse([], 'Member not found', 404);
            }

            // Get the user associated with the member
            $user = User::find($userId);

            // Check if the user exists
            if (!$user) {
                return Utils::errorResponse([], 'User not found', 404);
            }

            // Update business giver amount and status
            $busGiver->amount += $request->amount;
            $busGiver->status = 'Active';
            $busGiver->save();

            // $businessAmount = new BusinessAmount();
            // $businessAmount->circleMeetingMemberBusinessId = $id;
            // $businessAmount->amount = $request->amount;
            // $businessAmount->date = Carbon::now()->toDateString();
            // $businessAmount->status = 'Active';
            // $businessAmount->save();

            return Utils::sendResponse([
                'busGiver' => $busGiver,
                // 'businessAmount' => $businessAmount,
                'userId' => $user->id,
                'profilePhoto' => $member->profilePhoto,
                'firstName' => $user->firstName,
                'lastName' => $user->lastName,
                'email' => $user->email
            ], 'Circle Meeting Member Business Updated Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }




    public function delete(Request $request, $id)
    {
        try {
            $busGiver = CircleMeetingMembersBusiness::findOrFail($id);
            $busGiver->status = "Deleted";
            $busGiver->save();

            return Utils::sendResponse([], 'Circle Meeting Member Business Deleted Successfully!', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
