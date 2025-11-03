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
            <!-- Left: City List -->
            <div class="col-md-3">
                <div class="bg-light rounded p-3 mb-3">
                    <h6 class="fw-semibold text-muted mb-3">All Cities ({{ $cities->count() }})</h6>
                    <div class="city-list">
                        @foreach ($cities as $index => $city)
                            <div class="city-card d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2" data-id="{{ $city->id }}" style="cursor: pointer;">
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
                                    <img src="{{ asset($member->profilePicture ?? 'img/logo2.jpg') }}" class="rounded-circle mb-2" width="60" height="60" alt="Profile">
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
@endsection
