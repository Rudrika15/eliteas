@extends('layouts.master')

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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Testmonial</h4>
                <a href="{{ route('testimonials.indexAdmin') }}" class="btn btn-bg-orange btn-sm mt-3">Back</a>
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-striped table-hover">
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
                            <td>{{ $testimonialData->user->firstName ?? '-' }} {{ $testimonialData->user->lastName ?? '-' }}
                            </td>
                            <td>{{ $testimonialData->member->firstName ?? '-' }}
                                {{ $testimonialData->member->lastName ?? '-' }}</td>
                            <td>{{ $testimonialData->message }}</td>
                            <td>{{ $testimonialData->uploadedDate }}</td>
                            <td>{{ $testimonialData->status }}</td>
                            <td>

                                <a href="{{ route('testimonial.restore', $testimonialData->id) }}"
                                    onclick="return confirm('Do You Want To restore It ?')"
                                    class="btn btn-success btn-sm d-flex justify-content-center align-items-center">Restore</a>
                            </td>
                            {{-- <td>
                        <a href="{{ route('training.edit', $testimonialData->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>

                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                            {{-- <a href="{{ route('training.delete', $trainingData->id) }}" class="btn btn-danger btn-sm mt-3">
                            <i class="bi bi-trash"></i>
                        </a> --}}


                            {{-- <form action="{{ route('training.delete', $trainingData->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> <!-- Icon for delete -->
                            </button>
                        </form> --}}
                            {{-- </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $testimonials->links() !!}
            </div>
            <!-- End Table with stripped rows -->
        </div>
    @endsection
