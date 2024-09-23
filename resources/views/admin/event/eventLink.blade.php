@extends('layouts.layouts')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Add SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('content')
<div class="container mt-3">
    <div class="d-flex justify-content-center py-4">
        <a href="#" class="main-logo d-flex align-items-center">
            <img src="{{ asset('img/logo2.jpg') }}" alt=""
                style="background-color: #F5E9E2; mix-blend-mode: multiply; width: 150px; height:100px;">
            {{-- <span class="d-none d-lg-block">Elite</span> --}}
        </a>
    </div><!-- End Logo -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h4 class="card-title">Upcoming Events</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <h5>{{ $event->title }}</h5>
                            <p>
                                <strong>Date:</strong> {{
                                \Carbon\Carbon::parse($event->event_date)->format('j M Y') }}<br>
                                <strong>Start Time:</strong> {{ $event->start_time }}<br>
                                <strong>End Time:</strong> {{ $event->end_time }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            {{-- @if (!is_null($findEventRegister) && count($findEventRegister) == 0) --}}
                            @if ($event->amount == 0)
                            <h5 class="text-muted">Free</h5>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#registerModal">
                                Register
                            </button>
                            @else
                            <h5 class="text-muted">₹ {{ $event->amount }}</h5>
                            <button type="button" class="btn btn-warning" id="razorpayBtnEvent"
                                data-amount-event="{{ $event->amount }}">
                                Join Now
                            </button>
                            @endif
                        </div>
                    </div>

                    <!-- Shareable Link Section -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <!-- <a href="{{ route('event.link', $event->event_slug) }}" target="_blank">
                                        View Event Details
                                    </a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        <input type="email" class="form-control" id="personEmail" name="personEmail" required 
                               pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
                               title="Please enter a valid email address.">
                    </div>
                    
                    <div class="mb-3">
                        <label for="personContact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="personContact" name="personContact" required 
                               oninput="validateContactNumber(this)" maxlength="10" 
                               placeholder="Enter 10 digit number" pattern="\d{10}" 
                               title="Please enter a valid 10-digit contact number.">
                    </div>
                    <input type="hidden" id="eventId" name="eventId" value="{{ $event->id }}">
                    
                    <!-- Hidden field to store refId -->
                    <input type="hidden" id="refId" name="refId">

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Pay Now</button>
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
    // Check if the URL has a 'ref' query parameter
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const refId = urlParams.get('ref');

        // Debugging log to check if refId is being retrieved
        console.log('Ref ID:', refId);

        // If 'ref' exists, set the value in the hidden input field
        if (refId) {
            const refIdField = document.getElementById('refId');
            
            if (refIdField) {
                refIdField.value = refId;
                console.log('Ref ID set to:', refIdField.value);  // Check if it's set correctly
            } else {
                console.error('Ref ID input field not found');
            }
        } else {
            console.error('Ref ID not found in URL');
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var razorpayBtnEvent = document.getElementById('razorpayBtnEvent');

        // Extract refId from the URL and set it in the hidden field
        const urlParams = new URLSearchParams(window.location.search);
        const refId = urlParams.get('ref');
        if (refId) {
            document.getElementById('refId').value = refId;
            console.log('Ref ID found and set:', refId);
        }

        if (razorpayBtnEvent) {
            razorpayBtnEvent.addEventListener('click', function() {
                $('#registerModal').modal('show');
            });
        }

        $('#registrationForm').on('submit', function(event) {
            event.preventDefault();
            $('#registerModal').modal('hide');

            var form = $(this);
            var formData = new FormData(form[0]); // Use FormData to handle the form data
            var amount = parseInt($('#razorpayBtnEvent').data('amount-event')) * 100; // Convert to paise
            var razorpayKey = "{{ env('RAZORPAY_KEY') }}";

            // Get form field values
            var personName = formData.get('personName') || '';
            var personEmail = formData.get('personEmail') || '';
            var personContact = formData.get('personContact') || '';
            var eventId = $('#eventId').val();
            var refId = $('#refId').val();  // Get refId from hidden field

            console.log('Form Data:', {
                personName: personName,
                personEmail: personEmail,
                personContact: personContact,
                amount: amount,
                refId: refId  // Log refId for debugging
            });

            // Check if user is already registered
            $.ajax({
                url: "{{ route('checkRegistration') }}",
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    personEmail: personEmail,
                    eventId: eventId,
                    refId: refId  // Include refId in registration check
                },
                success: function(response) {
                    if (response.isRegistered) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Already Registered',
                            text: 'You are already registered for this event.',
                        });
                    } else {
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
            refId: refId  // Include refId for storage
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
                refId: refId  // Send refId with payment details
            })
        })
        .then(response => {
            console.log('Response Status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Payment details stored successfully:', data);
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
</script>

@endsection