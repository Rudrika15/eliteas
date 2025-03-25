<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .left-side {
            background: url("{{ asset('img/logNew.png') }}") no-repeat center center;
            background-size: cover;
            height: 100vh;
        }

        .login-box {
            max-width: 400px;
            width: 100%;
            margin: auto;
            padding: 20px;
            text-align: left;
        }

        .login-box img.logo {
            width: 100px;
            margin-bottom: 30px;
        }

        .login-box h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .login-box p {
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }

        .input-box {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-box input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #2b2d77, #e87532);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }

        .forgot-password a {
            text-decoration: none;
            color: #2b2d77;
            font-size: 14px;
        }

        @media (max-width: 991px) {
            .left-side {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-lg-7 left-side d-none d-lg-block"></div>
            <div class="col-lg-5 d-flex align-items-center">
                <div class="login-box">
                    <img src="{{ asset('img/logo4.png') }}" alt="UBN Logo" class="logo">
                    <h2 class="text-muted">Log In</h2>
                    <p>Login to your Account to get access to all Business related circles and Contact Details that help in your Businesses.</p>

                    <form method="POST" action="{{ route('login') }}" class="needs-validation w-100" novalidate id="login-form">
                        @csrf
                        <!-- Email Field -->
                        <div class="input-box position-relative mb-3">
                            <input id="email" type="email" class="form-control shadow-none border-none @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            {{-- <img src="{{ asset('img/envelope.png') }}" alt="Email Icon" class="icon position-absolute"> --}}

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
                        <div class="input-box position-relative mb-3">
                            <input id="password" type="password" class="form-control shadow-none border-none @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            {{-- <img src="{{ asset('img/padlock.png') }}" alt="Password Icon" class="icon position-absolute"> --}}

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

                        {{-- <div class="forgot-password d-flex justify-content-start mb-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('forget.password.get') }}" style="color: #1C2956; font-family: Poppins;">
                                    Forgot Your Password?
                                </a>
                            @endif
                        </div> --}}

                        <div class="forgot-password">
                            @if (Route::has('password.request'))
                                <a href="{{ route('forget.password.get') }}" style="color: #1C2956;">
                                    Forgot Your Password ?
                                </a>
                            @endif
                        </div>

                        <button class="login-btn">Log In</button>

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
