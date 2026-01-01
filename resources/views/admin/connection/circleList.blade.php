@extends('layouts.master')
@section('content')

<style>
    /* Standardized styling for consistency */
    .form-select:focus {
        border-color: #e76a35;
        box-shadow: 0 0 0 0.25rem rgba(231, 106, 53, 0.25);
    }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- Header Section -->
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="bi bi-people-fill text-primary me-2" style="color: #e76a35 !important;"></i>
                            Circle Connections
                        </h4>
                        <p class="text-muted small mb-0">Browse circles and view their members</p>
                    </div>

                    <div class="w-100 w-md-50">
                        <select id="circleSelect"
                            class="form-select form-select-lg shadow-none border-secondary-subtle">
                            <option value="" disabled {{ !$authCircleId ? 'selected' : '' }}>Select a Circle</option>

                            @if($authCircle)
                            <option value="{{ $authCircle->id }}" selected>
                                My Circle - {{ $authCircle->circleName }} ({{ $authCircle->city->cityName ?? 'N/A' }})
                            </option>
                            @endif

                            @foreach($circles as $circle)
                            @if(!$authCircle || $circle->id != $authCircle->id)
                            <option value="{{ $circle->id }}">
                                {{ $circle->circleName }} ({{ $circle->city->cityName ?? 'N/A' }})
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div id="memberCardsContainer">
                <!-- Content loaded via AJAX -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="color: #e76a35 !important;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading members...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const circleSelect = document.getElementById('circleSelect');
        const container = document.getElementById('memberCardsContainer');

        function loadMembers(circleId) {
            if (!circleId) return;

            container.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status" style="color: #e76a35 !important;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading members...</p>
                </div>
            `;

            fetch(`/get-circle-members/${circleId}`)
                .then(response => response.text())
                .then(html => {
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching members:', error);
                    container.innerHTML = `
                        <div class="alert alert-danger text-center">
                            Failed to load members. Please try again.
                        </div>
                    `;
                });
        }

        // Initial load
        if (circleSelect.value) {
            loadMembers(circleSelect.value);
        } else {
             container.innerHTML = `
                <div class="alert alert-info text-center">
                    Please select a circle to view members.
                </div>
            `;
        }

        // Handle change
        circleSelect.addEventListener('change', function() {
            loadMembers(this.value);
        });
    });
</script>

@endsection
