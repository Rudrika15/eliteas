<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;

class BusinessCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $businessCategory = BusinessCategory::where('status', 'Active')->get();
            return view('admin.businesscategory.index', compact('businessCategory'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $businessCategory = BusinessCategory::findOrFail($id);
            return response()->json($businessCategory);
        } catch (\Throwable $th) {
            //throw $th;
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $businessCategory = BusinessCategory::all();
            return view('admin.businesscategory.create', compact('businessCategory'));
        } catch (\Throwable $th) {
            //throe $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required',
            'categoryIcon' => 'required',
        ]);

        try {
            $businessCategory = new BusinessCategory();
            $businessCategory->categoryName = $request->categoryName;

            if ($request->categoryIcon) {
                $businessCategory->categoryIcon = time() . '.' . $request->categoryIcon->extension();
                $request->categoryIcon->move(public_path('BusinessCategory'),  $businessCategory->categoryIcon);
            }


            // $businessCategory->categoryIcon = $request->categoryIcon;

            $businessCategory->status = 'Active';
            $businessCategory->save();

            return redirect()->route('bCategory.index')->with('success', 'Business Category Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $businessCategory = BusinessCategory::find($id);
            return view('admin.businesscategory.edit', compact('businessCategory'));
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:business_categories,id',
            // 'categoryName' => 'required',
            // 'categoryIcon' => 'required',
        ]);

        try {
            $businessCategory = BusinessCategory::find($request->id);

            if (!$businessCategory) {
                return redirect()->route('bCategory.index')->with('error', 'Business Category not found.');
            }

            $businessCategory->categoryName = $request->categoryName;


            if ($request->categoryIcon) {
                $businessCategory->categoryIcon = time() . '.' . $request->categoryIcon->extension();
                $request->categoryIcon->move(public_path('BusinessCategory'),  $businessCategory->categoryIcon);
            }


            // $businessCategory->categoryIcon = $request->categoryIcon;

            $businessCategory->status = 'Active';
            $businessCategory->save();

            return redirect()->route('bCategory.index')->with('success', 'Business Category details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bCategory.index')->with('error', 'Failed to update Business Category details.');
        }
    }


    public function delete($id)
    {
        try {
            $businessCategory = BusinessCategory::find($id);

            if (!$businessCategory) {
                return redirect()->route('bCategory.index')->with('error', 'Business Category not found.');
            }

            $businessCategory->status = 'Deleted';
            $businessCategory->save();

            return redirect()->route('bCategory.index')->with('success', 'Business Category deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('bCategory.index')->with('error', 'Failed to delete Business Category.');
        }
    }
}
