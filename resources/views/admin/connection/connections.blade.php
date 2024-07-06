@extends('layouts.master')

@section('header', 'Connections')
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
            <h4 class="card-title">Connection Requests</h4>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable table-striped table-hover">
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
                        <td>{{ $connection->user->firstName ?? '-' }} {{ $connection->user->lastName ?? '-' }}</td>
                        <td>
                            @if ($connection->status == 'Pending')
                            <span class="badge bg-warning">{{ $connection->status }}</span>
                            @elseif ($connection->status == 'Accepted')
                            <span class="badge bg-success">{{ $connection->status }}</span>
                            @else
                            <span class="badge bg-danger">{{ $connection->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($connection->status == 'Pending')
                            <a class="btn btn-sm btn-success"
                                href="{{ route('connection.accept', $connection->id) }}"><i class="bi bi-check"></i></a>
                            <a class="btn btn-sm btn-danger" href="{{ route('connection.reject', $connection->id) }}"><i
                                    class="bi bi-x"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection