<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::where('memberId',Auth::user()->member->id)->get();
        // $testimonials = Testimonial::where('userId',Auth::user()->id)->get();
        // return Auth::user()->member->id;
        return view('testimonial.index',["testimonials"=>$testimonials]);
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
            'message'=>'required'
        ]);

        $testimonial = new Testimonial();
        $testimonial->userId = Auth::user()->id;
        $testimonial->memberId = $request->circlePersonId;
        $testimonial->message = $request->message;
        $testimonial->status = 'Active';
        $testimonial->uploadedDate = Carbon::now()->toDateString();
        $testimonial->save();
        return view('testimonial.create')->with("success","message");
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
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        //
    }
}
