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
            <h4 class="mb-0 mt-3 text-blue">My Testimonials</h4>
            <a href="{{ route('testimonial.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a>

            {{-- <a href="{{ route('testimonial.archives') }}" class="btn mt-3 btn-sm"
                style="background-color: #e76a35">Archives</a> --}}
        </div>
        <hr class="mb-5">
        <!-- Table with stripped rows -->
        <table class="table datatable mb-5">
            <thead>
                <tr>
                    <th>Circle Member</th>
                    <th>Message</th>
                    <th>UploadedDate</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myTestimonials as $myTestimonial)
                <tr>
                    <td>{{ $myTestimonial->receiver->firstName ?? '' }}
                        {{ $myTestimonial->receiver->lastName ?? '' }}</td>
                    <td>{{ $myTestimonial->message ?? '' }}</td>
                    <td>{{ \Carbon\Carbon::parse($myTestimonial->uploadedDate)->format('d-m-Y') ?? '' }}</td>
                    {{-- <td>{{ $myTestimonial->status }}</td> --}}
                    <td>
                        <a href="{{ route('testimonial.edit', $myTestimonial->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>
                        {{-- <a href="{{ route('testimonial.destroy', $myTestimonial->id) }}"
                            onclick="return confirm('Do You Want To Delete It ?')" class="btn btn-danger btn-sm"><i
                                class="bi bi-trash"></i></a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>

{{-- Received Testimonial --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="mb-0 mt-3 text-blue">Received Testimonials</h4>

        </div>
        <hr class="mb-5">
        <!-- Table with stripped rows -->
        <table class="table datatable mb-5">
            <thead>
                <tr>
                    <th>Circle Member</th>
                    <th>Message</th>
                    <th>UploadedDate</th>
                    {{-- <th>Status</th> --}}
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonials as $testimonial)
                <tr>
                    <td>{{ $testimonial->sender->firstName ?? '' }} {{ $testimonial->sender->lastName ?? '' }}</td>
                    <td>{{ $testimonial->message ?? '' }}</td>
                    <td>{{ \Carbon\Carbon::parse($testimonial->uploadedDate)->format('d-m-Y') ?? '' }}</td>
                    {{-- <td>{{ $testimonial->status }}</td> --}}

                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection