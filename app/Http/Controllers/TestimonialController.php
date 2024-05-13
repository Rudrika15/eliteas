<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::where('memberId', Auth::user()->member->id)->with('sender')->get();
        $myTestimonials = Testimonial::where('userId', Auth::user()->id)->with('receiver')->get();
        // return Auth::user()->member->id;
        // return $testimonials;
        return view('testimonial.index', ["testimonials" => $testimonials, 'myTestimonials' => $myTestimonials]);
    }

    public function indexAdmin()
    {
        $testimonials = Testimonial::all();

        return view('admin.testimonial.index', compact('testimonials'));
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
        return view('testimonial.create')->with("success", "message");
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $myTestimonial = Testimonial::find($id);

        return view('testimonial.edit', compact('myTestimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'circlePersonId' => 'required',
            'message' => 'required'
        ]);

        $id = $request->id;
        $testimonial = Testimonial::find($id);
        $testimonial->userId = Auth::user()->id;
        $testimonial->memberId = $request->circlePersonId;
        $testimonial->message = $request->message;
        $testimonial->status = 'Active';
        $testimonial->uploadedDate = Carbon::now()->toDateString();
        $testimonial->save();
        return redirect()->route('testimonial.index')->with("success", "Testimonial updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return redirect()->back()->with("success", "Testimonial deleted successfully.");
    }
    public function archives()
    {
        $testimonials = Testimonial::onlyTrashed()->get();
        return view('admin.testimonial.archives', \compact('testimonials'));
    }
    public function restore($id)
    {
        $testimonials = Testimonial::withTrashed()->find($id);
        $testimonials->restore();
        return \redirect()->route('testimonials.indexAdmin');
    }
}
