{{-- @extends('layouts.master')
@section('content')
<style>
    .circle-name {
        color: #1d3268;
    }

    .city-card.active {
        background-color: #e6efff;
        border-left: 4px solid #1d3268;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Left: City List -->
        <div class="col-md-3">
            <div class="bg-light rounded p-3 mb-3">
                <h6 class="fw-semibold text-muted mb-3">All Cities ({{ $cities->count() }})</h6>
                <div class="city-list">
                    @foreach ($cities as $index => $city)
                    <div class="city-card d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2"
                        data-id="{{ $city->id }}" style="cursor: pointer;">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-muted">{{ $index + 1 }}.</span>
                            <div>
                                <div class="fw-semibold circle-name">{{ $city->cityName }}</div>
                                <small class="text-muted">{{ $city->status }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Members List -->
        <div class="col-md-9">
            <div id="memberCardsContainer" class="row g-4">
                @foreach ($members as $member)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <img src="{{ asset($member->profilePicture ?? 'img/logo2.jpg') }}"
                                class="rounded-circle mb-2" width="60" height="60" alt="Profile">
                            <h6 class="circle-name mb-0">
                                {{ $member->firstName ?? '' }} {{ $member->lastName ?? '' }}
                            </h6>
                            <small class="text-muted">
                                {{ $member->city->cityName ?? 'N/A' }}
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
            const cities = document.querySelectorAll('.city-card');
            const container = document.getElementById('memberCardsContainer');

            cities.forEach(city => {
                city.addEventListener('click', function() {
                    // Remove active class
                    cities.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    const cityId = this.getAttribute('data-id');
                    container.innerHTML = '<p class="text-center circle-name mt-3">Loading members...</p>';

                    // 👇 Use your existing route here
                    fetch(`/get-city-members/${cityId}`)
                        .then(response => response.text())
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error fetching members:', error);
                            container.innerHTML = '<p class="text-danger text-center">Error loading members.</p>';
                        });
                });
            });
        });
</script>
@endsection --}}


{{--
@extends('layouts.master')

@section('content')

<style>
    .circle-name {
        color: #1d3268;
    }

    .city-card.active {
        background-color: #e6efff;
        border-left: 4px solid #1d3268;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row">

        <!-- LEFT : CITY LIST -->
        <div class="col-md-3">
            <div class="bg-light rounded p-3 mb-3">
                <h6 class="fw-semibold text-muted mb-3">
                    All Cities ({{ $cities->count() }})
                </h6>

                @foreach ($cities as $index => $city)
                <div class="city-card d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2"
                    data-id="{{ $city->id }}" style="cursor:pointer;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold text-muted">{{ $index + 1 }}.</span>
                        <div>
                            <div class="fw-semibold circle-name">{{ $city->cityName }}</div>
                            <small class="text-muted">{{ $city->status }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- RIGHT : MEMBERS -->
        <div class="col-md-9">
            <div id="memberCardsContainer" class="row g-4">
                @foreach ($members as $member)
                <div class="col-md-4 member-card" data-city="{{ $member->cityId }}">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <img src="{{ asset($member->profilePicture ?? 'img/logo2.jpg') }}"
                                class="rounded-circle mb-2" width="60" height="60">

                            <h6 class="mb-0">
                                {{ $member->firstName }} {{ $member->lastName }}
                            </h6>

                            <small class="text-muted">
                                {{ $member->city->cityName ?? 'N/A' }}
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.city-card').forEach(card => {
        card.addEventListener('click', function () {

            // active UI
            document.querySelectorAll('.city-card').forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            const cityId = this.getAttribute('data-id');

            document.querySelectorAll('.member-card').forEach(member => {
                member.style.display =
                    member.getAttribute('data-city') == cityId ? 'block' : 'none';
            });
        });
    });
</script>

@endsection --}}


@extends('layouts.master')

@section('content')

<style>
    .circle-name {
        color: #1d3268;
    }

    .city-card.active {
        background-color: #e6efff;
        border-left: 4px solid #1d3268;
    }
</style>

<style>
    .fb-card {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
        height: 100%;
        display: flex;
        flex-direction: column;
        font-family: sans-serif;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .fb-card-img-wrapper {
        width: 100%;
        padding-top: 100%;
        /* 1:1 Aspect Ratio */
        position: relative;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    .fb-card-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .fb-card-body {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
    }

    .fb-card-title {
        color: #1d3268;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .fb-card-subtitle {
        color: #65676b;
        font-size: 15px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .fb-card-info {
        color: #65676b;
        font-size: 14px;
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .fb-card-info i {
        color: #e76a35;
    }

    .fb-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #e76a35;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .fb-btn {
        width: 100%;
        border: none;
        border-radius: 6px;
        padding: 8px 0;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
    }

    .fb-btn:hover {
        text-decoration: none;
    }

    .fb-btn-primary {
        background-color: #1d3268;
        color: #fff;
    }

    .fb-btn-primary:hover {
        background-color: #15244d;
        color: #fff;
    }

    .fb-btn-secondary {
        background-color: #e4e6eb;
        color: #1d3268;
        margin-top: 10px;
    }

    .fb-btn-secondary:hover {
        background-color: #d8dadf;
        color: #1d3268;
    }

    .fb-btn-disabled {
        background-color: #e4e6eb;
        color: #bcc0c4;
        cursor: default;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header & Dropdown Section -->
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-building text-primary me-2"></i> City Connections
                        </h4>
                        <p class="text-muted small mb-0 mt-1">Select a city to view associated members</p>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bi bi-filter"></i>
                            </span>
                            <select id="citySelect" class="form-select border-0 bg-light py-2" aria-label="Select City"
                                style="cursor: pointer;">
                                <option value="" selected disabled>Choose a City...</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}">
                                    {{ $city->cityName }} ({{ $city->members->count() ?? '0' }} Members)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Section -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h5 class="fw-bold text-muted mb-0">Members List</h5>
                        <span class="badge bg-light text-primary rounded-pill px-3 py-2" id="selectedCityBadge">No City
                            Selected</span>
                    </div>

                    <div id="memberCardsContainer" class="row g-4">
                        <div id="noCitySelectedMsg" class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-people display-1 mb-3 text-secondary opacity-25"></i>
                                <h5 class="fw-normal">No Members Displayed</h5>
                                <p class="text-muted small">Please select a city from the dropdown above.</p>
                            </div>
                        </div>

                        @foreach ($cities as $city)
                        @foreach ($city->members as $member)
                        <div class="col-sm-6 col-lg-4 member-card" data-city="{{ $city->id }}" style="display: none;">
                            <div class="fb-card shadow-sm">
                                <div class="fb-card-img-wrapper">
                                    <span class="fb-badge">Member</span>
                                    {{-- <img src="{{ asset($member->ProfilePhoto ?? 'img/profile.png') }}"
                                        class="fb-card-img" alt="Profile Image"> --}}
                                    <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'profile.png')) }}"
                                        class="fb-card-img" alt="Profile Image">
                                </div>

                                <div class="fb-card-body">
                                    <h5 class="fb-card-title">
                                        {{ $member->firstName }} {{ $member->lastName }}
                                    </h5>

                                    <div class="fb-card-subtitle">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        {{ $city->cityName }}
                                    </div>

                                    <div class="fb-card-info">
                                        @if(!empty($member->companyName))
                                        <div><i class="bi bi-building"></i> {{ $member->companyName }}</div>
                                        @endif

                                        @if(!empty($member->bCategory->categoryName))
                                        <div><i class="bi bi-tag"></i> {{ $member->bCategory->categoryName }}</div>
                                        @endif
                                    </div>

                                    <div class="mt-auto">
                                        <a href="{{ route('foundPersonDetails', $member->id) }}"
                                            class="text-decoration-none d-block w-100">
                                            <button class="fb-btn fb-btn-primary w-100">
                                                View Profile
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach

                        <div id="noMembersFoundMsg" class="col-12 text-center py-5" style="display: none;">
                            <div class="text-muted">
                                <i class="bi bi-emoji-frown display-1 mb-3 text-secondary opacity-25"></i>
                                <h5 class="fw-normal">No Members Found</h5>
                                <p class="text-muted small">There are no members in this city yet.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#citySelect').on('change', function() {
            var cityId = $(this).val();
            var cityName = $(this).find("option:selected").text().split('(')[0].trim();

            // Update Badge
            $('#selectedCityBadge').text(cityName);

            // Hide initial message
            $('#noCitySelectedMsg').hide();
            $('#noMembersFoundMsg').hide();

            // Hide all members
            $('.member-card').hide();

            // Show members for selected city
            var visibleMembers = $('.member-card[data-city="' + cityId + '"]');

            if(visibleMembers.length > 0) {
                visibleMembers.fadeIn();
            } else {
                $('#noMembersFoundMsg').fadeIn();
            }
        });
    });
</script>

@endsection
