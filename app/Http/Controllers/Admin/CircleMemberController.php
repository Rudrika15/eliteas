<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\TopsProfile;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CircleMemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circlemember = CircleMember::with('circle')
                ->with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlemember.index', compact('circlemember'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $circlemember = CircleMember::findOrFail($id);
            return response()->json($circlemember);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $circle = Circle::where('status', 'Active')->get();
            $member = Member::where('status', 'Active')->get();
            // $city = City::with('country')
            //     ->with('state')
            //     ->get();
            return view('admin.circlemember.create', compact('circle', 'member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'circleId' => 'required',
            // Add validation rules for other fields if necessary
        ]);

        try {
            // Create and save the user
            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('Member');
            $user->save();

            // Create and save the member
            $member = new Member();
            $member->circleId = $request->circleId;
            $member->userId = $user->id;
            $member->title = $request->title;
            $member->firstName = $request->firstName;
            $member->lastName = $request->lastName;
            $member->username = $request->username;
            $member->suffix = $request->suffix;
            $member->displayName = $request->displayName;
            $member->gstRegiState = $request->gstRegiState;
            $member->gStinPan = $request->gStinPan;
            $member->industry = $request->industry;
            $member->classification = $request->classification;
            $member->gender = $request->gender;
            $member->language = $request->language;
            $member->timeZone = $request->timeZone;
            
            if ($request->profilePhoto) {
                $member->profilePhoto = time() . '.' . $request->profilePhoto->extension();
                $request->profilePhoto->move(public_path('ProfilePhoto'),  $member->profilePhoto);
            }


            // $member->profilePhoto = $request->profilePhoto;


            if ($request->companyLogo) {
                $member->companyLogo = time() . '.' . $request->companyLogo->extension();
                $request->companyLogo->move(public_path('CompanyLogo'),  $member->companyLogo);
            }

            // $member->companyLogo = $request->companyLogo;

            $member->goals = $request->goals;
            $member->chapter = $request->chapter;
            $member->renewalDueDate = $request->renewalDueDate;
            $member->accomplishment = $request->accomplishment;
            $member->companyName = $request->companyName;
            $member->interests = $request->interests;
            $member->networks = $request->networks;
            $member->skills = $request->skills;
            $member->myBusiness = $request->myBusiness;
            $member->webSite = $request->webSite;
            $member->showWebsite = $request->showWebsite;
            $member->socialLinks = $request->socialLinks;
            $member->showSocialLinks = $request->showSocialLinks;
            $member->receiveUpdates = $request->receiveUpdates;
            $member->shareRevenue = $request->shareRevenue;
            $member->membershipStatus = $request->membershipStatus;
            $member->keyWords = $request->keyWords;
            $member->status = 'Active';
            $member->save();

            // Create and save TopsProfile
            $tops = new TopsProfile();
            $tops->memberId = $member->id;
            $tops->idealRef = $request->idealRef;
            $tops->topProduct = $request->topProduct;
            $tops->topProblemSolved = $request->topProblemSolved;
            $tops->myFavBNIStory = $request->myFavBNIStory;
            $tops->myIdealRefPartner = $request->myIdealRefPartner;
            $tops->weeklyPresent1 = $request->weeklyPresent1;
            $tops->weeklyPresent2 = $request->weeklyPresent2;
            $tops->yearsInBusiness = $request->yearsInBusiness;
            $tops->prevJobs = $request->prevJobs;
            $tops->spouse = $request->spouse;
            $tops->children = $request->children;
            $tops->pets = $request->pets;
            $tops->hobbiesInterests = $request->hobbiesInterests;
            $tops->cityofRes = $request->cityofRes;
            $tops->yearsInCity = $request->yearsInCity;
            $tops->myBurningDesire = $request->myBurningDesire;
            $tops->dontKnowAboutMe = $request->dontKnowAboutMe;
            $tops->mKeyToSuccess = $request->mKeyToSuccess;
            $tops->status = 'Active';
            $tops->save();

            // Create and save ContactDetails
            $contact = new ContactDetails();
            $contact->memberId = $member->id;
            $contact->showMeOnPublicWeb = $request->showMeOnPublicWeb;
            $contact->billingAddress = $request->billingAddress;
            $contact->phone = $request->phone;
            $contact->showPhone = $request->showPhone;
            $contact->directNo = $request->directNo;
            $contact->showDirectNo = $request->showDirectNo;
            $contact->home = $request->home;
            $contact->mobileNo = $request->mobileNo;
            $contact->showMobileNo = $request->showMobileNo;
            $contact->pager = $request->pager;
            $contact->voiceMail = $request->voiceMail;
            $contact->tollFree = $request->tollFree;
            $contact->showTollFree = $request->showTollFree;
            $contact->fax = $request->fax;
            $contact->showFax = $request->showFax;
            $contact->email = $request->contactEmail;
            $contact->showEmail = $request->showEmail;
            $contact->addressLine1 = $request->addressLine2;
            $contact->addressLine2 = $request->addressLine2;
            // $contact->profileAddress = $request->profileAddress;
            $contact->city = $request->city;
            $contact->state = $request->state;
            $contact->country = $request->country;
            $contact->pinCode = $request->pinCode;
            $contact->status = 'Active';
            $contact->save();

            // Create and save BillingAddress
            $billing = new BillingAddress();
            $billing->memberId = $member->id;
            $billing->bAddressLine1 = $request->bAddressLine1;
            $billing->bAddressLine2 = $request->bAddressLine2;
            $billing->bCity = $request->bCity;
            $billing->bState = $request->bState;
            $billing->bCountry = $request->bCountry;
            $billing->bPinCode = $request->bPinCode;
            $billing->status = 'Active';
            $billing->save();

            // Now, create and save the circle member
            $circlemember = new CircleMember();
            $circlemember->circleId = $request->circleId;
            $circlemember->memberId = $member->id; // Set the member ID from the saved member
            $circlemember->status = 'Active';
            $circlemember->save();

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Created Successfully!');
        } catch (\Throwable $th) {
            // Handle
            throw $th;
            return view('servererror');
        }
    }


    public function edit($id)
    {
        try {
            // Retrieve the circle member to edit
            $circlemember = CircleMember::find($id);

            // Retrieve related data for dropdowns and fields
            $country = Country::where('status', 'Active')->get();
            $state = State::where('status', 'Active')->get();
            $city = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::where('memberId', $id)->first();
            $billing = BillingAddress::where('memberId', $id)->first();
            $tops = TopsProfile::where('memberId', $id)->first();
            $member = Member::where('status', 'Active')->get();
            $circles = Circle::where('status', 'Active')->get();

            // Pass data to the view for editing
            return view('admin.circlemember.edit', compact('circles', 'circlemember', 'member', 'country', 'state', 'city', 'contactDetails', 'billing', 'tops'));
        } catch (\Throwable $th) {
            // Handle exceptions appropriately
            throw $th;
            return view('servererror');
        }
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'circleId' => 'required',
            // Add validation rules for other fields if necessary
        ]);

        try {
            // Retrieve the circle member to update
            $circlemember = CircleMember::findOrFail($id);

            // Update the user
            $user = User::findOrFail($circlemember->memberId);
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('Member');
            $user->save();

            // Update the member
            $member = Member::findOrFail($user->id);
            $member->circleId = $request->circleId;
            $member->title = $request->title;
            $member->firstName = $request->firstName;
            $member->lastName = $request->lastName;
            $member->username = $request->username;
            $member->suffix = $request->suffix;
            $member->displayName = $request->displayName;
            $member->gstRegiState = $request->gstRegiState;
            $member->gStinPan = $request->gStinPan;
            $member->industry = $request->industry;
            $member->classification = $request->classification;
            $member->gender = $request->gender;
            $member->language = $request->language;
            $member->timeZone = $request->timeZone;
            
            if ($request->profilePhoto) {
                $member->profilePhoto = time() . '.' . $request->profilePhoto->extension();
                $request->profilePhoto->move(public_path('ProfilePhoto'),  $member->profilePhoto);
            }


            // $member->profilePhoto = $request->input('profilePhoto', $member->profilePhoto);

            if ($request->companyLogo) {
                $member->companyLogo = time() . '.' . $request->companyLogo->extension();
                $request->companyLogo->move(public_path('CompanyLogo'),  $member->companyLogo);
            }



            // $member->companyLogo = $request->input('companyLogo', $member->companyLogo);

            $member->goals = $request->goals;
            $member->chapter = $request->chapter;
            $member->renewalDueDate = $request->renewalDueDate;
            $member->accomplishment = $request->accomplishment;
            $member->companyName = $request->companyName;
            $member->interests = $request->interests;
            $member->networks = $request->networks;
            $member->skills = $request->skills;
            $member->myBusiness = $request->myBusiness;
            $member->webSite = $request->webSite;
            $member->showWebsite = $request->showWebsite;
            $member->socialLinks = $request->socialLinks;
            $member->showSocialLinks = $request->showSocialLinks;
            $member->receiveUpdates = $request->receiveUpdates;
            $member->shareRevenue = $request->shareRevenue;
            $member->membershipStatus = $request->membershipStatus;
            $member->keyWords = $request->keyWords;
            $member->status = 'Active';
            $member->save();

            // Update TopsProfile
            $tops = TopsProfile::where('memberId', $member->id)->firstOrFail();
            $tops->idealRef = $request->idealRef;
            $tops->topProduct = $request->topProduct;
            $tops->topProblemSolved = $request->topProblemSolved;
            $tops->myFavBNIStory = $request->myFavBNIStory;
            $tops->myIdealRefPartner = $request->myIdealRefPartner;
            $tops->weeklyPresent1 = $request->weeklyPresent1;
            $tops->weeklyPresent2 = $request->weeklyPresent2;
            $tops->yearsInBusiness = $request->yearsInBusiness;
            $tops->prevJobs = $request->prevJobs;
            $tops->spouse = $request->spouse;
            $tops->children = $request->children;
            $tops->pets = $request->pets;
            $tops->hobbiesInterests = $request->hobbiesInterests;
            $tops->cityofRes = $request->cityofRes;
            $tops->yearsInCity = $request->yearsInCity;
            $tops->myBurningDesire = $request->myBurningDesire;
            $tops->dontKnowAboutMe = $request->dontKnowAboutMe;
            $tops->mKeyToSuccess = $request->mKeyToSuccess;
            $tops->status = 'Active';
            $tops->save();

            // Update ContactDetails
            $contact = ContactDetails::where('memberId', $member->id)->firstOrFail();
            $contact->showMeOnPublicWeb = $request->showMeOnPublicWeb;
            $contact->billingAddress = $request->billingAddress;
            $contact->phone = $request->phone;
            $contact->showPhone = $request->showPhone;
            $contact->directNo = $request->directNo;
            $contact->showDirectNo = $request->showDirectNo;
            $contact->home = $request->home;
            $contact->mobileNo = $request->mobileNo;
            $contact->showMobileNo = $request->showMobileNo;
            $contact->pager = $request->pager;
            $contact->voiceMail = $request->voiceMail;
            $contact->tollFree = $request->tollFree;
            $contact->showTollFree = $request->showTollFree;
            $contact->fax = $request->fax;
            $contact->showFax = $request->showFax;
            $contact->email = $request->email;
            $contact->showEmail = $request->showEmail;
            $contact->addressLine1 = $request->addressLine1;
            $contact->addressLine2 = $request->addressLine2;
            $contact->profileAddress = $request->profileAddress;
            $contact->city = $request->city;
            $contact->state = $request->state;
            $contact->country = $request->country;
            $contact->pinCode = $request->pinCode;
            $contact->status = 'Active';
            $contact->save();

            // Update BillingAddress
            $billing = BillingAddress::where('memberId', $member->id)->firstOrFail();
            $billing->bAddressLine1 = $request->bAddressLine1;
            $billing->bAddressLine2 = $request->bAddressLine2;
            $billing->bCity = $request->bCity;
            $billing->bState = $request->bState;
            $billing->bCountry = $request->bCountry;
            $billing->bPinCode = $request->bPinCode;
            $billing->status = 'Active';
            $billing->save();

            // Update the circle member
            // $circlemember->circleId = $request->circleId;
            // $circlemember->status = 'Active';
            // $circlemember->save();

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Updated Successfully!');
        } catch (\Throwable $th) {
            // Handle exceptions appropriately
            throw $th;
            return view('servererror');
        }
    }


    function delete($id)
    {
        try {
            $circlemember = CircleMember::find($id);
            $circlemember->status = "Deleted";
            $circlemember->save();

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
