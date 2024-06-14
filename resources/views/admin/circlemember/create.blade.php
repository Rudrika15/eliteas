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
        <h5 class="card-title">Create Circle Member</h5>
        <a href="{{ route('circlemember.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="cityForm" enctype="multipart/form-data" method="post"
        action="{{ route('circlemember.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" data-error='Circle Field is required' required name="circleId"
                        id="circleId">
                        <option value="" selected disabled> Select Circle </option>
                        @foreach ($circle as $circleData)
                        <option value="{{ $circleData->id }}">{{ $circleData->circleName }}</option>
                        @endforeach
                    </select>
                    @error('circleId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select @error('businessCategory') is-invalid @enderror" id="businessCategory"
                        name="businessCategory">
                        <option value="" selected disabled>Select Business Category</option>
                        @foreach($businessCategory as $businessCategoryData)
                        <option value="{{ $businessCategoryData->id }}">{{ $businessCategoryData->categoryName }}
                        </option>
                        @endforeach
                    </select>
                    {{-- <label for="businessCategory">Business Category</label> --}}
                    @error('businessCategory')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Circle Field is required' required name="memberId"
                        id="memberId">
                        <option value="" selected disabled> Select Member </option>
                        @foreach ($member as $memberData)
                        <option value="{{ $memberData->id }}">{{ $memberData->firstName }} {{ $memberData->lastName }}
                        </option>
                        @endforeach
                    </select>
                    @error('memberId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div> --}}

        </div>



        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('title') is-invalid @enderror" id="title" name="title">
                        <option value="" selected disabled>Select Title</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Ms.">Ms.</option>
                        <option value="Mrs.">Mrs.</option>
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
                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                        name="firstName" placeholder="First Name">
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
                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                        name="lastName" placeholder="Last Name">
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
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" placeholder="User Name">
                    <label for="username">User Name</label>
                    @error('username')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="male" checked>
                        <label class="form-check-label" for="gender">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="female" checked>
                        <label class="form-check-label" for="gender">
                            Female
                        </label>
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
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Email">
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
                    <input type="text" class="form-control @error('mobileNo') is-invalid @enderror" id="mobileNo"
                        name="mobileNo" placeholder="Mobile No">
                    <label for="mobileNo">Mobile No</label>
                    @error('mobileNo')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('membershipType') is-invalid @enderror" id="membershipType"
                        name="membershipType">
                        <option value="" selected disabled>Select Membership Type</option>
                        @foreach($membershipType as $membershipTypeData)
                        <option value="{{ $membershipTypeData->id }}">{{ $membershipTypeData->membershipType }}
                        </option>
                        @endforeach
                    </select>
                    {{-- <label for="businessCategory">Business Category</label> --}}
                    @error('membershipType')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- <div class="col-md-6 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sendMail" name="sendMail" value="1">
                        <label class="form-check-label" for="sendMail">
                            Send Mail
                        </label>
                    </div>
                    @error('sendMail')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div> --}}

                <div class="col-md-9 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="sendMail" name="sendMail" value="1">
                        <label class="form-check-label" for="sendMail">
                            Send Mail <b>(If Payment is not Received)</b>
                        </label>
                    </div>
                    @error('sendMail')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="paymentStatus" name="paymentStatus"
                            value="1" onchange="toggleValue(this)">
                        <label class="form-check-label" for="paymentStatus">
                            Payment Recieved
                        </label>
                    </div>
                    @error('paymentStatus')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                    <input type="hidden" id="paymentId" name="paymentId" value="">
                </div>
                <script>
                    function toggleValue(element) {
                                        if(element.checked) {
                                            document.getElementById('paymentId').value = 'Offline';
                                        } else {
                                            document.getElementById('paymentId').value = '';
                                        }
                                    }
                </script>

            </div>
        </div>
</div>

<div class="text-center mt-3">
    <button type="submit" class="btn btn-bg-blue">Submit</button>
    <button type="reset" class="btn btn-bg-orange">Reset</button>
</div>
</form><!-- End floating Labels Form -->
</div>
<script>
    function previewPhoto(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
    var dataURL = reader.result;
    var img = document.getElementById('photoPreview');
    img.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
    }
</script>

<script>
    function previewPhoto(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
    var dataURL = reader.result;
    var img = document.getElementById('logoPreview');
    img.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
    }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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