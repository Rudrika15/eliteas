<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorsController extends Controller
{
    public function index()
    {
        $sponsors = Sponsors::latest()->paginate(10);

        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        return view('admin.sponsors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Active,Deleted',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time().'_'.rand(1000, 9999).'.'.
                $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(
                public_path('sponsors'),
                $imageName
            );
        }

        Sponsors::create([
            'title' => $request->title,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor created successfully.');
    }

    public function edit($id)
    {
        $sponsor = Sponsors::findOrFail($id);

        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, $id)
    {
        
        $sponsor = Sponsors::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:Active,Deleted',
        ]);

        $data = [
            'title' => $request->title,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {

            if ($sponsor->image && file_exists(public_path('sponsors/'.$sponsor->image))) {
                unlink(public_path('sponsors/'.$sponsor->image));
            }

            $imageName = time().'_'.rand(1000, 9999).'.'.
                $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move(
                public_path('sponsors'),
                $imageName
            );

            $data['image'] = $imageName;
        }

        $sponsor->update($data);

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor updated successfully.');
    }

    public function destroy($id)
    {
        $sponsor = Sponsors::findOrFail($id);
        $sponsor->delete();

        return redirect()
            ->route('sponsors.index')
            ->with('success', 'Sponsor deleted successfully.');
    }
}
