@extends('layouts.master')

@section('header', 'City')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

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
                        <option value="" selected disabled>Select Circle</option>
                        @foreach ($circle as $circleData)
                        <option value="{{ $circleData->id }}" {{ old('circleId')==$circleData->id ? 'selected' : '' }}>
                            {{ $circleData->circleName }}
                        </option>
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
                        name="businessCategory" required>
                        <option value="" selected disabled>Select Business Category</option>
                        @foreach($businessCategory as $businessCategoryData)
                        <option value="{{ $businessCategoryData->id }}">{{ $businessCategoryData->categoryName }}
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
        </div>

        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                        name="firstName" placeholder="First Name" required value="{{ old('firstName') }}">
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
                        name="lastName" placeholder="Last Name" required value="{{ old('lastName') }}">
                    <label for="lastName">Last Name</label>
                    @error('lastName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="Email" required value="{{ old('email') }}">
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
                        name="mobileNo" placeholder="Mobile No" value="{{ old('mobileNo') }}" pattern="[0-9]{10}"
                        oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                        oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');"
                        oninput="this.setCustomValidity('')">
                    <label for="mobileNo">Mobile No</label>
                    @error('mobileNo')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                    @if ($errors->has('mobileNo') && $errors->first('mobileNo') == 'Please enter a valid 10-digit mobile
                    number')
                    <div class="invalid-tooltip" style="color: red;">
                        {{ $errors->first('mobileNo') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('title') is-invalid @enderror" id="title" name="title" {{
                        old('title') ? 'value="' . old('title') . '"' : '' }} required>
                        <option value="" selected disabled>Select Title</option>
                        <option value="Mr." {{ old('title')==='Mr.' ? 'selected' : '' }}>Mr.</option>
                        <option value="Ms." {{ old('title')==='Ms.' ? 'selected' : '' }}>Ms.</option>
                        <option value="Mrs." {{ old('title')==='Mrs.' ? 'selected' : '' }}>Mrs.</option>
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
                <div class="form-check">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" checked>
                        <label class="form-check-label" for="genderMale" @required(true)>
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female">
                        <label class="form-check-label" for="genderFemale" @required(true)>
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
        </div>


        <div class="row">
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('membershipType') is-invalid @enderror" id="membershipType"
                        name="membershipType" onchange="fetchMembershipAmount(this.value)" required>
                        <option value="" selected disabled>Select Membership Type</option>
                        @foreach($membershipType as $membershipTypeData)
                        <option value="{{ $membershipTypeData->id }}">{{ $membershipTypeData->membershipType }}
                            {{ old('membershipType') }}
                        </option>
                        @endforeach
                    </select>
                    <label for="membershipType">Membership Type</label>
                    @error('membershipType')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="membershipAmount" name="membershipAmount"
                        placeholder="Membership Amount" readonly>
                    <label for="membershipAmount">Membership Amount</label>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Discount Amount Checkbox -->
            <div class="col-md-6 mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="discountAmount" name="discountAmount" value="1"
                        onchange="toggleFields(this)">
                    <label class="form-check-label" for="discountAmount">
                        Discount Amount
                    </label>
                </div>
            </div>
            <!-- Discounted Amount Input -->
            <div class="col-md-6 mt-3" id="discountedAmountContainer" style="display:none;">
                <div class="form-floating">
                    <input type="text" class="form-control" id="discountedAmount" name="discountedAmount"
                        placeholder="Discounted Amount" value="{{ old('discountedAmount') }}">
                    <label for="discountedAmount">Discounted Amount</label>
                </div>
            </div>
            <!-- Total Amount Input -->
            <div class="col-md-6 mt-3" id="totalAmountContainer" style="display:none;">
                <div class="form-floating">
                    <input type="text" class="form-control" id="totalAmount" name="totalAmount"
                        placeholder="Total Amount" readonly>
                    <label for="totalAmount">Total Amount</label>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="text" class="form-control" id="date" name="date" placeholder="Date" readonly
                        value="{{ date('Y-m-d') }}">
                    <label for="date">Date</label>
                    @error('date')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mt-3">
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
                    <input class="form-check-input" type="checkbox" id="paymentModeCheck" name="paymentModeCheck"
                        value="1" onchange="togglePaymentMode(this)">
                    <label class="form-check-label" for="paymentModeCheck">
                        Select Payment Mode
                    </label>
                </div>
            </div>
        </div>

        <div class="row" id="paymentModeContainer" style="display:none;">
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('paymentMode') is-invalid @enderror" id="paymentMode"
                        name="paymentMode">
                        <option value="" selected disabled>Select Payment Mode</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque</option>
                        <option value="neft">NEFT</option>
                        <option value="rtgs">RTGS</option>
                    </select>
                    <label for="paymentMode">Payment Mode</label>
                    @error('paymentMode')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form>
</div>
</div>

<script>
    function toggleDiscountAmount(checkbox) {
        var discountedAmountContainer = document.getElementById('discountedAmountContainer');
        discountedAmountContainer.style.display = checkbox.checked ? 'block' : 'none';

        // Calculate total amount when discount amount changes
        calculateTotalAmount();
    }

    function calculateTotalAmount() {
        var membershipAmount = parseFloat(document.getElementById('membershipAmount').value) || 0;
        var discountedAmount = parseFloat(document.getElementById('discountedAmount').value) || 0;

        var totalAmount = membershipAmount - discountedAmount;

        // Update the total amount field
        document.getElementById('totalAmount').value = totalAmount.toFixed(2); // Assuming you want to display it as a decimal
    }
</script>

<script>
    // Add event listener for membership amount change (assuming it changes based on selection)
    document.getElementById('membershipType').addEventListener('change', function() {
        // Fetch membership amount when membership type changes
        fetchMembershipAmount(this.value);
    });

    // Add event listener for discounted amount change
    document.getElementById('discountedAmount').addEventListener('input', function() {
        // Recalculate total amount whenever discounted amount changes
        calculateTotalAmount();
    });
</script>

<script>
    function fetchMembershipAmount(membershipTypeId) {
        if (membershipTypeId) {
            $.ajax({
                url: '{{ route('get.membership.amount') }}', // Update with your actual route for fetching the membership amount
                type: 'POST',
                data: {
                    membershipTypeId: membershipTypeId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#membershipAmount').val(data.amount);
                },
                error: function() {
                    $('#membershipAmount').val('');
                }
            });
        } else {
            $('#membershipAmount').val('');
        }
    }
</script>

<script>
    function toggleFields(checkbox) {
    var discountedAmountContainer = document.getElementById('discountedAmountContainer');
    var totalAmountContainer = document.getElementById('totalAmountContainer');
    
    console.log("Checkbox checked: ", checkbox.checked);
    console.log("Discounted Amount Container: ", discountedAmountContainer);
    console.log("Total Amount Container: ", totalAmountContainer);

    if (checkbox.checked) {
        discountedAmountContainer.style.display = 'block';
        totalAmountContainer.style.display = 'block';
    } else {
        discountedAmountContainer.style.display = 'none';
        totalAmountContainer.style.display = 'none';
    }
}

    function togglePaymentMode(checkbox) {
        var paymentModeContainer = document.getElementById('paymentModeContainer');
        paymentModeContainer.style.display = checkbox.checked ? 'block' : 'none';
    }

    (function () {
        'use strict'

        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>

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