@extends('layouts.master')

@section('title', 'UBN - Testimonial')
{{-- <title>UBN - Testimonial</title> --}}
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
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="card-title">Create Testimonial</h4>
                <a href="{{ route('testimonial.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>
            <hr class="mb-5">
            <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post"
                action="{{ route('testimonial.store') }}" novalidate>
                @csrf

                <!-- Button trigger modal -->

                @include('testimonialCircleMember')

                <div class="row mb-3 ">
                    <div class="col-md-12">
                        <div class="form-floating mt-3">
                            <input type="hidden" id="circlePersonId" name="circlePersonId" required>
                            <input type="text" class="form-control @error('circlePersonId') is-invalid @enderror"
                                id="circlePersonName" placeholder="Select Member" required disabled>
                            <label for="meetingPersonName">Circle Member Name</label>
                            @error('circlePersonId')
                                <div class="invalid-tooltip">
                                    This field is required.
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating mt-3">
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message"
                                placeholder="Enter Message"></textarea>
                            <label for="message">Message</label>
                            @error('message')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Hidden field to store the selected member's ID -->


                    {{-- <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror" id="meetingPlace" name="meetingPlace" placeholder="Meeeting Place Name" required>
                        <label for="meetingPlace">Meeting Place Name</label>
                        @error('meetingPlace')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}



                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form><!-- End floating Labels Form -->
        </div>
    </div>



@endsection
