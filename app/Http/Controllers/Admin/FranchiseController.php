<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\User;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::whereHas('roles', function($query){
                $query->where('name', 'Franchise Admin');
            })->get();
            $franchises = Franchise::where('status', 'Active')->get();
            return view('admin.franchise.index', compact('franchises', 'user'));
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
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {
            $user = new User();
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->assignRole('Franchise Admin');
            $user->save();

            $franchises = new Franchise();
            $franchises->franchiseName = $request->franchiseName;
            $franchises->franchiseContactDetails = $request->franchiseContactDetails;
            $franchises->userId = $user->id;
            $franchises->status = 'Active';
            $franchises->save();

            return redirect()->route('franchise.index')->with('success', 'Franchise and User Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
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
