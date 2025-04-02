@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center card-title mb-4">Circles</h1>
        <div class="row justify-content-center">
            @foreach ($circles as $circlesData)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 d-flex justify-content-center">
                    <div class="profile-card">
                        <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                        <div class="text-center p-3">
                            <img src="{{ asset($circlesData->profilePicture ?? 'img/logo2.jpg') }}" class="profile-img" alt="Profile Picture">
                            <h5 class="circle-name">{{ $circlesData->circleName ?? 'N/A' }}</h5>
                            <div class="info-section">
                                <div class="icon-text">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <div>{{ $circlesData->city->cityName ?? 'N/A' }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-currency-rupee"></i>
                                    <div>{{ number_format($circlesData->totalBusinessAmount ?? 0, 2, '.', ',') }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-people-fill"></i>
                                    <div>{{ $circlesData->members_count }}</div>
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
            width: 100%;
            max-width: 320px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            margin: 0 auto;
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
            color: #e76a35;
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
        }

        @media (max-width: 992px) {
            .col-lg-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .info-section {
                flex-direction: column;
                align-items: center;
            }

            .profile-card {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .profile-card {
                padding: 10px;
            }

            .profile-img {
                width: 70px;
                height: 70px;
                margin-top: -35px;
            }

            .icon-text i {
                font-size: 16px;
            }
        }
    </style>
@endsection
