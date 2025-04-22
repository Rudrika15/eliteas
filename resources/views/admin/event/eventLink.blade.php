@extends('layouts.layouts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
    <div class="main-content mt-4">
        <div class="container">
            <div class="row g-4">

                {{-- Left Side: Banner --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow rounded-4 overflow-hidden">
                        <img src="{{ asset('Event/' . $event->event_banner) }}" class="img-fluid w-100" alt="event banner">
                    </div>
                </div>

                {{-- Right Side: Event Details --}}
                <div class="col-md-6">
                    <div class="card border-0 shadow rounded-4 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('img/logo4.png') }}" alt="UBN logo" class="img-fluid me-3" style="width: 50px;">
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $event->title }}</h4>
                                <span class="badge bg-primary">Upcoming</span>
                                @if ($event->fees == 0)
                                    <span class="badge bg-danger ms-2">FREE</span>
                                @else
                                    <span class="badge bg-danger ms-2">₹ {{ $event->fees }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Event Info --}}
                        <ul class="list-unstyled mb-4">
                            <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</li>
                            @if ($event->slot_date)
                                <li><strong>Slot Booking Date:</strong> {{ \Carbon\Carbon::parse($event->slot_date)->format('d-m-Y') }}</li>
                            @endif
                            <li><strong>Start Time:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</li>
                            <li><strong>End Time:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</li>
                            <li><strong>Venue:</strong> {{ $event->venue }}</li>
                        </ul>

                        <div class="mb-3">
                            <strong>Event Details:</strong>
                            <p>{{ $event->event_details }}</p>
                        </div>

                        {{-- Share Link --}}
                        <button class="btn btn-outline-primary w-100 mb-3" onclick="copyLink()">📨 Invite Someone</button>
                        <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $event->event_slug, 'ref' => auth()->user()->member->id]) }}">

                        {{-- Registration Buttons --}}
                        {{-- @if (!is_null($findEventRegister) && count($findEventRegister) == 0) --}}
                        @if ($event->fees == 0)
                            <form method="POST" action="{{ route('event.register', ['eventId' => $event->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">Register Free</button>
                            </form>
                        @else
                            <div class="d-flex flex-column gap-2">
                                <button type="button" class="btn btn-warning w-100" id="razorpayBtnEvent" data-amount-event="{{ $event->fees }}">💳 Pay Now</button>
                                <button type="button" class="btn btn-secondary w-100" id="registerWithoutPaymentBtn" data-event-id="{{ $event->id }}">🕒 Register & Pay Later</button>
                            </div>
                        @endif
                        {{-- @else --}}
                        {{-- <button type="button" class="btn btn-success w-100 mb-2">✅ Already Registered</button> --}}
                        @if ($event->slot_date && \Carbon\Carbon::parse($event->slot_date)->isSameDay(\Carbon\Carbon::now()))
                            @php
                                $isSlotBooked = \App\Models\SlotBooking::where('eventId', $event->id)
                                    ->where('userId', Auth::user()->id)
                                    ->exists();
                            @endphp
                            <button type="button" class="btn btn-info w-100" onclick="location.href='{{ route('event.viewMembers', ['id' => $event->id]) }}'">
                                {{ $isSlotBooked ? '👥 View Members' : '📅 Slot Booking' }}
                            </button>
                        @endif
                        {{-- @endif --}}

                        {{-- Countdown --}}
                        <div class="countdown w-100 p-3 bg-dark text-white text-center rounded-4 mt-4">
                            <p class="mb-1"><img src="{{ asset('img_techExpo/watch-icon.png') }}" alt="watch" style="width: 20px;"> Live event will start in</p>
                            <h5 class="fw-bold">06D : 08H : 10M : 18S</h5>
                        </div>
                    </div>
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
