@extends('layouts.master')

@section('title', 'UBN - My Connection')
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
                <h4 class="card-title">My Connections</h4>
            </div>
            <hr class="mb-5">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($connections as $connection)
                            <tr>
                                <th>{{ ($connections->currentPage() - 1) * $connections->perPage() + $loop->index + 1 }}

                                <td>{{ $connection->connectedUser->firstName ?? '-' }}
                                    {{ $connection->connectedUser->lastName ?? '-' }}</td>
                                <td>{{ $connection->connectedUser->email ?? '-' }}</td>
                                <td>
                                    @if ($connection->status == 'Accepted')
                                        <span class="badge bg-success">Connected</span>
                                        {{-- @else
                            <span class="badge bg-success">{{ $connection->status }}</span> --}}
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-danger btn-tooltip"
                                        href="{{ route('connection.removeConnection', $connection->id) }}"><i
                                            class="bi bi-x"></i>
                                        <span class="btn-text">Remove Connection</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $connections->links() !!}
                </div>
            </div>
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">My Circle Connections</h4>
            </div>
            <hr class="mb-5">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myConnections as $myConnectionsData)
                            <tr>
                                <th>{{ ($myConnections->currentPage() - 1) * $myConnections->perPage() + $loop->index + 1 }}
                                <td>{{ $myConnectionsData->firstName ?? '-' }} {{ $myConnectionsData->lastName ?? '-' }}
                                </td>
                                <td>{{ $myConnectionsData->user->email ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $myConnections->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
@endsection
