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



                        <h5 class="text-center mb-4" style="color: #1d3268;"><b>Visitor Registration Form</b></h5>
                        {{-- <h5 class="text-center mb-4">Please Fill the Form</h5> --}}
                        <form method="POST" action="{{ route('visitor.form.store') }}"
                            class="needs-validation w-100 form-card" id="visitorForm" name="visitorForm" novalidate>
                            @csrf
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">First name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="firstName" name="firstName"
                                        value="{{ old('firstName') }}"
                                        class="form-control @error('firstName') is-invalid @enderror"
                                        onblur="validate(1)" required>
                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Last name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}"
                                        class="form-control @error('lastName') is-invalid @enderror"
                                        onblur="validate(2)" required>
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
                                        pattern="[0-9]{10}"
                                        oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');"
                                        oninput="this.setCustomValidity('')" onblur="validate(3)" required>
                                    @error('mobileNo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($errors->has('mobileNo') && $errors->first('mobileNo') == 'Please enter a valid 10-digit mobile number')
                                        <span class="invalid-feedback" role="alert" style="color: red;">
                                            <strong>{{ $errors->first('mobileNo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Business Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="businessName" name="businessName"
                                        value="{{ old('businessName') }}"
                                        class="form-control @error('businessName') is-invalid @enderror"
                                        onblur="validate(4)" required>
                                    @error('businessName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Business Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="businessCategory" name="businessCategory"
                                        class="form-control @error('businessCategory') is-invalid @enderror"
                                        onblur="validate(5)" required>
                                        <option value="" disabled selected>Select Business Category</option>
                                        @foreach ($businessCategory as $businessCategoryData)
                                            <option value="{{ $businessCategoryData->id }}"
                                                {{ old('businessCategory') == $businessCategoryData->id ? 'selected' : '' }}>
                                                {{ $businessCategoryData->categoryName }}
                                            </option>
                                        @endforeach
                                        <option value="other"
                                            {{ old('businessCategory') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>

                                    <!-- Input field for other category -->
                                    <div class="mt-3"></div>
                                    <input type="text" id="otherCategory" name="otherCategory"
                                        placeholder="Please specify your business category"
                                        class="form-control {{ old('businessCategory') == 'other' ? '' : 'd-none' }}"
                                        onblur="validate(5)" value="{{ old('otherCategory') }}">

                                    @error('businessCategory')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <script>
                                        const businessCategory = document.getElementById('businessCategory');
                                        const otherCategoryInput = document.getElementById('otherCategory');

                                        businessCategory.addEventListener('change', function() {
                                            if (this.value === 'other') {
                                                otherCategoryInput.classList.remove('d-none');
                                            } else {
                                                otherCategoryInput.classList.add('d-none');
                                                otherCategoryInput.value = ''; // Clear the input if it's hidden
                                            }
                                        });
                                    </script>
                                </div>

                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Invited by<span
                                            class="text-danger">*</span></label>

                                    @if (Auth::check())
                                        <!-- If the user is authenticated, show their name -->

                                        @php
                                            $meetingId = request()->query('meetingId'); // Get the 'ref' parameter from the URL
                                            $meeting = \App\Models\Schedule::find($meetingId);
                                            $circle = $meeting ? $meeting->circle : null;
                                            $city = $circle ? $circle->city : null;
                                            $cityAmount = $city ? $city->amount : 0;
                                        @endphp

                                        <input type="text" id="invitedBy" name="invitedBy"
                                            value="{{ Auth::user()->member->firstName }} {{ Auth::user()->member->lastName }}"
                                            class="form-control @error('invitedBy') is-invalid @enderror" disabled>
                                        <input type="hidden" id="invitedByHidden" name="invitedBy"
                                            value="{{ Auth::user()->member->id }}">
                                        <input type="hidden" id="meetingId" name="meetingId"
                                            value="{{ $meetingId ?? 0 }}">
                                        <input type="hidden" id="cityAmount" name="cityAmount"
                                            value="{{ $cityAmount }}">
                                    @else
                                        <!-- If the user is not authenticated, get the member ID from the URL -->
                                        @php
                                            $memberId = request()->query('ref'); // Get the 'ref' parameter from the URL
                                            $meetingId = request()->query('meetingId'); // Get the 'ref' parameter from the URL
                                            // You might want to fetch the member details based on this ID to show the name.
                                            $member = \App\Models\Member::find($memberId); // Fetch member from the database
                                        @endphp

                                        <input type="text" id="invitedBy" name="invitedBy"
                                            value="{{ $member ? $member->firstName . ' ' . $member->lastName : 'Invited by a member' }}"
                                            class="form-control" disabled>
                                        <input type="hidden" id="invitedByHidden" name="invitedBy"
                                            value="{{ $memberId ?? 0 }}"> <!-- Default to 0 if no member found -->
                                        @php
                                            $meeting = \App\Models\Schedule::find($meetingId);
                                            $circle = $meeting ? $meeting->circle : null;
                                            $city = $circle ? $circle->city : null;
                                            $cityAmount = $city ? $city->amount : 0;
                                            // // Check if you have the city amount
                                            // dump('City amount: ' . $cityAmount);
                                            // dump('City: ' . $city);
                                            // dump('Circle: ' . $circle);
                                            // dump('Meeting: ' . $meeting);
                                        @endphp
                                        <input type="hidden" id="cityAmount" name="cityAmount"
                                            value="{{ $cityAmount }}">
                                        <input type="hidden" id="meetingId" name="meetingId"
                                            value="{{ $meeting->id }}">
                                    @endif

                                    @error('invitedBy')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Product / Service</label>
                                    <input type="text" id="product" name="product"
                                        value="{{ old('product') }}"
                                        class="form-control @error('product') is-invalid @enderror"
                                        onblur="validate(6)">
                                    @error('product')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Are you part of any networking
                                        group?</label>
                                    <select id="networkingGroup" name="networkingGroup"
                                        class="form-control @error('networkingGroup') is-invalid @enderror">
                                        <option value="" disabled selected>Select Yes or No</option>
                                        <option value="Yes"
                                            {{ old('networkingGroup') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('networkingGroup') == 'No' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                    @error('networkingGroup')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-between text-left">

                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Circle Meet</label>
                                    <input type="text" id="circleMeet" name="circleMeet"
                                        value="{{ old('circleMeet') }}"
                                        class="form-control @error('circleMeet') is-invalid @enderror"
                                        onblur="validate(8)">
                                    @error('circleMeet')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">How do you know about us ?</label>
                                    <select id="knowsUs" name="knowsUs"
                                        class="form-control @error('knowsUs') is-invalid @enderror">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="Facebook" {{ old('knowsUs') == 'Facebook' ? 'selected' : '' }}>
                                            Facebook</option>
                                        <option value="Twitter" {{ old('knowsUs') == 'Twitter' ? 'selected' : '' }}>
                                            Twitter</option>
                                        <option value="Instagram"
                                            {{ old('knowsUs') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                                        <option value="LinkedIn" {{ old('knowsUs') == 'LinkedIn' ? 'selected' : '' }}>
                                            LinkedIn</option>
                                        <option value="Google" {{ old('knowsUs') == 'Google' ? 'selected' : '' }}>
                                            Google</option>
                                        <option value="Other" {{ old('knowsUs') == 'Other' ? 'selected' : '' }}>Other
                                        </option>
                                        <!-- Add more social media options as needed -->
                                    </select>
                                    @error('knowsUs')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            {{-- <input type="hiddden" name="meetingId" id="meetingId" value="{{ $meeting->id }}"> --}}

                            <div class="form-group col-auto">
                                <input type="checkbox" id="myCheckbox"> Check to Pay Offline
                                <div class="row justify-content-start align-items-center">
                                </div>
                                <div class="form-group col-auto">
                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-bg-blue" id="register"
                                        style="display:none;">Register</button>
                                    {{-- <button type="submit" class="btn btn-success" id="payNowMeet" disabled
                                        onclick="document.getElementById('cityAmount').value = {{ $cityAmount }};">Pay
                                        Now ₹ {{ $cityAmount }}</button> --}}

                                    <button type="submit" class="btn btn-success" id="payNowMeet" disabled>
                                        Pay Now ₹ {{ $cityAmount }}
                                    </button>


                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main><!-- End #main -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener("DOMContentLoaded", function() {
            const requiredFields = document.querySelectorAll(
                "#visitorForm input[required], #visitorForm select[required]");
            const payNowButton = document.getElementById("payNowMeet");

            // Disable the pay now button initially
            payNowButton.disabled = true;

            // Function to check if all required fields are filled
            function validateForm() {
                let allFieldsFilled = true;

                // Loop through each required field and check if it's filled
                requiredFields.forEach(function(field) {
                    if (field.value.trim() === "" || field.classList.contains('is-invalid')) {
                        allFieldsFilled = false;
                    }
                });

                // Enable or disable the button based on whether all fields are filled
                payNowButton.disabled = !allFieldsFilled;
            }

            // Attach event listeners to all required fields
            requiredFields.forEach(function(field) {
                field.addEventListener("input", validateForm);
                field.addEventListener("change", validateForm);
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pay Now button
            const payNowBtn = document.getElementById('payNowMeet');

            // Add click event listener to pay button
            payNowBtn.addEventListener('click', function(event) {
                event.preventDefault();

                console.log('Pay Now button clicked');
                const cityAmount = document.getElementById('cityAmount').value;
                console.log('City Amount:', cityAmount);

                // Get the amount and other necessary details
                const amount = parseInt(cityAmount) * 100; // Convert to paise
                console.log('Amount:', amount);

                const razorpayKey = "{{ env('RAZORPAY_KEY') }}"; // Razorpay Key
                console.log('Razorpay Key:', razorpayKey);

                const invitedBy = document.getElementById('invitedByHidden').value;
                console.log('Invited By:', invitedBy);

                if (!razorpayKey) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Razorpay key is missing. Please contact support.',
                    });
                    return;
                }

                // Collect form data
                const formData = new FormData(document.getElementById('visitorForm'));

                // Razorpay payment options
                const options = {
                    "key": razorpayKey,
                    "amount": amount,
                    "currency": "INR",
                    "name": "Circle Meeting",
                    "description": "Circle Meet Payment",
                    "image": "/img/logo.png", // Your logo
                    "handler": function(response) {
                        console.log('Payment successful, storing payment details');
                        storePaymentDetails(response.razorpay_payment_id, amount, formData);
                    },
                    "prefill": {},
                    "theme": {
                        "color": "#F37254"
                    }
                };

                console.log('Razorpay options:', options);

                // Open Razorpay checkout
                const rzp = new Razorpay(options);
                rzp.open();
            });

            // AJAX request to store payment details along with form data
            function storePaymentDetails(paymentId, amount, formData) {
                console.log('Storing payment details:', {
                    paymentId,
                    amount
                });

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const url = `{{ route('razorpay.payment.store.visitor') }}`;

                // Ensure meetingId exists before accessing its value
                const meetingIdElement = document.getElementById('meetingId');
                const meetingId = meetingIdElement ? meetingIdElement.value : null;

                if (!meetingId) {
                    console.error('Meeting ID not found.');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Meeting ID is missing. Please contact support.',
                    });
                    return;
                }

                // Add payment details to formData
                formData.append('paymentId', paymentId);
                formData.append('amount', amount);
                formData.append('meetingId', meetingId);

                // Convert formData to JSON object
                const formObject = {};
                formData.forEach((value, key) => {
                    formObject[key] = value;
                });

                console.log('Form Data with Payment Details:', formObject);

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
                            console.error('Error response:', response);
                            return response.json().then(errorData => {
                                throw new Error(errorData.error || 'Failed to store payment details.');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response:', data);
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Payment successful and details stored!',
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                            // window.location.reload();
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






    <script>
        var myCheckbox = document.getElementById('myCheckbox'); // Corrected checkbox ID
        var register = document.getElementById('register');
        var payNowMeet = document.getElementById('payNowMeet');

        myCheckbox.addEventListener('change', function() {
            if (myCheckbox.checked) {
                payNowMeet.style.display = 'none'; // Show the Pay Now button
                register.style.display = 'inline-block'; // Hide the Register button
            } else {
                register.style.display = 'none'; // Show the Register button
                payNowMeet.style.display = 'inline-block'; // Hide the Pay Now button
            }
        });
    </script>

    <script>
        function validate(val) {
            v1 = document.getElementById("firstName");
            v2 = document.getElementById("lastName");
            v3 = document.getElementById("mobileNo");
            v4 = document.getElementById("businessName");
            v5 = document.getElementById("businessCategory");
            v6 = document.getElementById("product");
            v7 = document.getElementById("networkingGroup");
            v8 = document.getElementById("circleMeet");

            flag1 = true;
            flag2 = true;
            flag3 = true;
            flag4 = true;
            flag5 = true;
            flag6 = true;
            flag7 = true;
            flag8 = true;

            if (val >= 1 || val == 0) {
                if (v1.value == "") {
                    v1.style.borderColor = "red";
                    flag1 = false;
                } else {
                    v1.style.borderColor = "green";
                    flag1 = true;
                }
            }

            if (val >= 2 || val == 0) {
                if (v2.value == "") {
                    v2.style.borderColor = "red";
                    flag2 = false;
                } else {
                    v2.style.borderColor = "green";
                    flag2 = true;
                }
            }
            if (val >= 3 || val == 0) {
                if (v3.value == "") {
                    v3.style.borderColor = "red";
                    flag3 = false;
                } else {
                    v3.style.borderColor = "green";
                    flag3 = true;
                }
            }
            if (val >= 4 || val == 0) {
                if (v4.value == "") {
                    v4.style.borderColor = "red";
                    flag4 = false;
                } else {
                    v4.style.borderColor = "green";
                    flag4 = true;
                }
            }
            if (val >= 5 || val == 0) {
                if (v5.value == "") {
                    v5.style.borderColor = "red";
                    flag5 = false;
                } else {
                    v5.style.borderColor = "green";
                    flag5 = true;
                }
            }
            if (val >= 6 || val == 0) {
                if (v6.value == "") {
                    v6.style.borderColor = "red";
                    flag6 = false;
                } else {
                    v6.style.borderColor = "green";
                    flag6 = true;
                }
            }
            if (val >= 7 || val == 0) {
                if (v7.value == "") {
                    v7.style.borderColor = "red";
                    flag7 = false;
                } else {
                    v7.style.borderColor = "green";
                    flag7 = true;
                }
            }
            if (val >= 8 || val == 0) {
                if (v8.value == "") {
                    v8.style.borderColor = "red";
                    flag8 = false;
                } else {
                    v8.style.borderColor = "green";
                    flag8 = true;
                }
            }

            flag = flag1 && flag2 && flag3 && flag4 && flag5 && flag6 && flag7 && flag8;

            return flag;
        }
    </script>

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

</body>

</html>
