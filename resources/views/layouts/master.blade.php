<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    {{-- add csrf --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/faviconUbn.png') }}" rel="icon" />
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



    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>



    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center shadow-none border ">

        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="logo">
                {{-- <img src="assets/img/logo.png" alt=""> --}}
                <img src="{{ asset('img/logo2.jpg') }}" alt="UBN" width="100">
            </a>
            <i class="bi bi-list toggle-sidebar-btn mt-2"></i>
        </div><!-- End Logo -->
        <!-- Start Search Bar -->
        <div class="search-bar">
            <a class="search-form d-flex align-items-center" href="{{ route('search') }}">
                <input type="text" name="query" placeholder="Click here to find & connect with People"
                    title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i>
                </button>
            </a>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->


                {{-- <li class="nav-item d-block dg-lg" style="display: none;">
                    <a class="nav-link nav-icon search-bar-toggle" href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->
                <style>
                    @media (min-width: 1024px) {
                        .nav-item.d-block.dg-lg-none {
                            display: block;
                        }
                    }

                    @media (max-width: 1024px) {
                        .nav-item.d-block.dg-lg-none {
                            display: none;
                        }
                    }
                </style> --}}



                {{-- <li class="nav-item dropdown">

                    <a class="nav-link nav-icon " href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number ">4</span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->


                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-chat-left-text"></i>
                    <span class="badge bg-success badge-number">3</span>
                </a><!-- End Messages Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                    <li class="dropdown-header">
                        You have 3 new messages
                        <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="message-item">
                        <a href="#">
                            <img src="public/img/messages-1.jpg" alt="" class="rounded-circle">
                            <div>
                                <h4>Maria Hudson</h4>
                                <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                <p>4 hrs. ago</p>
                            </div>
                        </a>
                    </li>


                    <li class="dropdown-footer">
                        <a href="#">Show all messages</a>
                    </li>

                </ul><!-- End Messages Dropdown Items -->

                </li><!-- End Messages Nav --> --}}


                {{-- @role('Admin')
                    <li class="nav-item pe-3">
                        <a class="nav-link" href="{{ url('/visitor-form-view') }}" target="_blank"
                            style="color: #1d3268; padding: 10px; border-radius: 5px; background-color: rgba(29, 50, 102, 0.2);">
                            <b>Visitor Form</b>
                        </a>
                    </li>
                @endrole --}}


                {{-- <li class="nav-item">
                    <a class="nav-link" href="https://ubnmart.ubncommunity.com/">
                        <span class="badge rounded-pill bg-warning"
                            style="font-size: 12px;padding: 5px 10px;color: #fff;display: inline-block;margin-top: 5px; margin-right: 10px;">Go
                            To Mart</span>
                    </a>
                </li> --}}



                {{-- @role('member') --}}
                @if (Auth::user()->userStatus == 'Online')
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="badge rounded-pill bg-success"
                                style="font-size: 12px;padding: 5px 10px;color: #fff;display: inline-block;margin-top: 5px;">Online</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="badge rounded-pill bg-danger"
                                style="font-size: 12px;padding: 5px 10px;color: #fff;display: inline-block;margin-top: 5px;">Offline</span>
                        </a>
                    </li>
                @endif
                {{-- @endrole --}}

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        @if (isset(Auth::user()->profile_photo))
                            {{-- <img class="img-profile rounded-circle" src="{{url('public/img/logo.png')}}"> --}}
                            <img class="img-profile rounded-circle" src="public/img/logo.png">
                        @else
                            <span
                                class="rounded-circle text-center p-2 fs-5 badge logobadge d-inline-block text-light h-50"
                                style="width: 38px !important;">
                            </span>
                        @endif
                        {{-- <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span> --}}
                        <span class="d-md-none">Hello, {{ Auth::user()->firstName ?? '-' }}</span>
                        <span class="d-none d-md-block dropdown-toggle ps-2">Hello,
                            {{ Auth::user()->firstName ?? '-' }}</span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header d-md-none">
                            {{-- <h6>{{Auth::user()->name}}</h6> --}}
                            <h6>{{ Auth::user()->firstName ?? '-' }}</h6>
                            {{-- <span>Web Designer</span> --}}
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @role('Member')
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('member') }}">
                                    <i class="bi bi-person" style="color: #e76a35"></i>
                                    <span style="font-weight: bold; color: #1d2856">My Profile</span>
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('member') }}">
                                    <i class="bi bi-cart" style="color: #e76a35"></i>
                                    <span style="font-weight: bold; color: #1d2856">Go To UBN Mart</span>
                                </a>
                            </li>
                        @endrole

                        @role('Admin')
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('member') }}">
                                    <i class="bi bi-cart" style="color: #e76a35"></i>
                                    <span style="font-weight: bold; color: #1d2856">Go To UBN Mart</span>
                                </a>
                            </li>
                        @endrole


                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="{{ route('changePasswordForm') }}">
                                <i class="bi bi-key" style="color: #e76a35"></i>
                                <span style="font-weight: bold; color: #1d2856">Change Password</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right signout-style"></i>
                                <span class="signout-style">Sign Out</span>

                                <style>
                                    .signout-style {
                                        color: red;
                                        font-weight: bold;
                                    }
                                </style>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar mt-3">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link collapsed" href="/">
                    <i class="bi bi-grid" style="color: #e76a35"></i>
                    <span style="color: #1d2865 ;">Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <!-- End Charts Nav -->

            @role('Admin')
                @include('layouts.adminmenu')
            @endrole

            @role('Member')
                @include('layouts.membermenu')
            @endrole

            <!-- End Tables Nav -->

            <!-- End Charts Nav -->

            <!-- End Icons Nav -->

            <!-- End Blank Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">

        {{-- <div class="pagetitle">
            {{-- <h1>Dashboard</h1> --}}
        {{-- <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div> --}}
        <!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="container-fluid p-5">
                    <!-- Page Heading -->
                    @yield('content')
                </div>
        </section>

    </main><!-- End #main -->
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    {{-- footer start --}}



    <!-- ======= Footer ======= -->
    <style>
        .show-on-scroll {
            display: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
    <footer id="footer" class="footer fixed-bottom bg-light border-top py-2 show-on-scroll">
        <div class="container">
            <div class="copyright text-center">
                &copy; Copyright <strong><span>FlipCode Solutions</span></strong>. All Rights Reserved
            </div>
            <div class="credits text-center">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="#">FlipCode</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center "
        style="background-color: #1d2865; "><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script>
        // Hide the success message after 5 minutes
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2000);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- end -->

    @if (Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: true,

            });
        </script>
    @endif

    @if (Session::get('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: true,
            });
        </script>
    @endif


    {{-- <script>
        window.onerror = function(message, source, lineno, colno, error) {
            // Construct the error data
            const errorData = {
                message: message,
                source: source,
                lineno: lineno,
                colno: colno,
                stack: error ? error.stack : null,
                url: window.location.href, // Current page URL
                method: 'GET', // Assuming it's a GET request; adjust if needed
                ip_address: '', // IP address would be captured in Laravel, so we leave it blank
                user_agent: navigator.userAgent // Capturing the user agent
            };

            // Log error to server
            logErrorToServer(errorData);

            // Optional: Show a message to the user or handle it as needed
            console.error('Error occurred:', errorData);
        };

        // Function to log error to server
        function logErrorToServer(errorData) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = '{{ route('log.error') }}'; // Your Laravel route for logging errors

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(errorData)
            })
            .then(response => {
                if (!response.ok) {
                    console.error('Failed to log error:', response);
                }
            })
            .catch(err => {
                console.error('Error logging error:', err);
            });
        }
    </script> --}}



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
