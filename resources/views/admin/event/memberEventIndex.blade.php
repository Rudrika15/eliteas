@extends('layouts.master')

@section('header', 'Event')
@section('content')

    <style>
        .event-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            gap: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .event-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .event-title {
            font-weight: 600;
            font-size: 15px;
            color: #0d1a26;
        }

        .event-meta {
            font-size: 13px;
            color: #6c757d;
        }

        .event-icons {
            font-size: 13px;
            color: #6c757d;
        }

        .event-icons i {
            margin-right: 5px;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .invite-btn {
            background-color: #fff;
            color: #fd7e14;
            border: 1px solid #fd7e14;
        }

        .book-btn {
            background-color: #fd7e14;
            color: white;
        }

        .price {
            font-weight: bold;
            font-size: 16px;
        }

        .attendee-count {
            color: #fd7e14;
            font-size: 13px;
            font-weight: 500;
        }
    </style>

    <div class="mt-4">
        @if ($events->count() > 0)
            <div class="row">
                <h3 style="color: #1d3268;">Events</h3>
                <hr>
                @foreach ($events as $eventData)
                    <div class="col-md-6">
                        <a href="{{ route('events.details', $eventData->id) }}" class="text-decoration-none">
                            <div class="event-card d-flex p-3 shadow-sm border rounded mt-3 bg-white">
                                <img src="{{ $eventData->event_thumb ? url('Event/' . basename($eventData->event_thumb)) : 'https://via.placeholder.com/100' }}" alt="Event" class="event-img me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">


                                <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="event-title fw-bold" style="color: #1d3268; font-weight: bold;">{{ $eventData->title ?? '-' }}</div>

                                        <div class="event-meta mt-1 text-muted small">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            {{ $eventData->venue ?? '-' }}
                                        </div>

                                        <div class="d-flex flex-wrap gap-3 mt-2 event-icons small text-secondary">
                                            <span class="color-blue fw-bold"><i class="bi bi-person-circle"></i> {{ $eventData->circle->circleName ?? '-' }}</span>
                                            <span class="color-blue fw-bold"><i class="bi bi-calendar-event"></i> {{ $eventData->event_date ? \Carbon\Carbon::parse($eventData->event_date)->format('d-m-Y') : '-' }}</span>
                                            {{-- <span class="color-blue fw-bold"><i class="bi bi-calendar-event"></i> {{ $eventData->slot_date ? \Carbon\Carbon::parse($eventData->slot_date)->format('d-m-Y') : '-' }}</span> --}}
                                            <span class="color-blue fw-bold"><i class="bi bi-clock"></i> {{ $eventData->start_time ?? '-' }}</span>
                                            <span class="color-blue fw-bold"><i class="bi bi-hourglass-split"></i>
                                                @if ($eventData->start_time && $eventData->end_time)
                                                    {{ \Carbon\Carbon::parse($eventData->start_time)->diff(\Carbon\Carbon::parse($eventData->end_time))->format('%h hrs %i min') }}
                                                @endif
                                            </span>
                                            <span class="attendee-count fw-bold color-orange"><i class="bi bi-people-fill"></i>
                                                {{-- Replace with actual attendee count if available --}}
                                                {{ $eventData->totalRegisterCount ?? '0' }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="event-footer d-flex justify-content-between align-items-center mt-3">
                                        <div class="price fw-bold color-orange">₹ {{ $eventData->fees ?? '0' }}</div>
                                        <div class="d-flex gap-2">
                                            {{-- @if ($eventData->slot_date)
                                            <a href="{{ route('memberSlotBooking.list', $eventData->id) }}" class="btn btn-sm btn-outline-primary">
                                                Slot Booking
                                            </a>
                                        @endif --}}
                                            {{-- <button href="{{ route('event.eventRegistrationListMembers', $eventData->id) }}" class="btn btn-sm btn-bg-orange">
                                            Joined People
                                        </button> --}}

                                            {{-- <button type="button" class="btn btn-bg-orange btn-md me-3 joinedMembersBtn" data-url="{{ route('event.eventRegistrationListMembers', $eventData->id) }}">
                                            Joined Members
                                        </button> --}}

                                            {{-- <button class="btn btn-bg-orange btn-md me-3 px-3 border-0 fw-bold" onclick="copyLink()" style="background-color: #1d2368;">
                                            Invite
                                        </button> --}}

                                            <i class="bi bi-share color-orange fw-bold" style="cursor: pointer;" onclick="copyLink()"></i>
                                            <span class="color-orange fw-bold" style="cursor: pointer;" onclick="copyLink()">Invite</span>

                                            <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $eventData->event_slug, 'ref' => auth()->user()->member->id]) }}">



                                            <style>
                                                #shareableLink {
                                                    display: none;
                                                }
                                            </style>


                                        </div>

                                        {{-- {{ $eventData->isMemberRegistered }} --}}

                                        @if (!$eventData->isMemberRegistered)
                                            @if ($eventData->fees == 0)
                                                <form method="POST" action="{{ route('event.register', ['eventId' => $eventData->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-bg-orange btn-md" id="freeRegisterBtn">Register</button>
                                                </form>
                                            @else
                                                {{-- <div class="d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-bg-orange btn-md me-3" id="razorpayBtnEvent" data-amount-event="{{ $eventData->fees }}" data-event-id="{{ $eventData->id }}">
                                                    Pay Now
                                                </button>
                                                <button type="button" class="btn btn-bg-blue btn-md" id="registerWithoutPaymentBtn" data-event-id="{{ $eventData->id }}">
                                                    Register & Pay Later
                                                </button>
                                            </div> --}}

                                                <button type="button" class="btn btn-bg-orange btn-md razorpayBtnEvent" data-amount-event="{{ $eventData->fees }}" data-event-id="{{ $eventData->id }}">
                                                    Pay Now
                                                </button>

                                                <button type="button" class="btn btn-bg-blue btn-md registerWithoutPaymentBtn" data-event-id="{{ $eventData->id }}">
                                                    Register & Pay Later
                                                </button>
                                            @endif
                                        @else
                                            <div class="d-flex">
                                                <div class="">
                                                    <button type="button" class="btn btn-success btn-md">
                                                        Already Joined
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-end mt-4">
                {!! $events->links() !!}
            </div> --}}
        @else
            <div class="row">
                <h3 style="color: #1d3268; font-weight: bold;">Events</h3>
                <hr>
            </div>
            <div class="text-center">
                <h3 style="color:#1d3268;">No event found for now</h3>
            </div>
        @endif
    </div>


    {{-- script section  --}}


    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js') }}" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('js/techExpo.js') }}"></script> --}}

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>


    {{-- copy link script  --}}


    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.joinedMembersBtn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var url = this.getAttribute('data-url');
                    window.location.href = url;
                });
            });
        });
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


    {{-- payment and registration script --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delegated event listener for all "Pay Now" buttons
            document.querySelectorAll('.razorpayBtnEvent').forEach(function(button) {
                button.addEventListener('click', function() {
                    let eventId = this.getAttribute('data-event-id');
                    let originalAmount = parseInt(this.getAttribute('data-amount-event')) * 100; // to paise
                    let discountAmount = 0;

                    // Optional: If coupon UI is per event, you'd fetch related elements here using eventId

                    // Final amount (no coupon logic applied here—assumes coupon UI is separate)
                    let finalAmount = originalAmount - discountAmount;

                    proceedWithPayment(finalAmount, eventId, this);
                });
            });

            // Core Razorpay logic per event
            function proceedWithPayment(amount, eventId, button) {
                let razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                let username = "{{ Auth::user()->name }}";
                let useremail = "{{ Auth::user()->email }}";
                let eventTitle = button.getAttribute('data-event-title') || "Event Registration";

                let options = {
                    key: razorpayKey,
                    amount: amount,
                    currency: "INR",
                    name: eventTitle,
                    description: "Event Registration Payment",
                    image: "/img/logo.png",
                    handler: function(response) {
                        console.log('Payment successful, Payment ID:', response.razorpay_payment_id);
                        storeEventPaymentDetails(response.razorpay_payment_id, amount, eventId);
                    },
                    prefill: {
                        name: username,
                        email: useremail
                    },
                    theme: {
                        color: "#F37254"
                    }
                };

                let rzp = new Razorpay(options);
                rzp.open();
            }

            // Store payment after successful payment
            function storeEventPaymentDetails(paymentId, amount, eventId) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let url = `{{ route('razorpay.payment.eventPayment') }}`;

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
        });
    </script>




    {{-- <script>
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
                                eventId: '{{ $eventData->id }}' // Dynamically include the event ID
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
                    console.log('Proceed with payment clicked');
                    var finalAmount = originalAmount - discountAmount;
                    console.log('Final amount:', finalAmount);
                    proceedWithPayment(finalAmount);
                });
            }

            // Function to initialize Razorpay and proceed with payment
            function proceedWithPayment(amount) {
                console.log('Proceed with payment function called');
                var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                // var razorpayKey = "rzp_test_VVNmvqg0nEoaOf";
                var username = "{{ Auth::user()->name }}";
                var useremail = "{{ Auth::user()->email }}";

                var eventOptions = {
                    key: razorpayKey,
                    amount: amount,
                    currency: "INR",
                    name: "{{ $eventData->title }}",
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
                console.log('Store event payment details function called');
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = `{{ route('razorpay.payment.eventPayment') }}`;
                var eventId = '{{ $eventData->id }}';

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
    </script> --}}
    {{-- 
    <script>
        $(document).ready(function() {
            $('#registerWithoutPaymentBtn').on('click', function() {
                var eventId = $(this).data('event-id');
                console.log(eventId);

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
    </script> --}}


    <script>
        $(document).ready(function() {
            // Use class selector and .on() for delegation if content is dynamic
            $(document).on('click', '.registerWithoutPaymentBtn', function() {
                var eventId = $(this).data('event-id');
                console.log("Register without payment clicked for Event ID:", eventId);

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

@endsection
