@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="p-3 d-flex justify-content-between">
                <h1 class="card-title mb-0 p-0">Members of {{ $category->categoryName }} Category</h1>
                <a href="{{ route('connection.categoryList') }}" class="btn btn-bg-orange btn-sm mb-0 pb-0 ">BACK</a>
            </div>
        </div>
        <div class="row">
            @forelse ($members as $member)
                <div class="col-md-3 mb-4">
                    <div class="profile-card">
                        <div class="card-body">
                            <!-- Profile Picture -->
                            {{-- <img src="{{ asset($member->profilePhoto ?? 'img/logo2.jpg') }}" alt="Profile Picture" class="profile-img mb-3 object-fit-contain"> --}}

                            <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'logo2.jpg')) }}" alt="Profile Picture" class="profile-img mb-3 object-fit-contain">

                            <!-- User Name -->
                            <h3 class="profile-name mb-3" style="color: #e76a35">
                                {{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}
                            </h3>

                            <!-- Email -->
                            <p style="font-size: 14px; color: #1d3268;"><b>{{ $member->user->email ?? 'N/A' }}</b></p>

                            <!-- Business Category -->
                            <h3 class="profile-name mb-3" style="color: #e76a35">
                                {{ $category->categoryName ?? 'N/A' }}
                            </h3>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No active members found in this category.</p>
            @endforelse
        </div>
    </div>

    <style>
        .profile-card {
            width: 280px !important;
            height: 250px !important;
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
