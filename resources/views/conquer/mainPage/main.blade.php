<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UBN Events</title>
    {{-- bootstrap --}}
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/techExpo.css') }}"> --}}
    {{-- google font --}}


    <link rel="preconnect" href="{{ asset('https://fonts.googleapis.com') }}">
    <link rel="preconnect" href="{{ asset('https://fonts.gstatic.com') }}" crossorigin>
    <link href="{{ asset('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&family=Jost:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap') }}" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #fafbfc !important;
        }

        .header-top {
            padding-top: 32px;
            padding-bottom: 24px;
        }

        .logo {
            width: auto;
            height: 60px;
        }

        .login {
            width: 140px;
            height: auto;
            background-color: #d6460d;
            font-size: 15px;
            font-family: Poppins, sans-serif;
            padding: 6px;
        }

        .login:hover {
            background-color: #e6480a;
        }

        .left-content {
            width: auto;
            padding-right: 14px !important;
        }

        .hero img {
            width: 870px;
            height: 489px;
        }

        .navlink {
            color: #000;
            font-size: 20px;
            font-family: "Jost", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;
            line-height: 32px;
        }

        .navlink.active {
            border-bottom: 4px solid #d6460d !important;
            color: #d6460d;
        }

        .border-bottom {
            border-color: #b2b2b2;
        }

        .event h4 {
            font-size: 20px;
            font-family: "Jost", sans-serif;
            font-weight: 600;
        }

        .event p {
            font-size: 20px;
            font-family: "Jost", sans-serif;
        }

        .sponsors h4 {
            font-size: 20px;
            font-family: "Jost", sans-serif;
            font-weight: 600;
        }

        .goldSponsors {
            background-color: #f3f5f6;
        }

        .goldSponsors h4 {
            font-size: 20px;
            font-family: "Jost", sans-serif;
            font-weight: 400;
        }

        .exhibitors_partners h4 {
            font-size: 20px;
            font-family: "Jost", sans-serif;
            font-weight: 600;
        }

        .exhibitors {
            background-color: #f3f5f6;
        }

        .exhibitors h4 {
            font-size: 20px;
            font-family: "Jost", sans-serif;
            font-weight: 400;
        }

        .login:hover {
            background-color: #e6480a;
        }

        .viewAll {
            background-color: #d6460d;
            width: 140px;
            height: auto;
            font-size: 15px;
            font-family: "Poppins", sans-serif;
        }

        .viewAll:hover {
            background-color: #e6480a;
        }

        .right-content {
            width: 400px;
            background-color: #f1f1f1;
            font-family: "Poppins", sans-serif;
            position: sticky;
            top: 0;
            padding: 30px;
        }

        .right-content p {
            font-family: "Poppins", sans-serif;
        }

        .organised {
            font-size: 16px;
        }

        .AIMED {
            max-height: 60px;
            width: auto;
        }

        .upcoming {
            background-color: #1132a6;
            font-size: 15px;
            padding-top: 12px;
            padding-bottom: 12px;
        }

        .upcoming img {
            max-width: 10px;
        }

        .time,
        .date {
            font-size: 14px;
        }

        .btn-ticket {
            background-color: #d6460d;
            font-size: 20px;
            font-family: "Poppins", sans-serif;
            padding: 14px;
        }

        .btn-ticket:hover {
            background-color: #e6480a;
        }

        .countdown {
            background-image: url({{ asset('img_techExpo/timer_bg_img.png') }});
            background-size: cover;
            background-repeat: no-repeat;
        }

        .countdown .heading {
            font-size: 12px;
        }

        .countdown .run {
            font-size: 16px;
        }

        .sticky-navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        ::-webkit-scrollbar {
            width: 8px;
            background-color: #fff;
        }

        ::-webkit-scrollbar-thumb {
            background: #d6460d;
        }

        .mobile-426 {
            display: none;
        }

        .bottomBookTickets {
            display: none;
        }

        @media (max-width:769px) {
            .mobile-426 {
                display: block;
                width: 100%;
            }

            .laptop-device {
                display: none;
            }

            .main-content {
                width: 100%;
                padding-bottom: 40px;
            }

            .left-content {
                width: 100%;
                padding: 10px;
                margin-top: 10px;
            }

            .right-content {
                width: 100%;
            }

            .header-top-tablet {
                width: 100%;
                position: sticky;
                top: 0;
                background-color: #fff;
                z-index: 1000;
            }

            .hero img {
                width: 100%;
                height: auto;
            }

            .mobile-navbar {
                display: none;
            }

            .bottomBookTickets {
                background-color: #d6460d;
                font-family: "Poppins", sans-serif;
                font-size: 15px;
                display: block;
                padding: 14px;
            }

            .tablet-768 {
                margin-top: 20px;
                padding-top: 4px;
            }

            .event {
                margin-top: 20px;
            }

            ::-webkit-scrollbar {
                width: 4px;
                background-color: #fff;
            }

            ::-webkit-scrollbar-thumb {
                background: #d6460d;
            }
        }


        @media (max-width:431px) {
            .mobile-426 {
                display: block;
                width: 100%;
            }

            .laptop-device {
                display: none;
            }

            .main-content {
                width: 100%;
            }

            .left-content {
                width: 100%;
                margin-top: 100px;
                padding: 10px;
            }

            .hero {
                margin-top: 8px;
            }

            .hero img {
                width: 100%;
                height: auto;
                padding: 10px;
            }

            .header-top-mobile {
                position: fixed;
                z-index: 1000;
                background-color: #fff;
                top: 0;
            }

            .mobile-navbar {
                display: none;
            }

            #details {
                padding: 10px;
            }

            .bottomBookTickets {
                background-color: #d6460d;
                font-family: "Poppins", sans-serif;
                font-size: 15px;
                display: block;
            }

            .mobile-425 {
                width: 100%;
                padding-right: 8px;
                padding-left: 8px;
                margin-right: auto;
                margin-left: auto;
            }
        }

        @media (max-width:391px) {
            .companyLogo {
                width: 130px;
                height: auto;
            }
        }

        @media (max-width:376px) {
            .companyLogo {
                width: 140px;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="header-top-tablet">
        <div class="container header-top-mobile d-flex justify-content-center mt-3">
            <a href="#"><img src="{{ asset('img/logo4.png') }}" alt="logo" class="logo bg-transparent"></a>
        </div>
    </div>
    <div class="main-content mt-2">
        <div class="container d-flex position-relative mb-3">
            <div class="left-content mb-5">
                <div class="hero">
                    <img src="{{ asset('Event/' . $event->event_banner) }}" alt="event banner">
                </div>
                {{-- 768px tablet & 425px and below mobile device --}}
                <div class="mobile-425 tablet-768">
                    <div class="right-content container position:absolute mobile-426">
                        <p class="organised mb-3"><strong>Organised By</strong></p>
                        <img src="{{ asset('img/logo4.png') }}" alt="UBN logo" class="img-fluid UBN">
                        <h4 class="py-3 fw-bold mb-0">{{ $event->title }}</h4>
                        <button class="upcoming text-white px-3 border-0 fw-bold mb-3" style="background-color: #1d2368;"><img src="{{ asset('img/upcoming.png') }}" alt="upcoming"> Upcoming</button>
                        <p class="time mb-1">Date</p>
                        <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</p>
                        <p class="time mb-1">Slot Booking Date</p>
                        <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->slot_date)->format('d-m-Y') }}</p>
                        <p class="time mb-1">Start Time</p>
                        <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                        <p class="time mb-1">End Time</p>
                        <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</p>
                        <p class="time mb-1">Venue</p>
                        <p class="fw-bold date mb-3">{{ $event->venue }}</p>
                        {{-- <a href="" class="btn btn-ticket w-100 text-white fw-bold">Book My Tickets</a> --}}

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('main.event.login', $event->id) }}" class="btn btn-ticket text-white fw-bold" style="background-color: #1d2368;">UBN Member</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ route('main.event.visitorLogin', $event->id) }}" class="btn btn-ticket text-white fw-bold w-50">Visitor</a>
                        </div>
                        {{-- <div class="countdown w-100 p-4 text-white mt-3">
                            <p class="mb-2 heading"><img src="{{ asset('img_techExpo/watch-icon.png') }}" alt="watch"> &nbsp;Live event will start in</p>
                            <p class="mb-0 run fw-bold">06D : 08H : 10M : 18S</p>
                        </div> --}}
                    </div>
                </div>

                <nav class="navbar border-bottom border-2 mt-4 mb-4 py-0 bg-white sticky-navbar sticky-top mobile-navbar" id="navList">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link navlink px-5 active" aria-current="page" href="#list-item-1">Overview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navlink px-5" href="#list-item-2">Sponsors And Partners</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link navlink px-5" href="#list-item-3">Exhibitors</a>
                        </li>
                    </ul>
                </nav>

                <div data-bs-spy="scroll" data-bs-target="#navList" data-bs-offset="70" tabindex="0" id="details">
                    <div class="event" id="list-item-1">
                        <h4>Event Details</h4>
                        <p>
                            {{ $event->event_details }}
                        </p>
                    </div>
                    <div class="sponsors mt-3" id="list-item-2">
                        <h4>Sponsors and Partners</h4>
                        <div class="mt-3 border goldSponsors">
                            <h4 class="text-uppercase border-bottom px-4 py-2">Gold Sponsors</h4>
                            {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 py-3 px-4"> --}}
                            <div class="row g-3 py-3 px-4">
                                {{-- @foreach ($data as $item) --}}
                                <div class="col col-6 col-md-3">
                                    <div class="card h-100 border-0 shadow-sm d-flex justify-content-center align-items-center">
                                        {{-- <img src="eventSponsor/{{ $item->image }}" class="p-4 companyLogo" alt="Elsner Technologies"> --}}
                                    </div>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                        <div class="my-4 border goldSponsors">
                            <h4 class="text-uppercase border-bottom px-4 py-2">Silver Sponsors</h4>
                            {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 py-3 px-4"> --}}
                            <div class="row g-3 py-3 px-4">
                                {{-- @foreach ($data as $item) --}}
                                <div class="col col-6 col-md-3">
                                    <div class="card h-100 border-0 shadow-sm d-flex justify-content-center align-items-center">
                                        {{-- <img src="eventSponsor/{{ $item->image }}" class="p-4 companyLogo" alt="Elsner Technologies"> --}}
                                    </div>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                        <div class="my-4 border goldSponsors">
                            <h4 class="text-uppercase border-bottom px-4 py-2">Supporting Partners</h4>
                            {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 py-3 px-4"> --}}
                            <div class="row g-3 py-3 px-4">
                                {{-- @foreach ($data as $item) --}}
                                <div class="col col-6 col-md-3">
                                    <div class="card h-100 border-0 shadow-sm d-flex justify-content-center align-items-center">
                                        {{-- <img src="eventSponsor/{{ $item->image }}" class="p-4 companyLogo" alt="Elsner Technologies"> --}}
                                    </div>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                        <div class="my-4 border goldSponsors">
                            <h4 class="text-uppercase border-bottom px-4 py-2">It Industry Partners</h4>
                            {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 py-3 px-4"> --}}
                            <div class="row g-3 py-3 px-4">
                                {{-- @foreach ($data as $item) --}}
                                <div class="col col-6 col-md-3">
                                    <div class="card h-100 border-0 shadow-sm d-flex justify-content-center align-items-center">
                                        {{-- <img src="eventSponsor/{{ $item->image }}" class="p-4 companyLogo" alt="Elsner Technologies"> --}}
                                    </div>
                                </div>
                                {{-- @endforeach --}}
                            </div>
                        </div>
                    </div>
                    <div class="exhibitors_partners mt-3" id="list-item-3">
                        <h4>Exhibitors and Partners</h4>
                        <div class="mt-3 border exhibitors">
                            <h4 class="text-uppercase border-bottom px-4 py-2">Exhibitors</h4>
                            {{-- <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 py-3 px-4"> --}}
                            <div class="row g-3 py-3 px-4">
                                {{-- @foreach ($data as $item) --}}
                                <div class="col col-6 col-md-3">
                                    <div class="card h-100 border-0 shadow-sm d-flex justify-content-center align-items-center">
                                        {{-- <img src="eventSponsor/{{ $item->image }}" class="p-4 companyLogo" alt="Elsner Technologies"> --}}
                                    </div>
                                </div>
                                {{-- @endforeach --}}
                                {{-- <div class="d-flex justify-content-center align-items-center mt-4 mb-1 text-center w-100">
                                    <button class="rounded-pill py-2 border-0 viewAll text-white fw-bold">View
                                        All</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container laptop-device">
                <div class="right-content container position:absolute">
                    <p class="organised mb-3"><strong>Organised By</strong></p>
                    <img src="{{ asset('img/logo4.png') }}" alt="UBN logo" class="img-fluid UBN">
                    <h4 class="py-3 fw-bold mb-0">{{ $event->title }}</h4>
                    <button class="upcoming text-white px-3 border-0 fw-bold mb-3" style="background-color: #1d2368;"><img src="{{ asset('img/upcoming.png') }}" alt="upcoming"> Upcoming</button>
                    <p class="time mb-1">Date</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</p>
                    <p class="time mb-1">Slot Booking Date</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->slot_date)->format('d-m-Y') }}</p>
                    <p class="time mb-1">Start Time</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                    <p class="time mb-1">End Time</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</p>
                    {{-- <p class="time mb-1">Timezone</p>
                    <p class="fw-bold date mb-3">IST (GMT +05:30)</p> --}}
                    <p class="time mb-1">Venue</p>
                    <p class="fw-bold date mb-3">{{ $event->venue }}</p>
                    {{-- <a href="" class="btn btn-ticket w-100 text-white fw-bold">Book My Tickets</a> --}}

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('main.event.login', $event->id) }}" class="btn btn-ticket text-white fw-bold" style="background-color: #1d2368;">UBN Member</a>
                        <a href="{{ route('main.event.visitorLogin', $event->id) }}" class="btn btn-ticket text-white fw-bold w-50">Visitor</a>
                    </div>

                    {{-- <div class="countdown w-100 p-4 text-white mt-3">
                        <p class="mb-2 heading"><img src="{{ asset('img_techExpo/watch-icon.png') }}" alt="watch"> &nbsp;Live event will start in</p>
                        <p class="mb-0 run fw-bold">06D : 08H : 10M : 18S</p>
                    </div> --}}
                </div>
            </div>
        </div>

        {{-- <div class="w-100 text-center bottomBookTickets fixed-bottom mt-3" id="bookTicketsDiv">
            <a href="" class="text-decoration-none btn text-white fw-bold">Book My Tickets</a>
        </div> --}}

        <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js') }}" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('js/techExpo.js') }}"></script> --}}
        <script>
            document.addEventListener("scroll", function() {
                const scrollPosition = window.scrollY + window.innerHeight; // Current scroll position
                const pageHeight = document.documentElement.scrollHeight; // Total page height

                const bookTicketsDiv = document.getElementById("bookTicketsDiv");

                if (scrollPosition >= pageHeight / 2) {
                    bookTicketsDiv.style.display = "block";
                } else {
                    bookTicketsDiv.style.display = "none";
                }
            });
        </script>
</body>

</html>
