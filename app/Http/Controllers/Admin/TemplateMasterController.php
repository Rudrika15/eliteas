<?php

namespace App\Http\Controllers\Admin;

use App\Models\TemplateMaster;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class TemplateMasterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:templatemaster-list|templatemaster-create|templatemaster-edit|templatemaster-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:templatemaster-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:templatemaster-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:templatemaster-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        try {
            $template = TemplateMaster::orderBy('id', 'DESC')->paginate(10);
            return view("admin.template.index", compact('template'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function create()
    {
        try {
            return view("admin.template.create");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'templateImage' => 'required',
        ]);

        try {
            $template = new TemplateMaster();
            if ($request->templateImage) {
                $template->templateImage = time() . '.' . $request->templateImage->extension();
                $request->templateImage->move(public_path('templateImage'), $template->templateImage);
            }
            $template->save();
            return redirect()->route('template.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        try {
            $template = TemplateMaster::find($id);
            return view('admin.template.edit', compact('template'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(Request $request)
    {

        $this->validate($request, [
            'templateImage' => 'required',
        ]);

        try {
            $id = $request->id;
            $template = TemplateMaster::find($id);
            if ($request->templateImage) {
                $template->templateImage = time() . '.' . $request->templateImage->extension();
                $request->templateImage->move(public_path('templateImage'), $template->templateImage);
            }
            $template->save();
            return redirect()->route('template.index')->with('success', 'Template Call Updated Successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        try {
            $template = TemplateMaster::find($id);
            $template->delete();
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
