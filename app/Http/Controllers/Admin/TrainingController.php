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

    // public function update(Request $request, $id)
    // {
    //     return $request;

    //     // Validate the incoming request
    //     $this->validate($request, [
    //         'title' => 'required',
    //         'fees' => 'required|numeric',
    //         'type' => 'required',
    //         'date' => 'required|date',
    //         'time' => 'required',
    //         'duration' => 'required',
    //     ]);

    //     // Find the training record to update
    //     $training = Training::findOrFail($id);

    //     // Update Training record
    //     $training->title = $request->title;
    //     $training->fees = $request->fees;
    //     $training->type = $request->type;
    //     $training->meetingLink = $request->meetingLink;
    //     $training->venue = $request->venue;
    //     $training->date = $request->date;
    //     $training->time = $request->time;
    //     $training->duration = $request->duration;
    //     $training->note = $request->note;
    //     $training->trainerId = $request->trainerId ? $request->trainerId : ($request->trainerId2 ? $request->trainerId2 : null); // Internal Trainer 1 ID
    //     $training->externalTrainerId = $request->externalTrainerId ? $request->externalTrainerId : ($request->externalTrainerId2 ? $request->externalTrainerId2 : null); // External Trainer 1 ID
    //     $training->save();

    //     // Redirect the user after successful update
    //     return redirect()->route('training.index')->with('success', 'Training details updated successfully.');
    // }



    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([]);

        // Find the training record
        $training = Training::findOrFail($id);

        // Update Training record
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

        // Update trainers for the training
        $trainerIds = $request->input('trainerIds', []);
        // You might want to clear existing trainers for this training before updating
        $training->trainers()->detach();
        foreach ($trainerIds as $trainerId) {
            // Attach each trainer to the training
            $training->trainers()->attach($trainerId);
        }

        // Redirect the user after successful update
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
