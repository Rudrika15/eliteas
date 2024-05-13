@extends('layouts.master')

@section('header', 'City')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif


<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Edit Testimonial</h5>
        <a href="{{ route('testimonial.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="testimonialForm" enctype="multipart/form-data" method="post"
        action="{{ route('testimonial.update', $myTestimonial->id) }}" novalidate>
        @csrf
        <input type="hiddden" name="id" value="{{ $myTestimonial->id }}">
        @include('testimonialCircleMember')

        <div class="row mb-3 ">
            <div class="col-md-12">
                <div class="form-floating mt-3">
                    <input type="hidden" id="circlePersonId" name="circlePersonId"
                        value="{{ old('circlePersonId', $myTestimonial->memberId) }}">
                    <input type="text" class="form-control" id="circlePersonName" placeholder="Select Member"
                        value="{{ old('circlePersonName', $myTestimonial->member->firstName . ' ' . $myTestimonial->member->lastName) }}"
                        disabled>
                    <label for="meetingPersonName">Circle Member Name</label>
                    @error('circlePersonId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-floating mt-3">
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                        placeholder="Enter Message">{{ $myTestimonial->message }}</textarea>
                    <label for="message">Message</label>
                    @error('message')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>


@endsection