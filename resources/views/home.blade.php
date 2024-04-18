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
                <div class="col-md-9">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="card-title"><b>Upcoming Circle Meetings</b></div>
                        </div>

                        <div class="col-md-12">
                            <div class="card border-0 shadow workshopCard">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4 class="card-title">{{ $meeting->circle->circleName }}
                                                        <span class="text-muted">( {{ $meeting->circle->city->cityName }} )</span>
                                                    </h4>

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


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
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
                </div>
                <div class="col-md-3">
                    <div class="col-md-12">
                        <div class="card-title"><b>Invite peoples to join</b></div>
                    </div>
                    <div class="card border-0 shadow workshopCard">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="">
                                        <ul class="list-group list-group-flush">

                                            <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                Invite
                                            </button>
                                            <li class="list-group-item text-center fw-bold">My Invites</li>
                                            @foreach ($myInvites as $invite)
                                                <li class="list-group-item">
                                                    {{ $invite->personName }}
                                                    <br>
                                                    <small class="text-muted">{{ $invite->personEmail }}</small>
                                                </li>
                                            @endforeach

                                        </ul>
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



    {{-- Testimonial --}}
    @if (count($testimonials) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card-title"><b>Testimonials</b></div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    @foreach ($testimonials as $testimonial)
                        <div class="col-md-4">
                            <div class="card" style="border-radius: 10px;height:250px;">

                                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                    {{-- {{asset('/')}} --}}
                                    <img src="{{ asset('ProfilePhoto/' . $testimonial->member->profilePhoto) }}" alt="Profile" class="rounded-circle border-4 border" style="height: 100px;width:100px;">
                                    <h3>{{ $testimonial->user->firstName . ' ' . $testimonial->user->lastName }}</h3>
                                    <h6 class="text-center text-muted text-truncate" style="width:300px;"><i class="bi bi-quote" style="font-size: 30px;"></i>{{ $testimonial->message }}dddddddddddddddddddd ddddddddddddddd</h6>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {{-- end testimonial --}}

    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    </div>


    {{-- invite person modal  --}}
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Person Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registrationForm" action="{{ route('invite.person') }}" method="POST">
                        @csrf
                        <input type="hidden" name="meetingId" id="meetingId" value="{{ $meeting->id }}">
                        <div class="mb-3">
                            <label for="personName" class="form-label">Name</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="personName" id="personName">
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="mb-3">
                            <label for="personEmail" class="form-label">Email address</label><span class="text-danger">*</span>
                            <input type="email" class="form-control" name="personEmail" id="personEmail" aria-describedby="emailHelp">
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="mb-3">
                            <label for="personContact" class="form-label">Contact Number</label><span class="text-danger">*</span>
                            <input type="tel" class="form-control" name="personContact" id="personContact" pattern="[0-9]{10}">
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="mb-3">
                            <label for="personBusiness" class="form-label">Business Category</label><span class="text-danger">*</span>
                            <select name="  businessCategoryId" class="form-select" id="personBusiness">
                                <option value="" disabled selected>--Select Business Category--</option>
                                @foreach ($businessCategory as $category)
                                    <option value="{{ $category->id }}"><img src="{{ asset('BusinessCategory') }}/{{ $category->image }}" alt=""> {{ $category->categoryName }}</option>
                                @endforeach
                            </select>
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    </script>

    {{-- validation --}}
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var isValid = true; // Flag to track overall form validity

                // Reset error messages
                $('.error-message').text('');

                // Validate each input field and select element
                $('#registrationForm input, #registrationForm select').each(function() {
                    var input = $(this);
                    var errorSpan = input.next('.error-message');
                    var value = input.val().trim(); // Trim value before validation

                    // Check if field is empty
                    if (value === '') {
                        errorSpan.text('This field is required.');
                        isValid = false; // Set flag to false if any field is invalid
                    }

                    // Additional validation for specific fields
                    if (input.attr('name') === 'personEmail' && !isValidEmail(value)) {
                        errorSpan.text('Please enter a valid email address.');
                        isValid = false;
                    }

                    // You can add more specific validation rules for other fields here
                });

                // Validate dropdown (select) element
                var selectElement = $('#personBusiness');
                var selectErrorSpan = selectElement.next('.error-message');
                if (selectElement.val() === null || selectElement.val() === '') {
                    selectErrorSpan.text('Please select a business category.');
                    isValid = false;
                }

                // If form is valid, submit the form
                if (isValid) {
                    this.submit();
                }
            });
        });

        // Function to check if email is valid
        function isValidEmail(email) {
            // This regex checks for a basic email format
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

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
