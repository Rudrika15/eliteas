<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Member;
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
        // Validate the incoming request data
        $request->validate([
            // 'trainerId' => 'required',
            // 'title' => 'required',
            // 'fees' => 'required|numeric',
            // 'type' => 'required|in:Online,Offline',
            // // 'meetingLink' => 'required_if:type,Online|url',
            // // 'venue' => 'required_if:type,Offline',
            // 'date' => 'required|date',
            // 'time' => 'required|date_format:H:i',
            // 'duration' => 'required',
            // 'note' => 'nullable|string',
            // 'meetingPersonName' => 'required',
            // 'meetingPersonContact' => 'required',
            // 'meetingPersonEmail' => 'required|email',
            // 'group' => 'required|in:internal,external',
            // 'groupMember' => 'required|in:internalMember,externalMember',
            // 'contactPersonName' => $request->input('group') == 'internal' ? 'required_if:group,internal' : 'required_if:group,external',
            // 'contactPersonContact' => 'required',
            // 'contactPersonEmail' => 'required|email',
        ]);

        
        
        // Create a new Training instance and fill it with validated data
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
        // Save the training record
        $training->save();

        $trainer = new TrainerMaster();
        $trainer->userId = $request->memberId;
        $trainer->trainerName = $request->trainerName;



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
