@extends('layouts.master')
@section('content')
    <div class="container mt-5">
        <h1 class="text-center card-title mb-4">Category</h1>
        <div class="row">
            @foreach ($categories as $categoryData)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('connection.showCategoryWiseMembers', $categoryData->id) }}" class="text-decoration-none">
                        <div class="profile-card">
                            <div class="card-body">
                                <!-- Profile Picture -->
                                {{-- <img src="{{ asset($categoryData->categoryIcon ?? 'img/logo2.jpg') }}" alt="Category Icon" class="profile-img mb-3 object-fit-contain"> --}}

                                <img src="{{ asset('BusinessCategory/' . ($categoryData->categoryIcon ?? 'logo2.jpg')) }}" alt="Category Icon" class="profile-img mb-3 object-fit-contain">


                                <!-- Category Name -->
                                <h3 class="profile-name mb-3" style="color: #e76a35">
                                    {{ $categoryData->categoryName ?? '' }}
                                </h3>

                                <!-- Total Members -->
                                <h3 class="profile-name mb-3">
                                    Total Members: {{ $categoryData->members_count ?? '' }}
                                </h3>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end custom-pagination">
            {{-- {!! $categories->links() !!} --}}
        </div>
    </div>



    <style>
        .profile-card {
            width: 250px !important;
            height: 195px !important;
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
