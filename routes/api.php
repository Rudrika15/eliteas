<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CircleController;
use App\Http\Controllers\Api\TrainingController;
// use App\Http\Controllers\Api\CircleMeetingMemberBusinessController;
use App\Http\Controllers\Api\FranchiseController;
use App\Http\Controllers\Api\CircleCallController;
use App\Http\Controllers\Api\CircleTypeController;
use App\Http\Controllers\Api\CircleMemberController;
use App\Http\Controllers\Api\CircleMeetingController;
use App\Http\Controllers\Api\TrainerMasterController;
use App\Http\Controllers\Api\ForgetPasswordController;
use App\Http\Controllers\Api\CircleMeetingMembersController;
use App\Http\Controllers\Api\CircleMeetingMemberBusinessController;
use App\Http\Controllers\Api\CircleMeetingMemberReferenceController;
use App\Http\Controllers\Api\MeetingInvitationController;
use App\Models\CircleMember;

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

//forgot password
Route::post('/forgot-password', [ForgetPasswordController::class, 'forgotPassword']);
// Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword']);

// Route::post('circle-meeting-member-references-create', [CircleMeetingMemberReferenceController::class, 'create']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user/profile', [LoginController::class, 'profile']);

    Route::post('/user/member/update', [LoginController::class, 'memberUpdate']);
    Route::post('/user/member/updateBillingAddress', [LoginController::class, 'billingAddressUpdate']);
    Route::post('/user/member/updateContactDetails', [LoginController::class, 'contactDetailsUpdate']);
    Route::post('/user/member/updateTopsProfile', [LoginController::class, 'topsProfileUpdate']);


    // Admin side profile change
    Route::post('/members/{id}', [LoginController::class, 'memberUpdateAdmin']);
    // Route::put('/members/{id}', [MemberController::class, 'update']);


    // Circl 1:1 Call 
    Route::get('circlecalls-index', [CircleCallController::class, 'index']);
    Route::get('circlecalls-view/{id}', [CircleCallController::class, 'view']);
    Route::post('circlecalls-create', [CircleCallController::class, 'create']);
    Route::post('circlecalls-update/{id}', [CircleCallController::class, 'update']);
    Route::get('circlecalls-delete/{id}', [CircleCallController::class, 'delete']);




    // Circle Meeting Business Giver
    Route::get('circle-meeting-member-businesses', [CircleMeetingMemberBusinessController::class, 'index']);
    Route::get('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'view']);
    Route::post('circle-meeting-member-businesses/create', [CircleMeetingMemberBusinessController::class, 'create']);
    Route::put('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'update']);
    Route::delete('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'delete']);

    // Reference Giver

    Route::get('circle-meeting-member-references-index', [CircleMeetingMemberReferenceController::class, 'index']);
    Route::get('circle-meeting-member-references/{id}', [CircleMeetingMemberReferenceController::class, 'view']);
    Route::post('circle-meeting-member-references-create', [CircleMeetingMemberReferenceController::class, 'create']);
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
    Route::post('/invitation', [MeetingInvitationController::class, 'invitation']);
});
