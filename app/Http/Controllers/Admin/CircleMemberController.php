<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\Razorpay;
use App\Models\CircleCall;
use App\Models\Connection;
use App\Utils\ErrorLogger;
use App\Models\AllPayments;
use App\Models\TopsProfile;
use Illuminate\Support\Str;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Models\BillingAddress;
use App\Models\ContactDetails;
use App\Models\MembershipType;
use App\Mail\MemberSubscription;
use App\Mail\WelcomeMemberEmail;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\MemberSubscriptions;
use Illuminate\Support\Facades\URL;
use App\Exports\CircleMembersExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Mail\MemberSubscriptionDiscount;
use App\Models\circleAdmin;
use App\Models\CircleMeetingMembersBusiness;
use App\Models\CircleMeetingMembersReference;
use Illuminate\Support\Facades\Auth;

class CircleMemberController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle member-related permissions
        $this->middleware('permission:circle-member-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:circle-member-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:circle-member-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:circle-member-delete', ['only' => ['delete']]);
        $this->middleware('permission:circle-member-filter', ['only' => ['filter']]);
        $this->middleware('permission:circle-member-payment', ['only' => ['memberPayment']]);
        $this->middleware('permission:get-membership-amount', ['only' => ['getMembershipAmount']]);
        $this->middleware('permission:circle-members-activity', ['only' => ['activity']]);
        $this->middleware('permission:circle-member-assignRole', ['only' => ['assignRole']]);
        $this->middleware('permission:circle-member-removeRole', ['only' => ['removeRole']]);
        $this->middleware('permission:circle-member-export', ['only' => ['export']]);
    }

    public function filterTableData(Request $request)
    {
        $categoryId = $request->input('categoryId');
        $circleId = $request->input('circleId');
        $membershipType = $request->input('membershipType');

        $query = Member::with(['circle', 'bCategory', 'mType', 'user.roles']); // Replace with your actual table name

        if ($categoryId) {
            $query->where('businessCategoryId', $categoryId); // Adjust column name if necessary
        }

        if ($circleId) {
            $query->where('circleId', $circleId); // Adjust column name if necessary
        }

        if ($membershipType) {
            $query->where('membershipType', $membershipType); // Adjust column name if necessary
        }

        // Fetch filtered data
        $data = $query->get();

        // Fetch all roles (or limit based on your condition)
        $roles = Role::all(); // Or filter roles based on your requirements

        return response()->json(['data' => $data, 'roles' => $roles]);
    }




    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $memberQuery = Member::where('status', 'Active')
                ->whereHas('circle')
                ->whereHas('contactDetails')
                ->with(['circle', 'contactDetails', 'user', 'topsProfile', 'billingAddress']);

            if ($user->hasRole('Circle Admin')) {
                $memberQuery->where('createdBy', $user->id);
            }

            $member = $memberQuery->paginate(10);
            $circle = Circle::where('status', 'Active')->get();
            $bCategory = BusinessCategory::where('status', 'Active')->get();
            $roles = Role::all();
            $membershipType = MembershipType::where('status', 'Active')->get();

            return view('admin.circlemember.index', compact('member', 'roles', 'circle', 'bCategory', 'membershipType'));
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function assignCircle(Request $request)
    {

        try {
            $member = Member::where('id', $request->memberId)->first();

            $circleAdmin = new circleAdmin();
            $circleAdmin->memberId = $member->id;
            $circleAdmin->circleId = $request->circleId;
            $circleAdmin->save();

            return redirect()->back()->with('success', 'Circle assigned successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    // public function index(Request $request)
    // {
    //     try {
    //         $user = Auth::user();
    //         $memberQuery = Member::where('status', 'Active')
    //             ->whereHas('circle')
    //             ->whereHas('contactDetails')
    //             ->with(['circle', 'contactDetails', 'user', 'topsProfile', 'billingAddress']);

    //         if ($user->hasRole('Circle Admin')) {
    //             $memberQuery->where('createdBy', $user->id);
    //         }

    //         $member = $memberQuery->paginate(10);
    //         // $member = Member::findOrFail($user->id);
    //         $member = Member::whereHas('circle')->where('status', 'Active')->with('circle')->whereHas('contactDetails')->where('status', 'Active')->with('contactDetails')->with('user')->where('status', 'Active')->with('topsProfile')->with('billingAddress')->paginate(10);
    //         $circle = Circle::where('status', 'Active')->get();
    //         $bCategory = BusinessCategory::where('status', 'Active')->get();
    //         // $roles = Role::whereNotIn('name', ['Admin', 'Member', 'Trainer', 'Franchise '])->paginate(10);
    //         $roles = Role::all();
    //         $membershipType = MembershipType::where('status', 'Active')->get();

    //         return view('admin.circlemember.index', compact('member', 'roles', 'circle', 'bCategory', 'membershipType'));
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             $request->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }


    //filter data
    public function filter(Request $request)
    {
        $circleId = $request->get('circleId');
        $categoryId = $request->get('categoryId');
        $membershipType = $request->get('membershipType');

        $query = Member::query();

        if ($circleId) {
            $query->where('circleId', $circleId);
        }

        if ($categoryId) {
            $query->where('categoryId', $categoryId);
        }

        if ($membershipType) {
            $query->where('membershipType', $membershipType);
        }

        $members = $query->with(['circle', 'bCategory', 'user.roles'])->get();

        return response()->json($members);
    }



    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $circlemember = Member::findOrFail($id);
            return response()->json($circlemember);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
    public function create(Request $request)
    {
        try {
            $businessCategory = BusinessCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            $user = Auth::user();
            if ($user->hasRole('Circle Admin')) {
                $circle = Circle::where('status', 'Active')->where('createdBy', $user->id)->get();
            } else {
                $circle = Circle::where('status', 'Active')->get();
            }
            $member = Member::where('status', 'Active')->get();
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            $membershipType = MembershipType::where('status', 'Active')->get();

            $circles = Circle::where('status', 'Active')->get();

            $circleMember = Member::with('circle')
                ->where('status', 'Active')
                ->get(); // Ensure 'circleId' is included

            return view('admin.circlemember.create', compact('circle', 'membershipType', 'circles', 'circleMember', 'member', 'countries', 'states', 'cities', 'businessCategory'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
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
            $rowPassword = 123456;

            // Create and save the user
            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->contactNo = $request->mobileNo;
            $user->password = Hash::make($rowPassword);
            $user->assignRole('Member');
            $user->save();

            // Initialize cURL
            $curl = curl_init();

            // Set cURL options
            curl_setopt_array($curl, [
                CURLOPT_URL => env('BASE_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_FAILONERROR => true,
                CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification for testing
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query([
                    'firstName' => $user->firstName,
                    'lastName' => $user->lastName,
                    'email' => $user->email,
                    'contactNo' => $user->contactNo,
                    'password' => $rowPassword
                ]),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded'
                ],
            ]);


            // Execute and handle response
            $response = curl_exec($curl);

            // Check for errors
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                // Handle the error, e.g., log or display it
                echo "cURL Error: $error_msg";
            }

            // Close cURL session
            curl_close($curl);


            // Create and save the member
            $member = new Member();
            $member->createdBy = Auth::user()->id;
            $member->circleId = $request->circleId;
            $member->sponsoredBy = $request->memberId;
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

            // Compare circleId and add connections
            $matchedMembers = Member::where('circleId', $member->circleId)
                ->where('userId', '!=', $member->userId) // Exclude the current member
                ->get();


            foreach ($matchedMembers as $matchedMember) {
                // Create new connection entries
                $connection = new Connection;
                $connection->memberId = $member->userId;
                $connection->userId = $matchedMember->userId;
                $connection->status = 'Accepted';
                $connection->save();

                // // Create the reverse connection
                // $reverseConnection = new Connection;
                // $reverseConnection->memberId = $matchedMember->userId;
                // $reverseConnection->userId = $member->userId;
                // $reverseConnection->status = 'Accepted';
                // $reverseConnection->save();
            }

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

            // return $member->membershipType;
            // Create and save MemberSubscriptions
            $payment = new MemberSubscriptions();
            $payment->userId = $user->id;
            $payment->paymentId = $paymentId;
            $payment->membershipType = $member->membershipType;
            $payment->paymentMode = $request->has('paymentMode') ? $request->paymentMode : 'Online';

            if ($member->membershipType == 2) {
                $payment->validity = now()->addYears(5)->format('d-m-Y');
            } elseif ($member->membershipType == 1) {
                $payment->validity = now()->addYear()->format('d-m-Y');
            }

            $payment->paymentDate = $request->date;

            $payment->status = 'Active';
            $payment->save();


            $allPayments = new AllPayments();
            $allPayments->memberId = $member->userId;
            $allPayments->amount = $member->membershipAmount;
            $allPayments->paymentType = 'Offline'; // Assume RazorPay for this example
            $allPayments->date = now()->format('Y-m-d');
            $allPayments->paymentMode = 'Membership Subscription';
            $allPayments->remarks = 'Payment Mode is Offline';
            $allPayments->save();


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
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
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




    public function edit(Request $request, $id)
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
            $user = Auth::user();
            if ($user->hasRole('Circle Admin')) {
                $circle = Circle::where('status', 'Active')->where('createdBy', $user->id)->get();
            } else {
                $circle = Circle::where('status', 'Active')->get();
            }
            $businessCategory = BusinessCategory::where('status', 'Active')->get();
            $membershipType = MembershipType::where('status', 'Active')->get();


            return view('admin.circlemember.edit', compact('countries', 'membershipType', 'user', 'states', 'cities', 'member', 'contactDetails', 'billing', 'tops', 'circles', 'businessCategory'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function update(Request $request)
    {

        // return $request;

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
            if ($request->has('circleId')) {
                $member->circleId = $request->circleId;
            }
            $member->title = $request->has('title') ? $request->title : $member->title;
            $member->firstName = $request->has('firstName') ? $request->firstName : $member->firstName;
            $member->lastName = $request->has('lastName') ? $request->lastName : $member->lastName;
            $member->username = $request->has('username') ? $request->username : $member->username;
            $member->businessCategoryId = $request->has('businessCategory') ? $request->businessCategory : $member->businessCategoryId;
            $member->suffix = $request->has('suffix') ? $request->suffix : $member->suffix;
            $member->displayName = $request->has('displayName') ? $request->displayName : $member->displayName;
            $member->gstRegiState = $request->has('gstRegiState') ? $request->gstRegiState : $member->gstRegiState;
            $member->gstinPan = $request->has('gstinPan') ? $request->gstinPan : $member->gstinPan;
            $member->industry = $request->has('industry') ? $request->industry : $member->industry;
            $member->classification = $request->has('classification') ? $request->classification : $member->classification;
            $member->gender = $request->has('gender') ? $request->gender : $member->gender;
            $member->language = $request->has('language') ? $request->language : $member->language;
            $member->timeZone = $request->has('timeZone') ? $request->timeZone : $member->timeZone;

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

            $member->goals =  $request->has('goals') ? $request->goals : $member->goals;
            $member->chapter = $request->has('chapter') ? $request->chapter : $member->chapter;
            $member->renewalDueDate = $request->has('renewalDueDate') ? $request->renewalDueDate : $member->renewalDueDate;
            $member->accomplishment = $request->has('accomplishment') ? $request->accomplishment : $member->accomplishment;
            $member->companyName = $request->has('companyName') ? $request->companyName : $member->companyName;
            $member->interests = $request->has('interests') ? $request->interests : $member->interests;
            $member->networks = $request->has('networks') ? $request->networks : $member->networks;
            $member->skills = $request->has('skills') ? $request->skills : $member->skills;
            $member->myBusiness = $request->has('myBusiness') ? $request->myBusiness : $member->myBusiness;
            $member->webSite = $request->has('webSite') ? $request->webSite : $member->webSite;
            $member->showWebsite = $request->has('showWebsite') ? $request->showWebsite : $member->showWebsite;
            $member->socialLinks = $request->has('socialLinks') ? $request->socialLinks : $member->socialLinks;
            $member->showSocialLinks = $request->has('showSocialLinks') ? $request->showSocialLinks : $member->showSocialLinks;
            $member->receiveUpdates = $request->has('receiveUpdates') ? $request->receiveUpdates : $member->receiveUpdates;
            $member->shareRevenue = $request->has('shareRevenue') ? $request->shareRevenue : $member->shareRevenue;
            $member->membershipStatus = $request->has('membershipStatus') ? $request->membershipStatus : $member->membershipStatus;
            // $member->membershipType = $request->has('membershipType') ? $request->membershipType : $member->membershipType;
            $member->keyWords = $request->has('keyWords') ? $request->keyWords : $member->keyWords;
            $member->status = 'Active';
            $member->save();

            // Update TopsProfile
            $tops = TopsProfile::where('memberId', $member->id)->firstOrFail();
            $tops->idealRef = $request->has('idealRef') ? $request->idealRef : $tops->idealRef;
            $tops->topProduct = $request->has('topProduct') ? $request->topProduct : $tops->topProduct;
            $tops->topProblemSolved = $request->has('topProblemSolved') ? $request->topProblemSolved : $tops->topProblemSolved;
            $tops->myFavBNIStory = $request->has('myFavBNIStory') ? $request->myFavBNIStory : $tops->myFavBNIStory;
            $tops->myIdealRefPartner = $request->has('myIdealRefPartner') ? $request->myIdealRefPartner : $tops->myIdealRefPartner;
            $tops->weeklyPresent1 = $request->has('weeklyPresent1') ? $request->weeklyPresent1 : $tops->weeklyPresent1;
            $tops->weeklyPresent2 = $request->has('weeklyPresent2') ? $request->weeklyPresent2 : $tops->weeklyPresent2;
            $tops->yearsInBusiness = $request->has('yearsInBusiness') ? $request->yearsInBusiness : $tops->yearsInBusiness;
            $tops->prevJobs = $request->has('prevJobs') ? $request->prevJobs : $tops->prevJobs;
            $tops->spouse = $request->has('spouse') ? $request->spouse : $tops->spouse;
            $tops->children = $request->has('children') ? $request->children : $tops->children;
            $tops->pets = $request->has('pets') ? $request->pets : $tops->pets;
            $tops->hobbiesInterests = $request->has('hobbiesInterests') ? $request->hobbiesInterests : $tops->hobbiesInterests;
            $tops->cityofRes = $request->has('cityofRes') ? $request->cityofRes : $tops->cityofRes;
            $tops->yearsInCity = $request->has('yearsInCity') ? $request->yearsInCity : $tops->yearsInCity;
            $tops->myBurningDesire = $request->has('myBurningDesire') ? $request->myBurningDesire : $tops->myBurningDesire;
            $tops->dontKnowAboutMe = $request->has('dontKnowAboutMe') ? $request->dontKnowAboutMe : $tops->dontKnowAboutMe;
            $tops->mKeyToSuccess = $request->has('mKeyToSuccess') ? $request->mKeyToSuccess : $tops->mKeyToSuccess;
            $tops->status = 'Active';
            $tops->save();

            // Update ContactDetails
            // return $member;
            $contact = ContactDetails::where('memberId', $member->id)->firstOrFail();
            // return $contact = ContactDetails::findOrFail($member->id);

            $contact->showMeOnPublicWeb = $request->has('showMeOnPublicWeb') ? $request->showMeOnPublicWeb : $contact->showMeOnPublicWeb;
            $contact->billingAddress = $request->has('billingAddress') ? $request->billingAddress : $contact->billingAddress;
            $contact->phone = $request->has('phone') ? $request->phone : $contact->phone;
            $contact->showPhone = $request->has('showPhone') ? $request->showPhone : $contact->showPhone;
            $contact->directNo = $request->has('directNo') ? $request->directNo : $contact->directNo;
            $contact->showDirectNo = $request->has('showDirectNo') ? $request->showDirectNo : $contact->showDirectNo;
            $contact->home = $request->has('home') ? $request->home : $contact->home;
            $contact->mobileNo = $request->has('mobileNo') ? $request->mobileNo : $contact->mobileNo;
            $contact->showMobileNo = $request->has('showMobileNo') ? $request->showMobileNo : $contact->showMobileNo;
            $contact->pager = $request->has('pager') ? $request->pager : $contact->pager;
            $contact->voiceMail = $request->has('voiceMail') ? $request->voiceMail : $contact->voiceMail;
            $contact->tollFree = $request->has('tollFree') ? $request->tollFree : $contact->tollFree;
            $contact->showTollFree = $request->has('showTollFree') ? $request->showTollFree : $contact->showTollFree;
            $contact->fax = $request->has('fax') ? $request->fax : $contact->fax;
            $contact->showFax = $request->has('showFax') ? $request->showFax : $contact->showFax;
            $contact->email = $request->has('email') ? $request->email : $contact->email;
            $contact->showEmail = $request->has('showEmail') ? $request->showEmail : $contact->showEmail;
            $contact->addressLine1 = $request->has('addressLine1') ? $request->addressLine1 : $contact->addressLine1;
            $contact->addressLine2 = $request->has('addressLine2') ? $request->addressLine2 : $contact->addressLine2;

            // $contact->profileAddress = $request->profileAddress;
            $contact->city = $request->has('city') ? $request->city : $contact->city;
            $contact->state = $request->has('state') ? $request->state : $contact->state;
            $contact->country = $request->has('country') ? $request->country : $contact->country;
            $contact->pinCode = $request->has('pinCode') ? $request->pinCode : $contact->pinCode;
            $contact->status = 'Active';
            $contact->save();

            // Update BillingAddress
            $billing = BillingAddress::where('memberId', $member->id)->firstOrFail();
            $billing->bAddressLine1 = $request->has('bAddressLine1') ? $request->bAddressLine1 : $billing->bAddressLine1;
            $billing->bAddressLine2 = $request->has('bAddressLine2') ? $request->bAddressLine2 : $billing->bAddressLine2;
            $billing->bCity = $request->has('bCity') ? $request->bCity : $billing->bCity;
            $billing->bState = $request->has('bState') ? $request->bState : $billing->bState;
            $billing->bCountry = $request->has('bCountry') ? $request->bCountry : $billing->bCountry;
            $billing->bPinCode = $request->has('bPinCode') ? $request->bPinCode : $billing->bPinCode;
            $billing->status = 'Active';
            $billing->save();

            $user = User::find($member->userId);
            $user->email = $request->has('email') ? $request->email : $user->email;
            $user->firstName = $request->has('firstName') ? $request->firstName : $user->firstName;
            $user->lastName = $request->has('lastName') ? $request->lastName : $user->lastName;
            $user->contactNo = $request->has('contactNo') ? $request->contactNo : $user->contactNo;
            $user->save();


            return redirect()->route('circlemember.index')->with('success', 'Member Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function delete(Request $request, $id)
    {

        try {
            $circlemember = Member::find($id);
            $user = User::find($circlemember->userId);
            $circlemember->status = "Deleted";
            $user->status = "Deleted";
            $circlemember->save();
            $user->save();

            // Update other tables also
            $contact = ContactDetails::where('memberId', $id)->first();
            $contact->status = "Deleted";
            $contact->save();

            $billing = BillingAddress::where('memberId', $id)->first();
            $billing->status = "Deleted";
            $billing->save();

            $tops = TopsProfile::where('memberId', $id)->first();
            $tops->status = "Deleted";
            $tops->save();

            // Fetch and update CircleCall records
            $circleCalls = CircleCall::where('memberId', $circlemember->userId)->get();
            foreach ($circleCalls as $circleCall) {
                $circleCall->status = "Deleted";
                $circleCall->save();
            }

            // Fetch and update CircleMeetingMembersBusiness records
            $businessSlips = CircleMeetingMembersBusiness::where('businessGiverId', $circlemember->userId)->get();
            foreach ($businessSlips as $businessSlip) {
                $businessSlip->status = "Deleted";
                $businessSlip->save();
            }

            // Fetch and update CircleMeetingMembersReference records
            $businessReferences = CircleMeetingMembersReference::where('memberId', $circlemember->userId)->get();
            foreach ($businessReferences as $businessReference) {
                $businessReference->status = "Deleted";
                $businessReference->save();
            }

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function activity(Request $request)
    {
        try {
            $circlecall = CircleCall::where('status', 'Active')
                ->where('memberId', 'userId')
                ->paginate(10);
            return view('admin.circlemember.activity', compact('circlecall'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function assignRole(Request $request)
    {

        // return $request();

        try {
            // Validate the incoming request
            $request->validate([
                'memberId' => 'required|exists:members,id',
                'roleId' => 'required|exists:roles,id',
            ]);

            // Find the circle member
            //   return  $member = CircleMember::findOrFail($request->memberId);

            $member = Member::where('id', $request->memberId)->first();

            // Find the role
            $role = Role::findOrFail($request->roleId);

            // Attach the role to the user (assuming the relationship is defined)
            $member->user->roles()->attach($role);

            return redirect()->back()->with('success', 'Role assigned successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function removeRole(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'memberId' => 'required|exists:members,id',
                'roleId' => 'required|exists:roles,id',
            ]);

            // Find the circle member
            $member = Member::where('id', $request->memberId)->firstOrFail();

            // Find the role
            $role = Role::findOrFail($request->roleId);

            // Detach the role from the user (assuming the relationship is defined)
            $member->user->roles()->detach($role);

            return redirect()->back()->with('success', 'Role removed successfully.');
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Redirect with an error message
            return redirect()->back()->with('error', 'Failed to remove role.');
        }
    }


    public function export(Request $request)
    {
        try {

            $circleId = $request->input('circleId');

            return Excel::download(new CircleMembersExport($circleId), 'circle_members.xlsx');
        } catch (\Throwable $th) {
            throw $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return redirect()->back()->with('error', 'Failed to export data.');
        }
    }
}
