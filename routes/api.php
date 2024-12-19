<?php

use App\Models\CircleMember;
use Illuminate\Http\Request;
use App\Mail\MeetingInvitation;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CircleController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Api\AllActivityController;
use App\Http\Controllers\Api\MonthlyPaymentController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\OTPLoginController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\FranchiseController;
use App\Http\Controllers\Api\MyPaymentController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CircleCallController;
use App\Http\Controllers\Api\CircleTypeController;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\LeaderBoardController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\CircleMemberController;
use App\Http\Controllers\Api\CircleMeetingController;
use App\Http\Controllers\Api\TrainerMasterController;
use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\BusinessCategoryController;
use App\Http\Controllers\Api\MeetingInvitationController;
use App\Http\Controllers\Api\CircleMeetingMembersController;
use App\Http\Controllers\Api\MembershipSubscriptionController;
use App\Http\Controllers\Api\CircleMeetingMemberBusinessController;
use App\Http\Controllers\Api\CircleMeetingMemberReferenceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\SlotController;
use App\Http\Controllers\Api\SpecificAskController;
use App\Http\Controllers\Api\UpdateAppController;
use App\Http\Controllers\Api\VisitorController;

// use App\Http\Controllers\Api\CircleMeetingMemberBusinessController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* ---------------------------------- Common Login  ----------------------------------  */


// login
Route::post('/login', [LoginController::class, 'login']);
Route::post('v1/login', [ApiController::class, 'login']);
Route::post('visitor/login', [VisitorController::class, 'visitorLogin']);

Route::post('event/attendance', [VisitorController::class, 'eventAttendance']);

Route::post('event/visitorIndex', [VisitorController::class, 'eventIndex']);

Route::get('/events/users/{id?}', [VisitorController::class, 'getUserListForVisitors']);

Route::post('/slot-booking/visitor', [SlotController::class, 'slotBookingVisitorAPI']);

Route::post('/payment/visitor', [EventController::class, 'eventPaymentVisitor']);


Route::get('/slot/index', [SlotController::class, 'slotIndex']);


//forgot password
Route::post('/forgot-password', [ForgetPasswordController::class, 'forgotPassword']);
// Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);


// Route::post('circle-meeting-member-references-create', [CircleMeetingMemberReferenceController::class, 'create']);
//Login with otp

Route::post('/send-otp', [OTPLoginController::class, 'sendOTP'])->name('send_otp');

// Route for verifying OTP
Route::post('/verify-otp', [OTPLoginController::class, 'verifyOTP'])->name('verify_otp');

Route::get('role-permissions', [LoginController::class, 'getRolePermissions']);





Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user/profile', [LoginController::class, 'profile']);

    Route::post('/user/member/update', [LoginController::class, 'memberUpdate']);
    Route::post('/user/member/updateBillingAddress', [LoginController::class, 'billingAddressUpdate']);
    Route::post('/user/member/updateContactDetails', [LoginController::class, 'contactDetailsUpdate']);
    Route::post('/user/member/updateTopsProfile', [LoginController::class, 'topsProfileUpdate']);


    // Admin side profile change
    Route::post('/members/{id}', [LoginController::class, 'memberUpdateAdmin']);
    // Route::put('/members/{id}', [MemberController::class, 'update']);

    //permissions
    Route::get('/permissions-index', [PermissionController::class, 'index']);
    Route::get('/role-permissions-index', [PermissionController::class, 'rolePermission']);
    Route::get('/role-index', [PermissionController::class, 'getRole']);


    // Circl 1:1 Call
    Route::get('circlecalls-index', [CircleCallController::class, 'index']);
    Route::get('circlecalls-recievedBusinessMeet-index', [CircleCallController::class, 'recievedBusinessMeet']);
    Route::get('circlecalls-view/{id}', [CircleCallController::class, 'view']);
    Route::post('circlecalls-create', [CircleCallController::class, 'create']);
    Route::post('circlecalls-update/{id}', [CircleCallController::class, 'update']);
    Route::get('circlecalls-delete/{id}', [CircleCallController::class, 'delete']);




    // Circle Meeting Business Giver
    Route::get('circle-meeting-member-businesses', [CircleMeetingMemberBusinessController::class, 'index']);
    Route::get('circle-meeting-member-business-received-index', [CircleMeetingMemberBusinessController::class, 'recievedBus']);
    Route::get('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'view']);
    Route::post('circle-meeting-member-businesses/create', [CircleMeetingMemberBusinessController::class, 'create']);
    Route::post('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'update']);
    Route::delete('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'delete']);

    Route::get('circle-meeting-member-businesses/paymentHistory/{id}', [CircleMeetingMemberBusinessController::class, 'paymentHistory']);
    // Reference Giver

    Route::get('circle-meeting-member-references-index', [CircleMeetingMemberReferenceController::class, 'index']);
    Route::get('circle-meeting-member-references-recieved-index', [CircleMeetingMemberReferenceController::class, 'receivedRef']);
    Route::get('circle-meeting-member-references/{id}', [CircleMeetingMemberReferenceController::class, 'view']);
    Route::post('circle-meeting-member-references-create', [CircleMeetingMemberReferenceController::class, 'create']);
    Route::post('circle-meeting-member-references-refByOtherStore', [CircleMeetingMemberReferenceController::class, 'refByOtherStore']);
    Route::post('circle-meeting-member-references-update/{id}', [CircleMeetingMemberReferenceController::class, 'update']);
    Route::get('circle-meeting-member-references-delete/{id}', [CircleMeetingMemberReferenceController::class, 'delete']);


    // Trainer master
    Route::get('trainers-index', [TrainerMasterController::class, 'index']);
    Route::get('trainers-show/{id}', [TrainerMasterController::class, 'show']);
    Route::post('trainers-create', [TrainerMasterController::class, 'create']);
    Route::put('trainers-update/{id}', [TrainerMasterController::class, 'update']);
    Route::delete('trainers-delete/{id}', [TrainerMasterController::class, 'delete']);

    // Training
    Route::get('trainings-index', [TrainingController::class, 'index']);
    Route::get('trainings-show/{id}', [TrainingController::class, 'show']);
    Route::post('trainings-create', [TrainingController::class, 'create']);
    Route::put('trainings-update/{id}', [TrainingController::class, 'update']);
    Route::delete('trainings-delete/{id}', [TrainingController::class, 'delete']);

    //Training Register

    // Route::post('/training-register/{trainingId}/{trainerId}', [TrainingController::class, 'trainingRegister']);

    Route::post('/training-register', [TrainingController::class, 'trainingRegister']);

    // Circle Type
    Route::get('circle-type-index', [CircleTypeController::class, 'index']);
    Route::get('circle-type-show/{id}', [CircleTypeController::class, 'show']);
    Route::post('circle-type-create', [CircleTypeController::class, 'create']);
    Route::put('circle-type-update/{id}', [CircleTypeController::class, 'update']);
    Route::delete('circle-type-delete/{id}', [CircleTypeController::class, 'delete']);


    // Circle
    Route::get('circle-index', [CircleController::class, 'index']);
    Route::get('circle-show/{id}', [CircleController::class, 'show']);
    Route::post('circle-create', [CircleController::class, 'create']);
    Route::put('circle-update/{id}', [CircleController::class, 'update']);
    Route::delete('circle-delete/{id}', [CircleController::class, 'delete']);

    // Circle
    Route::get('circle-member-index', [CircleMemberController::class, 'index']);
    Route::get('circle-member-show/{id}', [CircleMemberController::class, 'show']);
    Route::post('circle-member-create', [CircleMemberController::class, 'create']);
    Route::put('circle-member-update/{id}', [CircleMemberController::class, 'update']);
    Route::delete('circle-member-delete/{id}', [CircleMemberController::class, 'delete']);

    // Circle Meeting
    Route::get('circle-meeting-index', [CircleMeetingController::class, 'index']);
    Route::get('circle-meeting-show/{id}', [CircleMeetingController::class, 'show']);
    Route::post('circle-meeting-create', [CircleMeetingController::class, 'create']);
    Route::put('circle-meeting-update/{id}', [CircleMeetingController::class, 'update']);
    Route::delete('circle-meeting-delete/{id}', [CircleMeetingController::class, 'delete']);

    // Circle Meeting member
    Route::get('circle-meeting-members-index', [CircleMeetingMembersController::class, 'index']);
    Route::get('circle-meeting-members-show/{id}', [CircleMeetingMembersController::class, 'show']);
    Route::post('circle-meeting-members-create', [CircleMeetingMembersController::class, 'create']);
    Route::put('circle-meeting-members-update/{id}', [CircleMeetingMembersController::class, 'update']);
    Route::delete('circle-meeting-members-delete/{id}', [CircleMeetingMembersController::class, 'delete']);

    // Franchise
    Route::get('franchise-index', [FranchiseController::class, 'index']);
    Route::get('franchise-show/{id}', [FranchiseController::class, 'show']);
    Route::post('franchise-create', [FranchiseController::class, 'create']);
    Route::put('franchise-update/{id}', [FranchiseController::class, 'update']);
    Route::delete('franchise-delete/{id}', [FranchiseController::class, 'delete']);

    //search member
    Route::post('search-member-index', [CircleCallController::class, 'searchmember']);

    //circle wise mmeber
    Route::get('circle-wise-member-index', [CircleMemberController::class, 'circleWiseMember']);

    //Meeting Invitation
    Route::get('meeting-invitations-index', [MeetingInvitationController::class, 'index']);
    Route::post('meetings-invitation', [MeetingInvitationController::class, 'invitation']);

    //Circle Meeting View
    Route::get('circle-meeting-view', [MeetingInvitationController::class, 'getMeetingForCircle']);

    //Business Category View
    Route::get('business-category-index', [BusinessCategoryController::class, 'index']);


    //Testimonial

    Route::get('/testimonials/index', [TestimonialController::class, 'index']);
    Route::get('/testimonials/myTestimonials', [TestimonialController::class, 'myTestimonials']);
    Route::post('/testimonials/create', [TestimonialController::class, 'create']);
    // Route::get('/testimonials/admin', [TestimonialController::class, 'indexAdmin']);
    // Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy']);
    // Route::get('/testimonials/archives', [TestimonialController::class, 'archives']);
    // Route::put('/testimonials/restore/{id}', [TestimonialController::class, 'restore']);

    // Connections

    Route::get('/connections/receivedConnectionsRequests', [ConnectionController::class, 'receivedConnectionsRequests']);
    Route::get('/connections/myConnections', [ConnectionController::class, 'myConnections']);
    Route::post('/connections/sendRequest', [ConnectionController::class, 'sendRequest']);
    Route::post('/connections/search', [ConnectionController::class, 'search']);
    Route::post('/connections/requestAction', [ConnectionController::class, 'requestAction']);
    Route::post('/connections/removeConnection', [ConnectionController::class, 'removeConnection']);
    Route::post('/connections/viewMemberProfile', [ConnectionController::class, 'viewMemberProfile']);
    Route::get('/connections/ConnectionsRequests', [ConnectionController::class, 'ConnectionsRequests']);

    // Route::get('/connections/myConnection', [ConnectionController::class, 'myConnection']);

    //Membership History

    Route::get('/membership-history', [MembershipSubscriptionController::class, 'MembershipHistory']);

    // My Payment History
    Route::get('/my-payment-history', [MyPaymentController::class, 'myPaymentHistory']);

    //Event
    Route::post('/register/{eventId}', [EventController::class, 'eventRegister']);
    // Store user details for an event
    Route::post('/store-details', [EventController::class, 'storeUserDetails']);
    // get member list of event
    Route::get('/events/user-list/{id?}', [VisitorController::class, 'getUserListForMembers']);
    //slot booking for event
    Route::post('/slot-booking/member', [SlotController::class, 'slotBookingMemberAPI']);



    // Retrieve all active events
    Route::get('/event/index', [EventController::class, 'index']);

    // Check if a user is registered for an event
    Route::post('/check-registration-user', [EventController::class, 'checkRegistrationUser']);
    Route::post('/check-registration', [EventController::class, 'checkRegistration']);

    // Get the registration list for an event
    Route::get('/register-list/{id}', [EventController::class, 'eventRegisterList']);

    // Payment for event registration (for members)
    Route::post('/payment/member', [EventController::class, 'eventPaymentForMember']);

    // Payment for event registration (for users)
    Route::post('/payment/user', [EventController::class, 'userEventPayment']);

    //Monthly Payment APi
    Route::post('/monthly-payment/store', [MonthlyPaymentController::class, 'monthlyPaymentStore']);
    Route::get('/monthlyPayment/index', [MonthlyPaymentController::class, 'monthlyPaymentIndex']);


    // Attendance Api

    Route::get('/attendance/memberAttendance/{id}', [AttendanceController::class, 'memberAttendance']);
    Route::get('/attendance/invitedAttendance/{id}', [AttendanceController::class, 'invitedAttendance']);
    Route::get('/attendance/meeting-schedules', [AttendanceController::class, 'meetingSchedules']);
    Route::get('/attendance/attendance-list', [AttendanceController::class, 'attendanceList']);
    Route::post('/attendance/attendance-store', [AttendanceController::class, 'attendanceStore']);
    Route::post('/attendance/invited-store', [AttendanceController::class, 'invitedAttendanceStore']);

    //dashboard leaderboard apis

    Route::get('/leaderboards/max-meetings', [LeaderBoardController::class, 'maxMeetings']);
    Route::get('/leaderboards/max-business', [LeaderBoardController::class, 'maxBusiness']);
    Route::get('/leaderboards/max-reference', [LeaderBoardController::class, 'maxReference']);
    Route::get('/leaderboards/max-referral', [LeaderBoardController::class, 'maxRefferal']);
    Route::get('/leaderboards/max-visitor', [LeaderBoardController::class, 'maxVisitor']);


    //location
    Route::get('/userLocation/index', [LocationController::class, 'index']);
    Route::get('/user/userLocation', [LocationController::class, 'userLocation']);

    //chat
    Route::post('/chat/sendMessage', [ChatController::class, 'sendMessage']);
    // Route::get('/chat/getMessages', [ChatController::class, 'getMessages']);
    Route::post('/get-messages', [ChatController::class, 'getMessages']);
    Route::get('/chat/getList', [ChatController::class, 'getList']);

    //suggested members
    Route::get('/category-wise-member-index', [CircleMemberController::class, 'categoryWiseMember']);

    //change password
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);

    //My Subscriptions
    Route::get('/member/my-subscription', [PaymentController::class, 'mySubscription']);



    //new api v1
    //lead board
    Route::get('v1/leaderboards/max-meetings', [ApiController::class, 'maxMeetings']);
    Route::get('v1/leaderboards/max-business', [ApiController::class, 'maxBusiness']);
    Route::get('v1/leaderboards/max-reference', [ApiController::class, 'maxReference']);
    Route::get('v1/leaderboards/max-referral', [ApiController::class, 'maxRefferal']);
    Route::get('v1/leaderboards/max-visitor', [ApiController::class, 'maxVisitor']);


    Route::get('v1/leaderboards/get-max-data', [ApiController::class, 'getMaxData']);

    //Upcoming Workshop
    Route::get('v1/trainings-index', [ApiController::class, 'index']);

    //Personal Details update
    Route::get('v1/user/profile', [ApiController::class, 'profile']);
    Route::post('v1/user/member/update', [ApiController::class, 'memberUpdate']);
    Route::post('v1/user/member/updateBillingAddress', [ApiController::class, 'billingAddressUpdate']);
    Route::post('v1/user/member/updateContactDetails', [ApiController::class, 'contactDetailsUpdate']);
    Route::post('v1/user/member/updateTopsProfile', [ApiController::class, 'topsProfileUpdate']);

    //Circle Member List
    Route::get('v1/circle-wise-member-index', [ApiController::class, 'circleWiseMember']);
    // Route::get('v1/circle-member-index', [ApiController::class, 'iindex']);

    //Category Wise Member
    Route::get('v1/category-wise-member-index', [ApiController::class, 'categoryWiseMember']);

    //allMembers
    Route::get('v1/member-index', [ApiController::class, 'allMembers']);

    //getMaxdata
    Route::get('v1/get-max-data', [ApiController::class, 'getMaxData']);

    //getMaxdata of User
    Route::get('v1/get-max-data-user', [ApiController::class, 'getMaxDataUser']);

    Route::get('v1/max-meetings-user', [ApiController::class, 'maxMeetingsUser']);
    Route::get('v1/max-business-user', [ApiController::class, 'maxBusinessUser']);
    Route::get('v1/max-reference-user', [ApiController::class, 'maxReferenceUser']);
    Route::get('v1/max-referral-user', [ApiController::class, 'maxRefferalUser']);
    Route::get('v1/max-visitor-user', [ApiController::class, 'maxVisitorUser']);

    //userdata by id
    Route::get('v1/user-details/{userId}', [ApiController::class, 'getUserDetails']);

    //connection

    Route::get('v1/connections/receivedConnectionsRequests', [ConnectionController::class, 'receivedConnectionsRequests']);
    Route::get('v1/connections/myConnections', [ConnectionController::class, 'myConnections']);
    Route::post('v1/connections/sendRequest', [ConnectionController::class, 'sendRequest']);
    Route::post('v1/connections/search', [ConnectionController::class, 'search']);
    Route::post('v1/connections/requestAction', [ConnectionController::class, 'requestAction']);
    Route::post('v1/connections/removeConnection', [ConnectionController::class, 'removeConnection']);
    Route::post('v1/connections/viewMemberProfile', [ConnectionController::class, 'viewMemberProfile']);
    Route::get('v1/connections/ConnectionsRequests', [ConnectionController::class, 'ConnectionsRequests']);

    //change password
    Route::post('v1/change-password', [ApiController::class, 'changePassword']);

    //busGiven
    Route::get('busGiven-index', [CircleMeetingMemberBusinessController::class, 'busGiven']);

    //app
    // Route::get('/app-version', [ApiController::class, 'getAppVersion']);


    // specific Ask

    Route::get('specific-ask/all-index', [SpecificAskController::class, 'allIndexApi']);
    Route::get('specific-ask/index', [SpecificAskController::class, 'indexApi']);
    Route::post('specific-ask/create', [SpecificAskController::class, 'createApi']);
    Route::post('specific-ask/update/{id}', [SpecificAskController::class, 'updateApi']);
    Route::get('specific-ask/delete/{id}', [SpecificAskController::class, 'deleteApi']);

    //all activity for vp

    Route::get('/ibm-vp', [AllActivityController::class, 'ibmVp']);
    Route::get('/reference-vp', [AllActivityController::class, 'refrenceVp']);
    Route::get('/business-vp', [AllActivityController::class, 'businessVp']);

    //circle admin payment history

    Route::get('circleAdminPaymentHistory', [PaymentController::class, 'circleAdminPaymentHistory']);
    Route::get('myPaymentHistory', [PaymentController::class, 'getAllPayments']);
});

//get app version
Route::get('app-version', [UpdateAppController::class, 'getAppVersion']);
Route::post('update-app-version', [UpdateAppController::class, 'updateAppVersion']);


