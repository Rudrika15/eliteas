<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BillingAddress;
use App\Models\BusinessCategory;
use App\Models\Circle;
use App\Models\City;
use App\Models\Connection;
use App\Models\ContactDetails;
use App\Models\Country;
use App\Models\Member;
use App\Models\MemberGallery;
use App\Models\Post;
use App\Models\State;
use App\Models\TopsProfile;
use App\Models\User;
use App\Utils\ErrorLogger;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicProfileController extends Controller
{
    /**
     * Get Public Profile by identifier (member ID, user ID, username or slug)
     * Or for the currently authenticated user if no identifier is passed.
     *
     * Supports:
     * 1) Logged-in user profile: GET /api/user/public-profile OR GET /api/public-profile (with Bearer token)
     * 2) Dashboard / View Profile: GET /api/public-profile/{id_or_username} OR query params ?user_id=X or ?member_id=X
     */
    public function getPublicProfile(Request $request, $identifier = null)
    {
        try {
            // Check query parameters fallback
            if (empty($identifier)) {
                $identifier = $request->query('member_id') 
                    ?? $request->query('user_id') 
                    ?? $request->query('id') 
                    ?? $request->query('firstname').'-'.$request->query('lastname')
                    ?? $request->query('slug');
            }

            $member = null;
            $user = null;

            // Resolve target member/user
            if (empty($identifier)) {
                // If no identifier provided, check authenticated user via Sanctum or session
                $authUser = auth('sanctum')->user() ?? Auth::user();
                if ($authUser) {
                    $user = $authUser;
                    $member = Member::where('userId', $user->id)->first();
                } else {
                    return Utils::errorResponse('Member ID, User ID, or username is required for public profile.', [], 400);
                }
            } else {
                // 1. Check if identifier is numeric (Member ID or User ID)
                if (is_numeric($identifier)) {
                    $member = Member::find($identifier);
                    if (!$member) {
                        $member = Member::where('userId', $identifier)->first();
                    }
                    if (!$member) {
                        $user = User::find($identifier);
                        if ($user) {
                            $member = Member::where('userId', $user->id)->first();
                        }
                    }
                }

                // 2. Exact match on username in Member table
                if (!$member) {
                    $member = Member::where('username', $identifier)->first();
                }

                if (!$member) {
                    $member = Member::whereRaw("LOWER(username) = ?", [strtolower($identifier)])->first();
                }

                // 3. Slug match against username, full name, or company
                if (!$member) {
                    $targetSlug = Str::slug($identifier);
                    $allMembers = Member::where('status', 'Active')->get();
                    foreach ($allMembers as $m) {
                        $uNameSlug = !empty($m->username) ? Str::slug($m->username) : '';
                        $fullNameSlug = Str::slug(($m->firstName ?? '') . '-' . ($m->lastName ?? ''));
                        $fullNameSpaceSlug = Str::slug(($m->firstName ?? '') . ' ' . ($m->lastName ?? ''));
                        $companySlug = !empty($m->companyName) ? Str::slug($m->companyName) : '';

                        if (
                            $targetSlug === $uNameSlug || 
                            $targetSlug === $fullNameSlug || 
                            $targetSlug === $fullNameSpaceSlug || 
                            $targetSlug === $companySlug || 
                            $identifier === $uNameSlug || 
                            $identifier === $fullNameSlug
                        ) {
                            $member = $m;
                            break;
                        }
                    }
                }

                // 4. Fallback search on User table by name or email
                if (!$member && !$user) {
                    $targetSlug = Str::slug($identifier);
                    $allUsers = User::where('status', 'Active')->get();
                    foreach ($allUsers as $u) {
                        $nameSlug = Str::slug(($u->firstName ?? '') . '-' . ($u->lastName ?? ''));
                        if ($targetSlug === $nameSlug || strtolower($u->email ?? '') === strtolower($identifier)) {
                            $user = $u;
                            $member = Member::where('userId', $user->id)->first();
                            break;
                        }
                    }
                }
            }

            // If member found but user not loaded yet
            if ($member && !$user) {
                $user = $member->user ?? User::find($member->userId);
            }

            // If neither member nor user found
            if (!$member && !$user) {
                return Utils::errorResponse('Profile not found.', [], 404);
            }

            // Prepare structured public profile data
            $profileData = $this->formatProfileData($member, $user, $request);

            return Utils::sendResponse($profileData, 'Public profile fetched successfully');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return Utils::errorResponse($th->getMessage(), [], 500);
        }
    }

    /**
     * Dedicated endpoint for the authenticated logged-in user
     * GET /api/user/public-profile
     */
    public function getAuthPublicProfile(Request $request)
    {
        $authUser = auth('sanctum')->user() ?? Auth::user();

        if (!$authUser) {
            return Utils::errorResponse('Unauthenticated.', [], 401);
        }

        return $this->getPublicProfile($request, $authUser->id);
    }

    /**
     * Helper to format all profile attributes cleanly for API responses
     */
    private function formatProfileData($member, $user, Request $request)
    {
        $authUserId = auth('sanctum')->id() ?? Auth::id();

        // Related records
        $memberId = $member ? $member->id : null;
        $userId = $user ? $user->id : ($member ? $member->userId : null);

        $contactDetails = $memberId ? ContactDetails::where('memberId', $memberId)->first() : null;
        $billingAddress = $memberId ? BillingAddress::where('memberId', $memberId)->first() : null;
        $topsProfile = $memberId ? TopsProfile::where('memberId', $memberId)->first() : null;

        $circle = null;
        if ($member && $member->circleId) {
            $circleModel = Circle::find($member->circleId);
            if ($circleModel) {
                $circle = [
                    'id' => $circleModel->id,
                    'name' => $circleModel->circleName ?? $circleModel->name,
                    'chapter' => $member->chapter ?? null,
                ];
            }
        }

        $businessCategory = null;
        if ($member && $member->businessCategoryId) {
            $bCategoryModel = BusinessCategory::find($member->businessCategoryId);
            if ($bCategoryModel) {
                $businessCategory = [
                    'id' => $bCategoryModel->id,
                    'name' => $bCategoryModel->categoryName,
                ];
            }
        }

        // Location data
        $city = $member && $member->cityId ? City::find($member->cityId) : null;
        $state = $city && $city->stateId ? State::find($city->stateId) : null;
        $country = $state && $state->countryId ? Country::find($state->countryId) : null;

        $location = [
            'cityId' => $city ? $city->id : null,
            'cityName' => $city ? $city->name : null,
            'stateId' => $state ? $state->id : null,
            'stateName' => $state ? $state->name : null,
            'countryId' => $country ? $country->id : null,
            'countryName' => $country ? $country->name : null,
            'formatted' => implode(', ', array_filter([
                $city ? $city->name : null,
                $state ? $state->name : null,
                $country ? $country->name : null,
            ])) ?: 'Location not specified',
        ];

        // Format Image URLs
        $profilePhoto = $member->profilePhoto ?? null;
        $profilePhotoUrl = null;
        if (!empty($profilePhoto) && file_exists(public_path('ProfilePhoto/' . $profilePhoto))) {
            $profilePhotoUrl = asset('ProfilePhoto/' . $profilePhoto);
        } else {
            $nameStr = urlencode(($member->firstName ?? $user->firstName ?? 'U') . ' ' . ($member->lastName ?? $user->lastName ?? ''));
            $profilePhotoUrl = "https://ui-avatars.com/api/?name={$nameStr}&background=1D2856&color=fff&size=200";
        }

        $companyLogo = $member->companyLogo ?? null;
        $companyLogoUrl = null;
        if (!empty($companyLogo) && file_exists(public_path('CompanyLogo/' . $companyLogo))) {
            $companyLogoUrl = asset('CompanyLogo/' . $companyLogo);
        }

        // Cover banner
        $coverBannerUrl = asset('img/header_img.png');

        // Keywords and skills
        $keywordsArr = [];
        if ($member && !empty($member->keyWords)) {
            $decoded = json_decode($member->keyWords, true);
            if (is_array($decoded)) {
                $keywordsArr = $decoded;
            } else {
                $keywordsArr = array_map('trim', explode(',', $member->keyWords));
            }
        }

        $skillsArr = [];
        if ($member && !empty($member->skills)) {
            $skillsArr = array_map('trim', explode(',', $member->skills));
        }
        $combinedSkills = array_values(array_unique(array_filter(array_merge($keywordsArr, $skillsArr))));

        // Gallery images
        $galleryImages = [];
        if ($memberId) {
            $galleries = MemberGallery::where('memberId', $memberId)
                ->where('status', 'Active')
                ->latest()
                ->get();

            foreach ($galleries as $g) {
                $galleryImages[] = [
                    'id' => $g->id,
                    'title' => $g->title ?? null,
                    'image' => $g->image,
                    'imageUrl' => asset('MemberGallery/' . $g->image),
                    'createdAt' => $g->created_at ? $g->created_at->toIso8601String() : null,
                ];
            }
        }

        // Recent posts from Social Wall
        $posts = [];
        if ($userId) {
            $recentPosts = Post::where('userId', $userId)
                ->latest()
                ->take(5)
                ->get();

            foreach ($recentPosts as $p) {
                $posts[] = [
                    'id' => $p->id,
                    'caption' => $p->caption ?? '',
                    'attachment' => $p->attachment ?? null,
                    'attachmentUrl' => !empty($p->attachment) ? asset('post/' . $p->attachment) : null,
                    'createdAt' => $p->created_at ? $p->created_at->diffForHumans() : null,
                ];
            }
        }

        // Slug and Share URLs
        $slug = $member && !empty($member->username)
            ? Str::slug($member->username)
            : Str::slug(($member->firstName ?? $user->firstName ?? '') . '-' . ($member->lastName ?? $user->lastName ?? ''));
        if (empty($slug)) {
            $slug = 'user-' . ($userId ?? $memberId);
        }

        $publicProfileUrl = url('/in/' . $slug);
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=' . urlencode($publicProfileUrl);

        // Connection status check (relative to authenticated requester)
        $isSelfProfile = false;
        $connectionStatus = 'not_connected';
        $connectionId = null;

        if ($authUserId) {
            if ($userId && $authUserId == $userId) {
                $isSelfProfile = true;
                $connectionStatus = 'self';
            } else {
                $conn = Connection::where(function ($q) use ($authUserId, $userId) {
                    $q->where('userId', $authUserId)->where('memberId', $userId);
                })->orWhere(function ($q) use ($authUserId, $userId) {
                    $q->where('userId', $userId)->where('memberId', $authUserId);
                })->first();

                if ($conn) {
                    $connectionId = $conn->id;
                    if ($conn->status === 'Accepted') {
                        $connectionStatus = 'connected';
                    } elseif ($conn->status === 'Pending') {
                        $connectionStatus = ($conn->userId == $authUserId) ? 'request_sent' : 'request_received';
                    } elseif ($conn->status === 'Rejected') {
                        $connectionStatus = 'rejected';
                    }
                } else {
                    // Circle-based connection fallback
                    $authMember = Member::where('userId', $authUserId)->first();
                    if ($authMember && $member && $authMember->circleId && $member->circleId && ($authMember->circleId == $member->circleId)) {
                        $connectionStatus = 'connected';
                    }
                }
            }
        }

        // Inductions count
        $inductionsCount = $memberId ? Member::where('sponsoredBy', $memberId)->count() : 0;

        // Other recommended members
        $recommendedMembers = [];
        $otherMembers = Member::where('status', 'Active')
            ->when($memberId, function ($q) use ($memberId) {
                return $q->where('id', '!=', $memberId);
            })
            ->inRandomOrder()
            ->take(4)
            ->get();

        foreach ($otherMembers as $om) {
            $omPhoto = $om->profilePhoto ?? null;
            $omPhotoUrl = (!empty($omPhoto) && file_exists(public_path('ProfilePhoto/' . $omPhoto)))
                ? asset('ProfilePhoto/' . $omPhoto)
                : 'https://ui-avatars.com/api/?name=' . urlencode(($om->firstName ?? '') . ' ' . ($om->lastName ?? '')) . '&background=1D2856&color=fff&size=100';

            $omSlug = !empty($om->username) ? Str::slug($om->username) : Str::slug(($om->firstName ?? '') . '-' . ($om->lastName ?? ''));
            if (empty($omSlug)) {
                $omSlug = 'user-' . $om->id;
            }

            $recommendedMembers[] = [
                'id' => $om->id,
                'userId' => $om->userId,
                'name' => trim(($om->firstName ?? '') . ' ' . ($om->lastName ?? '')),
                'companyName' => $om->companyName ?? null,
                'classification' => $om->classification ?? null,
                'profilePhotoUrl' => $omPhotoUrl,
                'slug' => $omSlug,
                'publicProfileUrl' => url('/in/' . $omSlug),
            ];
        }

        return [
            'isSelfProfile' => $isSelfProfile,
            'connection' => [
                'status' => $connectionStatus, // self, connected, request_sent, request_received, not_connected
                'connectionId' => $connectionId,
            ],
            'member' => [
                'id' => $memberId,
                'userId' => $userId,
                'firstName' => $member->firstName ?? $user->firstName ?? '',
                'lastName' => $member->lastName ?? $user->lastName ?? '',
                'fullName' => trim(($member->firstName ?? $user->firstName ?? '') . ' ' . ($member->lastName ?? $user->lastName ?? '')),
                'title' => $member->title ?? null,
                'gender' => $member->gender ?? null,
                'username' => $member->username ?? null,
                'slug' => $slug,
                'classification' => $member->classification ?? null,
                'industry' => $member->industry ?? null,
                'companyName' => $member->companyName ?? null,
                'companyLogo' => $companyLogo,
                'companyLogoUrl' => $companyLogoUrl,
                'profilePhoto' => $profilePhoto,
                'profilePhotoUrl' => $profilePhotoUrl,
                'coverBannerUrl' => $coverBannerUrl,
                'myBusiness' => $member->myBusiness ?? null,
                'goals' => $member->goals ?? null,
                'accomplishment' => $member->accomplishment ?? null,
                'interests' => $member->interests ?? null,
                'networks' => $member->networks ?? null,
                'website' => $member->webSite ?? null,
                'inductionsCount' => $inductionsCount,
                'status' => $member->status ?? ($user->status ?? 'Active'),
            ],
            'user' => [
                'id' => $userId,
                'firstName' => $user->firstName ?? ($member->firstName ?? ''),
                'lastName' => $user->lastName ?? ($member->lastName ?? ''),
                'email' => $user->email ?? null,
                'contactNo' => $user->contactNo ?? null,
                'status' => $user->status ?? 'Active',
            ],
            'location' => $location,
            'circle' => $circle,
            'businessCategory' => $businessCategory,
            'skills' => $combinedSkills,
            'contactDetails' => [
                'email' => $user->email ?? ($contactDetails->email ?? null),
                'mobileNo' => $user->contactNo ?? ($contactDetails->mobileNo ?? null),
                'phone' => $contactDetails->phone ?? null,
                'website' => $member->webSite ?? null,
                'address' => implode(', ', array_filter([
                    $contactDetails ? $contactDetails->addressLine1 : null,
                    $contactDetails ? $contactDetails->addressLine2 : null,
                    $contactDetails ? $contactDetails->city : null,
                    $contactDetails ? $contactDetails->state : null,
                    $contactDetails ? $contactDetails->pinCode : null,
                ])) ?: null,
            ],
            'billingAddress' => $billingAddress ? [
                'addressLine1' => $billingAddress->bAddressLine1 ?? null,
                'addressLine2' => $billingAddress->bAddressLine2 ?? null,
                'city' => $billingAddress->bCity ?? null,
                'state' => $billingAddress->bState ?? null,
                'country' => $billingAddress->bCountry ?? null,
                'pinCode' => $billingAddress->bPinCode ?? null,
            ] : null,
            'topsProfile' => $topsProfile ? [
                'burningDesire' => $topsProfile->myBurningDesire ?? null,
                'keyToSuccess' => $topsProfile->mKeyToSuccess ?? null,
                'idealReferral' => $topsProfile->idealRef ?? null,
                'topProduct' => $topsProfile->topProduct ?? null,
                'topProblemSolved' => $topsProfile->topProblemSolved ?? null,
                'yearsInBusiness' => $topsProfile->yearsInBusiness ?? null,
                'hobbiesInterests' => $topsProfile->hobbiesInterests ?? null,
            ] : null,
            'gallery' => $galleryImages,
            'posts' => $posts,
            'share' => [
                'publicProfileUrl' => $publicProfileUrl,
                'qrCodeUrl' => $qrCodeUrl,
            ],
            'recommendedProfiles' => $recommendedMembers,
        ];
    }
}
