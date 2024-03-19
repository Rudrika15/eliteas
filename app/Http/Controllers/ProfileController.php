<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Member;
use App\Models\Country;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function member($id = 0)
    {
        try {
            if ($id === 0) {
                // If no $id is provided, fetch the currently authenticated user's ID
                $id = Auth::user()->id;
            }

            // Fetch profile data based on the provided $id
            $member = Member::where('userId', '=', $id)->first(); // Assuming userId column stores user ID
            $country = Country::where('status', 'Active')->get();
            $state = State::where('status', 'Active')->get();
            $city = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::find($id);
            $billing = BillingAddress::find($id);
            $tops = TopsProfile::find($id);

            return view('profile', compact('member', 'country', 'state', 'city', 'contactDetails', 'billing', 'tops'));
        } catch (\Throwable $th) {
            // In case of an error, redirect to servererror view
            return view('servererror');
        }
    }


    public function memberUpdate(Request $request)
    {
        try {
            if ($userId = $request->userId) {
                $user = User::find($userId);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->save();

                $id = $request->id;
                $member = Member::find($id);
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

                $tops = TopsProfile::find($id);
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

                $contact = ContactDetails::find($id);
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

                $billing = BillingAddress::find($id);
                $billing->bAddressLine1 = $request->bAddressLine1;
                $billing->bAddressLine2 = $request->bAddressLine2;
                $billing->bCity = $request->bCity;
                $billing->bState = $request->bState;
                $billing->bCountry = $request->bCountry;
                $billing->bPinCode = $request->bPinCode;
                $billing->status = 'Active';

                $billing->save();

                return redirect('/home');
            }
        } catch (Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }
}
