<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banners::latest()->paginate(10);

        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banner.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'status' => 'required|in:Active,Deleted',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('banners'), $imageName);
        }


        Banners::create([
            'title' => $request->title,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('banner.index')
            ->with('success', 'Banner created successfully.');
    }

    public function edit($id)
    {
        $banner = Banners::findOrFail($id);

        return view('admin.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banners::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'status' => 'required|in:Active,Deleted',
        ]);

        $imageName = $banner->image;

        if ($request->hasFile('image')) {

            if (
                $banner->image &&
                File::exists(public_path('banners/' . $banner->image))
            ) {
                File::delete(public_path('banners/' . $banner->image));
            }

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('banners'), $imageName);
        }

        $banner->update([
            'title' => $request->title,
            'image' => $imageName,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('banner.index')
            ->with('success', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = Banners::findOrFail($id);

        if (
            $banner->image &&
            File::exists(public_path('banners/' . $banner->image))
        ) {
            File::delete(public_path('banners/' . $banner->image));
        }

        $banner->delete();

        return redirect()
            ->route('banner.index')
            ->with('success', 'Banner deleted successfully.');
    }
}
