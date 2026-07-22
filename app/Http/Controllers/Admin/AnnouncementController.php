<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcements;
use Illuminate\Validation\Rules\Text;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcements::latest()->paginate(10);

        return view('admin.announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Deleted',
        ]);

        // dd($request->all());
        $announcement = Announcements::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('announcement.index')
            ->with('success', 'announcement created successfully.');
    }

    public function edit($id)
    {
        $announcement = Announcements::findOrFail($id);

        return view('admin.announcement.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcements::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Active,Deleted',
        ]);


        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('announcement.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy($id)
    {
        $announcement = Announcements::findOrFail($id);
        $announcement->delete();

        return redirect()
            ->route('announcement.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
