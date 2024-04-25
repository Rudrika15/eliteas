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
                        <th>Requested By</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($connections as $connection)
                        <tr>
                            <td>{{ $connection->memberId }}</td>
                            <td>
                                @if ($connection->status == 'Pending')
                                    <span class="badge bg-info">{{ $connection->status }}</span>
                                @elseif ($connection->status == 'Accepted')
                                    <span class="badge bg-success">{{ $connection->status }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $connection->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-sm btn-success" href="#">Accept</a>
                                <a class="btn btn-sm btn-danger" href="#">Reject</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>

@endsection
