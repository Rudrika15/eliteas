@extends('layouts.layouts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
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

        @media (max-width:1440px) {
            .mobile-426 {
                display: block;
                width: 100%;
            }

            .laptop-device {
                display: block;
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



    <div class="container mt-3">
        <div class="d-flex justify-content-center py-4">
            <a href="#" class="main-logo d-flex align-items-center">
                <img src="{{ asset('img/logo2.jpg') }}" alt="" style="background-color: #F5E9E2; mix-blend-mode: multiply; width: 150px; height:100px;">
            </a>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h4 class="card-title">Upcoming Events</h4>
                    </div>

                    <div class="card-body">
                        <div class="container d-flex flex-column flex-lg-row position-relative mb-3">
                            <div class="left-content mb-5 w-100 w-lg-50">
                                <div class="hero">
                                    <img src="{{ asset('Event/' . $event->event_banner) }}" alt="event banner" class="w-100 rounded-4" style="height: 500px; object-fit: contain;">
                                </div>
                            </div>

                            <div class="right-content ms-lg-4 mt-4 mt-lg-0 w-100">
                                <p class="organised mb-3"><strong>Organised By</strong></p>
                                <img src="{{ asset('img/logo4.png') }}" alt="UBN logo" class="img-fluid mb-3" style="max-width: 150px;">

                                <h4 class="fw-bold mb-3">{{ $event->title }}</h4>

                                <div class="mb-3">
                                    <button class="btn text-white px-3 fw-bold me-2 mb-2" style="background-color: #1d2368;">
                                        <img src="{{ asset('img/upcoming.png') }}" alt="upcoming" style="width: 20px; margin-right: 5px;"> Upcoming
                                    </button>

                                    @if ($event->fees == 0)
                                        <button type="button" class="btn text-white px-3 fw-bold mb-2" style="background-color: #d6460d;">FREE</button>
                                    @else
                                        <button type="button" class="btn text-white px-3 fw-bold mb-2" style="background-color: #d6460d;">₹ {{ $event->fees }}</button>
                                    @endif


                                </div>


                                <div class="event-details">
                                    <p class="mb-1"><strong>Date:</strong></p>
                                    <p class="fw-bold mb-3">{{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</p>

                                    @if ($event->slot_date)
                                        <p class="mb-1"><strong>Slot Booking Date:</strong></p>
                                        <p class="fw-bold mb-3">{{ \Carbon\Carbon::parse($event->slot_date)->format('d-m-Y') }}</p>
                                    @endif

                                    <p class="mb-1"><strong>Start Time:</strong></p>
                                    <p class="fw-bold mb-3">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>

                                    <p class="mb-1"><strong>End Time:</strong></p>
                                    <p class="fw-bold mb-3">{{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</p>

                                    <p class="mb-1"><strong>Venue:</strong></p>
                                    <p class="fw-bold mb-3">{{ $event->venue }}</p>

                                    <p class="mb-1"><strong>Event Details:</strong></p>
                                    <p class="fw-bold mb-3">{{ $event->event_details }}</p>
                                </div>

                                <div class="mt-4">
                                    @if ($event->fees == 0)
                                        <form method="POST" action="{{ route('event.register', ['eventId' => $event->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-bg-orange btn-md">Register</button>
                                        </form>
                                    @else
                                        <div class="d-flex flex-wrap justify-content-start align-items-center gap-2">
                                            <button type="button" style="color: #fff; background-color: #d6460d;" class="btn btn-bg-orange btn-md" id="razorpayBtnEvent" data-amount-event="{{ $event->fees }}">Register Now</button>
                                            {{-- <button type="button" class="btn btn-bg-blue btn-md" id="registerWithoutPaymentBtn" data-event-id="{{ $event->id }}">Register & Pay Later</button> --}}
                                        </div>
                                    @endif
                                </div>

                            </div> <!-- End Right Content -->
                        </div> <!-- End Main Flex Box -->
                    </div> <!-- End Card Body -->
                </div> <!-- End Card -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register for Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registrationForm">
                        <div class="mb-3">
                            <label for="personName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="personName" name="personName" required>
                        </div>
                        <div class="mb-3">
                            <label for="personEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="personEmail" name="personEmail" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Please enter a valid email address.">
                        </div>

                        <div class="mb-3">
                            <label for="personContact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="personContact" name="personContact" required oninput="validateContactNumber(this)" maxlength="10" placeholder="Enter 10 digit number" pattern="\d{10}" title="Please enter a valid 10-digit contact number.">
                        </div>

                        <!-- Checkbox for Offline Payment -->
                        {{-- <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="payOffline" name="payOffline">
                        <label class="form-check-label" for="payOffline">
                            Pay Offline
                        </label>
                    </div> --}}

                        <input type="hidden" id="eventId" name="eventId" value="{{ $event->id }}">

                        <!-- Hidden field to store refId -->
                        <input type="hidden" id="refId" name="refId">

                        <div class="form-check mb-3">

                            <input type="checkbox" id="myCheckbox"> Check to Pay Now

                            <!-- Buttons -->
                            <button type="submit" class="btn btn-primary" id="payNowButton" style="display:none;">Pay Now</button>
                            <button type="submit" class="btn btn-success" id="registerButton">Register</button>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Extract the "ref" parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const refId = urlParams.get('ref'); // Get the "ref" parameter from the URL

            console.log('Ref ID:', refId); // Log refId for debugging

            var razorpayBtnEvent = document.getElementById('razorpayBtnEvent');
            var registerButton = document.getElementById('registerButton');
            var myCheckbox = document.getElementById('myCheckbox');
            var payNowButton = document.getElementById('payNowButton');

            // Show the registration modal when "Join Now" button is clicked
            if (razorpayBtnEvent) {
                razorpayBtnEvent.addEventListener('click', function() {
                    $('#registerModal').modal('show');
                });
            }

            // Handle the checkbox change to show/hide the "Pay Now" button
            myCheckbox.addEventListener('change', function() {
                if (myCheckbox.checked) {
                    payNowButton.style.display = 'inline-block'; // Show the button
                    registerButton.style.display = 'none'; // Hide the button
                } else {
                    registerButton.style.display = 'inline-block'; // Show the button
                    payNowButton.style.display = 'none'; // Hide the button
                }
            });

            // Handle the form submission for registration
            $('#registrationForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var form = $(this);
                var formData = new FormData(form[0]); // Use FormData to handle the form data
                var amount = parseInt($('#razorpayBtnEvent').data('amount-event')) * 100; // Convert to paise
                var razorpayKey = "{{ env('RAZORPAY_KEY') }}";

                // Get form field values
                var personName = formData.get('personName') || '';
                var personEmail = formData.get('personEmail') || '';
                var personContact = formData.get('personContact') || '';
                var eventId = $('#eventId').val();

                console.log('Form Data:', {
                    personName: personName,
                    personEmail: personEmail,
                    personContact: personContact,
                    refId: refId // Log refId for debugging
                });

                // Check if user is already registered
                $.ajax({
                    url: "{{ route('checkRegistration') }}",
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        personEmail: personEmail,
                        eventId: eventId,
                        refMemberId: refId // Include refId in registration check
                    },
                    success: function(response) {
                        if (response.isRegistered) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Already Registered',
                                text: 'You are already registered for this event.',
                            });
                        } else {
                            // Check if "Pay Now" is selected
                            if ($('#myCheckbox').is(':checked')) {
                                // Proceed with Razorpay payment
                                var eventOptions = {
                                    "key": razorpayKey,
                                    "amount": amount,
                                    "currency": "INR",
                                    "name": "{{ $event->title }}",
                                    "description": "Event Registration Payment",
                                    "image": "/img/logo.png",
                                    "handler": function(response) {
                                        console.log('Payment successful, Payment ID:', response.razorpay_payment_id);
                                        storeEventPaymentDetails(response.razorpay_payment_id, amount, personName, personEmail, personContact, refId);
                                    },
                                    "prefill": {
                                        "name": personName,
                                        "email": personEmail
                                    },
                                    "theme": {
                                        "color": "#F37254"
                                    }
                                };

                                var rzp = new Razorpay(eventOptions);
                                rzp.open();
                            } else {
                                // Register without payment
                                storeRegistrationDetails(personName, personEmail, personContact, refId);
                            }
                        }
                    },
                    error: function(error) {
                        console.error('Error checking registration:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to check registration status.',
                        });
                    }
                });
            });
        });

        function storeEventPaymentDetails(paymentId, amount, personName, personEmail, personContact, refId) {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = `{{ route('razorpay.payment.userEventPayment') }}`;
            var eventId = document.getElementById('eventId').value;

            console.log('Storing Payment Details:', {
                paymentId: paymentId,
                amount: amount,
                eventId: eventId,
                personName: personName,
                personEmail: personEmail,
                personContact: personContact,
                refMemberId: refId // Include refId for storage
            });

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        paymentId: paymentId,
                        amount: amount,
                        eventId: eventId,
                        personName: personName,
                        personEmail: personEmail,
                        personContact: personContact,
                        refId: refId // Send refId with payment details
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful',
                        text: 'You have successfully registered for the event.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error storing payment details:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to store payment details.',
                    });
                });
        }

        function storeRegistrationDetails(personName, personEmail, personContact, refId) {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = `{{ route('eventPayment.userOfflinePayment') }}`;
            var eventId = document.getElementById('eventId').value;

            console.log('Storing Registration Details:', {
                personName: personName,
                personEmail: personEmail,
                personContact: personContact,
                eventId: eventId,
                refMemberId: refId // Include refId for storage
            });

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        personName: personName,
                        personEmail: personEmail,
                        personContact: personContact,
                        eventId: eventId,
                        refMemberId: refId // Send refId with registration details
                    })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful',
                        text: 'You have successfully registered for the event.',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error storing registration details:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to store registration details.',
                    });
                });
        }
    </script>
@endsection
