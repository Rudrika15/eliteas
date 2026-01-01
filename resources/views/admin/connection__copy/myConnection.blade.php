@extends('layouts.master')

@section('title', 'UBN - My Connections')

@section('content')
    <style>
        .page-header {
            padding: 1rem 2rem;
            background-color: #fff;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .tab-count {
            color: #e76a35;
            font-weight: 500;
        }

        .connection-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: 0.3s;
            margin-bottom: 2rem;
        }

        .connection-card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header-image {
            width: 100%;
            height: 90px;
            object-fit: cover;
        }

        .card-body {
            text-align: center;
            padding: 1rem;
        }

        .profile-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid white;
            margin-top: -35px;
        }

        .name {
            font-weight: bold;
            font-size: 16px;
            color: #1d3268;
            margin-top: 0.5rem;
        }

        .position {
            font-size: 14px;
            color: #6c757d;
        }

        .connected {
            color: #e76a35;
            font-weight: 500;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #6c757d;
            padding: 0.25rem 1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #1d3268;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
            padding: 0 1rem 1rem;
        }

        .btn-orange {
            background-color: #e76a35;
            color: white;
            font-size: 13px;
            border: none;
            border-radius: 10px;
            padding: 5px 10px;
        }

        .btn-orange:hover {
            background-color: #cf5f2f;
        }

        .ubn-tab-nav {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 0;
            gap: 30px;
        }

        .ubn-tab-nav .nav-link {
            font-size: 16px;
            font-weight: 600;
            color: #2f3a59;
            border: none;
            background-color: transparent;
            padding: 12px 0;
            position: relative;
        }

        .ubn-tab-nav .nav-link.active {
            color: #e76a35;
            font-weight: 700;
        }

        .ubn-tab-nav .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #e76a35;
            border-radius: 2px;
        }

        .ubn-tab-nav .nav-link:hover {
            color: #e76a35;
            background-color: transparent;
        }

        .ubn-tab-nav .count {
            color: #e76a35;
            font-weight: 500;
        }

        .tab-section {
            display: none;
        }

        .tab-section:not(.d-none) {
            display: block;
        }
    </style>

    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            /* spacing between cards */
        }

        .profile-card {
            width: 400px;
            /* slightly reduced to fit 3 in a row nicely */
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            margin: 20px;
            /* changed from centered to spaced for flexbox */
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
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: -50px;
        }

        h5 {
            margin-top: 10px;
            margin-bottom: 4px;
            font-weight: 700;
            color: #1d3268;
        }

        .position {
            color: #1d3268;
            font-size: 14px;
            /* font-weight: bold; */
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
            flex: 1;
        }

        .icon-text i {
            font-size: 22px;
            color: #e76a35;
            margin-bottom: 5px;
        }

        .company-category-section {
            display: flex;
            align-items: center;
            padding: 20px;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            gap: 20px;
        }

        .company-section,
        .category-section {
            flex: 1;
            min-width: 0;
            /* prevents overflow issues */
            text-align: center;
            word-wrap: break-word;
        }

        .company-section h2,
        .category-section h3 {
            white-space: normal;
            /* Allows text to wrap */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Limits to 2 lines */
            -webkit-box-orient: vertical;
            word-wrap: break-word;
            line-height: 1.4;
            /* Adjust for better readability */
            max-width: 100%;
        }

        .B-divider {
            width: 1px;
            background-color: #dcdcdc;
            height: 60px;
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
            font-weight: bold;
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
            justify-content: space-between;
            /* Move buttons to corners */
            align-items: center;
            border-top: 1px solid #e6e6e6;
            padding: 10px 0;
            text-align: center;
            width: 100%;


        }

        .action-button {
            /* flex: 1; */
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            color: #1d2951;
            transition: color 0.2s;
            text-decoration: none;
            padding: 10px;
            gap: 8px;
            margin-right: 10px;
            margin-left: 10px;
            /* Space between icon and text */
        }

        .right-action {
            flex: 1;
            /* display: flex; */
            align-items: center;
            font-weight: 600;
            color: #1d2951;
            transition: color 0.2s;
            text-decoration: none;
            padding: 10px;
            gap: 28px;
            margin: 0%;
        }

        /* .reject {
                                                margin-left: 20px;
                                            } */
        /*
                                            .accept {
                                                margin-right: 15px;
                                            } */

        .action-button.connected {
            color: #e76a35 !important;
            /* Orange color for connected users */
        }


        .action-button i {
            font-size: 16px;
            /* Adjust icon size if needed */
        }

        .divider {
            width: 1px;
            background-color: #e6e6e6;
            height: 100px;
        }


        .bottom-actions div:hover {
            color: #e76a35;
        }

        .bottom-divider {
            width: 1px;
            background-color: #e0e0e0;
            height: 25px;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 1200px) {
            .profile-card {
                width: 280px;
            }
        }

        @media screen and (max-width: 1500px) {
            .profile-card {
                width: 280px;
            }
        }

        @media screen and (max-width: 992px) {
            .profile-card {
                width: 200px;
            }
        }

        @media screen and (max-width: 768px) {
            .profile-card {
                width: 220px;
            }

            .icon-text {
                font-size: 10px;
            }
        }

        @media screen and (max-width: 576px) {
            .profile-card {
                width: 100%;
            }
        }

        @media screen and (max-width: 320px) {
            .profile-card {
                width: 220px;
            }

            .icon-text {
                font-size: 9px;
            }
        }


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
    </style>


    <style>
        body {
            background-color: #f8f9fa;
        }

        .circle-logo-sm {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .member-card {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .member-card-header {
            background-color: #f1f3f5;
            position: relative;
            height: 70px;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid #fff;
            background-color: #fff;
            /* position: absolute;
                                                                                                                                                                                                                                                                top: -40px;
                                                                                                                                                                                                                                                                left: 50%;
                                                                                                                                                                                                                                                                transform: translateX(-50%); */
            object-fit: cover;
        }

        .member-card-body {
            padding: 1.5rem 1rem 1rem;
        }

        .member-card-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid #e9ecef;
        }

        .tags span {
            background: #eef1f7;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 20px;
            margin: 2px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .profile-img {
                top: -30px;
                width: 60px;
                height: 60px;
            }
        }

        .circle-card.active {
            border: 2px solid #4F46E5;
            background-color: #EEF2FF;
            transition: 0.2s ease-in-out;
        }
    </style>

    <!-- Tabs -->
    <ul class="nav nav-tabs ubn-tab-nav justify-content-start mb-4 px-2" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" data-target="tab-my-connections" href="javascript:void(0);">
                My Connection <span class="count">({{ is_countable($connections ?? []) ? count($connections ?? []) : 0 }})</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-target="tab-sent-requests" href="javascript:void(0);">
                Sent Connection Request <span class="count">({{ is_countable($sentRequests ?? []) ? count($sentRequests ?? []) : 0 }})</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" data-target="tab-received-requests" href="javascript:void(0);">
                Received Connection Request <span class="count">({{ is_countable($receivedRequests ?? []) ? count($receivedRequests ?? []) : 0 }})</span>
            </a>
        </li>
    </ul>


    <div id="tab-content-area">
        <!-- My Connections -->
        <div id="tab-my-connections" class="tab-section active-tab">
            <ul>
                {{-- @forelse ($connections ?? [] as $member)
                    <li>{{ $connection->connectedUser->firstName ?? 'N/A' }} {{ $connection->connectedUser->lastName ?? '' }}</li>
                @empty
                    <li>No connections found.</li>
                @endforelse --}}
                {{-- {{ $connections }} --}}
                @include('components.connection.myConnection')

            </ul>
        </div>

        <!-- Sent Requests -->
        <div id="tab-sent-requests" class="tab-section d-none">
            <ul>
                {{-- @forelse ($sentRequests ?? [] as $request)
                    <li>{{ $request->receiver->firstName ?? 'N/A' }} {{ $request->receiver->lastName ?? '' }}</li>
                @empty
                    <li>No sent requests.</li>
                @endforelse --}}
                {{-- {{ $sentRequests }} --}}

                @include('components.connection.sentConnection')

            </ul>
        </div>

        <!-- Received Requests -->
        <div id="tab-received-requests" class="tab-section d-none">
            <ul>
                {{-- @forelse ($receivedRequests ?? [] as $request)
                    <li>{{ $request->user->firstName ?? 'N/A' }} {{ $request->user->lastName ?? '' }}</li>
                @empty
                    <li>No received requests.</li>
                @endforelse --}}

                @include('components.connection.receivedConnection')


            </ul>
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
                    document.getElementById(targetId).classList.remove('d-none');
                });
            });
        });
    </script>




@endsection
