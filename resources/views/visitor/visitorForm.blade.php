<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Visitor Form</title>
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

    <!-- Additional CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />



    <style>
        /* body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background-image:
                url("https://i.imgur.com/GMmCQHC.png");
            background-repeat: no-repeat;
            background-size: 100% 100%
        } */

        .card {
            padding: 30px 40px;
            margin-top: 10px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
        }


        .form-control-label {
            margin-bottom: 0
        }

        input,
        textarea,
        button {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 12px !important;
            font-weight: 20
        }

        /* input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #00BCD4;
            outline-width: 0;
            font-weight:
                200
        } */



        /* button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0
        } */
    </style>




</head>

<body>

    <main>
        <div class="container-fluid px-1 py-5 mx-auto">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="#" class="main-logo d-flex align-items-center">
                            <img src="{{ asset('img/logo2.jpg') }}" alt=""
                                style="background-color: #F5E9E2; mix-blend-mode: multiply; width: 150px; height:100px;">
                            {{-- <span class="d-none d-lg-block">Elite</span> --}}
                        </a>
                    </div><!-- End Logo -->
                    <div class="card p-3" style="border-radius: 10px; background-color: rgba(255, 255, 255, 0.699);">
                        {{-- <div class="card p-3" style="border-radius: 10px;"> --}}
                            {{-- <div class="card"> --}}

                                @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert" id="success-alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert">
                                                {{-- <i class="fa fa-times"></i> --}}
                                            </button>
                                            <strong>Success !</strong> {{ session('success') }}
                                        </div>
                                        <script>
                                            setTimeout(function() {
                                        $('#success-alert').fadeOut('fast');
                                    }, 5000); // <-- time in milliseconds
                                        </script>
                                        @endif

                                        @if (Session::has('error'))
                                        <div class="alert alert-danger alert-dismissible" role="alert" id="error-alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert">
                                                        {{-- <i class="fa fa-times"></i> --}}
                                                    </button>
                                                    <strong>Error !</strong> {{ session('error') }}
                                                </div>
                                                <script>
                                                    setTimeout(function() {
                                        $('#error-alert').fadeOut('fast');
                                    }, 5000); // <-- time in milliseconds
                                                </script>
                                                @endif



                                                <h5 class="text-center mb-4">Please Fill the Form</h5>
                                                <form method="POST" action="{{ route('visitor.form.store') }}"
                                                    class="needs-validation w-100 form-card" novalidate>
                                                    @csrf
                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">First name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="firstName" name="firstName"
                                                                value="{{ old('firstName') }}"
                                                                class="form-control @error('firstName') is-invalid @enderror"
                                                                onblur="validate(1)">
                                                            @error('firstName')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Last name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="lastName" name="lastName"
                                                                value="{{ old('lastName') }}"
                                                                class="form-control @error('lastName') is-invalid @enderror"
                                                                onblur="validate(2)">
                                                            @error('lastName')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Mobile No<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="mobileNo" name="mobileNo"
                                                                value="{{ old('mobileNo') }}"
                                                                class="form-control @error('mobileNo') is-invalid @enderror"
                                                                onblur="validate(3)">
                                                            @error('mobileNo')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Business Name<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="businessName" name="businessName"
                                                                value="{{ old('businessName') }}"
                                                                class="form-control @error('businessName') is-invalid @enderror"
                                                                onblur="validate(4)">
                                                            @error('businessName')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Business
                                                                Category<span class="text-danger">*</span></label>
                                                            <input type="text" id="businessCategory"
                                                                name="businessCategory"
                                                                value="{{ old('businessCategory') }}"
                                                                class="form-control @error('businessCategory') is-invalid @enderror"
                                                                onblur="validate(5)">
                                                            @error('businessCategory')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Product /
                                                                Service<span class="text-danger">*</span></label>
                                                            <input type="text" id="product" name="product"
                                                                value="{{ old('product') }}"
                                                                class="form-control @error('product') is-invalid @enderror"
                                                                onblur="validate(6)">
                                                            @error('product')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-between text-left">
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Are you part of any
                                                                networking group?<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="networkingGroup"
                                                                name="networkingGroup"
                                                                value="{{ old('networkingGroup') }}"
                                                                class="form-control @error('networkingGroup') is-invalid @enderror"
                                                                onblur="validate(7)">
                                                            @error('networkingGroup')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-sm-6 flex-column d-flex">
                                                            <label class="form-control-label px-3">Circle Meet<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" id="circleMeet" name="circleMeet"
                                                                value="{{ old('circleMeet') }}"
                                                                class="form-control @error('circleMeet') is-invalid @enderror"
                                                                onblur="validate(8)">
                                                            @error('circleMeet')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="form-group col-sm-3">
                                                            <button type="submit"
                                                                class="btn-sm btn-primary">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                        </div>
                                </div>
                            </div>
                        </div>
    </main><!-- End #main -->

    <script>
        function validate(val) {
        v1 = document.getElementById("firstName");
        v2 = document.getElementById("lastName");
        v3 = document.getElementById("mobileNo");
        v4 = document.getElementById("businessName");
        v5 = document.getElementById("businessCategory");
        v6 = document.getElementById("product");
        v6 = document.getElementById("networkingGroup");
        v6 = document.getElementById("circleMeet");
        
        flag1 = true;
        flag2 = true;
        flag3 = true;
        flag4 = true;
        flag5 = true;
        flag6 = true;
        
        if(val>=1 || val==0) {
        if(v1.value == "") {
        v1.style.borderColor = "red";
        flag1 = false;
        }
        else {
        v1.style.borderColor = "green";
        flag1 = true;
        }
        }
        
        if(val>=2 || val==0) {
        if(v2.value == "") {
        v2.style.borderColor = "red";
        flag2 = false;
        }
        else {
        v2.style.borderColor = "green";
        flag2 = true;
        }
        }
        if(val>=3 || val==0) {
        if(v3.value == "") {
        v3.style.borderColor = "red";
        flag3 = false;
        }
        else {
        v3.style.borderColor = "green";
        flag3 = true;
        }
        }
        if(val>=4 || val==0) {
        if(v4.value == "") {
        v4.style.borderColor = "red";
        flag4 = false;
        }
        else {
        v4.style.borderColor = "green";
        flag4 = true;
        }
        }
        if(val>=5 || val==0) {
        if(v5.value == "") {
        v5.style.borderColor = "red";
        flag5 = false;
        }
        else {
        v5.style.borderColor = "green";
        flag5 = true;
        }
        }
        if(val>=6 || val==0) {
        if(v6.value == "") {
        v6.style.borderColor = "red";
        flag6 = false;
        }
        else {
        v6.style.borderColor = "green";
        flag6 = true;
        }
        }
        
        flag = flag1 && flag2 && flag3 && flag4 && flag5 && flag6;
        
        return flag;
        }

    </script>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

    <!-- Additional JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>