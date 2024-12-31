<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .left-section {
            background-color: #1A2E58;
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
            padding-left: 40px;
            border-radius: 5px;
        }

        .form-group .icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #666;
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

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Left Section -->
            <div class="col-md-5 d-flex align-items-center justify-content-center left-section">
                <div class="text-center">
                    <h1>Login</h1>
                    <img src="https://via.placeholder.com/150" alt="Graph Icon" class="my-4">
                    <p>Designed by Aspireotech Solutions</p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-md-7 d-flex align-items-center justify-content-center">
                <div class="form-container w-75">
                    <img src="{{ asset('img/logo2.jpg') }}" alt="UBN" class="mb-3">
                    <!-- Email Field -->
                    <div class="form-group position-relative mb-3">
                        <span class="icon position-absolute">&#9993;</span>
                        <input type="email" class="form-control" placeholder="Email" required>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group position-relative mb-3">
                        <span class="icon position-absolute">&#128274;</span>
                        <input type="password" class="form-control" placeholder="Password" required>
                    </div>

                    <!-- Forgot Password -->
                    <a href="#" class="d-block mb-3">Forget your password?</a>

                    <!-- Login Button -->
                    <button class="btn btn-login w-100">Login</button>

                    <!-- Footer -->
                    <div class="footer mt-3">Designed by Aspireotech Solutions</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
