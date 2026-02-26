@extends('layouts.master')

@section('content')


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


        .btn-connect {
            border: none !important;
            outline: none !important;
        }
    </style>


    <div class="container mt-5">
        <div class="card">
            <div class="p-3 d-flex justify-content-between">
                <h1 class="card-title mb-0 p-0">Members of {{ $category->categoryName }} Category</h1>
                <a href="{{ route('connection.categoryList') }}" class="btn btn-bg-orange btn-sm mb-0 pb-0">BACK</a>
            </div>
        </div>

        <div class="row g-4" id="searchResults">
            @forelse ($members as $member)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="profile-card shadow-sm rounded border-0">
                        <!-- Header Image -->
                        {{-- <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image"> --}}
                        <img src="{{ asset('img/header_img.jpeg') }}" class="header-image" alt="Header Image">

                        <div class="text-center p-3">
                            <!-- Profile Image -->
                            <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ? (file_exists(public_path($member->profilePhoto)) ? $member->profilePhoto : 'ProfilePhoto/profile.png') : 'img/profile.png')) }}" class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">

                            <!-- Member Name -->
                            <h5 class="member-name" style="color: #e76a35; font-weight: bold;">
                                {{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}
                            </h5>


                            <!-- Role/Position -->
                            <p class="position">{{ $member->users->roles ?? 'Position' }}</p>

                            <!-- Info Section -->
                            <div class="info-section">
                                @php
                                    $isConnected = in_array($member->connection_status, ['Accepted', 'Connected']);
                                @endphp

                                <div class="icon-text" title="{{ $isConnected ? $member->user->email ?? 'N/A' : '****' }}">
                                    <i class="bi bi-envelope-fill" style="color: #787c80;"></i>
                                    <span>{{ $isConnected ? Str::limit($member->user->email ?? 'N/A', 15) : '****' }}</span>
                                </div>
                                <div class="icon-text" title="{{ $isConnected ? $member->user->contactNo ?? 'N/A' : '****' }}">
                                    <i class="bi bi-telephone-fill" style="color: #787c80;"></i>
                                    <span>{{ $isConnected ? Str::limit($member->user->contactNo ?? 'N/A', 10) : '****' }}</span>
                                </div>

                                <div class="icon-text">
                                    <i class="bi bi-people-fill" style="color: #787c80;"></i>
                                    <span>{{ $member->circle->circleName ?? 'N/A' }}</span>
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
                            <div class="keywords-container row">
                                @php
                                    $keyWords = json_decode($member->keyWords ?? '[]', true);
                                @endphp

                                @if (is_array($keyWords) && count($keyWords) > 0)
                                    @foreach ($keyWords as $keyWord)
                                        <span class="keyword-pill col">{{ $keyWord }}</span>
                                    @endforeach
                                @else
                                    {{-- <span class="keyword-pill"></span> --}}
                                @endif
                            </div>
                        </div>

                        <div class="mt-2 text-center fw-bold pb-2" style="color: #1d3268;">
                            Inductions - {{ $member->sponsored_count ?? $member->sponsored->count() }}
                        </div>
                        <!-- Bottom Actions -->
                        <div class="bottom-actions">
                            <!-- View Profile Button -->
                            <div id="viewProfile" class="action-button left-action">
                                <a href="{{ route('foundPersonDetails', $member->id) }}">
                                    <i class="bi bi-person-lines-fill" style="color: #1d3268;"></i><span style="color: #1d3268;">View Profile</span>
                                </a>
                            </div>

                            <div class="B-divider"></div>

                            <!-- Connection Status Logic -->
                            <div id="connectButton" class="action-button right-action btn w-100">
                                @if ($member->circleId == $authCircleId)
                                    <!-- Display "Connected" if both users are in the same circle -->
                                    <button type="button" class="btn btn-connect fw-bold shadow-none" style="color: #e76a35;">
                                        Connected &nbsp;<i class="bi bi-check-circle-fill" style="color: #e76a35;"></i>
                                    </button>
                                @elseif ($member->connection_status == 'Not Connected')
                                    <!-- Display "Connect" button if no connection exists -->
                                    <form action="{{ route('connect') }}" id="connectForm" method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" value="{{ $member->id }}" name="memberId" id="memberId">
                                        <button type="submit" class="btn btn-connect shadow-none fw-bold" id="connectBtn" style="color: #1d3268;">
                                            Connect &nbsp;<i class="bi bi-person-plus-fill fw-bold" style="color: #1d3268;"></i>
                                        </button>
                                    </form>
                                @elseif ($member->connection_status == 'Accepted')
                                    <button id="messageButton" class="btn btn-connect ms-2">
                                        Message
                                    </button>
                                @elseif ($member->connection_status == 'Pending')
                                    <button type="button" class="btn btn-connect fw-bold shadow-none" style="color: #e76a35;">
                                        Requested &nbsp;<i class="bi bi-clock" style="color: #e76a35;"></i>
                                    </button>
                                @elseif ($member->connection_status == 'Rejected')
                                    <!-- Display "Connect" button again after rejection -->
                                    <form action="{{ route('connect') }}" id="connectForm" method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" value="{{ $member->id }}" name="memberId" id="memberId">
                                        <button type="submit" class="btn btn-connect shadow-none fw-bold" id="connectBtn" style="color: #1d3268;">
                                            Connect &nbsp;<i class="bi bi-person-plus-fill  fw-bold" style="color: #1d3268;"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
            @empty
                <p class="text-center">No active members found in this category.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#connectForm').on('submit', function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                var form = $(this);
                var actionUrl = form.attr('action');
                var formData = form.serialize(); // Serialize form data

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            // Show SweetAlert success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'Okay'
                            }).then(() => {
                                // Refresh the page after the user clicks "Okay"
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        // Handle any error here (e.g., show an error message)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                });
            });
        });
    </script>

@endsection
