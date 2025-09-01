<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingFeedback;
use App\Models\TrainingMaster;
use App\Models\TrainingRegister;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingFeedbackController extends Controller
{

    public function __construct()
    {
        // Apply middleware for circle type-related permissions
        $this->middleware('permission:training-feedback-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:training-feedback-index-all', ['only' => ['index', 'view']]);
        $this->middleware('permission:training-feedback-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:training-feedback-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:training-feedback-delete', ['only' => ['delete']]);
    }


    public function adminIndex(Request $request, $id)
    {
        try {
            $trainingFeedback = TrainingFeedback::where('trainingId', $id)->paginate(10);
            if ($trainingFeedback->isEmpty()) {
                return redirect()->route('training.index')->with('error', 'No feedback found for this training.');
            }
            return view('admin.trainingFeedback.adminIndex', compact('trainingFeedback'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }


    public function index(Request $request)
    {
        try {

            $user = auth()->user();
            $trainingFeedback = TrainingFeedback::where('status', 'Active')->where('userId', $user->id)->orderBy('id', 'desc')->paginate(10);
            return view('admin.trainingFeedback.adminIndex', compact('trainingFeedback'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function create(Request $request, $id = null)
    {
        try {
            $trainingFeedback = TrainingFeedback::where('trainingId', $id)->where('userId', Auth::user()->id)->where('status', 'Active')->get();
            return view('admin.trainingFeedback.create', compact('id', 'trainingFeedback'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'trainingName' => 'required',
        // ]);

        try {
            $trainingFeedback = new TrainingFeedback();
            $trainingFeedback->trainingId = $request->trainingId;
            $trainingFeedback->userId = Auth::user()->id;
            $trainingFeedback->feedback = $request->feedback;
            $trainingFeedback->status = 'Active';
            $trainingFeedback->save();
            return redirect()->route('trainingFeedback.memberIndex')->with('success', 'Training Feedback Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $trainingFeedback = TrainingFeedback::find($id);
            return view('admin.trainingFeedback.edit', compact('trainingFeedback'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    // public function update(Request $request)
    // {
    //     $this->validate($request, [
    //         'id' => 'required|exists:training_feedback,id',
    //         // 'trainingName' => 'required',
    //     ]);

    //     try {
    //         $trainingFeedback = TrainingFeedback::find($request->id);

    //         if (!$trainingFeedback) {
    //             return redirect()->route('trainingFeedback.index')->with('error', 'Training Feedback not found.');
    //         }

    //         $trainingFeedback->trainingName = $request->trainingName;
    //         $trainingFeedback->status = 'Active';
    //         $trainingFeedback->save();

    //         return redirect()->route('trainingFeedback.index')->with('success', 'Training Feedback updated successfully.');
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         ErrorLogger::logError($th, $request->fullUrl());
    //         return redirect()->route('trainingFeedback.index')->with('error', 'Failed to update Training Feedback details.');
    //     }
    // }


    public function delete(Request $request, $id)
    {
        try {
            $trainingFeedback = TrainingFeedback::find($id);

            if (!$trainingFeedback) {
                return redirect()->route('trainingFeedback.index')->with('error', 'Training Feedback not found.');
            }

            $trainingFeedback->status = 'Deleted';
            $trainingFeedback->save();

            return redirect()->route('trainingFeedback.memberIndex')->with('success', 'Training Feedback deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('trainingFeedback.index')->with('error', 'Failed to delete Training Feedback.');
        }
    }

    // public function memberIndex()
    // {
    //     try {
    //         // $trainingRegisters = TrainingRegister::where('userId', Auth::user()->id)
    //         //     ->where('status', 'Active')
    //         //     ->get();


    //         $trainings = Training::where('trainingStatus', 'Publish')
    //             ->get();

    //         $findRegister = TrainingRegister::where('userId', Auth::user()->id)
    //             ->where('trainingId', $trainings->id)
    //             ->get();



    //         // $trainingIds = $trainingRegisters->pluck('trainingId');

    //         // return $trainings = Training::whereIn('id', $trainingIds)->get();

    //         return view('admin.trainingFeedback.index', compact('trainings', 'findRegister'));
    //     } catch (\Throwable $th) {
    //         throw $th;
    //         ErrorLogger::logError(
    //             $th,
    //             request()->fullUrl()
    //         );
    //         return view('servererror');
    //     }
    // }



    public function memberIndex()
    {
        try {
            // Fetch all published trainings
            $trainings = Training::where('trainingStatus', 'Publish')->get();

            // Extract training IDs from the collection
            $trainingIds = $trainings->pluck('id');

            // Fetch all registrations for the current user and these training IDs
            $findRegister = TrainingRegister::where('userId', Auth::user()->id)
                ->whereIn('trainingId', $trainingIds)
                ->get();

            $registeredTrainingIds = $findRegister->pluck('trainingId')->toArray();


            return view('admin.trainingFeedback.index', compact('trainings', 'findRegister', 'registeredTrainingIds'));
        } catch (\Throwable $th) {
            // Optional: log or rethrow the error
            return back()->with('error', 'Something went wrong: ' . $th->getMessage());
        }
    }
}
