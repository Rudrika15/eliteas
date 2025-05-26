<div class="row mt-3">
    <div class="col-md-12">
        <div class="card-title"><b>Upcoming Training Workshops</b></div>
        <div class="card border-0 shadow workshopCard">
            {{-- {{$nearestTraining}} --}}
            @if ($nearestTraining)
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10">
                            <h4 class="card-title">{{ $nearestTraining->title }}</h4>
                            @if ($nearestTraining->venue)
                                <b>Venue:</b> {{ $nearestTraining->venue }}
                            @endif
                        </div>

                        <div class="col-md-2 pt-3 text-muted text-end">
                            <b>Start Date : </b> {{ \Carbon\Carbon::parse($nearestTraining->date)->format('j M Y') }}
                            <b>End Date : </b> {{ \Carbon\Carbon::parse($nearestTraining->end_date)->format('j M Y') }}
                            <br>
                            <b>Time :</b> {{ $nearestTraining->time }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-4">
                            <p class="text-muted"><strong>Trainer Details:</strong><br>
                                <small class="fw-italic text-muted pt-2 fw-italic">

                                    @foreach ($nearestTraining->trainers as $user)
                                        <input type="hidden" value="{{ $user->user->id }}" name="trainerId" class="trainerId">
                                        <input type="hidden" value="{{ $nearestTraining->id }}" name="trainingId" class="trainingId">
                                        {{ $user->user->firstName }}
                                        {{ $user->user->lastName }}
                                        <br>
                                    @endforeach


                                </small>
                                <br>
                                <small class="text-muted">
                                    {{ $nearestTraining->trainersTrainings->externalMemberBio ?? '' }}
                                </small>
                            </p>
                        </div>
                        <div class="col-md-4">
                            @if (count($findRegister) == 0)
                                @if ($nearestTraining->fees == 0)
                                    <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                                    <button type="button" class="btn btn-bg-orange btn-md" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        Register
                                    </button>
                                @else
                                    <h5 class="text-muted text-end me-4 pt-3"> ₹
                                        {{ $nearestTraining->fees }}
                                    </h5>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-bg-orange btn-md " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Join Now
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="d-flex justify-content-end">
                                    <div class="ps-5 ms-5 mt-5">
                                        <strong> <span class="text-success">Already Joined</span> </strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <p class="mt-3 text-muted text-center"> <b> No Training Workshop for now. </b></p>
        </div>
    </div>
</div>
@endif
</div>


@if ($nearestTraining)
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Join {{ $nearestTraining->title }}
                        Training
                    </h5>
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
                            <h6>
                                {{ \Carbon\Carbon::parse($nearestTraining->date)->format('j M Y') }}
                            </h6>
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
                                    <a href="{{ route('training.register') }}/{{ $nearestTraining->id }}/{{ $nearestTraining->trainersTrainings->user->id }}" class="btn btn-primary">Register Now</a>
                                @else
                                    <button type="button" class="btn btn-bg-blue pay">Pay Now</button>
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
@endif


{{-- invite person modal --}}
<!-- Button trigger modal -->


<!-- Modal -->
{{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Person Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registrationForm" action="{{ route('invite.person') }}" method="POST">
                    @csrf
                    @if (!auth()->user()->hasRole('Admin'))
                        <input type="hidden" name="meetingId" id="meetingId" value="{{ $meeting->id }}">
                        <div class="mb-3">
                            <label for="personName" class="form-label">Name</label>
                            <input type="text" class="form-control" name="personName" id="personName" required>
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="mb-3">
                            <label for="personEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" name="personEmail" id="personEmail" aria-describedby="emailHelp" required>
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="mb-3">
                            <label for="personContact" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" name="personContact" id="personContact" pattern="[0-9]{10}" maxlength="10" oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" required>
                            <span class="error-message text-danger" id="phoneError" style="display:none;">
                                Please enter correct number
                            </span> <!-- Error message placeholder -->
                        </div>

                        <script>
                            document.getElementById("personContact").addEventListener("input", function(e) {
                                var x = document.getElementById("personContact").value;
                                if (x.length == 10) {
                                    document.getElementById("phoneError").style.display = "none";
                                } else {
                                    document.getElementById("phoneError").style.display = "block";
                                }
                            });
                        </script>
                        <div class="mb-3">
                            <label for="personBusiness" class="form-label">Business Category</label>
                            <select name="  businessCategoryId" class="form-select" id="personBusiness" required>
                                <option value="" disabled selected>--Select Business Category--</option>
                                @foreach ($businessCategory as $category)
                                    <option value="{{ $category->id }}"><img src="{{ asset('BusinessCategory') }}/{{ $category->image }}" alt=""> {{ $category->categoryName }}</option>
                                @endforeach
                            </select>
                            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-bg-blue">Submit</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
{{-- @endif --}}



<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all elements with the 'pay-button' class
        var payButtons = document.querySelectorAll('.pay');
        console.log('pay buttons', payButtons);

        // Loop through each pay button and attach the click event handler
        payButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {

                var amountElement = document.querySelector('.amount');
                var amountText = amountElement ? amountElement.textContent.trim() : '';
                var amount = parseInt(amountText.replace('₹', '').trim()) * 100;

                console.log('amount:', amount);

                var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                // var razorpayKey = "rzp_test_VVNmvqg0nEoaOf";
                console.log('Razorpay Key:', razorpayKey);

                // Ensure that the Razorpay key is available
                if (!razorpayKey) {
                    console.error('Razorpay key is missing.');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Payment configuration error. Please contact support.',
                    });
                    return;
                }

                var username = "{{ Auth::user()->name }}";
                var useremail = "{{ Auth::user()->email }}";
                console.log('username:', username);
                console.log('useremail:', useremail);

                var options = {
                    "key": razorpayKey,
                    "amount": amount,
                    "currency": "INR",
                    "name": "UBN",
                    "description": "Razorpay payment",
                    "image": "/img/logo.png",
                    "handler": function(response) {
                        // Handle the response after payment
                        console.log('Payment response:', response);
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
        var trainingId = $('.trainingId').val();
        // var trainingId2 =
        // var trainerId = '{{ $nearestTraining->trainersTrainings[0]->user ?? '-' }}';

        console.log('my training id:', trainingId);
        // console.log('trainerId:', trainerId);

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
                    // trainerId: trainerId
                }),
            })
            .then(response => {
                // Handle the response from the server
                console.log('Payment ID stored successfully');
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
