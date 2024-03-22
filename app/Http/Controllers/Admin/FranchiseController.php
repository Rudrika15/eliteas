<?php

namespace App\Http\Controllers\Admin;

use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use DataTables;
use App\Http\Controllers\Controller;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $franchises = Franchise::where('status', 'Active')->get();
            return view('admin.franchise.index', compact('franchises'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $franchises = Franchise::findOrFail($id);
            return response()->json($franchises);
        } catch (\Throwable $th) {
            //throw $th

            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $franchises = Franchise::all();
            return view('admin.franchise.create', compact('franchises'));
        } catch (\Throwable $th) {
            //throe $th
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'franchiseName' => 'required',
            'franchiseContactDetails' => 'required',
        ]);

        try {
            $franchises = new Franchise();
            $franchises->franchiseName = $request->franchiseName;
            $franchises->franchiseContactDetails = $request->franchiseContactDetails;
            $franchises->status = 'Active';
            $franchises->save();

            return redirect()->route('franchise.index')->with('success', 'Franchise Created Successfully!');
        } catch (\Throwable $th) {
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $franchises = Franchise::find($id);
            return view('admin.franchise.edit', compact('franchises'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:franchises,id',
            'franchiseName' => 'required',
            'franchiseContactDetails' => 'required',
        ]);

        try {
            $franchise = Franchise::find($request->id);

            if (!$franchise) {
                return redirect()->route('franchise.index')->with('error', 'Franchise not found.');
            }

            $franchise->franchiseName = $request->franchiseName;
            $franchise->franchiseContactDetails = $request->franchiseContactDetails;
            $franchise->status = 'Active';
            $franchise->save();

            return redirect()->route('franchise.index')->with('success', 'Franchise details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('franchise.index')->with('error', 'Failed to update franchise details.');
        }
    }


    public function delete($id)
    {
        try {
            $franchise = Franchise::find($id);

            if (!$franchise) {
                return redirect()->route('franchise.index')->with('error', 'Franchise not found.');
            }

            $franchise->status = 'Deleted';
            $franchise->save();

            return redirect()->route('franchise.index')->with('success', 'Franchise deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('franchise.index')->with('error', 'Failed to delete franchise.');
        }
    }
}
