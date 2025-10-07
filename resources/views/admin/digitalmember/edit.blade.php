@extends('layouts.master')

@section('header', 'City')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Digital Member</h5>
            <a href="{{ route('digitalMember.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        {{-- {{$member}} --}}
        <form class="m-3 needs-validation" id="circlememberForm" enctype="multipart/form-data" method="post" action="{{ route('digitalMember.update', $member->id) }}" novalidate>
            @csrf

            <input type="hidden" name="memberId" value="{{ $member->id }}">
            <div class="row mb-3">


                <div class="accordion" id="accordionExample">
                    <!-- Section 1 -->
                    <div class="accordion-item mt-3">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Personal Information
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <select class="form-select @error('businessCategory') is-invalid @enderror" id="businessCategory" name="businessCategory">
                                                <option value="" disabled>Select Business Category</option>
                                                @foreach ($businessCategory as $businessCategoryData)
                                                    <option value="{{ $businessCategoryData->id }}" {{ old('businessCategoryId', $member->businessCategoryId) == $businessCategoryData->id ? 'selected' : '' }}>
                                                        {{ $businessCategoryData->categoryName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('businessCategory')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <select class="form-select @error('title') is-invalid @enderror" id="title" name="title">
                                                <option value="" selected disabled>Select Title</option>
                                                <option value="Mr." {{ old('title', $member->title) === 'Mr.' ? 'selected' : '' }}>
                                                    Mr.</option>
                                                <option value="Ms." {{ old('title', $member->title) === 'Ms.' ? 'selected' : '' }}>
                                                    Ms.</option>
                                                <option value="Mrs." {{ old('title', $member->title) === 'Mrs.' ? 'selected' : '' }}>
                                                    Mrs.</option>
                                            </select>
                                            <label for="title">Title</label>
                                            @error('title')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ $member->firstName }}" placeholder="First Name">
                                            <label for="firstName">First Name</label>
                                            @error('firstName')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ $member->lastName }}" placeholder="Last Name">
                                            <label for="lastName">Last Name</label>
                                            @error('lastName')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ \App\Models\User::where('id', $member->userId)->value('email') ?? '' }}" placeholder="email">
                                            <label for="email">Email</label>
                                            @error('email')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="contactNo" name="contactNo" value="{{ \App\Models\User::where('id', $member->userId)->value('contactNo') ?? '' }}" placeholder="contactNo">
                                            <label for="contactNo">Mobile No</label>
                                            @error('contactNo')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" {{ $member->gender === 'male' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="genderMale">Male</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" {{ $member->gender === 'female' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="genderFemale">Female</label>
                                            </div>
                                            @error('gender')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('companyName') is-invalid @enderror" id="companyName" name="companyName" value="{{ $member->companyName }}" placeholder="Company Name">
                                            <label for="companyName">Company Name</label>
                                            @error('companyName')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('gstinPan') is-invalid @enderror" id="gstinPan" name="gstinPan" value="{{ $member->gstinPan }}" placeholder="GSTIN / PAN">
                                            <label for="gstinPan">GSTIN / PAN </label>
                                            @error('gstinPan')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="longText" class="form-control @error('keyWords') is-invalid @enderror" id="keyWords" name="keyWords" value="{{ $member->keyWords }}" placeholder="keyWords">
                                            <label for="keyWords">Keywords (Comma Seperated)</label>
                                            @error('keyWords')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('addressLine1') is-invalid @enderror" id="addressLine1" name="addressLine1" value="{{ $member->contactDetails->addressLine1 ?? '-' }}" placeholder="Address Line 1">
                                            <label for="addressLine1">Address Line 1</label>
                                            @error('addressLine1')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('addressLine2') is-invalid @enderror" id="addressLine2" name="addressLine2" value="{{ $member->contactDetails->addressLine2 ?? '-' }}" placeholder="addressLine2">
                                            <label for="addressLine2">Address Line 2 </label>
                                            @error('addressLine2')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('webSite') is-invalid @enderror" id="webSite" name="webSite" value="{{ $member->webSite }}" placeholder="webSite">
                                            <label for="webSite">Website</label>
                                            @error('webSite')
                                                <div class="invalid-tooltip">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-label-group mt-3">
                                            <label for="profilePhoto" class="fw-bold">Profile Photo <sup class="text-danger">*</sup></label>
                                            <input type="file" class="form-control @error('profilePhoto') is-invalid @enderror" id="profilePhoto" name="profilePhoto" accept="image/*" onchange="previewPhoto(event, 'photoPreview')">
                                            <span class="text-danger mt-1 d-block">*
                                                File size:Max 2MB</span>
                                            <div style="width: 100px; height: 100px; position: relative;" class="mt-3">
                                                <img id="photoPreview" src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'default.jpg')) }}" style="width: 100%; height: 100%; object-fit: contain; aspect-ratio: 1/1;">
                                            </div>

                                            <!-- Display Profile Photo Error -->
                                            @error('profilePhoto')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-label-group mt-3">
                                            <label for="companyLogo" class="fw-bold">Company Logo <sup class="text-danger">*</sup></label>
                                            <input type="file" class="form-control @error('companyLogo') is-invalid @enderror" id="companyLogo" name="companyLogo" accept="image/*" onchange="previewPhoto(event, 'logoPreview')">
                                            <span class="text-danger mt-1 d-block">*
                                                File size:Max 2MB</span>
                                            <div style="width: 100px; height: 100px; position: relative;" class="mt-3">
                                                <img id="logoPreview" src="{{ asset('CompanyLogo/' . ($member->companyLogo ?? 'default.jpg')) }}" style="width: 100%; height: 100%; object-fit: contain; aspect-ratio: 1/1;">
                                            </div>

                                            <!-- Display Company Logo Error -->
                                            @error('companyLogo')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                            <!-- Note about file size -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-bg-blue">Submit</button>
                            <button type="reset" class="btn btn-bg-orange">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function previewPhoto(event, previewId) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var img = document.getElementById(previewId);
                img.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>



    <script>
        $(document).ready(function() {
            $('#bCountry').change(function() {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '{{ route('get.states') }}', // Replace with your route for fetching states
                        type: 'POST',
                        data: {
                            countryId: countryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#bState').html(data);
                            $('#bCity').html('<option value="">Select City</option>');
                        }
                    });
                } else {
                    $('#bState').html('<option value="">Select State</option>');
                    $('#bCity').html('<option value="">Select City</option>');
                }
            });

            $('#bState').change(function() {
                var stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: '{{ route('get.cities') }}', // Replace with your route for fetching cities
                        type: 'POST',
                        data: {
                            stateId: stateId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#bCity').html(data);
                        }
                    });
                } else {
                    $('#bCity').html('<option value="">Select City</option>');
                }
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#country').change(function() {
                var countryId = $(this).val();
                if (countryId) {
                    $.ajax({
                        url: '{{ route('get.states') }}', // Replace with your route for fetching states
                        type: 'POST',
                        data: {
                            countryId: countryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#state').html(data);
                            $('#city').html('<option value="">Select City</option>');
                        }
                    });
                } else {
                    $('#state').html('<option value="">Select State</option>');
                    $('#city').html('<option value="">Select City</option>');
                }
            });

            $('#state').change(function() {
                var stateId = $(this).val();
                if (stateId) {
                    $.ajax({
                        url: '{{ route('get.cities') }}', // Replace with your route for fetching cities
                        type: 'POST',
                        data: {
                            stateId: stateId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#city').html(data);
                        }
                    });
                } else {
                    $('#city').html('<option value="">Select City</option>');
                }
            });
        });
    </script>


@endsection
