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
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
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
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="main-logo d-flex align-items-center">
                                    <img src="{{ asset('img/logo2.jpg') }}" alt=""
                                        style="background-color: #F5E9E2; mix-blend-mode: multiply; width: 150px; height:100px;">
                                    {{-- <span class="d-none d-lg-block">Elite</span> --}}
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3" style="width: 20rem;">
                                <div class="card-body">
                                    <h5 class="card-title text-center pb-0 fs-4">Request OTP</h5>
                                    {{-- <p class="text-center small">Enter your phone number to request OTP</p> --}}

                                    <!-- OTP Request Form -->
                                    <form action="{{ route('otp.request') }}" method="post"
                                        class="needs-validation w-100" novalidate>
                                        @csrf
                                        <div class="mb-3 form-floating">
                                            <input type="text" id="phone" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror" required
                                                autocomplete="phone" autofocus>
                                            <label for="phone">Phone Number</label>
                                            @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Send OTP</button>
                                        </div>
                                    </form>
                                    <!-- End OTP Request Form -->
                                </div>
                            </div>

                            <div class="credits">
                                <!-- All the links in the footer should remain intact. -->
                                <!-- You can delete the links only if you purchased the pro version. -->
                                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                                Designed by <a href="https://flipcodesolutions.com/" target="_blank">FlipCode
                                    Solutions</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main