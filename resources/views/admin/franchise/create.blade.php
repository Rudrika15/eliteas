@extends('layouts.master')

@section('header', 'Franchise')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif --}}

<div class="container">
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Franchise</h5>
            <a href="{{ route('franchise.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="franchiseForm" enctype="multipart/form-data" method="post"
            action="{{ route('franchise.store') }}" novalidate>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('franchiseName') is-invalid @enderror"
                            id="franchiseName" name="franchiseName" placeholder="Franchise Name" required>
                        <label for="franchiseName">Franchise Name</label>
                        @error('franchiseName')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('franchiseContactDetails') is-invalid @enderror"
                            id="franchiseContactDetails" name="franchiseContactDetails"
                            placeholder="Franchise Contact Details" required pattern="[0-9]{1,10}" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10">
                        <label for="franchiseContactDetails">Franchise Contact Details</label>
                        @error('franchiseContactDetails')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('countryId') is-invalid @enderror" id="countryId"
                            name="countryId" required>
                            <option value="" selected disabled>Select Country</option>
                            @foreach ($countries as $countryData)
                            <option value="{{ $countryData->id }}">{{ $countryData->countryName }}</option>
                            @endforeach
                        </select>
                        @error('countryId')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('stateId') is-invalid @enderror" id="stateId" name="stateId"
                            required>
                            <option value="" selected disabled>Select State</option>
                        </select>
                        @error('stateId')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <select class="form-select @error('cityId') is-invalid @enderror" id="cityId" name="cityId"
                            required>
                            <option value="" selected disabled>Select City</option>
                        </select>
                        @error('cityId')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Email" required>
                        <label for="email">Email</label>
                        @error('email')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                            name="firstName" placeholder="First Name" required>
                        <label for="firstName">First Name</label>
                        @error('firstName')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                            name="lastName" placeholder="Last Name" required>
                        <label for="lastName">Last Name</label>
                        @error('lastName')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize state and city dropdowns to be empty on page load
        $('#stateId').html('<option value="">Select State</option>');
        $('#cityId').html('<option value="">Select City</option>');

        // Handle country change event
        $('#countryId').change(function () {
            var countryId = $(this).val();
            console.log('Country selected: ', countryId);
            if (countryId) {
                $.ajax({
                    url: '{{ route('get.states') }}', // Replace with your route for fetching states
                    type: 'POST',
                    data: {
                        countryId: countryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        console.log('States data: ', data);
                        $('#stateId').html('<option value="">Select State</option>'); // Default option
                        $('#stateId').append(data); // Append states to dropdown
                        $('#cityId').html('<option value="">Select City</option>'); // Reset city dropdown
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching states: ', error);
                    }
                });
            } else {
                console.log('No country selected, resetting state and city dropdowns');
                $('#stateId').html('<option value="">Select State</option>');
                $('#cityId').html('<option value="">Select City</option>');
            }
        });

        // Handle state change event
        $('#stateId').change(function () {
            var stateId = $(this).val();
            console.log('State selected: ', stateId);
            if (stateId) {
                $.ajax({
                    url: '{{ route('get.cities') }}', // Replace with your route for fetching cities
                    type: 'POST',
                    data: {
                        stateId: stateId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        console.log('Cities data: ', data);
                        $('#cityId').html('<option value="">Select City</option>'); // Default option
                        $('#cityId').append(data); // Append cities to dropdown
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching cities: ', error);
                    }
                });
            } else {
                console.log('No state selected, resetting city dropdown');
                $('#cityId').html('<option value="">Select City</option>');
            }
        });
    });

</script>

@endsection