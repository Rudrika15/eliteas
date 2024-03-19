<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Circle;
use App\Models\Franchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\CircleType;

class CircleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circle = Circle::with('circleType')
                ->with('city')
                ->with('franchise')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circle.index', compact('circle'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $circle = Circle::findOrFail($id);
            return response()->json($circle);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $circle = Circle::where('status', '!=', 'Deleted')->get();
            $franchise = Franchise::where('status', '!=', 'Deleted')->get();
            $city = City::where('status', '!=', 'Deleted')->get();
            $circletype = CircleType::where('status', '!=', 'Deleted')->get();
            return view('admin.circle.create', compact('circle', 'franchise', 'city', 'circletype'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'circleName' => 'required',
            'franchiseId' => 'required',
            'cityId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            'meetingTime' => 'required',
            'numberOfMeetings' => 'required',
            'weekNo' => 'required|array', // Ensure weekNo is an array
            // 'start_date' => 'required',
            // 'end_date' => 'required'
        ]);

        try {
            $circle = new Circle();
            $circle->circleName = $request->circleName;
            $circle->franchiseId = $request->franchiseId;
            $circle->cityId = $request->cityId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->meetingDay;
            $circle->meetingTime = $request->meetingTime;
            $circle->numberOfMeetings = $request->numberOfMeetings;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            // $circle->start_date = $request->start_date;
            // $circle->end_date = $request->end_date;
            $circle->status = 'Active';

            $circle->save();

            return redirect()->route('circle.index')->with('success', 'Circle Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function edit($id)
    {
        try {
            $circle = Circle::find($id);
            $franchise = Franchise::where('status', '!=', 'Deleted')->get();
            $city = City::where('status', '!=', 'Deleted')->get();
            $circletype = CircleType::where('status', '!=', 'Deleted')->get();
            return view('admin.circle.edit', compact('franchise', 'circletype', 'city', 'circle'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'circleName' => 'required',
            'cityId' => 'required',
            'franchiseId' => 'required',
            'circletypeId' => 'required',
            'meetingDay' => 'required',
            'meetingTime' => 'required',
            // 'start_date' => 'required',
            // 'end_date' => 'required',
            'weekNo' => 'required|array', // Ensure weekNo is an array
        ]);

        try {
            $id = $request->id;
            $circle = Circle::find($id);
            $circle->circleName = $request->circleName;
            $circle->cityId = $request->cityId;
            $circle->franchiseId = $request->franchiseId;
            $circle->circletypeId = $request->circletypeId;
            $circle->meetingDay = $request->meetingDay;
            $circle->meetingTime = $request->meetingTime;
            $circle->start_date = $request->start_date;
            $circle->end_date = $request->end_date;
            $circle->weekNo = json_encode($request->weekNo); // Serialize the array of week numbers
            $circle->status = 'Active';
            $circle->save();

            return redirect()->route('circle.index')->with('success', 'Circle Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $circle = Circle::find($id);
            $circle->status = "Deleted";
            $circle->save();

            return redirect()->route('circle.index')->with('Success', 'Circle Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
