<?php

namespace App\Http\Controllers\Admin;

use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Models\BusinessCategory;
use App\Http\Controllers\Controller;

class BusinessCategoryController extends Controller
{

    function __construct()
    {
        // Applying middleware for managing business categories with specific permissions
        $this->middleware('permission:business-category-list|business-category-create|business-category-edit', ['only' => ['index', 'show']]);
        $this->middleware('permission:business-category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:business-category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:business-category-delete', ['only' => ['delete']]);
    }



    public function index(Request $request)
    {
        try {
            $businessCategory = BusinessCategory::where('status', 'Active')->paginate(10);
            return view('admin.businesscategory.index', compact('businessCategory'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
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
            ErrorLogger::logError(
                $th,
                $request->fullUrl()
            );

            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            $businessCategory = BusinessCategory::all();
            return view('admin.businesscategory.create', compact('businessCategory'));
        } catch (\Throwable $th) {
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a custom error view
            return view('servererror');
        }
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required|unique:business_categories,categoryName',
            // 'categoryIcon' => 'required',
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
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
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
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:business_categories,id',
            'categoryName' => 'required|unique:business_categories,categoryName',
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
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, $request->fullUrl());
            return redirect()->route('bCategory.index')->with('error', 'Failed to update Business Category details.');
        }
    }


    public function delete(Request $request, $id)
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
            // Log the error using the ErrorLogger utility
            ErrorLogger::logError($th, $request->fullUrl());

            // Return a custom error message
            return redirect()->route('bCategory.index')->with('error', 'Failed to delete Business Category.');
        }
    }
}
