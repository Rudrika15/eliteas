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
        try {
            // Validate the incoming request
            $request->validate([
                'title' => 'required|string|max:255',
                'fees' => 'required|numeric',
                'type' => 'required|string|max:255',
                'meetingLink' => 'nullable|url',
                'venue' => 'nullable|string|max:255',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'duration' => 'nullable|string|max:255',
                'note' => 'nullable|string',
                'trainerId' => 'nullable|array',
                'trainerId.*' => 'nullable|integer|exists:users,id',
                'externalTrainerId' => 'nullable|array',
                'externalTrainerId.*' => 'nullable|integer|exists:external_trainers,id',
                'trainerId2' => 'nullable|integer|exists:users,id',
                'externalTrainerId2' => 'nullable|integer|exists:external_trainers,id',
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

            // Add trainers to the Training_trainers table if present in the request
            $trainers = [
                $request->trainerId ?? [],
                $request->externalTrainerId ?? [],
                $request->trainerId2 ?? null,
                $request->externalTrainerId2 ?? null,
            ];

            foreach ($trainers as $key => $values) {
                if (is_array($values)) {
                    foreach ($values as $value) {
                        if (!is_null($value)) {
                            DB::table('trainings_trainers')->insert([
                                'trainingId' => $training->id,
                                'userId' => $value,
                                'status' => 'Active',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                } elseif (!is_null($values)) {
                    DB::table('trainings_trainers')->insert([
                        'trainingId' => $training->id,
                        'userId' => $values,
                        'status' => 'Active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Redirect the user after successful submission
            return redirect()->route('training.index')->with('success', 'Training details saved successfully.');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, $request->fullUrl());

            // Redirect with error message
            return redirect()->back()->with('error', 'Failed to save training details.');
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
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'fees' => 'required|numeric',
                'type' => 'required|string|max:255',
                'meetingLink' => 'nullable|url',
                'venue' => 'nullable|string|max:255',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'duration' => 'nullable|string|max:255',
                'note' => 'nullable|string',
                'trainerId' => 'nullable|array',
                'trainerId.*' => 'nullable|integer|exists:users,id',
                'externalTrainerId' => 'nullable|array',
                'externalTrainerId.*' => 'nullable|integer|exists:external_trainers,id',
                'trainerId2' => 'nullable|integer|exists:users,id',
                'externalTrainerId2' => 'nullable|integer|exists:external_trainers,id',
            ]);

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
            $training->save(); // Use save() instead of update()

            // Delete all trainers of the training
            DB::table('trainings_trainers')->where('trainingId', $training->id)->delete();

            // Add trainers to the Training_trainers table if present in the request
            $trainers = [
                $request->input('trainerId') ?? [],
                $request->input('externalTrainerId') ?? [],
                $request->input('trainerId2'),
                $request->input('externalTrainerId2'),
            ];

            foreach ($trainers as $value) {
                if (is_array($value)) {
                    foreach ($value as $trainerId) {
                        if (!is_null($trainerId)) {
                            DB::table('trainings_trainers')->insert([
                                'trainingId' => $training->id,
                                'userId' => $trainerId,
                                'status' => 'Active',
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                } elseif (!is_null($value)) {
                    DB::table('trainings_trainers')->insert([
                        'trainingId' => $training->id,
                        'userId' => $value,
                        'status' => 'Active',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()->route('training.index')->with('success', 'Training details updated successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->back()->with('error', 'Failed to update training details.');
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
            ErrorLogger::logError($th, $request->fullUrl());
            return response()->json(['error' => 'An error occurred while fetching trainer details'], 500);
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
            ErrorLogger::logError($th, $request->fullUrl());
            return response()->json(['error' => 'An error occurred while fetching internal trainer details'], 500);
        }
    }
}
