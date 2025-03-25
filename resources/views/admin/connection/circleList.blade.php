@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <h1 class="text-center card-title">Circles</h1>
        </div>
        <div class="row">
            @foreach ($circles as $circlesData)
                <div class="col-md-4 mb-4">
                    <a href="{{ route('connection.showMembers', $circlesData->id) }}" class="text-decoration-none">
                        <div class="profile-card">
                            <img src="https://picsum.photos/600/100" class="header-image" alt="Header Image">
                            <div class="text-center p-3">
                                <img src="{{ asset($circlesData->profilePicture ?? 'img/logo2.jpg') }}" class="profile-img" alt="Profile Picture">
                                <h5 class="mt-2 mb-0" style="color: #e76a35; font-weight: bold;">{{ $circlesData->circleName ?? '' }}</h5>
                                {{-- <p class="text-muted mb-2" style="font-size: 14px;">
                                    Total Members: {{ $circlesData->members_count ?? 0 }}
                                </p> --}}
                                <div class="d-flex justify-content-around text-center mt-3 mb-3">
                                    <div class="icon-text">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <div style="font-size: 14px; font-weight: bold; color: #e76a35;">{{ $circlesData->city->cityName ?? 'N/A' }}</div>
                                    </div>
                                    <div class="icon-text">
                                        <i class="bi bi-currency-rupee"></i>
                                        <div style="font-size: 14px; font-weight: bold; color: #e76a35;">{{ number_format($circlesData->totalBusinessAmount ?? 0, 2, '.', ',') }}</div>
                                    </div>
                                    <div class="icon-text">
                                        <i class="bi bi-people-fill"></i>
                                        <div style="font-size: 14px; font-weight: bold; color: #e76a35;">{{ $circlesData->members_count }}</div>
                                    </div>
                                </div>
                                {{-- <div class="text-center">
                                    <div class="company-name">{{ $circlesData->circleName }}</div>
                                    <div class="category-text">Active Circle</div>
                                    <div>
                                        <button class="keyword-btn">Business</button>
                                        <button class="keyword-btn">Members</button>
                                        <button class="keyword-btn">View</button>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="profile-actions d-flex justify-content-center">
                                {{-- <a href="{{ route('connection.showMembers', $circlesData->id) }}">View Members</a> --}}
                                <button class="btn-message " onclick="window.location.href='{{ route('connection.showMembers', $circlesData->id) }}'">View Members</button>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .profile-card {
            width: 320px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            margin: 20px auto;
        }

        .header-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .profile-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            margin-top: -45px;
        }

        .icon-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-size: 13px;
        }

        .icon-text i {
            font-size: 20px;
            color: #5f6368;
            margin-bottom: 4px;
        }

        .company-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .category-text {
            color: #888;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .keyword-btn {
            border-radius: 50px;
            font-size: 12px;
            padding: 4px 12px;
            background-color: #f1f1f1;
            border: none;
            margin: 4px;
        }

        .profile-actions {
            border-top: 1px solid #f0f0f0;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-actions a {
            text-decoration: none;
            font-weight: 500;
            color: #1d3268;
        }

        .btn-message {
            background-color: #ff6b6b;
            color: white;
            border-radius: 50px;
            padding: 6px 14px;
            border: none;
        }

        .card-title {
            font-size: 28px;
            font-weight: bold;
            color: #1d3268;
            margin: 30px 0 20px;
        }
    </style>
@endsection
