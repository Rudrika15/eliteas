@extends('layouts.master')

@section('header', 'My Connection')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 mt-3">My Connection</h4>

        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($connections as $connection)
                <tr>
                    <td>{{ $connection->user->firstName ?? '-' }} {{ $connection->user->lastName ?? '-' }}</td>
                    <td>
                        <span class="badge bg-success">{{ $connection->status }}</span>
                    </td>
                    <td>
                        <a class="btn btn-sm btn-danger"
                            href="{{ route('connection.removeConnection', $connection->id) }}">Remove Connection</a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection