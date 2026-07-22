<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class BirthDayController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Member::with('user');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('firstName', 'like', "%{$search}%")
                        ->orWhere('lastName', 'like', "%{$search}%")
                        ->orWhere('displayName', 'like', "%{$search}%")
                        ->orWhere('birthDate', 'like', "%{$search}%");
                });
            }

            $birthday = $query->orderByRaw('birthDate IS NULL, birthDate ASC')->where('status', 'Active')->paginate(10);

            return view('admin.birthday.index', compact('birthday'));
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $members = Member::orderBy('firstName', 'ASC')->get();

            return view('admin.birthday.create', compact('members'));
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'birthDate' => 'required|date',
        ]);

        try {
            $member = Member::findOrFail($request->member_id);
            $member->birthDate = $request->birthDate;
            $member->save();

            return redirect()
                ->route('birthday.index')
                ->with('success', 'Birthday added successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return redirect()->back()->with('error', 'Something went wrong while adding birthday.');
        }
    }

    public function edit($id)
    {
        try {
            $birthday = Member::findOrFail($id);
            $members = Member::orderBy('firstName', 'ASC')->get();

            return view('admin.birthday.edit', compact('birthday', 'members'));
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return view('servererror');
        }
    }

    public function update(Request $request, $id = null)
    {
        $memberId = $id ?? $request->id ?? $request->member_id;

        $request->validate([
            'birthDate' => 'required|date',
        ]);

        try {
            $member = Member::findOrFail($memberId);
            $member->birthDate = $request->birthDate;
            $member->save();

            return redirect()
                ->route('birthday.index')
                ->with('success', 'Birthday updated successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return redirect()->back()->with('error', 'Something went wrong while updating birthday.');
        }
    }

    public function delete($id = null)
    {
        try {
            $memberId = $id ?? request('id');
            $member = Member::findOrFail($memberId);
            $member->birthDate = null;
            $member->save();

            return redirect()
                ->route('birthday.index')
                ->with('success', 'Birthday removed successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError(
                $th,
                request()->fullUrl()
            );

            return redirect()->back()->with('error', 'Something went wrong while deleting birthday.');
        }
    }
}
