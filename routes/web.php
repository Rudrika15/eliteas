<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CircleController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\CircleCallController;
use App\Http\Controllers\Admin\CircleTypeController;
use App\Http\Controllers\Admin\CircleMemberController;
use App\Http\Controllers\Admin\CircleMeetingController;
use App\Http\Controllers\Admin\TrainerMasterController;
use App\Http\Controllers\Admin\CircleMeetingMembersController;
use App\Http\Controllers\Admin\CircleMeetingMemberBusinessController;
use App\Http\Controllers\Admin\CircleMeetingMemberReferenceController;
use App\Http\Controllers\Admin\FranchiseController;

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
    Route::post('circlemember/update', [CircleMemberController::class, 'update'])->name('circlemember.update');
    Route::get('circlemember/delete/{id?}', [CircleMemberController::class, 'delete'])->name('circlemember.delete');

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
    Route::get('get-member', [CircleCallController::class, 'getMember'])->name('getMember');




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
    Route::post('refGiver/store', [CircleMeetingMemberReferenceController::class, 'store'])->name('refGiver.store');
    Route::get('refGiver/edit/{id?}', [CircleMeetingMemberReferenceController::class, 'edit'])->name('refGiver.edit');
    Route::post('refGiver/update', [CircleMeetingMemberReferenceController::class, 'update'])->name('refGiver.update');
    Route::get('refGiver/delete/{id?}', [CircleMeetingMemberReferenceController::class, 'delete'])->name('refGiver.delete');

    Route::get('/busGiver/index', [CircleMeetingMemberBusinessController::class, 'index'])->name('busGiver.index');
    Route::get('busGiver/show/{id?}', [CircleMeetingMemberBusinessController::class, 'show'])->name('busGiver.show');
    Route::get('busGiver/create', [CircleMeetingMemberBusinessController::class, 'create'])->name('busGiver.create');
    Route::post('busGiver/store', [CircleMeetingMemberBusinessController::class, 'store'])->name('busGiver.store');
    Route::get('busGiver/edit/{id?}', [CircleMeetingMemberBusinessController::class, 'edit'])->name('busGiver.edit');
    Route::post('busGiver/update', [CircleMeetingMemberBusinessController::class, 'update'])->name('busGiver.update');
    Route::get('busGiver/delete/{id?}', [CircleMeetingMemberBusinessController::class, 'delete'])->name('busGiver.delete');

    Route::get('/meetingmember/index', [CircleMeetingMembersController::class, 'index'])->name('meetingmember.index');
    Route::get('meetingmember/show/{id?}', [CircleMeetingMembersController::class, 'show'])->name('meetingmember.show');
    Route::get('meetingmember/create', [CircleMeetingMembersController::class, 'create'])->name('meetingmember.create');
    Route::post('meetingmember/store', [CircleMeetingMembersController::class, 'store'])->name('meetingmember.store');
    Route::get('meetingmember/edit/{id?}', [CircleMeetingMembersController::class, 'edit'])->name('meetingmember.edit');
    Route::post('meetingmember/update', [CircleMeetingMembersController::class, 'update'])->name('meetingmember.update');
    Route::get('meetingmember/delete/{id?}', [CircleMeetingMembersController::class, 'delete'])->name('meetingmember.delete');

    //Profile Update

    Route::get('member-update/{id?}', [ProfileController::class, 'member'])->name('member');
    Route::post('update', [ProfileController::class, 'memberUpdate'])->name('member.update');
});
