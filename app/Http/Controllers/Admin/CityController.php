<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class CityController extends Controller
{

    public function __construct()
    {
        // Apply middleware for city-related permissions
        $this->middleware('permission:city-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:city-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:city-delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        try {
            $city = City::with('country')
                ->with('state')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->paginate(10);
            return view('admin.city.index', compact('city'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {

            $city = City::findOrFail($id);
            return response()->json($city);
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
            $countries = Country::where('status', '!=', 'Deleted')->get();
            $states = State::where('status', '!=', 'Deleted')->get();
            $city = City::with('country')
                ->with('state')
                ->get();
            return view('admin.city.create', compact('countries', 'states', 'city'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cityName' => 'required',
        ]);
        try {
            $city = new City();
            $city->countryId = $request->countryId;
            $city->stateId = $request->stateId;
            $city->cityName = $request->cityName;
            $city->amount = $request->amount;
            $city->memberAmount = $request->memberAmount;
            $city->status = 'Active';

            $city->save();

            return redirect()->route('city.create')->with('success', 'City Created Successfully!');
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
            $city = City::find($id);
            $states = State::where('status', '!=', 'Deleted')->get();
            $countries = Country::where('status', '!=', 'Deleted')->get();
            return view('admin.city.edit', compact('countries', 'states', 'city'));
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
            'cityName' => 'required',

        ]);
        try {
            $id = $request->id;
            $city = City::find($id);
            $city->countryId = $request->countryId;
            $city->stateId = $request->stateId;
            $city->cityName = $request->cityName;
            $city->amount = $request->amount;
            $city->memberAmount = $request->memberAmount;
            $city->status = 'Active';

            $city->save();


            return redirect()->route('city.index')->with('success', 'City Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }

    function delete(Request $request, $id)
    {
        try {
            $city = City::find($id);
            $city->status = "Deleted";
            $city->save();
            return redirect()->route('city.index')->with('success', 'City Deleted Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );
            return view('servererror');
        }
    }
}
