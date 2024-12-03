<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" />
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet" />


    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->




</head>

<body>

    <main>
        <div class="">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container res-box">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="main-logo d-flex align-items-center">
                                    <img src="{{ asset('img/logo2.jpg') }}" alt=""
                                        style="background-color: #F5E9E2; mix-blend-mode: multiply; width: 150px; height:100px;">
                                    {{-- <span class="d-none d-lg-block">Elite</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3 res-box" style="width: 20rem; border: 1px solid #1d3268;">
                                {{-- <div class=" card mb-3 res-box"
                                    style="width: 20rem; background-image: url({{ asset('img/b2.jpg') }});"> --}}
                                    <div class="card-body">
                                        <h5 class="card-title text-center pb-0 fs-4 mb-4" style="color: #1d3268;">Login
                                        </h5>


                                        @if (session('message'))
                                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                            {{ session('message') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @endif

                                        {{-- <form method="POST" action="{{ route('conEventLogin') }}" --}} <form
                                            method="POST" action="{{ route('conquer.event.user.login') }}"
                                            class="needs-validation w-100" novalidate id="login-form" name="loginForm">
                                            @csrf

                                            <!-- Email Input -->
                                            <div class="mb-3 form-floating">
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email" autofocus>
                                                <label for="email"><b>Email Address</b></label>
                                                @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <!-- Password Input -->
                                            <div class="mb-3 form-floating">
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">
                                                <label for="password"><b>Password</b></label>
                                                @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            @php
                                            $eventId = \App\Models\Event::find($event->id);
                                            $eventFees = $event ? $event->fees : 0;
                                            $eventName = $event ? $event->title : '';
                                            // print('eventId: ' . $eventId->id . ', eventFees: ' . $eventFees);
                                            @endphp

                                            <input type="hidden" id="eventFees" name="eventFees"
                                                value="{{ $event->fees }}">
                                            <input type="hidden" id="eventId" name="eventId" value="{{ $event->id }}">

                                            @if (session('message'))
                                            <div class="alert alert-warning">
                                                {{ session('message') }}
                                            </div>
                                            @endif

                                            @if ($eventFees > 0)
                                            <div class="d-flex justify-content-center razorpayBtnEvent">
                                                <button type="button" class="btn btn-bg-orange me-2" id="payNowMeet"
                                                    onclick="checkRegistration()">
                                                    Pay ₹ {{ $eventFees }} & Register
                                                </button>
                                            </div>
                                            @else
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn"
                                                    style="background-color: #1d3268; color: white;" id="payNowMeet">
                                                    Register
                                                </button>
                                            </div>
                                            @endif


                                            <!-- Modal for Coupon Code -->
                                            <!-- Modal for Coupon Code -->
                                            <div class="modal fade" id="couponModal" tabindex="-1"
                                                aria-labelledby="couponModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="couponModalLabel">Enter Coupon
                                                                Code</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="text" class="form-control" id="couponCode"
                                                                placeholder="Enter coupon code">
                                                            <span id="couponError" class="text-danger d-none">Invalid
                                                                coupon code or expired.</span>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                id="applyCouponBtn">Apply Coupon</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal" id="noCouponBtn">Proceed without
                                                                Coupon</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <script>
                                                function checkRegistration() {
    // Check if the user is already registered before proceeding to the payment page
    let registrationStatus = @json(session('message')); // Passing backend message to JS
    if (registrationStatus) {
        alert(registrationStatus); // Show registration status message
        return false;
    } else {
        // Proceed to payment if not registered
        // You can add further payment gateway logic here
    }
}
                                            </script>

                                            @if (Route::has('password.request'))
                                            <div class="mt-3 text-center">
                                                <a href="{{ route('forget.password.get') }}" class=""
                                                    style="color: #1d3268; font-weight: bold;">Forgot Your Password?</a>
                                            </div>
                                            @endif
                                        </form>


                                    </div>
                                </div>

                                <div class="credits">
                                    Designed by <a href="https://www.aspireotech.com/" target="_blank"
                                        class="text-black"><b>Aspireotech
                                            Solutions</b></a>
                                </div>

                            </div>
                        </div>
                    </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const payNowButton = document.getElementById('payNowMeet');
            const registerNowButton = document.getElementById('registerNowMeet');

            // Function to toggle button state based on input fields
            function toggleButtonState() {
                const isEmailFilled = emailInput.value.trim() !== '';
                const isPasswordFilled = passwordInput.value.trim() !== '';

                // Enable button if both fields are filled, otherwise disable it
                if (payNowButton) {
                    payNowButton.disabled = !(isEmailFilled && isPasswordFilled);
                }

                if (registerNowButton) {
                    registerNowButton.disabled = !(isEmailFilled && isPasswordFilled);
                }
            }

            // Attach event listeners to inputs to check when they change
            emailInput.addEventListener('input', toggleButtonState);
            passwordInput.addEventListener('input', toggleButtonState);

            // Initialize button state on page load
            toggleButtonState();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const payNowBtn = document.getElementById('payNowMeet');

    payNowBtn.addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission

    // Get event details
    var eventId = document.getElementById('eventId').value;
    var email = document.getElementById('email').value;
    var eventFees = document.getElementById('eventFees').value;

    // Open the coupon modal
    var couponModal = new bootstrap.Modal(document.getElementById('couponModal'));
    couponModal.show();

    // Add coupon validation logic
    document.getElementById('applyCouponBtn').addEventListener('click', function() {
    var couponCode = document.getElementById('couponCode').value;

    // Check if coupon is valid
    fetch('/validate-coupon', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ couponCode: couponCode, eventId: eventId })
    })
    .then(response => response.json())
    .then(data => {
    if (data.success) {
    // Apply discount
    var discount = data.discount;
    var discountedAmount = eventFees - discount;
    openRazorpayPaymentPage(eventId, discountedAmount); // Proceed with discounted amount
    couponModal.hide(); // Close modal
    } else {
    // Show error if coupon is invalid
    document.getElementById('couponError').classList.remove('d-none');
    }
    })
    .catch(error => console.error('Error:', error));
    });

    // If no coupon is applied, proceed with original payment
    document.getElementById('noCouponBtn').addEventListener('click', function() {
    openRazorpayPaymentPage(eventId, eventFees);
    couponModal.hide(); // Close modal
    });
    });

    // Custom function to trigger Razorpay payment page
    function openRazorpayPaymentPage(eventId, eventFees) {
    var amount = parseInt(eventFees) * 100; // Convert to paise

    const razorpayKey = "{{ env('RAZORPAY_KEY') }}"; // Razorpay Key

    if (!razorpayKey) {
    Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'Razorpay key is missing. Please contact support.',
    });
    return;
    }

    const formData = new FormData(document.getElementById('login-form'));

    const options = {
    key: razorpayKey,
    amount: amount,
    currency: "INR",
    name: "UBN Event",
    description: "Event Payment for Event ID " + eventId,
    image: "/img/logo.png", // Your logo
    handler: function(response) {
    console.log('Payment successful, storing payment details');
    storePaymentDetails(response.razorpay_payment_id, amount, formData);
    },
    prefill: {
    name: document.getElementById('email').value,
    email: document.getElementById('email').value,
    },
    theme: {
    color: "#F37254"
    }
    };

    const rzp = new Razorpay(options);
    rzp.open();
    }

    // AJAX request to store payment details along with form data
    function storePaymentDetails(paymentId, amount, formData) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = `{{ route('conquer.event.user.login') }}`;

    const eventId = document.getElementById('eventId').value;
    if (!eventId) {
    console.error('Event ID not found.');
    Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'Event ID is missing. Please contact support.',
    });
    return;
    }

    // Add payment details to formData
    formData.append('paymentId', paymentId);
    formData.append('amount', amount);
    formData.append('eventId', eventId);

    // Convert formData to JSON object
    const formObject = {};
    formData.forEach((value, key) => {
    formObject[key] = value;
    });

    fetch(url, {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(formObject) // Send the form data as JSON
    })
    .then(response => {
    if (!response.ok) {
    return response.json().then(errorData => {
    throw new Error(errorData.error || 'Failed to store payment details.');
    });
    }
    return response.json();
    })
    .then(data => {
    if (data.success) {
    Swal.fire({
    icon: 'success',
    title: 'Success',
    text: 'Payment successful and details stored!',
    });
    setTimeout(function() {
    window.location.replace("{{ route('main.event.thankYouUser') }}");
    }, 3000);
    } else {
    Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'Payment was successful, but storing details failed.',
    });
    }
    })
    .catch(error => {
    console.error('Error:', error);
    Swal.fire({
    icon: 'error',
    title: 'Error',
    text: 'Error storing payment details: ' + error.message,
    });
    });
    }
    });
    </script>





</body>

</html>