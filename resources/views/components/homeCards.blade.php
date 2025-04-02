<style>
    /* Leaderboard style  */
    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
        border-top: 4px solid #e76a35;
        margin-bottom: 20px;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #1d3268;
    }

    .profile-title {
        font-size: 14px;
        font-weight: bold;
        color: #e76a35;
        margin-top: 10px;
    }

    .profile-name {
        font-size: 16px;
        font-weight: bold;
        color: #1d3268;
        margin-bottom: 5px;
    }

    .profile-info {
        font-size: 14px;
        color: #1d3268;
        margin: 5px 0;
    }

    .profile-buttons {
        margin-top: 15px;
    }

    .profile-buttons a {
        display: inline-block;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        margin: 5px;
    }

    .btn-view {
        background-color: #1d3268;
        color: white;
    }

    .btn-connect {
        background-color: #e76a35;
        color: white;
    }

    /* Stats Cards Styling */
    /* .stat-card {
        background: linear-gradient(to right, #f8f9fa, #e8eaf6);
        border-radius: 12px;
        padding: 10px;
        max-height: 200px;
        display: flex;
    }

    .stat-icon {
        font-size: 60px;
        color: rgba(108, 117, 125, 0.6);
    } */

    .stat-card {
        background: linear-gradient(to right, #f8f9fa, #e8eaf6);
        border-radius: 12px;
        padding: 10px;
        position: relative;
        /* Enables absolute positioning for the icon */
        overflow: hidden;
        /* Ensures content does not overflow */
    }

    .stat-icon {
        font-size: 60px;
        color: rgba(108, 117, 125, 0.6);
        position: absolute;
        bottom: 10px;
        /* Positions icon at the bottom */
        right: 10px;
        /* Positions icon at the right */
    }




    .text-gradient {
        color: #ab2626;
        font-size: 20px;
    }

    .content {
        margin-right: auto;
    }

    /* Responsive Grid Layout for Leaderboard */
    @media (max-width: 767px) {
        .profile-card {
            margin-bottom: 15px;
        }

        .stat-card {
            margin-bottom: 15px;
        }
    }

    .card-text {
        font-size: 14px;
    }

    .bottom-card {
        height: auto;
        align-self: center;
        margin-bottom: 10px;
    }
</style>

 <style>
        body {
            background-color: #f8f9fa;
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .section-header a {
            text-decoration: none;
            color: #000;
            font-weight: 500;
        }
        .event-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .event-card:hover {
            transform: scale(1.02);
        }
        .event-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
            border-radius: 10px 10px 0 0;
        }
        .event-details {
            padding: 15px;
        }
        .event-meta {
            font-size: 14px;
            color: #6c757d;
            display: flex;
            align-items: center;
        }
        .event-meta i {
            margin-right: 5px;
        }
        .badge-price {
            background-color: #f8d7da;
            color: #dc3545;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
        }
    </style>



<div class="container mt-4">
    <div class="row">
        <!-- Left Section (7 Columns) -->
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <!-- Cities Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="content p-3">
                                    <h2 class="fw-bold text-gradient">4</h2>
                                    <p class="text-uppercase text-muted fw-semibold">Cities</p>
                                </div>
                            </div>
                        </div>
                        <!-- Icon positioned at the bottom right, overlapping slightly -->
                        <i class="bi bi-buildings stat-icon position-absolute" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
                    </div>
                </div>

                <!-- Circles Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="content p-3">
                                    <h2 class="fw-bold text-gradient">{{ $circleCount }}</h2>
                                    <p class="text-uppercase text-muted fw-semibold">Circles</p>
                                </div>
                            </div>
                        </div>
                        <i class="bi bi-bullseye stat-icon" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
                    </div>
                </div>

                <!-- Members Card -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 p-2 stat-card position-relative overflow-hidden">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="content p-3">
                                    <h2 class="fw-bold text-gradient">{{ $membersCount }}</h2>
                                    <p class="text-uppercase text-muted fw-semibold">Members</p>
                                </div>
                            </div>
                        </div>
                        <i class="bi bi-people stat-icon" style="bottom: -30px; right: -10px; font-size: 5rem; opacity: 0.6;"></i>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="fw-bold text-center mb-3">Leaderboard</div>
                @if ($circlecalls)
                    <div class="col-md-4">
                        <div class="profile-card">
                            <img src="{{ asset('ProfilePhoto/' . ($circlecalls['member']->profilePhoto ?? 'profile.png')) }}" alt="Profile Photo" class="profile-img">
                            <p class="profile-title">Max Business Meets</p>
                            <h3 class="profile-name">{{ $circlecalls['member']->firstName }} {{ $circlecalls['member']->lastName }}</h3>
                            <p class="profile-info">Circle: <b>{{ $circlecalls['member']->circle->circleName }}</b></p>
                            <p class="profile-info">Meetings: <b>{{ $circlecalls['count'] }}</b></p>
                            <div class="profile-buttons">
                                <a href="#" class="btn-view">View Profile</a>
                                <a href="#" class="btn-connect">Connect</a>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($busGiver)
                    <div class="col-md-4">
                        <div class="profile-card">
                            <img src="{{ asset('ProfilePhoto/' . ($busGiver['member']->profilePhoto ?? 'profile.png')) }}" alt="Profile Photo" class="profile-img">
                            <p class="profile-title">Business Leader</p>
                            <h3 class="profile-name">{{ $busGiver['user']->firstName }} {{ $busGiver['user']->lastName }}</h3>
                            <p class="profile-info">Circle: <b>{{ $busGiver['circle']['circleName'] }}</b></p>
                            <p class="profile-info">Meetings: <b>{{ $busGiver['count'] }}</b></p>
                            <p class="profile-info">Amount: <b>{{ $busGiver['amount'] }}</b></p>
                            <div class="profile-buttons">
                                <a href="#" class="btn-view">View Profile</a>
                                <a href="#" class="btn-connect">Connect</a>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($refGiver)
                    <div class="col-md-4">
                        <div class="profile-card">
                            <img src="{{ asset('ProfilePhoto/' . ($refGiver['profilePhoto'] ?? 'profile.png')) }}" alt="Profile Photo" class="profile-img">
                            <p class="profile-title">Top Reference Giver</p>
                            <h3 class="profile-name">{{ $refGiver['user']->firstName ?? 'N/A' }} {{ $refGiver['user']->lastName ?? 'N/A' }}</h3>
                            <p class="profile-info">Circle: <b>{{ $refGiver['circle'] ?? 'N/A' }}</b></p>
                            <p class="profile-info">References: <b>{{ $refGiver['count'] ?? '0' }}</b></p>
                            <p class="profile-info"><b>{{ $refGiver['businessCategory'] ?? 'N/A' }}</b></p>
                            <div class="profile-buttons">
                                <a href="#" class="btn-view">View Profile</a>
                                <a href="#" class="btn-connect">Connect</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="container mt-4">
                <!-- Section Header -->
                <div class="section-header">
                    <h5>Upcoming Events</h5>
                    <a href="#">See All &gt;</a>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card event-card">
                            <img src="https://via.placeholder.com/300x180" class="event-img" alt="Event 1">
                            <div class="event-details">
                                <h6 class="mb-2">Business Excellence 2025 - Business Growth Workshop</h6>
                                <p class="event-meta"><i class="bi bi-geo-alt"></i> RPJ Hotel, Ahmedabad &bull; Pinnacle</p>
                                <p class="event-meta">18 Mar 2025 | 14:00 | 2 Hours</p>
                                <span class="badge badge-price">₹ 800</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card event-card">
                            <img src="https://via.placeholder.com/300x180" class="event-img" alt="Event 2">
                            <div class="event-details">
                                <h6 class="mb-2">Mumbai International Finance Expo</h6>
                                <p class="event-meta"><i class="bi bi-geo-alt"></i> RPJ Hotel, Ahmedabad &bull; Pinnacle</p>
                                <p class="event-meta">18 Mar 2025 | 14:00 | 2 Hours</p>
                                <span class="badge badge-price">₹ 800</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card event-card">
                            <img src="https://via.placeholder.com/300x180" class="event-img" alt="Event 3">
                            <div class="event-details">
                                <h6 class="mb-2">KIDS CARNIVAL AND EXPO 2025 - MUMBAI</h6>
                                <p class="event-meta"><i class="bi bi-geo-alt"></i> RPJ Hotel, Ahmedabad &bull; Pinnacle</p>
                                <p class="event-meta">18 Mar 2025 | 14:00 | 2 Hours</p>
                                <span class="badge badge-price">₹ 800</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Right Section (5 Columns) -->
        <div class="col-lg-4 col-md-12">
            <div class="row">
                @if ($categoryNames->isNotEmpty())
                    <div class="card shadow-sm p-4 text-center">
                        <h4 class="mb-4 fw-bold">Vacant Categories</h4>
                        <div class="row">
                            @foreach ($categoryNames as $categoryName)
                                <div class="col-md-6 mb-3">
                                    <div class="card bottom-card border rounded p-2 pt-2" width="100%">
                                        <h5 class="m-0 card-text fw-bold">{{ $categoryName }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($meeting == null)
                    <div class="col-lg-12 col-md-12">
                        <div class="card shadow-sm p-4 text-center">
                            <h4 class="mb-4 fw-bold">Upcoming Circle Meetings</h4>
                            <div class="alert alert-info" role="alert">
                                No upcoming circle meeting found
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 col-md-12">
                        <div class="card shadow-sm p-4">
                            <h4 class="mb-4 fw-bold" style="font-size: 18px;">&nbsp;Upcoming Circle Meetings
                                <i class="bi bi-people me-2"></i>{{ $meeting->circle->members->count() }}
                            </h4>
                            <div class="card shadow-sm p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">1.</span>
                                    <span class="fw-bold">{{ $meeting->date->format('j M Y') }} | {{ $meeting->meetingTime }}</span>
                                    <i class="bi bi-clipboard" onclick="copyMeetingLink()"></i>
                                    <button class="btn btn-outline-primary btn-sm" onclick="openInvitePage('{{ $signedUrl }}')">Invite</button>
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="bi bi-clock me-2"></i> 2 Hours
                                </div>
                                <div class="d-flex align-items-center mt-2">
                                    <i class="bi bi-geo-alt me-2"></i> {{ $meeting->circle->circleName }}, {{ $meeting->circle->city->cityName }}
                                </div>
                                <hr>
                                <div class="text-primary fw-semibold">
                                    Invited People - {{ $myInvites->count() }} <i class="bi bi-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="shareableMeetingLink" value="{{ URL::signedRoute('visitor.form', ['slug' => $meeting->cm_slug, 'meetingId' => $meeting->id, 'ref' => auth()->user()->member->id]) }}">
                @endif


                <script>
                    function copyMeetingLink() {
                        var copyText = document.getElementById("shareableMeetingLink").value;
                        navigator.clipboard.writeText(copyText).then(function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Link copied!',
                                text: 'The link has been copied to your clipboard.',
                                confirmButtonText: 'OK'
                            });
                        }, function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Could not copy the link. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        });
                    }

                    function openInvitePage(url) {
                        window.open(url, '_blank');
                    }
                </script>

            </div>
        </div>
    </div>
</div>
