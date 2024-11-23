<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login</title>
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
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif

                                    {{-- <form method="POST" action="{{ route('conEventLogin') }}" --}}
                                    <form method="POST" action="{{ route('conquer.event.user.login') }}"
                                        class="needs-validation w-100" novalidate id="login-form">
                                        @csrf

                                        <!-- Email Input -->
                                        <div class="mb-3 form-floating">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <label for="email"><b>Email Address</b></label>

                                            @if (Session::has('error') && Session::get('error') === 'email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>Your Email is incorrect.</strong>
                                                </span>
                                            @endif

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
                                                name="password" required autocomplete="current-password"
                                                style="border-color: #1d3268 !important">
                                            <label for="password"><b>Password</b></label>

                                            @if (Session::has('error') && Session::get('error') === 'password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>Your Password is incorrect.</strong>
                                                </span>
                                            @endif

                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-bg-blue">Login</button>
                                        </div>




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

</body>

</html>