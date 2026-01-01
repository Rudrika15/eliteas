@extends('layouts.master')

@section('title', 'UBN - Sent Connection Requests')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Sent Connection Requests</h4>
            </div>

            <!-- Table with striped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            {{-- <th>Profile</th> --}}
                            <th>Requested To</th>
                            <th>Status</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($connections as $connection)
                            <tr>
                                {{-- <td>
                                    @if ($connection->receiverMember && $connection->receiverMember->profilePhoto)
                                        <img src="{{ asset('storage/' . $connection->receiverMember->profilePhoto) }}" alt="Profile Photo" class="rounded-circle" width="40" height="40">
                                    @else
                                        <img src="{{ asset('default-profile.png') }}" alt="Default Profile" class="rounded-circle" width="40" height="40">
                                    @endif
                                </td> --}}
                                <td>
                                    {{ $connection->receiver->firstName ?? '-' }} {{ $connection->receiver->lastName ?? '-' }}
                                </td>
                                <td>
                                    @if ($connection->status == 'Pending')
                                        <span class="badge bg-warning">{{ $connection->status }}</span>
                                    @elseif ($connection->status == 'Accepted')
                                        <span class="badge bg-success">{{ $connection->status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $connection->status }}</span>
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($connection->status == 'Pending')
                                        <a class="btn btn-sm btn-danger" href="{{ route('connection.cancel', $connection->id) }}">
                                            <i class="bi bi-x"></i> Cancel
                                        </a>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $connections->links() !!}
                </div>
            </div>
            <!-- End Table -->
        </div>
    </div>

@endsection
