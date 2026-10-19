<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>{{ $member->firstName ?? $user->firstName ?? 'Member' }} {{ $member->lastName ?? $user->lastName ?? '' }} - Public Profile | UBN Community</title>
    
    <!-- Meta tags for social sharing -->
    <meta property="og:title" content="{{ $member->firstName ?? $user->firstName ?? 'Member' }} {{ $member->lastName ?? $user->lastName ?? '' }} - Public Profile">
    <meta property="og:description" content="{{ $member->classification ?? $member->companyName ?? 'Professional Member at UBN Community' }}">
    <meta property="og:image" content="{{ !empty($member->profilePhoto) ? asset('ProfilePhoto/' . $member->profilePhoto) : asset('img/faviconUbn.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link href="{{ asset('img/faviconUbn.png') }}" rel="icon" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        :root {
            --brand-navy: #1d2856;
            --brand-navy-dark: #121a3b;
            --brand-orange: #e76a35;
            --brand-orange-hover: #d45a2b;
            --bg-light: #f4f6f9;
            --card-bg: #ffffff;
            --border-color: #e2e8f0;
            --text-dark: #2d3748;
            --text-muted: #718096;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Brand Header */
        .site-public-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            backdrop-filter: blur(8px);
        }

        .brand-logo-img {
            height: 38px;
            width: auto;
            object-fit: contain;
            transition: height 0.2s ease;
        }

        .brand-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--brand-navy);
            letter-spacing: -0.4px;
            white-space: nowrap;
        }

        /* Profile Cards */
        .profile-card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 3px 16px rgba(0,0,0,0.04);
            margin-bottom: 20px;
            overflow: hidden;
            transition: box-shadow 0.2s ease;
        }

        .profile-card-body {
            padding: 24px;
        }

        /* Hero Banner & Avatar */
        .profile-cover-banner {
            height: 220px;
            background: linear-gradient(135deg, #1d2856 0%, #2b3d80 50%, #e76a35 100%);
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .profile-avatar-wrapper {
            position: absolute;
            left: 28px;
            bottom: -65px;
            width: 136px;
            height: 136px;
            border-radius: 50%;
            border: 4px solid #ffffff;
            background-color: #ffffff;
            box-shadow: 0 8px 24px rgba(0,0,0,0.14);
            overflow: hidden;
            z-index: 2;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-header-body {
            padding: 78px 28px 26px 28px;
        }

        .profile-user-name {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--brand-navy);
            line-height: 1.25;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .profile-user-headline {
            font-size: 0.98rem;
            color: #4a5568;
            font-weight: 500;
            margin-top: 6px;
            line-height: 1.5;
            word-break: break-word;
        }

        .profile-user-location {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin-top: 8px;
            word-break: break-word;
        }

        /* Company & Circle Badges */
        .company-badges-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: flex-end;
        }

        .company-badge-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 7px 14px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 10px;
            max-width: 100%;
            word-break: break-word;
        }

        .company-badge-logo {
            width: 34px;
            height: 34px;
            object-fit: contain;
            border-radius: 6px;
            flex-shrink: 0;
            background: #fff;
            padding: 2px;
        }

        /* Buttons */
        .btn-brand-primary {
            background-color: var(--brand-navy);
            color: #ffffff;
            font-weight: 600;
            border-radius: 25px;
            padding: 9px 22px;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-brand-primary:hover, .btn-brand-primary:focus {
            background-color: var(--brand-navy-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-brand-accent {
            background-color: var(--brand-orange);
            color: #ffffff;
            font-weight: 600;
            border-radius: 25px;
            padding: 9px 22px;
            border: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-brand-accent:hover, .btn-brand-accent:focus {
            background-color: var(--brand-orange-hover);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-brand-outline {
            background-color: transparent;
            color: var(--brand-navy);
            font-weight: 600;
            border-radius: 25px;
            padding: 8px 20px;
            border: 2px solid var(--brand-navy);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .btn-brand-outline:hover, .btn-brand-outline:focus {
            background-color: var(--brand-navy);
            color: #ffffff;
        }

        .btn-brand-outline-secondary {
            background-color: transparent;
            color: #4a5568;
            font-weight: 600;
            border-radius: 25px;
            padding: 8px 18px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-brand-outline-secondary:hover {
            background-color: #f1f5f9;
            color: var(--brand-navy);
        }

        .section-card-heading {
            font-size: 1.12rem;
            font-weight: 700;
            color: var(--brand-navy);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Chips */
        .skill-badge-chip {
            background-color: #f8fafc;
            color: #2d3748;
            font-weight: 500;
            font-size: 0.88rem;
            padding: 7px 16px;
            border-radius: 25px;
            display: inline-flex;
            align-items: center;
            margin-right: 6px;
            margin-bottom: 8px;
            border: 1px solid var(--border-color);
            word-break: break-word;
            max-width: 100%;
        }

        /* Recommended Member Card in Sidebar */
        .recommended-member-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f7;
            text-decoration: none;
            color: inherit;
            transition: background 0.2s ease;
        }

        .recommended-member-card:hover {
            color: var(--brand-navy);
        }

        .recommended-member-card:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .recommended-member-img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #e2e8f0;
        }

        /* Gallery Image Grid Item */
        .gallery-thumb-container {
            position: relative;
            aspect-ratio: 4/3;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
            background-color: #edf2f7;
            border: 1px solid var(--border-color);
        }

        .gallery-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .gallery-thumb-container:hover .gallery-thumb-img {
            transform: scale(1.05);
        }

        /* Sticky Sidebar on Desktop */
        @media (min-width: 992px) {
            .profile-sidebar-sticky {
                position: sticky;
                top: 76px;
            }
        }

        /* Floating Modern Toast for Copy Link */
        .profile-toast {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(120px);
            background: #1d2856;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            z-index: 1099;
            transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.35s ease;
            opacity: 0;
            pointer-events: none;
            max-width: 90vw;
            white-space: nowrap;
        }

        .profile-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        /* Footer */
        .footer-public {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 18px 0;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* ============================================================
           RESPONSIVE BREAKPOINTS
           ============================================================ */

        /* Tablet (max-width: 991.98px) */
        @media (max-width: 991.98px) {
            .profile-card-body {
                padding: 20px;
            }

            .sidebar-contact-card {
                max-width: 520px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        /* Mobile Landscape / Small Tablets (max-width: 767.98px) */
        @media (max-width: 767.98px) {
            .profile-cover-banner {
                height: 160px;
            }

            .profile-avatar-wrapper {
                width: 114px;
                height: 114px;
                left: 20px;
                bottom: -56px;
                border-width: 3.5px;
            }

            .profile-header-body {
                padding: 66px 20px 22px 20px;
            }

            .profile-user-name {
                font-size: 1.45rem;
            }

            .company-badges-container {
                align-items: flex-start;
                margin-top: 12px;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .company-badge-item {
                font-size: 0.85rem;
                padding: 6px 12px;
            }

            .profile-action-group {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                width: 100%;
            }

            .profile-action-group .btn {
                flex: 1 1 calc(50% - 6px);
                font-size: 0.88rem;
                padding: 9px 14px;
            }
        }

        /* Mobile Portrait (max-width: 575.98px) */
        @media (max-width: 575.98px) {
            .brand-logo-img {
                height: 32px;
            }

            .brand-name {
                font-size: 1rem;
            }

            .site-public-header .btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .profile-cover-banner {
                height: 140px;
            }

            .profile-avatar-wrapper {
                width: 98px;
                height: 98px;
                left: 16px;
                bottom: -48px;
                border-width: 3.5px;
            }

            .profile-header-body {
                padding: 58px 16px 18px 16px;
            }

            .profile-card-body {
                padding: 16px;
            }

            .profile-user-name {
                font-size: 1.3rem;
            }

            .profile-user-headline {
                font-size: 0.88rem;
            }

            .profile-user-location {
                font-size: 0.82rem;
            }

            .profile-action-group {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 16px !important;
            }

            .profile-action-group .btn {
                flex: 1 1 calc(50% - 4px);
                font-size: 0.84rem;
                padding: 9px 8px;
            }

            .profile-action-group .btn-full-mobile {
                flex: 1 1 100%;
            }

            .section-card-heading {
                font-size: 1.02rem;
                margin-bottom: 12px;
            }

            .skill-badge-chip {
                font-size: 0.82rem;
                padding: 6px 12px;
            }

            .contact-modal-item {
                padding: 10px 0;
            }
        }

        /* Tiny Mobile Screens (max-width: 360px) */
        @media (max-width: 360px) {
            .brand-name {
                font-size: 0.9rem;
            }

            .site-public-header .btn {
                padding: 5px 8px;
                font-size: 0.75rem;
            }

            .profile-cover-banner {
                height: 120px;
            }

            .profile-avatar-wrapper {
                width: 86px;
                height: 86px;
                left: 14px;
                bottom: -42px;
            }

            .profile-header-body {
                padding: 50px 14px 16px 14px;
            }
        }
    </style>
</head>

<body>

    <!-- Site Header -->
    <header class="site-public-header py-2">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none" title="UBN Community Home">
                <img src="{{ asset('img/logo2.jpg') }}" class="brand-logo-img" alt="UBN Logo">
                <span class="brand-name">
                    UBN <span class="d-none d-sm-inline">Community</span>
                </span>
            </a>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-brand-outline btn-sm" onclick="handleProfileShare()" title="Share Profile Link">
                    <i class="bi bi-share-fill"></i>
                    <span class="d-none d-sm-inline ms-1">Share</span>
                </button>
                @auth
                    <a href="{{ route('home') }}" class="btn btn-brand-primary btn-sm" title="Go to Dashboard">
                        <i class="bi bi-speedometer2"></i>
                        <span class="d-none d-sm-inline ms-1">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand-primary btn-sm" title="Sign In">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span class="d-none d-sm-inline ms-1">Sign In</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Public Profile Container -->
    <main class="container my-3 my-md-4">
        <div class="row g-3 g-md-4">

            <!-- Main Profile Column (8 cols on desktop) -->
            <div class="col-lg-8">

                <!-- HERO CARD -->
                <div class="profile-card">
                    <!-- Cover Banner -->
                    <div class="profile-cover-banner">
                        <div class="profile-avatar-wrapper">
                            @php
                                $photo = $member->profilePhoto ?? null;
                            @endphp
                            @if ($photo && file_exists(public_path('ProfilePhoto/' . $photo)))
                                <img src="{{ asset('ProfilePhoto/' . $photo) }}" alt="{{ $member->firstName ?? '' }}" class="profile-avatar-img">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(($member->firstName ?? $user->firstName ?? 'U') . ' ' . ($member->lastName ?? $user->lastName ?? '')) }}&background=1D2856&color=fff&size=180" alt="Avatar" class="profile-avatar-img">
                            @endif
                        </div>
                    </div>

                    <!-- Header Content -->
                    <div class="profile-header-body">
                        <div class="row align-items-start">
                            <div class="col-md-7 col-lg-8">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <h1 class="profile-user-name mb-0">
                                        {{ $member->firstName ?? $user->firstName ?? 'Member' }}
                                        @if(!empty($member->title) && $member->title != '-') ({{ $member->title }}) @endif
                                        {{ $member->lastName ?? $user->lastName ?? '' }}
                                    </h1>
                                    <i class="bi bi-patch-check-fill text-primary fs-5" title="Verified Member Profile"></i>
                                    @if(!empty($member->gender))
                                        <span class="badge bg-light text-secondary border fw-normal">{{ $member->gender }}</span>
                                    @endif
                                </div>

                                @php
                                    $headlineItems = array_filter([
                                        $member->classification ?? null,
                                        $member->industry ?? null,
                                        $member->companyName ?? null
                                    ]);
                                @endphp
                                <p class="profile-user-headline">
                                    @if(!empty($headlineItems))
                                        {{ implode(' · ', $headlineItems) }}
                                    @else
                                        Professional Member at UBN Community Network
                                    @endif
                                </p>

                                <div class="profile-user-location">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $city->name ?? 'Location' }}@if(isset($state->name)), {{ $state->name }}@endif @if(isset($country->name)), {{ $country->name }}@endif
                                    · 
                                    <a href="#" class="text-primary fw-semibold text-decoration-none ms-1" data-bs-toggle="modal" data-bs-target="#contactInfoModal">
                                        Contact Info
                                    </a>
                                </div>
                            </div>

                            <!-- Right Badges -->
                            <div class="col-md-5 col-lg-4 mt-3 mt-md-0">
                                <div class="company-badges-container">
                                    @if(!empty($member->companyName))
                                    <div class="company-badge-item" title="{{ $member->companyName }}">
                                        @if(!empty($member->companyLogo) && file_exists(public_path('CompanyLogo/' . $member->companyLogo)))
                                            <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" class="company-badge-logo" alt="Logo">
                                        @else
                                            <i class="bi bi-building text-primary fs-5"></i>
                                        @endif
                                        <span class="fw-semibold text-dark small text-truncate" style="max-width: 180px;">{{ $member->companyName }}</span>
                                    </div>
                                    @endif

                                    @if(!empty($circle->name) || !empty($member->chapter))
                                    <div class="company-badge-item">
                                        <i class="bi bi-award-fill text-warning fs-5 flex-shrink-0"></i>
                                        <span class="fw-semibold text-dark small text-truncate" style="max-width: 180px;">{{ $circle->name ?? $member->chapter }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="profile-action-group mt-3 mt-md-4">
                            <button class="btn btn-brand-primary" data-bs-toggle="modal" data-bs-target="#contactInfoModal">
                                <i class="bi bi-telephone-fill me-1"></i> Contact Info
                            </button>
                           
                            @auth
                                <a href="{{ route('chat.index') }}" class="btn btn-brand-outline">
                                    <i class="bi bi-send-fill me-1"></i> Message
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- ABOUT CARD -->
                <div class="profile-card">
                    <div class="profile-card-body">
                        <h5 class="section-card-heading">
                            <i class="bi bi-person-lines-fill text-primary"></i> About Me
                        </h5>
                        <p class="text-secondary mb-0" style="font-size: 0.95rem; line-height: 1.8; white-space: pre-line; word-break: break-word;">
                            @if(!empty($member->myBusiness))
                                {{ $member->myBusiness }}
                            @elseif(!empty($tops->myBurningDesire))
                                {{ $tops->myBurningDesire }}
                            @elseif(!empty($member->goals))
                                {{ $member->goals }}
                            @else
                                Welcome to my official public profile! I am an active professional member focused on expanding business connections, delivering quality services, and building strategic collaborations across our business network.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- EXPERIENCE & BUSINESS DETAILS CARD -->
                <div class="profile-card">
                    <div class="profile-card-body">
                        <h5 class="section-card-heading">
                            <i class="bi bi-briefcase-fill text-primary"></i> Experience & Business Overview
                        </h5>

                        <div class="d-flex align-items-start gap-3 mb-3">
                            <div class="bg-light border rounded p-2 text-center flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                                @if(!empty($member->companyLogo) && file_exists(public_path('CompanyLogo/' . $member->companyLogo)))
                                    <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain;">
                                @else
                                    <i class="bi bi-building text-primary fs-3"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="fw-bold mb-1 fs-5 text-truncate" style="color: var(--brand-navy);">
                                    {{ $member->companyName ?? 'Business Organization' }}
                                </h6>
                                <p class="text-secondary mb-1 fw-semibold small">
                                    {{ $member->classification ?? 'Business Owner' }} @if(!empty($member->industry)) · {{ $member->industry }} @endif
                                </p>
                                @if(!empty($member->webSite))
                                <p class="mb-2">
                                    <a href="{{ Str::startsWith($member->webSite, 'http') ? $member->webSite : 'https://' . $member->webSite }}" target="_blank" class="text-primary text-decoration-none fw-semibold small text-break" style="word-break: break-all;">
                                        <i class="bi bi-globe me-1"></i> {{ $member->webSite }}
                                    </a>
                                </p>
                                @endif
                                @if(!empty($member->myBusiness))
                                    <p class="text-muted small mb-0" style="line-height: 1.6; word-break: break-word;">
                                        {{ Str::limit($member->myBusiness, 260) }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if(!empty($member->chapter) || !empty($circle->name))
                        <hr class="my-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light border rounded p-2 text-center flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi bi-people-fill text-success fs-4"></i>
                            </div>
                            <div class="min-w-0">
                                <h6 class="fw-bold mb-0" style="color: var(--brand-navy); font-size: 0.95rem;">Circle & Chapter Membership</h6>
                                <p class="text-secondary mb-0 fw-semibold small text-truncate">
                                    {{ $circle->name ?? $member->chapter }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- SKILLS & KEYWORDS CARD -->
                <div class="profile-card">
                    <div class="profile-card-body">
                        <h5 class="section-card-heading">
                            <i class="bi bi-award-fill text-warning"></i> Skills & Key Focus Areas
                        </h5>

                        @php
                            $keywordsArr = [];
                            if (!empty($member->keyWords)) {
                                $decoded = json_decode($member->keyWords, true);
                                if (is_array($decoded)) {
                                    $keywordsArr = $decoded;
                                } else {
                                    $keywordsArr = array_map('trim', explode(',', $member->keyWords));
                                }
                            }
                            if (!empty($member->skills)) {
                                $skillsArr = array_map('trim', explode(',', $member->skills));
                                $keywordsArr = array_unique(array_merge($keywordsArr, $skillsArr));
                            }
                        @endphp

                        @if(count($keywordsArr) > 0)
                            <div class="d-flex flex-wrap">
                                @foreach($keywordsArr as $kw)
                                    @if(!empty($kw))
                                        <span class="skill-badge-chip">
                                            <i class="bi bi-check-circle-fill text-success me-1"></i> {{ $kw }}
                                        </span>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="d-flex flex-wrap">
                                <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Business Networking</span>
                                <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Strategic Growth</span>
                                <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Client Relations</span>
                                <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Professional Leadership</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- GALLERY CARD -->
                @if(isset($galleryImages) && $galleryImages->count() > 0)
                <div class="profile-card">
                    <div class="profile-card-body">
                        <h5 class="section-card-heading">
                            <i class="bi bi-images text-info"></i> Portfolio & Media Showcase
                        </h5>
                        <div class="row g-2 g-md-3">
                            @foreach($galleryImages as $img)
                                <div class="col-6 col-sm-4">
                                    <div class="gallery-thumb-container" onclick="openLightbox('{{ asset('MemberGallery/' . $img->image) }}')">
                                        <img src="{{ asset('MemberGallery/' . $img->image) }}" class="gallery-thumb-img" alt="Gallery Photo">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Right Sidebar Column (4 cols on desktop) -->
            <div class="col-lg-4">
                <div class="profile-sidebar-sticky">

                    <!-- Quick Contact Summary Card -->
                    <div class="profile-card sidebar-contact-card">
                        <div class="profile-card-body text-center">
                            <h6 class="fw-bold mb-2 text-dark" style="font-size: 1.05rem;">Quick Contact Card</h6>
                            <p class="small text-muted mb-3">Scan QR code or copy direct link to save or share this profile.</p>
                            
                            <div class="d-flex justify-content-center mb-3">
                                <div class="p-2 bg-light border rounded" style="display: inline-block;">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url()->current()) }}" class="img-fluid" style="width: 140px; height: 140px; display: block;" alt="Profile QR Code">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button class="btn btn-brand-accent py-2 rounded-pill fw-bold" onclick="handleProfileShare()">
                                    <i class="bi bi-clipboard me-1"></i> Copy Direct Profile Link
                                </button>
                                <button class="btn btn-brand-outline-secondary py-2 rounded-pill fw-semibold" data-bs-toggle="modal" data-bs-target="#contactInfoModal">
                                    <i class="bi bi-person-lines-fill me-1"></i> View Full Contact Info
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Members / "More Profiles in Community" -->
                   
                </div>
            </div>

        </div>
    </main>

    <!-- Contact Info Modal -->
    <div class="modal fade" id="contactInfoModal" tabindex="-1" aria-labelledby="contactModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom py-3 px-3 px-md-4">
                    <h5 class="modal-title fw-bold text-dark fs-6 fs-md-5 text-truncate pe-2" id="contactModalTitle">
                        Contact Info: {{ $member->firstName ?? $user->firstName ?? '' }} {{ $member->lastName ?? $user->lastName ?? '' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 p-md-4">

                    <!-- Profile Link -->
                    @php
                        $canonicalUrl = url('/in/' . ($member->username ?? Str::slug(($user->firstName ?? '') . '-' . ($user->lastName ?? '')) ?? $member->id ?? ''));
                    @endphp
                    <div class="d-flex align-items-start gap-3 mb-3 contact-modal-item">
                        <div class="bg-light p-2 rounded-circle text-primary fs-5 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 small text-muted text-uppercase">Public Profile Link</h6>
                            <a id="profileUrlLink" href="{{ $canonicalUrl }}" class="text-primary text-decoration-none fw-semibold small d-block" style="word-break: break-all;">
                                {{ $canonicalUrl }}
                            </a>
                            <button class="btn btn-sm btn-light border rounded-pill mt-2 px-3 fw-semibold" onclick="handleProfileShare()">
                                <i class="bi bi-clipboard me-1"></i> Copy Link
                            </button>
                        </div>
                    </div>

                    <!-- Phone -->
                    @if(!empty($user->contactNo) || !empty($contactDetails->mobileNo))
                    @php
                        $rawPhone = $user->contactNo ?? $contactDetails->mobileNo;
                        $cleanPhone = preg_replace('/[^0-9]/', '', $rawPhone);
                    @endphp
                    <hr class="my-2 text-muted opacity-25">
                    <div class="d-flex align-items-start gap-3 mb-3 contact-modal-item">
                        <div class="bg-light p-2 rounded-circle text-success fs-5 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 small text-muted text-uppercase">Phone / Mobile</h6>
                            <p class="mb-2 text-dark fw-semibold">
                                {{ $rawPhone }}
                            </p>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="tel:{{ $cleanPhone }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-telephone me-1"></i> Call
                                </a>
                                <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Email -->
                    @if(!empty($user->email) || !empty($contactDetails->email))
                    @php
                        $userEmail = $user->email ?? $contactDetails->email;
                    @endphp
                    <hr class="my-2 text-muted opacity-25">
                    <div class="d-flex align-items-start gap-3 mb-3 contact-modal-item">
                        <div class="bg-light p-2 rounded-circle text-danger fs-5 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 small text-muted text-uppercase">Email Address</h6>
                            <a href="mailto:{{ $userEmail }}" class="text-primary text-decoration-none fw-semibold small d-block text-break" style="word-break: break-all;">
                                {{ $userEmail }}
                            </a>
                            <a href="mailto:{{ $userEmail }}" class="btn btn-sm btn-light border rounded-pill mt-2 px-3 fw-semibold">
                                <i class="bi bi-send me-1"></i> Compose Email
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Website -->
                    @if(!empty($member->webSite))
                    @php
                        $webUrl = Str::startsWith($member->webSite, 'http') ? $member->webSite : 'https://' . $member->webSite;
                    @endphp
                    <hr class="my-2 text-muted opacity-25">
                    <div class="d-flex align-items-start gap-3 mb-3 contact-modal-item">
                        <div class="bg-light p-2 rounded-circle text-info fs-5 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                            <i class="bi bi-globe"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 small text-muted text-uppercase">Official Website</h6>
                            <a href="{{ $webUrl }}" target="_blank" class="text-primary text-decoration-none fw-semibold small d-block text-break" style="word-break: break-all;">
                                {{ $member->webSite }}
                            </a>
                            <a href="{{ $webUrl }}" target="_blank" class="btn btn-sm btn-light border rounded-pill mt-2 px-3 fw-semibold">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Visit Website
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Address -->
                    @if(!empty($contactDetails->addressLine1) || isset($city->name))
                    <hr class="my-2 text-muted opacity-25">
                    <div class="d-flex align-items-start gap-3 contact-modal-item">
                        <div class="bg-light p-2 rounded-circle text-warning fs-5 flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 small text-muted text-uppercase">Office Location / Address</h6>
                            <p class="mb-0 text-secondary small" style="line-height: 1.6; word-break: break-word;">
                                {{ $contactDetails->addressLine1 ?? '' }} 
                                {{ $city->name ?? '' }} 
                                {{ $state->name ?? '' }} 
                                {{ $country->name ?? '' }}
                            </p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox Modal for Gallery Images -->
    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img id="lightboxImage" src="" class="img-fluid rounded shadow" style="max-height: 85vh; object-fit: contain;" alt="Enlarged Preview">
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Copy Toast Notification -->
    <div id="profileToast" class="profile-toast">
        <i class="bi bi-check-circle-fill text-success fs-5"></i>
        <span id="profileToastMsg">Profile link copied to clipboard!</span>
    </div>

    <!-- Footer -->
    <footer class="footer-public">
        <div class="container px-3">
            <p class="mb-0">© {{ date('Y') }} UBN Community. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Native Web Share with Clipboard Fallback
        function handleProfileShare() {
            const urlElem = document.getElementById('profileUrlLink');
            const linkText = urlElem ? urlElem.href : window.location.href;
            const profileTitle = document.title;

            if (navigator.share) {
                navigator.share({
                    title: profileTitle,
                    text: 'Connect with {{ $member->firstName ?? $user->firstName ?? "Member" }} on UBN Community:',
                    url: linkText
                }).catch(err => {
                    // Fallback to clipboard if user dismissed share dialog or error
                    if (err.name !== 'AbortError') {
                        copyToClipboardFallback(linkText);
                    }
                });
            } else {
                copyToClipboardFallback(linkText);
            }
        }

        function copyToClipboardFallback(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Link copied to clipboard!');
            }).catch(() => {
                // Legacy fallback
                const tempInput = document.createElement('input');
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                showToast('Link copied to clipboard!');
            });
        }

        function showToast(msg) {
            const toast = document.getElementById('profileToast');
            const msgElem = document.getElementById('profileToastMsg');
            if (toast && msgElem) {
                msgElem.innerText = msg;
                toast.classList.add('show');
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 3000);
            }
        }

        function openLightbox(imageUrl) {
            const img = document.getElementById('lightboxImage');
            if (img) {
                img.src = imageUrl;
                const modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
                modal.show();
            }
        }
    </script>
</body>

</html>
