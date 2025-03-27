@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center card-title mb-4">Circles</h1>
        <div class="row">
            @foreach ($circles as $circlesData)
                <div class="col-md-4 mb-4">
                    <div class="profile-card">
                        <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                        <div class="text-center p-3">
                            <img src="{{ asset($circlesData->profilePicture ?? 'img/logo2.jpg') }}" class="profile-img" alt="Profile Picture">
                            <h5 style="color: #e76a35; font-weight: bold;">{{ $circlesData->circleName ?? 'N/A' }}</h5>
                            {{-- <p class="text-muted">Active Circle</p> --}}
                            <div class="info-section">
                                <div class="icon-text">
                                    <i class="bi bi-geo-alt-fill" style="color: #e76a35;"></i>
                                    <div style="color: #1d3268; font-weight: bold;">{{ $circlesData->city->cityName ?? 'N/A' }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-currency-rupee" style="color: #e76a35;"></i>
                                    <div style="color: #1d3268; font-weight: bold;">{{ number_format($circlesData->totalBusinessAmount ?? 0, 2, '.', ',') }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-people-fill" style="color: #e76a35"></i>
                                    <div style="color: #1d3268; font-weight: bold;">{{ $circlesData->members_count }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom-actions">
                            <button class="btn-message" onclick="window.location.href='{{ route('connection.showMembers', $circlesData->id) }}'">View Members</button>
                        </div>
                    </div>
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
            height: 120px;
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

        .info-section {
            display: flex;
            justify-content: space-around;
            text-align: center;
            margin-top: 10px;
        }

        .icon-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 14px;
        }

        .icon-text i {
            font-size: 20px;
            color: #5f6368;
            margin-bottom: 4px;
        }

        .bottom-actions {
            text-align: center;
            padding: 10px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-message {
            background-color: #1d3268;
            color: white;
            border-radius: 50px;
            padding: 6px 14px;
            border: none;
        }

        .card-title {
            font-size: 28px;
            font-weight: bold;
            color: #1d3268;
            margin-bottom: 20px;
        }
    </style>
@endsection
