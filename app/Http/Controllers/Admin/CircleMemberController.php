<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\State;
use App\Models\Circle;
use App\Models\Member;
use App\Models\Country;
use App\Models\CircleMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class CircleMemberController extends Controller
{
    public function index(Request $request)
    {
        try {
            $circlemember = CircleMember::with('circle')
                ->with('member')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get();
            return view('admin.circlemember.index', compact('circlemember'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    //For show single data
    public function view(Request $request, $id)
    {
        try {
            $circlemember = CircleMember::findOrFail($id);
            return response()->json($circlemember);
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
    public function create()
    {
        try {
            $circle = Circle::where('status', 'Active')->get();
            $member = Member::where('status', 'Active')->get();
            // $city = City::with('country')
            //     ->with('state')
            //     ->get();
            return view('admin.circlemember.create', compact('circle', 'member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'circleId' => 'required',
            'memberId' => 'required',
        ]);
        try {
            $circlemember = new CircleMember();
            $circlemember->circleId = $request->circleId;
            $circlemember->memberId = $request->memberId;
            $circlemember->status = 'Active';

            $circlemember->save();

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function edit($id)
    {
        try {
            $circlemember = CircleMember::find($id);
            $member = Member::where('status', 'Active')->get();
            $circle = Circle::where('status', 'Active')->get();
            return view('admin.circlemember.edit', compact('circle', 'circlemember', 'member'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'circleId' => 'required',
            'memberId' => 'required',

        ]);
        try {
            $id = $request->id;
            $circlemember = CircleMember::find($id);
            $circlemember->circleId = $request->circleId;
            $circlemember->memberId = $request->memberId;
            $circlemember->status = 'Active';

            $circlemember->save();


            return redirect()->route('circlemember.index')->with('success', 'Circle Member Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    function delete($id)
    {
        try {
            $circlemember = CircleMember::find($id);
            $circlemember->status = "Deleted";
            $circlemember->save();

            return redirect()->route('circlemember.index')->with('success', 'Circle Member Deleted Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }
}
