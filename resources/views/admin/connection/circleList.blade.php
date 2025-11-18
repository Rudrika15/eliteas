@extends('layouts.master')
@section('content')
    <style>
        .circle-name {
            color: #1d3268;
        }
    </style>


    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Left: Circle List (col-md-3) -->
            <div class="col-md-3">
                <!-- My Circle Section -->
                <div class="bg-light rounded p-3 mb-3">
                    <h6 class="fw-semibold text-muted mb-3">My Circle</h6>
                    @if ($authCircle)
                        <div class="d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset($authCircle->profilePicture ? (file_exists(public_path($authCircle->profilePicture)) ? $authCircle->profilePicture : 'ProfilePhoto/profile.png') : 'img/profile.png') }}" class="rounded-circle" width="40" height="40" alt="{{ $authCircle->circleName }}">
                                <div>
                                    <div class="fw-semibold circle-name">{{ $authCircle->circleName }}</div>
                                    <small class=" circle-name">{{ $authCircle->city->cityName ?? 'N/A' }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold circle-name">₹ {{ number_format($authCircle->totalBusinessAmount ?? 0, 0) }}</div>
                                <small class="text-muted circle-name">👥 <span class="circle-name"> {{ $authCircle->members_count }}</span></small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted small">You are not part of any circle yet.</p>
                    @endif
                </div>

                <!-- Filters -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">All Circle ({{ $circles->count() }})</small>
                    <select class="form-select form-select-sm w-50">
                        <option selected>All City</option>
                        @foreach ($circles->pluck('city.cityName')->unique() as $cityName)
                            <option>{{ $cityName }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- All Circles -->
                <div class="circle-list">
                    @foreach ($circles as $index => $circle)
                        <div class="circle-card d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2" data-id="{{ $circle->id }}" style="cursor: pointer;">
                            <div class="d-flex align-items-center gap-2">
                                <span class="fw-bold text-muted">{{ $index + 1 }}.</span>
                                <img src="{{ asset($circle->profilePicture ? (file_exists(public_path($circle->profilePicture)) ? $circle->profilePicture : 'ProfilePhoto/profile.png') : 'img/profile.png') }}" class="rounded-circle" width="40" height="40" alt="logo">
                                <div>
                                    <div class="fw-semibold circle-name">{{ $circle->circleName }}</div>
                                    <small class=" circle-name">{{ $circle->city->cityName ?? 'N/A' }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-semibold circle-name">₹ {{ number_format($circle->totalBusinessAmount ?? 0, 0) }}</div>
                                {{-- <small class="text-muted">👥 {{ $circle->members_count }}</small> --}}
                                <small class="text-muted circle-name">👥 <span class="circle-name"> {{ $circle->members_count }}</span></small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Members List (col-md-9) -->
            <div class="col-md-9">
                <div id="memberCardsContainer" class="row g-4">
                    {{-- Member cards will be dynamically loaded here --}}
                    {{-- Each card should be wrapped like below --}}
                    {{-- <div class="col-md-6"> @include('partials.member-card', ['member' => $member]) </div> --}}
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const circles = document.querySelectorAll('.circle-card');
            const container = document.getElementById('memberCardsContainer');
            const defaultCircleId = "{{ $authCircleId }}"; // Blade will render this as a string or empty

            // Fetch default circle members when the page loads
            if (defaultCircleId && defaultCircleId !== "null") {
                container.innerHTML = '<p class="text-center circle-name">Loading...</p>'; // Optional: show loading
                fetch(`/get-circle-members/${defaultCircleId}`)
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching members:', error);
                    });
            }

            circles.forEach(circle => {
                circle.addEventListener('click', function() {
                    // Remove 'active' class from all cards
                    circles.forEach(c => c.classList.remove('active'));

                    // Add 'active' class to the clicked card
                    this.classList.add('active');

                    const circleId = this.getAttribute('data-id');
                    container.innerHTML = '<p class="text-center circle-name">Loading...</p>'; // Optional: show loading
                    fetch(`/get-circle-members/${circleId}`)
                        .then(response => response.text())
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error fetching members:', error);
                        });
                });
            });
        });
    </script>



    <!-- Full CSS -->
@endsection
