<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Visitor Form</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




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



                        <h5 class="text-center mb-4" style="color: #1d3268;"><b>Visitor Registration Form</b></h5>
                        {{-- <h5 class="text-center mb-4">Please Fill the Form</h5> --}}
                        <form method="POST" action="{{ route('conquer.visitor.form.store') }}"
                            class="needs-validation w-100 form-card" id="visitorForm" name="visitorForm" novalidate>
                            @csrf

                            {{-- <input type="hidsden" name="userId" value="{{ Auth::user()->id }}"> --}}

                            <input type="hidden" name="eventId" value="{{ $event->id }}">

                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">First name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="firstName" name="firstName"
                                        value="{{ old('firstName') }}"
                                        class="form-control @error('firstName') is-invalid @enderror"
                                        onblur="validate(1)" required>
                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Last name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}"
                                        class="form-control @error('lastName') is-invalid @enderror"
                                        onblur="validate(2)" required>
                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Contact No<span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="contactNo" name="contactNo"
                                        value="{{ old('contactNo') }}"
                                        class="form-control @error('contactNo') is-invalid @enderror"
                                        oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                        pattern="[0-9]{10}"
                                        oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');"
                                        oninput="this.setCustomValidity('')" onblur="validate(3)" required>
                                    @error('contactNo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($errors->has('contactNo') && $errors->first('contactNo') == 'Please enter a valid 10-digit mobile number')
                                        <span class="invalid-feedback" role="alert" style="color: red;">
                                            <strong>{{ $errors->first('contactNo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Email<span
                                            class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        oninvalid="this.setCustomValidity('Please enter a valid email address');"
                                        oninput="this.setCustomValidity('')" required>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    @if ($errors->has('email') && $errors->first('email') == 'Please enter a valid email address')
                                        <span class="invalid-feedback" role="alert" style="color: red;">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row justify-content-between text-left">
                                <div class="form-group col-sm-6 flex-column d-flex">
                                    <label class="form-control-label px-3">Business Category<span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="businessCategory" name="businessCategory"
                                        class="form-control @error('businessCategory') is-invalid @enderror"
                                        onblur="validate(5)" required>
                                        <option value="" disabled selected>Select Business Category</option>
                                        @foreach ($businessCategory as $businessCategoryData)
                                            <option value="{{ $businessCategoryData->id }}"
                                                {{ old('businessCategory') == $businessCategoryData->id ? 'selected' : '' }}>
                                                {{ $businessCategoryData->categoryName }}
                                            </option>
                                        @endforeach
                                        <option value="other"
                                            {{ old('businessCategory') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>

                                    <!-- Input field for other category -->
                                    <div class="mt-3"></div>
                                    <input type="text" id="otherCategory" name="otherCategory"
                                        placeholder="Please specify your business category"
                                        class="form-control {{ old('businessCategory') == 'other' ? '' : 'd-none' }}"
                                        onblur="validate(5)" value="{{ old('otherCategory') }}">

                                    @error('businessCategory')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <script>
                                        const businessCategory = document.getElementById('businessCategory');
                                        const otherCategoryInput = document.getElementById('otherCategory');

                                        businessCategory.addEventListener('change', function() {
                                            if (this.value === 'other') {
                                                otherCategoryInput.classList.remove('d-none');
                                            } else {
                                                otherCategoryInput.classList.add('d-none');
                                                otherCategoryInput.value = ''; // Clear the input if it's hidden
                                            }
                                        });
                                    </script>
                                </div>
                            </div>

                            <div class="form-group col-auto">
                                <!-- Buttons -->
                                <button type="submit" class="btn btn-bg-blue" id="register">Submit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main><!-- End #main -->



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
