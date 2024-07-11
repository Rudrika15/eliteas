<?php

namespace App\Http\Controllers\Admin;

use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;
use App\Models\CircleType;

class CircleTypeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circletype = CircleType::where('status', 'Active')->paginate(10);
            return view('admin.circletype.index', compact('circletype'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $circletype = CircleType::findOrFail($id);
            return response()->json($circletype);
        } catch (\Throwable $th) {
            //throw $th
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $circletype = CircleType::all();
            return view('admin.circletype.create', compact('circletype'));
        } catch (\Throwable $th) {
            //throe $th
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
            throw $th;
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $circletype = CircleType::find($id);
            return view('admin.circletype.edit', compact('circletype'));
        } catch (\Throwable $th) {
            throw $th;
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
            return redirect()->route('circletype.index')->with('error', 'Failed to update Circle Type details.');
        }
    }


    public function delete($id)
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
            return redirect()->route('circletype.index')->with('error', 'Failed to delete Circle Type.');
        }
    }
}
