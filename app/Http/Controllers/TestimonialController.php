<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Member;
use App\Utils\ErrorLogger;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
                'myTestimonials' => $myTestimonials
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
    public function create()
    {
        return view('testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'circlePersonId' => 'required',
                'message' => 'required'
            ]);

            $testimonial = new Testimonial();
            $testimonial->userId = Auth::user()->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->status = 'Active';
            $testimonial->uploadedDate = Carbon::now()->toDateString();
            $testimonial->save();

            return redirect()->route('testimonial.index')->with("success", "Testimonial uploaded successfully.");
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

            return view('testimonial.edit', compact('myTestimonial'));
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
                'message' => 'required'
            ]);

            $id = $request->id;
            $testimonial = Testimonial::findOrFail($id);
            $testimonial->userId = Auth::user()->id;
            $testimonial->memberId = $request->circlePersonId;
            $testimonial->message = $request->message;
            $testimonial->status = 'Active';
            $testimonial->save();

            return redirect()->route('testimonial.index')->with("success", "Testimonial updated successfully.");
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

            return redirect()->back()->with("success", "Testimonial deleted successfully.");
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
            $testimonial = Testimonial::where('status', 'Archived')->findOrFail($id);
            $testimonial->status = 'Deleted';
            $testimonial->save();

            return redirect()->route('testimonials.indexAdmin');
        } catch (\Throwable $th) {
            // Log the error
            ErrorLogger::logError($th, request()->fullUrl());

            // Return a generic error view
            return response()->view('servererror');
        }
    }
}
