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
            {{-- <a href="{{ route('home') }}" class="logo"> --}}
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

                <li class="nav-item dropdown pe-3">



                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header d-md-none">
                            {{-- <h6>{{Auth::user()->name}}</h6> --}}
                            {{-- <span>Web Designer</span> --}}
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <hr class="dropdown-divider">
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

                @include('layouts.visitorMenu')

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
