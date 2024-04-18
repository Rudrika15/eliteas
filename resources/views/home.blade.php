@extends('layouts.master')

@section('content')
    <div class="container">
        <style>
            .workshopCard {
                position: relative;
            }

            .workshopCard::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border-top: 2px solid transparent;
                border-bottom: 2px solid transparent;
                border-left: 2px solid #007bff;
                /* Left border */
                border-right: 2px solid #007bff;
                /* Right border */
                z-index: 1;
                transition: box-shadow 0.3s ease-in-out;
                /* Add transition for smooth effect */
            }

            .workshopCard:hover::before {
                box-shadow: 0 0 20px rgba(88, 168, 253, 0.4);
                /* Shadow effect on hover */
            }

            .workshopCard .card-body {
                position: relative;
                z-index: 2;
            }
        </style>

        @role('Member')
            <div class="row">
                <div class="col-md-12">
                    <div class="card-title"><b>Upcoming Circle Meetings</b></div>
                </div>
                {{ $meeting }}
                <div class="col-md-6">
                    <div class="card border-0 shadow workshopCard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="card-title">{{ $meeting->circle->circleName }}</h4>
                                            <span class="text-muted">( {{ $meeting->circle->city->cityName }} )</span>
                                        </div>
                                        <div class="col-md-6 pt-3 text-muted text-end">
                                            {{ $meeting->date }} <br>
                                            {{ $meeting->meetingTime }}
                                        </div>
                                    </div>
                                    <p>
                                        <small class="fw-italic text-muted pt-2 fw-italic">
                                            Total Members : {{ $meeting->circle->members->count() }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            Franchise Name : {{ $meeting->circle->franchise->franchiseName }}
                                        </small>
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="">



                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-title"><b>Upcoming Traning Workshops</b></div>
                </div>
                <div class="col-md-12">
                    <div class="card border-0 shadow workshopCard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title">{{ $nearestTraining->title }}</h4>
                                    <p>
                                        <small class="fw-italic text-muted pt-2 fw-italic">
                                            {{ $nearestTraining->trainers->user->firstName }}
                                            {{ $nearestTraining->trainers->user->lastName }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            {{ $nearestTraining->trainers->user->email }}
                                        </small>
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="">

                                        @if ($nearestTraining->fees == 0)
                                            <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                                            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Register
                                            </button>
                                        @else
                                            <h5 class="text-muted text-end me-4 pt-5"> ₹ {{ $nearestTraining->fees }}</h5>
                                            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Join Now
                                            </button>
                                        @endif

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endrole



        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    @role('Admin')
                        <div class="card-header"><b>Upcoming Circle Meetings</b></div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            {{-- <h2>{{ $count }}</h2> --}}
                            <a href="{{ route('schedule.dashIndex') }}">View Details</a>

                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>



    {{-- Testimonial
    @if(count($testimonials)>0)

    <div class="row">
        <div class="col-md-12">
            <div class="card-title"><b>Testimonials</b></div>
        </div>
        <div class="col-md-12">
            <div class="row">
                @foreach($testimonials as $testimonial)
                <div class="col-md-4">
                    <div class="card" style="border-radius: 10px;height:250px;">

                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                                <img src="{{asset('ProfilePhoto/'.$testimonial->member->profilePhoto)}}" alt="Profile" class="rounded-circle border-4 border" style="height: 100px;width:100px;">
                                <h3>{{$testimonial->user->firstName . " " . $testimonial->user->lastName}}</h3>
                                <h6 class="text-center text-muted text-truncate" style="width:300px;"><i class="bi bi-quote" style="font-size: 30px;"></i>{{$testimonial->message}}dddddddddddddddddddd ddddddddddddddd</h6>
                            </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif --}}
    {{-- end testimonial --}}

    <!-- Button trigger modal -->


    <!-- Modal -->
    {{-- <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Join {{ $nearestTraining->title }} Training</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 text-start">
                            <p class="text-muted">
                                <small>{{ $nearestTraining->venue }}</small>
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6 class="card-subtitle mt-2 text-muted ">{{ $nearestTraining->date }}</h6>
                            <small class="text-muted">{{ $nearestTraining->time }}</small>
                        </div>
                    </div>
                </div>
                <style>
                    .modal-footers {
                        /* display: flex; */
                        */ flex-shrink: 0;
                        /* flex-wrap: wrap; */
                        align-items: center;
                        padding: calc(var(--bs-modal-padding) - var(--bs-modal-footer-gap)* .5);
                        background-color: var(--bs-modal-footer-bg);
                        border-top: var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);
                        border-bottom-right-radius: var(--bs-modal-inner-border-radius);
                        border-bottom-left-radius: var(--bs-modal-inner-border-radius);

                    }
                </style>
                <div class="modal-footers">
                    <div class="d-flex justify-content-between">

                        <div class="text-start">
                            @if ($nearestTraining->fees == 0)
                                <h5 class="text-muted text-center">Free</h5>
                            @else
                                <h5 class="text-muted text-center amount"> ₹ {{ $nearestTraining->fees }}</h5>
                            @endif
                        </div>
                        <div class="">
                            @if (count($findRegister) == 0)
                                @if ($nearestTraining->fees == 0)
                                    <a href="{{ route('training.register') }}/{{ $nearestTraining->id }}/{{ $nearestTraining->trainers->user->id }}" class="btn btn-primary">Register Now</a>
                                @else
                                    <button type="button" class="btn btn-primary pay">Pay Now</button>
                                @endif
                            @else
                                <span class="text-muted">Already Registered</span>
                            @endif
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the 'pay-button' class
            var payButtons = document.querySelectorAll('.pay');
            console.log('pay', payButtons);
            // Loop through each pay button and attach the click event handler
            payButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {

                    var amountElement = document.querySelector('.amount');
                    var amountText = amountElement.textContent.trim();
                    var amount = parseInt(amountText.replace('₹', '').trim()) * 100;

                    console.log('amount', amount);
                    console.log('pay button', payButtons);

                    username = "{{ Auth::user()->name }}";
                    useremail = "{{ Auth::user()->email }}";
                    console.log('username', username);

                    var options = {
                        "key": "{{ env('RAZORPAY_KEY') }}",
                        "amount": amount,
                        "currency": "INR",
                        "name": "Brandbeans",
                        "description": "Razorpay payment",
                        "image": "/images/logo-icon.png",
                        "handler": function(response) {
                            // Handle the response after payment
                            console.log(response);
                            var paymentId = response.razorpay_payment_id;
                            storePaymentId(paymentId, amount);
                        },
                        "prefill": {
                            "name": username,
                            "email": useremail
                        },
                        "theme": {
                            "color": "#012e6f"
                        }
                    };

                    var rzp = new Razorpay(options);
                    rzp.open();
                });
            });
        });

        function storePaymentId(paymentId = '', amount = '') {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = `{{ route('razorpay.payment.store') }}`;
            var trainingId = '{{ $nearestTraining->id }}';
            var trainerId = '{{ $nearestTraining->trainers->user->id }}';
            console.log('trainingId', trainingId);
            console.log('trainerId', trainerId);
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
                        trainerId: trainerId
                    }),
                })
                .then(response => {
                    // Handle the response from the server
                    console.log('Payment ID stored successfully');
                    // Display SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payment ID stored successfully',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error storing payment ID: ', error);
                    // Display SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to store payment ID',
                    });
                });
        }
    </script> --}}

    <!-- sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- end -->

    @if (Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: true,

            });
        </script>
    @endif

    @if (Session::get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: true,
            });
        </script>
    @endif
@endsection
