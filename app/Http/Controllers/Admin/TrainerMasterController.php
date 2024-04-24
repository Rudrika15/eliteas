<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Franchise;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'contactNo' => 'required',
        ]);

        try {

            $user = new User();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            $password = '';
            $length = 8;
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }
            $user->password = Hash::make($password);
            $user->assignRole('Trainer');
            $user->save();

            $trainer = new TrainerMaster();
            $trainer->userId = $user->id;
            $trainer->firstName = $request->firstName;
            $trainer->lastName = $request->lastName;
            $trainer->email = $user->email;
            $trainer->contactNo = $request->contactNo;
            $trainer->status = 'Active';
            $trainer->save();

            return redirect()->route('trainer.index')->with('success', 'Trainer Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
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

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:trainer_masters,id',
            'trainerName' => 'required',
        ]);

        try {
            $trainer = TrainerMaster::find($request->id);

            if (!$trainer) {
                return redirect()->route('trainer.index')->with('error', 'Trainer not found.');
            }

            $trainer->trainerName = $request->trainerName;
            $trainer->status = 'Active';
            $trainer->save();

            return redirect()->route('trainer.index')->with('success', 'Trainer details updated successfully.');
        } catch (\Throwable $th) {
            //thow $th;
            return redirect()->route('trainer.index')->with('error', 'Failed to update Trainer details.');
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
}
