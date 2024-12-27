<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecificAsk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpecificAskController extends Controller
{
    public function index()
    {
        $specificasks = SpecificAsk::where('askBy', Auth::user()->id)->paginate(10);
        // $specificasks = SpecificAsk::paginate(10);
        return view('admin.specificask.index', compact('specificasks'));
    }

    public function allIndex()
    {
        $specificasks = SpecificAsk::where('status', 'Active')->orderBy('id', 'desc')->get();
        return view('admin.specificask.allIndex', compact('specificasks'));
    }

    public function create()
    {
        return view('admin.specificask.create');
    }

    public function store(Request $request)
    {
        $specificasks = new SpecificAsk();
        $specificasks->askBy = Auth::user()->id;
        $specificasks->ask = $request->ask;
        $specificasks->status = "Active";
        $specificasks->save();

        return redirect()->route('specificask.index')->with('success', 'Specific Ask Created Successfully!');
    }

    public function edit($id)
    {
        $specificasks = SpecificAsk::find($id);
        return view('admin.specificask.edit', compact('specificasks'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $specificasks = SpecificAsk::findOrFail($id);
        $specificasks->askBy = Auth::user()->id;
        $specificasks->ask = $request->ask;
        $specificasks->save();

        return redirect()->route('specificask.index')->with('success', 'Specific Ask Updated Successfully!');
    }

    public function destroy($id)
    {
        $specificasks = SpecificAsk::find($id);
        $specificasks->status = "Deleted";
        $specificasks->save();
        return redirect()->route('specificask.index')->with('success', 'Specific Ask Deleted Successfully!');
    }
}
