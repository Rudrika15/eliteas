@extends('layouts.master')

@section('header', 'Testimonial')
@section('content')


<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Testimonial</h4>
                <a href="{{ route('testimonial.archives') }}" class="btn btn-bg-orange mt-3 btn-sm btn-tooltip"><i
                        class="bi bi-archive"></i>
                    <span class="btn-text">Archives</span>
                </a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Testimonial Giver</th>
                            <th>Testimonial Taker</th>
                            <th>Message</th>
                            <th>Date</th>
                            {{-- <th>Status</th> --}}
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
                            <td>{{ $testimonialData->uploadedDate ?
                                \Carbon\Carbon::parse($testimonialData->uploadedDate)->format('d-m-Y') : '-' }}</td>
                            {{-- <td>{{ $testimonialData->status ?? '-' }}</td> --}}
                            <td>
                                <a href="{{ route('testimonial.destroy', $testimonialData->id) }}"
                                    class="btn btn-danger btn-sm justify-content-center align-items-center btn-tooltip"><i
                                        class="bi bi-trash"></i>
                                    <span class="btn-text">Delete</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $testimonials->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>

@endsection