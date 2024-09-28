<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Franchise;
use App\Utils\ErrorLogger;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\WelcomeMemberEmail;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = User::all();
            $franchises = Franchise::where('status', 'Active')->paginate(10);
            return view('admin.franchise.index', compact('franchises', 'user'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $franchises = Franchise::findOrFail($id);
            return response()->json($franchises);
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $franchises = Franchise::all();
            $countries = Country::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $cities = City::where('status', 'Active')->get();
            return view('admin.franchise.create', compact('franchises', 'countries', 'states', 'cities'));
        } catch (\Throwable $th) {
            //throe $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'franchiseName' => 'required|unique:franchises',
            'franchiseContactDetails' => 'required|max:10',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',

        ]);

        try {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
            $password = '';
            $length = 8;
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }

            $rowPassword = $password;

            $user = new User;
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($rowPassword);
            // $user->password = Str::random(8);
            $user->assignRole('Franchise Admin');
            $user->save();

            $franchises = new Franchise();
            $franchises->franchiseName = $request->franchiseName;
            $franchises->franchiseContactDetails = $request->franchiseContactDetails;
            $franchises->cityId = $request->cityId;
            $franchises->userId = $user->id;
            $franchises->status = 'Active';
            $franchises->save();

            Mail::to($user->email)->send(new WelcomeMemberEmail($user, $rowPassword));

            return redirect()->route('franchise.index')->with('success', 'Franchise and User Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $franchises = Franchise::find($id);
            $cities = City::where('status', 'Active')->get();
            $states = State::where('status', 'Active')->get();
            $countries = Country::where('status', 'Active')->get();

            $city = City::where('id', $franchises->cityId)->first();
            $state = State::where('id', $city->stateId)->first();
            $country = Country::where('id', $state->countryId)->first();

            return view('admin.franchise.edit', compact('franchises', 'cities', 'states', 'countries', 'city', 'state', 'country'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:franchises,id',
            'franchiseName' => 'required|unique:franchises,id,' . $request->id,
            'franchiseContactDetails' => 'required',
        ]);

        try {
            $franchises = Franchise::find($request->id);
            $user = $franchises ? $franchises->user : null; // Check if franchises object exists before trying to find user

            if (!$franchises) {
                return redirect()->route('franchise.index')->with('error', 'Franchise not found.');
            }


            if (!$user) {
                return redirect()->route('franchise.index')->with('error', 'User not found.');
            }

            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            $franchises = Franchise::find($request->id);
            $franchises->franchiseName = $request->franchiseName;
            $franchises->franchiseContactDetails = $request->franchiseContactDetails;
            $franchises->cityId = $request->cityId;
            $franchises->status = 'Active';
            $franchises->save();

            return redirect()->route('franchise.index')->with('success', 'Franchise details Updated Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
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
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('franchise.index')->with('error', 'Failed to delete franchise.');
        }
    }

    // public function getStates(Request $request)
    // {
    //     $countryId = $request->input('countryId');
    //     $states = State::where('countryId', $countryId)->get();

    //     $options = '<option value="">Select State</option>';
    //     foreach ($states as $state) {
    //         $options .= '<option value="' . $state->id . '">' . $state->stateName . '</option>';
    //     }

    //     return $options;
    // }

    // public function getCities(Request $request)
    // {
    //     $stateId = $request->input('stateId');
    //     $cities = City::where('stateId', $stateId)->get();

    //     $options = '<option value="">Select City</option>';
    //     foreach ($cities as $city) {
    //         $options .= '<option value="' . $city->id . '">' . $city->cityName . '</option>';
    //     }

    //     return $options;
    // }


    // Example Laravel Controller Method
    public function getStates(Request $request)
    {
        $countryId = $request->countryId;
        $states = State::where('countryId', $countryId)->get();

        $options = '<option value="">Select State</option>';
        foreach ($states as $state) {
            $options .= '<option value="' . $state->id . '">' . $state->stateName . '</option>';
        }
        return response()->json($options);
    }

    public function getCities(Request $request)
    {
        $stateId = $request->stateId;

        $cities = City::where('stateId', $stateId)->get();

        $options = '<option value="">Select City</option>';

        foreach ($cities as $city) {
            $options .= '<option value="' . $city->id . '">' . $city->cityName . '</option>';
        }

        return response()->json($options);
    }

    public function getStateAndCountry(Request $request)
    {
        $city = City::find($request->cityId); // Assuming you have a City model
        if ($city) {
            $state = $city->state; // Assuming City belongs to State
            $country = $state->country; // Assuming State belongs to Country
            return response()->json([
                'stateId' => $state->id,
                'countryId' => $country->id,
            ]);
        }

        return response()->json(['error' => 'City not found'], 404);
    }
}
