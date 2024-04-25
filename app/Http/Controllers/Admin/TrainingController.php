<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Member;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
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
        // Validate the incoming request
        $this->validate($request, [
            'title' => 'required',
            'fees' => 'required|numeric',
            'type' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required',
        ]);

        // Create Training record for Trainer 1
        $training1 = new Training();
        $training1->title = $request->title;
        $training1->fees = $request->fees;
        $training1->type = $request->type;
        $training1->meetingLink = $request->meetingLink;
        $training1->venue = $request->venue;
        $training1->date = $request->date;
        $training1->time = $request->time;
        $training1->duration = $request->duration;
        $training1->note = $request->note;
        $training1->trainerId = $request->trainerId; // Internal Trainer 1 ID
        $training1->externalTrainerId = $request->externalTrainerId1; // External Trainer 1 ID
        $training1->save();

        // Create Training record for Trainer 2
        $training2 = new Training();
        $training2->title = $request->title;
        $training2->fees = $request->fees;
        $training2->type = $request->type;
        $training2->meetingLink = $request->meetingLink;
        $training2->venue = $request->venue;
        $training2->date = $request->date;
        $training2->time = $request->time;
        $training2->duration = $request->duration;
        $training2->note = $request->note;
        $training2->trainerId = $request->trainerId2; // Internal Trainer 2 ID
        $training2->externalTrainerId = $request->externalTrainerId2; // External Trainer 2 ID
        $training2->save();

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

    public function update(Request $request, Training $training)
    {
        // Validate the incoming request data (you may need to adjust validation rules)
        $this->validate($request, [
            'title' => 'required',
            'fees' => 'required|numeric',
            'type' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required',
        ]);

        // Update the existing Training record
        $training->trainerId = $request->memberId;
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

        // Update Trainer 1
        if ($request->has('groupMember')) {
            if ($request->input('groupMember') === 'internalMember') {
                // Update Trainer 1 internal
                $trainer1 = TrainerMaster::where('userId', $request->memberId)->first();
                if (!$trainer1) {
                    $trainer1 = new TrainerMaster();
                    $trainer1->userId = $request->memberId;
                }
                $trainer1->trainerName = $request->memberName;
                $trainer1->save();

                $user1 = User::findOrFail($trainer1->userId);
                $user1->assignRole('Trainer');
            } elseif ($request->input('groupMember') === 'externalMember') {
                // Update Trainer 1 external
                $user1 = User::where('id', $request->memberId)->first();
                if (!$user1) {
                    $user1 = new User();
                    $user1->id = $request->memberId;
                }
                $user1->firstName = $request->memberName;
                $user1->email = $request->email;
                $user1->password = Hash::make('123456');
                $user1->assignRole('Trainer');
                $user1->save();

                $trainer1 = TrainerMaster::where('userId', $user1->id)->first();
                if (!$trainer1) {
                    $trainer1 = new TrainerMaster();
                    $trainer1->userId = $user1->id;
                }
                $trainer1->trainerName = $user1->memberNameExternal;
                $trainer1->save();
            }
        }

        // Update Trainer 2
        if ($request->has('group')) {
            if ($request->input('group') === 'internal') {
                // Update Trainer 2 internal
                $trainer2 = TrainerMaster::where('userId', $request->trainerMemberId2)->first();
                if (!$trainer2) {
                    $trainer2 = new TrainerMaster();
                    $trainer2->userId = $request->trainerMemberId2;
                }
                $trainer2->trainerName = $request->trainerNameInternal;
                $trainer2->save();

                $user2 = User::findOrFail($trainer2->userId);
                $user2->assignRole('Trainer');
            } elseif ($request->input('group') === 'external') {
                // Update Trainer 2 external
                $user2 = User::where('id', $request->trainerMemberId2)->first();
                if (!$user2) {
                    $user2 = new User();
                    $user2->id = $request->trainerMemberId2;
                }
                $user2->firstName = $request->trainerNameExternal;
                $user2->email = $request->email2;
                $user2->password = Hash::make('123456'); // Set a default password or generate one securely
                $user2->assignRole('Trainer');
                $user2->save();

                $trainer2 = TrainerMaster::where('userId', $user2->id)->first();
                if (!$trainer2) {
                    $trainer2 = new TrainerMaster();
                    $trainer2->userId = $user2->id;
                }
                $trainer2->trainerName = $user2->trainerNameExternal;
                $trainer2->save();
            }
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

        $trainerMaster = TrainerMaster::all();

        if (!$trainerMaster) {
            return response()->json(['error' => 'Trainer not found'], 404);
        }

        return response()->json($trainerMaster);
    }
}
