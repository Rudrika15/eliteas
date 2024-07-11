<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TrainingCategory;
use App\Http\Controllers\Controller;

class TrainingCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trainingCategory = TrainingCategory::where('status', 'Active')->paginate(10);
            return view('admin.trainingcategory.index', compact('trainingCategory'));
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $trainingCategory = TrainingCategory::all();
            return view('admin.trainingcategory.create', compact('trainingCategory'));
        } catch (\Throwable $th) {
            //throe $th;
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'categoryName' => 'required|unique:training_categories,categoryName',
        ]);

        try {
            $trainingCategory = new TrainingCategory();
            $trainingCategory->categoryName = $request->categoryName;

            $trainingCategory->status = 'Active';
            $trainingCategory->save();

            return redirect()->route('tCategory.index')->with('success', 'Training Category Created Successfully!');
        } catch (\Throwable $th) {
            throw $th;
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $trainingCategory = TrainingCategory::find($id);
            return view('admin.trainingcategory.edit', compact('trainingCategory'));
        } catch (\Throwable $th) {
            // throw $th;
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:training_categories,id',
            'categoryName' => 'required|unique:training_categories,categoryName',
        ]);

        try {
            $trainingCategory = TrainingCategory::find($request->id);

            $trainingCategory->categoryName = $request->categoryName;


            // $trainingCategory->categoryIcon = $request->categoryIcon;

            $trainingCategory->status = 'Active';
            $trainingCategory->save();

            return redirect()->route('tCategory.index')->with('success', 'Training Category details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tCategory.index')->with('error', 'Failed to update Training Category details.');
        }
    }


    public function delete($id)
    {
        try {
            $trainingCategory = TrainingCategory::find($id);

            if (!$trainingCategory) {
                return redirect()->route('bCategory.index')->with('error', 'training Category not found.');
            }

            $trainingCategory->status = 'Deleted';
            $trainingCategory->save();

            return redirect()->route('tCategory.index')->with('success', 'Training Category deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('tCategory.index')->with('error', 'Failed to delete Training Category.');
        }
    }
}
