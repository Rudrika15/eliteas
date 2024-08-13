{{--
<!doctype html>
<html lang="en">

<head>
    <title>UBN - Details </title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Admin</title>
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
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <main>
        <div class="p-4">
            <div class="d-flex align-items-center justify-content-center bg-light rounded-circle mt-5  mx-auto"
                style="width: 100px; height: 90px;">
                <img src="{{ asset('ProfilePhoto/' . $member->profilePhoto) }}" class="card-img-top rounded-circle"
                    alt="Profile Photo">
                <h1> {{ $member->firstName . ' ' . $member->lastName }} </h1>
            </div>
            <hr>
            <div class="row mt-5">
                <div class="col">
                    <h2>Personal information</h2>
                    <ul>
                        <li><b> Title = {{ $member->title }}</li>
                        <li> Suffix = {{ $member->suffix }}</li>
                        <li> Display Name = {{ $member->displayName }}</li>
                        <li> Company Name = {{ $member->companyName }}</li>
                        <li> Gender = {{ $member->gender }}</li>
                    </ul>
                </div>
                <div class="col">
                    <h2>Product/Service Description</h2>
                    <ul>
                        <li>GST Registered State = {{ $member->gstRegiState }} </li>
                        <li>GSTIN / PAN = {{ $member->gstinPan }}</li>
                        <li>Industry = {{ $member->industry }}</li>
                        <li>Classification = {{ $member->classification }} </li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row mt-3">
                <div class="col">
                    <h2>Speciality</h2>
                    <ul>
                        <li>Chapter = {{ $member->chapter }}</li>
                        <li>Renewal Date = {{ $member->renewalDueDate }}</li>
                        <li>Membership Status = {{ $member->membershipStatus }}</li>
                        <li>My Businesses = {{ $member->myBusiness }}</li>
                        <li>keywords = {{ $member->keyWords ?? '-' }}</li>
                    </ul>
                </div>
                <div class="col">
                    <h2>Contact Details</h2>
                    <ul>
                        <li>Billing Address =
                            {{ $member->billingAddress->addressLine1 ?? '-' }}
                        </li>
                        <li>Phone = {{ $member->contactDetails->phone ?? '-' }}</li>
                        <li>Direct Number = {{ $member->contactDetails->directNo ?? '-' }}</li>
                        <li>Home = {{ $member->contactDetails->phone ?? '-' }}</li>
                        <li>Mobile Number {{ $member->contactDetails->mobileNo ?? '-' }}</li>
                        <li>Pager = {{ $member->contactDetails->pager ?? '-' }}</li>
                        <li>voice Mail = {{ $member->contactDetails->voiceMail ?? '-' }}</li>
                        <li>Toll Free = {{ $member->contactDetails->tollFree ?? '-' }}</li>
                        <li>Fax = {{ $member->contactDetails->fax ?? '-' }}</li>
                        <li>E-mail = {{ $member->contactDetails->email ?? '-' }}</li>

                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h2>Billing Address</h2>
                    <ul>
                        <li>Address Line 1 = {{ $member->billingAddress->bAddressLine1 ?? '-' }}</li>
                        <li>Address Line 2 = {{ $member->billingAddress->bAddressLine2 ?? '-' }}</li>
                        <li>City = {{ $member->billingAddress->bCity ?? '-' }}</li>
                        <li>State = {{ $member->billingAddress->bState ?? '-' }}</li>
                        <li>Country = {{ $member->billingAddress->bCountry ?? '-' }}</li>
                        <li>Pincode = {{ $member->billingAddress->bPinCode ?? '-' }}</li>
                    </ul>
                </div>
                <div class="col">
                    <h2>Address</h2>
                    <ul>
                        <li>Address Line 1 = {{ $member->contactDetails->addressLine1 ?? '-' }}</li>
                        <li>Address Line 2 = {{ $member->contactDetails->addressLine2 ?? '-' }}</li>
                        <li>City = {{ $member->contactDetails->city ?? '-' }}</li>
                        <li>State = {{ $member->contactDetails->state ?? '-' }}</li>
                        <li>Country = {{ $member->contactDetails->country ?? '-' }}</li>
                        <li>Pincode = {{ $member->contactDetails->pinCode ?? '-' }}</li>
                    </ul>

                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h2>Tops Profile</h2>
                    <ul>
                        <li>Ideal Referral = {{ $member->topsProfile->idealRef ?? '-' }} </li>
                        <li>Top Product = {{ $member->topsProfile->topProduct ?? '-' }}</li>
                        <li>Top Problem Solved = {{ $member->topsProfile->topProblemSolved ?? '-' }}</li>
                        <li>My Fav. BNI Story = {{ $member->topsProfile->myFavBniStory ?? '-' }}</li>
                        <li>My Ideal Ref. Partner = {{ $member->topsProfile->myIdealRefPartner ?? '-' }}</li>
                    </ul>
                </div>
                <div class="col">
                    <h2>Gains Profile</h2>
                    <ul>
                        <li>Goals = {{ $member->goals ?? '-' }}</li>
                        <li>Accomplishment = {{ $member->accomplishment ?? '-' }}</li>
                        <li>Interests = {{ $member->interests ?? '-' }}</li>
                        <li>Networks = {{ $member->networks ?? '-' }}</li>
                        <li>Skills = {{ $member->skills ?? '-' }}</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <h2>Weekly Presentation</h2>
                    <ul>
                        <li>Presentation 1 = {{ $member->topsProfile->weeklyPresent1 ?? '-' }}</li>
                        <li>Presentation 2 = {{ $member->topsProfile->weeklyPresent2 ?? '-' }}</li>
                    </ul>
                </div>
                <div class="col">
                    <h2>My Bios</h2>
                    <ul>
                        <li>Years In Business = {{ $member->topsProfile->yearsInBusiness ?? '-' }}</li>
                        <li>Previous Types Of Jobs = {{ $member->topsProfile->prevJobs ?? '-' }}</li>
                        <li>Spouse = {{ $member->topsProfile->spouse ?? '-' }}</li>
                        <li>Childrens = {{ $member->topsProfile->childrens ?? '-' }}</li>
                        <li>Pets = {{ $member->topsProfile->pets ?? '-' }}</li>
                        <li>Hobbies & Interests = {{ $member->topsProfile->hobbiesIntersets ?? '-' }}</li>
                        <li>City Of Residence = {{ $member->topsProfile->cityOfRes ?? '-' }}</li>
                        <li>Years In City = {{ $member->topsProfile->yearsInCity ?? '-' }}</li>
                        <li>My Burning Desire = {{ $member->topsProfile->myBurningDesire ?? '-' }}</li>
                        <li>Something No One Here Knows About Me = {{ $member->topsProfile->dontKnowAboutMe ?? '-' }}
                        </li>
                        <li>My Key To Success = {{ $member->topsProfile->mKeyToSuccess ?? '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>FlipCode Solutions</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="#">FlipCode</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
</body>


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
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>UBN - Profile Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />

    <div class="pt-3 px-3">
        <div class="row">
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset('img/logo4.png') }}" alt="UBN" class="pb-2" width="100"
                    style="max-width: 100%; height: auto;">
            </div>
        </div>

        <style>
            @media (max-width: 768px) {
                .col-md-1 {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
            }

            /* Styles for screens less than 768px wide */
            @media (max-width: 767px) {
                .back-btn3 {
                    display: none;
                }

                .back-btn2 {
                    display: inline-block;
                }
            }

            /* Styles for screens 768px wide and up */
            @media (min-width: 768px) {
                .back-btn3 {
                    display: inline-block;
                }

                .back-btn2 {
                    display: none;
                }
            }
        </style>




        <style type="text/css">
            body {
                margin-top: 20px;
                color: #1a202c;
                text-align: left;
                background-color: #e2e8f0;
            }

            .main-body {
                padding: 15px;
            }

            .card {
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            }

            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 0 solid rgba(0, 0, 0, .125);
                border-radius: .25rem;
            }

            .card-body {
                flex: 1 1 auto;
                min-height: 1px;
                padding: 1rem;
            }

            .gutters-sm {
                margin-right: -8px;
                margin-left: -8px;
            }

            .gutters-sm>.col,
            .gutters-sm>[class*=col-] {
                padding-right: 8px;
                padding-left: 8px;
            }

            .mb-3,
            .my-3 {
                margin-bottom: 1rem !important;
            }

            .bg-gray-300 {
                background-color: #e2e8f0;
            }

            .h-100 {
                height: 100% !important;
            }

            .shadow-none {
                box-shadow: none !important;
            }

            .btn-bg-orange {
                background-color: #e76a35 !important;
                color: white !important;
            }

            .btn-bg-blue {
                background-color: #1d2856 !important;
                color: white !important;
            }

            /* text-icon colors */
            .text-orange {
                color: #e76a35 !important;
            }

            .text-blue {
                color: #1d2856;
            }
        </style>

        <style>
            /* Modal styling */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 90%;
                max-width: 600px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                display: none;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .memberName {
                font-weight: bold;
                font-size: 18px;
                margin-bottom: 10px;

            }

            .chat-container {
                display: flex;
                flex-direction: column;
                height: 400px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #fff;
                overflow: hidden;
            }

            .chat-box {
                flex: 1;
                padding: 10px;
                overflow-y: scroll;
                margin-bottom: 10px;
                background-color: #f9f9f9;
                scrollbar-width: none;
                /* For Firefox */
            }

            .chat-box::-webkit-scrollbar {
                display: none;
                /* For Chrome, Safari, and Edge */
            }

            .input-container {
                display: flex;
                padding: 10px;
                border-top: 1px solid #ddd;
                background-color: #fff;
            }

            #chatInput {
                flex: 1;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 20px;
                margin-right: 10px;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            #sendButton {
                padding: 10px 20px;
                background-color: #e76a35;
                color: white;
                border: none;
                border-radius: 20px;
                cursor: pointer;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            #sendButton:hover {
                background-color: #1d3268;
            }

            .message {
                padding: 10px;
                margin: 5px 0;
                border-radius: 20px;
                max-width: 80%;
                /* Adjusts the maximum width of the message box */
                word-wrap: break-word;
                position: relative;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                font-size: 14px;
                display: block;
                /* Changed to block to ensure each message is on a new line */
                clear: both;
                /* Ensures messages don't appear on the same line */
            }

            .sender {
                background-color: #1d3268;
                color: white;
                text-align: right;
                margin-left: auto;
                border-radius: 20px 20px 0 20px;
                float: right;
                /* Aligns sender messages to the right */
            }

            .receiver {
                background-color: #e76a35;
                color: white;
                text-align: left;
                margin-right: auto;
                border-radius: 20px 20px 20px 0;
                float: left;
                /* Aligns receiver messages to the left */
            }

            /* Optional: add a small triangle for speech bubble effect */
            .message::after {
                content: "";
                position: absolute;
                border-width: 10px;
                border-style: solid;
            }

            .sender::after {
                border-color: #1d3268 transparent transparent transparent;
                /* right: -15px; */
                top: 10px;
                border-width: 10px 15px 10px 0;
            }

            .receiver::after {
                border-color: #e76a35 transparent transparent transparent;
                left: -5px;
                top: 10px;
                border-width: 10px 0 10px 15px;
            }
        </style>

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
        var memberIdElement = document.getElementById('memberId');
        console.log('Member ID Element:', memberIdElement);
        if (memberIdElement) {
            console.log('Member ID Value:', memberIdElement.value);
        }
    });
        </script> --}}
</head>

<body class="">
    {{--

    <body class="" style=" mix-blend-mode: multiply; background: linear-gradient(to right, #1d2856, #e76a35);"> --}}
        <div class="container">
            <div class="main-body">

                {{-- <nav aria-label="breadcrumb" class="main-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                    </ol>
                </nav> --}}

                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card ">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @php
                                    $profilePhoto = $member->profilePhoto;
                                    @endphp

                                    @if ($profilePhoto && file_exists(public_path('ProfilePhoto/' . $profilePhoto)))
                                    <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="ProfilePhoto"
                                        class="rounded-circle" width="150">
                                    @else
                                    <img src="{{ asset('ProfilePhoto/profile.png') }}" alt="ProfilePhoto"
                                        class="rounded-circle" width="100">
                                    @endif
                                    <div class="mt-3">
                                        <h4 class="text-blue">{{ $member->title . ' ' . $member->displayName }}</h4>

                                        <p class="text-secondary d-flex justify-content-center mb-1">{{ $member->skills
                                            }}
                                            &#x2022 {{ $member->suffix }}
                                            &#x2022 {{ $member->gender }}
                                            &#x2022 {{ $member->industry }}

                                        </p>

                                        <p class="text-muted font-size-sm">
                                            {{ $member->contactDetails->addressLine1 ?? '-' }}
                                            {{ $member->contactDetails->addressLine2 ?? '-' }}
                                            {{ $member->contactDetails->city ?? '-' }} ,
                                            {{ $member->contactDetails->state ?? '-' }}
                                        </p>
                                        @if (!$memberStatus)
                                        <form action="{{ route('connect') }}" id="connectForm" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{ $member->user->id }}" name="memberId"
                                                id="memberId">
                                            <button type="submit" class="btn btn-bg-blue shadow-none">Connect &nbsp;<i
                                                    class="bi bi-person-plus-fill"></i></button>
                                        </form>

                                        @elseif ($memberStatus->status == 'Accepted')
                                        <button type="button" class="btn btn-bg-blue shadow-none">Connected &nbsp;<i
                                                class="bi bi-check-circle-fill"></i></button>

                                        @elseif ($memberStatus->status == 'Rejected')
                                        <button type="submit" class="btn btn-bg-blue shadow-none">Connect &nbsp;<i
                                                class="bi bi-person-plus-fill"></i></button>

                                        @else
                                        <button type="button" class="btn btn-bg-blue shadow-none">Requested &nbsp;<i
                                                class="bi bi-clock"></i></button>
                                        @endif
                                        <a href="javascript:history.back()"
                                            class="btn btn-bg-orange back-btn2 ">Back</a>
                                    </div>
                                    {{-- {{ $member->user->id }} {{ $member->user->id }} {{$memberStatus->status}} --}}
                                    <div class="mt-3">
                                        <input type="hidden" value="{{ $member->user->id }}" name="memberId"
                                            id="memberId">
                                        @if(!empty($memberStatus))
                                        @if($memberStatus->status == 'Accepted')
                                        <button id="messageButton" class="btn btn-bg-orange">Message</button>
                                        @endif
                                        @else
                                        <button id="messageButton" class="btn btn-bg-orange disabled">Message</button>
                                        @endif
                                    </div>
                                    <!-- Message Button -->
                                    {{-- <button id="messageButton">Message</button> --}}

                                    <!-- Chat Modal -->
                                    <div id="chatModal" class="modal">
                                        <div class="modal-content">
                                            <span class="close">&times;</span>
                                            <div class="member-image">
                                                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}"
                                                    alt="profilePhoto" style="height:50px; width:50px;"
                                                    class="rounded-circle">
                                            </div>
                                            <span class="memberName">{{ $member->user->firstName }} {{
                                                $member->user->lastName }}</span>
                                            <div class="chat-container">
                                                <div id="chatBox" class="chat-box"></div>
                                                <div class="input-container">
                                                    <input type="hidden" value="{{ $member->user->id }}" name="memberId"
                                                        id="memberId">
                                                    <input type="text" id="chatInput" placeholder="Type a message...">
                                                    <button id="sendButton">Send</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        {{-- <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->firstName ?? '-' }} {{ $member->lastName }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->contactDetails->email ?? '-' }}
                                    </div>

                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Company Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->companyName }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Language</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->language }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->contactDetails->phone ?? '-' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Mobile No</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->contactDetails->mobileNo ?? '-' }}
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Billing Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $member->billingAddress->bAddressLine1 ?? '-' }}
                                        {{ $member->billingAddress->bAddressLine2 ?? '-' }} <br>
                                        {{ $member->billingAddress->bCity ?? '-' }}
                                        {{ $member->billingAddress->bState ?? '-' }}
                                        {{ $member->billingAddress->bPinCode ?? '-' }}
                                    </div>
                                </div>

                            </div>
                        </div> --}}


                        {{-- <div class="row gutters-sm"> --}}
                            {{-- <div class="col-lg-6 col-sm-6 mb-3"> --}}
                                {{-- <div class="accordion " id="accordionExample">
                                    <!-- Accordion Item 1 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed shadow-none" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                My Bios
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="card shadow">
                                                    <div class="card-body">
                                                        <h4 class="card-title text-orange text-center">My Bios</h4>
                                                        <hr>
                                                        <ul class="list-unstyled">
                                                            <li><b> Years In Business : </b>
                                                                {{ $member->topsProfile->yearsInBusiness ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> Previous Types Of Jobs : </b>
                                                                {{ $member->topsProfile->prevJobs ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> Spouse : </b> {{ $member->topsProfile->spouse ?? '-'
                                                                }}
                                                            </li>
                                                            <hr>
                                                            <li><b> Childrens : </b> {{ $member->topsProfile->children
                                                                ??
                                                                '-' }}
                                                            </li>
                                                            <hr>
                                                            <li><b> Pets : </b> {{ $member->topsProfile->pets ?? '-' }}
                                                            </li>
                                                            <hr>
                                                            <li><b> Hobbies & Interests : </b>
                                                                {{ $member->topsProfile->hobbiesInterests ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> City Of Residence : </b>
                                                                {{ $member->topsProfile->cityofRes ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> Years In City : </b>
                                                                {{ $member->topsProfile->yearsInCity ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> My Burning Desire : </b>
                                                                {{ $member->topsProfile->myBurningDesire ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> Something No One Here Knows About Me : </b>
                                                                {{ $member->topsProfile->dontKnowAboutMe ?? '-' }}</li>
                                                            <hr>
                                                            <li><b> My Key To Success : </b>
                                                                {{ $member->topsProfile->mKeyToSuccess ?? '-' }}</li>
                                                            <hr>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Accordion Item 2 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed shadow-none" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                Tops Profile
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title text-orange text-center">Tops Profile</h4>
                                                        <hr>
                                                        <ul class="list-unstyled">
                                                            <li><b> Ideal Referral : </b>
                                                                {{ $member->topsProfile->idealRef ?? '-' }}</li>
                                                            <li><b> Top Product : </b>
                                                                {{ $member->topsProfile->topProduct ?? '-' }}</li>
                                                            <li><b> Top Problem Solved : </b>
                                                                {{ $member->topsProfile->topProblemSolved ?? '-' }}</li>
                                                            <li><b> My Fav. BNI Story : </b>
                                                                {{ $member->topsProfile->myFavBniStory ?? '-' }}</li>
                                                            <li><b> My Ideal Ref. Partner : </b>
                                                                {{ $member->topsProfile->myIdealRefPartner ?? '-' }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Accordion Item 3 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button collapsed shadow-none" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">
                                                Gains Profile
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title text-orange text-center">Gains Profile
                                                        </h4>
                                                        <hr>
                                                        <ul class="list-unstyled">
                                                            <li><b> Goals : </b> {{ $member->goals ?? '-' }}</li>
                                                            <li><b> Accomplishment : </b> {{ $member->accomplishment ??
                                                                '-'
                                                                }}</li>
                                                            <li><b> Interests : </b> {{ $member->interests ?? '-' }}
                                                            </li>
                                                            <li><b> Networks : </b> {{ $member->networks ?? '-' }}</li>
                                                            <li><b> Skills : </b> {{ $member->skills ?? '-' }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="card ">
                            <div class="card-body">
                                <a href="javascript:history.back()"
                                    class="btn btn-bg-orange back-btn3 float-end">Back</a>

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="myTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active text-blue" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                            aria-selected="true">My Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link  text-blue" id="bios-tab" data-bs-toggle="tab"
                                            data-bs-target="#bios" type="button" role="tab" aria-controls="bios"
                                            aria-selected="true">My Bios</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-blue" id="tops-tab" data-bs-toggle="tab"
                                            data-bs-target="#tops" type="button" role="tab" aria-controls="tops"
                                            aria-selected="false">Tops Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-blue" id="gains-tab" data-bs-toggle="tab"
                                            data-bs-target="#gains" type="button" role="tab" aria-controls="gains"
                                            aria-selected="false">Gains Profile</button>
                                    </li>

                                    {{-- {{$member->user->id}} --}}

                                    <li class="nav-item ms-3 mb-3">
                                        <span
                                            class="badge rounded-pill {{ $member->user->userStatus == 'Online' ? 'bg-success' : 'bg-danger' }}"
                                            style="font-size: 12px;padding: 5px 10px;color: #fff;display: inline-block;margin-top: 5px;">
                                            {{$member->title}}{{ $member->user->firstName }} {{
                                            $member->user->userStatus == 'Online' ? 'is Online' : 'is Offline' }}
                                        </span>
                                        </a>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content" id="myTabsContent">
                                    <div class="tab-pane fade active show " id="profile" role="tabpanel"
                                        aria-labelledby="profile-tab">
                                        <!-- Bios Content -->
                                        <div class="card shadow-none">
                                            <div class="card-body">
                                                <!-- Your content for My Bios goes here -->
                                                <h4 class="card-title text-orange text-center">My Profile</h4>
                                                <hr>
                                                {{-- <ul class="list-unstyled"> --}}
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Full Name</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->firstName ?? '-' }} {{ $member->lastName }}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Email</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->contactDetails->email ?? '-' }}
                                                        </div>

                                                    </div>
                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Company Name</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->companyName }}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Language</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->language }}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Phone</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->contactDetails->phone ?? '-' }}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Mobile No</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->contactDetails->mobileNo ?? '-' }}
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <h6 class="mb-0">Billing Address</h6>
                                                        </div>
                                                        <div class="col-sm-9 text-secondary">
                                                            {{ $member->billingAddress->bAddressLine1 ?? '-' }}
                                                            {{ $member->billingAddress->bAddressLine2 ?? '-' }} <br>
                                                            {{ $member->billingAddress->bCity ?? '-' }}
                                                            {{ $member->billingAddress->bState ?? '-' }}
                                                            {{ $member->billingAddress->bPinCode ?? '-' }}
                                                        </div>
                                                        {{--
                                                </ul> --}}

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="bios" role="tabpanel" aria-labelledby="bios-tab">
                                    <!-- Bios Content -->
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <!-- Your content for My Bios goes here -->
                                            <h4 class="card-title text-orange text-center">My Bios</h4>
                                            <hr>
                                            {{-- <ul class="list-unstyled"> --}}
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Years In Business</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->yearsInBusiness ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Previous Types Of Jobs</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->prevJobs ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Spouse</h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->spouse ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Childrens </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->children ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Pets </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->pets ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Hobbies & Interests </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->hobbiesInterests ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">City Of Residence </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->cityofRes ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">Years In City </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->yearsInCity ?? '-' }}
                                                    </div>
                                                </div>
                                                {{--
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0">My Burning Desire </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->myBurningDesire ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Something No One Here Knows About Me </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->dontKnowAboutMe ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> My Key To Success </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->mKeyToSuccess ?? '-' }}
                                                    </div>
                                                </div> --}}

                                                {{--
                                            </ul> --}}

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tops" role="tabpanel" aria-labelledby="tops-tab">
                                    <!-- Tops Profile Content -->
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <!-- Your content for Tops Profile goes here -->
                                            <h4 class="card-title text-orange text-center">Tops Profile</h4>
                                            <hr>
                                            {{-- <ul class="list-unstyled"> --}}
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Ideal Referral </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->idealRef ?? '-' }}
                                                    </div>

                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Top Product </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->topProduct ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> My Fav. BNI Story </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->myFavBniStory ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> My Ideal Ref. Partner </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->myIdealRefPartner ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Top Problem Solved </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->topsProfile->topProblemSolved ?? '-' }}
                                                    </div>
                                                </div>

                                                {{--
                                            </ul> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="gains" role="tabpanel" aria-labelledby="gains-tab">
                                    <!-- Gains Profile Content -->
                                    <div class="card shadow-none">
                                        <div class="card-body">
                                            <!-- Your content for Gains Profile goes here -->
                                            <h4 class="card-title text-orange text-center">Gains Profile</h4>
                                            <hr>

                                            {{-- <ul class="list-unstyled"> --}}
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Goals </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->goals ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Accomplishment </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->accomplishment ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Interests </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->interests ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Networks </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->networks ?? '-' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <h6 class="mb-0"> Skills </h6>
                                                    </div>
                                                    <div class="col-sm-9 text-secondary">
                                                        {{ $member->skills ?? '-' }}
                                                    </div>
                                                </div>
                                                {{--
                                            </ul> --}}

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script> --}}
        {{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js">
        </script>
        --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            // Get elements
            console.log('Getting elements');
            var modal = document.getElementById("chatModal");
            var btn = document.getElementById("messageButton");
            var span = document.getElementsByClassName("close")[0];
            var chatBox = document.getElementById("chatBox");
            var chatInput = document.getElementById("chatInput");
            var sendButton = document.getElementById("sendButton");
            var pollingInterval;
            console.log('Got elements');
        
            // Open the modal
            btn.onclick = function() {
                console.log('Button clicked');
                modal.style.display = "block";
                console.log('Modal displayed');
                fetchMessages();  // Fetch messages when the modal is opened
                startPolling();   // Start polling for new messages
            }
        
            // Close the modal
            span.onclick = function() {
                console.log('Close button clicked');
                modal.style.display = "none";
                console.log('Modal hidden');
                stopPolling(); // Stop polling when the modal is closed
            }
        
            // Close the modal when clicking outside of it
            window.onclick = function(event) {
                console.log('Window clicked');
                if (event.target == modal) {
                    console.log('Modal clicked');
                    modal.style.display = "none";
                    console.log('Modal hidden');
                    stopPolling(); // Stop polling when clicking outside the modal
                }
            }
        
            // Handle sending a message
            sendButton.onclick = function() {
                console.log('Send button clicked');
                sendMessage();
            }
        
            chatInput.addEventListener("keypress", function(event) {
                console.log('Key pressed');
                if (event.key === "Enter") {
                    console.log('Enter key pressed');
                    sendMessage();
                }
            });
        
            function fetchMessages() {
                const authCheck = `{{Auth::user()->id}}`;
                console.log("authCheck", authCheck);
        
                $.get('/get-messages', function(messages) {
                    console.log('Got messages');
                    chatBox.innerHTML = ''; // Clear existing messages
                    messages.forEach(function(message) {
                        var messageElement = document.createElement("div");
                        if (message.senderId == authCheck) {
                            messageElement.className = "message sender"; // Sender's message
                        } else if (message.receiverId == authCheck) {
                            messageElement.className = "message receiver"; // Receiver's message
                        }
                        messageElement.textContent = message.content;
                        chatBox.appendChild(messageElement);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching messages: ', textStatus, errorThrown);
                });
            }
        
            function sendMessage() {
                console.log('Sending message');
                var message = chatInput.value.trim();
                var memberIdElement = document.getElementById('memberId');
        
                console.log('Checking for memberId element:', memberIdElement);
                if (!memberIdElement) {
                    console.error('Element with ID "memberId" not found');
                    alert('Member ID is missing. Cannot send message.');
                    return;
                }
        
                var receiverId = memberIdElement.value;
                console.log('Receiver ID:', receiverId);
        
                if (message && receiverId) {
                    $.post('/send-message', {
                        message: message,
                        userId: receiverId,
                        _token: '{{ csrf_token() }}'
                    }).done(function(response) {
                        console.log('Message sent: ' + response.status);
                        if (response.status === 'Message sent') {
                            var messageElement = document.createElement("div");
                            messageElement.className = "message sender"; // Sender's message
                            messageElement.textContent = message;
                            chatBox.appendChild(messageElement);
                            chatInput.value = "";
                            chatBox.scrollTop = chatBox.scrollHeight;
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.error('Error sending message: ', textStatus, errorThrown);
                    });
                }
            }
        
            function startPolling() {
                pollingInterval = setInterval(fetchMessages, 1000); // Poll every 1 seconds
            }
        
            function stopPolling() {
                clearInterval(pollingInterval);
            }
        </script>


        <script>
            // JavaScript to handle form submission
                document.addEventListener('DOMContentLoaded', function() {
                    var connectForm = document.getElementById('connectForm');
                    if (connectForm) {
                        connectForm.addEventListener('submit', function(event) {
                            event.preventDefault(); // Prevent default form submission
                            var form = this;

                            // Submit the form via AJAX
                            fetch(form.action, {
                                    method: form.method,
                                    body: new FormData(form)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Check if the request was successful
                                    if (data && data.message) {
                                        // Show SweetAlert notification
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success!',
                                            text: data.message
                                        }).then(() => {
                                            // Reload the page after the success message is displayed
                                            window.location.reload();
                                        });
                                    } else {
                                        // Show error message if something went wrong
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        });
                                    }
                                })
                                .catch(error => {
                                    // Show error message if there was an error with the request
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!'
                                    });
                                });
                        });
                    }
                });
        </script>

    </body>

</html>