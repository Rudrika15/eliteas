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
    {{-- add csrf --}}
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
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
                        <li>Title = {{ $member->title }}</li>
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
                            {{ $member->contactDetails->billingAddress }}
                        </li>
                        <li>Phone = {{ $member->contactDetails->phone }}</li>
                        <li>Direct Number = {{ $member->contactDetails->directNo }}</li>
                        <li>Home = {{ $member->contactDetails->phone }}</li>
                        <li>Mobile Number {{ $member->contactDetails->mobileNo }}</li>
                        <li>Pager = {{ $member->contactDetails->pager }}</li>
                        <li>voice Mail = {{ $member->contactDetails->voiceMail }}</li>
                        <li>Toll Free = {{ $member->contactDetails->tollFree }}</li>
                        <li>Fax = {{ $member->contactDetails->fax }}</li>
                        <li>E-mail = {{ $member->contactDetails->email }}</li>

                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">

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
{{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script> --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

</html>
