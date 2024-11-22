<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UBN Community - Business Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #e76a35;
        }

        .navbar-brand,
        .nav-link {
            color: #fff !important;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #1d3268 !important;
        }

        /* Hero Section */
        .hero {
            background: url('https://images.unsplash.com/photo-1504384308090-c894fdcc538d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1600') no-repeat center center/cover;
            height: 50vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(29, 50, 104, 0.8);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
            color: #e76a35;
        }

        .hero p {
            font-size: 1.25rem;
            margin-top: 1rem;
        }

        /* Event Section */
        .event-section {
            padding: 4rem 1rem;
        }

        .event-card {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #1d3268;
        }

        .event-card h4 {
            color: #e76a35;
            font-weight: bold;
        }

        .event-card p {
            margin: 0.5rem 0;
        }

        .btn-event {
            background-color: #e76a35;
            color: #fff;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-event:hover {
            background-color: #d85f30;
            transform: translateY(-3px);
        }

        /* Highlights Section */
        .highlights {
            background-color: #1d3268;
            color: #fff;
            padding: 3rem 1rem;
            text-align: center;
        }

        .highlights h3 {
            margin-bottom: 2rem;
            font-size: 2rem;
            color: #e76a35;
        }

        .highlights .highlight-item {
            margin-bottom: 1.5rem;
        }

        .highlights .icon {
            font-size: 2rem;
            color: #e76a35;
        }

        /* Footer Styles */
        footer {
            background-color: #1d3268;
            color: #fff;
            padding: 2rem 0;
            text-align: center;
        }

        footer a {
            color: #e76a35;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .btn-bg-blue {
            background-color: #1d3268;
            color: #fff;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-bg-orange {
            background-color: #e76a35;
            color: #fff;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">UBN Community</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="#highlights">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#footer">Contact</a></li> --}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-content">
            <h1>Empowering Business Connections</h1>
            <p>Join our community to exchange ideas, build relationships, and grow your business.</p>
        </div>
    </div>

    <!-- Event Section -->
    <div class="container event-section" id="events">
        <h2 class="text-center mb-4" style="color: #e76a35; font-weight: bold;">Upcoming Business Events</h2>

        <!-- First Event -->
        <div class="row mb-4">
            <div class="col-md-6">
                <img src="{{ asset('Event/' . $event->event_banner) }}" class="img-fluid rounded"
                    alt="Event Image 1" style="height: 300px; width: 500px;">
            </div>
            <div class="col-md-6">
                <div class="event-card">
                    <h4>{{ $event->title }}</h4>
                    <p style="font-style: italic; font-weight: bold; color: #555;">{{ $event->event_details }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }}</p>
                    <p><strong>Location:</strong> {{ $event->venue }}</p>
                    <p><strong>Apply If you are</strong></p>
                    <a href="{{ route('main.event.login', $event->id) }}" class="btn btn-event"
                        style="margin-right: 10px;">UBN Member</a>
                    <a href="{{ route('main.event.visitorLogin', $event->id) }}" class="btn btn-event">Visitor</a>

                    {{-- <a href="#" class="btn btn-event" data-bs-toggle="modal" data-bs-target="#applyModal">Apply
                        Now</a> --}}
                </div>
            </div>

            <!-- Modal -->
            {{-- <div class="modal fade" id="applyModal" tabindex="-1" aria-labelledby="applyModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="applyModalLabel">Are You UBN Member ?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <a href="{{ route('main.event.login', $event->id) }}" class="btn btn-bg-blue me-3">YES</a>
                            <a href="{{ route('main.event.visitor', $event->id) }}" class="btn btn-bg-orange">NO</a>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>


    <!-- Highlights Section -->
    <div class="highlights" id="highlights">
        <div class="container">
            <h3>Why Choose UBN Community?</h3>
            <div class="row">
                <div class="col-md-4 highlight-item">
                    <span class="icon">🌐</span>
                    <p>Global Business Network</p>
                </div>
                <div class="col-md-4 highlight-item">
                    <span class="icon">💡</span>
                    <p>Innovative Ideas & Strategies</p>
                </div>
                <div class="col-md-4 highlight-item">
                    <span class="icon">🤝</span>
                    <p>Strong Professional Relationships</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer id="footer">
        <p>&copy; 2024 UBN Community | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
