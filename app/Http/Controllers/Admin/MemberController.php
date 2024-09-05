<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Member;
use App\Models\Country;
use App\Utils\ErrorLogger;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $member = Member::all(); // show only 10 record per page
            return view('userrs.member.index', compact('member'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            return view('userrs.member.create', compact('countries', 'states', 'cities'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );

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
            'email' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
        ]);
        try {

            // user table entry
            // role = Memebr

            // Create user
            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('Member');
            $user->save(); // 

            $member = new Member();
            $member->userId = $user->id; // Access user ID after saving
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
            $contact->email = $request->conEmail;
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
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $member = Member::find($id);
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::where('memberId', $id)->first();
            $billing = BillingAddress::where('memberId', $id)->first();
            $tops = TopsProfile::where('memberId', $id)->first();
            return view('userrs.member.edit', compact('countries', 'states', 'cities', 'member', 'contactDetails', 'billing', 'tops'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }



    public function show($id)
    {
        try {
            $member = Member::find($id);
            $country = Country::where('status', 'Active')->get();
            $state = State::where('status', 'Active')->get();
            $city = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::where('memberId', $id)->first();
            $billing = BillingAddress::where('memberId', $id)->first();
            $tops = TopsProfile::where('memberId', $id)->first();
            return view('userrs.member.show', compact('country', 'state', 'city', 'member', 'contactDetails', 'billing', 'tops'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }



    public function update(Request $request, $id)
    {
        try {
            // Find the member
            $member = Member::find($id);

            // Update only the fields that have new values
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
            // Continue updating other fields...

            $member->save();

            // Update the other models in a similar manner
            $tops = TopsProfile::where('memberId', $id)->first();
            $tops->idealRef = $request->input('idealRef', $tops->idealRef);
            $tops->topProduct = $request->input('topProduct', $tops->topProduct);
            $tops->topProblemSolved = $request->input('topProblemSolved', $tops->topProblemSolved);
            $tops->myFavBniStory = $request->input('myFavBniStory', $tops->myFavBniStory);
            $tops->myIdealRefPartner = $request->input('myIdealRefPartner', $tops->myIdealRefPartner);
            $tops->weeklyPresent1 = $request->input('weeklyPresent1', $tops->weeklyPresent1);
            $tops->weeklyPresent2 = $request->input('weeklyPresent2', $tops->weeklyPresent2);
            $tops->yearsInBusiness = $request->input('yearsInBusiness', $tops->yearsInBusiness);
            $tops->prevJobs = $request->input('prevJobs', $tops->prevJobs);
            $tops->spouse = $request->input('spouse', $tops->spouse);
            $tops->children = $request->input('children', $tops->children);
            $tops->pets = $request->input('pets', $tops->pets);
            $tops->hobbiesInterests = $request->input('hobbiesInterests', $tops->hobbiesInterests);
            $tops->yearsInCity = $request->input('yearsInCity', $tops->yearsInCity);
            $tops->cityofRes = $request->input('cityofRes', $tops->cityofRes);
            $tops->myBurningDesire = $request->input('myBurningDesire', $tops->myBurningDesire);
            $tops->dontKnowAboutMe = $request->input('dontKnowAboutMe', $tops->dontKnowAboutMe);
            $tops->mKeyToSuccess = $request->input('mKeyToSuccess', $tops->mKeyToSuccess);
            $tops->save();

            $contact = ContactDetails::where('memberId', $id)->first();
            $contact->showMeOnPublicWeb = $request->input('showMeOnPublicWeb', $contact->showMeOnPublicWeb);
            $contact->billingAddress = $request->input('billingAddress', $contact->billingAddress);
            $contact->phone = $request->input('phone', $contact->phone);
            $contact->showPhone = $request->input('showPhone', $contact->showPhone);
            $contact->directNo = $request->input('directNo', $contact->directNo);
            $contact->showDirectNo = $request->input('showDirectNo', $contact->showDirectNo);
            $contact->home = $request->input('home', $contact->home);
            $contact->mobileNo = $request->input('mobileNo', $contact->mobileNo);
            $contact->showMobileNo = $request->input('showMobileNo', $contact->showMobileNo);
            $contact->pager = $request->input('pager', $contact->pager);
            $contact->voiceMail = $request->input('voiceMail', $contact->voiceMail);
            $contact->tollFree = $request->input('tollFree', $contact->tollFree);
            $contact->showTollFree = $request->input('showTollFree', $contact->showTollFree);
            $contact->fax = $request->input('fax', $contact->fax);
            $contact->showFax = $request->input('showFax', $contact->showFax);
            $contact->email = $request->input('email', $contact->email);
            $contact->showEmail = $request->input('showEmail', $contact->showEmail);
            $contact->addressLine1 = $request->input('addressLine1', $contact->addressLine1);
            $contact->addressLine2 = $request->input('addressLine2', $contact->addressLine2);
            $contact->addressShow = $request->input('addressShow', $contact->addressShow);
            $contact->city = $request->input('city', $contact->city);
            $contact->state = $request->input('state', $contact->state);
            $contact->country = $request->input('country', $contact->country);
            $contact->pinCode = $request->input('pinCode', $contact->pinCode);
            $contact->save();

            $billing = BillingAddress::where('memberId', $id)->first();
            $billing->bAddressLine1 = $request->input('bAddressLine1', $billing->bAddressLine1);
            $billing->bAddressLine2 = $request->input('bAddressLine2', $billing->bAddressLine2);
            $billing->bCity = $request->input('bCity', $billing->bCity);
            $billing->bState = $request->input('bState', $billing->bState);
            $billing->bCountry = $request->input('bCountry', $billing->bCountry);
            $billing->bPinCode = $request->input('bPinCode', $billing->bPinCode);
            $billing->save();


            return redirect()->route('members.index')->with('success', 'Member Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
}
