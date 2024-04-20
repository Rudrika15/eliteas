<?php

namespace App\Http\Controllers\Admin;

use App\Models\Franchise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TrainerMaster;

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
            'trainerName' => 'required',
        ]);

        try {
            $trainer = new TrainerMaster();
            $trainer->trainerName = $request->trainerName;
            $trainer->status = 'Active';
            $trainer->save();

            return redirect()->route('trainer.index')->with('success', 'Trainer Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
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
