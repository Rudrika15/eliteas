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
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 mt-3">Testimonials</h4>

                <a href="{{ route('testimonial.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a>
            </div>

            <!-- Table with stripped rows -->
            <table class="table datatable">
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
                            <td>{{ $testimonial->user->firstName ?? '-' }}</td>
                            <td>{{ $testimonial->message ?? '-' }}</td>
                            <td>{{ $testimonial->uploadedDate ?? '-' }}</td>
                            <td>{{ $testimonial->status }}</td>
                            {{-- <td>
                                <a href="{{ route('circlecall.edit', $circlecallData->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pen"></i>
                                </a>
                                <a href="{{ route('circlecall.delete', $circlecallData->id) }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    @endsection