<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Franchise;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use App\Models\TrainingRegister;
use App\Models\TrainingTrainers;
use App\Exports\TrainersListExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class TrainerMasterController extends Controller
{


    // public function __construct()
    // {
    //     $this->middleware('permission:trainer-master-list|trainer-master-create|trainer-master-edit|trainer-master-delete');
    //     $this->middleware('permission:trainer-master-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:trainer-master-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:trainer-master-show', ['only' => ['show']]);
    //     $this->middleware('permission:trainer-master-get-member-details', ['only' => ['getMemberDetails']]);
    //     $this->middleware('permission:trainer-master-training-wise-trainer-list', ['only' => ['trainingWiseTrainerlist']]);
    //     $this->middleware('permission:trainer-master-training-register-view', ['only' => ['trainingRegisterView']]);
    // }


    public function getMemberDetails($id)
    {
        // Retrieve the member's details from the members table
        $member = Member::find($id);

        if ($member) {
            // Retrieve additional details (contact, email) from the users table
            $user = User::where('id', $member->userId)->first();

            // Return the data in JSON format
            return response()->json([
                'success' => true,
                'member' => $member,
                'contactNo' => $user->contactNo ?? null,
                'email' => $user->email ?? null
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Member not found'
            ]);
        }
    }



    public function index(Request $request)
    {
        try {
            $trainer = TrainerMaster::where('status', 'Active')->paginate(10);
            return view('admin.trainerMaster.index', compact('trainer'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $trainer = TrainerMaster::findOrFail($id);
            return response()->json($trainer);
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $circles = Circle::where('status', 'Active')->get();

            $circleMember = Member::with('circle')
                ->where('status', 'Active')
                ->get(); // Ensure 'circleId' is included

            $trainer = TrainerMaster::all();
            return view('admin.trainerMaster.create', compact('trainer', 'circles', 'circleMember'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        // Validate the request
        $validate = [];
        if ($request->type == 'externalMember') {
            $validate = [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:users,email',
                'contactNo' => 'required|unique:users,contactNo|max:10',
                // 'bio' => 'required',
                'trainerImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

        $this->validate($request, $validate);

        try {
            if ($request->type == 'externalMember') { // Change from 'group' to 'type'
                // Create a new user
                $user = new User();
                $user->firstName = $request->firstName;
                $user->lastName = $request->lastName;
                $user->email = $request->email;
                $user->contactNo = $request->contactNo;
                $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
                $password = '';
                $length = 8;
                for ($i = 0; $i < $length; $i++) {
                    $password .= $characters[rand(0, strlen($characters) - 1)];
                }
                $user->password = Hash::make($password);
                $user->save(); // Save the user to the database
                $user->assignRole('Trainer'); // Assign role to the user

                // Create a new TrainerMaster
                $trainer = new TrainerMaster();
                $trainer->userId = $user->id;
                $trainer->type = $request->type; // Change from 'group' to 'type'
                $trainer->externalMemberContact = $request->contactNo;
                $trainer->externalMemberBio = $request->bio;

                if ($request->hasFile('trainerImage')) {
                    $imageName = time() . '.' . $request->trainerImage->extension();
                    $request->trainerImage->move(public_path('img/trainerImages'), $imageName);
                    $trainer->trainerImage = $imageName;
                }

                $trainer->status = 'Active';
                $trainer->save();
            } else if ($request->type == 'internalMember') {
                // Find the user by ID
                $user = User::find($request->trainerId);
                if (!$user) {
                    return redirect()->back()->with('error', 'User not found.');
                }
                if (TrainerMaster::where('userId', $user->id)->exists()) {
                    return redirect()->back()->with('error', 'Member is already a trainer.');
                }
                $user->assignRole('Trainer'); // Assign role to the user
                $user->save();

                $trainer = new TrainerMaster();
                $trainer->userId = $user->id;
                $trainer->type = $request->type; // Change from 'group' to 'type'
                $trainer->status = 'Active';
                $trainer->save();
            }

            return redirect()->route('trainer.index')->with('success', 'Trainer Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            // Log the error or handle it gracefully
            return view('servererror');
        }
    }



    public function edit(Request $request, $id)
    {
        try {
            $trainer = TrainerMaster::find($id);
            return view('admin.trainerMaster.edit', compact('trainer'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $this->validate($request, [
            // Add validation rules for your fields if needed
        ]);

        try {

            // Find the user by ID
            $user = User::find($request->trainerId);
            if (!$user) {
                return redirect()->back()->with('error', 'User not found.');
            }

            // Find the TrainerMaster by user ID
            $trainer = TrainerMaster::where('userId', $user->id)->first();
            if (!$trainer) {
                return redirect()->back()->with('error', 'Trainer details not found.');
            }

            // Update the TrainerMaster details
            $trainer->type = $request->type;
            // Update other TrainerMaster fields if needed
            $trainer->save();

            return redirect()->route('trainer.index')->with('success', 'Trainer Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            // Log the error or handle it gracefully
            return view('servererror');
        }
    }



    function delete($id)
    {
        try {
            $trainer = TrainerMaster::find($id);
            $trainer->status = "Deleted";
            $trainer->save();

            return redirect()->route('trainer.index')->with('success', 'Trainer deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function trainingWiseTrainerList(Request $request)
    {
        try {
            $trainers = TrainingTrainers::where('status', 'Active')->paginate(10);
            return view('admin.trainerMaster.trainingWiseTrainerList', compact('trainers'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    //     public function trainerListExport()
    // {
    //     return Excel::download(new TrainersListExport, 'trainers.xlsx');
    // }

    public function trainingRegisterView()
    {
        $trainingRegister = TrainingRegister::where('status', 'Active')->paginate(10);
        return view('admin.trainerMaster.trainingRegisterView', compact('trainingRegister'));
    }
}
