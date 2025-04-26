@extends('layouts.master')
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
    <style>
        #shareableLink {
            display: none;
        }
    </style>

    <div class="header-top-tablet">

    </div>
    <div class="main-content mt-2">
        <div class="container d-flex position-relative mb-3">
            <div class="left-content mb-5">
                <div class="hero">
                    <img src="{{ asset('Event/' . $event->event_banner) }}" alt="event banner">
                </div>
                
            </div>

            <div class="container laptop-device">
                <div class="right-content container position:absolute">
                    <p class="organised mb-3"><strong>Organised By</strong></p>
                    <img src="{{ asset('img/logo4.png') }}" alt="UBN logo" class="img-fluid UBN">
                    <h4 class="py-3 fw-bold mb-0">{{ $event->title }}</h4>
                    <button class="upcoming text-white px-3 border-0 fw-bold mb-3" style="background-color: #1d2368;"><img src="{{ asset('img/upcoming.png') }}" alt="upcoming"> Upcoming</button>

                    @if ($event->fees == 0)
                        <button type="button" class="upcoming text-white px-3 border-0 fw-bold " style="background-color: #d6460d;">
                            FREE
                        </button>
                    @else
                        <button type="button" class="upcoming text-white px-3 border-0 fw-bold" style="background-color: #d6460d;">
                            ₹ {{ $event->fees }}
                        </button>
                    @endif

                    {{-- <button class="upcoming text-white px-3 border-0 fw-bold" onclick="copyLink()" style="background-color: #1d2368;">
                        Invite
                    </button>

                    <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $event->event_slug, 'ref' => auth()->user()->member->id]) }}"> --}}



                    <button class="upcoming text-white px-3 border-0 fw-bold" onclick="copyLink()" style="background-color: #1d2368;">
                        Invite
                    </button>
                    <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $event->event_slug, 'ref' => auth()->user()->member->id]) }}">


                    <style>
                        #shareableLink {
                            display: none;
                        }
                    </style>



                    <button type="button" class="upcoming text-white px-3 border-0 fw-bold" style="background-color: #d6460d;">
                        Total Registered Members : {{ $totalRegisterCount }}
                    </button>
                    {{-- <p class="time mb-1">Registred Members : <b> {{ $totalRegisterCount }}</b> --}}
                    </p>
                    <p class="time mb-1">Date</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</p>
                    @if ($event->slot_date)
                        <p class="time mb-1">Slot Booking Date</p>
                        <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->slot_date)->format('d-m-Y') }}</p>
                    @endif
                    <p class="time mb-1">Start Time</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</p>
                    <p class="time mb-1">End Time</p>
                    <p class="fw-bold date mb-3">{{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</p>
                    <p class="time mb-1">Venue</p>
                    <p class="fw-bold date mb-3">{{ $event->venue }}</p>
                    <p class="time mb-1">Event Details</p>
                    <p class="fw-bold date mb-3"> {{ $event->event_details }}
                    </p>

                    {{-- <div class="d-flex justify-content-between">
                        <a href="{{ route('main.event.login', $event->id) }}" class="btn btn-ticket text-white fw-bold" style="background-color: #1d2368;">UBN Member</a>
                        <a href="{{ route('main.event.visitorLogin', $event->id) }}" class="btn btn-ticket text-white fw-bold w-50">Visitor</a>
                    </div> --}}

                    <div class="mt-3">
                        @if (!is_null($findEventRegister) && count($findEventRegister) == 0)
                            @if ($event->fees == 0)
                                {{-- <h5 class="text-muted text-end me-4 pt-5">Free</h5> --}}
                                <form method="POST" action="{{ route('event.register', ['eventId' => $event->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-bg-orange btn-md" id="freeRegisterBtn">Register</button>
                                </form>
                            @else
                                {{-- <h5 class="text-end me-4 pt-3">₹ {{ $event->fees }}</h5> --}}
                                <div class="d-flex justify-content-end align-items-center">
                                    {{-- <input type="text" id="couponCode" class="form-control me-3 w-25" placeholder="Have you a coupon code ?"> --}}
                                    {{-- <button type="button" class="btn btn-secondary me-3" id="applyCouponBtn">Apply</button> --}}
                                    <button type="button" class="btn btn-bg-orange btn-md me-3" id="razorpayBtnEvent" data-amount-event="{{ $event->fees }}">
                                        Pay Now
                                    </button>

                                    <button type="button" class="btn btn-bg-blue btn-md" id="registerWithoutPaymentBtn" data-event-id="{{ $event->id }}">
                                        Register & Pay Later
                                    </button>

                                </div>
                                {{-- <div id="couponError" class="text-danger mt-2 text-end me-4" style="display:none;">Invalid
                                                    coupon code.</div>
                                                <div id="discountSuccess" class="text-success mt-2 text-end me-4" style="display:none;">
                                                    Coupon applied
                                                    successfully! Discount: ₹<span id="discountAmount"></span></div> --}}
                            @endif
                        @else
                            <div class="d-flex justify-content-between">
                                <div class="mt-3">
                                    <button type="button" class="btn btn-success btn-md">
                                        Already Joined
                                    </button>
                                </div>
                                @if ($event->slot_date && \Carbon\Carbon::parse($event->slot_date)->isSameDay(\Carbon\Carbon::now()))
                                    @php
                                        $isSlotBooked = \App\Models\SlotBooking::where('eventId', $event->id)
                                            ->where('userId', Auth::user()->id)
                                            ->exists();
                                    @endphp
                                    <div class=" mt-3 ">
                                        @if ($isSlotBooked)
                                            <button type="button" class="btn btn-bg-orange btn-md" id="viewMembers" onclick="location.href='{{ route('event.viewMembers', ['id' => $event->id]) }}'">
                                                View Members
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-bg-orange btn-md" id="slotBooking" onclick="location.href='{{ route('event.viewMembers', ['id' => $event->id]) }}'">
                                                Slot Booking
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- <div class="text-end mt-3">
                        <button class="btn btn-bg-blue btn-sm" onclick="copyLink()">
                            Invite Via Link
                        </button>
                        <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $event->event_slug, 'ref' => auth()->user()->member->id]) }}">
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

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        {{-- <script>
            function copyLink() {
                var copyText = document.getElementById("shareableLink").value;
                navigator.clipboard.writeText(copyText).then(function() {
                    alert("Link copied to clipboard");
                }, function(err) {
                    alert("Could not copy link");
                });
            }
        </script>
        <script>
            function copyLink() {
                var copyText = document.getElementById("shareableLink").value;
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
        </script> --}}


        <script>
            function copyLink() {
                var copyText = document.getElementById("shareableLink").value;

                if (navigator.clipboard && window.isSecureContext) {
                    // Modern Clipboard API
                    navigator.clipboard.writeText(copyText).then(function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Link copied!',
                            text: 'The link has been copied to your clipboard.',
                            confirmButtonText: 'OK'
                        });
                    }).catch(function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Could not copy the link. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    });
                } else {
                    // Fallback for older browsers
                    var textArea = document.createElement("textarea");
                    textArea.value = copyText;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        Swal.fire({
                            icon: 'success',
                            title: 'Link copied!',
                            text: 'The link has been copied to your clipboard.',
                            confirmButtonText: 'OK'
                        });
                    } catch (err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Could not copy the link. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                    document.body.removeChild(textArea);
                }
            }
        </script>



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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var razorpayBtnEvent = document.getElementById('razorpayBtnEvent');
                var applyCouponBtn = document.getElementById('applyCouponBtn');
                var couponCodeInput = document.getElementById('couponCode');
                var couponError = document.getElementById('couponError');
                var discountSuccess = document.getElementById('discountSuccess');
                var discountAmountSpan = document.getElementById('discountAmount');
                var originalAmount = parseInt(razorpayBtnEvent.getAttribute('data-amount-event')) * 100; // Convert to paise
                var discountAmount = 0;

                // Apply coupon functionality
                if (applyCouponBtn) {
                    applyCouponBtn.addEventListener('click', function() {
                        var couponCode = couponCodeInput.value.trim();

                        if (!couponCode) {
                            couponError.textContent = 'Please enter a coupon code.';
                            couponError.style.display = 'block';
                            return;
                        }

                        // Validate coupon via API
                        fetch('/validate-coupon', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    couponCode: couponCode, // Ensure it matches the backend's expected key
                                    eventId: '{{ $event->id }}' // Dynamically include the event ID
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Coupon is valid
                                    discountAmount = data.discount * 100; // Convert INR to paise
                                    discountSuccess.style.display = 'block';
                                    discountAmountSpan.textContent = (discountAmount / 100).toFixed(2); // Show INR format
                                    couponError.style.display = 'none';
                                } else {
                                    // Coupon is invalid
                                    discountSuccess.style.display = 'none';
                                    couponError.textContent = 'Invalid or expired coupon code.';
                                    couponError.style.display = 'block';
                                }
                            })
                            .catch(error => {
                                console.error('Error validating coupon:', error);
                                discountSuccess.style.display = 'none';
                                couponError.textContent = 'An error occurred while validating the coupon.';
                                couponError.style.display = 'block';
                            });
                    });
                }

                // Proceed to payment with discount
                if (razorpayBtnEvent) {
                    razorpayBtnEvent.addEventListener('click', function() {
                        var finalAmount = originalAmount - discountAmount;
                        proceedWithPayment(finalAmount);
                    });
                }

                // Function to initialize Razorpay and proceed with payment
                function proceedWithPayment(amount) {
                    var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                    // var razorpayKey = "rzp_test_VVNmvqg0nEoaOf";
                    var username = "{{ Auth::user()->name }}";
                    var useremail = "{{ Auth::user()->email }}";

                    var eventOptions = {
                        key: razorpayKey,
                        amount: amount,
                        currency: "INR",
                        name: "{{ $event->title }}",
                        description: "Event Registration Payment",
                        image: "/img/logo.png",
                        handler: function(response) {
                            console.log('Payment successful, Payment ID:', response.razorpay_payment_id);
                            storeEventPaymentDetails(response.razorpay_payment_id, amount);
                        },
                        prefill: {
                            name: username,
                            email: useremail
                        },
                        theme: {
                            color: "#F37254"
                        }
                    };

                    var rzp = new Razorpay(eventOptions);
                    rzp.open();
                }

                // Store payment details after successful payment
                function storeEventPaymentDetails(paymentId, amount) {
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var url = `{{ route('razorpay.payment.eventPayment') }}`;
                    var eventId = '{{ $event->id }}';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                paymentId: paymentId,
                                amount: amount,
                                eventId: eventId
                            })
                        })
                        .then(response => {
                            console.log('Payment details stored successfully.');
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
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#registerWithoutPaymentBtn').on('click', function() {
                    var eventId = $(this).data('event-id');

                    $.ajax({
                        url: "{{ route('handle.EventRegistration') }}",
                        type: "POST",
                        data: {
                            eventId: eventId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.message || "Failed to register for the event.");
                        }
                    });
                });
            });
        </script>
    </div>
@endsection
