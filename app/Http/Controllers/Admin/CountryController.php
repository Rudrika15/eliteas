<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{

    public function __construct()
    {
        // Apply middleware for country-related permissions
        $this->middleware('permission:country-index', ['only' => ['index', 'show']]);
        $this->middleware('permission:country-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country-delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        try {
            $country = Country::where('status', 'Active')->paginate(10);
            return view('admin.country.index', compact('country'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
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
            ErrorLogger::logError($th, request()->fullUrl());
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
            ErrorLogger::logError($th, request()->fullUrl());
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

            return redirect()->route('country.create')->with('success', 'Country Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
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
            ErrorLogger::logError($th, request()->fullUrl());
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
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
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
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('country.index')->with('error', 'Failed to delete country.');
        }
    }
}
