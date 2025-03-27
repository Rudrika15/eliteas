<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile Card Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .profile-card {
            width: 400px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            margin: 50px auto;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .header-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            margin-top: -50px;
        }

        h5 {
            margin-top: 10px;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .text-muted {
            color: #6c757d;
            font-size: 14px;
        }

        .info-section {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .icon-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-size: 13px;
            flex: 1;
        }

        .icon-text i {
            font-size: 22px;
            color: #4a4a4a;
            margin-bottom: 5px;
        }

        .company-category-section {
            display: flex;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 0;
        }

        .company-section,
        .category-section {
            flex: 1;
            text-align: center;
        }

        .divider {
            width: 1px;
            background-color: #ccc;
            height: auto;
            margin: 0 15px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ff6b6b;
        }

        .company-section h2,
        .category-section h3 {
            margin: 6px 0;
            color: #1d2951;
            font-size: 16px;
        }

        .category-section .label {
            color: gray;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .keywords-container {
            text-align: center;
            margin: 15px 20px 10px;
        }

        .keyword-pill {
            display: inline-block;
            background-color: #f3f5fb;
            color: #3a3a3a;
            font-size: 12px;
            padding: 6px 12px;
            margin: 5px 5px;
            border-radius: 20px;
            border: 1px solid #e0e4f0;
            cursor: default;
        }

        .bottom-actions {
            display: flex;
            border-top: 1px solid #e6e6e6;
            padding: 10px 0;
            text-align: center;
        }

        .bottom-actions div {
            flex: 1;
            cursor: pointer;
            font-weight: 600;
            color: #1d2951;
            transition: color 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
        }

        .bottom-actions div:hover {
            color: #ff6b6b;
        }

        .bottom-divider {
            width: 1px;
            background-color: #e0e0e0;
            height: auto;
            
        }
    </style>
</head>

<body>
    <div class="profile-card">
        <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image">
        <div class="text-center p-3">
            <img src="https://randomuser.me/api/portraits/men/76.jpg" class="profile-img" alt="Profile">
            <h5>John Doshi</h5>
            <p class="text-muted">Vice President at UBN</p>
            <div class="info-section">
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
            <div class="company-category-section">
                <div class="company-section">
                    <div class="logo">SUS|H</div>
                    <h2>CubX Technologies</h2>
                </div>
                <div class="divider"></div>
                <div class="category-section">
                    <div class="label">Category</div>
                    <h3>Mechanical<br>Workshop</h3>
                </div>
            </div>
            <div class="keywords-container">
                <span class="keyword-pill">Mobile App Development</span>
                <span class="keyword-pill">Web Development</span>
                <span class="keyword-pill">UI/UX Design</span>
                <span class="keyword-pill">Cloud Services</span>
            </div>
        </div>
        <div class="bottom-actions">
            <div>
                <i class="bi bi-person-lines-fill"></i>
                View Profile
            </div>
            <div class="bottom-divider"></div>
            <div>
                <i class="bi bi-person-plus-fill"></i>
                Connect
            </div>
        </div>
    </div>
</body>

</html>




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


{{-- <!DOCTYPE html>
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

</html> --}}
