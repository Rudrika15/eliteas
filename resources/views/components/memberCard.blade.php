{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Card Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .profile-card {
            width: 320px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            margin: 40px auto;
        }

        .header-image {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .profile-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            margin-top: -45px;
        }

        .icon-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-size: 13px;
        }

        .icon-text i {
            font-size: 20px;
            color: #5f6368;
            margin-bottom: 4px;
        }

        .company-name {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .category-text {
            color: #888;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .keyword-btn {
            border-radius: 50px;
            font-size: 12px;
            padding: 4px 12px;
            background-color: #f1f1f1;
            border: none;
            margin: 4px;
        }

        .profile-actions {
            border-top: 1px solid #f0f0f0;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .profile-actions a {
            text-decoration: none;
            font-weight: 500;
        }

        .btn-message {
            background-color: #ff6b6b;
            color: white;
            border-radius: 50px;
            padding: 6px 14px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="profile-card">
        <img src="https://picsum.photos/600/100" class="header-image" alt="Header Image">
        <div class="text-center p-3">
            <img src="https://randomuser.me/api/portraits/men/75.jpg" class="profile-img" alt="Profile">
            <h5 class="mt-2 mb-0">John Doshi</h5>
            <p class="text-muted mb-2" style="font-size: 14px;">Vice President at UBN</p>
            <div class="d-flex justify-content-around text-center mt-3 mb-3">
                <div class="icon-text">
                    <i class="bi bi-envelope-fill"></i>
                    <div>John5968dosh...</div>
                </div>
                <div class="icon-text">
                    <i class="bi bi-telephone-fill"></i>
                    <div>941 440 2140</div>
                </div>
                <div class="icon-text">
                    <i class="bi bi-people-fill"></i>
                    <div>Pinnacle</div>
                </div>
            </div>
            <div class="text-center">
                <div class="company-name">CubX Technologies</div>
                <div class="category-text">Category: Mechanical Workshop</div>
                <div>
                    <button class="keyword-btn">Keyword 1</button>
                    <button class="keyword-btn">Keyword 2</button>
                    <button class="keyword-btn">Keyword 3</button>
                </div>
            </div>
        </div>
        <div class="profile-actions">
            <a href="#">View Profile</a>
            <button class="btn-message">Message</button>
        </div>
    </div>
</body>

</html> --}}




{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        .left-side {
            width: 50%;
            background: url("{{ asset('img/logNew.png') }}") no-repeat center center;
            background-size: cover;
        }

        .right-side {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 80%;
            max-width: 400px;
        }

        .login-box h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .login-box p {
            margin-bottom: 30px;
            color: #666;
        }

        .input-box {
            margin-bottom: 20px;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="left-side"></div>
        <div class="right-side">
            <div class="login-box">
                <h2>Log In</h2>
                <p>Login to your Account to get access to all Business related circles and contact details that help in your businesses.</p>
                <div class="input-box">
                    <input type="email" placeholder="Email">
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Password">
                </div>
                <div class="forgot-password">
                    <a href="#">Forgot Your Password?</a>
                </div>
                <button class="login-btn">Log In</button>
            </div>
        </div>
    </div>
</body>

</html> --}}


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

                    <div class="input-box">
                        <input type="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="input-box">
                        <input type="password" class="form-control" placeholder="Password">
                    </div>

                    <div class="forgot-password">
                        <a href="#">Forgot Your Password?</a>
                    </div>

                    <button class="login-btn">Log In</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
