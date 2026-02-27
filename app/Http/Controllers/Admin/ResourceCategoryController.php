<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResourceCategory;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class ResourceCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $categories = ResourceCategory::orderBy('categoryName', 'asc')->where('status', 'Active')->paginate(10);

            return view('admin.resourceCategory.index', compact('categories'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            return view('admin.resourceCategory.create');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required|unique:resource_categories,categoryName',
        ]);

        try {
            $category = new ResourceCategory;
            $category->categoryName = $request->categoryName;
            $category->status = 'Active';
            $category->save();

            return redirect()->route('resourceCategory.index')->with('success', 'Resource Category Created Successfully!');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $category = ResourceCategory::find($id);

            return view('admin.resourceCategory.edit', compact('category'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:resource_categories,id',
            'categoryName' => 'required|unique:resource_categories,categoryName,'.$request->id,
        ]);

        try {
            $category = ResourceCategory::find($request->id);

            if (! $category) {
                return redirect()->route('resourceCategory.index')->with('error', 'Resource Category not found.');
            }

            $category->categoryName = $request->categoryName;
            $category->status = 'Active';
            $category->save();

            return redirect()->route('resourceCategory.index')->with('success', 'Resource Category updated successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('resourceCategory.index')->with('error', 'Failed to update Resource Category.');
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $category = ResourceCategory::find($id);

            if (! $category) {
                return redirect()->route('resourceCategory.index')->with('error', 'Resource Category not found.');
            }

            $category->status = 'Inactive';
            $category->save();

            return redirect()->route('resourceCategory.index')->with('success', 'Resource Category deleted successfully.');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return redirect()->route('resourceCategory.index')->with('error', 'Failed to delete Resource Category.');
        }
    }
}
