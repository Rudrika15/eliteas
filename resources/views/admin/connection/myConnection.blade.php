@extends('layouts.master')

@section('title', 'UBN - My Connections')
@section('content')

    <div class="container my-5">
        <!-- Page Header -->
        {{-- <h2 class="text-center mb-4">My Connections</h2> --}}
        <h1 class="text-center card-title mb-4">My Connections</h1>

        <div class="search-bar">
            <a class="search-bar" href="{{ route('search') }}">
                <input type="text" name="query" style="width: 1200px;" placeholder="Click Here to Go for Search Member" title="Enter search keyword">
            </a>
        </div>


        <!-- Connection Cards -->
        <div class="row">
            @foreach ($connections as $connection)
                <div class="col-md-4 mb-4">
                    <div class="profile-card">
                        <div class="card-body">
                            {{-- {{ $connection->connectedUser->userId ?? $connection->members->id }} --}}
                            <!-- Profile Picture -->
                            <img src="{{ asset($connection->connectedUser->profilePicture ?? 'img/profile.png') }}" alt="Profile Picture" class="profile-img">

                            <!-- User Name -->
                            <h3 class="profile-name mb-3">
                                {{ $connection->connectedUser->firstName ?? '-' }} {{ $connection->connectedUser->lastName ?? '-' }}
                            </h3>

                            {{-- <!-- Email -->
                            <p class="profile-details">
                                <strong>Email:</strong> {{ $connection->connectedUser->email ?? '-' }}
                            </p> --}}

                            <!-- Connection Status -->
                            <p class="profile-details mb-3">
                                {{-- <strong>Status:</strong> --}}
                                @if ($connection->status === 'Accepted')
                                    <span class="badge bg-success">Connected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $connection->status }}</span>
                                @endif
                            </p>

                            <!-- Remove Connection Button -->
                            <a href="{{ route('connection.removeConnection', $connection->id) }}" class="btn btn-sm btn-outline-danger mt-2">
                                <i class="bi bi-x"></i> Remove Connection
                            </a>
                            {{-- <a href="{{ route('foundPersonDetails', $connection->members->id ) }}" class="mt-3 btn btn-sm btn-outline-primary mt-2">
                                <i class="bi bi-person"></i> View Profile
                            </a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <!-- Pagination -->
        <div class="d-flex justify-content-end custom-pagination">
            {!! $connections->links() !!}
        </div> --}}

        <!-- My Circle Connections -->

    </div>

    <style>
        .search-bar {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .search-bar input {
            width: 100%;
            padding: 10px;
            border: 0.5px solid #e76a35;
            border-radius: 5px;
            font-size: 1em;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-bar input::placeholder {
            color: #162e6b;
        }

        .profile-card {
            width: 250px !important;
            height: 300px !important;
            background-color: #fff !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
            text-align: center !important;
            margin: auto !important;
            padding: 15px 0 !important;
            border: 2px solid #e76a35 !important;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #1d3268;
            margin-bottom: 10px;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #1d3268;
        }

        .profile-title {
            font-size: 14px;
            font-weight: bold;
            color: #e76a35;
            margin-bottom: 5px;
        }

        .profile-name {
            font-size: 16px;
            font-weight: bold;
            color: #1d3268;
            margin-bottom: 5px;
        }

        .profile-details {
            font-size: 14px;
            color: #1d3268;
            margin-bottom: 5px;
        }

        .custom-pagination .page-link {
            color: #007bff;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
@endsection
