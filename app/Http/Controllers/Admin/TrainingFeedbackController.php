<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingFeedback;
use App\Models\TrainingMaster;
use App\Utils\ErrorLogger;
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
            $trainingFeedback = TrainingFeedback::find($id);
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

    public function index(Request $request)
    {
        try {

            $user = auth()->user();
            $trainingFeedback = TrainingFeedback::where('status', 'Active')->where('userId', $user->id)->orderBy('id', 'desc')->paginate(10);
            return view('admin.trainingFeedback.index', compact('trainingFeedback'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            return view('admin.trainingFeedback.create');
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
            $trainingFeedback->trainingMasterId = $request->trainingMasterId;
            $trainingFeedback->userId = Auth::user()->id;
            $trainingFeedback->feedback = $request->feedback;
            $trainingFeedback->status = 'Active';
            $trainingFeedback->save();

            return redirect()->route('trainingFeedback.index')->with('success', 'Training Feed Created Successfully!');
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

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:training_feedback,id',
            // 'trainingName' => 'required',
        ]);

        try {
            $trainingFeedback = TrainingFeedback::find($request->id);

            if (!$trainingFeedback) {
                return redirect()->route('trainingFeedback.index')->with('error', 'Training Feedback not found.');
            }

            $trainingFeedback->trainingName = $request->trainingName;
            $trainingFeedback->status = 'Active';
            $trainingFeedback->save();

            return redirect()->route('trainingFeedback.index')->with('success', 'Training Feedback updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('trainingFeedback.index')->with('error', 'Failed to update Training Feedback details.');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $trainingFeedback = TrainingFeedback::find($id);

            if (!$trainingFeedback) {
                return redirect()->route('trainingFeedback.index')->with('error', 'Training Feedback not found.');
            }

            $trainingFeedback->status = 'Deleted';
            $trainingFeedback->save();

            return redirect()->route('trainingFeedback.index')->with('success', 'Training Feedback deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('trainingFeedback.index')->with('error', 'Failed to delete Training Feedback.');
        }
    }
}
