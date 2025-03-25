<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            font-family: 'Poppins';
            overflow: hidden;
        }

        .left-section {
            background-color: #1C2956;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .left-section h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .left-section p {
            margin-top: 20px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .left-section img {
            max-width: 100%;
        }

        .form-container img {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
        }

        .form-group .form-control {
            padding-left: 0px;
            border-radius: 0;
            border: none;
            border-bottom: 1px solid #ccc;
            width: 50%;
            margin: 0 auto;
            margin-top: 20px;
            color: #1C2956;
            /* font-weight: bold; */
            font-family: Poppins;
            shadow: none !important;

        }

        ::placeholder {
            color: #1C2956 !important;
            opacity: 1;
            /* Firefox */
        }

        .form-group .icon {
            position: absolute;
            top: 50%;
            left: 410px;
            transform: translateY(-50%);
            color: #1C2956;
        }

        .form-container a {
            text-align: right;
            display: block;
            font-size: 14px;
            color: #1A2E58;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }

        .btn-login {
            background-color: #1A2E58;
            color: #ffffff;
            border-radius: 5px;
        }

        .btn-login:hover {
            background-color: #143a6a;
        }



        .graph-image {
            margin-top: 100px !important;
            height: 500px;
        }

        .globe-overlay-right {
            position: absolute;
            top: -80px;
            right: -100px;
            z-index: 10;
            width: 300px;
            height: auto;
            pointer-events: none;
            opacity: 50%;
        }

        .globe-overlay-left {
            position: absolute;
            top: -80px;
            left: -100px;
            /* Adjust for the left corner */
            z-index: 10;
            width: 300px;
            /* Same dimensions as the right image */
            height: auto;
            pointer-events: none;
            opacity: 50%;
        }

        .f-password {
            margin-left: 145px !important;
        }



        /* Media Queries for Mobile */
        @media (max-width: 1024px) {
            .left-section {
                display: none !important;
            }

            .form-container img {
                max-width: 100px;
            }

            .form-group .form-control {
                width: 80%;
            }

            .btn-login {
                width: 80%;
            }

        }


        @media (max-width: 768px) {

            .rounded-pill-top {
                display: none;
            }

            .form-group .icon {
                left: 267px;
            }


            .globe-overlay-right {
                display: none;
            }

            .globe-overlay-left {
                display: none;
            }

            .footer {
                display: none;
            }

            .icon {
                left: 80% !important;
            }

            .f-password {
                margin-left: 10% !important;
            }

        }
    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Left Section -->
            <div class="col-md-5 d-flex align-items-center justify-content-center left-section d-none d-md-flex">
                <div class="text-center mt-5 graph-image">
                    <img src="{{ asset('img/graphLogin.png') }}" alt="UBN" class="mt-5" style="opacity: 10%; margin-left: 30px;">
                </div>
            </div>
            <div class="rounded-pill rounded-pill-top position-absolute w-25 " style="background: white; color: #1C2956; margin-left: 400px;  padding: 10px; border: none; margin-top: 60px;">
                <button class="bg-transparent border-0 ms-2">
                    <h1 class=" mb-0" style="color: #1C2956; font-family: Poppins;">Login</h1>
                </button>
            </div>

            <h2 class="footer position-absolute bottom-0 " style="color: white; padding-left: 80px; font-family: Poppins; font-size: 25px">Designed by Aspireotech Solutions</h2>



            <!-- Right Section -->
            <div class="col-md-7 col-sm-12 col-xs-12 d-flex align-items-center justify-content-center">
                <div class="form-container w-75">

                    <div class="img">
                        <img src="{{ asset('img/ubnNewLogo2.png') }}" alt="UBN" class="mb-3">
                    </div>


                    <form method="POST" action="{{ route('login') }}" class="needs-validation w-100" novalidate id="login-form">
                        @csrf
                        <!-- Email Field -->
                        <div class="form-group position-relative mb-3">
                            <input id="email" type="email" class="form-control shadow-none border-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            <img src="{{ asset('img/envelope.png') }}" alt="Email Icon" class="icon position-absolute">

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

                        <!-- Password Field -->
                        <div class="form-group position-relative mb-3">
                            <input id="password" type="password" class="form-control shadow-none border-none @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            {{-- <span class="icon position-absolute">&#128274;</span> --}}
                            <img src="{{ asset('img/padlock.png') }}" alt="Email Icon" class="icon position-absolute">


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

                        <!-- Forgot Password -->
                        <div class="f-password">
                            @if (Route::has('password.request'))
                                <div class="d-flex justify-content-start">
                                    <a href="{{ route('forget.password.get') }}" class="d-block mb-3" style="color: #1C2956; font-family: Poppins;">
                                        Forgot Your Password ?
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="d-flex justify-content-center align-items-center mt-5">
                            <button type="submit" class="btn btn-login w-30 rounded-pill login-footer" style="font-family: Poppins;">Login</button>
                        </div>

                        <!-- Hidden Latitude and Longitude Fields -->
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </form>

                    <!-- Footer -->
                </div>
            </div>
        </div>

        <!-- Globe Image Overlay (Right) -->
        <img src="{{ asset('img/loginDesign.png') }}" alt="Network Globe" class="globe-overlay-right">

        <!-- Globe Image Overlay (Left) -->
        <img src="{{ asset('img/loginDesign.png') }}" alt="Network Globe" class="globe-overlay-left">

    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
