<?php

namespace App\Http\Controllers\Admin;

use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        try {

            $training = Training::with('trainer')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();

            return view('admin.training.index', compact('training'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $training = Training::with('trainer')->findOrFail($id);
            return response()->json($training);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $trainer = TrainerMaster::where('status', '!=', 'Deleted')->get();
            $training = Training::with('trainer')
                ->get();
            return view('admin.training.create', compact('trainer', 'training'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'trainerId' => 'required',
            'topic' => 'required',
        ]);
        try {
            $training = new Training();
            $training->trainerId = $request->trainerId;
            $training->topic = $request->topic;
            $training->status = 'Active';

            $training->save();

            return redirect()->route('training.index')->with('success', 'Training Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $training = Training::find($id);
            $trainer = TrainerMaster::where('status', '!=', 'Deleted')->get();
            return view('admin.training.edit', compact('training', 'trainer'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'trainerId' => 'required',
            'topic' => 'required',

        ]);
        try {
            $id = $request->id;
            $training = Training::find($id);
            $training->trainerId = $request->trainerId;
            $training->topic = $request->topic;
            $training->status = 'Active';

            $training->save();


            return redirect()->route('training.index')->with('success', 'Training Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $training = Training::find($id);
            $training->status = "Deleted";
            $training->save();
            
            return redirect()->route('training.index')->with('success', 'Training Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
