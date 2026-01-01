@extends('layouts.master')
@section('content')

<style>
    /* Profile Card Styles */
    .profile-card {
        background-color: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
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
        background-color: #fff;
    }

    .member-name {
        margin-top: 10px;
        margin-bottom: 4px;
        font-weight: 700;
        color: #e76a35;
        font-size: 1.25rem;
    }

    .info-section {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 15px;
        margin-bottom: 20px;
        padding: 0 10px;
    }

    .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 13px;
        color: #1d3268;
        font-weight: bold;
    }

    .icon-text i {
        font-size: 22px;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .company-category-section {
        display: flex;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        padding: 15px 0;
        margin-top: auto;
    }

    .company-section,
    .category-section {
        flex: 1;
        text-align: center;
        padding: 0 10px;
    }

    .divider {
        width: 1px;
        background-color: #ccc;
        margin: 0 5px;
    }

    .logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .logo-section img,
    .initials {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e0e0e0;
    }

    .initials {
        background-color: #c1c1c1;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .company-section h2,
    .category-section h3 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #334155;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-section .label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        margin-bottom: 2px;
    }

    .keywords-container {
        padding: 15px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 5px;
    }

    .keyword-pill {
        font-size: 0.75rem;
        padding: 4px 10px;
        background-color: #eff6ff;
        color: #1d3268;
        border-radius: 20px;
        font-weight: 600;
    }

    .induction-count-section {
        text-align: center;
        padding: 10px;
        background-color: #f8fafc;
        border-top: 1px solid #f0f0f0;
    }

    .bottom-actions {
        display: flex;
        justify-content: center;
        padding: 15px;
        border-top: 1px solid #f0f0f0;
        color: #1d3268;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .bottom-actions:hover {
        background-color: #f8fafc;
    }

    .bottom-actions i {
        margin-right: 8px;
    }

    .custom-pagination {
        margin-top: 20px;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- Header -->
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="bi bi-people-fill text-primary me-2" style="color: #e76a35 !important;"></i> My
                            Circle Connections
                        </h4>
                        <p class="text-muted small mb-0">View and manage your circle connections</p>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="row g-4">
                @forelse ($myConnections as $myConnectionsData)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="profile-card shadow-sm rounded border-0">
                        <img src="{{ asset('img/header_img.jpeg') }}" class="header-image" alt="Header Image">
                        {{-- <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image"> --}}

                        <div class="text-center p-3 flex-grow-1 d-flex flex-column">
                            <img src="{{ asset($myConnectionsData->profilePicture ?? 'img/profile.png') }}"
                                class="profile-img mx-auto" alt="Profile">
                            <h5 class="member-name">{{ $myConnectionsData->firstName ?? 'N/A' }} {{
                                $myConnectionsData->lastName ?? 'N/A' }}</h5>

                            <div class="info-section">
                                <div class="icon-text" title="{{ $myConnectionsData->user->email ?? 'N/A' }}">
                                    <i class="bi bi-envelope-fill"></i>
                                    <div>{{ Str::limit($myConnectionsData->user->email ?? 'N/A', 8) }}</div>
                                </div>
                                <div class="icon-text" title="{{ $myConnectionsData->user->contactNo ?? 'N/A' }}">
                                    <i class="bi bi-telephone-fill"></i>
                                    <div>{{ $myConnectionsData->user->contactNo ?? 'N/A' }}</div>
                                </div>
                                <div class="icon-text">
                                    <i class="bi bi-people-fill"></i>
                                    <div>{{ $myConnectionsData->circle->circleName ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <div class="company-category-section mt-auto">
                                <div class="company-section">
                                    <div class="logo-section">
                                        @if (!empty($myConnectionsData->companyLogo))
                                        <img src="{{ asset('CompanyLogo/' . $myConnectionsData->companyLogo) }}"
                                            class="company-logo" alt="Company Logo"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        @endif
                                        <div class="initials"
                                            style="{{ empty($myConnectionsData->companyLogo) ? 'display:flex;' : 'display:none;' }}">
                                            {{ strtoupper(substr($myConnectionsData->companyName ?? 'C', 0, 1)) }}
                                        </div>
                                    </div>
                                    <h2 title="{{ $myConnectionsData->companyName ?? 'Company Name' }}">
                                        {{ $myConnectionsData->companyName ?? 'Company Name' }}
                                    </h2>
                                </div>
                                <div class="divider"></div>
                                <div class="category-section">
                                    <div class="label">Category</div>
                                    <h3>{{ $myConnectionsData->bCategory->categoryName ?? 'N/A' }}</h3>
                                </div>
                            </div>

                            <div class="keywords-container">
                                @php
                                $keyWords = json_decode($myConnectionsData->keyWords ?? '[]', true);
                                @endphp

                                @if (is_array($keyWords) && count($keyWords) > 0)
                                @foreach ($keyWords as $keyWord)
                                <span class="keyword-pill">{{ $keyWord }}</span>
                                @endforeach
                                @endif
                            </div>

                            <div class="induction-count-section rounded bg-light mt-2">
                                <div class="label" style="color: #1d3268; font-weight: bold;">Induction Count : {{
                                    $myConnectionsData->inductionCount ?? '0' }}</div>
                            </div>
                        </div>

                        <div class="bottom-actions">
                            <a href="#" class="text-decoration-none d-flex align-items-center" style="color: inherit;">
                                <i class="bi bi-person-lines-fill"></i>
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No circle connections found.
                    </div>
                </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-end custom-pagination mt-4">
                {!! $myConnections->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
