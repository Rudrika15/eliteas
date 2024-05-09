<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Member;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\TrainingTrainers;
use Illuminate\Support\Facades\Hash;

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
            $trainer = Member::with('circle')->where('status', 'Active')->get();
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
        // Validate the incoming request
        $request->validate([]);

        // Create Training record
        $training = new Training();
        $training->title = $request->title;
        $training->fees = $request->fees;
        $training->type = $request->type;
        $training->meetingLink = $request->meetingLink;
        $training->venue = $request->venue;
        $training->date = $request->date;
        $training->time = $request->time;
        $training->duration = $request->duration;
        $training->note = $request->note;
        $training->save();

        // Add trainers to the Training_trainers table if present in the request
        $trainers = [
            'trainerId' => $request->trainerId ?? null,
            'externalTrainerId' => $request->externalTrainerId ?? null,
            'trainerId2' => $request->trainerId2 ?? null,
            'externalTrainerId2' => $request->externalTrainerId2 ?? null,
        ];

        foreach ($trainers as $key => $value) {
            if (!is_null($value)) {
                DB::table('trainings_trainers')->insert([
                    ['trainingId' => $training->id, 'userId' => $value, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }

        // Redirect the user after successful submission
        return redirect()->route('training.index')->with('success', 'Training details saved successfully.');
    }






    public function edit($id)
    {
        try {
            // $training = Training::find($id);
            $training = Training::where('id', $id)->first();
            
            $trainer = TrainerMaster::where('status', 'Active')->get();

            return view('admin.training.edit', compact('training', 'trainer'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validatedData = $request->validate([

        ]);

        // Update the fields with validated data
        $training = Training::findOrFail($id);
        $training->update($validatedData);

        // Add trainers to the Training_trainers table if present in the request
        $trainers = [
            'trainerId' => $request->input('trainerId'),
            'externalTrainerId' => $request->input('externalTrainerId'),
            'trainerId2' => $request->input('trainerId2'),
            'externalTrainerId2' => $request->input('externalTrainerId2'),
        ];

        // Delete all trainers of the training
        DB::table('trainings_trainers')->where('trainingId', $training->id)->delete();

        foreach ($trainers as $key => $value) {
            if (!is_null($value)) {
                // Insert the trainer into the table
                DB::table('trainings_trainers')->insert([
                    ['trainingId' => $training->id, 'userId' => $value, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }

        // Redirect the user after successful submission
        return redirect()->route('training.index')->with('success', 'Training details updated successfully.');
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


    // public function getExternalTrainer(Request $request)
    // {

    //     $exTrainer = TrainerMaster::all();

    //     return response()->json($exTrainer);
    // }


    public function getTrainerDetails(Request $request)
    {
        $trainerMasters = TrainerMaster::where('type', 'externalMember')
            ->where('status', 'Active')
            ->with('users')
            ->get();

        if ($trainerMasters->isEmpty()) {
            return response()->json(['error' => 'Trainers not found'], 404);
        }

        return response()->json($trainerMasters);
    }

    public function getInternalTrainerDetails(Request $request)
    {
        $internalTrainerMasters = TrainerMaster::where('type', 'internalMember')
            ->where('status', 'Active')
            ->with('users')
            ->with('members')
            ->get();
        return $internalTrainerMasters;
        if ($internalTrainerMasters->isEmpty()) {
            return response()->json(['error' => 'Trainers not found'], 404);
        }

        return response()->json($internalTrainerMasters);
    }
}
