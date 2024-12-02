@extends('layouts.masterVisitor')

@section('title', 'UBN - Visitor Dashboard')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <p class="mt-3 text-muted text-center"><b> Welcome to UBN Visitor Dashboard. </b></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-title"><b>Upcoming Events</b></div>
            <div class="card border-0 shadow workshopCard">
                @if ($nearestEvents)
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="card-title">{{ $nearestEvents->title }}</h4>
                                <p class="card-text text-muted">
                                    <b>Total Registered Members: {{ $totalRegisterCount }}</b>
                                </p>
                                <b class="text-muted">Slot Date:</b> {{ \Carbon\Carbon::parse($nearestEvents->event_date)->format('j M Y') }} <br>
                            </div>
                            <div class="col-md-2 pt-3 text-muted text-end">
                                <b>Date:</b> {{ \Carbon\Carbon::parse($nearestEvents->event_date)->format('j M Y') }} <br>
                                <b>Start Time:</b> {{ $nearestEvents->start_time }} <br>
                                <b>End Time:</b> {{ $nearestEvents->end_time }}
                            </div>
                        </div>

                        @php
                            $visitor = session('visitor_id');
                            $eventRegister = \App\Models\VisitorEventRegister::where('visitorId', $visitor)
                                ->where('eventId', $nearestEvents->id)
                                ->first();
                        @endphp

                        @if ($eventRegister)
                            <div class="d-flex justify-content-end">
                                <strong><span class="text-success">Already Joined</span></strong>
                            </div>

                            @if ($nearestEvents->slot_date)
                                @php
                                    $isSlotBooked = \App\Models\SlotBooking::where('eventId', $nearestEvents->id)
                                        ->where('visitorId', $visitor)
                                        ->exists();
                                @endphp
                                <div class="d-flex justify-content-end mt-3">
                                    @if ($isSlotBooked)
                                        <button type="button" class="btn btn-bg-orange btn-md" id="viewMembers"
                                            onclick="location.href='{{ route('event.viewMembersForVisitors', ['id' => $nearestEvents->id]) }}'">
                                            View Members
                                        </button>
                                    @elseif (\Carbon\Carbon::parse($nearestEvents->slot_date)->format('Y-m-d') == \Carbon\Carbon::today()->format('Y-m-d'))
                                        <button type="button" class="btn btn-bg-orange btn-md" id="slotBooking"
                                            onclick="location.href='{{ route('event.viewMembersForVisitors', ['id' => $nearestEvents->id]) }}'">
                                            Slot Booking
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @else
                            @if ($nearestEvents->visitorFees == 0)
                                <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                                <form method="POST" action="{{ route('visitor.register.dash', ['eventId' => $nearestEvents->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-bg-orange btn-md" id="freeRegisterBtn">
                                        Register
                                    </button>
                                </form>
                            @else
                            <h5 class="text-muted text-end me-4 pt-3">₹ {{ $nearestEvents->visitorFees }}</h5>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-bg-orange btn-md" id="razorpayBtnEvent"
                                    data-amount-event="{{ $nearestEvents->visitorFees }}" data-original-amount="{{ $nearestEvents->visitorFees }}">
                                    Join Now
                                </button>
                            </div>

                            <!-- Coupon Modal -->
                            <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="couponModalLabel">Apply Coupon</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="couponForm">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="couponCode" class="form-label">Coupon Code</label>
                                                    <input type="text" class="form-control" id="couponCode" name="couponCode"
                                                           placeholder="Enter coupon code">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Apply</button>
                                            </form>
                                            <p id="discountInfo" class="text-success mt-3" style="display:none;"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="button" id="proceedToPayment" class="btn btn-bg-orange" disabled>Proceed to Payment</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mt-3 text-muted text-center"><b>No Events for now.</b></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    @if ($nearestEvents)
        <script>
    document.addEventListener('DOMContentLoaded', function() {
    var razorpayBtnEvent = document.getElementById('razorpayBtnEvent');
    var couponModal = new bootstrap.Modal(document.getElementById('couponModal'));
    var couponForm = document.getElementById('couponForm');
    var couponCodeInput = document.getElementById('couponCode');
    var discountInfo = document.getElementById('discountInfo');
    var proceedToPaymentBtn = document.getElementById('proceedToPayment');
    var originalAmount = parseInt(razorpayBtnEvent.getAttribute('data-amount-event'));
    var discountedAmount = originalAmount;  // Start with the original amount as the discounted amount
    var couponApplied = false;  // Flag to track if a valid coupon was applied

    // Initially show the payment options with the original amount and discounted amount options
    showPaymentOptions(originalAmount, discountedAmount);

    if (razorpayBtnEvent) {
        razorpayBtnEvent.addEventListener('click', function() {
            // Open the coupon modal when the "Join Now" button is clicked
            couponModal.show();
        });
    }

    couponForm.addEventListener('submit', function(e) {
        e.preventDefault();

        var couponCode = couponCodeInput.value.trim();
        if (couponCode) {
            // Send the coupon code to the server to validate
            validateCouponCode(couponCode);
        } else {
            // If no coupon code is entered, proceed to payment with the original amount
            showPaymentOptions(originalAmount, discountedAmount);
        }
    });

    function validateCouponCode(couponCode) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = "{{ route('visitor.validateCouponCode') }}";  // Your coupon validation route

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ couponCode: couponCode, eventId: '{{ $nearestEvents->id }}' })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var discount = data.discount;  // Assuming the response returns a discount value
                discountedAmount = originalAmount - discount;
                couponApplied = true; // Set the flag to true
                discountInfo.textContent = 'Coupon applied! Discount: ₹' + discount;
                discountInfo.style.display = 'block';
                showPaymentOptions(originalAmount, discountedAmount); // Update options with the discount
            } else {
                discountInfo.textContent = 'Invalid coupon code.';
                discountInfo.style.display = 'block';
                couponApplied = false;
                showPaymentOptions(originalAmount, discountedAmount); // Show options with the original amount
            }
        })
        .catch(error => {
            console.error('Error applying coupon:', error);
            discountInfo.textContent = 'Error applying coupon code. Please try again.';
            discountInfo.style.display = 'block';
            couponApplied = false;
            showPaymentOptions(originalAmount, discountedAmount); // Show options with the original amount
        });
    }

    function showPaymentOptions(originalAmount, discountedAmount) {
        // Show both options: with coupon (discounted) or without coupon (original)
        proceedToPaymentBtn.disabled = false;
        if (couponApplied) {
            proceedToPaymentBtn.textContent = 'Proceed with Discounted Payment (₹' + discountedAmount + ')';
        } else {
            proceedToPaymentBtn.textContent = 'Proceed with Original Payment (₹' + originalAmount + ')';
        }
    }

    proceedToPaymentBtn.addEventListener('click', function() {
        // Proceed to payment with the selected amount (either discounted or original)
        if (couponApplied) {
            openRazorpayPayment(discountedAmount);
        } else {
            openRazorpayPayment(originalAmount);
        }
    });

    function openRazorpayPayment(amount) {
        var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
        if (!razorpayKey) {
            console.error('Razorpay key is missing.');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Payment configuration error. Please contact support.',
            });
            return;
        }

        var userid = "{{ session('visitor_id') }}";
        var username = "{{ session('visitor_name') }}";
        var useremail = "{{ session('visitor_email') }}";
        console.log('Visitor Id:', userid);
        console.log('Visitor Name:', username);
        console.log('Visitor Email:', useremail);

        var eventOptions = {
            "key": razorpayKey,
            "amount": amount * 100,  // Convert to paise
            "currency": "INR",
            "name": "{{ $nearestEvents->title }}",
            "description": "Event Registration Payment",
            "image": "/img/logo.png",
            "handler": function(response) {
                console.log('Payment successful, Payment ID:', response.razorpay_payment_id);
                storeEventPaymentDetails(response.razorpay_payment_id, amount);
            },
            "prefill": {
                "name": username,
                "email": useremail
            },
            "theme": {
                "color": "#F37254"
            }
        };

        var rzp = new Razorpay(eventOptions);
        rzp.open();
    }

    function storeEventPaymentDetails(paymentId, amount) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = `{{ route('razorpay.payment.eventPaymentVisitor') }}`;
        var eventId = '{{ $nearestEvents->id }}';
        var visitorId = '{{ session('visitor_id') }}';

        console.log('Payment ID:', paymentId);
        console.log('Visitor ID:', visitorId);

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
                visitorId: visitorId
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
    @endif

@endsection
