@extends('layouts.master')
{{-- <title></title> --}}
@section('title', 'UBN - Testimonial')

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
                <h4 class="mb-0 mt-3 text-blue">Testimonials</h4>

                <a href="{{ route('testimonial.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i class="bi bi-plus-circle"></i></a>
            </div>
            <hr class="mb-5">
            <!-- Table with stripped rows -->
            <table class="table datatable mb-5">
                <thead>
                    <tr>
                        <th>Circle Member</th>
                        <th>Message</th>
                        <th>UploadedDate</th>
                        <th>Status</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonials as $testimonial)
                        <tr>
                            <td>{{ $testimonial->sender->firstName ?? '' }} {{ $testimonial->sender->lastName ?? '' }}</td>
                            <td>{{ $testimonial->message ?? '' }}</td>
                            <td>{{ $testimonial->uploadedDate ?? '' }}</td>
                            <td>{{ $testimonial->status }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="mb-0 mt-3 text-blue">My Testimonials</h4>

            </div>
            <hr class="mb-5">
            <!-- Table with stripped rows -->
            <table class="table datatable mb-5">
                <thead>
                    <tr>
                        <th>Circle Member</th>
                        <th>Message</th>
                        <th>UploadedDate</th>
                        <th>Status</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myTestimonials as $myTestimonial)
                        <tr>
                            <td>{{ $myTestimonial->receiver->firstName ?? '' }}
                                {{ $myTestimonial->receiver->lastName ?? '' }}</td>
                            <td>{{ $myTestimonial->message ?? '' }}</td>
                            <td>{{ $myTestimonial->uploadedDate ?? '' }}</td>
                            <td>{{ $myTestimonial->status }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>
@endsection
