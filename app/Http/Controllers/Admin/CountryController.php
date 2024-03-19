<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $country = Country::where('status', 'Active')->get();
            return view('admin.country.index', compact('country'));
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $country = Country::findOrFail($id);
            return response()->json($country);
        } catch (\Throwable $th) {
            //throw $th;
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $country = Country::all();
            return view('admin.country.create', compact('country'));
        } catch (\Throwable $th) {
            //throe $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'countryName' => 'required',
        ]);

        try {
            $country = new Country();
            $country->countryName = $request->countryName;
            $country->status = 'Active';
            $country->save();

            return redirect()->route('country.index')->with('success', 'Country Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $country = Country::find($id);
            return view('admin.country.edit', compact('country'));
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:countries,id',
            'countryName' => 'required',
        ]);

        try {
            $country = Country::find($request->id);

            if (!$country) {
                return redirect()->route('country.index')->with('error', 'Country not found.');
            }

            $country->countryName = $request->countryName;
            $country->status = 'Active';
            $country->save();

            return redirect()->route('country.index')->with('success', 'Country details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('country.index')->with('error', 'Failed to update country details.');
        }
    }


    public function delete($id)
    {
        try {
            $country = Country::find($id);

            if (!$country) {
                return redirect()->route('country.index')->with('error', 'Country not found.');
            }

            $country->status = 'Deleted';
            $country->save();

            return redirect()->route('country.index')->with('success', 'Country deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('country.index')->with('error', 'Failed to delete country.');
        }
    }
}
