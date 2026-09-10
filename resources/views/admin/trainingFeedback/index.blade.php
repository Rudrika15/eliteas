@extends('layouts.master')

@section('header', 'Training')
@section('content')

    <div class="mt-4">
        @if ($trainings->count() > 0)
            <div class="row">
                <h3 style="color: #1d3268;">Trainings</h3>
                <hr>
                @foreach ($trainings as $trainingData)
                    <div class="col-md-6">
                        <div class="event-card d-flex p-3 shadow-sm border rounded mt-3 bg-white">
                            <img src="https://via.placeholder.com/100" alt="Training" class="event-img me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">

                            <img src="{{ $trainingData->training_thumb ? url('Training/' . basename($trainingData->training_thumb)) : 'https://via.placeholder.com/100' }}" alt="Training" class="event-img me-3" style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">

                            <div class="flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="event-title fw-bold" style="color: #1d3268;">
                                        {{ $trainingData->title ?? '-' }}
                                    </div>

                                    <div class="event-meta mt-1 text-muted small">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        {{ $trainingData->venue ?? '-' }}
                                    </div>

                                    <div class="d-flex flex-wrap gap-3 mt-2 event-icons small text-secondary">
                                        <span class="color-blue fw-bold">
                                            <i class="bi bi-bookmark-fill"></i>
                                            {{ $trainingData->trainingMaster->trainingName ?? '-' }}
                                        </span>
                                        <span class="color-blue fw-bold">
                                            <i class="bi bi-list-task"></i>
                                            {{ $trainingData->type ?? '-' }}
                                        </span>
                                        <span class="color-blue fw-bold">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ \Carbon\Carbon::parse($trainingData->date)->format('d-m-Y') ?? '-' }} to {{ \Carbon\Carbon::parse($trainingData->end_date)->format('d-m-Y') ?? '-' }}
                                        </span>
                                        <span class="color-blue fw-bold">
                                            <i class="bi bi-clock"></i>
                                            {{ $trainingData->time ?? '-' }}
                                        </span>
                                        {{-- <span class="fw-bold color-orange">
                                            <i class="bi bi-currency-rupee"></i>
                                            {{ number_format($trainingData->fees, 2, '.', ',') }}
                                        </span> --}}
                                        {{-- @if (!empty($trainingData->meetingLink))
                                            <span class="fw-bold text-primary">
                                                <i class="bi bi-link-45deg"></i>
                                                <a href="{{ $trainingData->meetingLink }}" target="_blank">Meeting Link</a>
                                            </span>
                                        @endif --}}
                                    </div>
                                </div>

                                <div class="event-footer d-flex justify-content-between align-items-center mt-3">
                                    @if ($trainingData->fees == 0)
                                        <div class="price fw-bold color-orange">Free</div>
                                    @else
                                        <div class="price fw-bold color-orange">₹ {{ $trainingData->fees ?? '0' }}</div>
                                    @endif
                                    {{-- <a href="{{ route('trainingFeedback.create', $trainingData->id) }}" class="btn btn-bg-blue btn-sm">
                                        <i class="bi bi-plus"></i> Add Feedback
                                    </a> --}}

                                    {{-- <button type="button" class="btn btn-bg-orange btn-md razorpayBtnEvent" data-amount-event="{{ $trainingData->fees }}" data-event-id="{{ $trainingData->id }}">
                                        Join Now
                                    </button> --}}

                                    <div class="d-flex justify-content-between">
                                        <div class="text-end">
                                            @if (!in_array($trainingData->id, $registeredTrainingIds))
                                                @if ($trainingData->fees == 0)
                                                    <a href="{{ route('training.register') }}/{{ $trainingData->id }}" class="btn btn-bg-orange">Register Now</a>
                                                @else
                                                    <button type="button" class="btn btn-bg-blue pay" data-training-id="{{ $trainingData->id }}">
                                                        Register & Pay Now
                                                    </button>
                                                @endif
                                            @else
                                                <button type="button" disabled class="btn btn-bg-orange">Already Registered</button>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-end mt-4">
                {!! $trainings->links() !!}
            </div> --}}
        @else
            <div class="row">
                <h3 style="color: #1d3268;">Trainings</h3>
                <hr>
            </div>
            <div class="text-center">
                <h3 style="color:#1d3268;">No training found for now</h3>
            </div>
        @endif
    </div>


    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var payButtons = document.querySelectorAll('.pay');

            payButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    var card = e.target.closest('.event-card');
                    var trainingId = button.getAttribute('data-training-id');

                    var amountElement = card ? card.querySelector('.price') : null;
                    var amountText = amountElement ? amountElement.textContent.trim() : '0';
                    var parsedAmount = parseInt(amountText.replace(/[^\d]/g, '')) || 0;

                    // If training is free (fees == 0), register directly without opening Razorpay
                    if (parsedAmount <= 0) {
                        window.location.href = "{{ route('training.register') }}/" + trainingId;
                        return;
                    }

                    var amount = parsedAmount * 100;

                    console.log('Amount:', amount);
                    console.log('Training ID:', trainingId);

                    var razorpayKey = "{{ env('RAZORPAY_KEY') }}";

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

                    var options = {
                        key: razorpayKey,
                        amount: amount,
                        currency: "INR",
                        name: "UBN",
                        description: "Training Payment",
                        image: "/img/logo.png",
                        handler: function(response) {
                            storePaymentId(response.razorpay_payment_id, amount, trainingId);
                        },
                        prefill: {
                            name: username,
                            email: useremail
                        },
                        theme: {
                            color: "#012e6f"
                        }
                    };

                    var rzp = new Razorpay(options);
                    rzp.open();
                });
            });
        });

        function storePaymentId(paymentId = '', amount = '', trainingId = '') {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = `{{ route('razorpay.payment.store') }}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        paymentId: paymentId,
                        amount: amount,
                        trainingId: trainingId,
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
                    console.error('Error storing payment ID: ', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to store payment ID',
                    });
                });
        }
    </script>


@endsection
