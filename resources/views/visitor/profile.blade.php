@extends('layouts.masterVisitor')

@section('title', 'UBN - Visitor Update Profile')
@section('content')

    {{-- Success and Error Messages --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Profile Update Form --}}
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">My Profile</h5>
        </div>

        <form class="m-3 needs-validation" id="visitorForm" enctype="multipart/form-data" method="post"
            action="{{ route('visitor.profileUpdate', session('visitor_id')) }}" novalidate>
            @csrf

            <input type="hidden" name="id" value="{{ $visitor->id }}">

            {{-- Personal Details --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="firstName" name="firstName"
                            placeholder="First Name" value="{{ $visitor->firstName }}" required>
                        <label for="firstName">First Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="lastName" name="lastName"
                            placeholder="Last Name" value="{{ $visitor->lastName }}" required>
                        <label for="lastName">Last Name</label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="birthDate" name="birthDate"
                            placeholder="Birth Date" value="{{ $visitor->birthDate }}" required>
                        <label for="birthDate">Birth Date</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender"
                                id="genderMale" value="male"
                                {{ $visitor->gender === 'male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderMale">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender"
                                id="genderFemale" value="female"
                                {{ $visitor->gender === 'female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="genderFemale">Female</label>
                        </div>
                        @error('gender')
                            <div class="invalid-tooltip">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Business Information --}}
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('businessCategory') is-invalid @enderror"
                            id="businessCategory" name="businessCategory"
                            value="{{ $visitor->bCategory->categoryName ?? '-' }}"
                            placeholder="Business Category" readonly>
                        <label for="businessCategory">Business Category</label>
                        @error('businessCategory')
                            <div class="invalid-tooltip">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Email" value="{{ $visitor->email }}" required readonly>
                        <label for="email">Email</label>
                    </div>
                </div>
            </div>

            {{-- Contact Details --}}
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="tel" class="form-control" id="mobileNo" name="mobileNo"
                            placeholder="Mobile Number" value="{{ $visitor->mobileNo }}">
                        <label for="mobileNo">Mobile Number</label>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form>
    </div>

    {{-- Image Preview Script --}}
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

@endsection
