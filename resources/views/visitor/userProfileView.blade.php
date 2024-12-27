<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->firstName ?? '-' }} {{ $member->lastName ?? '-' }}'s Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f3f2ef;
            font-family: 'Arial', sans-serif;
        }

        .profile-header {
            background: linear-gradient(5deg, #1d3268, #e76a35);
            color: white;
            position: relative;
            padding: 20px;
        }

        .profile-header .cover-photo {
            height: 200px;
            background: url("{{ asset('') ?? 'https://via.placeholder.com/' }}") repeat center center;
            background-size: cover;
            border-radius: 0 0 10px 10px;
        }

        .profile-header .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid white;
            position: absolute;
            bottom: -75px;
            left: 20px;
            background: #fff;
            object-fit: cover;
        }

        .profile-header .user-info {
            margin-top: 70px;
            padding-left: 180px;
            padding-right: 20px;
        }

        .profile-header h3 {
            font-weight: bold;
        }

        .profile-header p {
            font-size: 14px;
        }

        .btn-connect {
            background-color: #e76a35;
            color: white;
            border: none;
            font-weight: bold;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
        }

        .btn-connect:hover {
            background-color: #d45a2b;
        }

        .content-section {
            background: white;
            margin-top: 20px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .content-section h5 {
            font-weight: bold;
            color: #1d3268;
        }

        .content-section ul {
            list-style-type: none;
            padding: 0;
        }

        .content-section ul li {
            margin-bottom: 10px;
        }

        .content-section ul li .title {
            font-weight: bold;
        }

        .content-section ul li .value {
            color: #555;
        }

        .bio-section {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
        }

        .top-profile,
        .gains-profile {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
        }

        .top-profile h3,
        .gains-profile h3 {
            color: #1d3268;
        }

        .top-profile ul,
        .gains-profile ul {
            list-style-type: none;
            padding: 0;
        }

        .top-profile ul li,
        .gains-profile ul li {
            margin-bottom: 10px;
        }

        .top-profile ul li strong,
        .gains-profile ul li strong {
            color: #e76a35;
        }

        /* Add orange color to tabs when active */
        .nav-tabs .nav-link.active {
            background-color: #e76a35;
            color: white;
        }

        .nav-tabs .nav-link {
            color: #555;
        }

        .logged-in {
            font-size: 24px;
            color: green;
            animation: blink 1s infinite;
        }

        .logged-out {
            font-size: 24px;
            color: red;
            animation: blink 1s infinite;
        }
    </style>
</head>

<body>
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="cover-photo"></div>

        @php
            $profilePhoto = $visitor->profilePhoto ?? null;
        @endphp

        @if ($profilePhoto && file_exists(public_path('ProfilePhoto/' . $profilePhoto)))
            <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="Profile Picture" class="profile-picture">
        @else
            <img src="{{ asset('ProfilePhoto/profile.png') }}" alt="Default Profile" class="profile-picture">
        @endif

        <div class="user-info">
            <h3>{{ $visitor->firstName ?? '' }} {{ $visitor->lastName ?? '' }}</h3>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#myProfile" role="tab"
                    aria-controls="myProfile" aria-selected="true">My Profile</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="profileTabContent">
            <!-- My Profile Tab -->
            <div class="tab-pane fade show active" id="myProfile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="content-section">
                    <h5>My Profile</h5>
                    <ul>
                        <li><span class="title">Email:</span> <span class="value">{{ $visitor->email ?? '-' }}</span></li>
                        <li><span class="title">Mobile:</span> <span class="value">{{ $visitor->mobileNo ?? '-' }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
