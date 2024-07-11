<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Franchise;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use App\Models\TrainingTrainers;
use App\Exports\TrainersListExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class TrainerMasterController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trainer = TrainerMaster::where('status', 'Active')->paginate(10);
            return view('admin.trainerMaster.index', compact('trainer'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $trainer = TrainerMaster::findOrFail($id);
            return response()->json($trainer);
        } catch (\Throwable $th) {
            //throw $th
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $trainer = TrainerMaster::all();
            return view('admin.trainerMaster.create', compact('trainer'));
        } catch (\Throwable $th) {
            //throe $th
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
                'contactNo' => 'required|unique:users,contactNo',
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
                $trainer->status = 'Active';
                $trainer->save();
            } else if ($request->type == 'internalMember') {
                // Find the user by ID
                $user = User::find($request->trainerId);
                if (!$user) {
                    return redirect()->back()->with('error', 'User not found.');
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
            throw $th;
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
            throw $th;
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
            throw $th;
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
            throw $th;
            return view('servererror');
        }
    }

    public function trainingWiseTrainerList(Request $request)
    {
        try {
            $trainers = TrainingTrainers::where('status', 'Active')->paginate(10);
            return view('admin.trainerMaster.trainingWiseTrainerList', compact('trainers'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    //     public function trainerListExport()
    // {
    //     return Excel::download(new TrainersListExport, 'trainers.xlsx');
    // }

}
