@extends('layouts.master')

@section('title', 'UBN - My Connections')
@section('content')

    <div class="container my-5">
        <!-- Page Header -->
        <h1 class="text-center card-title mb-4">My Connections</h1>

        <!-- Search Bar -->
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
                        <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                        <div class="text-center p-3">
                            <!-- Profile Picture -->
                            <img src="{{ asset($connection->connectedUser->profilePicture ?? 'img/profile.png') }}" class="profile-img" alt="Profile">

                            <!-- User Name -->
                            <h5 class="profile-name">
                                {{ $connection->connectedUser->firstName ?? 'N/A' }} {{ $connection->connectedUser->lastName ?? 'N/A' }}
                            </h5>

                            <!-- Connection Status -->
                            <p class="profile-details">
                                @if ($connection->status === 'Accepted')
                                    <span class="badge bg-success">Connected</span>
                                @else
                                    <span class="badge bg-secondary">{{ $connection->status }}</span>
                                @endif
                            </p>

                            <!-- Company & Contact Info -->
                            {{-- <div class="info-section">
                                <div class="icon-text" title="{{ $connection->connectedUser->email ?? 'N/A' }}">
                                    <i class="bi bi-envelope-fill"></i>
                                    <div>{{ Str::limit($connection->connectedUser->email ?? 'N/A', 15) }}</div>
                                </div>
                                <div class="icon-text" title="{{ $connection->connectedUser->contactNo ?? 'N/A' }}">
                                    <i class="bi bi-telephone-fill"></i>
                                    <div>{{ Str::limit($connection->connectedUser->contactNo ?? 'N/A', 10) }}</div>
                                </div>
                            </div> --}}

                            <!-- Remove Connection Button -->
                            <a href="{{ route('connection.removeConnection', $connection->id) }}" class="btn btn-sm btn-outline-danger mt-2">
                                <i class="bi bi-x"></i> Remove Connection
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .search-bar {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-bar input {
            width: 80%;
            padding: 12px;
            border: 1px solid #e76a35;
            border-radius: 8px;
            font-size: 1em;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .search-bar input::placeholder {
            color: #162e6b;
        }

        .profile-card {
            width: 250px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .header-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: -50px;
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

        .info-section {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .icon-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            color: #1d3268;
            flex: 1;
        }

        .btn-outline-danger {
            font-size: 14px;
            font-weight: bold;
            border-radius: 20px;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            /* background-color: #ff4b5c; */
            background-color: #e76a35;
            color: white;
        }
    </style>
@endsection
