<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Utils\Utils;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CircleMemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circleMembers = CircleMember::with('circle')
                ->with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return Utils::sendResponse(['circleMembers' => $circleMembers], 'Circle members retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
    // public function iindex(Request $request)
    // {
    //     try {
    //         $circleMembers = CircleMember::with('circle')
    //             ->with('member')
    //             ->where('status', 'Active')
    //             ->orderBy('id', 'DESC')
    //             ->get();
    //         return Utils::sendResponse(['circleMembers' => $circleMembers], 'Circle members retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    public function show(Request $request, $id)
    {
        try {
            $circleMember = CircleMember::findOrFail($id);
            return Utils::sendResponse(['circleMember' => $circleMember], 'Circle member retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'circleId' => 'required',
            'memberId' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleMember = new CircleMember();
            $circleMember->circleId = $request->circleId;
            $circleMember->memberId = $request->memberId;
            $circleMember->status = 'Active';

            $circleMember->save();

            return Utils::sendResponse(['circleMember' => $circleMember], 'Circle Member Created Successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'circleId' => 'required',
            'memberId' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::errorResponse(['error' => $validator->errors()->first()], 'Invalid Input', 400);
        }

        try {
            $circleMember = CircleMember::find($id);

            if (!$circleMember) {
                return Utils::errorResponse(['error' => 'Circle Member not found.'], 'Not Found', 404);
            }

            $circleMember->circleId = $request->circleId;
            $circleMember->memberId = $request->memberId;
            $circleMember->status = 'Active';
            $circleMember->save();

            return Utils::sendResponse(['circleMember' => $circleMember], 'Circle Member Updated Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $circleMember = CircleMember::find($id);

            if (!$circleMember) {
                return Utils::errorResponse(['error' => 'Circle Member not found.'], 'Not Found', 404);
            }

            $circleMember->status = 'Deleted';
            $circleMember->save();

            return Utils::sendResponse([], 'Circle Member Deleted Successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    //api for circle wise member data 

    // public function circleWiseMember(Request $request)
    // {
    //     try {
    //         $circlesData = [];
    //         $circles = Circle::where('status', 'Active')->get();

    //         foreach ($circles as $circle) {
    //             $circleData = $circle->toArray();
    //             // unset($circleData['id']); // Remove 'id' from circle data

    //             $circleMembers = $circle->members()->get()->toArray();
    //             $circlesData[] = [
    //                 'circle' => $circleData,
    //                 'members' => $circleMembers
    //             ];
    //         }

    //         // You can return data using Utils::sendResponse for API response
    //         return Utils::sendResponse($circlesData, 'Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Handle exceptions and return error response
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }

    // public function circleWiseMember(Request $request)
    // {
    //     try {
    //         $circlesData = [];
    //         $circles = Circle::where('status', 'Active')->get();

    //         foreach ($circles as $circle) {
    //             // Customize the fields you want to display for the circle
    //             $circleData = [
    //                 'id' => $circle->id,
    //                 'name' => $circle->circleName,
    //                 // Add more fields as needed
    //             ];

    //             // Fetch only specific fields for members
    //             $circleMembers = $circle->members()->select('id', 'circleId', 'firstName', 'lastName')->get()->toArray();

    //             $circlesData[] = [
    //                 'circle' => $circleData,
    //                 'members' => $circleMembers
    //             ];
    //         }

    //         // You can return data using Utils::sendResponse for API response
    //         return Utils::sendResponse($circlesData, 'Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Handle exceptions and return error response
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }


    // public function circleWiseMember(Request $request)
    // {
    //     try {


    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }
    // public function circleWiseMember(Request $request)
    // {
    //     try {
    //         $circlesData = [];
    //         $circles = Circle::where('status', 'Active')->get();

    //         foreach ($circles as $circle) {
    //             // Customize the fields you want to display for the circle
    //             $circleData = [
    //                 'id' => $circle->id,
    //                 'name' => $circle->circleName,
    //                 // Add more fields as needed
    //             ];

    //             // Fetch members for the current circle
    //             $circleMembers = $circle->members()->select('id', 'circleId', 'firstName', 'lastName')->get();

    //             $membersData = [];

    //             foreach ($circleMembers as $member) {
    //                 // Fetch contact details for each member
    //                 $memberContactDetails = $member->contactDetails()->select('id', 'memberId', 'mobileNo', 'email')->get()->toArray();

    //                 $membersData[] = [
    //                     'id' => $member->id,
    //                     'firstName' => $member->firstName,
    //                     'lastName' => $member->lastName,
    //                     'contactDetails' => $memberContactDetails,
    //                 ];
    //             }

    //             $circlesData[] = [
    //                 'circle' => $circleData,
    //                 'members' => $membersData,
    //             ];
    //         }

    //         // You can return data using Utils::sendResponse for API response
    //         return Utils::sendResponse($circlesData, 'Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Handle exceptions and return error response
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }

    public function circleWiseMember(Request $request)
    {
        try {
            // Check if the user is authenticated
            if (!auth()->check()) {
                return Utils::errorResponse([], 'Unauthorized', 401);
            }

            // Get the authenticated user's member ID
            $authMemberId = auth()->user()->member->id;

            $circlesData = [];
            $circles = Circle::where('status', 'Active')->get();

            foreach ($circles as $circle) {
                // Customize the fields you want to display for the circle
                $circleData = [
                    'id' => $circle->id,
                    'name' => $circle->circleName,
                    // Add more fields as needed
                ];

                // Fetch active members for the current circle, excluding the authenticated user's member data
                $circleMembers = $circle->members()
                    ->where('status', 'Active') // Only active members
                    ->where('id', '!=', $authMemberId) // Exclude the authenticated user's member data
                    ->whereHas('user', function ($query) {
                        $query->where('status', 'Active'); // Ensure the related user is active
                    })
                    ->select('id', 'circleId', 'firstName', 'lastName')
                    ->get();

                $membersData = [];

                foreach ($circleMembers as $member) {
                    // Fetch contact details for each member
                    $memberContactDetails = $member->contactDetails()
                        ->select('id', 'memberId', 'mobileNo', 'email')
                        ->get()
                        ->toArray();

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
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }


    public function categoryWiseMember(Request $request)
    {
        try {
            $categoryData = []; // Initialize the array to hold business category data
            $data = []; // Initialize the array to hold member data

            // Check if the user is authenticated
            if (!auth()->check()) {
                return Utils::errorResponse([], 'Unauthorized', 401);
            }

            // Get authenticated user
            $user = auth()->user();

            // Get user's memberId and businessCategoryId
            $authMemberId = $user->member->id; // Assuming the user has a related member
            $authBusinessCategoryId = $user->member->businessCategoryId; // Assuming 'businessCategoryId' exists on 'members' table

            // Fetch members who belong to the same business category as the authenticated user
            $members = Member::where('businessCategoryId', $authBusinessCategoryId)->get();

            foreach ($members as $member) {
                // Fetch the category for the current member
                $businessCategory = BusinessCategory::find($member->businessCategoryId); // Fetching the related category object

                if ($businessCategory && $businessCategory->status === 'Active') {
                    // Populate the category data only once
                    if (empty($categoryData)) {
                        $categoryData = [
                            'businessCategoryId' => $businessCategory->id,
                            'businessCategoryName' => $businessCategory->categoryName,
                            'members' => [], // Initialize the members array inside categoryData
                        ];
                    }

                    // Add member data to the members array within categoryData
                    $categoryData['members'][] = [
                        'authMemberId' => $authMemberId,
                        'memberId' => $member->id,
                        'firstName' => $member->firstName,
                        'lastName' => $member->lastName,
                        // Add any other fields you need here
                    ];
                }
            }

            // Return the consolidated category data array, which includes member data
            return Utils::sendResponse($categoryData, 'Data retrieved successfully', 200);
        } catch (\Throwable $th) {
            // Handle exceptions and return error response
            return Utils::errorResponse([
                'error' => $th->getMessage()
            ], 'Internal Server Error', 500);
        }
    }





    // public function circleWiseMember(Request $request)
    // {
    //     try {
    //         // Fetch active circles with their members
    //         $circles = Circle::where('status', 'Active')
    //         ->with('members')
    //             ->get();

    //         // You can return data using Utils::sendResponse for API response
    //         return Utils::sendResponse([
    //             'circles' => $circles
    //         ], 'Data retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Handle exceptions and return error response
    //         return Utils::errorResponse([
    //             'error' => $th->getMessage()
    //         ], 'Internal Server Error', 500);
    //     }
    // }



}
