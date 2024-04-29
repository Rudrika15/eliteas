<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\Admin\CircleController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Admin\CircleCallController;
use App\Http\Controllers\Admin\CircleTypeController;
use App\Http\Controllers\Admin\CircleMemberController;
use App\Http\Controllers\Admin\CircleMeetingController;
use App\Http\Controllers\Admin\TrainerMasterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\MembershipTypeController;
use App\Http\Controllers\Admin\BusinessCategoryController;
use App\Http\Controllers\Admin\TrainingCategoryController;
use App\Http\Controllers\Admin\CircleMeetingMembersController;
use App\Http\Controllers\Admin\CircleMemberActivityController;
use App\Http\Controllers\Admin\CircleMeetingMemberBusinessController;
use App\Http\Controllers\Admin\CircleMeetingMemberReferenceController;

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




Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);


    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/franchise/index', [FranchiseController::class, 'index'])->name('franchise.index');
    Route::get('franchise/show/{id?}', [FranchiseController::class, 'show'])->name('franchise.show');
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




    Route::get('/trainer/index', [TrainerMasterController::class, 'index'])->name('trainer.index');
    Route::get('trainer/show/{id?}', [TrainerMasterController::class, 'show'])->name('trainer.show');
    Route::get('trainer/create', [TrainerMasterController::class, 'create'])->name('trainer.create');
    Route::post('trainer/store', [TrainerMasterController::class, 'store'])->name('trainer.store');
    Route::get('trainer/edit/{id?}', [TrainerMasterController::class, 'edit'])->name('trainer.edit');
    Route::post('trainer/update', [TrainerMasterController::class, 'update'])->name('trainer.update');
    Route::get('trainer/delete/{id?}', [TrainerMasterController::class, 'delete'])->name('trainer.delete');

    Route::get('/training/index', [TrainingController::class, 'index'])->name('training.index');
    Route::get('training/show/{id?}', [TrainingController::class, 'show'])->name('training.show');
    Route::get('training/create', [TrainingController::class, 'create'])->name('training.create');
    Route::post('training/store', [TrainingController::class, 'store'])->name('training.store');
    Route::get('training/edit/{id?}', [TrainingController::class, 'edit'])->name('training.edit');
    Route::post('training/update', [TrainingController::class, 'update'])->name('training.update');
    Route::get('training/delete/{id?}', [TrainingController::class, 'delete'])->name('training.delete');

    Route::get('/circletype/index', [CircleTypeController::class, 'index'])->name('circletype.index');
    Route::get('circletype/show/{id?}', [CircleTypeController::class, 'show'])->name('circletype.show');
    Route::get('circletype/create', [CircleTypeController::class, 'create'])->name('circletype.create');
    Route::post('circletype/store', [CircleTypeController::class, 'store'])->name('circletype.store');
    Route::get('circletype/edit/{id?}', [CircleTypeController::class, 'edit'])->name('circletype.edit');
    Route::post('circletype/update', [CircleTypeController::class, 'update'])->name('circletype.update');
    Route::get('circletype/delete/{id?}', [CircleTypeController::class, 'delete'])->name('circletype.delete');

    Route::get('/circle/index', [CircleController::class, 'index'])->name('circle.index');
    Route::get('circle/show/{id?}', [CircleController::class, 'show'])->name('circle.show');
    Route::get('circle/create', [CircleController::class, 'create'])->name('circle.create');
    Route::post('circle/store', [CircleController::class, 'store'])->name('circle.store');
    Route::get('circle/edit/{id?}', [CircleController::class, 'edit'])->name('circle.edit');
    Route::post('circle/update', [CircleController::class, 'update'])->name('circle.update');
    Route::get('circle/delete/{id?}', [CircleController::class, 'delete'])->name('circle.delete');

    Route::get('/circlemember/index', [CircleMemberController::class, 'index'])->name('circlemember.index');
    Route::get('circlemember/show/{id?}', [CircleMemberController::class, 'show'])->name('circlemember.show');
    Route::get('circlemember/create', [CircleMemberController::class, 'create'])->name('circlemember.create');
    Route::post('circlemember/store', [CircleMemberController::class, 'store'])->name('circlemember.store');
    Route::get('circlemember/edit/{id?}', [CircleMemberController::class, 'edit'])->name('circlemember.edit');
    Route::post('circlemember/update/{id?}', [CircleMemberController::class, 'update'])->name('circlemember.update');
    Route::get('circlemember/delete/{id?}', [CircleMemberController::class, 'delete'])->name('circlemember.delete');

    //member activity
    Route::get('circlemember/activity/{id?}', [CircleMemberActivityController::class, 'activity'])->name('circlemember.activity');

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
    // old get member
    Route::get('get-member', [CircleCallController::class, 'getMember'])->name('getMember');

    // get external trainer list
    // Route::get('get-external-trainers' , [TrainingController::class, 'getExternalTrainers'])->name('getExternalTrainers');

    Route::get('/get-trainer-details', [TrainingController::class, 'getTrainerDetails'])->name('getTrainerDetails');


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

    Route::get('/busGiver/index', [CircleMeetingMemberBusinessController::class, 'index'])->name('busGiver.index');
    Route::get('busGiver/show/{id?}', [CircleMeetingMemberBusinessController::class, 'show'])->name('busGiver.show');
    Route::get('busGiver/create/{id?}', [CircleMeetingMemberBusinessController::class, 'create'])->name('busGiver.create');
    Route::post('busGiver/store', [CircleMeetingMemberBusinessController::class, 'store'])->name('busGiver.store');
    Route::get('busGiver/edit/{id?}', [CircleMeetingMemberBusinessController::class, 'edit'])->name('busGiver.edit');
    Route::post('busGiver/update/{id?}', [CircleMeetingMemberBusinessController::class, 'update'])->name('busGiver.update');
    Route::get('busGiver/delete/{id?}', [CircleMeetingMemberBusinessController::class, 'delete'])->name('busGiver.delete');

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

    Route::get('/schedule/dashIndex', [ScheduleController::class, 'dashIndex'])->name('schedule.dashIndex');
    Route::get('/schedule/dashEdit/{id?}', [ScheduleController::class, 'dashEdit'])->name('schedule.dashEdit');
    Route::post('/schedule/dashUpdate', [ScheduleController::class, 'dashUpdate'])->name('schedule.dashUpdate');



    //Profile Update

    Route::get('member-update/{id?}', [ProfileController::class, 'member'])->name('member');
    Route::post('update', [ProfileController::class, 'memberUpdate'])->name('member.update');

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
    Route::post('/razorpay-payment-invite', [PaymentController::class, 'invitePayment'])->name('razorpay.payment.invite');

    // invite person
    Route::post('/invite', [HomeController::class, 'invitation'])->name('invite.person');
    //testimonials user side
    Route::get('testimonial/index', [TestimonialController::class, 'index'])->name('testimonial.index');
    Route::get('testimonial/create', [TestimonialController::class, 'create'])->name('testimonial.create');
    Route::post('testimonial/store', [TestimonialController::class, 'store'])->name('testimonial.store');

    //Testimonial View Admin Side
    Route::get('testimonials/indexAdmin', [TestimonialController::class, 'indexAdmin'])->name('testimonials.indexAdmin');


    //Membership Master
    Route::get('/membershipType/index', [MembershipTypeController::class, 'index'])->name('membershipType.index');
    Route::get('membershipType/show/{id?}', [MembershipTypeController::class, 'show'])->name('membershipType.show');
    Route::get('membershipType/create', [MembershipTypeController::class, 'create'])->name('membershipType.create');
    Route::post('membershipType/store', [MembershipTypeController::class, 'store'])->name('membershipType.store');
    Route::get('membershipType/edit/{id?}', [MembershipTypeController::class, 'edit'])->name('membershipType.edit');
    Route::post('membershipType/update', [MembershipTypeController::class, 'update'])->name('membershipType.update');
    Route::get('membershipType/delete/{id?}', [MembershipTypeController::class, 'delete'])->name('membershipType.delete');

    Route::get('testimonial/destroy{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');
    Route::get('testimonial/archives', [TestimonialController::class, 'archives'])->name('testimonial.archives');
    Route::get('testimonial/restore/{id}', [TestimonialController::class, 'restore'])->name('testimonial.restore');
});

Route::get('/trainingRegister/{trainingId?}/{trainerId?}', [HomeController::class, 'trainingRegister'])->name('training.register');
Route::get('/invitationPay/{personName?}/{personEmail?}/{invitedPersonFirstName?}/{invitedPersonLastName?}/{amount?}', [HomeController::class, 'invitationPay'])->name('invitationPay');
// Route::post('/invitationPay', [HomeController::class, 'invitationPay'])->name('invitationPay');



// global search 
Route::get('/search', [HomeController::class, 'findMember'])->name('search');
Route::get('/searchQuery', [HomeController::class, 'search'])->name('searchQuery');
Route::post('/connect', [HomeController::class, 'connect'])->name('connect');

// my connections
Route::get('/connections/index', [HomeController::class, 'myConnections'])->name('connection.index');
