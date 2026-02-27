<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Help;
use App\Models\ResourceCategory;
use App\Utils\ErrorLogger;
use Illuminate\Http\Request;

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
            $categories = ResourceCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();
            $selectedCategoryId = $request->resourceCatId;

            $query = Help::where('status', 'Active');
            if ($selectedCategoryId) {
                $query->where('resourceCatId', $selectedCategoryId);
            }

            $help = $query->paginate(10)->appends($request->query());

            return view('admin.help.userView', compact('help', 'categories', 'selectedCategoryId'));
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }

    public function create()
    {
        try {
            $categories = ResourceCategory::where('status', 'Active')->orderBy('categoryName', 'asc')->get();

            return view('admin.help.create', compact('categories'));
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
            'resourceCatId' => 'required|exists:resource_categories,id',
        ]);

        try {
            $help = new Help;
            $help->title = $request->title;
            $help->resourceCatId = $request->resourceCatId;
            if ($request->photo) {
                $help->photo = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('help'), $help->photo);
            }
            if ($request->video) {
                $help->video = time().'.'.$request->video->extension();
                $request->video->move(public_path('help'), $help->video);
            }
            if ($request->pdf) {
                $help->pdf = time().'.'.$request->pdf->extension();
                $request->pdf->move(public_path('help'), $help->pdf);
            }
            $help->description = $request->description;
            $help->status = 'Active';
            $help->save();

            return redirect()->route('help.index')->with('success', 'Resource Created Successfully!');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            return view('servererror');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $help = Help::find($id);
            $categories = ResourceCategory::where('status', 'Active')
                ->when($help?->resourceCatId, function ($q) use ($help) {
                    $q->orWhere('id', $help->resourceCatId);
                })
                ->orderBy('categoryName', 'asc')
                ->get();

            return view('admin.help.edit', compact('help', 'categories'));
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
            'resourceCatId' => 'required|exists:resource_categories,id',
        ]);

        try {
            $help = Help::find($request->id);

            if (! $help) {
                return redirect()->route('help.index')->with('error', 'Resource not found.');
            }

            $help->title = $request->title;
            $help->resourceCatId = $request->resourceCatId;
            if ($request->photo) {
                $help->photo = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('help'), $help->photo);
            }
            if ($request->video) {
                $help->video = time().'.'.$request->video->extension();
                $request->video->move(public_path('help'), $help->video);
            }
            if ($request->pdf) {
                $help->pdf = time().'.'.$request->pdf->extension();
                $request->pdf->move(public_path('help'), $help->pdf);
            }
            $help->description = $request->description;
            $help->status = 'Active';
            $help->save();

            return redirect()->route('help.index')->with('success', 'Resource details updated successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('help.index')->with('error', 'Failed to update resource details.');
        }
    }

    public function delete($id)
    {
        try {
            $help = Help::find($id);

            if (! $help) {
                return redirect()->route('help.index')->with('error', 'Resource not found.');
            }

            $help->status = 'Deleted';
            $help->save();

            return redirect()->route('help.index')->with('success', 'Resource deleted successfully.');
        } catch (\Throwable $th) {
            // throw $th;
            ErrorLogger::logError($th, request()->fullUrl());

            return redirect()->route('help.index')->with('error', 'Failed to delete resource.');
        }
    }
}
