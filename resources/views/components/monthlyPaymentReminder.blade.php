<style>
    #paymentReminderModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    #paymentReminderModal .modal-header {
        border-bottom: none;
        background-color: #1d3268;
    }

    #paymentReminderModal .modal-footer {
        border-top: none;
    }

    #paymentReminderModal .btn-outline-secondary:hover {
        background-color: #e0e0e0;
        color: #333;
    }

    #paymentReminderModal .btn-primary {
        background-color: #1d3268;
        border-color: #1d3268;
    }

    #paymentReminderModal .btn-primary:hover {
        background-color: #1d3268;
        border-color: #1d3268;
    }
</style>


<div class="row">
    <div class="col-md-12">
        <div class="card-title"><b>Monthly Meeting Payment</b></div>
        <div class="card border-0 shadow workshopCard">
            @if ($monthlyPayments->isNotEmpty())
                <div class="card-body">
                    @foreach ($monthlyPayments as $month => $payments)
                        @php
                            $currentMonth = now()->format('F - Y');
                            $isCurrentMonth = $month == $currentMonth;
                            $isUnpaid = $payments->first()->status == 'unpaid';
                        @endphp

                        @if ($isUnpaid)
                            <div class="alert alert-warning mt-3">
                                <strong>Payment Pending!</strong> Your payment is pending for
                                <b>{{ $month }}</b>.
                            </div>
                            <ul>
                                @foreach ($payments as $payment)
                                    <li class="mt-3">
                                        <b>{{ $month }}:</b> <span class="text-danger">Pending</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="alert alert-success">
                                <strong>Payment Completed!</strong> Your payment for <b>{{ $month }}</b> has
                                already been made.
                            </div>
                        @endif
                    @endforeach

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-bg-orange btn-md monthlyPay" data-amount="{{ $totalAmountDue }}">
                            Pay ₹{{ $totalAmountDue }}
                        </button>
                    </div>
                </div>
            @else
                <div class="card-body">
                    <p class="mt-5 text-muted text-center"><b>No Monthly Payment Details for Now.</b></p>
                </div>
            @endif
        </div>
    </div>
</div>


{{-- <div class="modal fade" id="paymentReminderModal" tabindex="-1" role="dialog" aria-labelledby="paymentReminderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="paymentReminderModalLabel">Payment Reminder</h5>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <img src="/img/timePayment4.png" alt="Reminder Icon" style="width: 80px;">
                </div>
                <h6 class="text-danger">
                    <strong>Your payment for <span id="paymentMonth" class="text-primary"></span> is pending.</strong>
                </h6>
                <p class="text-muted">Please complete your payment to avoid interruptions.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">
                    <i class="bi bi-clock"></i> Later
                </button>
                <button type="button" class="btn btn-primary px-4 py-2 payNowButton">
                    <i class="bi bi-wallet2"></i> Pay Now
                </button>
            </div>
        </div>
    </div>
</div> --}}




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

@if ($monthlyPayments)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var unpaidMonths = [];

            @if ($monthlyPayments->isNotEmpty())
                @foreach ($monthlyPayments as $month => $payments)
                    @if ($payments->first()->status == 'unpaid')
                        unpaidMonths.push("{{ $month }}");
                    @endif
                @endforeach
            @endif

            function showPaymentReminder() {
                if (unpaidMonths.length > 0) {
                    var paymentMonthElement = document.getElementById('paymentMonth');
                    if (paymentMonthElement) {
                        paymentMonthElement.textContent = unpaidMonths.join(", ");
                    }

                    var reminderModal = new bootstrap.Modal(document.getElementById('paymentReminderModal'));
                    reminderModal.show();
                }
            }

            // Show the modal on page load if unpaid payments exist
            showPaymentReminder();

            // Set interval to show the reminder every 15 minutes
            setInterval(showPaymentReminder, 15 * 60 * 1000); // 15 minutes in milliseconds

            // Add click event to all pay buttons
            var monthlyPayButtons = document.querySelectorAll('.monthlyPay');
            monthlyPayButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var amount = parseInt(button.getAttribute('data-amount')) * 100; // Convert to paise

                    var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                    // var razorpayKey = "rzp_test_VVNmvqg0nEoaOf";

                    if (!razorpayKey) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Payment configuration error. Please contact support.',
                        });
                        return;
                    }

                    var username = "{{ Auth::user()->name }}";
                    var useremail = "{{ Auth::user()->email }}";

                    var payOptions = {
                        "key": razorpayKey,
                        "amount": amount,
                        "currency": "INR",
                        "name": "UBN",
                        "description": "Monthly payment",
                        "image": "/img/logo.png",
                        "handler": function(response) {
                            storeMonthlyPaymentId(response.razorpay_payment_id, amount);
                        },
                        "prefill": {
                            "name": username,
                            "email": useremail
                        },
                        "theme": {
                            "color": "#012e6f"
                        }
                    };

                    var rzp = new Razorpay(payOptions);
                    rzp.open();
                });
            });

            document.querySelector('.payNowButton').addEventListener('click', function() {
                var firstUnpaidButton = document.querySelector('.monthlyPay');
                if (firstUnpaidButton) {
                    firstUnpaidButton.click();
                }
            });

            function storeMonthlyPaymentId(paymentId = '', amount = '') {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = `{{ route('razorpay.payment.monthlyPaymentStore') }}`;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            paymentId: paymentId,
                            amount: amount,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Payment Successful',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to store payment ID',
                        });
                    });
            }
        });
    </script>
@endif
