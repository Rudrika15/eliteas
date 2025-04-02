@extends('layouts.master')

@section('content')

    <style>
        .initials {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #c1c1c1;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .profile-card {
            width: 400px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            margin: 50px auto;
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

        h5 {
            margin-top: 10px;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .text-muted {
            color: #6c757d;
            font-size: 14px;
        }

        .info-section {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
            margin-bottom: 20px;
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

        .icon-text i {
            font-size: 22px;
            color: #4a4a4a;
            margin-bottom: 5px;
        }

        .company-category-section {
            display: flex;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 0;
        }

        .company-section,
        .category-section {
            flex: 1;
            text-align: center;
        }

        .divider {
            width: 1px;
            background-color: #ccc;
            height: auto;
            margin: 0 15px;
        }

        .logo-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 8px;
        }

        .logo-section img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .company-section h2,
        .category-section h3 {
            margin: 6px 0;
            color: #1d2951;
            font-size: 16px;
        }

        .category-section .label {
            color: gray;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .keywords-container {
            text-align: center;
            margin: 15px 20px 10px;
        }

        .keyword-pill {
            display: inline-block;
            background-color: #f3f5fb;
            color: #3a3a3a;
            font-size: 12px;
            padding: 6px 12px;
            margin: 5px 5px;
            border-radius: 20px;
            border: 1px solid #e0e4f0;
            cursor: default;
        }

        .bottom-actions {
            display: flex;
            border-top: 1px solid #e6e6e6;
            padding: 10px 0;
            text-align: center;
        }

        .bottom-actions div {
            flex: 1;
            cursor: pointer;
            font-weight: 600;
            color: #1d2951;
            transition: color 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .bottom-actions div:hover {
            color: #e76a35;
        }

        .bottom-divider {
            width: 1px;
            background-color: #e0e0e0;
            height: auto;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .profile-card {
                width: 80%;
            }
        }
       
        @media (max-width: 1440px) {
            .profile-card {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .profile-card {
                width: 90%;
            }

            .info-section {
                flex-direction: column;
                align-items: center;
            }

            .company-category-section {
                flex-direction: column;
                text-align: center;
            }

            .divider {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .profile-card {
                width: 95%;
                margin: 20px auto;
            }

            h5 {
                font-size: 16px;
            }

            .profile-img {
                width: 80px;
                height: 80px;
            }

            .icon-text i {
                font-size: 18px;
            }
        }
    </style>



    <div class="container mt-5">
        <h1 class="text-center card-title mb-4">Members of {{ $circle->circleName }} Circle</h1>
        <div class="row">
            @forelse ($circle->members as $member)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="profile-card">
                        <img src="https://picsum.photos/600/120" class="header-image img-fluid" alt="Header Image">
                        <div class="text-center p-3">
                            <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'logo2.jpg')) }}" class="profile-img img-fluid" alt="Profile">
                            <h5 style="color: #e76a35; font-weight: bold;">{{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}</h5>

                            <div class="info-section">
                                <div class="icon-text" title="{{ $member->user->email ?? 'N/A' }}">
                                    <i class="bi bi-envelope-fill" style="color: #e76a35;"></i>
                                    <div>{{ Str::limit($member->user->email ?? 'N/A', 10) }}</div>
                                </div>
                                <div class="icon-text" title="{{ $member->user->contactNo ?? 'N/A' }}">
                                    <i class="bi bi-telephone-fill" style="color: #e76a35;"></i>
                                    <div>{{ Str::limit($member->user->contactNo ?? 'N/A', 10) }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-people-fill" style="color: #e76a35;"></i>
                                    <div>{{ $circle->circleName ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="company-category-section">
                                <div class="company-section">
                                    <div class="logo-section">
                                        @if (!empty($member->companyLogo))
                                            <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" class="company-logo img-fluid" alt="Company Logo">
                                        @endif
                                        <div class="initials" style="{{ empty($member->companyLogo) ? 'display:flex;' : 'display:none;' }}">
                                            {{ strtoupper(substr($member->companyName ?? 'C', 0, 1)) }}
                                        </div>
                                    </div>
                                    <h2 title="{{ $member->companyName ?? 'Company Name' }}">
                                        {{ $member->companyName ?? 'Company Name' }}
                                    </h2>
                                </div>
                                <div class="divider"></div>
                                <div class="category-section">
                                    <div class="label">Category</div>
                                    <h3>{{ $member->bCategory->categoryName ?? 'N/A' }}</h3>
                                </div>
                            </div>

                            <div class="keywords-container">
                                @php
                                    $keyWords = json_decode($member->keyWords ?? '[]', true);
                                @endphp

                                @if (is_array($keyWords))
                                    @foreach ($keyWords as $keyWord)
                                        <span class="keyword-pill">{{ $keyWord }}</span>
                                    @endforeach
                                @else
                                    <span class="keyword-pill">No Keywords</span>
                                @endif
                            </div>
                        </div>
                        <div class="bottom-actions">
                            <div>
                                <i class="bi bi-person-lines-fill"></i>
                                View Profile
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No active members found in this circle.</p>
            @endforelse
        </div>
    </div>



@endsection
