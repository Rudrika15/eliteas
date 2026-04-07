<?php

namespace App\Http\Controllers;

use App\Models\Circle;
use App\Models\City;
use App\Models\Member;
use App\Models\Testimonial;
use App\Utils\ErrorLogger;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:testimonial-index', ['only' => ['index', 'view']]);
        $this->middleware('permission:testimonial-indexAdmin', ['only' => ['indexAdmin']]);
        $this->middleware('permission:testimonial-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimonial-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimonial-delete', ['only' => ['delete']]);
        $this->middleware('permission:testimonial-restore', ['only' => ['restore']]);
        $this->middleware('permission:testimonial-archived', ['only' => ['archived']]);
        $this->middleware('permission:testimonial-archives', ['only' => ['archives']]);
    }

    public function index()
    {
        try {
            $testimonials = Testimonial::where('memberId', Auth::user()->member->id)
                ->with('sender')
                ->where('status', 'Active')
                ->paginate(10);

            $myTestimonials = Testimonial::where('userId', Auth::user()->id)
                ->with('receiver')
                ->where('status', 'Active')
                ->paginate(10);

            return view('testimonial.index', [
                'testimonials' => $testimonials,
                'myTestimonials' => $myTestimonials,
            ]);
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    public function indexAdmin()
    {
        try {
            $testimonials = Testimonial::where('status', 'Active')->paginate(10);

            return view('admin.testimonial.index', compact('testimonials'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {

    //     $members = Member::where('status', 'Active')
    //         ->where('id', '!=', Auth::user()->member->id)
    //         ->get();

    //     return view('testimonial.create');
    // }

    public function create(Request $request)
    {
        try {

            $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();

            $circleMember = Member::with('circle')
                ->where('circleId', Auth::user()->member->circleId)
                ->where('status', 'Active')
                ->where('id', '!=', Auth::user()->member->id)
                ->orderBy('firstName', 'ASC')
                ->get();

            return view('testimonial.create', compact('circles', 'circleMember'));
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, $request->fullUrl());

            return view('servererror');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'circlePersonId' => 'required',
                'message' => 'required',
            ]);

            $testimonial = new Testimonial;
            $testimonial->userId = Auth::user()->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->status = 'Active';
            $testimonial->uploadedDate = $request->date;
            $testimonial->save();

            return redirect()->route('testimonial.index')->with('success', 'Testimonial uploaded successfully.');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $myTestimonial = Testimonial::findOrFail($id);

            if (auth()->user()->hasRole('Member')) {

                $circles = Circle::where('status', 'Active')->orderBy('circleName', 'ASC')->get();
                $selectedCircleId = old('circleId', $myTestimonial->circleId ?? (Auth::user()->member->circleId ?? null));
                $members = Member::where('status', 'Active')
                    ->where('userId', '!=', Auth::id())
                    ->when($selectedCircleId, function ($q) use ($selectedCircleId) {
                        $q->where('circleId', $selectedCircleId);
                    })
                    ->orderBy('firstName', 'ASC')
                    ->get(['id', 'userId', 'firstName', 'lastName']);

                return view('testimonial.edit', compact('circles', 'members', 'myTestimonial'));
            }

            // For Digital Member
            if (auth()->user()->hasRole('Digital Member')) {

                $cities = City::where('status', 'Active')->orderBy('cityName', 'ASC')->get();

                $members = Member::where('status', 'Active')
                    ->where('id', '!=', Auth::user()->member->id)
                    ->where('circleId', null)
                    ->orderBy('firstName', 'ASC')
                    ->get();

                return view('testimonial.edit', compact('cities', 'members', 'myTestimonial'));
            }
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'circlePersonId' => 'required',
                'message' => 'required',
            ]);

            $id = $request->id;
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->userId = Auth::user()->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->uploadedDate = $request->date;
            $testimonial->status = 'Active';
            $testimonial->save();

            return redirect()->route('testimonial.index')->with('success', 'Testimonial updated successfully.');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function archived($id)
    {
        try {

            $testimonial = Testimonial::findOrFail($id);
            $testimonial->status = 'Archived';
            $testimonial->save();

            return redirect()->back()->with('success', 'Testimonial deleted successfully.');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    public function archives()
    {
        try {
            $testimonials = Testimonial::where('status', 'Archived')->paginate(10);

            return view('admin.testimonial.archives', compact('testimonials'));
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    public function restore($id)
    {
        try {
            $testimonial = Testimonial::where('status', 'Archived')->findOrFail($id);
            $testimonial->status = 'Active';
            $testimonial->save();

            return redirect()->route('testimonials.indexAdmin');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }

    public function delete($id)
    {
        try {
            $testimonial = Testimonial::where('id', $id)
                // ->where('status', 'Archived')
                ->firstOrFail();

            $testimonial->status = 'Deleted';
            $testimonial->save();

            return redirect()->route('testimonial.index')
                ->with('success', 'Testimonial deleted successfully');
        } catch (\Throwable $th) {
            ErrorLogger::logError($th, request()->fullUrl());

            return response()->view('servererror');
        }
    }
}
