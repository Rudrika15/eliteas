@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center card-title mb-4">My Circle Connections</h1>
        <div class="row">
            @foreach ($myConnections as $myConnectionsData)
                <div class="col-md-4 mb-4">
                    <div class="profile-card">
                        <img src="https://picsum.photos/600/100" class="header-image" alt="Header Image">
                        <div class="text-center p-3">
                            <img src="{{ asset($myConnectionsData->profilePicture ?? 'img/profile.png') }}" class="profile-img" alt="Profile">
                            <h5 class="mt-2 mb-0">{{ $myConnectionsData->firstName ?? 'N/A' }} {{ $myConnectionsData->lastName ?? 'N/A' }}</h5>
                            <p class="text-muted mb-2" style="font-size: 14px;">Circle Member</p>
                            <div class="d-flex justify-content-around text-center mt-3 mb-3">
                                <div class="icon-text" data-toggle="tooltip" data-placement="top" title="{{ $myConnectionsData->user->email ?? 'N/A' }}">
                                    <i class="bi bi-envelope-fill"></i>
                                    <div>{{ Str::limit($myConnectionsData->user->email ?? 'N/A', 10) }}</div>
                                </div>
                                <div class="icon-text" data-toggle="tooltip" data-placement="top" title="{{ $myConnectionsData->user->contactNo ?? 'N/A' }}">
                                    <i class="bi bi-telephone-fill"></i>
                                    <div>{{ Str::limit($myConnectionsData->user->contactNo ?? 'N/A', 5) }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-people-fill"></i>
                                    <div>{{ $myConnectionsData->circle->circleName ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="company-name">{{ $myConnectionsData->companyName ?? 'Company Name' }}</div>
                                <div class="category-text"> {{ $myConnectionsData->bCategory->categoryName ?? 'N/A' }}</div>
                                <div>
                                    <button class="keyword-btn">{{ $myConnectionsData->keyword1 ?? 'Keyword 1' }}</button>
                                    <button class="keyword-btn">{{ $myConnectionsData->keyword2 ?? 'Keyword 2' }}</button>
                                    <button class="keyword-btn">{{ $myConnectionsData->keyword3 ?? 'Keyword 3' }}</button>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="profile-actions">
                        <a href="#">View Profile</a>
                        <button class="btn-message">Message</button>
                    </div> --}}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end custom-pagination">
            {!! $myConnections->links() !!}
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
        }

        .btn-message {
            background-color: #ff6b6b;
            color: white;
            border-radius: 50px;
            padding: 6px 14px;
            border: none;
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
