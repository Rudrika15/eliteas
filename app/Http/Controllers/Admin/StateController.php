<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use App\Models\Country;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function index(Request $request)
    {
        try {

            $state = State::with('country')
                ->where('status', 'Active')
                ->paginate(10);

            return view('admin.state.index', compact('state'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $state = State::with('country')->findOrFail($id);
            return response()->json($state);
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $country = Country::where('status', '!=', 'Deleted')->get();
            $state = State::with('country')
                ->get();
            return view('admin.state.create', compact('country', 'state'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'stateName' => 'required',
        ]);
        try {
            $state = new State();
            $state->countryId = $request->countryId;
            $state->stateName = $request->stateName;
            $state->status = 'Active';

            $state->save();

            return redirect()->route('state.create')->with('success', 'State Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $state = State::find($id);
            $country = Country::where('status', '!=', 'Deleted')->get();
            return view('admin.state.edit', compact('country', 'state'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'stateName' => 'required',

        ]);
        try {
            $id = $request->id;
            $state = State::find($id);
            $state->countryId = $request->countryId;
            $state->stateName = $request->stateName;
            $state->status = 'Active';

            $state->save();


            return redirect()->route('state.index')->with('success', 'State Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th,
                request()->fullUrl()
            );
            return view('servererror');
        }
    }

    public function delete($id)
    {
        try {
            $states = State::find($id);

            $states->status = 'Deleted';
            $states->save();

            return redirect()->route('state.index')->with('success', 'Business Category deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('state.index')->with('error', 'Failed to delete Business Category.');
        }
    }
}
