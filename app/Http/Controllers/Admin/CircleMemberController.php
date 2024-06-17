<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\CircleCall;
use App\Models\TopsProfile;
use Illuminate\Support\Str;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Models\MembershipType;
use App\Mail\WelcomeMemberEmail;
use App\Mail\MemberSubscription;
use App\Mail\MemberSubscriptionDiscount;
use App\Models\BusinessCategory;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\AllPayments;
use App\Models\MemberSubscriptions;
use App\Models\Razorpay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CircleMemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            // $member = Member::findOrFail($user->id);
            $member = Member::whereHas('circle')->with('circle')->whereHas('contactDetails')->with('contactDetails')->with('user')->with('topsProfile')->with('billingAddress')->get();
            $circle = Circle::where('status', 'Active')->get();
            $bCategory = BusinessCategory::where('status', 'Active')->get();
            $roles = Role::whereNotIn('name', ['Admin', 'Member', 'Trainer', 'Franchise '])->get();
            return view('admin.circlemember.index', compact('member', 'roles', 'circle', 'bCategory'));
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
            // throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $businessCategory = BusinessCategory::where('status', 'Active')->get();
            $circle = Circle::where('status', 'Active')->get();
            $member = Member::where('status', 'Active')->get();
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            $membershipType = MembershipType::where('status', 'Active')->get();
            return view('admin.circlemember.create', compact('circle', 'membershipType', 'member', 'countries', 'states', 'cities', 'businessCategory'));
        } catch (\Throwable $th) {
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'title' => 'required',
            'circleId' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|unique:users,email',
            'gender' => 'required',
            'mobileNo' => 'required|unique:users,contactNo',
        ]);

        try {
            // Generate random password
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            $password = '';
            $length = 8;
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }
            $rowPassword = $password;

            // Create and save the user
            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->contactNo = $request->mobileNo;
            $user->password = Hash::make($rowPassword);
            $user->assignRole('Member');
            $user->save();

            // Create and save the member
            $member = new Member();
            $member->circleId = $request->circleId;
            $member->userId = $user->id;
            $member->title = $request->title;
            $member->username = $request->username;
            $member->businessCategoryId = $request->businessCategory;
            $member->firstName = $request->firstName;
            $member->lastName = $request->lastName;
            $member->gender = $request->gender;
            $member->membershipType = $request->membershipType;

            // Set membership amount
            $membershipType = MembershipType::findOrFail($request->membershipType);
            if ($request->has('discountAmount') && $request->has('totalAmount')) {
                $member->membershipAmount = $request->totalAmount;
            } else {
                $member->membershipAmount = $membershipType->amount;
            }

            $member->status = 'Active';
            $member->save();

            // Create and save TopsProfile
            $tops = new TopsProfile();
            $tops->memberId = $member->id;
            $tops->status = 'Active';
            $tops->save();

            // Create and save ContactDetails
            $contact = new ContactDetails();
            $contact->memberId = $member->id;
            $contact->mobileNo = $request->mobileNo;
            $contact->status = 'Active';
            $contact->save();

            // Create and save BillingAddress
            $billing = new BillingAddress();
            $billing->memberId = $member->id;
            $billing->status = 'Active';
            $billing->save();

            // Determine paymentId
            $paymentId = $request->has('paymentModeCheck') ? 'At Office' : $request->paymentId;

            // Create and save MemberSubscriptions
            $payment = new MemberSubscriptions();
            $payment->userId = $user->id;
            $payment->paymentId = $paymentId;
            $payment->membershipType = $member->membershipType;
            $payment->paymentMode = $request->has('paymentMode') ? $request->paymentMode : 'Online';

            if ($member->membershipType == 'Monthly') {
                $payment->validity = now()->addMonth()->format('d-m-Y');
            } elseif ($member->membershipType == 'Yearly') {
                $payment->validity = now()->addYear()->format('d-m-Y');
            }

            $payment->paymentDate = $request->date;

            $payment->status = 'Active';
            $payment->save();

            $amount = $member->membershipAmount;

            $totalAmount = $member->totalAmount;

            $originalAmount = $request->membershipAmount;

            $data = [
                'email' => $user->email,
                'amount' => $amount,
                'totalAmount' => $totalAmount,
                'originalAmount' => $originalAmount,
                'membershipType' => $payment->membershipType,
            ];

            if ($request->has('totalAmount') && $request->has('sendMail')) {
                Mail::to($user->email)->send(new MemberSubscriptionDiscount($data));
            } elseif ($request->has('sendMail')) {
                Mail::to($user->email)->send(new MemberSubscription($data));
            }

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function memberPayment($paymentData)
    {
        try {
            $data = Crypt::decrypt($paymentData);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404);
        }

        if (!$data) {
            abort(404);
        }

        return view('admin.memberPayment', compact('data'));
    }


    public function getMembershipAmount(Request $request)
    {
        $membershipTypeId = $request->membershipTypeId;
        $membershipType = MembershipType::find($membershipTypeId); // Adjust according to your model

        if ($membershipType) {
            return response()->json(['amount' => $membershipType->amount]);
        } else {
            return response()->json(['amount' => '']);
        }
    }




    public function edit($id)
    {
        try {
            $user = User::find($id);
            $member = Member::find($id);
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            $contactDetails = ContactDetails::where('memberId', $id)->first();
            $billing = BillingAddress::where('memberId', $id)->first();
            $tops = TopsProfile::where('memberId', $id)->first();
            $circles = Circle::where('status', 'Active')->get();
            $businessCategory = BusinessCategory::where('status', 'Active')->get();
            $membershipType = MembershipType::where('status', 'Active')->get();


            return view('admin.circlemember.edit', compact('countries', 'membershipType', 'user', 'states', 'cities', 'member', 'contactDetails', 'billing', 'tops', 'circles', 'businessCategory'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function update(Request $request)
    {
        try {
            // return $request;
            // Find the member
            // return $member = $request->memberId;
            // $memberId = $request->memberId;
            $member = $request->id;
            // Update only the fields that have new values
            //   return   $user = User::findOrFail($id);
            //     $user->firstName = $request->firstName;
            //     $user->lastName = $request->lastName;
            //     // $user->email = $request->email;
            //     $user->password = Hash::make($request->password);
            //     $user->assignRole('Member');
            //     $user->save();

            // Update the member
            $member = Member::findOrFail($member);
            $member->circleId = $request->circleId;
            $member->title = $request->title;
            $member->firstName = $request->firstName;
            $member->lastName = $request->lastName;
            $member->username = $request->username;
            $member->businessCategoryId = $request->businessCategory;
            $member->suffix = $request->suffix;
            $member->displayName = $request->displayName;
            $member->gstRegiState = $request->gstRegiState;
            $member->gStinPan = $request->gStinPan;
            $member->industry = $request->industry;
            $member->classification = $request->classification;
            $member->gender = $request->gender;
            $member->language = $request->language;
            $member->timeZone = $request->timeZone;

            if ($request->hasFile('profilePhoto')) {
                $profilePhoto = $request->file('profilePhoto');
                $profilePhotoName = time() . '.' . $profilePhoto->extension();
                $profilePhoto->move(public_path('ProfilePhoto'), $profilePhotoName);
                $member->profilePhoto = $profilePhotoName;
            }

            // CompanyLogo upload
            if ($request->hasFile('companyLogo')) {
                $companyLogo = $request->file('companyLogo');
                $companyLogoName = time() . '.' . $companyLogo->extension();
                $companyLogo->move(public_path('CompanyLogo'), $companyLogoName);
                $member->companyLogo = $companyLogoName;
            }

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
            $member->membershipType = $request->membershipType;
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
            // $contact = ContactDetails::where('memberId', $member->id)->firstOrFail();
            $contact = ContactDetails::findOrFail($member->id);

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
            // $contact->profileAddress = $request->profileAddress;
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


            return redirect()->route('circlemember.index')->with('success', 'Member Updated Successfully!');
        } catch (\Throwable $th) {
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
            // throw $th;
            return view('servererror');
        }
    }

    public function activity()
    {
        try {
            $circlecall = CircleCall::where('status', 'Active')
                ->where('memberId', 'userId')
                ->get();
            return view('admin.circlemember.activity', compact('circlecall'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function assignRole(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'memberId' => 'required|exists:circle_members,id',
            'roleId' => 'required|exists:roles,id',
        ]);

        // Find the circle member
        $member = CircleMember::findOrFail($request->memberId);

        // Find the role
        $role = Role::findOrFail($request->roleId);

        // Attach the role to the user (assuming the relationship is defined)
        $member->user->roles()->attach($role);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }

    public function removeRole(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'memberId' => 'required|exists:circle_members,id',
            'roleId' => 'required|exists:roles,id',
        ]);

        // Find the circle member
        $member = CircleMember::findOrFail($request->memberId);

        // Find the role
        $role = Role::findOrFail($request->roleId);

        // Detach the role from the user (assuming the relationship is defined)
        $member->user->roles()->detach($role);

        return redirect()->back()->with('success', 'Role removed successfully.');
    }
}
