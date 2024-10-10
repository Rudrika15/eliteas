<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Member;
use App\Models\Training;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\TrainerMaster;
use App\Models\TrainingTrainers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class TrainingController extends Controller
{

    public function __construct()
    {

        // Apply middleware for event-related permissions
        $this->middleware('permission:training-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:training-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:training-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:training-delete', ['only' => ['delete']]);
        $this->middleware('permission:training-get-trainer-details', ['only' => ['getTrainerDetails']]);
        $this->middleware('permission:training-get-internal-details', ['only' => ['getInternalDetails']]);
    }

    public function index(Request $request)
    {
        try {

            $training = Training::with('trainer')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);

            return view('admin.training.index', compact('training'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
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
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
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
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function store(Request $request)
    {

        return $request;


        try {
            // Validate the incoming request
            $request->validate([]);
            // return request();
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
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }






    public function edit($id)
    {
        try {
            // $training = Training::find($id);
            $training = Training::where('id', $id)->first();

            $trainer = TrainerMaster::where('status', 'Active')->get();

            return view('admin.training.edit', compact('training', 'trainer'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request
            $validatedData = $request->validate([]);

            // Update the fields with validated data
            $training = Training::findOrFail($id);
            $training->title = $request->title;
            $training->fees = $request->fees;
            $training->type = $request->type;
            $training->meetingLink = $request->meetingLink;
            $training->venue = $request->venue;
            $training->date = $request->date;
            $training->time = $request->time;
            $training->duration = $request->duration;
            $training->note = $request->note;
            $training->update();

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
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
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
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
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
        try {
            $trainerMasters = TrainerMaster::where('type', 'externalMember')
                ->where('status', 'Active')
                ->with('users')
                ->get();

            if ($trainerMasters->isEmpty()) {
                return response()->json(['error' => 'Trainers not found'], 404);
            }

            return response()->json($trainerMasters);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function getInternalTrainerDetails(Request $request)
    {
        try {
            $internalTrainerMasters = TrainerMaster::where('type', 'internalMember')
                ->where('status', 'Active')
                ->with('users')
                ->with('members')
                ->get();

            if ($internalTrainerMasters->isEmpty()) {
                return response()->json(['error' => 'Trainers not found'], 404);
            }

            return response()->json($internalTrainerMasters);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
}
