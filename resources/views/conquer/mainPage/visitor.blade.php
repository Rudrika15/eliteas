<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Visitor Form</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" />
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet" />

    <!-- Additional CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <style>
        /* body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background-image:
                url("https://i.imgur.com/GMmCQHC.png");
            background-repeat: no-repeat;
            background-size: 100% 100%
        } */

        .card {
            padding: 30px 40px;
            margin-top: 10px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
        }


        .form-control-label {
            margin-bottom: 0
        }

        input,
        textarea,
        button {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 12px !important;
            font-weight: 20
        }

        /* input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #00BCD4;
            outline-width: 0;
            font-weight:
                200
        } */



        /* button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0
        } */
    </style>




</head>

<body>

    <main>
        <div class="container-fluid px-1 py-5 mx-auto">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="#" class="main-logo d-flex align-items-center">
                            <img src="{{ asset('img/logo2.jpg') }}" alt=""
                                style="background-color: #F5E9E2; mix-blend-mode: multiply; width: 150px; height:100px;">
                            {{-- <span class="d-none d-lg-block">Elite</span> --}}
                        </a>
                    </div><!-- End Logo -->
                    <div class="card p-3" style="border-radius: 10px; background-color: rgba(255, 255, 255, 0.699);">
                        {{-- <div class="card p-3" style="border-radius: 10px;"> --}}
                            {{-- <div class="card"> --}}

                                @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">
                                                {{-- <i class="fa fa-times"></i> --}}
                                            </button>
                                            <strong>Success !</strong> {{ session('success') }}
                                        </div>
                                        <script>
                                            setTimeout(function() {
                                            $('#success-alert').fadeOut('fast');
                                        }, 5000); // <-- time in milliseconds
                                        </script>
                                        @endif

                                        @if (Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible" role="alert" id="error-alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                        {{-- <i class="fa fa-times"></i> --}}
                                                    </button>
                                                    <strong>Error !</strong> {{ session('error') }}
                                                </div>
                                                <script>
                                                    setTimeout(function() {
                                            $('#error-alert').fadeOut('fast');
                                        }, 5000); // <-- time in milliseconds
                                                </script>
                                                @endif



                                                <h5 class="text-center mb-4" style="color: #1d3268;"><b>Visitor
                                                        Registration Form</b></h5>
                                                {{-- <h5 class="text-center mb-4">Please Fill the Form</h5> --}}
                                                <form method="POST" action="{{ route('conquer.visitor.form.store') }}"
                                                    class="needs-validation w-100 form-card" id="visitorForm"
                                                    name="visitorForm" novalidate>
                                                    @csrf

                                                    <input type="hidden" name="eventId" value="{{ $event->id }}">

                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">First name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="firstName" name="firstName"
                                                                value="{{ old('firstName') }}"
                                                                class="form-control @error('firstName') is-invalid @enderror"
                                                                required>
                                                            @error('firstName')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Last name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="lastName" name="lastName"
                                                                value="{{ old('lastName') }}"
                                                                class="form-control @error('lastName') is-invalid @enderror"
                                                                required>
                                                            @error('lastName')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Mobile No<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="mobileNo" name="mobileNo"
                                                                value="{{ old('mobileNo') }}"
                                                                class="form-control @error('mobileNo') is-invalid @enderror"
                                                                oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                                                required>
                                                            @error('mobileNo')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Email<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="email" id="email" name="email"
                                                                value="{{ old('email') }}"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                required>
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>Please enter a valid email address</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Birth Date<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="date" id="birthDate" name="birthDate"
                                                                class="form-control @error('birthDate') is-invalid @enderror"
                                                                required>
                                                            @error('birthDate')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Gender<span
                                                                    class="text-danger">*</span></label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender" id="male" value="male" required>
                                                                <label class="form-check-label" for="male">Male</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="gender" id="female" value="female" required>
                                                                <label class="form-check-label"
                                                                    for="female">Female</label>
                                                            </div>
                                                            @error('gender')
                                                            <div class="invalid-tooltip">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Business
                                                                Category<span class="text-danger">*</span></label>
                                                            <select id="businessCategory" name="businessCategory"
                                                                class="form-select" required>
                                                                <option value="" disabled selected>Select Business
                                                                    Category</option>
                                                                @foreach ($businessCategory as $businessCategoryData)
                                                                <option value="{{ $businessCategoryData->id }}" {{
                                                                    old('businessCategory')==$businessCategoryData->id ?
                                                                    'selected' : '' }}>
                                                                    {{ $businessCategoryData->categoryName }}
                                                                </option>
                                                                @endforeach
                                                                <option value="other" {{
                                                                    old('businessCategory')=='other' ? 'selected' : ''
                                                                    }}>Other</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    @php
                                                    $eventId = \App\Models\Event::find($event->id);
                                                    $eventFees = $event ? $event->visitorFees : 0;

                                                    @endphp




                                                    <input type="hidden" id="eventFees" name="eventFees"
                                                        value="{{ $event->visitorFees }}">
                                                    <input type="hidden" id="eventId" name="eventId"
                                                        value="{{ $event->id }}">


                                                    @if ($eventFees == 0 || is_null($eventFees))
                                                    <button type="submit" class="btn btn-success">
                                                        Register
                                                    </button>
                                                    <button type="submit" class="btn btn-success d-none" id="payNowMeet"
                                                        disabled>
                                                        Pay Now ₹ {{ $eventFees }}
                                                    </button>
                                                    @else
                                                    <button type="submit" class="btn btn-success d-none">
                                                        Register
                                                    </button>
                                                    <button type="submit" class="btn btn-success" id="payNowMeet"
                                                        disabled>
                                                        Pay Now ₹ {{ $eventFees }}
                                                    </button>
                                                    @endif

                                                    <!-- Coupon Code Modal -->
                                                    <div class="modal fade" id="couponModal" tabindex="-1"
                                                        aria-labelledby="couponModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="couponModalLabel">Enter
                                                                        Coupon Code</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="text" id="couponCode"
                                                                        class="form-control"
                                                                        placeholder="Enter your coupon code">
                                                                    <div id="couponMessage" class="mt-3"></div>
                                                                    <!-- For displaying coupon status -->
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" id="applyCoupon"
                                                                        class="btn btn-primary">Apply</button>
                                                                    <button type="button" id="proceedWithCoupon"
                                                                        class="btn btn-success d-none">Pay with
                                                                        Discount</button>
                                                                    <button type="button" id="proceedWithoutCoupon"
                                                                        class="btn btn-secondary">Pay Original
                                                                        Amount ₹{{ $eventFees }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                </form>

                                        </div>
                                </div>
                            </div>
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

    <!-- Additional JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('visitorForm');
            const button = document.getElementById('payNowMeet');

            // Function to toggle button state
            const toggleButtonState = () => {
                console.log('Checking form validity...');
                console.log('Form valid:', form.checkValidity());
                button.disabled = !form.checkValidity(); // Enable button only if form is valid
                console.log('Button enabled:', !button.disabled);
            };

            // Check form state on input and change events
            form.addEventListener('input', toggleButtonState);
            form.addEventListener('change', toggleButtonState);

            // Ensure button state is set correctly on page load
            toggleButtonState();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const payNowBtn = document.getElementById('payNowMeet');

    payNowBtn.addEventListener('click', function (event) {
    event.preventDefault();

    // Show coupon modal
    const couponModal = new bootstrap.Modal(document.getElementById('couponModal'));
    couponModal.show();

    // Element references
    const couponCodeInput = document.getElementById('couponCode');
    const couponMessage = document.getElementById('couponMessage');
    const applyCouponBtn = document.getElementById('applyCoupon');
    const proceedWithCouponBtn = document.getElementById('proceedWithCoupon');
    const proceedWithoutCouponBtn = document.getElementById('proceedWithoutCoupon');

    let discountedAmount = null; // To store discounted amount
    const originalAmount = parseInt(document.getElementById('eventFees').value) * 100; // Convert to paise

    applyCouponBtn.addEventListener('click', function () {
    const couponCode = couponCodeInput.value;
    const eventId = document.getElementById('eventId').value;

    fetch('{{ route("visitor.validateCouponCode") }}', {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ couponCode, eventId })
    })
    .then(response => response.json())
    .then(data => {
    if (data.success) {
    discountedAmount = (originalAmount / 100 - data.discount) * 100; // Convert back to paise
    couponMessage.innerHTML = `<div class="alert alert-success"> <br>
    Total Amount is: ₹${originalAmount / 100} <br>  Coupon applied successfully! You get a discount of
        ₹${data.discount}. Total payable amount: ₹${discountedAmount / 100}.</div>`;
    proceedWithCouponBtn.classList.remove('d-none'); // Show the discounted payment option
    proceedWithoutCouponBtn.classList.add('d-none'); // Hide the original payment option

    proceedWithCouponBtn.innerText = `Pay with Discount ₹${discountedAmount / 100}`;

    } else {
    couponMessage.innerHTML = `<div class="alert alert-danger">Invalid or expired coupon code. Please try again.</div>`;
    }
    })
    .catch(error => {
    console.error('Error validating coupon:', error);
    couponMessage.innerHTML = `<div class="alert alert-danger">Failed to validate the coupon code. Please try again.
    </div>`;
    });
    });

    proceedWithCouponBtn.addEventListener('click', function () {
    couponModal.hide();
    proceedToPayment(discountedAmount);
    });

    proceedWithoutCouponBtn.addEventListener('click', function () {
    couponModal.hide();
    proceedToPayment(originalAmount);
    });
    });

    function proceedToPayment(amount) {
    const razorpayKey = "{{ env('RAZORPAY_KEY') }}";
    const formData = new FormData(document.getElementById('visitorForm'));

    const options = {
    key: razorpayKey,
    amount: amount,
    currency: "INR",
    name: "UBN Event",
    description: "Event Payment",
    image: "/img/logo.png",
    handler: function (response) {
    storePaymentDetails(response.razorpay_payment_id, amount, formData);
    },
    theme: { color: "#F37254" }
    };

    const rzp = new Razorpay(options);
    rzp.open();
    }

    function storePaymentDetails(paymentId, amount, formData) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = `{{ route('conquer.visitor.form.store') }}`;

    formData.append('paymentId', paymentId);
    formData.append('amount', amount);

    fetch(url, {
    method: 'POST',
    headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(Object.fromEntries(formData))
    })
    .then(response => response.json())
    .then(data => {
    if (data.success) {
    Swal.fire({ icon: 'success', title: 'Payment Successful', text: 'Thank you for your payment!' });
    setTimeout(() => {
    window.location.replace("{{ route('main.event.thankYouUser') }}");
    }, 3000);
    } else {
    Swal.fire({ icon: 'error', title: 'Error', text: 'Payment succeeded but failed to store details.' });
    }
    })
    .catch(error => {
    Swal.fire({ icon: 'error', title: 'Error', text: 'Error storing payment details: ' + error.message });
    });
    }
    });
    </script>






</body>

</html>
