<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->firstName ?? $user->firstName ?? 'Member' }} {{ $member->lastName ?? $user->lastName ?? '' }} - Public Profile | UBN Community</title>
    
    <!-- Meta tags for social sharing -->
    <meta property="og:title" content="{{ $member->firstName ?? $user->firstName ?? 'Member' }} {{ $member->lastName ?? $user->lastName ?? '' }} - Public Profile">
    <meta property="og:description" content="{{ $member->classification ?? $member->companyName ?? 'Professional Member at UBN Community' }}">
    <meta property="og:image" content="{{ !empty($member->profilePhoto) ? asset('ProfilePhoto/' . $member->profilePhoto) : asset('img/faviconUbn.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Favicon -->
    <link href="{{ asset('img/faviconUbn.png') }}" rel="icon" />

    <!-- Google Fonts -->
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

        body {
            background-color: var(--bg-light);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Brand Header */
        .site-public-header {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        }

        .brand-logo-img {
            height: 42px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 700;
            color: var(--brand-navy);
            letter-spacing: -0.5px;
        }

        /* Cards */
        .profile-card {
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            margin-bottom: 24px;
            overflow: hidden;
        }

        /* Hero Banner */
        .profile-cover-banner {
            height: 240px;
            background: linear-gradient(135deg, #1d2856 0%, #2b3d80 50%, #e76a35 100%);
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .profile-avatar-wrapper {
            position: absolute;
            left: 32px;
            bottom: -76px;
            width: 152px;
            height: 152px;
            border-radius: 50%;
            border: 5px solid #ffffff;
            background-color: #ffffff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            overflow: hidden;
            z-index: 2;
        }

        .profile-avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-header-body {
            padding: 88px 32px 32px 32px;
        }

        .profile-user-name {
            font-size: 28px;
            font-weight: 700;
            color: var(--brand-navy);
            line-height: 1.2;
        }

        .profile-user-headline {
            font-size: 16px;
            color: #4a5568;
            font-weight: 500;
            margin-top: 6px;
            line-height: 1.5;
        }

        .profile-user-location {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 8px;
        }

        .company-badge-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 10px;
            margin-bottom: 8px;
        }

        .company-badge-logo {
            width: 38px;
            height: 38px;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Buttons */
        .btn-brand-primary {
            background-color: var(--brand-navy);
            color: #ffffff;
            font-weight: 600;
            border-radius: 25px;
            padding: 9px 24px;
            border: none;
            transition: all 0.2s;
        }

        .btn-brand-primary:hover {
            background-color: var(--brand-navy-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-brand-accent {
            background-color: var(--brand-orange);
            color: #ffffff;
            font-weight: 600;
            border-radius: 25px;
            padding: 9px 24px;
            border: none;
            transition: all 0.2s;
        }

        .btn-brand-accent:hover {
            background-color: var(--brand-orange-hover);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-brand-outline {
            background-color: transparent;
            color: var(--brand-navy);
            font-weight: 600;
            border-radius: 25px;
            padding: 8px 22px;
            border: 2px solid var(--brand-navy);
            transition: all 0.2s;
        }

        .btn-brand-outline:hover {
            background-color: var(--brand-navy);
            color: #ffffff;
        }

        .section-card-heading {
            font-size: 19px;
            font-weight: 700;
            color: var(--brand-navy);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .skill-badge-chip {
            background-color: #f7fafc;
            color: #2d3748;
            font-weight: 600;
            font-size: 14px;
            padding: 8px 18px;
            border-radius: 25px;
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 8px;
            border: 1px solid var(--border-color);
        }

        .recommended-member-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .recommended-member-card:last-child {
            border-bottom: none;
        }

        .recommended-member-img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .footer-public {
            margin-top: auto;
            background-color: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 20px 0;
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }
    </style>
</head>

<body>

    <!-- Site Header -->
    <header class="site-public-header py-2">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('img/logo2.jpg') }}" class="brand-logo-img" alt="UBN Logo">
                <span class="brand-name">UBN Community</span>
            </a>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-brand-outline btn-sm py-1-5 px-3" onclick="copyProfileLink()">
                    <i class="bi bi-share-fill me-1"></i> Share Profile
                </button>
                @auth
                    <a href="{{ route('home') }}" class="btn btn-brand-primary btn-sm py-1-5 px-3">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-brand-primary btn-sm py-1-5 px-3">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Public Profile Container -->
    <main class="container my-4">
        <div class="row">

            <!-- Main Profile Column (8 cols) -->
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
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(($member->firstName ?? $user->firstName ?? 'U') . ' ' . ($member->lastName ?? $user->lastName ?? '')) }}&background=1D2856&color=fff&size=150" alt="Avatar" class="profile-avatar-img">
                            @endif
                        </div>
                    </div>

                    <!-- Header Content -->
                    <div class="profile-header-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <h1 class="profile-user-name mb-0">
                                        {{ $member->firstName ?? $user->firstName ?? 'Member' }}
                                        @if(!empty($member->title) && $member->title != '-') ({{ $member->title }}) @endif
                                        {{ $member->lastName ?? $user->lastName ?? '' }}
                                    </h1>
                                    <i class="bi bi-patch-check-fill text-primary fs-4" title="Verified Member Profile"></i>
                                    @if(!empty($member->gender))
                                        <span class="badge bg-light text-secondary border fw-normal fs-6">{{ $member->gender }}</span>
                                    @endif
                                </div>

                                <p class="profile-user-headline">
                                    @if(!empty($member->classification))
                                        {{ $member->classification }}
                                    @endif
                                    @if(!empty($member->industry))
                                        | {{ $member->industry }}
                                    @endif
                                    @if(!empty($member->companyName))
                                        | {{ $member->companyName }}
                                    @endif
                                    @if(empty($member->classification) && empty($member->industry) && empty($member->companyName))
                                        Professional Member at UBN Community Network
                                    @endif
                                </p>

                                <div class="profile-user-location">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $city->name ?? 'Location' }}@if(isset($state->name)), {{ $state->name }}@endif @if(isset($country->name)), {{ $country->name }}@endif
                                    · 
                                    <a href="#" class="text-primary fw-semibold text-decoration-none ms-1" data-bs-toggle="modal" data-bs-target="#contactInfoModal">
                                        Contact Details
                                    </a>
                                </div>
                            </div>

                            <!-- Right Badges -->
                            <div class="col-md-4 mt-3 mt-md-0 d-flex flex-column align-items-md-end">
                                @if(!empty($member->companyName))
                                <div class="company-badge-item">
                                    @if(!empty($member->companyLogo) && file_exists(public_path('CompanyLogo/' . $member->companyLogo)))
                                        <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" class="company-badge-logo" alt="Logo">
                                    @else
                                        <i class="bi bi-building text-primary fs-5"></i>
                                    @endif
                                    <span class="fw-semibold text-dark small">{{ $member->companyName }}</span>
                                </div>
                                @endif

                                @if(!empty($circle->name) || !empty($member->chapter))
                                <div class="company-badge-item">
                                    <i class="bi bi-award-fill text-warning fs-5"></i>
                                    <span class="fw-semibold text-dark small">{{ $circle->name ?? $member->chapter }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap align-items-center gap-2 mt-4">
                            <button class="btn btn-brand-primary" data-bs-toggle="modal" data-bs-target="#contactInfoModal">
                                <i class="bi bi-telephone-fill me-1"></i> Contact Details
                            </button>
                            <button class="btn btn-brand-accent" onclick="copyProfileLink()">
                                <i class="bi bi-share-fill me-1"></i> Share Profile
                            </button>
                            @auth
                                <a href="{{ route('chat.index') }}" class="btn btn-brand-outline">
                                    <i class="bi bi-send-fill me-1"></i> Send Message
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- ABOUT CARD -->
                <div class="profile-card p-4">
                    <h5 class="section-card-heading">
                        <i class="bi bi-person-lines-fill text-primary"></i> About Me
                    </h5>
                    <p class="text-secondary" style="font-size: 15px; line-height: 1.8; white-space: pre-line;">
                        @if(!empty($member->myBusiness))
                            {{ $member->myBusiness }}
                        @elseif(!empty($tops->myBurningDesire))
                            {{ $tops->myBurningDesire }}
                        @elseif(!empty($member->goals))
                            {{ $member->goals }}
                        @else
                            Welcome to my official public profile! I am an active professional member focused on expanding business connections, delivering quality services, and building strategic collaborations.
                        @endif
                    </p>
                </div>

                <!-- EXPERIENCE & BUSINESS DETAILS CARD -->
                <div class="profile-card p-4">
                    <h5 class="section-card-heading">
                        <i class="bi bi-briefcase-fill text-primary"></i> Experience & Business Overview
                    </h5>

                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="bg-light border rounded p-2 text-center" style="width: 58px; height: 58px;">
                            @if(!empty($member->companyLogo) && file_exists(public_path('CompanyLogo/' . $member->companyLogo)))
                                <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" style="width: 100%; height: 100%; object-fit: contain;">
                            @else
                                <i class="bi bi-building text-primary fs-3"></i>
                            @endif
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 fs-5" style="color: var(--brand-navy);">
                                {{ $member->companyName ?? 'Business Organization' }}
                            </h6>
                            <p class="text-secondary mb-1 fw-semibold">
                                {{ $member->classification ?? 'Business Owner' }} @if(!empty($member->industry)) · {{ $member->industry }} @endif
                            </p>
                            @if(!empty($member->webSite))
                            <p class="mb-2">
                                <a href="{{ Str::startsWith($member->webSite, 'http') ? $member->webSite : 'https://' . $member->webSite }}" target="_blank" class="text-primary text-decoration-none fw-semibold">
                                    <i class="bi bi-globe me-1"></i> {{ $member->webSite }}
                                </a>
                            </p>
                            @endif
                            @if(!empty($member->myBusiness))
                                <p class="text-muted small mb-0" style="line-height: 1.6;">
                                    {{ Str::limit($member->myBusiness, 260) }}
                                </p>
                            @endif
                        </div>
                    </div>

                    @if(!empty($member->chapter) || !empty($circle->name))
                    <hr>
                    <div class="d-flex align-items-start gap-3 mt-3">
                        <div class="bg-light border rounded p-2 text-center" style="width: 54px; height: 54px;">
                            <i class="bi bi-people-fill text-success fs-3"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 fs-5">Circle & Chapter Membership</h6>
                            <p class="text-secondary mb-0 fw-semibold">
                                {{ $circle->name ?? $member->chapter }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- SKILLS & KEYWORDS CARD -->
                <div class="profile-card p-4">
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
                        <div>
                            @foreach($keywordsArr as $kw)
                                @if(!empty($kw))
                                    <span class="skill-badge-chip">
                                        <i class="bi bi-check-circle-fill text-success me-1"></i> {{ $kw }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="d-flex flex-wrap gap-2">
                            <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Business Networking</span>
                            <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Strategic Growth</span>
                            <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Client Relations</span>
                            <span class="skill-badge-chip"><i class="bi bi-check-circle-fill text-success me-1"></i> Professional Leadership</span>
                        </div>
                    @endif
                </div>

                <!-- GALLERY CARD -->
                @if(isset($galleryImages) && $galleryImages->count() > 0)
                <div class="profile-card p-4">
                    <h5 class="section-card-heading">
                        <i class="bi bi-images text-info"></i> Portfolio & Media Showcase
                    </h5>
                    <div class="row g-3">
                        @foreach($galleryImages as $img)
                            <div class="col-6 col-md-4">
                                <img src="{{ asset('MemberGallery/' . $img->image) }}" class="img-fluid rounded border shadow-sm" style="height: 150px; width: 100%; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <!-- Right Sidebar Column (4 cols) -->
            <div class="col-lg-4">

                <!-- Quick Contact Summary Card -->
                <div class="profile-card p-4 text-center">
                    <h6 class="fw-bold mb-3 text-dark" style="font-size: 17px;">Quick Contact Card</h6>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode(url()->current()) }}" class="img-fluid rounded border mb-3 p-2 bg-light" alt="QR Code">
                    <p class="small text-muted mb-3">Scan QR code to open or save this profile link directly on your phone.</p>
                    <button class="btn btn-brand-accent w-100 py-2 rounded-pill fw-bold" onclick="copyProfileLink()">
                        <i class="bi bi-clipboard me-1"></i> Copy Direct Profile Link
                    </button>
                </div>

            </div>

        </div>
    </main>

    <!-- Contact Info Modal -->
    <div class="modal fade" id="contactInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-header-title fw-bold mb-0">
                        Contact Details: {{ $member->firstName ?? $user->firstName ?? '' }} {{ $member->lastName ?? $user->lastName ?? '' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">

                    <!-- Profile Link -->
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-link-45deg text-primary fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Public Profile Link</h6>
                            <a id="profileUrlLink" href="{{ url('/in/' . ($member->username ?? Str::slug(($user->firstName ?? '') . '-' . ($user->lastName ?? '')))) }}" class="text-primary text-decoration-none fw-semibold">
                                {{ url('/in/' . ($member->username ?? Str::slug(($user->firstName ?? '') . '-' . ($user->lastName ?? '')))) }}
                            </a>
                            <br>
                            <button class="btn btn-sm btn-light border rounded-pill mt-2" onclick="copyProfileLink()">
                                <i class="bi bi-clipboard me-1"></i> Copy Link
                            </button>
                        </div>
                    </div>

                    <!-- Email -->
                    @if(!empty($user->email) || !empty($contactDetails->email))
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-envelope-fill text-danger fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Email Address</h6>
                            <a href="mailto:{{ $user->email ?? $contactDetails->email }}" class="text-primary text-decoration-none">
                                {{ $user->email ?? $contactDetails->email }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Phone -->
                    @if(!empty($user->contactNo) || !empty($contactDetails->mobileNo))
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-telephone-fill text-success fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Phone Number</h6>
                            <p class="mb-0 text-secondary fw-semibold">
                                {{ $user->contactNo ?? $contactDetails->mobileNo }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Website -->
                    @if(!empty($member->webSite))
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-globe text-info fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Official Website</h6>
                            <a href="{{ Str::startsWith($member->webSite, 'http') ? $member->webSite : 'https://' . $member->webSite }}" target="_blank" class="text-primary text-decoration-none">
                                {{ $member->webSite }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Address -->
                    @if(!empty($contactDetails->addressLine1) || isset($city->name))
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-geo-alt-fill text-warning fs-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Location / Address</h6>
                            <p class="mb-0 text-secondary">
                                {{ $contactDetails->addressLine1 ?? '' }} {{ $city->name ?? '' }} {{ $state->name ?? '' }} {{ $country->name ?? '' }}
                            </p>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer-public">
        <div class="container">
            <p class="mb-0">© {{ date('Y') }} UBN Community. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function copyProfileLink() {
            const linkText = document.getElementById('profileUrlLink').href;
            navigator.clipboard.writeText(linkText).then(() => {
                alert('Public Profile link copied to clipboard:\n' + linkText);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>

</html>
