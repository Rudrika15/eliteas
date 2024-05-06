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
</head>

<body>
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
                    <div class="card">
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

                                    <p class="text-secondary d-flex justify-content-center mb-1">{{ $member->skills }}
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
                                    @if (!$connection)
                                    <form action="{{ route('connect') }}" id="connectForm" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $member->id }}" name="memberId" id="">
                                        <button type="submit" class="btn btn-bg-blue shadow-none">Connect &nbsp;<i
                                                class="bi bi-person-plus-fill"></i></button>
                                    </form>
                                    @elseif ($connection->status == 'Accepted')
                                    <button type="button" class="btn btn-bg-blue shadow-none">Connected &nbsp;<i
                                            class="bi bi-check-circle-fill"></i></button>
                                    @elseif ($connection->status == 'Rejected')
                                    <button type="submit" class="btn btn-bg-blue shadow-none">Connect &nbsp;<i
                                            class="bi bi-person-plus-fill"></i></button>
                                    @else
                                    <button type="button" class="btn btn-bg-blue shadow-none">Requested &nbsp;<i
                                            class="bi bi-clock"></i></button>
                                    @endif



                                    {{-- <button class="btn btn-outline-primary">Message</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-globe mr-2 icon-inline">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="2" y1="12" x2="22" y2="12"></line>
                                        <path
                                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                        </path>
                                    </svg>Website</h6>
                                <span class="text-secondary">{{ $member->webSite }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-github mr-2 icon-inline">
                                        <path
                                            d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                        </path>
                                    </svg>Github</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-twitter mr-2 icon-inline text-info">
                                        <path
                                            d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                        </path>
                                    </svg>Twitter</h6>
                                <span class="text-secondary">@bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-instagram mr-2 icon-inline text-danger">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                        </rect>
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                    </svg>Instagram</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-facebook mr-2 icon-inline text-primary">
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                        </path>
                                    </svg>Facebook</h6>
                                <span class="text-secondary">bootdey</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
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
                    </div>


                    {{-- <div class="row gutters-sm"> --}}
                        {{-- <div class="col-lg-6 col-sm-6 mb-3"> --}}
                            {{-- <div class="accordion " id="accordionExample">
                                <!-- Accordion Item 1 -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed shadow-none" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
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
                                                        <li><b> Spouse : </b> {{ $member->topsProfile->spouse ?? '-' }}
                                                        </li>
                                                        <hr>
                                                        <li><b> Childrens : </b> {{ $member->topsProfile->children ??
                                                            '-' }}
                                                        </li>
                                                        <hr>
                                                        <li><b> Pets : </b> {{ $member->topsProfile->pets ?? '-' }}</li>
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
                                                            {{ $member->topsProfile->myIdealRefPartner ?? '-' }}</li>
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
                                                    <h4 class="card-title text-orange text-center">Gains Profile</h4>
                                                    <hr>
                                                    <ul class="list-unstyled">
                                                        <li><b> Goals : </b> {{ $member->goals ?? '-' }}</li>
                                                        <li><b> Accomplishment : </b> {{ $member->accomplishment ?? '-'
                                                            }}</li>
                                                        <li><b> Interests : </b> {{ $member->interests ?? '-' }}</li>
                                                        <li><b> Networks : </b> {{ $member->networks ?? '-' }}</li>
                                                        <li><b> Skills : </b> {{ $member->skills ?? '-' }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card">
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active text-blue" id="bios-tab" data-bs-toggle="tab"
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
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content" id="myTabsContent">
                                        <div class="tab-pane fade active show " id="bios" role="tabpanel"
                                            aria-labelledby="bios-tab">
                                            <!-- Bios Content -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- Your content for My Bios goes here -->
                                                    <h4 class="card-title text-orange text-center">My Bios</h4>
                                                    <hr>
                                                    <ul class="list-unstyled">
                                                        <div class="row ">
                                                            <div class="col">
                                                                <li><b> Years In Business </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->yearsInBusiness ?? '-'
                                                                        }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Previous Types Of Jobs </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->prevJobs ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Spouse </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->spouse ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Childrens </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->children ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Pets </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->pets ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                            </div>
                                                            <div class="col">
                                                                <li><b> Hobbies & Interests </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->hobbiesInterests ?? '-'
                                                                        }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> City Of Residence </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->cityofRes ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Years In City </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->yearsInCity ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> My Burning Desire </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->myBurningDesire ?? '-'
                                                                        }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Something No One Here Knows About Me </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->dontKnowAboutMe ?? '-'
                                                                        }}
                                                                    </p>
                                                                </li>
                                                                <hr>

                                                            </div>
                                                            <li class="text-center"><b> My Key To Success </b>
                                                                <p class="text-secondary">
                                                                    {{ $member->topsProfile->mKeyToSuccess ?? '-' }}
                                                                </p>
                                                            </li>

                                                        </div>
                                                        <hr>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tops" role="tabpanel" aria-labelledby="tops-tab">
                                            <!-- Tops Profile Content -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- Your content for Tops Profile goes here -->
                                                    <h4 class="card-title text-orange text-center">Tops Profile</h4>
                                                    <hr>
                                                    <ul class="list-unstyled">
                                                        <div class="row">
                                                            <div class="col">
                                                                <li><b> Ideal Referral </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->idealRef ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Top Product </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->topProduct ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>

                                                            </div>
                                                            <div class="col">
                                                                <li><b> My Fav. BNI Story </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->myFavBniStory ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> My Ideal Ref. Partner </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->topsProfile->myIdealRefPartner ??
                                                                        '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                            </div>
                                                            <li class="text-center"><b> Top Problem Solved </b>
                                                                <p class="text-secondary">
                                                                    {{ $member->topsProfile->topProblemSolved ?? '-' }}
                                                                </p>
                                                            </li>

                                                        </div>
                                                        <hr>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="gains" role="tabpanel"
                                            aria-labelledby="gains-tab">
                                            <!-- Gains Profile Content -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- Your content for Gains Profile goes here -->
                                                    <h4 class="card-title text-orange text-center">Gains Profile</h4>
                                                    <hr>

                                                    <ul class="list-unstyled">
                                                        <div class="row">
                                                            <div class="col">
                                                                <li><b> Goals </b>
                                                                    <p class="text-secondary"> {{ $member->goals ?? '-'
                                                                        }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Accomplishment </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->accomplishment ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                            </div>
                                                            <div class="col">
                                                                <li><b> Interests </b>
                                                                    <p class="text-secondary">
                                                                        {{ $member->interests ?? '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                                <li><b> Networks </b>
                                                                    <p class="text-secondary"> {{ $member->networks ??
                                                                        '-' }}
                                                                    </p>
                                                                </li>
                                                                <hr>
                                                            </div>
                                                            <li class="text-center"><b> Skills </b>
                                                                <p class="text-secondary"> {{ $member->skills ?? '-' }}
                                                                </p>
                                                            </li>

                                                        </div>
                                                        <hr>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--
                        </div> --}}

                        {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script> --}}
    {{-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
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