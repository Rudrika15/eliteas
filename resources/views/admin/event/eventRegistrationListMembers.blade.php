@extends('layouts.master')

@section('header', 'Event')
@section('content')

    <div class="container mt-5">
        <div class="card">
            <div class="p-3 d-flex justify-content-between">
                <h1 class="card-title mb-0 p-0">Registration List of {{ $event->title }}</h1>
                <!-- Back button can be added if necessary -->
                {{-- <a href="{{ route('event.index') }}" class="btn btn-bg-orange btn-sm mb-0 pb-0">BACK</a> --}}
            </div>
        </div>

        <div class="row mt-4">
            @foreach ($registerLists as $registerListsData)
                <div class="col-md-4 mb-4">
                    <div class="profile-card">
                        <div class="card-body">
                            <!-- Member Name -->
                            <img src="{{ $registerListsData->members ? asset('ProfilePhoto/' . ($registerListsData->members->profilePhoto ?? 'profile.png')) : asset('ProfilePhoto/profile.png') }}" class="profile-img mb-3 object-fit-contain" alt="Profile Picture">
                            @if ($registerListsData->personName)
                                <p class="profile-name" style="color: #e76a35">
                                    {{ $registerListsData->personName }}
                                </p>
                            @elseif ($registerListsData->members->firstName || $registerListsData->members->lastName)
                                <h3 class="profile-name" style="color: #e76a35">
                                    {{ $registerListsData->members->firstName ?? '' }}
                                    {{ $registerListsData->members->lastName ?? '' }}
                                </h3>
                                <p class="profile-companyName" style="color: #1d3268; font-size: 14px; font-weight: bold;">
                                    {{ $registerListsData->members->circle->circleName ?? '' }}
                                </p>
                                <p class="profile-companyName" style="color: #1d3268; font-size: 14px; font-weight: bold;">
                                    {{ $registerListsData->members->companyName ?? '' }}
                                </p>
                                <p class="profile-companyName" style="color: #1d3268; font-size: 14px; font-weight: bold;">
                                    {{ $registerListsData->members->bCategory->categoryName ?? '' }}
                                </p>
                                <p class="profile-companyName" style="color: #1d3268; font-size: 14px; font-weight: bold;">
                                    {{ $registerListsData->members->circle->city->cityName ?? '' }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- <div class="d-flex justify-content-end custom-pagination">
            {!! $registerLists->links() !!}
        </div> --}}
    </div>


    <style>
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
