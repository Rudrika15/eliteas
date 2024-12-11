<?php

use Maatwebsite\Excel\Excel;
use App\Exports\TrainersListExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\CircleController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Auth\OTPLoginController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\ErrorListController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CircleCallController;
use App\Http\Controllers\Admin\CircleTypeController;
use App\Http\Controllers\Admin\ConnectionController;
use App\Http\Controllers\Admin\AllActivityController;
use App\Http\Controllers\Admin\LeaderBoardController;
use App\Http\Controllers\Admin\CircleMemberController;
use App\Http\Controllers\Api\MonthlyPaymentController;
use App\Http\Controllers\Admin\CircleMeetingController;
use App\Http\Controllers\Admin\TrainerMasterController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\visitor\VisitorFormController;
use App\Http\Controllers\Admin\MembershipTypeController;
use App\Http\Controllers\Admin\BusinessCategoryController;
use App\Http\Controllers\Admin\TrainingCategoryController;
use App\Http\Controllers\Admin\CircleMeetingMembersController;
use App\Http\Controllers\Admin\CircleMemberActivityController;
use App\Http\Controllers\Admin\MembershipSubscriptionController;
use App\Http\Controllers\Admin\MembershipSubscriptionsController;
use App\Http\Controllers\Admin\CircleMeetingMemberBusinessController;
use App\Http\Controllers\Admin\CircleMeetingMemberReferenceController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\EventTypeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\admin\TemplateDetailController;
use App\Http\Controllers\Admin\UpdateAppController;
use App\Http\Controllers\Admin\SpecificAskController;
use App\Http\Controllers\Admin\TemplateMasterController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Conquer\ConEventController;
use App\Http\Controllers\Conquer\ConquerEventController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();



// Forgot Password

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');



// Route::get('visitor-form', [VisitorFormController::class, 'visitorForm'])->name('visitor.form');

// test visitor form route
Route::get('/visitor-form', [VisitorFormController::class, 'visitorForm'])->name('visitor.form')->middleware('signed');
Route::post('visitor-form-store', [VisitorFormController::class, 'store'])->name('visitor.form.store');
Route::post('/razorpay-payment-visitor', [PaymentController::class, 'storePaymentDetails'])->name('razorpay.payment.store.visitor');

// event invite
// Route::get('/event-link', [EventController::class, 'showEvent'])->name('event.link')->middleware('signed');

//new visitorform
// Route::get('visitor-form-view', [VisitorFormController::class, 'visitorsFormView'])->name('visitors.form.view');
// Route::post('visitors-form-user', [VisitorFormController::class, 'visitorStore'])->name('visitors.form.store');


Route::get('/server-error', function () {
    return view('servererror'); // This will render the custom error page
})->name('server.error');


Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::get('view', function () {
        Artisan::call('view:clear');
        return redirect()->back();
    });

    Route::get('cache', function () {
        Artisan::call('cache:clear');
        return redirect()->back();
    });

    Route::get('route', function () {
        Artisan::call('route:clear');
        return redirect()->back();
    });

    //update App
    Route::get('updateApp/edit/{id?}', [UpdateAppController::class, 'edit'])->name('updateApp.edit');
    Route::post('update-app-version/update', [UpdateAppController::class, 'updateAppVersion'])->name('updateApp.update');


    //permission
    Route::get('permission/index', [PermissionController::class, 'index'])->name('permission.index');
    Route::get('permission/create', [PermissionController::class, 'create'])->name('permission.create');
    Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('permission/edit/{id?}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('permission/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::get('permission/delete/{id?}', [PermissionController::class, 'delete'])->name('permission.delete');

    //change password
    Route::get('change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('changePasswordForm');
    Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('changePassword');

    Route::post('/save-location', [LocationController::class, 'saveLocation']);

    Route::get('/user-list', [UserController::class, 'userList'])->name('userList');

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('birthday/canvas/{id?}', [App\Http\Controllers\HomeController::class, 'birthday'])->name('birthday.canvas');

    Route::get('franchise/show/{id?}', [FranchiseController::class, 'show'])->name('franchise.show');
    Route::get('/franchise/index', [FranchiseController::class, 'index'])->name('franchise.index');
    Route::get('franchise/create', [FranchiseController::class, 'create'])->name('franchise.create');
    Route::post('franchise/store', [FranchiseController::class, 'store'])->name('franchise.store');
    Route::get('franchise/edit/{id?}', [FranchiseController::class, 'edit'])->name('franchise.edit');
    Route::post('franchise/update', [FranchiseController::class, 'update'])->name('franchise.update');
    Route::get('franchise/delete/{id?}', [FranchiseController::class, 'delete'])->name('franchise.delete');


    Route::get('/country/index', [CountryController::class, 'index'])->name('country.index');
    Route::get('country/show/{id?}', [CountryController::class, 'show'])->name('country.show');
    Route::get('country/create', [CountryController::class, 'create'])->name('country.create');
    Route::post('country/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('country/edit/{id?}', [CountryController::class, 'edit'])->name('country.edit');
    Route::post('country/update', [CountryController::class, 'update'])->name('country.update');
    Route::get('country/delete/{id?}', [CountryController::class, 'delete'])->name('country.delete');

    Route::get('/state/index', [StateController::class, 'index'])->name('state.index');
    Route::get('state/show/{id?}', [StateController::class, 'show'])->name('state.show');
    Route::get('state/create', [StateController::class, 'create'])->name('state.create');
    Route::post('state/store', [StateController::class, 'store'])->name('state.store');
    Route::get('state/edit/{id?}', [StateController::class, 'edit'])->name('state.edit');
    Route::post('state/update', [StateController::class, 'update'])->name('state.update');
    Route::get('state/delete/{id?}', [StateController::class, 'delete'])->name('state.delete');

    Route::get('/city/index', [CityController::class, 'index'])->name('city.index');
    Route::get('city/show/{id?}', [CityController::class, 'show'])->name('city.show');
    Route::get('city/create', [CityController::class, 'create'])->name('city.create');
    Route::post('city/store', [CityController::class, 'store'])->name('city.store');
    Route::get('city/edit/{id?}', [CityController::class, 'edit'])->name('city.edit');
    Route::post('city/update', [CityController::class, 'update'])->name('city.update');
    Route::delete('city/delete/{id?}', [CityController::class, 'delete'])->name('city.delete');

    // Get city and state

    Route::post('/get-states', [FranchiseController::class, 'getStates'])->name('get.states');
    Route::post('/get-cities', [FranchiseController::class, 'getCities'])->name('get.cities');
    Route::post('get/state-country', [FranchiseController::class, 'getStateAndCountry'])->name('get.state.country');




    Route::get('/trainer/index', [TrainerMasterController::class, 'index'])->name('trainer.index');
    Route::get('trainer/show/{id?}', [TrainerMasterController::class, 'show'])->name('trainer.show');
    Route::get('trainer/create', [TrainerMasterController::class, 'create'])->name('trainer.create');
    Route::post('trainer/store', [TrainerMasterController::class, 'store'])->name('trainer.store');
    Route::get('trainer/edit/{id?}', [TrainerMasterController::class, 'edit'])->name('trainer.edit');
    Route::post('trainer/update{id}', [TrainerMasterController::class, 'update'])->name('trainer.update');
    Route::get('trainer/delete/{id?}', [TrainerMasterController::class, 'delete'])->name('trainer.delete');

    //Trainer List
    Route::get('trainer/list', [TrainerMasterController::class, 'trainingWiseTrainerList'])->name('trainer.list');


    Route::get('/training/index', [TrainingController::class, 'index'])->name('training.index');
    Route::get('training/show/{id?}', [TrainingController::class, 'show'])->name('training.show');
    Route::get('training/create', [TrainingController::class, 'create'])->name('training.create');
    Route::post('training/store', [TrainingController::class, 'store'])->name('training.store');
    Route::get('training/edit/{id?}', [TrainingController::class, 'edit'])->name('training.edit');
    Route::post('training/update/{id}', [TrainingController::class, 'update'])->name('training.update');
    Route::get('training/delete/{id?}', [TrainingController::class, 'delete'])->name('training.delete');

    Route::get('/circletype/index', [CircleTypeController::class, 'index'])->name('circletype.index');
    Route::get('circletype/show/{id?}', [CircleTypeController::class, 'show'])->name('circletype.show');
    Route::get('circletype/create', [CircleTypeController::class, 'create'])->name('circletype.create');
    Route::post('circletype/store', [CircleTypeController::class, 'store'])->name('circletype.store');
    Route::get('circletype/edit/{id?}', [CircleTypeController::class, 'edit'])->name('circletype.edit');
    Route::post('circletype/update', [CircleTypeController::class, 'update'])->name('circletype.update');
    Route::get('circletype/delete/{id?}', [CircleTypeController::class, 'delete'])->name('circletype.delete');

    //event Type

    Route::get('eventType/index', [EventTypeController::class, 'index'])->name('eventType.index');
    Route::get('eventType/create', [EventTypeController::class, 'create'])->name('eventType.create');
    Route::post('eventType/store', [EventTypeController::class, 'store'])->name('eventType.store');
    Route::get('eventType/edit/{id?}', [EventTypeController::class, 'edit'])->name('eventType.edit');
    Route::post('eventType/update', [EventTypeController::class, 'update'])->name('eventType.update');
    Route::get('eventType/delete/{id?}', [EventTypeController::class, 'delete'])->name('eventType.delete');

    //Slot
    Route::get('slot/index', [SlotController::class, 'index'])->name('slot.index');
    Route::get('slot/create', [SlotController::class, 'create'])->name('slot.create');
    Route::post('slot/store', [SlotController::class, 'store'])->name('slot.store');
    Route::get('slot/edit/{id?}', [SlotController::class, 'edit'])->name('slot.edit');
    Route::post('slot/update', [SlotController::class, 'update'])->name('slot.update');
    Route::get('slot/delete/{id?}', [SlotController::class, 'delete'])->name('slot.delete');

    //slot booking
    Route::get('slotbooking/index', [SlotController::class, 'index'])->name('slotbooking.index');
    Route::get('slotbooking/create', [SlotController::class, 'create'])->name('slotbooking.create');
    Route::post('slotbooking/slotBookingMember', [SlotController::class, 'slotBookingMember'])->name('slotbooking.member');
    Route::get('slotbooking/edit/{id?}', [SlotController::class, 'edit'])->name('slotbooking.edit');
    Route::post('slotbooking/update', [SlotController::class, 'update'])->name('slotbooking.update');
    Route::get('slotbooking/delete/{id?}', [SlotController::class, 'delete'])->name('slotbooking.delete');


    Route::get('/member/event/index', [EventController::class, 'memberEventIndex'])->name('member.eventIndex');

    Route::get('memberSlotbooking/list/{id?}', [SlotController::class, 'memberSlotBookingRequests'])->name('memberSlotBooking.list');




    //circle
    Route::get('/circle/index', [CircleController::class, 'index'])->name('circle.index');
    Route::get('circle/show/{id?}', [CircleController::class, 'show'])->name('circle.show');
    Route::get('circle/create', [CircleController::class, 'create'])->name('circle.create');
    Route::post('circle/store', [CircleController::class, 'store'])->name('circle.store');
    Route::get('circle/edit/{id?}', [CircleController::class, 'edit'])->name('circle.edit');
    Route::post('circle/update', [CircleController::class, 'update'])->name('circle.update');
    Route::get('circle/delete/{id?}', [CircleController::class, 'delete'])->name('circle.delete');
    Route::get('circle/memberList/{id?}', [CircleController::class, 'memberList'])->name('circle.memberList');
    Route::get('circle/report/{id?}', [CircleController::class, 'report'])->name('circle.report');


    Route::get('/circlemember/index', [CircleMemberController::class, 'index'])->name('circlemember.index');
    Route::get('/filter-table-data', [CircleMemberController::class, 'filterTableData'])->name('filterTableData');
    Route::get('circlemember/show/{id?}', [CircleMemberController::class, 'show'])->name('circlemember.show');
    Route::get('circlemember/create', [CircleMemberController::class, 'create'])->name('circlemember.create');
    Route::post('circlemember/store', [CircleMemberController::class, 'store'])->name('circlemember.store');
    Route::get('circlemember/edit/{id?}', [CircleMemberController::class, 'edit'])->name('circlemember.edit');
    Route::post('circlemember/update/{id?}', [CircleMemberController::class, 'update'])->name('circlemember.update');
    Route::get('circlemember/delete/{id?}', [CircleMemberController::class, 'delete'])->name('circlemember.delete');
    Route::post('/get-membership-amount', [CircleMemberController::class, 'getMembershipAmount'])->name('get.membership.amount');

    //filter
    Route::get('/circlemember/filter', [CircleMemberController::class, 'filter'])->name('circlemember.filter');


    //member activity
    Route::get('circlemember/activity/{id?}', [CircleMemberActivityController::class, 'activity'])->name('circlemember.activity');
    //give new role to member
    Route::post('/assign-role', [CircleMemberController::class, 'assignRole'])->name('assign.role');
    Route::post('/assign-circle', [CircleMemberController::class, 'assignCircle'])->name('assign.circle');
    Route::post('/remove-role', [CircleMemberController::class, 'removeRole'])->name('remove.role');



    Route::get('/circlemeeting/index', [CircleMeetingController::class, 'index'])->name('circlemeeting.index');
    Route::get('circlemeeting/show/{id?}', [CircleMeetingController::class, 'show'])->name('circlemeeting.show');
    Route::get('circlemeeting/create', [CircleMeetingController::class, 'create'])->name('circlemeeting.create');
    Route::post('circlemeeting/store', [CircleMeetingController::class, 'store'])->name('circlemeeting.store');
    Route::get('circlemeeting/edit/{id?}', [CircleMeetingController::class, 'edit'])->name('circlemeeting.edit');
    Route::post('circlemeeting/update', [CircleMeetingController::class, 'update'])->name('circlemeeting.update');
    Route::get('circlemeeting/delete/{id?}', [CircleMeetingController::class, 'delete'])->name('circlemeeting.delete');

    Route::get('/circlecall/index', [CircleCallController::class, 'index'])->name('circlecall.index');
    Route::get('circlecall/show/{id?}', [CircleCallController::class, 'show'])->name('circlecall.show');
    Route::get('circlecall/create', [CircleCallController::class, 'create'])->name('circlecall.create');
    Route::post('circlecall/store', [CircleCallController::class, 'store'])->name('circlecall.store');
    Route::get('circlecall/edit/{id?}', [CircleCallController::class, 'edit'])->name('circlecall.edit');
    Route::post('circlecall/update', [CircleCallController::class, 'update'])->name('circlecall.update');
    Route::get('circlecall/delete/{id?}', [CircleCallController::class, 'delete'])->name('circlecall.delete');

    // get member list
    Route::get('get-circle', [CircleCallController::class, 'getCircle'])->name('getCircle');
    Route::get('get-circle-members', [CircleCallController::class, 'getCircleMembers'])->name('getCircleMembers');

    // In your web.php or api.php
    Route::get('/members/byCircle', [CircleCallController::class, 'getMembersByCircle'])->name('members.byCircle');
    Route::get('/member/byCircle', [CircleMemberController::class, 'getMemberByCircle'])->name('member.byCircle');


    // old get member
    Route::get('get-member', [CircleCallController::class, 'getMember'])->name('getMember');

    // get external trainer list
    // Route::get('get-external-trainers' , [TrainingController::class, 'getExternalTrainers'])->name('getExternalTrainers');

    Route::get('/get-trainer-details', [TrainingController::class, 'getTrainerDetails'])->name('getTrainerDetails');
    Route::get('/get-internal-trainer-details', [TrainingController::class, 'getInternalTrainerDetails'])->name('getInternalTrainerDetails');


    Route::get("get-external-trainer-modal", function () {
        return view('TrainerPerson1External');
    });

    Route::get("get-external-trainer-modal2", function () {
        return view('TrainerPerson2External');
    });


    Route::get("get-member-circle-master-modal", function () {
        return view('circleMemberMaster');
    });

    // referance giver
    Route::get('get-member-for-ref', [CircleCallController::class, 'getMemberForRef'])->name('getMemberForRef');
    Route::get('get-member-for-ref-giver', [CircleCallController::class, 'getMemberForRefGiver'])->name('getMemberForRefGiver');

    //get user by role fr trainer
    Route::get('/get-user-roles/{userId}', [UserController::class, 'getUserRoles']);

    Route::get('/meetings/{circle}', [CircleController::class, 'showByCircle'])->name('meetings.by.circle');

    // Route::post('/schedule/generate/{circle}', 'CircleController@generateMeetings')->name('schedule.generate');

    Route::post('/schedule/generate2/{circle}', [CircleController::class, 'generateMeetings'])->name('schedule.generate');

    Route::get('/members/index', [MemberController::class, 'index'])->name('members.index');
    Route::get('members/show/{id?}', [MemberController::class, 'show'])->name('members.show');
    Route::get('members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('members/store', [MemberController::class, 'store'])->name('members.store');
    Route::get('members/edit/{id?}', [MemberController::class, 'edit'])->name('members.edit');
    Route::post('members/update/{id?}', [MemberController::class, 'update'])->name('members.update');
    Route::get('members/delete/{id?}', [MemberController::class, 'delete'])->name('members.delete');



    Route::get('/refGiver/index', [CircleMeetingMemberReferenceController::class, 'index'])->name('refGiver.index');
    Route::get('refGiver/show/{id?}', [CircleMeetingMemberReferenceController::class, 'show'])->name('refGiver.show');
    Route::get('refGiver/create', [CircleMeetingMemberReferenceController::class, 'create'])->name('refGiver.create');
    Route::get('get-member-details', [CircleMeetingMemberReferenceController::class, 'getMemberDetails'])->name('getMemberDetails');
    Route::post('refGiver/store', [CircleMeetingMemberReferenceController::class, 'store'])->name('refGiver.store');
    Route::get('refGiver/edit/{id?}', [CircleMeetingMemberReferenceController::class, 'edit'])->name('refGiver.edit');
    Route::post('refGiver/update/{id?}', [CircleMeetingMemberReferenceController::class, 'update'])->name('refGiver.update');
    Route::get('refGiver/delete/{id?}', [CircleMeetingMemberReferenceController::class, 'delete'])->name('refGiver.delete');


    Route::get('refGiver/refByOther', [CircleMeetingMemberReferenceController::class, 'refByOther'])->name('refGiver.refByOther');
    Route::post('refGiver/refByOtherStore', [CircleMeetingMemberReferenceController::class, 'refByOtherStore'])->name('refGiver.refByOtherStore');


    Route::get('/busGiver/index', [CircleMeetingMemberBusinessController::class, 'index'])->name('busGiver.index');
    Route::get('busGiver/show/{id?}', [CircleMeetingMemberBusinessController::class, 'show'])->name('busGiver.show');
    Route::get('busGiver/create/{id?}', [CircleMeetingMemberBusinessController::class, 'create'])->name('busGiver.create');
    Route::post('busGiver/store', [CircleMeetingMemberBusinessController::class, 'store'])->name('busGiver.store');
    Route::get('busGiver/edit/{id?}', [CircleMeetingMemberBusinessController::class, 'edit'])->name('busGiver.edit');
    Route::post('busGiver/update/{id?}', [CircleMeetingMemberBusinessController::class, 'update'])->name('busGiver.update');
    Route::post('busGiver/update/{id?}', [CircleMeetingMemberBusinessController::class, 'update'])->name('busGiver.update');
    // Route::post('busGiver/paymentUpdate/{id?}', [CircleMeetingMemberBusinessController::class, 'paymentUpdate'])->name('busGiver.paymentUpdate');
    Route::get('busGiver/delete/{id?}', [CircleMeetingMemberBusinessController::class, 'delete'])->name('busGiver.delete');

    // web.php
    Route::get('/busGiver/paymentUpdate/{id}', [CircleMeetingMemberBusinessController::class, 'editPayment'])->name('busGiver.updatePayment');
    Route::post('/busGiver/paymentUpdate/{id}', [CircleMeetingMemberBusinessController::class, 'updatePayment'])->name('busGiver.paymentUpdate.save');




    Route::get('/meetingmember/index', [CircleMeetingMembersController::class, 'index'])->name('meetingmember.index');
    Route::get('meetingmember/show/{id?}', [CircleMeetingMembersController::class, 'show'])->name('meetingmember.show');
    Route::get('meetingmember/create', [CircleMeetingMembersController::class, 'create'])->name('meetingmember.create');
    Route::post('meetingmember/store', [CircleMeetingMembersController::class, 'store'])->name('meetingmember.store');
    Route::get('meetingmember/edit/{id?}', [CircleMeetingMembersController::class, 'edit'])->name('meetingmember.edit');
    Route::post('meetingmember/update', [CircleMeetingMembersController::class, 'update'])->name('meetingmember.update');
    Route::get('meetingmember/delete/{id?}', [CircleMeetingMembersController::class, 'delete'])->name('meetingmember.delete');

    Route::get('/schedule/index', [ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('schedule/show/{id?}', [ScheduleController::class, 'show'])->name('schedule.show');
    Route::get('schedule/create', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('schedule/store', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::get('schedule/edit/{id?}', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('schedule/update', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::get('schedule/delete/{id?}', [ScheduleController::class, 'delete'])->name('schedule.delete');
    Route::get('schedule/invitedList/{id?}', [ScheduleController::class, 'invitedList'])->name('schedule.invitedList');

    Route::get('/schedule/dashIndex', [ScheduleController::class, 'dashIndex'])->name('schedule.dashIndex');
    Route::get('/schedule/dashEdit/{id?}', [ScheduleController::class, 'dashEdit'])->name('schedule.dashEdit');
    Route::post('/schedule/dashUpdate', [ScheduleController::class, 'dashUpdate'])->name('schedule.dashUpdate');

    Route::get('/schedules/filter', [ScheduleController::class, 'filter'])->name('schedule.filter');

    //Profile Update

    Route::get('member-update/{id?}', [ProfileController::class, 'member'])->name('member');
    Route::post('update/{id?}', [ProfileController::class, 'memberUpdate'])->name('member.update');

    //Business Caategory

    Route::get('/bCategory/index', [BusinessCategoryController::class, 'index'])->name('bCategory.index');
    Route::get('bCategory/show/{id?}', [BusinessCategoryController::class, 'show'])->name('bCategory.show');
    Route::get('bCategory/create', [BusinessCategoryController::class, 'create'])->name('bCategory.create');
    Route::post('bCategory/store', [BusinessCategoryController::class, 'store'])->name('bCategory.store');
    Route::get('bCategory/edit/{id?}', [BusinessCategoryController::class, 'edit'])->name('bCategory.edit');
    Route::post('bCategory/update', [BusinessCategoryController::class, 'update'])->name('bCategory.update');
    Route::get('bCategory/delete/{id?}', [BusinessCategoryController::class, 'delete'])->name('bCategory.delete');

    //Training Caategory

    Route::get('/tCategory/index', [TrainingCategoryController::class, 'index'])->name('tCategory.index');
    Route::get('tCategory/show/{id?}', [TrainingCategoryController::class, 'show'])->name('tCategory.show');
    Route::get('tCategory/create', [TrainingCategoryController::class, 'create'])->name('tCategory.create');
    Route::post('tCategory/store', [TrainingCategoryController::class, 'store'])->name('tCategory.store');
    Route::get('tCategory/edit/{id?}', [TrainingCategoryController::class, 'edit'])->name('tCategory.edit');
    Route::post('tCategory/update', [TrainingCategoryController::class, 'update'])->name('tCategory.update');
    Route::get('tCategory/delete/{id?}', [TrainingCategoryController::class, 'delete'])->name('tCategory.delete');

    // payment
    Route::post('/razorpay-payment', [PaymentController::class, 'store'])->name('razorpay.payment.store');
    Route::post('/razorpay-payment-monthlyPaymentStore', [PaymentController::class, 'monthlyPaymentStore'])->name('razorpay.payment.monthlyPaymentStore');
    Route::post('/razorpay-payment-eventPayment', [PaymentController::class, 'eventPayment'])->name('razorpay.payment.eventPayment');
    Route::post('/razorpay-payment-invite', [PaymentController::class, 'invitePayment'])->name('razorpay.payment.invite');

    // invite person
    Route::post('/invite', [HomeController::class, 'invitation'])->name('invite.person');

    //testimonials user side
    Route::get('testimonial/index', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::get('testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');
    Route::post('testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');
    Route::get('testimonial/edit/{id?}', [TestimonialController::class, 'edit'])->name('testimonial.edit');
    Route::post('testimonial/update', [TestimonialController::class, 'update'])->name('testimonial.update');
    // Route::post('testimonial/delete{id?}', [TestimonialController::class, 'delete'])->name('testimonial.delete');



    //Testimonial View Admin Side
    Route::get('testimonials/indexAdmin', [TestimonialController::class, 'indexAdmin'])->name('testimonials.indexAdmin');

    Route::get('/get-member-details/{id}', [TrainerMasterController::class, 'getMemberDetails']);



    //Membership Master
    Route::get('/membershipType/index', [MembershipTypeController::class, 'index'])->name('membershipType.index');
    Route::get('membershipType/show/{id?}', [MembershipTypeController::class, 'show'])->name('membershipType.show');
    Route::get('membershipType/create', [MembershipTypeController::class, 'create'])->name('membershipType.create');
    Route::post('membershipType/store', [MembershipTypeController::class, 'store'])->name('membershipType.store');
    Route::get('membershipType/edit/{id?}', [MembershipTypeController::class, 'edit'])->name('membershipType.edit');
    Route::post('membershipType/update', [MembershipTypeController::class, 'update'])->name('membershipType.update');
    Route::get('membershipType/delete/{id?}', [MembershipTypeController::class, 'delete'])->name('membershipType.delete');

    Route::get('testimonial/archived/{id}', [TestimonialController::class, 'archived'])->name('testimonial.archived');
    Route::get('testimonial/archives', [TestimonialController::class, 'archives'])->name('testimonial.archives');
    Route::get('testimonial/restore/{id}', [TestimonialController::class, 'restore'])->name('testimonial.restore');
    Route::get('testimonial/delete/{id}', [TestimonialController::class, 'delete'])->name('testimonial.delete');

    Route::get('/trainingRegisterView', [TrainerMasterController::class, 'trainingRegisterView'])->name('trainerMaster.trainingRegisterView');
    Route::get('/trainingRegister/{trainingId?}/{trainerId?}', [HomeController::class, 'trainingRegister'])->name('training.register');
    Route::get('/invitationPay/{personName?}/{personEmail?}/{invitedPersonFirstName?}/{invitedPersonLastName?}/{amount?}', [HomeController::class, 'invitationPay'])->name('invitationPay');
    // Route::post('/invitationPay', [HomeController::class, 'invitationPay'])->name('invitationPay');

    // Invited Prople List
    Route::get('/invitedPersonList', [CircleMeetingController::class, 'invitedPersonList'])->name('invitedPersonList');



    // global search
    Route::get('/search', [HomeController::class, 'findMember'])->name('search');
    Route::get('/searchQuery', [HomeController::class, 'search'])->name('searchQuery');
    Route::get('/foundPersonDetails/{id}', [HomeController::class, 'foundPersonDetails'])->name('foundPersonDetails');

    // connections
    Route::post('/connect', [ConnectionController::class, 'connect'])->name('connect');
    Route::get('/connections/connectionRequests', [ConnectionController::class, 'connectionRequests'])->name('connection.connectionRequests');
    Route::get('/connections/myConnections', [ConnectionController::class, 'myConnections'])->name('connection.myConnections');
    Route::get('/connections/accept/{id?}', [ConnectionController::class, 'accept'])->name('connection.accept');
    Route::get('/connections/reject/{id?}', [ConnectionController::class, 'reject'])->name('connection.reject');
    Route::get('/connections/removeConnection/{id?}', [ConnectionController::class, 'removeConnection'])->name('connection.removeConnection');

    Route::get('/member-subscription', [MembershipSubscriptionController::class, 'index'])->name('subscription.memberSubscription');
    Route::get('/member-subscription-all', [MembershipSubscriptionController::class, 'memberData'])->name('subscription.memberSubscription.admin');

    //report
    // Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
    Route::get('/admin/reports/ibm', [ReportController::class, 'ibm'])->name('admin.report.ibm');
    Route::get('/admin/reports/reference', [ReportController::class, 'reference'])->name('admin.report.reference');
    Route::get('/admin/reports/business', [ReportController::class, 'business'])->name('admin.report.business');


    //admin side activity membership status changed
    Route::get('/allPayments', [PaymentController::class, 'allPayments'])->name('allPayments.index');
    Route::get('/monthlyPayments', [PaymentController::class, 'monthlyPayments'])->name('monthlyPayments.index');
    Route::get('/generate-payment', [PaymentController::class, 'generateMonthlyPayment'])->name('generate.payment');
    Route::post('/update-payment-status', [PaymentController::class, 'updatePaymentStatus'])->name('update.payment.status');
    Route::post('/handle-payment', [PaymentController::class, 'handlePayment'])->name('handle.payment');

    //circle admin payment history
    Route::get('/circleAdminPayment', [PaymentController::class, 'circleAdminPaymentHistory'])->name('circleAdminPaymentHistory.index');


    //user side activity membership status changed
    Route::get('/my-allPayments', [PaymentController::class, 'myAllPayments'])->name('myAllPayments.index');

    //dashboard
    Route::get('/pending-payments', [PaymentController::class, 'pendingPayments'])->name('pendingPayments.index');

    //send mail to user for renew membership
    // Route::get('/renewMembership/{id?}', [PaymentController::class, 'renewMembership'])->name('renewMembership.mail');
    // routes/web.php
    // Route::post('/renew-membership/{userId}', 'MembershipController@renewMembership')->name('renewMembership.mail');

    Route::post('/renew-membership/{userId}', [PaymentController::class, 'renewMembership'])->name('renewMembership.mail');

    //User View for Event
    // Route::get('/event/userListView', [SlotController::class, 'userListView'])->name('event.slot.userListView');

    //
    Route::get('/event/{id}/view-members', [SlotController::class, 'userListView'])->name('event.viewMembers');




    // Attendance

    Route::get('/attendance/takeAttendance/{id?}', [AttendanceController::class, 'takeAttendance'])->name('attendance.takeAttendance');
    Route::get('/attendance/invitedAttendance/{id?}', [AttendanceController::class, 'invitedAttendance'])->name('attendance.invitedAttendance');
    Route::post('/attendance/attendanceStore', [AttendanceController::class, 'attendanceStore'])->name('attendance.attendanceStore');
    Route::post('/attendance/invitedAttendanceStore', [AttendanceController::class, 'invitedAttendanceStore'])->name('attendance.invitedAttendanceStore');


    Route::get('/attendance/meetingSchedules', [AttendanceController::class, 'meetingSchedules'])->name('attendance.meetingSchedules');
    Route::get('/attendance/attendanceList/{id?}', [AttendanceController::class, 'attendanceList'])->name('attendance.attendanceList');

    //export excel file
    Route::get('circlemember/export', [CircleMemberController::class, 'export'])->name('circlemember.export');
    Route::post('/subscriptions/export', [MembershipSubscriptionController::class, 'exportSubscriptions'])->name('subscriptions.export');
    Route::get('export/users', [UserController::class, 'export'])->name('export.users');
    // Route::get('trainers/export', [TrainerMasterController::class, 'trainerListExport'])->name('trainersListExport.export');

    //leaderboard on dashboard
    Route::get('/leaderboard/maxMeetings', [LeaderBoardController::class, 'maxMeetings'])->name('maxMeetings.index');
    Route::get('/leaderboard/maxBusiness', [LeaderBoardController::class, 'maxBusiness'])->name('maxBusiness.index');
    Route::get('/leaderboard/maxReference', [LeaderBoardController::class, 'maxReference'])->name('maxReference.index');
    Route::get('/leaderboard/maxRefferal', [LeaderBoardController::class, 'maxRefferal'])->name('maxRefferal.index');
    Route::get('/leaderboard/maxVisitor', [LeaderBoardController::class, 'maxVisitor'])->name('maxVisitor.index');
    Route::get('/leaderboard/circleWiseLeaderboard', [LeaderBoardController::class, 'circleWiseLeaderboard'])->name('circleWiseLeaderboard.index');

    //visitors

    Route::get('/visitor-index', [VisitorFormController::class, 'index'])->name('visitor.index');
    Route::post('/visitor/update-remark', [VisitorFormController::class, 'updateRemark'])->name('visitor.updateRemark');


    //Visitors Crud

    Route::get('visitors/index', [VisitorController::class, 'index'])->name('visitors.index');
    Route::get('visitors/create', [VisitorController::class, 'create'])->name('visitors.create');
    Route::post('visitors/store', [VisitorController::class, 'store'])->name('visitors.store');
    Route::get('visitors/edit/{id?}', [VisitorController::class, 'edit'])->name('visitors.edit');
    Route::post('visitors/update', [VisitorController::class, 'update'])->name('visitors.update');
    Route::get('visitors/delete/{id?}', [VisitorController::class, 'delete'])->name('visitors.delete');



    //template

    Route::get('/template-index', [TemplateMasterController::class, 'index'])->name('template.index');
    Route::get('/template-create', [TemplateMasterController::class, 'create'])->name('template.create');
    Route::post('/template/store', [TemplateMasterController::class, 'store'])->name('template.store');
    Route::get('/template-edit/{id}', [TemplateMasterController::class, 'edit'])->name('template.edit');
    Route::post('/template/update', [TemplateMasterController::class, 'update'])->name('template.update');
    Route::get('/template-delete/{id}', [TemplateMasterController::class, 'destroy'])->name('template.delete');

    //Template Details
    Route::get('template-detail-index/{id?}', [TemplateDetailController::class, 'index'])->name('templateDetail.index');
    Route::get('template-detail-create', [TemplateDetailController::class, 'create'])->name('templateDetail.create');
    Route::post('template-detail-store', [TemplateDetailController::class, 'store'])->name('templateDetail.store');
    Route::get('template-detail-edit/{id}', [TemplateDetailController::class, 'edit'])->name('templateDetail.edit');
    Route::post('template-detail-update', [TemplateDetailController::class, 'update'])->name('templateDetail.update');
    Route::get('template-detail-delete/{id?}', [TemplateDetailController::class, 'destroy'])->name('templateDetail.delete');



    //chat
    // Route::get('/chat-index', [ChatController::class, 'index'])->name('chat.index');
    // routes/web.php

    Route::post('/send-message', [ChatController::class, 'sendMessage']);
    Route::post('/get-messages', [ChatController::class, 'getMessages']);
    Route::post('/getList', [ChatController::class, 'getList'])->name('chat.getList');

    Route::get('/myChatList', [ChatController::class, 'myChatList'])->name('chat.index');

    Route::get('/get-chat/{userId}', [ChatController::class, 'getChat']);




    // Route::post('/typing-status', [ChatController::class, 'updateTypingStatus']);

    Route::post('/typing', [ChatController::class, 'typing']);
    Route::post('/stopped-typing', [ChatController::class, 'stoppedTyping']);
    Route::get('/typing-status', [ChatController::class, 'typingStatus']);

    //Error List

    Route::get('/error-list', [ErrorListController::class, 'index'])->name('errorList');
    Route::post('/update-error-status/{id}', [ErrorListController::class, 'updateErrorStatus']);
    // Route::post('/log-error-web', [ErrorListController::class, 'logError'])->name('log.error');


    //location

    //event

    Route::get('/event/index', [EventController::class, 'index'])->name('event.index');
    Route::get('event/create', [EventController::class, 'create'])->name('event.create');
    // Route::get('/event/{slug}', [EventController::class, 'eventLink'])->name('event.link');
    Route::post('event/store', [EventController::class, 'store'])->name('event.store');
    Route::get('event/edit/{id?}', [EventController::class, 'edit'])->name('event.edit');
    Route::post('event/update', [EventController::class, 'update'])->name('event.update');
    Route::post('/event/update-status/{id}', [EventController::class, 'updateStatus'])->name('event.updateStatus');
    Route::get('event/eventRegisterList/{id?}', [EventController::class, 'eventRegisterList'])->name('event.eventRegisterList');
    Route::get('slotbooking/list/{id?}', [EventController::class, 'slotBookingList'])->name('slotbooking.list');
    Route::post('/event/register/{eventId}', [EventController::class, 'eventRegister'])->name('event.register');
    Route::delete('event/delete/{id?}', [EventController::class, 'delete'])->name('event.delete');

    // Route::post('/store-user-details', [EventController::class, 'storeUserDetails'])->name('storeUserDetails');
    // Route::post('/check-email', [EventController::class, 'checkEmail'])->name('checkEmail');

    //Conquer Event
    Route::get('conquer/event/index', [ConquerEventController::class, 'index'])->name('conquer.events.index');
    Route::get('conquer/event/registerList/{id?}', [ConquerEventController::class, 'registerList'])->name('conquer.events.registerList');
    Route::get('conquer/event/create', [ConquerEventController::class, 'create'])->name('conquer.events.create');
    Route::post('conquer/event/store', [ConquerEventController::class, 'store'])->name('conquer.events.store');
    Route::get('conquer/event/edit/{id?}', [ConquerEventController::class, 'edit'])->name('conquer.events.edit');
    Route::post('conquer/event/update', [ConquerEventController::class, 'update'])->name('conquer.events.update');
    Route::delete('conquer/event/delete/{id?}', [ConquerEventController::class, 'delete'])->name('conquer.events.delete');

    //Coupon Event
    Route::get('coupon/index', [CouponController::class, 'index'])->name('coupon.index');
    Route::get('coupon/create', [CouponController::class, 'create'])->name('coupon.create');
    Route::post('coupon/store', [CouponController::class, 'store'])->name('coupon.store');
    Route::get('coupon/edit/{id?}', [CouponController::class, 'edit'])->name('coupon.edit');
    Route::post('coupon/update', [CouponController::class, 'update'])->name('coupon.update');
    Route::get('coupon/delete/{id?}', [CouponController::class, 'delete'])->name('coupon.delete');

    //All Activity
    Route::get('/activity/ibm', [AllActivityController::class, 'ibm'])->name('activity.ibm');
    Route::get('/activity/refrence', [AllActivityController::class, 'refrence'])->name('activity.refrence');
    Route::get('/activity/businesses', [AllActivityController::class, 'business'])->name('activity.businesses');
    // Route::get('/activity/activityAllByCircle', [AllActivityController::class, 'activityAllByCircle'])->name('activity.allActivityByCircle');
    Route::get('/activity/ibm/vp', [AllActivityController::class, 'ibmVp'])->name('activity.ibmVp');
    Route::get('/activity/refrence/vp', [AllActivityController::class, 'refrenceVp'])->name('activity.refrenceVp');
    Route::get('/activity/businesses/vp', [AllActivityController::class, 'businessVp'])->name('activity.businessesVp');


    Route::get('/circle/{id}/report', [CircleController::class, 'report'])->name('circle.report');


    //Specific ask

    Route::get('/specific-ask/all-index', [SpecificAskController::class, 'allIndex'])->name('specificask.allIndex');
    Route::get('/specific-ask/index', [SpecificAskController::class, 'index'])->name('specificask.index');
    Route::get('/specific-ask/create', [SpecificAskController::class, 'create'])->name('specificask.create');
    Route::post('/specific-ask/store', [SpecificAskController::class, 'store'])->name('specificask.store');
    Route::get('/specific-ask/edit/{id?}', [SpecificAskController::class, 'edit'])->name('specificask.edit');
    Route::post('/specific-ask/update', [SpecificAskController::class, 'update'])->name('specificask.update');
    Route::post('/specific-ask/delete/{id?}', [SpecificAskController::class, 'delete'])->name('specificask.delete');
});

Route::get('/main-event-thankYouVisitor', [ConEventController::class, 'thankYouUser'])->name('main.event.thankYouUser');
// Route::get('/main-event-thankYouUser', [ConEventController::class, 'thankYouUser'])->name('main.event.thankYouUser');
Route::post('/main-event/conquer-user-store', [ConEventController::class, 'conquerUserStore'])->name('conquer.user.form.store');

Route::get('/main-event', [ConEventController::class, 'main'])->name('main.event');
Route::get('/main-event-thankYou', [ConEventController::class, 'thankYou'])->name('main.event.thankYou');
Route::get('/main-event/visitor/{id?}', [ConEventController::class, 'visitor'])->name('main.event.visitor');
Route::get('/main-event/visitor/login/{id?}', [ConEventController::class, 'visitorLogin'])->name('main.event.visitorLogin');
Route::post('/main-event/visitor/registration', [ConEventController::class, 'handleVisitorRegistration'])->name('conquer.visitor.form.store');
// Route::post('/main-event/conquer-visitor-store', [ConEventController::class, 'conquerVisitorStore'])->name('conquer.visitor.form.store');

Route::get('/main-event-login/{id?}', [ConEventController::class, 'eventLogin'])->name('main.event.login');

Route::post('/main-event/conquer-event-login', [ConEventController::class, 'conEventLogin'])->name('conquer.event.user.login');

Route::post('/main-event/visitor-login', [ConEventController::class, 'visitorLoginCheck'])->name('visitor.login.check');
Route::get('/visitor/dashboard', [ConEventController::class, 'visitorDashboard'])->name('visitor.dashboard');


Route::post('/main-event/visitor-register-event', [ConEventController::class, 'registerFromVisitor'])->name('visitor.register.dash');

Route::get('/event/{id}/view-members-visitors', [SlotController::class, 'userListViewforVisitors'])->name('event.viewMembersForVisitors');

Route::get('/visitorLogout', [ConEventController::class, 'logoutVisitor'])->name('visitor.logout');

Route::post('slotbooking/visitor/{id?}', [SlotController::class, 'slotBookingVisitor'])->name('slotbooking.visitor');

Route::get('/visitorProfile', [VisitorFormController::class, 'updateVisitorProfile'])->name('visitor.profile');

Route::post('visitor/update/{id?}', [VisitorFormController::class, 'profileUpdate'])->name('visitor.profileUpdate');

Route::post('/razorpay-payment-eventPaymentVisitor', [PaymentController::class, 'eventPaymentVisitor'])->name('razorpay.payment.eventPaymentVisitor');

Route::get('/visitor/event/index', [EventController::class, 'eventIndex'])->name('visitor.eventIndex');

Route::get('/profileView/{id?}', [SlotController::class, 'profileViewMember'])->name('viewMember.profile');

Route::get('/profileViewUser/{id?}', [SlotController::class, 'profileViewUser'])->name('viewMember.profileUser');

Route::put('/slotBooking/{id}/updateStatus', [EventController::class, 'slotBookingUpdateStatus'])->name('slotBooking.updateStatus');

Route::get('visitorSlotbooking/list/{id?}', [SlotController::class, 'visitorSlotBookingRequests'])->name('visitorSlotBooking.list');

// Route::post('/validate-coupon', [CouponController::class, 'validateCoupon'])->name('validate.coupon');
Route::post('/validate-coupon', [CouponController::class, 'validateCouponCode'])->name('visitor.validateCouponCode');

//Login with otp

// Route::get('/otp-login', [OTPLoginController::class, 'showLoginForm'])->name('otp.login.form');
// // Route to handle OTP login form submission
// Route::post('/otp-login', [OTPLoginController::class, 'OTPlogin'])->name('otp.login');
// // Route to resend the OTP
// Route::get('/resend-otp', [OTPLoginController::class, 'resendOTP'])->name('resend.otp');



//login with otp

Route::get('otp/request', [OTPLoginController::class, 'showOTPRequestForm'])->name('otp.request');
Route::post('otp/request', [OTPLoginController::class, 'sendOTP']);
Route::get('otp/verify', [OTPLoginController::class, 'showOTPVerificationForm'])->name('otp.verify');
Route::post('otp/verify', [OTPLoginController::class, 'verifyOTP']);
Route::post('otp/resend', [OTPLoginController::class, 'resendOTP'])->name('otp.resend');


// Route::post('/otp/verify', [OTPLoginController::class, 'verifyOTP'])->name('otp.verify');
// Route::post('/otp/resend', [OTPLoginController::class, 'resendOTP'])->name('otp.resend');
// Route::get('/otp/verify', [OTPLoginController::class, 'showVerifyOtpForm'])->name('otp.showVerifyOtpForm');

//privacypolicy
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index']);


Route::get('/memberPayment/{paymentData}', [CircleMemberController::class, 'memberPayment'])->name('memberPayment');

Route::post('/membership-payment', [PaymentController::class, 'membershipPayment'])->name('razorpay.payment.membershipPayment');


//event registration for outsider
Route::get('/event-link/{slug}', [EventController::class, 'eventLink'])->name('event.link')->middleware('signed');

// Route::get('/event/{slug}', [EventController::class, 'eventLink'])->name('event.link');
Route::post('/store-user-details', [EventController::class, 'storeUserDetails'])->name('storeUserDetails');
Route::post('/check-registration', [EventController::class, 'checkRegistration'])->name('checkRegistration');
Route::post('/razorpay-payment-userEventPayment', [PaymentController::class, 'userEventPayment'])->name('razorpay.payment.userEventPayment');
Route::post('/userOfflinePayment', [PaymentController::class, 'userOfflinePayment'])->name('eventPayment.userOfflinePayment');
