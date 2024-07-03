@extends('layouts.master')

@section('header', 'Testimonial')
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

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Testimonial</h4>
                <a href="{{ route('testimonial.archives') }}" class="btn btn-bg-orange mt-3 btn-sm"><i
                        class="bi bi-archive"></i></a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Testimonial Giver</th>
                            <th>Testimonial Taker</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $testimonialData)
                        <tr>
                            <td>{{ $testimonialData->user->firstName ?? '-' }} {{ $testimonialData->user->lastName ??
                                '-' }}</td>
                            <td>{{ $testimonialData->member->firstName ?? '-' }} {{ $testimonialData->member->lastName
                                ?? '-' }}</td>
                            <td>{{ $testimonialData->message ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($testimonialData->date)->format('j M Y') }}</td>
                            <td>{{ $testimonialData->status ?? '-' }}</td>
                            <td>
                                <a href="{{ route('testimonial.destroy', $testimonialData->id) }}"
                                    onclick="return confirm('Do You Want To Delete It ?')"
                                    class="btn btn-danger btn-sm justify-content-center align-items-center"><i
                                        class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>

@endsection