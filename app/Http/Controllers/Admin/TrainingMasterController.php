<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingMaster;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class TrainingMasterController extends Controller
{
    public function __construct()
    {
        // Apply middleware for circle type-related permissions
        $this->middleware('permission:training-master-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:training-master-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:training-master-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:training-master-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        try {
            $trainingMaster = TrainingMaster::where('status', 'Active')->paginate(10);

            return view('admin.trainingMaster.index', compact('trainingMaster'));
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
            return view('admin.trainingMaster.create');
        } catch (\Throwable $th) {
            // throe $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'trainingName' => 'required',
        ]);

        try {
            $trainingMaster = new TrainingMaster;
            $trainingMaster->trainingName = $request->trainingName;
            $trainingMaster->status = 'Active';
            $trainingMaster->save();

            return redirect()->route('trainingMaster.index')->with('success', 'Training Master Created Successfully!');
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
            $trainingMaster = TrainingMaster::find($id);

            return view('admin.trainingMaster.edit', compact('trainingMaster'));
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
            'id' => 'required|exists:training_masters,id',
            'trainingName' => 'required',
        ]);

        try {
            $trainingMaster = TrainingMaster::find($request->id);

            if (! $trainingMaster) {
                return redirect()->route('trainingMaster.index')->with('error', 'Training not found.');
            }

            $trainingMaster->trainingName = $request->trainingName;
            $trainingMaster->status = 'Active';
            $trainingMaster->save();

            return redirect()->route('trainingMaster.index')->with('success', 'Training updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return redirect()->route('trainingMaster.index')->with('error', 'Failed to update Training details.');
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $trainingMaster = TrainingMaster::find($id);

            if (! $trainingMaster) {
                return redirect()->route('trainingMaster.index')->with('error', 'Training not found.');
            }

            $trainingMaster->status = 'Deleted';
            $trainingMaster->save();

            return redirect()->route('trainingMaster.index')->with('success', 'Training deleted successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return redirect()->route('trainingMaster.index')->with('error', 'Failed to delete Training.');
        }
    }
}
