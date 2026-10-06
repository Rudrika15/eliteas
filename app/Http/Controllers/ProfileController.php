<?php

namespace App\Http\Controllers;

use App\Models\BillingAddress;
use App\Models\Circle;
use App\Models\City;
use App\Models\ContactDetails;
use App\Models\Country;
use App\Models\Landmark;
use App\Models\Member;
use App\Models\MemberGallery;
use App\Models\Post;
use App\Models\State;
use App\Models\TopsProfile;
use App\Models\User;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:profile-member', ['only' => ['member']]);
        $this->middleware('permission:profile-member-update', ['only' => ['memberUpdate']]);
    }

    public function getLandmarks($cityId)
    {
        try {
            $landmarks = Landmark::where('cityId', $cityId)
                ->where('status', 'Active')
                ->pluck('name');

            return response()->json($landmarks);
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function member($id = 0)
    {
        try {
            if ($id === 0) {
                // If no $id is provided, fetch the currently authenticated user's ID
                $id = Auth::user()->id;
            }

            // Fetch profile data based on the provided $id
            $user = User::where('id', '=', $id)->first();
            $member = Member::where('userId', '=', $id)->first(); // Assuming userId column stores user ID
            $country = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $city = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::where('memberId', $member->id)->first();
            $billing = BillingAddress::where('memberId', $member->id)->first();
            $tops = TopsProfile::where('memberId', $member->id)->first();
            $landmarks = [];
            if ($member->cityId) {
                $landmarks = Landmark::where('cityId', $member->cityId)
                    ->where('status', 'Active')
                    ->pluck('name');
            }

            $galleryImages = MemberGallery::where('memberId', $member->id)->where('status', 'Active')->get();

            return view('profile', compact('member', 'user', 'country', 'states', 'city', 'contactDetails', 'billing', 'tops', 'landmarks', 'galleryImages'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            // In case of an error, redirect to servererror view
            return view('servererror');
        }
    }

    public function memberUpdate(Request $request)
    {
        //return $request;

        try {
            $this->validate($request, [
                'profilePhoto' => 'max:2048', // 5MB in kilobytes
                'companyLogo' => 'max:2048', // 5MB in kilobytes
            ]);

            $id = $request->input('id');
            $member = Member::find($id);
            if ($request->filled('title')) {
                $member->title = $request->title;
            }
            if ($request->filled('firstName')) {
                $member->firstName = $request->firstName;
            }
            if ($request->filled('lastName')) {
                $member->lastName = $request->lastName;
            }
            if ($request->filled('username')) {
                $member->username = $request->username;
            }

            // $member->email = $request->email;
            // $member->suffix = $request->suffix;
            // $member->displayName = $request->displayName;
            // $member->gstRegiState = $request->gstRegiState;

            if ($request->filled('gStinPan')) {
                $member->gStinPan = $request->gStinPan;
            }
            // $member->industry = $request->industry;
            // $member->classification = $request->classification;
            if ($request->filled('gender')) {
                $member->gender = $request->gender;
            }
            if ($request->filled('bussinessType')) {
                $member->bussinessType = $request->bussinessType;
            }
            // $member->language = $request->language;
            // $member->timeZone = $request->timeZone;

            if ($request->hasFile('profilePhoto')) {
                $member->profilePhoto = time() . '.' . $request->profilePhoto->extension();
                $request->profilePhoto->move(public_path('ProfilePhoto'), $member->profilePhoto);
            }

            if ($request->hasFile('companyLogo')) {
                $member->companyLogo = time() . '.' . $request->companyLogo->extension();
                $request->companyLogo->move(public_path('CompanyLogo'), $member->companyLogo);
            }

            // $member->goals = $request->goals;
            // $member->chapter = $request->chapter;
            // $member->renewalDueDate = $request->renewalDueDate;
            // $member->accomplishment = $request->accomplishment;
            if ($request->filled('companyName')) {
                $member->companyName = $request->companyName;
            }

            if ($request->filled('birthDate')) {
                $member->birthDate = $request->birthDate;
            }
            // $member->interests = $request->interests;
            // $member->networks = $request->networks;
            // $member->skills = $request->skills;
            // $member->myBusiness = $request->myBusiness;

            if ($request->filled('webSite')) {
                $member->webSite = $request->webSite;
            }
            // $member->showWebsite = $request->showWebsite;
            // $member->socialLinks = $request->socialLinks;
            // $member->showSocialLinks = $request->showSocialLinks;
            // $member->receiveUpdates = $request->receiveUpdates;
            // $member->shareRevenue = $request->shareRevenue;
            // $member->membershipStatus = $request->membershipStatus;
            // $member->keyWords = $request->keyWords;
            // $keywords = array_filter([$request->keyword1, $request->keyword2, $request->keyword3])

            $keywords = array_filter([
                $request->keyword1,
                $request->keyword2,
                $request->keyword3
            ]);
            if (!empty($keywords)) {
                $member->keyWords = json_encode($keywords);
            }
            if ($request->filled('city')) {
                $member->cityId = $request->city;
            }

            if ($request->filled('landmark')) {
                $landmarkName = $request->landmark;
                if ($landmarkName == 'Other') {
                    $landmarkName = $request->other_landmark;
                    // Save new landmark to landmarks table if it doesn't exist
                    if ($landmarkName) {
                        // Check if it already exists (case insensitive check recommended)
                        $existingLandmark = Landmark::where('cityId', $request->city)
                            ->where('name', $landmarkName)
                            ->first();

                        if (! $existingLandmark) {
                            Landmark::create([
                                'cityId' => $request->city,
                                'name' => $landmarkName,
                                'status' => 'Active',
                            ]);
                        }
                    }
                }
                $member->landmark = $landmarkName;
            }

            $member->status = 'Active';
            $member->save();
            if (!empty($request->deletedImages)) {
                $deletedIds = explode(',', $request->deletedImages);
                $images = MemberGallery::whereIn('id', $deletedIds)->get();
                foreach ($images as $img) {
                    $imagePath = public_path('MemberGallery/' . $img->image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    $img->status = 'Deleted';
                    $img->save();
                }
            }
            if ($request->hasFile('galleryImages')) {

                if (!file_exists(public_path('MemberGallery'))) {
                    mkdir(public_path('MemberGallery'), 0777, true);
                }

                foreach ($request->file('galleryImages') as $galleryImage) {

                    if (!$galleryImage || !$galleryImage->isValid()) {
                        continue;
                    }

                    $extension = strtolower($galleryImage->getClientOriginalExtension());

                    $allowed = ['jpg', 'jpeg', 'png', 'webp', 'avif'];

                    if (!in_array($extension, $allowed)) {
                        continue;
                    }

                    $imageName = time() . '_' . uniqid() . '.' . $extension;

                    $galleryImage->move(
                        public_path('MemberGallery'),
                        $imageName
                    );
                    MemberGallery::create([
                        'memberId' => $member->id,
                        'image' => $imageName,
                        'status' => 'Active'
                    ]);
                }
            }

            $user = User::find(Auth::id());

            if ($request->filled('firstName')) {
                $user->firstName = $request->firstName;
            }
            if ($request->filled('lastName')) {
                $user->lastName = $request->lastName;
            }
            if ($request->filled('email')) {
                $user->email = $request->email;
            }
            if ($request->filled('contactNo')) {
                $user->contactNo = $request->contactNo;
            }
            $user->save();

            $tops = TopsProfile::where('memberId', $member->id)->first();
            // $tops->idealRef = $request->idealRef;
            // $tops->topProduct = $request->topProduct;
            // $tops->topProblemSolved = $request->topProblemSolved;
            // $tops->myFavBNIStory = $request->myFavBNIStory;
            // $tops->myIdealRefPartner = $request->myIdealRefPartner;
            // $tops->weeklyPresent1 = $request->weeklyPresent1;
            // $tops->weeklyPresent2 = $request->weeklyPresent2;
            // $tops->yearsInBusiness = $request->yearsInBusiness;
            // $tops->prevJobs = $request->prevJobs;
            // $tops->spouse = $request->spouse;
            // $tops->children = $request->children;
            // $tops->pets = $request->pets;
            // $tops->hobbiesInterests = $request->hobbiesInterests;
            // $tops->cityofRes = $request->cityofRes;
            // $tops->yearsInCity = $request->yearsInCity;
            // $tops->myBurningDesire = $request->myBurningDesire;
            // $tops->dontKnowAboutMe = $request->dontKnowAboutMe;
            // $tops->mKeyToSuccess = $request->mKeyToSuccess;
            if ($tops) {
                $tops->status = 'Active';
                $tops->save();
            }

            $contact = ContactDetails::where('memberId', $member->id)->first();
            // $contact->showMeOnPublicWeb = $request->showMeOnPublicWeb;
            // $contact->billingAddress = $request->billingAddress;
            // $contact->phone = $request->phone;
            // $contact->showPhone = $request->showPhone;
            // $contact->directNo = $request->directNo;
            // $contact->showDirectNo = $request->showDirectNo;
            // $contact->home = $request->home;
            // $contact->mobileNo = $request->mobileNo;
            // $contact->showMobileNo = $request->showMobileNo;
            // $contact->pager = $request->pager;
            // $contact->voiceMail = $request->voiceMail;
            // $contact->tollFree = $request->tollFree;
            // $contact->showTollFree = $request->showTollFree;
            // $contact->fax = $request->fax;
            // $contact->showFax = $request->showFax;
            // $contact->showEmail = $request->showEmail;
            // $contact->profileAddress = $request->profileAddress;
            // $contact->city = $request->city;
            // $contact->state = $request->state;
            // $contact->country = $request->country;
            // $contact->pinCode = $request->pinCode;
            if ($contact) {
                if ($request->filled('email')) {
                    $contact->email = $request->email;
                }

                if ($request->filled('addressLine1')) {
                    $contact->addressLine1 = $request->addressLine1;
                }

                if ($request->filled('addressLine2')) {
                    $contact->addressLine2 = $request->addressLine2;
                }
                $contact->status = 'Active';
                $contact->save();
            }

            $billing = BillingAddress::where('memberId', $member->id)->first();
            // $billing->bAddressLine1 = $request->bAddressLine1;
            // $billing->bAddressLine2 = $request->bAddressLine2;
            // $billing->bCity = $request->bCity;
            // $billing->bState = $request->bState;
            // $billing->bCountry = $request->bCountry;
            // $billing->bPinCode = $request->bPinCode;
            if ($billing) {
                $billing->status = 'Active';
                $billing->save();
            }

            return redirect()->route('home')->with('success', 'Profile Updated Successfully!')->with('profileUpdated', true);
        } catch (Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }

    public function showPublicProfile($identifier = null)
    {
        try {
            $member = null;
            $user = null;

            if (empty($identifier)) {
                if (Auth::check()) {
                    $user = Auth::user();
                    $member = Member::where('userId', $user->id)->first();
                    $slug = $member && !empty($member->username) 
                        ? Str::slug($member->username) 
                        : Str::slug(($user->firstName ?? '') . '-' . ($user->lastName ?? ''));
                    if (empty($slug)) {
                        $slug = 'user-' . $user->id;
                    }
                    return redirect()->route('public.profile', $slug);
                } else {
                    abort(404, 'Profile not found');
                }
            }

            $targetSlug = Str::slug($identifier);

            // 1. Check exact match by username or ID in Member
            $member = Member::where('username', $identifier)->first();

            if (!$member) {
                $member = Member::whereRaw("LOWER(username) = ?", [strtolower($identifier)])->first();
            }

            if (!$member && is_numeric($identifier)) {
                $member = Member::find($identifier);
                if (!$member) {
                    $member = Member::where('userId', $identifier)->first();
                }
            }

            // 2. Match slug against username or member full name or company
            if (!$member) {
                $allMembers = Member::all();
                foreach ($allMembers as $m) {
                    $uNameSlug = !empty($m->username) ? Str::slug($m->username) : '';
                    $fullNameSlug = Str::slug(($m->firstName ?? '') . '-' . ($m->lastName ?? ''));
                    $fullNameSpaceSlug = Str::slug(($m->firstName ?? '') . ' ' . ($m->lastName ?? ''));
                    $companySlug = !empty($m->companyName) ? Str::slug($m->companyName) : '';

                    if ($targetSlug === $uNameSlug || $targetSlug === $fullNameSlug || $targetSlug === $fullNameSpaceSlug || $targetSlug === $companySlug || $identifier === $uNameSlug || $identifier === $fullNameSlug) {
                        $member = $m;
                        break;
                    }
                }
            }

            // 3. Fallback check on User model
            if (!$member) {
                if (is_numeric($identifier)) {
                    $user = User::find($identifier);
                } else {
                    $allUsers = User::all();
                    foreach ($allUsers as $u) {
                        $nameSlug = Str::slug(($u->firstName ?? '') . '-' . ($u->lastName ?? ''));
                        $nameSpaceSlug = Str::slug(($u->firstName ?? '') . ' ' . ($u->lastName ?? ''));
                        if ($targetSlug === $nameSlug || $targetSlug === $nameSpaceSlug) {
                            $user = $u;
                            break;
                        }
                    }
                }
                if ($user) {
                    $member = Member::where('userId', $user->id)->first();
                }
            }

            if ($member && !$user) {
                $user = $member->user;
            }

            if (!$member && !$user) {
                if (Auth::check()) {
                    $user = Auth::user();
                    $member = Member::where('userId', $user->id)->first();
                }
                if (!$member) {
                    $member = Member::where('status', 'Active')->first() ?? Member::first();
                }
                if ($member && !$user) {
                    $user = $member->user;
                }
                if (!$user) {
                    $user = User::first();
                }
            }

            // Fetch related data
            $contactDetails = $member ? ContactDetails::where('memberId', $member->id)->first() : null;
            $billing = $member ? BillingAddress::where('memberId', $member->id)->first() : null;
            $tops = $member ? TopsProfile::where('memberId', $member->id)->first() : null;
            $galleryImages = $member ? MemberGallery::where('memberId', $member->id)->where('status', 'Active')->get() : collect();
            $city = $member && $member->cityId ? City::find($member->cityId) : null;
            $state = $city && $city->stateId ? State::find($city->stateId) : null;
            $country = $state && $state->countryId ? Country::find($state->countryId) : null;
            $circle = $member && $member->circleId ? Circle::find($member->circleId) : null;

            // User posts from Social Wall
            $posts = $user ? Post::where('userId', $user->id)->latest()->take(5)->get() : collect();

            // Other members for "More profiles for you"
            $otherMembers = Member::where('status', 'Active')
                ->when($member, function ($q) use ($member) {
                    return $q->where('id', '!=', $member->id);
                })
                ->inRandomOrder()
                ->take(5)
                ->get();

            $isSelfProfile = Auth::check() && $user && (Auth::id() == $user->id);

            return view('visitor.linkedinProfile', compact(
                'member',
                'user',
                'contactDetails',
                'billing',
                'tops',
                'galleryImages',
                'city',
                'state',
                'country',
                'circle',
                'posts',
                'otherMembers',
                'isSelfProfile'
            ));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }
}
