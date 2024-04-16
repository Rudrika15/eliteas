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
        // return request()->all();
        // Validate the incoming request data (you may need to add more validation rules)
        $this->validate($request, [
            'title' => 'required',
            'fees' => 'required|numeric',
            'type' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required',
        ]);

        // Create a new Training record
        $training = new Training();
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

        // Process Trainer 1
        if ($request->has('groupMember')) {
            if ($request->input('groupMember') === 'internalMember') {
                // Trainer 1 internal
                $trainer1 = new TrainerMaster();
                $trainer1->userId = $request->memberId; 
                $trainer1->trainerName = $request->memberName; 
                $trainer1->save();

                $user1 = User::findOrFail($trainer1->userId);
                $user1->assignRole('Trainer');
            } elseif ($request->input('groupMember') === 'externalMember') {
                // Trainer 1  external
                $user1 = new User();
                $user1->firstName = $request->memberName;
                $user1->email = $request->email;
                $user1->password = Hash::make('123456');
                $user1->assignRole('Trainer');
                $user1->save();

                $trainer1 = new TrainerMaster();
                $trainer1->userId = $user1->id;
                $trainer1->trainerName = $user1->memberNameExternal;
                $trainer1->save();

            }
        }

        // Trainer 2


        $training = new Training();
        $training->trainerId = $request->trainerMemberId2;
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



        if ($request->has('group')) {
            if ($request->input('group') === 'internal') {
                // Trainer 2 is internal
                $trainer2 = new TrainerMaster();
                $trainer2->userId = $request->trainerMemberId2; // Assuming trainerMemberId2 is used for internal trainers
                $trainer2->trainerName = $request->trainerNameInternal; // Assuming trainerMemberId2 is used for internal trainers
                $trainer2->save();

                // Assign 'Trainer' role to the user associated with Trainer 2
                $user2 = User::findOrFail($trainer2->userId);
                $user2->assignRole('Trainer');

            } elseif ($request->input('group') === 'external') {
                // Trainer 2 is external
                $user2 = new User();
                $user2->firstName = $request->trainerNameExternal;
                $user2->email = $request->email2;
                $user2->password = Hash::make('123456'); // Set a default password or generate one securely
                $user2->assignRole('Trainer');
                $user2->save();

                $trainer2 = new TrainerMaster();
                $trainer2->userId = $user2->id;
                $trainer2->trainerName = $user2->trainerNameExternal;
                $trainer2->save();

                // Assign 'Trainer' role to the user associated with Trainer 2
            }
        }

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

    public function update(Request $request)
    {
        $this->validate($request, [
            // 'trainerId' => 'required',

        ]);
        try {
            $id = $request->id;
            $training = Training::find($id);
            $training->trainerId = $request->trainerId;
            $training->externalTrainer = $request->trainerName;
            $training->title = $request->title;
            $training->type = $request->type;
            $training->fees = $request->fees;
            $training->venue = $request->venue;
            $training->date = $request->date;
            $training->time = $request->time;
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
