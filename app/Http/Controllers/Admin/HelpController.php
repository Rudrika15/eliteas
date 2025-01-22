<?php

namespace App\Http\Controllers\Admin;

use App\Models\Help;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpController extends Controller
{

    public function __construct()
    {
        // Apply middleware for help-related permissions
        $this->middleware('permission:help-userView', ['only' => ['userView']]);
        $this->middleware('permission:help-index', ['only' => ['index', 'show']]);
        $this->middleware('permission:help-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:help-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:help-delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        try {
            $help = Help::where('status', 'Active')->paginate(10);
            return view('admin.help.index', compact('help'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function userView(Request $request)
    {
        try {
            $help = Help::where('status', 'Active')->paginate(10);
            return view('admin.help.userView', compact('help'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function create()
    {
        try {
            return view('admin.help.create');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        try {
            $help = new Help();
            $help->title = $request->title;
            if ($request->photo) {
                $help->photo = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('help'), $help->photo);
            }
            if ($request->video) {
                $help->video = time() . '.' . $request->video->extension();
                $request->video->move(public_path('help'), $help->video);
            }
            $help->description = $request->description;
            $help->status = 'Active';
            $help->save();

            return redirect()->route('help.create')->with('success', 'Help Created Successfully!');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }


    public function edit(Request $request, $id)
    {
        try {
            $help = Help::find($id);
            return view('admin.help.edit', compact('help'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return view('servererror');
        }
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:helps,id',
            'title' => 'required',
        ]);

        try {
            $help = Help::find($request->id);

            if (!$help) {
                return redirect()->route('help.index')->with('error', 'Help not found.');
            }

            $help->title = $request->title;
            if ($request->photo) {
                $help->photo = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('help'), $help->photo);
            }
            if ($request->video) {
                $help->video = time() . '.' . $request->video->extension();
                $request->video->move(public_path('help'), $help->video);
            }
            $help->description = $request->description;
            $help->status = 'Active';
            $help->save();

            return redirect()->route('help.index')->with('success', 'Help details updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('help.index')->with('error', 'Failed to update help details.');
        }
    }


    public function delete($id)
    {
        try {
            $help = Help::find($id);

            if (!$help) {
                return redirect()->route('help.index')->with('error', 'Help not found.');
            }

            $help->status = 'Deleted';
            $help->save();

            return redirect()->route('help.index')->with('success', 'Help deleted successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            ErrorLogger::logError($th, request()->fullUrl());
            return redirect()->route('help.index')->with('error', 'Failed to delete help.');
        }
    }
}
