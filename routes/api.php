<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\CircleCallController;
use App\Http\Controllers\Api\CircleMeetingMemberBusinessController;

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
    Route::get('circlecalls', [CircleCallController::class, 'index']);
    Route::get('circlecalls/{id}', [CircleCallController::class, 'view']);
    Route::post('circlecalls', [CircleCallController::class, 'create']);
    Route::put('circlecalls-update/{id}', [CircleCallController::class, 'update']);
    Route::delete('circlecalls/{id}', [CircleCallController::class, 'delete']);


    // Circle Meeting Business Giver

    Route::get('circle-meeting-member-businesses', [CircleMeetingMemberBusinessController::class, 'index']);
    Route::get('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'view']);
    Route::post('circle-meeting-member-businesses/create', [CircleMeetingMemberBusinessController::class, 'create']);
    Route::put('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'update']);
    Route::delete('circle-meeting-member-businesses/{id}', [CircleMeetingMemberBusinessController::class, 'delete']);
});
