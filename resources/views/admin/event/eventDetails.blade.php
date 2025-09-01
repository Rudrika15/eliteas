@extends('layouts.master')
@section('content')
    <style>
        /* body {
                                                                                                                background-color: #f5f8fb;
                                                                                                                font-family: 'Segoe UI', sans-serif;
                                                                                                            } */

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item.active {
            color: #1d2368;
        }

        .event-banner-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .event-banner-wrapper img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 12px;
        }

        .event-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
        }

        .event-meta i {
            color: #6c757d;
        }

        .event-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        .btn-danger,
        .btn-outline-primary {
            border-radius: 8px;
            font-weight: 600;
        }

        .invited-members img {
            border-radius: 50%;
            object-fit: cover;
            width: 40px;
            height: 40px;
        }

        .invited-members li {
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .invited-members .member-info {
            margin-left: 0.5rem;
            flex-grow: 1;
        }

        .btn-bg-orange {
            background-color: #d6460d;
            color: white;
        }

        .btn-bg-blue {
            background-color: #1d2368;
            color: white;
        }

        .see-all {
            display: inline-block;
            margin-top: 0.5rem;
            color: #1d2368;
            font-weight: 500;
            float: right;
        }
    </style>


    <style>
        #shareableLink {
            display: none;
        }
    </style>

    <div class=" my-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Events ({{ $eventCount ?? '1' }})</li>
                <li class="breadcrumb-item active color-blue fw-bold" aria-current="page">{{ $event->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Left: Event Image and Details -->
            <div class="col-lg-9">
                <img src="{{ asset('Event/' . $event->event_banner) }}" class="card-img-top" alt="event banner" style="border-radius: 10px; margin-bottom: 1rem;">

                <h5 class="fw-bold color-blue">{{ $event->title }}</h5>

                <div class="text-muted">Date & Time</div>

                <div class="d-flex align-items-center mb-3 text-muted small mt-3">
                    <i class="bi bi-calendar-event me-2 color-blue "></i><span class="color-blue fw-bold">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} </span>
                    <span class="mx-3 color-blue">|</span>
                    <i class="bi bi-clock me-2 color-blue"></i><span class="color-blue fw-bold">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}</span>
                    <span class="mx-3 color-blue">|</span>
                    <i class="bi bi-hourglass-split me-2 color-blue"></i><span class="color-blue fw-bold">2 Hours</span>
                </div>

                <p class="mb-1 color-blue fw-bold"><i class="bi bi-geo-alt-fill me-2 color-blue"></i>{{ $event->venue }}</p>
                {{-- <p class="text-muted small color-blue fw-bold mt-3">Organized by <strong class="color-blue">UBN</strong></p> --}}
            </div>

            <!-- Right: Booking Info -->
            <div class="col-lg-3">
                <div class="card p-3 border-0 shadow-sm mb-3 event-card">
                    <div class="event-card">
                        <div class="label text-muted">Event Fees</div>
                        <div class="amount color-blue" style="font-weight: bold; font-size: 1.5rem;">₹ {{$event->fees}}</div>
                        {{-- <br> --}}
                        <div class="actions">
                            <a href="javascript:void(0)" onclick="copyLink()" class="invite-btn color-orange">
                                <svg width="16" height="16" fill="#e0622b" viewBox="0 0 24 24">
                                    <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7a2.49 2.49 0 0 0 0-1.39l7.02-4.11a2.5 2.5 0 1 0-.91-1.54L8 9.67a2.5 2.5 0 1 0 0 4.66l7.02 4.11c.25-.16.52-.29.81-.39a2.5 2.5 0 1 0 2.17-2.97z" />
                                </svg>
                                <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $event->event_slug, 'ref' => auth()->user()->member->id]) }}">
                                <span class="fw-bold">Invite</span>
                            </a>
                            <button class="book-btn btn btn-bg-orange" style="margin-left: 100px;">Book Now</button>
                        </div>
                    </div>
                </div>

                <hr>
                {{-- <h6 class="mb-2">Invited Members ({{ $invitedMembers->count() }})</h6> --}}
                <div class="card p-3 border-0 shadow-sm mb-3 event-card">
                    <h6 class="mb-2 text-muted">Invited Members</h6>
                    <ul class="list-unstyled mt-3" style="max-height: 300px; overflow-y: auto;">
                        {{-- @foreach ($invitedMembers as $member) --}}
                        <li class="d-flex align-items-center mb-2">
                            <img src="{{ asset('img/profile.png') }}" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                {{-- <div class="fw-bold small">{{ $member->name }}</div> --}}
                                <div class="fw-bold small color-blue">Rudrika Dave</div>
                                {{-- <div class="text-muted small">{{ $member->designation }}</div> --}}
                                {{-- <div class="text-muted small">Full Stack Developer</div> --}}
                            </div>
                        </li>
                        <li class="d-flex align-items-center mb-2 mt-3">
                            <img src="{{ asset('img/profile.png') }}" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                {{-- <div class="fw-bold small">{{ $member->name }}</div> --}}
                                <div class="fw-bold small color-blue">Rudrika Dave</div>
                                {{-- <div class="text-muted small">{{ $member->designation }}</div> --}}
                                {{-- <div class="text-muted small">Full Stack Developer</div> --}}
                            </div>
                        </li>
                        {{-- @endforeach --}}
                    </ul>
                    {{-- <a href="#" class="text-primary small">See All</a> --}}
                </div>
            </div>
        </div>

        <!-- About the Event -->
        <div class="mt-2">
            <div class="">
                <h6 class="fw-bold mb-2 text-muted">About the Event</h6>
                <p class="color-blue">{{ $event->event_details }}</p>
            </div>
        </div>
    </div>

    <style>
        .btn-bg-orange {
            background-color: #d6460d;
            color: white;
        }

        .btn-bg-blue {
            background-color: #1d2368;
            color: white;
        }

        .card.event-card {
            border-radius: 0 !important;
        }
    </style>


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
