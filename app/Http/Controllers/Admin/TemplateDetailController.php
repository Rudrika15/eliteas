<?php

namespace App\Http\Controllers\admin;

use App\Models\TemplateDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TemplateDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tempDetail = TemplateDetail::with(['Template' => function ($query) use ($id) {
            $query->where('id', '=', $id);
        }])->where('templateId', '=', $id)->orderBy('id', 'DESC')->get();
        return view('admin.templateDetail.index', \compact('tempDetail'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // return $request;

        $this->validate($request, [
            'title' => 'required',
            'templateIcon' => 'required',
            'bottom' => 'required',
            'left' => 'required',
            'height' => 'required',
            'width' => 'required',
            'fontSize' => 'required',
            'textColor' => 'required',
            'textWidth' => 'required',
            'textLength' => 'required',
            'frameHeight' => 'required',
        ]);

        try {
            $id = $request->templateId;
            $template = new TemplateDetail();
            $template->templateId = $id;
            $template->title = $request->title;

            if ($request->templateIcon) {
                $template->templateIcon = time() . '.' . $request->templateIcon->extension();
                $request->templateIcon->move(public_path('templateIcon'), $template->templateIcon);
            }

            $template->bottom = $request->bottom;
            $template->left = $request->left;
            $template->height = $request->height;
            $template->width = $request->width;
            $template->fontSize = $request->fontSize;
            $template->textColor = $request->textColor;
            $template->textWidth = $request->textWidth;
            $template->textLength = $request->textLength;
            $template->frameHeight = $request->frameHeight;

            $template->save();
            return redirect()->back()->with('success', 'Added successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(TemplateDetail $templateDetail)
    {
        //
    }

    public function edit($id)
    {
        $template = TemplateDetail::find($id);
        return view('admin.templateDetail.edit', \compact('template'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'bottom' => 'required',
            'left' => 'required',
            'height' => 'required',
            'width' => 'required',
            'fontSize' => 'required',
            'textColor' => 'required',
            'textWidth' => 'required',
            'textLength' => 'required',
            'frameHeight' => 'required',
        ]);

        try {
            $id = $request->templateDetailId;
            $templateId = $request->templateId;
            $template = TemplateDetail::find($id);
            $template->title = $request->title;
            if ($request->templateIcon) {
                $template->templateIcon = time() . '.' . $request->templateIcon->extension();
                $request->templateIcon->move(public_path('templateIcon'), $template->templateIcon);
            }
            $template->bottom = $request->bottom;
            $template->left = $request->left;
            $template->height = $request->height;
            $template->width = $request->width;
            $template->fontSize = $request->fontSize;
            $template->textColor = $request->textColor;
            $template->textWidth = $request->textWidth;
            $template->textLength = $request->textLength;
            $template->frameHeight = $request->frameHeight;
            $template->save();
            return redirect()->route('template.index')->with('success', 'Update successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $template = TemplateDetail::find($id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
