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




{{-- <style>
    .leaderboard .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        /* spacing between cards */
    }

    .leaderboard .profile-card {
        width: 220px;
        height: 486px;
        /* slightly reduced to fit 3 in a row nicely */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        margin: 20px;
        /* changed from centered to spaced for flexbox */
        transition: all 0.3s ease;
    }

    .leaderboard .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .leaderboard .header-image {
        width: 100%;
        height: 60px;
        object-fit: cover;
    }

    .leaderboard .profile-img {
        /* width: 150px;
        height: 150px; */
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -50px;
    }

    .leaderboard h5 {
        margin-top: 10px;
        margin-bottom: 4px;
        font-weight: 700;
        color: #1d3268;
    }

    .leaderboard .position {
        color: #1d3268;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .leaderboard .info-section {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .leaderboard .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 13px;
        flex: 1;
    }

    .leaderboard .icon-text i {
        font-size: 22px;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .leaderboard .company-category-section {
        display: flex;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
    }

    .leaderboard .company-section,
    .leaderboard .category-section {
        flex: 1;
        min-width: 0;
        /* prevents overflow issues */
        text-align: center;
        word-wrap: break-word;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
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

    .leaderboard .B-divider {
        width: 1px;
        background-color: #dcdcdc;
        height: 60px;
    }


    .leaderboard .logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .leaderboard .logo-section img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e0e0e0;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
        margin: 6px 0;
        color: #1d2951;
        font-size: 16px;
        font-weight: bold;
    }

    .leaderboard .category-section .label {
        color: gray;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .leaderboard .keywords-container {
        text-align: center;
        margin: 15px 20px 10px;
    }

    .leaderboard .keyword-pill {
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

    .leaderboard .bottom-actions {
        display: flex;
        justify-content: space-between;
        /* Move buttons to corners */
        align-items: center;
        border-top: 1px solid #e6e6e6;
        padding: 10px 0;
        text-align: center;
        width: 100%;

    }

    .leaderboard .action-button {
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

    .leaderboard .action-button.connected {
        color: #e76a35 !important;
        /* Orange color for connected users */
    }


    .leaderboard .action-button i {
        font-size: 16px;
        /* Adjust icon size if needed */
    }

    .leaderboard .divider {
        width: 1px;
        background-color: #e6e6e6;
        height: 100px;
    }


    .leaderboard .bottom-actions div:hover {
        color: #e76a35;
    }

    .leaderboard .bottom-divider {
        width: 1px;
        background-color: #e0e0e0;
        height: 25px;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 1200px) {
        .leaderboard .profile-card {
            width: 280px;
        }
    }

    @media screen and (max-width: 1500px) {
        .leaderboard .profile-card {
            width: 200px;
        }
    }

    @media screen and (max-width: 992px) {
        .leaderboard .profile-card {
            width: 200px;
        }
    }

    @media screen and (max-width: 768px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 10px;
        }
    }

    @media screen and (max-width: 576px) {
        .leaderboard .profile-card {
            width: 100%;
        }
    }

    @media screen and (max-width: 320px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 9px;
        }
    }


    .leaderboard .initials {
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
</style> --}}


<style>
    .leaderboard .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        /* spacing between cards */
    }

    .leaderboard .profile-card {
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

    .leaderboard .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .leaderboard .header-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .leaderboard .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -50px;
    }

    .leaderboard h5 {
        margin-top: 10px;
        margin-bottom: 4px;
        font-weight: 700;
        color: #1d3268;
    }

    .leaderboard .position {
        color: #1d3268;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .leaderboard .info-section {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .leaderboard .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 13px;
        flex: 1;
    }

    .leaderboard .icon-text i {
        font-size: 22px;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .leaderboard .company-category-section {
        display: flex;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
    }

    .leaderboard .company-section,
    .leaderboard .category-section {
        flex: 1;
        min-width: 0;
        /* prevents overflow issues */
        text-align: center;
        word-wrap: break-word;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
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

    .leaderboard .B-divider {
        width: 1px;
        background-color: #dcdcdc;
        height: 60px;
    }


    .leaderboard .logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .leaderboard .logo-section img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e0e0e0;
    }

    .leaderboard .company-section h2,
    .leaderboard .category-section h3 {
        margin: 6px 0;
        color: #1d2951;
        font-size: 16px;
        font-weight: bold;
    }

    .leaderboard .category-section .label {
        color: gray;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .leaderboard .keywords-container {
        text-align: center;
        margin: 15px 20px 10px;
    }

    .leaderboard .keyword-pill {
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

    .leaderboard .bottom-actions {
        display: flex;
        justify-content: space-between;
        /* Move buttons to corners */
        align-items: center;
        border-top: 1px solid #e6e6e6;
        padding: 10px 0;
        text-align: center;
        width: 100%;

    }

    .leaderboard .action-button {
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

    .leaderboard .action-button.connected {
        color: #e76a35 !important;
        /* Orange color for connected users */
    }


    .leaderboard .action-button i {
        font-size: 16px;
        /* Adjust icon size if needed */
    }

    .leaderboard .divider {
        width: 1px;
        background-color: #e6e6e6;
        height: 100px;
    }


    .leaderboard .bottom-actions div:hover {
        color: #e76a35;
    }

    .leaderboard .bottom-divider {
        width: 1px;
        background-color: #e0e0e0;
        height: 25px;
    }

    /* Responsive adjustments */

    @media screen and (max-width: 2560px) {
        .leaderboard .profile-card {
            width: 230px !important;
        }

        .leaderboard .info-section .icon-text {
            font-size: 8px;
        }

        .leaderboard .company-category-section {
            padding: 0%;
            gap: 0%;
        }

        .leaderboard .company-section,
        .leaderboard .category-section {
            flex: 1;
            min-width: 0;
            /* prevents overflow issues */
            text-align: center;
            word-wrap: break-word;
        }

        .leaderboard .company-section h2,
        .leaderboard .category-section h3 {
            margin: 0px 0;
            color: #1d2951;
            font-size: 10px;
            font-weight: bold;
        }

        .leaderboard .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .leaderboard .header-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
        }

        .leaderboard .bottom-actions {
            font-size: 8px;
        }

        .leaderboard .btn-connect {
            font-size: 8px;
        }

        .leaderboard .position {
            font-size: 8px;
        }

        .leaderboard .member-name {
            font-size: 12px;
        }
    }


    @media screen and (max-width: 1024px) {
        .leaderboard .profile-card {
            width: 195px !important;
        }

        .leaderboard .info-section .icon-text {
            font-size: 12px;
        }

        .leaderboard .company-category-section {
            padding: 0%;
            gap: 0%;
        }

        .leaderboard .company-section,
        .leaderboard .category-section {
            flex: 1;
            min-width: 0;
            /* prevents overflow issues */
            text-align: center;
            word-wrap: break-word;
        }

        .leaderboard .company-section h2,
        .leaderboard .category-section h3 {
            margin: 0px 0;
            color: #1d2951;
            font-size: 12px;
            font-weight: bold;
        }

        .leaderboard .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e0e0e0;
        }

        .leaderboard .header-image {
            width: 100%;
            height: 60px;
            object-fit: cover;
        }

        .leaderboard .bottom-actions {
            font-size: 12px;
        }

        .leaderboard .btn-connect {
            font-size: 12px;
        }

        .leaderboard .position {
            font-size: 12px;
        }

        .leaderboard .member-name {
            font-size: 15px;
        }


    }

    @media screen and (max-width: 992px) {
        .leaderboard .profile-card {
            width: 210px;
        }


    }

    @media screen and (max-width: 1500px) {
        .leaderboard .profile-card {
            width: 200px;
        }


    }

    @media screen and (max-width: 768px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 10px;
        }
    }

    @media screen and (max-width: 576px) {
        .leaderboard .profile-card {
            width: 100%;
        }
    }

    @media screen and (max-width: 320px) {
        .leaderboard .profile-card {
            width: 220px;
        }

        .leaderboard .icon-text {
            font-size: 9px;
        }
    }


    .leaderboard .initials {
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

    .leaderboard .heading {
        color: #1d3268;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .leaderboard .col-lg-4 {
        width: 31.33333333% !important;
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

            <h1 class="text-center card-title mb-4">Leaderboard</h1>
            <div class="leaderboard">

                {{-- <div class="">
                    <div class="row justify-content-center">
                        <div class="col-12 col-sm-8 col-lg-6">
                            <div class="profile-card shadow-sm rounded border-0">
                                <span class="text-center card-title mt-0">Top IBM Member</span>
                                <img src="https://picsum.photos/600/120" class="header-image mt-2" alt="Header Image">
                                <div class="text-center p-3">
                                    <img src="https://randomuser.me/api/portraits/men/76.jpg" class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">
                                    <h5 class="member-name" style="color: #e76a35; font-weight: bold;">John Doshi</h5>
                                    <p class="position">Vice President at UBN</p>
                                    <div class="info-section">
                                        <div class="icon-text">
                                            <i class="bi bi-people-fill" style="color: #787c80;"></i>
                                            <span>Pinnacle</span>
                                        </div>
                                        <div class="icon-text">
                                            <i class="bi bi-calendar-event-fill" style="color: #787c80;"></i>
                                            <span>Meetings: 51</span>
                                        </div>
                                    </div>
                                    <div class="company-category-section">
                                        <div class="company-section">
                                            <h2 title="CubX Technologies">CubX Technologies</h2>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="category-section">
                                            <div class="label">Category</div>
                                            <h3>Mechanical Workshop</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-actions">
                                    <div id="viewProfile" class="action-button left-action">
                                        <a href="#">
                                            <i class="bi bi-person-lines-fill me-2" style="color: #1d3268;"></i>
                                            <span style="color: #1d3268;">View Profile</span>
                                        </a>
                                    </div>
                                    <div class="B-divider"></div>
                                    <div id="connectButton" class="action-button right-action btn w-100 d-flex justify-content-center align-items-center">
                                        <span class="fw-bold" style="color: #e76a35;">
                                            <i class="bi bi-person-plus-fill ms-2" style="color: #e76a35;"></i>
                                            Connect
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row g-4">
                    @if ($circlecalls)
                        <div class="col-sm-6 col-lg-4">
                            <div class="profile-card shadow-sm rounded border-0">
                                <span class="heading">Top IBM Member</span>
                                <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                                <div class="text-center p-3">
                                    <img src="{{ asset('ProfilePhoto/' . ($circlecalls['member']->profilePhoto ?? 'profile.png')) }}" class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">
                                    <h5 class="member-name" style="color: #e76a35; font-weight: bold;">
                                        {{ $circlecalls['member']->firstName }} {{ $circlecalls['member']->lastName }}
                                    </h5>
                                    <p class="position">Max Business Meets</p>

                                    <div class="info-section">
                                        <div class="icon-text">
                                            <i class="bi bi-people-fill" style="color: #787c80;"></i>
                                            <span>Pinnacle</span>
                                        </div>
                                        <div class="icon-text">
                                            <i class="bi bi-calendar-event-fill" style="color: #787c80;"></i>
                                            <span>Meetings: 51</span>
                                        </div>
                                    </div>

                                    <div class="company-category-section">
                                        <div class="company-section">
                                            <h2 title="Static Company">Static Company</h2>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="category-section">
                                            <div class="label">Category</div>
                                            <h3>Static Category</h3>
                                        </div>
                                    </div>
                                    <div class="bottom-actions">
                                        <div id="viewProfile" class="action-button left-action">
                                            <a href="#"><i class="bi bi-person-lines-fill" style="color: #1d3268;"></i><span style="color: #1d3268;"> View Profile</span></a>
                                        </div>
                                        <div class="B-divider"></div>
                                        <div class="action-button right-action">
                                            <a style="color: #1d3268;" href="#"><i class="bi bi-person-plus-fill" style="color: #e76a35;"></i> Connect</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($busGiver)
                        <div class=" col-sm-6 col-lg-4">
                            <div class="profile-card shadow-sm rounded border-0">
                                <span class="heading">Top Business Leader</span>
                                <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                                <div class="text-center p-3">
                                    <img src="{{ asset('ProfilePhoto/' . ($busGiver['member']->profilePhoto ?? 'profile.png')) }}" class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">
                                    <h5 class="member-name" style="color: #e76a35; font-weight: bold;">
                                        {{ $busGiver['user']->firstName }} {{ $busGiver['user']->lastName }}
                                    </h5>
                                    <p class="position">Business Leader</p>

                                    <div class="info-section">
                                        <div class="icon-text">
                                            <i class="bi bi-people-fill" style="color: #787c80;"></i>
                                            <span>Pinnacle</span>
                                        </div>
                                        <div class="icon-text">
                                            <i class="bi bi-calendar-event-fill" style="color: #787c80;"></i>
                                            <span>Meetings: 51</span>
                                        </div>
                                    </div>

                                    <div class="company-category-section">
                                        <div class="company-section">
                                            <h2 title="Static Company">Static Company</h2>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="category-section">
                                            <div class="label">Category</div>
                                            <h3>Static Category</h3>
                                        </div>
                                    </div>
                                    <div class="bottom-actions">
                                        <div id="viewProfile" class="action-button left-action">
                                            <a href="#"><i class="bi bi-person-lines-fill" style="color: #1d3268;"></i><span style="color: #1d3268;"> View Profile</span></a>
                                        </div>
                                        <div class="B-divider"></div>
                                        <div class="action-button right-action">
                                            <a style="color: #1d3268;" href="#"><i class="bi bi-person-plus-fill" style="color: #e76a35;"></i> Connect</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($refGiver)
                        <div class=" col-sm-6 col-lg-4">
                            <div class="profile-card shadow-sm rounded border-0">
                                <span class="heading">Top Reference Giver</span>
                                <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
                                <div class="text-center p-3">
                                    <img src="{{ asset('ProfilePhoto/' . ($refGiver['profilePhoto'] ?? 'profile.png')) }}" class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">
                                    <h5 class="member-name" style="color: #e76a35; font-weight: bold;">
                                        {{ $refGiver['user']->firstName ?? 'N/A' }} {{ $refGiver['user']->lastName ?? 'N/A' }}
                                    </h5>
                                    <p class="position">Top Reference Giver</p>

                                    <div class="info-section">
                                        <div class="icon-text">
                                            <i class="bi bi-people-fill" style="color: #787c80;"></i>
                                            <span>Pinnacle</span>
                                        </div>
                                        <div class="icon-text">
                                            <i class="bi bi-calendar-event-fill" style="color: #787c80;"></i>
                                            <span>Meetings: 51</span>
                                        </div>
                                    </div>


                                    <div class="company-category-section">
                                        <div class="company-section">
                                            <h2 title="Static Company">Static Company</h2>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="category-section">
                                            <div class="label">Category</div>
                                            <h3>Static Category</h3>
                                        </div>
                                    </div>
                                    <div class="bottom-actions">
                                        <div id="viewProfile" class="action-button left-action">
                                            <a href="#"><i class="bi bi-person-lines-fill" style="color: #1d3268;"></i><span style="color: #1d3268;"> View Profile</span></a>
                                        </div>
                                        <div class="B-divider"></div>
                                        <div class="action-button right-action">
                                            <a style="color: #1d3268;" href="#"><i class="bi bi-person-plus-fill" style="color: #e76a35;"></i> Connect</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

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
