@extends('layouts.master')

@section('title', 'UBN - My Connections')

@section('content')
<style>
    /* Shared Profile Card Styles */
    .profile-card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .header-image {
        width: 100%;
        height: 100px;
        object-fit: cover;
        background-color: #f1f5f9;
    }

    .profile-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -40px;
        background-color: #fff;
    }

    .member-name {
        font-size: 1.1rem;
        margin-top: 10px;
        margin-bottom: 5px;
        color: #1d3268;
        font-weight: 700;
    }

    .info-section {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin: 15px 0;
        padding: 0 10px;
    }

    .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 0.75rem;
        color: #64748b;
    }

    .icon-text svg {
        width: 20px;
        height: 20px;
        fill: #94a3b8;
        margin-bottom: 4px;
    }

    /* Company & Category Section */
    .company-category-section {
        display: flex;
        align-items: center;
        padding: 15px;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        background-color: #f8fafc;
        margin-top: auto;
        /* Push to bottom of content area */
    }

    .company-section,
    .category-section {
        flex: 1;
        text-align: center;
        overflow: hidden;
    }

    .divider {
        width: 1px;
        height: 40px;
        background-color: #cbd5e1;
        margin: 0 10px;
    }

    .logo-section {
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
    }

    .company-logo,
    .initials {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    .initials {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e2e8f0;
        color: #475569;
        font-weight: bold;
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

    /* Keywords */
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

    /* Bottom Actions */
    .bottom-actions {
        display: flex;
        border-top: 1px solid #e2e8f0;
    }

    .action-button {
        flex: 1;
        padding: 12px;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-button:hover {
        background-color: #f8fafc;
    }

    .action-button a {
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        width: 100%;
        justify-content: center;
    }

    .B-divider {
        width: 1px;
        background-color: #e2e8f0;
    }

    .btn-connect {
        border: none;
        background: transparent;
        padding: 0;
        display: flex;
        align-items: center;
        gap: 5px;
        justify-content: center;
        width: 100%;
    }

    /* Custom Tabs */
    .ubn-tab-nav {
        border-bottom: none;
        gap: 10px;
    }

    .ubn-tab-nav .nav-link {
        border: none;
        background-color: transparent;
        color: #64748b;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 50px;
        transition: all 0.2s;
    }

    .ubn-tab-nav .nav-link:hover {
        background-color: #f1f5f9;
        color: #1d3268;
    }

    .ubn-tab-nav .nav-link.active {
        background-color: #1d3268;
        color: #fff;
    }

    .ubn-tab-nav .nav-link.active .count {
        color: #fff;
        opacity: 0.8;
    }

    .ubn-tab-nav .count {
        margin-left: 5px;
        font-size: 0.85em;
    }
</style>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <!-- Header & Tabs -->
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-bold text-dark mb-1">
                            <i class="bi bi-people-fill text-primary me-2"></i> My Connections
                        </h4>
                        <p class="text-muted small mb-0">Manage your network and connection requests</p>
                    </div>

                    <ul class="nav nav-pills ubn-tab-nav" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-target="tab-my-connections" href="javascript:void(0);">
                                Connections <span class="count">({{ is_countable($connections ?? []) ?
                                    count($connections ?? []) : 0 }})</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-target="tab-sent-requests" href="javascript:void(0);">
                                Sent <span class="count">({{ is_countable($sentRequests ?? []) ? count($sentRequests ??
                                    []) : 0 }})</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-target="tab-received-requests" href="javascript:void(0);">
                                Received <span class="count">({{ is_countable($receivedRequests ?? []) ?
                                    count($receivedRequests ?? []) : 0 }})</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content Area -->
            <div id="tab-content-area">
                <!-- My Connections -->
                <div id="tab-my-connections" class="tab-section active-tab">
                    {{-- Note: myConnection component starts with <div class="row"> --}}
                        @include('components.connection.myConnection')
                    </div>

                    <!-- Sent Requests -->
                    <div id="tab-sent-requests" class="tab-section d-none">
                        <div class="row g-3">
                            {{-- Note: sentConnection component generates cols but no row wrapper --}}
                            @include('components.connection.sentConnection')
                        </div>
                    </div>

                    <!-- Received Requests -->
                    <div id="tab-received-requests" class="tab-section d-none">
                        {{-- Note: receivedConnection component starts with <div class="row g-3"> --}}
                            @include('components.connection.receivedConnection')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.ubn-tab-nav .nav-link');
            const tabSections = document.querySelectorAll('.tab-section');

            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Remove active class from all nav links
                    navLinks.forEach(l => l.classList.remove('active'));

                    // Add active to clicked link
                    this.classList.add('active');

                    // Hide all tab sections
                    tabSections.forEach(tab => tab.classList.add('d-none'));

                    // Show target tab
                    const targetId = this.getAttribute('data-target');
                    const targetSection = document.getElementById(targetId);
                    if(targetSection) {
                        targetSection.classList.remove('d-none');
                    }
                });
            });
        });
        </script>
        @endsection