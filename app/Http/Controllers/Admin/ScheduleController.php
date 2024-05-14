<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Franchise;
use Illuminate\Http\Request;
use App\Models\MeetingInvitation;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        try {

            $schedules = Schedule::where('status', 'Active')->get();
            return view('admin.schedule.index', compact('schedules'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $schedules = Schedule::findOrFail($id);
            return response()->json($schedules);
        } catch (\Throwable $th) {
            //throw $th

            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $schedules = Schedule::all();
            return view('admin.schedule.create', compact('schedules'));
        } catch (\Throwable $th) {
            //throe $th
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'venue' => 'required',
            'meetingTime' => 'required',
            'remarks' => 'required',
        ]);

        try {
            $schedules = new Schedule();
            $schedules->venue = $request->venue;
            $schedules->meetingTime = $request->meetingTime;
            $schedules->remarks = $request->remarks;
            $schedules->save();

            return redirect()->route('schedule.index')->with('success', 'Mettting Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $schedules = Schedule::find($id);
            return view('admin.schedule.edit', compact('schedules'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:schedules,id',
            'venue' => 'required',
            'meetingTime' => 'required',
            'remarks' => 'required',
        ]);

        try {
            $schedules = Schedule::find($request->id);

            if (!$schedules) {
                return redirect()->route('schedule.index')->with('error', 'Schedule not found.');
            }

            $schedules->venue = $request->venue;
            $schedules->meetingTime = $request->meetingTime;
            $schedules->remarks = $request->remarks;
            $schedules->save();

            return redirect()->route('schedule.index')->with('success', 'Schedule details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('schedule.index')->with('error', 'Failed to update Schedule details.');
        }
    }


    public function delete($id)
    {
        try {
            $schedules = Schedule::find($id);

            if (!$schedules) {
                return redirect()->route('schedule.index')->with('error', 'Schedule not found.');
            }

            $schedules->status = 'Deleted';
            $schedules->save();

            return redirect()->route('schedule.index')->with('success', 'Schedule deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('schedule.index')->with('error', 'Failed to delete Schedule.');
        }
    }

    public function dashIndex(Request $request)
    {
        try {

            $schedules = Schedule::where('status', 'Active')->get();
            return view('admin.schedule.dashIndex', compact('schedules'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function dashEdit(Request $request, $id)
    {
        try {
            $schedules = Schedule::find($id);
            return view('admin.schedule.dashEdit', compact('schedules'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function dashUpdate(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:schedules,id',
            'venue' => 'required',
            'meetingTime' => 'required',
            'remarks' => 'required',
        ]);

        try {
            $schedules = Schedule::find($request->id);

            if (!$schedules) {
                return redirect()->route('schedule.dashboardIndex')->with('error', 'Schedule not found.');
            }

            $schedules->venue = $request->venue;
            $schedules->meetingTime = $request->meetingTime;
            $schedules->remarks = $request->remarks;
            $schedules->save();

            return redirect()->route('schedule.dashIndex')->with('success', 'Schedule details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('schedule.dashIndex')->with('error', 'Failed to update Schedule details.');
        }
    }

    public function invitedList(Request $request, $id)
    {
        try {
            $schedules = Schedule::findOrFail($id);
            $invitedPersonList = MeetingInvitation::where('meetingId', $id)->get();
            return view('admin.schedule.invitedList', compact('schedules', 'invitedPersonList'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }



}
