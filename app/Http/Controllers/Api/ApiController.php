<?php

namespace App\Http\Controllers\Api;

use App\Utils\Utils;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Training;
use App\Models\CircleCall;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use Illuminate\Support\Carbon;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Utils::sendResponse($request->all(), 'Invalid Input');
        }

        if (Auth::attempt($request->only('email', 'password'))) {

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return Utils::sendResponse(['token' => $token, 'user' => $user], 'Success');
        }

        return Utils::sendResponse(['error' => 'Unauthorized'], 401);
    }

    //lead board
    public function maxMeetings(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $circlecalls = CircleCall::with(['member', 'meetingPerson'])
                ->where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            $circlecalls = $circlecalls->groupBy('memberId')->map(function ($group) {
                return [
                    'member' => $group->first()->member,
                    'count' => $group->count()
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

    public function maxBusiness(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $busGiver = CircleMeetingMembersBusiness::where('status', 'Active')
                ->whereYear('date', $previousYear)
                ->whereMonth('date', $previousMonth)
                ->get();

            $busGiver = $busGiver->groupBy('businessGiverId')->map(function ($group) {
                return [
                    'user' => $group->first()->users,
                    'amount' => $group->sum('amount'),
                    'count' => $group->count()
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

    public function maxReference(Request $request)
    {
        try {
            $previousMonth = Carbon::now()->subMonth()->month;
            $previousYear = Carbon::now()->subMonth()->year;

            $refGiver = CircleMeetingMembersReference::where('status', 'Active')
                ->whereYear('created_at', $previousYear)
                ->whereMonth('created_at', $previousMonth)
                ->get();

            $refGiver = $refGiver->groupBy('referenceGiverId')->map(function ($group) {
                return [
                    'user' => $group->first()->refGiverName,
                    'count' => $group->count()
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

    //Upcoming Workshop
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

    //Personal Details

    public function profile(Request $request)
    {
        $user = Auth::user();

        // Retrieve the member record associated with the authenticated user
        $member = Member::where('userId', $user->id)->first();

        if ($member) {
            // Retrieve related records
            $billingAddress = BillingAddress::where('memberId', $member->id)->first();
            $contactDetails = ContactDetails::where('memberId', $member->id)->first();
            $topsProfile = TopsProfile::where('memberId', $member->id)->first();

            // Return the data in your API response
            return response()->json([
                'user' => $user,
                'member' => $member,
                'billingAddress' => $billingAddress,
                'contactDetails' => $contactDetails,
                'topsProfile' => $topsProfile,
            ]);
        } else {
            // Handle the case where member record is not found
            return response()->json(['error' => 'Member not found'], 404);
        }
        // return Utils::sendResponse($responseData, "Profile Data");

    }

    public function billingAddressUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {
            return Utils::errorResponse($request->all(), 'Invalid Input');
        }

        $user = Auth::user();
        $member = $user->member;
        //update only billingAddress table data of logged in user
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


        //update only contactDetails table data of logged in user
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

        //update only topsProfile table data of logged in user
        $topsProfile = TopsProfile::where('memberId', $member->id)->first();

        if ($topsProfile) {
            $topsProfile->update($request->all());
            return Utils::sendResponse([$topsProfile, 'message' => 'Tops Profile data updated successfully'], 200);
        } else {
            return Utils::errorResponse(['error' => 'Tops Profile not found'], 404);
        }
    }

    public function memberUpdate(Request $request)
    {


        $user = Auth::user();


        $member = Member::where('userId', $user->id)->first();

        if (!$member) {
            return Utils::errorResponse(['error' => 'Member not found'], 404);
        }
        $member->title = $request->input('title', $member->title);
        $member->firstName = $request->input('firstName', $member->firstName);
        $member->lastName = $request->input('lastName', $member->lastName);
        // $member->username = $request->input('username', $member->username);
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

        if ($request->hasFile('profilePhoto')) {
            $file = $request->file('profilePhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            if ($member->profilePhoto) {
                $filePath = public_path('ProfilePhoto/') . $member->profilePhoto;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $file->move(public_path('ProfilePhoto'),  $filename);
            $member->profilePhoto = $filename;
        }

        if ($request->hasFile('companyLogo')) {
            $file = $request->file('companyLogo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            if ($member->companyLogo) {
                $filePath = public_path('CompanyLogo/') . $member->companyLogo;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $file->move(public_path('CompanyLogo'),  $filename);
            $member->companyLogo = $filename;
        }

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


        $member->save();


        return Utils::sendResponse([$member, 'message' => 'Member Profile data updated successfully'], 200);
    }

    //memberList

    public function circleWiseMember(Request $request)
    {
        try {
            $circlesData = [];
            $circles = Circle::where('status', 'Active')->get();

            foreach ($circles as $circle) {
                // Customize the fields you want to display for the circle
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
                'error' => $th->getMessage()
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

    //suggested members
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
}
