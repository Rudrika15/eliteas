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
        // return $request;
        // Validate the incoming request
        $this->validate($request, [
            // Add your validation rules here
        ]);

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

        // Add trainers to the Training_trainers table
        $trainers = [
            ['trainerId' => $request->trainerId1, 'externalTrainerId' => $request->externalTrainerId1],
            ['trainerId' => $request->trainerId2, 'externalTrainerId' => $request->externalTrainerId2]
        ];

        $trainerId1 = $request->trainerId;
        $externalTrainerId1 = $request->externalTrainerId;

        $trainerId2 = $request->trainerId2;
        $externalTrainerId2 = $request->externalTrainerId2;

        $userId1 = $trainerId1 ? $trainerId1 : $externalTrainerId1;
        $userId2 = $trainerId2 ? $trainerId2 : $externalTrainerId2;

        DB::table('trainings_trainers')->insert([
            ['trainingId' => $training->id, 'userId' => $userId1, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['trainingId' => $training->id, 'userId' => $userId2, 'status' => 'Active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Redirect the user after successful submission
        return redirect()->route('training.index')->with('success', 'Training details saved successfully.');
    }




    public function edit($id)
    {
        try {
            $training = Training::find($id);
            $trainer = TrainerMaster::where('status', 'Active')->get();

            return view('admin.training.edit', compact('training', 'trainer'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request, $id)
    {
        return $request;

        // Validate the incoming request
        $this->validate($request, [
            'title' => 'required',
            'fees' => 'required|numeric',
            'type' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required',
        ]);

        // Find the training record to update
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
        $training->trainerId = $request->trainerId ? $request->trainerId : ($request->trainerId2 ? $request->trainerId2 : null); // Internal Trainer 1 ID
        $training->externalTrainerId = $request->externalTrainerId ? $request->externalTrainerId : ($request->externalTrainerId2 ? $request->externalTrainerId2 : null); // External Trainer 1 ID
        $training->save();

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
}
