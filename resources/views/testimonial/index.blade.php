@extends('layouts.master')
@section('title', 'UBN - Testimonial')

@section('content')

<!-- Loader -->
<div id="loader" class="loader"></div>

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
    </button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
    </button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="mb-0 mt-3 text-blue">My Testimonials</h4>
            <a href="{{ route('testimonial.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a>
        </div>
        <hr class="mb-5">
        <!-- Table with stripped rows -->
        <table class="table datatable mb-5">
            <thead>
                <tr>
                    <th>Circle Member</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($myTestimonials as $myTestimonial)
                <tr>
                    <td>{{ $myTestimonial->receiver->firstName ?? '' }} {{ $myTestimonial->receiver->lastName ?? '' }}</td>
                    <td>{{ $myTestimonial->message ?? '' }}</td>
                    <td>{{ \Carbon\Carbon::parse($myTestimonial->date)->format('j M Y') }}</td>
                    <td>
                        <a href="{{ route('testimonial.edit', $myTestimonial->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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
                    <th>Uploaded Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonials as $testimonial)
                <tr>
                    <td>{{ $testimonial->sender->firstName ?? '' }} {{ $testimonial->sender->lastName ?? '' }}</td>
                    <td>{{ $testimonial->message ?? '' }}</td>
                    <td>{{ \Carbon\Carbon::parse($testimonial->uploadedDate)->format('d-m-Y') ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('styles')
<style>
    .loader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('/path/to/your/loader.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
    body.loading .loader {
        display: block;
    }
    body:not(.loading) .loader {
        display: none;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('loading');
        window.addEventListener('load', function () {
            document.body.classList.remove('loading');
        });
    });
</script>
@endsection
