<?php

namespace App\Http\Controllers;

use Throwable;
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
            $user = User::where('id', '=', $id)->first();
            $member = Member::where('userId', '=', $id)->first(); // Assuming userId column stores user ID
            $country = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $city = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::where('memberId', $member->id)->first();
            $billing = BillingAddress::where('memberId', $member->id)->first();
            $tops = TopsProfile::where('memberId', $member->id)->first();

            return view('profile', compact('member', 'user', 'country', 'states', 'city', 'contactDetails', 'billing', 'tops'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            // In case of an error, redirect to servererror view
            return view('servererror');
        }
    }


    public function memberUpdate(Request $request)
    {
        // return $request;

        try {
            $this->validate($request, [
                'profilePhoto' => 'max:2048', // 5MB in kilobytes
                'companyLogo' => 'max:2048', // 5MB in kilobytes
            ]);

            $id = $request->input('id');
            $member = Member::find($id);

            $member->title = $request->title;
            $member->firstName = $request->firstName;
            $member->lastName = $request->lastName;
            $member->username = $request->username;
            // $member->email = $request->email;
            // $member->suffix = $request->suffix;
            // $member->displayName = $request->displayName;
            // $member->gstRegiState = $request->gstRegiState;
            $member->gStinPan = $request->gStinPan;
            // $member->industry = $request->industry;
            // $member->classification = $request->classification;
            $member->gender = $request->gender;
            // $member->language = $request->language;
            // $member->timeZone = $request->timeZone;

            if ($request->profilePhoto) {
                $member->profilePhoto = time() . '.' . $request->profilePhoto->extension();
                $request->profilePhoto->move(public_path('ProfilePhoto'), $member->profilePhoto);
            }

            if ($request->companyLogo) {
                $member->companyLogo = time() . '.' . $request->companyLogo->extension();
                $request->companyLogo->move(public_path('CompanyLogo'), $member->companyLogo);
            }

            // $member->goals = $request->goals;
            // $member->chapter = $request->chapter;
            // $member->renewalDueDate = $request->renewalDueDate;
            // $member->accomplishment = $request->accomplishment;
            $member->companyName = $request->companyName;
            // $member->interests = $request->interests;
            // $member->networks = $request->networks;
            // $member->skills = $request->skills;
            // $member->myBusiness = $request->myBusiness;
            $member->webSite = $request->webSite;
            // $member->showWebsite = $request->showWebsite;
            // $member->socialLinks = $request->socialLinks;
            // $member->showSocialLinks = $request->showSocialLinks;
            // $member->receiveUpdates = $request->receiveUpdates;
            // $member->shareRevenue = $request->shareRevenue;
            // $member->membershipStatus = $request->membershipStatus;
            // $member->keyWords = $request->keyWords;
            $member->status = 'Active';
            $member->save();


            $user = User::find(Auth::id());

            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->contactNo = $request->contactNo;
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
            $tops->status = 'Active';

            $tops->save();

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
            $contact->email = $request->email;
            // $contact->showEmail = $request->showEmail;
            $contact->addressLine1 = $request->addressLine1;
            $contact->addressLine2 = $request->addressLine2;
            // $contact->profileAddress = $request->profileAddress;
            // $contact->city = $request->city;
            // $contact->state = $request->state;
            // $contact->country = $request->country;
            // $contact->pinCode = $request->pinCode;
            $contact->status = 'Active';

            $contact->save();

            $billing = BillingAddress::where('memberId', $member->id)->first();
            // $billing->bAddressLine1 = $request->bAddressLine1;
            // $billing->bAddressLine2 = $request->bAddressLine2;
            // $billing->bCity = $request->bCity;
            // $billing->bState = $request->bState;
            // $billing->bCountry = $request->bCountry;
            // $billing->bPinCode = $request->bPinCode;
            $billing->status = 'Active';

            $billing->save();



            return redirect()->route('home')->with('success', 'Profile Updated Successfully!');
        } catch (Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
}
