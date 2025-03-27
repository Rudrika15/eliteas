@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="p-3 d-flex justify-content-between">
                <h1 class="card-title mb-0 p-0">Members of {{ $category->categoryName }} Category</h1>
                <a href="{{ route('connection.categoryList') }}" class="btn btn-bg-orange btn-sm mb-0 pb-0">BACK</a>
            </div>
        </div>

        <div class="row">
            @forelse ($members as $member)
                <div class="col-md-4 mb-4">
                    <div class="profile-card">
                        <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                        <div class="text-center p-3">
                            <!-- Profile Image -->
                            <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'logo2.jpg')) }}" class="profile-img" alt="Profile">

                            <!-- Member Name -->
                            <h5 style="color: #e76a35; font-weight: bold;">{{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}</h5>

                            <!-- Contact Information -->
                            <div class="info-section">
                                <div class="icon-text" title="{{ $member->user->email ?? 'N/A' }}">
                                    <i class="bi bi-envelope-fill" style="color: #e76a35;"></i>
                                    <div>{{ Str::limit($member->user->email ?? 'N/A', 15) }}</div>
                                </div>
                                <div class="icon-text" title="{{ $member->user->contactNo ?? 'N/A' }}">
                                    <i class="bi bi-telephone-fill" style="color: #e76a35;"></i>
                                    <div>{{ Str::limit($member->user->contactNo ?? 'N/A', 10) }}</div>
                                </div>
                            </div>

                            <!-- Company & Category Section -->
                            <div class="company-category-section">
                                <div class="company-section">
                                    <div class="logo-section">
                                        @if (!empty($member->companyLogo))
                                            <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" class="company-logo" alt="Company Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
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
                                    <h3>{{ $category->categoryName ?? 'N/A' }}</h3>
                                </div>
                            </div>

                            <!-- Keywords Section -->
                            <div class="keywords-container">
                                @php
                                    $keyWords = json_decode($member->keyWords ?? '[]', true);
                                @endphp

                                @if (is_array($keyWords) && count($keyWords) > 0)
                                    @foreach ($keyWords as $keyWord)
                                        <span class="keyword-pill">{{ $keyWord }}</span>
                                    @endforeach
                                @else
                                    <span class="keyword-pill">No Keywords</span>
                                @endif
                            </div>
                        </div>

                        <!-- Bottom Actions -->
                        <div class="bottom-actions">
                            <div>
                                <i class="bi bi-person-lines-fill"></i>
                                View Profile
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No active members found in this category.</p>
            @endforelse
        </div>
    </div>

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
            /* mix-blend-mode: color-burn; */

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
            justify-content: center;
        }

        .bottom-actions div {
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
    </style>
@endsection
