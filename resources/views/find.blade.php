@extends('layouts.master')
@section('title', 'Search User')
@section('content')


    <!doctype html>
    <html lang="en">

    <head>
        <title>UBN - Search User </title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <!-- Bootstrap CSS v5.2.1 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        {{-- add csrf --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <title>Dashboard - Admin</title> --}}
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('img/favicon.png') }}" rel="icon" />
        <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <!-- Vendor CSS Files -->
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet" />
        <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet" />
        <!-- Template Main CSS File -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    </head>

    <body class="" style=" mix-blend-mode: multiply;">
        {{--

    <body class="" style=" mix-blend-mode: multiply; background: linear-gradient(to right, #1d2856, #e76a35);"> --}}
        <header>
            <!-- place navbar here -->
        </header>
        <main>

            <div class="pt-5 px-3">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-1">
                        <img src="{{ asset('img/logo4.png') }}" alt="UBN" class="pb-2" width="100" style="max-width: 100%; height: auto;">
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="query" id="searchInput" placeholder="Enter circle name or member name..." class="form-control" title="Enter search keyword">
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                    </div>
                    <style>
                        @media (max-width: 425px) {
                            .col-auto {
                                margin-top: 30px;
                            }
                        }

                        @media (max-width: 786px) {
                            .col-auto {
                                margin-top: 10px;
                            }
                        }
                    </style>
                </div>

                <style>
                    @media (max-width: 768px) {
                        .col-md-1 {
                            display: flex;
                            justify-content: center;
                            align-items: center;
                        }
                    }
                </style>
            </div>
            <div class="container pt-5">
                <h3 class="text-muted mb-3">
                    <div class="searchText"> </div>
                </h3>

                <div class="">
                    <div id="searchResults">
                    </div>
                    {{-- @auth
                    <div class="mb-3">
                        You are logged in as {{ Auth::user()->id }}
                    </div>
                    @endauth

                    @guest
                    <div class="mb-3">
                        You are not logged in
                    </div>
                    @endguest --}}

                </div>
            </div>
        </main>
        <br>
        {{-- <div id="memberModal" class="modal">
            <div class="model-dialog">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="modalContent"></div> <!-- This is the element to display member details -->
                </div>
            </div>
        </div> --}}



        {{-- <div class="modal" id="memberModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modalContent"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> --}}








        {{-- <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>FlipCode Solutions</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="#">FlipCode</a>
            </div>
        </footer><!-- End Footer --> --}}

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <div id="searchResults"></div>

        {{-- <style>
            /* LinkedIn-inspired styling */
            .card-container {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 15px;
            }

            .card {
                border: 1px solid #ddd;
                border-radius: 8px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                padding: 15px;
                background-color: #fff;
                text-align: center;
                /* Center align text for LinkedIn look */
            }

            .card-body {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .profile-image {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                margin-bottom: 10px;
                background-color: #e1e9ee;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 24px;
                color: #0073b1;
                overflow: hidden;
            }

            .profile-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 50%;
            }

            .card-title {
                font-weight: bold;
                font-size: 16px;
                margin: 0;
                color: #0073b1;
                /* LinkedIn blue */
                cursor: pointer;
            }

            .card-text {
                font-size: 14px;
                color: #666;
                margin: 5px 0;
            }

            .btn-view-profile {
                background-color: #e76a35;
                color: #fff;
                border-radius: 25px;
                padding: 5px 15px;
                font-size: 14px;
                margin-top: 10px;
                cursor: pointer;
            }

            .btn-view-profile:hover {
                background-color: #e76a35;
            }
        </style> --}}


        {{-- <style>
            .profile-card {
                width: 320px;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
                background-color: #fff;
                margin: 20px auto;
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

            /* .btn-message {
                            background-color: #ff6b6b;
                            color: white;
                            border-radius: 50px;
                            padding: 6px 14px;
                            border: none;
                        } */

            .card-container {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                /* You can adjust column count */
                gap: 20px;
                justify-items: center;
            }
        </style> --}}


        {{-- <style>
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
        </style> --}}


        {{-- <style>
            /* Container for profile cards */
            .card-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                /* Centers the cards */
                gap: 20px;
                /* Adds spacing between cards */
                padding: 20px;
            }

            /* Profile card styling */
            .profile-card {
                width: 400px;
                /* Maintain the width */
                flex: 1 1 calc(33.33% - 40px);
                /* Allow 3 cards per row */
                min-width: 300px;
                /* Prevents cards from getting too small */
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                background-color: #fff;
                margin: 20px;
                transition: all 0.3s ease;
            }

            .profile-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            }

            /* Header image */
            .header-image {
                width: 100%;
                height: 120px;
                object-fit: cover;
            }

            /* Profile Image */
            .profile-img {
                width: 100px;
                height: 100px;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid #fff;
                margin-top: -50px;
            }

            /* Member Name */
            h5 {
                margin-top: 10px;
                margin-bottom: 4px;
                font-weight: 700;
            }

            /* Role/Position */
            .text-muted {
                color: #6c757d;
                font-size: 14px;
            }

            /* Info section (Email, Phone, Circle) */
            .info-section {
                display: flex;
                justify-content: space-around;
                margin-top: 15px;
                margin-bottom: 20px;
            }

            /* Icon text styling */
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

            /* Company & Category section */
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

            /* Divider between company & category */
            .divider {
                width: 1px;
                background-color: #ccc;
                height: auto;
                margin: 0 15px;
            }

            /* Company Name */
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

            /* Keywords section */
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

            /* Bottom Actions */
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

            /* Divider between bottom actions */
            .bottom-divider {
                width: 1px;
                background-color: #e0e0e0;
                height: auto;
            }

            /* Responsive Design */

            /* For tablets: 2 cards per row */
            @media (max-width: 1024px) {
                .profile-card {
                    flex: 1 1 calc(50% - 40px);
                }
            }

            /* For mobile: 1 card per row */
            @media (max-width: 768px) {
                .profile-card {
                    flex: 1 1 100%;
                }
            }
        </style> --}}

        <style>
            .card-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 30px;
                /* spacing between cards */
            }

            .profile-card {
                width: 400px;
                /* slightly reduced to fit 3 in a row nicely */
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                background-color: #fff;
                margin: 20px;
                /* changed from centered to spaced for flexbox */
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
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 50%;
                border: 4px solid #fff;
                margin-top: -50px;
            }

            h5 {
                margin-top: 10px;
                margin-bottom: 4px;
                font-weight: 700;
                color: #1d3268;
            }

            .position {
                color: #1d3268;
                font-size: 14px;
                /* font-weight: bold; */
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
                color: #e76a35;
                margin-bottom: 5px;
            }

            .company-category-section {
                display: flex;
                align-items: center;
                padding: 20px;
                border-top: 1px solid #f0f0f0;
                border-bottom: 1px solid #f0f0f0;
                gap: 20px;
            }

            .company-section,
            .category-section {
                flex: 1;
                min-width: 0;
                /* prevents overflow issues */
                text-align: center;
                word-wrap: break-word;
            }

            .company-section h2,
            .category-section h3 {
                white-space: normal;
                /* Allows text to wrap */
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                /* Limits to 2 lines */
                -webkit-box-orient: vertical;
                word-wrap: break-word;
                line-height: 1.4;
                /* Adjust for better readability */
                max-width: 100%;
            }

            .B-divider {
                width: 1px;
                background-color: #dcdcdc;
                height: 60px;
            }


            .logo-section {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 8px;
            }

            .logo-section img {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                object-fit: cover;
                border: 1px solid #e0e0e0;
            }

            .company-section h2,
            .category-section h3 {
                margin: 6px 0;
                color: #1d2951;
                font-size: 16px;
                font-weight: bold;
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
                justify-content: space-between;
                /* Move buttons to corners */
                align-items: center;
                border-top: 1px solid #e6e6e6;
                padding: 10px 0;
                text-align: center;
                width: 100%;

            }

            .action-button {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                font-weight: 600;
                color: #1d2951;
                transition: color 0.2s;
                text-decoration: none;
                padding: 10px;
                gap: 8px;
                /* Space between icon and text */
            }

            .action-button.connected {
                color: #e76a35 !important;
                /* Orange color for connected users */
            }


            .action-button i {
                font-size: 16px;
                /* Adjust icon size if needed */
            }

            .divider {
                width: 1px;
                background-color: #e6e6e6;
                height: 100px;
            }


            .bottom-actions div:hover {
                color: #e76a35;
            }

            .bottom-divider {
                width: 1px;
                background-color: #e0e0e0;
                height: 25px;
            }

            /* Responsive adjustments */
            @media screen and (max-width: 1200px) {
                .profile-card {
                    width: 280px;
                }
            }

            @media screen and (max-width: 1500px) {
                .profile-card {
                    width: 280px;
                }
            }

            @media screen and (max-width: 992px) {
                .profile-card {
                    width: 200px;
                }
            }

            @media screen and (max-width: 768px) {
                .profile-card {
                    width: 220px;
                }

                .icon-text {
                    font-size: 10px;
                }
            }

            @media screen and (max-width: 576px) {
                .profile-card {
                    width: 100%;
                }
            }

            @media screen and (max-width: 320px) {
                .profile-card {
                    width: 220px;
                }

                .icon-text {
                    font-size: 9px;
                }
            }


            .initials {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background-color: #c1c1c1;
                color: white;
                font-weight: bold;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
                /* mix-blend-mode: color-burn; */

            }
        </style>


        <script>
            var timeoutId;
            var inputElement = document.getElementById('searchInput');

            inputElement.addEventListener('input', function(event) {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function() {
                    var searchText = event.target.value;
                    performSearch(searchText);
                }, 500);
            });

            function performSearch(query) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/searchQuery?query=' + encodeURIComponent(query), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        displaySearchResults(response);
                    } else {
                        console.error('Request failed. Status:', xhr.status);
                    }
                };
                xhr.send();
            }

            function displaySearchResults(response) {

                console.warn(response);


                var searchResultsElement = document.getElementById('searchResults');
                searchResultsElement.innerHTML = ''; // Clear previous results

                var rowContainer = document.createElement('div');
                rowContainer.classList.add('row', 'g-4'); // g-4 for spacing between columns

                if (response && response.members && Array.isArray(response.members)) {
                    response.members.forEach(function(member) {
                        var col = document.createElement('div');
                        col.classList.add('col-12', 'col-sm-6', 'col-lg-4');
                        // 3 cards per row on md and above

                        var cardElement = document.createElement('div');
                        // cardElement.classList.add('profile-card');
                        cardElement.classList.add('profile-card', 'shadow-sm', 'rounded', 'border-0');

                        // Header image
                        var headerImg = document.createElement('img');
                        headerImg.src = '{{ asset('img/coverImage.png') }}';
                        headerImg.classList.add('header-image');
                        cardElement.appendChild(headerImg);

                        // Card body container
                        var cardBody = document.createElement('div');
                        cardBody.classList.add('text-center', 'p-3');

                        // Profile Image
                        var profileImg = document.createElement('img');
                        profileImg.classList.add('profile-img', 'img-fluid', 'rounded-circle', 'mx-auto', 'd-block');
                        profileImg.src = member.profilePhoto ?
                            `/ProfilePhoto/${member.profilePhoto}` :
                            'img/profile.png';

                        cardBody.appendChild(profileImg);


                        // Member Name
                        var memberName = document.createElement('h5');
                        memberName.textContent = `${capitalize(member.firstName)} ${capitalize(member.lastName)}`;
                        memberName.classList.add('member-name'); // Add class for easier debugging
                        cardBody.appendChild(memberName);

                        // Function to fetch roles from the database (users table) using member.userId
                        function getRoleFromDatabase(userId) {
                            console.log(`Fetching role from database for userId: ${userId}`);

                            return new Promise((resolve, reject) => {
                                $.ajax({
                                    url: `/get-user-role/${userId}`, // Adjust this URL based on your Laravel route
                                    method: "GET",
                                    dataType: "json",
                                    success: function(response) {
                                        console.log("Raw Roles from DB:", response.roles);

                                        // Ensure roles exist, filter out "Member"
                                        let roles = response.roles ? response.roles.filter(role => role !== "Member") : [];

                                        console.log("Filtered Roles (excluding 'Member'):", roles);
                                        resolve(roles);
                                    },
                                    error: function(error) {
                                        console.error("Error fetching roles:", error);
                                        reject(error);
                                    }
                                });
                            });
                        }

                        // Fetch the role and update UI
                        getRoleFromDatabase(member.userId)
                            .then(roles => {
                                // Create position element
                                var position = document.createElement('p');
                                position.classList.add('position');
                                console.log("Created position element.");

                                // Check if there's a valid role to display
                                if (roles.length > 0) {
                                    position.textContent = `${roles[0]}`;
                                    // position.textContent = `${roles[0]} at ${member.circle.circleName || ''}`;
                                    console.log(`Displaying Role: ${roles[0]} at ${member.circle.circleName || ''}`);
                                } else {
                                    position.textContent = `Member at ${member.circle.circleName || ''}`;
                                    console.log(`No valid role found. Displaying default: Member at ${member.circle.circleName || ''}`);
                                }

                                // Insert the position element **just after** the member name
                                memberName.insertAdjacentElement('afterend', position);
                                console.log("Inserted position element just below member name.");
                            })
                            .catch(error => {
                                console.error("Failed to fetch role:", error);
                            });



                        // Info Section (Email, Phone, Circle)
                        var infoSection = document.createElement('div');
                        infoSection.classList.add('info-section');

                        // Check if the user is connected (Accepted) or belongs to the same circle (Connected)
                        var isConnected = member.connection_status === 'Accepted' || member.connection_status === 'Connected';

                        function createIconText(iconClass, text, tooltipText = '') {
                            var container = document.createElement('div');
                            container.classList.add('icon-text');

                            var icon = document.createElement('i');
                            icon.classList.add(...iconClass.split(' '));
                            icon.style.color = '#787c80'; // Set icon color

                            var span = document.createElement('span');
                            span.textContent = text;

                            // Add tooltip only if tooltipText is provided
                            if (tooltipText) {
                                span.setAttribute('title', tooltipText);
                                span.classList.add('tooltip-text'); // Optional, for styling
                            }

                            container.appendChild(icon);
                            container.appendChild(span);

                            return container;
                        }

                        // Email text with tooltip for full email
                        var emailText = isConnected ?
                            (member.user?.email ? truncateText(member.user.email, 14) : 'No Email') :
                            '****';
                        var emailTooltip = isConnected ? (member.user?.email || '') : ''; // Full email for tooltip

                        var phoneText = isConnected ? (member.user?.contactNo || 'N/A') : '****';
                        var circleText = member.circle?.circleName || 'N/A';

                        var emailIconText = createIconText('bi bi-envelope-fill', emailText, emailTooltip);
                        var phoneIconText = createIconText('bi bi-telephone-fill', phoneText);
                        var circleIconText = createIconText('bi bi-people-fill', circleText);

                        infoSection.appendChild(emailIconText);
                        infoSection.appendChild(phoneIconText);
                        infoSection.appendChild(circleIconText);
                        cardBody.appendChild(infoSection);




                        // Company & Category Section
                        var companyCategorySection = document.createElement('div');
                        companyCategorySection.classList.add('company-category-section');

                        var companySection = document.createElement('div');
                        companySection.classList.add('company-section');
                        companySection.innerHTML = `
  <div class="logo-section">
    <img class="company-logo" src="${member.companyLogo ? `/CompanyLogo/${member.companyLogo}` : '/default-company-logo.png'}" 
      alt="Company Logo" 
      onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
    <div class="initials" style="display:none;">
      ${member.companyName ? member.companyName.charAt(0).toUpperCase() : 'C'}
    </div>
  </div>
  <h2 title="${member.companyName || 'Company Name'}">${member.companyName || 'Company Name'}</h2>
`;



                        var categorySection = document.createElement('div');
                        categorySection.classList.add('category-section');
                        categorySection.innerHTML = `<div class="label">Category</div><h3>${member.b_category?.categoryName || 'N/A'}</h3>`;

                        console.log('Member business category:', member.b_category?.categoryName);

                        var divider = document.createElement('div');
                        divider.classList.add('divider');

                        companyCategorySection.appendChild(companySection);
                        companyCategorySection.appendChild(divider);
                        companyCategorySection.appendChild(categorySection);
                        cardBody.appendChild(companyCategorySection);

                        // Keywords Section
                        var keywordsContainer = document.createElement('div');
                        keywordsContainer.classList.add('keywords-container', 'row');

                        console.log('Member keywords raw value:', member.keyWords); // Debugging log

                        var hasKeywords = false; // Flag to track if valid keywords exist

                        if (member.keyWords) {
                            try {
                                var keywordsArray = JSON.parse(member.keyWords);
                                console.log('Parsed keywords array:', keywordsArray); // Debugging log

                                if (Array.isArray(keywordsArray) && keywordsArray.length > 0) {
                                    keywordsArray.forEach(keyword => {
                                        if (keyword) {
                                            var keywordPill = document.createElement('span');
                                            keywordPill.classList.add('keyword-pill', 'col');
                                            keywordPill.textContent = keyword;
                                            keywordsContainer.appendChild(keywordPill);
                                            hasKeywords = true; // Set flag to true if at least one keyword exists
                                        }
                                    });
                                }
                            } catch (e) {
                                console.error('Error parsing keywords:', e);
                            }
                        }

                        // Hide the keywords container if no keywords are found
                        if (!hasKeywords) {
                            keywordsContainer.style.display = 'none';
                        }

                        cardBody.appendChild(keywordsContainer);
                        cardElement.appendChild(cardBody);


                        // Bottom Actions
                        var bottomActions = document.createElement('div');
                        bottomActions.classList.add('bottom-actions');

                        // View Profile Button
                        var viewProfile = createActionButton('bi bi-person-lines-fill', 'View Profile', `/foundPersonDetails/${member.id}`);
                        viewProfile.classList.add('action-button', 'left-action'); // Add custom class

                        // Divider Line
                        var divider = document.createElement('div');
                        divider.classList.add('B-divider');

                        // Connect Button
                        var connectButton;
                        if (member.connection_status === 'Connected') {
                            connectButton = createActionButton('bi bi-check-circle-fill', 'Connected', '#', true);
                            connectButton.classList.add('connected'); // Add class for orange color
                        } else if (member.connection_status === 'Accepted') {
                            connectButton = createActionButton('bi bi-check-circle-fill', 'Connected', '#', true);
                            connectButton.classList.add('connected'); // Add class for orange color
                        } else if (member.connection_status === 'Pending') {
                            connectButton = createActionButton('bi bi-hourglass-split', 'Requested', '#', true);
                        } else {
                            connectButton = createActionButton('bi bi-person-plus-fill', 'Connect', '#');
                            connectButton.addEventListener('click', function() {
                                sendConnectionRequest(member.id, connectButton);
                            });
                        }
                        connectButton.classList.add('action-button', 'right-action', 'btn', 'w-100'); // Add custom class


                        // Append elements
                        bottomActions.appendChild(viewProfile);
                        bottomActions.appendChild(divider);
                        bottomActions.appendChild(connectButton);
                        cardElement.appendChild(bottomActions);
                        col.appendChild(cardElement);
                        rowContainer.appendChild(col);



                        // Function to send connection request
                        function sendConnectionRequest(memberId, button) {
                            fetch('/connect', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Ensure CSRF token is included
                                    },
                                    body: JSON.stringify({
                                        memberId: memberId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        // Update button UI
                                        button.innerText = 'Requested';
                                        button.classList.remove('bi-person-plus-fill');
                                        button.classList.add('bi-hourglass-split');
                                        button.disabled = true; // Disable button after request

                                        // Show SweetAlert confirmation
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Connection Request Sent!',
                                            text: 'Your request has been successfully sent.',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK'
                                        });
                                    } else {
                                        // Show error alert if request failed
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops!',
                                            text: data.message || 'Something went wrong. Please try again.',
                                            confirmButtonColor: '#d33',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    // Show error alert in case of fetch failure
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Failed to send request. Please try again later.',
                                        confirmButtonColor: '#d33',
                                        confirmButtonText: 'OK'
                                    });
                                });
                        }




                    });
                } else {
                    searchResultsElement.innerHTML = '<p>No members found.</p>';
                }

                searchResultsElement.appendChild(rowContainer);
            }


            // Helper function to create icon-text elements
            function createIconText(iconClass, text) {
                var div = document.createElement('div');
                div.classList.add('icon-text');
                div.innerHTML = `<i class="${iconClass}"></i><div>${text}</div>`;
                return div;
            }

            // Helper function to create bottom action buttons
            function createActionButton(iconClass, text, link) {
                var div = document.createElement('div');
                div.innerHTML = `<i class="${iconClass}"></i>${text}`;
                div.style.cursor = 'pointer';
                div.onclick = function() {
                    window.location.href = link;
                };
                return div;
            }

            // Helper function to capitalize first letter of name
            function capitalize(str) {
                return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
            }

            // Helper function to truncate text
            function truncateText(text, maxLength) {
                return text.length > maxLength ? text.slice(0, maxLength) + '...' : text;
            }
        </script>

        {{-- <button class="btn-message" onclick="window.location.href='/chatWith/${member.id}'">Message</button> --}}

        {{-- <script>
        // Paste your JavaScript code here
        // Declare a variable to hold the timeout ID
        var timeoutId;

        // Get the input element
        var inputElement = document.getElementById('searchInput');

        // Add event listener for input event
        inputElement.addEventListener('input', function(event) {
            // Clear any previous timeout
            clearTimeout(timeoutId);

            // Set a new timeout for 500 milliseconds
            timeoutId = setTimeout(function() {
                // Get the value of the input field
                var searchText = event.target.value;

                // Log the text to the console or perform any other action
                console.log('Text from input (after typing):', searchText);

                // Call your search function here
                console.log('searchText', searchText);

                performSearch(searchText);
            }, 500); // Adjust the delay time as needed
        });


        // Function to perform the search using AJAX
        function performSearch(query) {
            // Make an AJAX request
            var xhr = new XMLHttpRequest();
            console.log("query", query);

            xhr.open('GET', '/searchQuery?query=' + encodeURIComponent(query), true);

            // Set up the callback function for when the request is complete
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Request was successful
                    // Parse the response and display the search results
                    var response = JSON.parse(xhr.responseText);
                    displaySearchResults(response);
                } else {
                    // Request failed
                    console.error('Request failed. Status:', xhr.status);
                }
            };

            // Send the request
            xhr.send();
        }

        // Function to display the search results
        function displaySearchResults(response) {
            var searchTextElement = document.querySelector('.searchText');
            var searchResultsElement = document.getElementById('searchResults');

            // Clear previous search results and messages
            searchTextElement.textContent = '';
            searchResultsElement.innerHTML = '';

            // Check if the response contains the expected structure
            if (response && response.message) {
                // Display search message
                searchTextElement.textContent = response.message;
            }
            console.log('response', response);

            if (response && response.members && Array.isArray(response.members)) {
                // Loop through the members array and create card elements
                response.members.forEach(function(member) {
                    console.log('member', member);
                    var cardElement = document.createElement('div');
                    cardElement.classList.add('card', 'mb-3');

                    var cardBody = document.createElement('div');
                    cardBody.classList.add('card-body');

                    // Name Row
                    var nameRow = document.createElement('div');
                    nameRow.classList.add('row');

                    var nameCol = document.createElement('div');
                    nameCol.classList.add('col-md-8');

                    var cardTitle = document.createElement('h5');
                    cardTitle.classList.add('card-title');
                    var nameText = document.createElement('span');
                    nameText.textContent = member.firstName + ' ' + member.lastName;
                    // Add click event listener to the card title (first name and last name)
                    nameText.addEventListener('click', function() {
                        // Get the route URL with the id concatenated
                        var routeURL = '/foundPersonDetails/' + member
                            .id; // Assuming the route follows this pattern

                        // Create an anchor tag
                        var anchorTag = document.createElement('a');

                        // Set the href attribute to the route URL
                        anchorTag.href = routeURL;

                        // Click the anchor tag to open the page
                        anchorTag.click();
                    });


                    nameText.style.cursor = "pointer";
                    cardTitle.appendChild(nameText); // Append the span element to the card title
                    nameCol.appendChild(cardTitle);
                    nameRow.appendChild(nameCol);

                    nameCol.appendChild(cardTitle);
                    nameRow.appendChild(nameCol);

                    // Email
                    if (member.user && member.user.email) {
                        var emailCol = document.createElement('div');
                        emailCol.classList.add('col-md-8', 'text-muted');

                        var cardEmail = document.createElement('p');
                        cardEmail.classList.add('card-text');
                        cardEmail.textContent = 'Email: ' + member.user.email;
                        emailCol.appendChild(cardEmail);

                        nameRow.appendChild(emailCol);
                    }

                    cardBody.appendChild(nameRow);

                    var cardText = document.createElement('p');
                    cardText.classList.add('card-text');
                    cardText.textContent = 'Circle Name: ' + member.circle.circleName; // Adjust as needed

                    // Button Element
                    var buttonWrapper = document.createElement('div');
                    // buttonWrapper.classList.add('text-end');

                    var button = document.createElement('button');
                    // button.innerHTML = `<i class="bi bi-person-plus-fill"></i> Connect`;
                    // button.classList.add('btn', 'btn-primary', 'btn-sm');

                    // Add click event listener to the button
                    button.addEventListener('click', function() {
                        // Perform action here when the button is clicked
                        // For example, make an AJAX call
                        console.log('clicked');
                        fetch('/connect', {
                                method: 'POST', // Adjust method as needed (e.g., 'GET', 'POST')
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                    // Add any additional headers if required
                                },
                                body: JSON.stringify({
                                    memberId: member.id // Assuming member ID is available
                                })
                            })
                            .then(response => {
                                if (response.ok) {
                                    return response.json();
                                } else {
                                    throw new Error('Network response was not ok');
                                }
                            })
                            .then(data => {
                                console.log(data);
                                // Perform any further actions based on the response
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                            });
                    });

                    // Append elements to card body
                    cardBody.appendChild(cardText);

                    // Append button to wrapper
                    buttonWrapper.appendChild(button);

                    // Append card body and button wrapper to card element
                    cardElement.appendChild(cardBody);
                    // cardElement.appendChild(buttonWrapper);

                    // Append card element to search results container
                    searchResultsElement.appendChild(cardElement);
                });
            } else {
                console.error('Invalid response format or missing data');
            }
        }
    </script> --}}


        <!-- sweetalert -->
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
    </body>

    </html>


@endsection
