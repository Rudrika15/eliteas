<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\RisingStar;
use Illuminate\Http\Request;

class RisingStarController extends Controller
{
    public function index()
    {
        $risingStars = RisingStar::with('member')->latest()->paginate(10);

        return view('admin.risingstar.index', compact('risingStars'));
    }

    public function create()
    {
        $members = Member::where('status', 'Active')->orderBy('firstName')->get();

        return view('admin.risingstar.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|in:Active,Deleted',
        ]);

        RisingStar::create([
            'member_id' => $request->member_id,
            'title' => $request->title,
            'status' => $request->status,
        ]);

        return redirect()->route('risingstar.index')->with('success', 'Rising Star added successfully.');
    }

    public function edit($id)
    {
        $risingStar = RisingStar::findOrFail($id);
        $members = Member::where('status', 'Active')->orderBy('firstname')->get();

        return view('admin.risingstar.edit', compact('risingStar', 'members'));
    }

    public function update(Request $request, $id)
    {
        $risingStar = RisingStar::findOrFail($id);
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|in:Active,Deleted',
        ]);

        $risingStar->update([
            'member_id' => $request->member_id,
            'title' => $request->title,
            'status' => $request->status ?? 'Active',
        ]);

        return redirect()->route('risingstar.index')->with('success', 'Rising Star updated successfully.');
    }

    public function destroy($id)
    {
        $risingStar = RisingStar::findOrFail($id);

        if ($risingStar->image && file_exists(public_path('uploads/rising-stars/'.$risingStar->image))) {
            unlink(public_path('uploads/rising-stars/'.$risingStar->image));
        }
        $risingStar->delete();

        return redirect()->route('risingstar.index')->with('success', 'Rising Star deleted successfully.');
    }

}
