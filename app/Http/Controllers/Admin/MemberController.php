<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\State;
use App\Models\Member;
use App\Models\Country;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $member = Member::all();
            return view('userrs.member.index', compact('member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            return view('userrs.member.create');
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'displayName' => 'required',
            'gender' => 'required',
            'username' => 'required',
            'profilePhoto' => 'required',
        ]);
        try {
            $member = new Member();
            $member->userId = $request->userId;
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
            $member->profilePhoto = $request->profilePhoto;
            $member->companyLogo = $request->companyLogo;
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
            $contact->email = $request->email;
            $contact->showEmail = $request->showEmail;
            $contact->addressLine1 = $request->addressLine2;
            $contact->addressLine2 = $request->addressLine2;
            $contact->profileAddress = $request->profileAddress;
            $contact->city = $request->city;
            $contact->state = $request->state;
            $contact->country = $request->country;
            $contact->pinCode = $request->pinCode;
            $contact->status = 'Active';

            $contact->save();


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



            return redirect()->route('members.index')->with('success', 'Member Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
                $member = Member::find($id);
                $country = Country::where('status', 'Active')->get();
                $state = State::where('status', 'Active')->get();
                $city = City::where('status', 'Active')->get();
                $contactDetails = ContactDetails::find($id);
                $billing = BillingAddress::find($id);
                $tops = TopsProfile::find($id);
            return view('userrs.member.edit', compact('country', 'state', 'city', 'member', 'contactDetails', 'billing', 'tops'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, []);
        try {



            return redirect()->route('members.index')->with('success', 'Member Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function updateProfile(Request $request)
    {

    }



}
