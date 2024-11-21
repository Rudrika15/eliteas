<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Utils\Utils;
use App\Models\Member;
use App\Models\TopsProfile;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
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
            $roles = Auth::user()->getRoleNames();
            // $permissions = $user->getAllPermissions();
            $token = $user->createToken('authToken')->plainTextToken;

            return Utils::sendResponse(['token' => $token, 'user' => $user, 'roles' => $roles], 'Success');
        }

        return Utils::sendResponse(['error' => 'Unauthorized'], 401);
    }

    public function getRolePermissions()
    {
        // Fetch all roles that are active
        $roles = Role::get();

        // Prepare an array to store roles with their permissions
        $rolePermissions = [];

        // Iterate through roles and fetch permissions for each role
        foreach ($roles as $role) {
            // Fetch permissions associated with the role that are also active
            $permissions = $role->permissions()->where('status', 'Active')->get();

            // Add role and associated active permissions to the array
            $rolePermissions[] = [
                'role' => $role->name,
                'permissions' => $permissions->map(function ($permission) {
                    return [
                        'id' => $permission->id,
                        'name' => $permission->name,
                    ];
                })
            ];
        }

        // Return the response with roles and their active permissions
        return Utils::sendResponse($rolePermissions, 'Role and Permission List');
    }


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


    // public function memberUpdate(Request $request)
    // {
    //     $user = Auth::user();


    //     $member = Member::where('userId', $user->id)->first();

    //     if (!$member) {
    //         return Utils::errorResponse(['error' => 'Member not found'], 404);
    //     }

    //     $updatedFields = array_filter($request->all());


    //     foreach ($updatedFields as $key => $value) {
    //         $member->{$key} = $value;
    //     }

    //     $member->save();

    //     return Utils::sendResponse([$member, 'message' => 'Your Profile data updated successfully'], 200);
    // }



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

    //admin side profile edit or update

    public function memberUpdateAdmin(Request $request, $id)
    {
        $this->validate($request, [
            // Add your validation rules here
        ]);

        try {
            $member = Member::findOrFail($id);
            $member->title = $request->input('title', $member->title);
            $member->firstName = $request->input('firstName', $member->firstName);
            $member->lastName = $request->input('lastName', $member->lastName);
            $member->username = $request->input('username', $member->username);
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

            // $member->profilePhoto = $request->input('profilePhoto', $member->profilePhoto);

            if ($request->profilePhoto) {
                $member->profilePhoto = time() . '.' . $request->profilePhoto->extension();
                $request->profilePhoto->move(public_path('ProfilePhoto'),  $member->profilePhoto);
            }


            // $member->companyLogo = $request->input('companyLogo', $member->companyLogo);

            if ($request->companyLogo) {
                $member->companyLogo = time() . '.' . $request->companyLogo->extension();
                $request->companyLogo->move(public_path('ProfilePhoto'),  $member->companyLogo);
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


            return Utils::sendResponse([$member, $tops, $contact, $billing, 'message' => 'Member Profile data updated successfully'], 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => 'Member Profile not found'], 404);
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
        $member->birthDate  = $request->input('birthDate', $member->birthDate);
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
}
