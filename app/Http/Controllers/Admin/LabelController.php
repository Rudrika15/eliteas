<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');

            $query = Label::where('status', '!=', 'Deleted');

            if (!empty($search)) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            }

            $labels = $query->orderBy('id', 'DESC')->paginate(10);

            return view('admin.label.index', compact('labels', 'search'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function create(Request $request)
    {
        try {
            return view('admin.label.create');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        try {
            $label = new Label();
            $label->name = $request->name;
            $label->status = $request->status ?? 'Active';
            $label->save();

            return redirect()->route('label.index')->with('success', 'Label Created Successfully!');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $label = Label::findOrFail($id);
            return view('admin.label.edit', compact('label'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        try {
            $label = Label::findOrFail($id);
            $label->name = $request->name;
            $label->status = $request->status ?? 'Active';
            $label->save();

            return redirect()->route('label.index')->with('success', 'Label Updated Successfully!');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $label = Label::findOrFail($id);
            $label->status = 'Deleted';
            $label->save();

            return redirect()->route('label.index')->with('success', 'Label Deleted Successfully!');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());
            return view('servererror');
        }
    }
}
