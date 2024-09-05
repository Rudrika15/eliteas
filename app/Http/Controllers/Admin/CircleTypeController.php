<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Franchise;
use App\Models\CircleType;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class CircleTypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circletype = CircleType::where('status', 'Active')->paginate(10);
            return view('admin.circletype.index', compact('circletype'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circletype = CircleType::findOrFail($id);
            return response()->json($circletype);
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            $circletype = CircleType::all();
            return view('admin.circletype.create', compact('circletype'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'circleTypeName' => 'required',
        ]);

        try {
            $circletype = new CircleType();
            $circletype->circleTypeName = $request->circleTypeName;
            $circletype->status = 'Active';
            $circletype->save();

            return redirect()->route('circletype.index')->with('success', 'Circle Type Created Successfully!');
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
            $circletype = CircleType::find($id);
            return view('admin.circletype.edit', compact('circletype'));
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
            'id' => 'required|exists:circle_types,id',
            'circleTypeName' => 'required',
        ]);

        try {
            $circletype = CircleType::find($request->id);

            if (!$circletype) {
                return redirect()->route('circletype.index')->with('error', 'Circle Type not found.');
            }

            $circletype->circleTypeName = $request->circleTypeName;
            $circletype->status = 'Active';
            $circletype->save();

            return redirect()->route('circletype.index')->with('success', 'Circle Type updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('circletype.index')->with('error', 'Failed to update Circle Type details.');
        }
    }


    public function delete(Request $request, $id)
    {
        try {
            $circletype = CircleType::find($id);

            if (!$circletype) {
                return redirect()->route('circletype.index')->with('error', 'Circle Type not found.');
            }

            $circletype->status = 'Deleted';
            $circletype->save();

            return redirect()->route('circletype.index')->with('success', 'Circle Type deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('circletype.index')->with('error', 'Failed to delete Circle Type.');
        }
    }
}
