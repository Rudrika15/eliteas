@extends('layouts.master')

@section('content')

    {{-- <style>
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
    </style> --}}


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
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
            color: #1d2951;
            transition: color 0.2s;
            text-decoration: none;
            padding: 10px;
            gap: 8px;
            /* Space between icon and text */
        }

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


    <div class="container mt-5">
        <h1 class="text-center card-title mb-4">Members of {{ $circle->circleName }} Circle</h1>
        <div class="row row-cols-3 g-4" id="searchResults">
            @forelse ($circle->members as $member)
                <div class="col">
                    <div class="fb-card shadow-sm h-100">
                        <div class="fb-card-img-wrapper">
                            <span class="fb-badge">Member</span>
                            <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                        </div>
                        <div class="fb-card-body">
                            <h5 class="fb-card-title">{{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}</h5>
                            <div class="fb-card-subtitle">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $circle->circleName ?? 'N/A' }}
                            </div>
                            @php $isConnected = in_array($member->connection_status, ['Accepted', 'Connected']); @endphp
                            <div class="fb-card-info">
                                <div><i class="bi bi-envelope-fill"></i> {{ $isConnected ? ($member->user->email ?? 'N/A') : '****' }}</div>
                                <div><i class="bi bi-telephone-fill"></i> {{ $isConnected ? ($member->user->contactNo ?? 'N/A') : '****' }}</div>
                            </div>
                            @if(!empty($member->companyName) || !empty($member->bCategory->categoryName))
                                <div class="fb-card-info">
                                    @if(!empty($member->companyName))
                                        <div><i class="bi bi-building"></i> {{ $member->companyName }}</div>
                                    @endif
                                    @if(!empty($member->bCategory->categoryName))
                                        <div><i class="bi bi-tag"></i> {{ $member->bCategory->categoryName }}</div>
                                    @endif
                                </div>
                            @endif
                            @php $keyWords = json_decode($member->keyWords ?? '[]', true); @endphp
                            @if (is_array($keyWords) && count($keyWords) > 0)
                                <div>
                                    @foreach ($keyWords as $keyWord)
                                        <span class="keyword-pill">{{ $keyWord }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mt-auto">
                                <a href="{{ route('foundPersonDetails', $member->id) }}" class="fb-btn fb-btn-primary d-block w-100 text-decoration-none">View Profile</a>
                                @if ($member->connection_status == 'Connected' || $member->connection_status == 'Accepted')
                                    <button type="button" class="fb-btn fb-btn-secondary fb-btn-disabled w-100 mt-2">
                                        <i class="bi bi-check-circle-fill me-2"></i> Connected
                                    </button>
                                @elseif ($member->connection_status == 'Not Connected' || $member->connection_status == 'Rejected')
                                    <form action="{{ route('connect') }}" class="connectForm d-inline-block w-100 mt-2" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $member->id }}" name="memberId">
                                        <button type="submit" class="fb-btn fb-btn-secondary w-100">
                                            <i class="bi bi-person-plus-fill me-2"></i> Connect
                                        </button>
                                    </form>
                                @elseif ($member->connection_status == 'Pending')
                                    <button type="button" class="fb-btn fb-btn-secondary fb-btn-disabled w-100 mt-2">
                                        <i class="bi bi-clock me-2"></i> Requested
                                    </button>
                                @endif
                                <div class="mt-2 text-center"><i class="bi bi-people-fill me-1 color-blue"></i> <strong class="color-blue">Inductions:</strong> <span class="fw-bold color-blue">{{ $member->inductionCount ?? '0' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No active members found in this circle.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            $(document).on('submit', '.connectForm', function(e) {
                e.preventDefault();
                var form = $(this);
                var actionUrl = form.attr('action');
                var formData = form.serialize();
                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'Success', text: response.message, confirmButtonText: 'Okay' })
                                .then(() => { location.reload(); });
                        } else {
                            Swal.fire({ icon: 'info', title: 'Info', text: response.message });
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Oops!', text: 'Something went wrong. Please try again.' });
                    }
                });
            });
        });
    </script>

@endsection
