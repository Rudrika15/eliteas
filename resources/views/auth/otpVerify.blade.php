<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login with OTP</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

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
        <div class=""
            style="background-image: url('{{ asset('img/b2.jpg') }}'); background-size: 100% 100%; background-position: center;">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="main-logo d-flex align-items-center">
                                    <img src="{{ asset('img/logo2.jpg') }}" alt=""
                                        style="mix-blend-mode: multiply; width: 150px; height:100px;">
                                    {{-- <span class="d-none d-lg-block">Elite</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3 res-box"
                                style="width: 20rem; height: 100%; background-image: url('{{ asset('img/b2.jpg') }}'); background-size: cover; background-position: center;">
                                <div class="card-body">
                                    <h5 class="card-title text-center text-white pb-0 fs-4 mt-5">Verify OTP</h5>
                                    {{-- <p class="text-center small">Enter your phone number to request OTP</p> --}}

                                    <!-- Display Error Message -->
                                    @if ($errors->has('message'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('message') }}
                                    </div>
                                    @endif
        
                                    <!-- OTP Verification Form -->
                                    <form action="{{ route('otp.verify') }}" method="post"
                                        class="needs-validation w-100 mt-3" novalidate>
                                        @csrf
                                        <div class="form-group d-flex justify-content-between">
                                            <input type="password" id="otp1" name="otp1"
                                                class="form-control otp-input me-2" maxlength="1"
                                                style="border-color: #1d2856; border-radius: 5px; padding: 10px; transition: all 0.3s ease-in-out;"
                                                onfocus="this.style.border = '1px solid #1d2856'"
                                                onmouseover="this.style.border = '1px solid #1d2856'"
                                                onmouseout="this.style.border = '1px solid #1d2856'" required>
                                            <input type="password" id="otp2" name="otp2"
                                                class="form-control otp-input me-2" maxlength="1"
                                                style="border-color: #1d2856; border-radius: 5px; padding: 10px; transition: all 0.3s ease-in-out;"
                                                onfocus="this.style.border = '1px solid #1d2856'"
                                                onmouseover="this.style.border = '1px solid #1d2856'"
                                                onmouseout="this.style.border = '1px solid #1d2856'" required>
                                            <input type="password" id="otp3" name="otp3"
                                                class="form-control otp-input me-2" maxlength="1"
                                                style="border-color: #1d2856; border-radius: 5px; padding: 10px; transition: all 0.3s ease-in-out;"
                                                onfocus="this.style.border = '1px solid #1d2856'"
                                                onmouseover="this.style.border = '1px solid #1d2856'"
                                                onmouseout="this.style.border = '1px solid #1d2856'" required>
                                            <input type="password" id="otp4" name="otp4"
                                                class="form-control otp-input me-2" maxlength="1"
                                                style="border-color: #1d2856; border-radius: 5px; padding: 10px; transition: all 0.3s ease-in-out;"
                                                onfocus="this.style.border = '1px solid #1d2856'"
                                                onmouseover="this.style.border = '1px solid #1d2856'"
                                                onmouseout="this.style.border = '1px solid #1d2856'" required>
                                            <input type="password" id="otp5" name="otp5"
                                                class="form-control otp-input me-2" maxlength="1"
                                                style="border-color: #1d2856; border-radius: 5px; padding: 10px; transition: all 0.3s ease-in-out;"
                                                onfocus="this.style.border = '1px solid #1d2856'"
                                                onmouseover="this.style.border = '1px solid #1d2856'"
                                                onmouseout="this.style.border = '1px solid #1d2856'" required>
                                            <input type="password" id="otp6" name="otp6" class="form-control otp-input"
                                                maxlength="1"
                                                style="border-color: #1d2856; border-radius: 5px; padding: 10px; transition: all 0.3s ease-in-out;"
                                                onfocus="this.style.border = '1px solid #1d2856'"
                                                onmouseover="this.style.border = '1px solid #1d2856'"
                                                onmouseout="this.style.border = '1px solid #1d2856'" required>
                                        </div>

                                        {{-- @if ($errors->has('otp'))
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>Invalid OTP</strong>
                                        </span>
                                        @endif --}}

                                        <input type="hidden" name="phone" value="{{ session('phone') }}">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-bg-blue mt-3">Verify OTP</button>
                                        </div>
                                    </form>

                                    <!-- Resend OTP Form -->
                                    <form action="{{ route('otp.resend') }}" method="post" class="w-100 mt-3">
                                        @csrf
                                        <input type="hidden" name="phone" value="{{ session('phone') }}">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-bg-orange" id="resendBtn">Resend
                                                OTP</button>
                                        </div>
                                        <p id="countdown" class="text-center mt-2"></p>
                                    </form>
                                    <!-- End Resend OTP Form -->

                                </div>
                            </div>

                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                Designed by <a href="https://flipcodesolutions.com/" target="_blank"
                                    class="text-black"><b>Aspireotech
                                        Solutions</b></a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        // Move focus to the next OTP input field
        document.querySelectorAll('.otp-input').forEach((input, index, arr) => {
            input.addEventListener('input', (e) => {
                if (index < arr.length - 1 && e.target.value.length === 1) {
                    arr[index + 1].focus();
                }
            });
        });

        // Allow only numeric input in OTP fields
        document.querySelectorAll('.otp-input').forEach(input => {
            input.addEventListener('keypress', function (e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });

        // Countdown for Resend OTP
        document.addEventListener('DOMContentLoaded', function() {
            let countdownElement = document.getElementById('countdown');
            let resendButton = document.getElementById('resendBtn');
            let timer = 60;

            function startCountdown() {
                resendButton.disabled = true;
                countdownElement.innerText = `Resend OTP in ${timer} Seconds...`;
                let interval = setInterval(function() {
                    timer--;
                    countdownElement.innerText = `Resend OTP in ${timer} Seconds...`;
                    if (timer <= 0) {
                        clearInterval(interval);
                        countdownElement.innerText = '';
                        resendButton.disabled = false;
                        timer = 60;
                    }
                }, 1000);
            }

            startCountdown();
        });
    </script>
</body>

</html>