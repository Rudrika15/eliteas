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
        <h5 class="card-title">Create City</h5>
        <a href="{{ route('city.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="cityForm" enctype="multipart/form-data" method="post"
        action="{{ route('city.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='State Name Field is required' required name="countryId"
                        id="countryId">
                        <option value="" selected disabled> Select Country </option>
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
                    <select class="form-control" data-error='State Name Field is required' required name="stateId"
                        id="stateId">
                        <option value="" selected disabled> Select State </option>
                        @foreach ($states as $stateData)
                        <option value="{{ $stateData->id }}">{{ $stateData->stateName }}</option>
                        @endforeach
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
                    <input type="text" class="form-control @error('cityName') is-invalid @enderror" id="stateName"
                        name="cityName" placeholder="City Name" required>
                    <label for="cityName">City Name</label>
                    @error('cityName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                        name="amount" placeholder="amount" required>
                    <label for="amount">Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('memberAmount') is-invalid @enderror"
                        id="memberAmount" name="memberAmount" placeholder="memberAmount" required>
                    <label for="memberAmount">Member Amount</label>
                    @error('memberAmount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#countryId').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '{{ route("get.states") }}', // Replace with your route for fetching states
                    type: 'POST',
                    data: {
                        countryId: countryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#stateId').html(data);
                    }
                });
            } else {
                $('#stateId').html('<option value="" selected disabled>Select State</option>');
            }
        });
    });
</script>



@endsection