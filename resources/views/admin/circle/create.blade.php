@extends('layouts.master')

@section('header', 'Circle')
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
        <h5 class="card-title">Create Circle</h5>
        <a href="{{ route('circle.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circleForm" enctype="multipart/form-data" method="post"
        action="{{ route('circle.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('circleName') is-invalid @enderror" id="circleName"
                        name="circleName" placeholder="Circle Name" required>
                    <label for="circleName">Circle Name</label>
                    @error('circleName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('country') is-invalid @enderror" id="country" name="country">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->countryName }}</option>
                        @endforeach
                    </select>
                    <label for="country">Country</label>
                    @error('country')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('state') is-invalid @enderror" id="state" name="state">
                        <option value="">Select State</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->stateName }}</option>
                        @endforeach
                    </select>
                    <label for="state">State</label>
                    @error('state')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select @error('cityId') is-invalid @enderror" id="cityId" name="cityId">
                        <option value="">Select City</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                        @endforeach
                    </select>
                    <label for="cityId">City</label>
                    @error('cityId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-control" data-error='Franchise Name Field is required' required
                        name="franchiseId" id="franchiseId">
                        <option value="" selected disabled> Select Franchise</option>
                        @foreach ($franchise as $franchiseData)
                        <option value="{{ $franchiseData->id }}">{{ $franchiseData->franchiseName }}</option>
                        @endforeach
                    </select>
                    @error('franchiseId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-control" data-error='Circle Name Field is required' required name="circletypeId"
                        id="circletypeId">
                        <option value="" selected disabled> Select Circle Type</option>
                        @foreach ($circletype as $circletypeData)
                        <option value="{{ $circletypeData->id }}">{{ $circletypeData->circleTypeName }}</option>
                        @endforeach
                    </select>
                    @error('circletypeId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <select class="form-select" id="meetingDay" name="meetingDay">
                        <option selected disabled>Select Day</option>
                        <option value="0">Sunday</option>
                        <option value="1">Monday</option>
                        <option value="2">Tuesday</option>
                        <option value="3">Wednesday</option>
                        <option value="4">Thursday</option>
                        <option value="5">Friday</option>
                        <option value="6">Saturday</option>
                    </select>
                    {{-- <label for="circleTypeName">Select Type</label> --}}
                    @error('meetingDay')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


            {{-- <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="time" class="form-control @error('meetingTime') is-invalid @enderror" id="stateName"
                        name="meetingTime" placeholder="meetingTime" required>
                    <label for="meetingTime">Meeting Time</label>
                    @error('meetingTime')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div> --}}

            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <select class="form-select" id="numberOfMeetings" name="numberOfMeetings">
                            <option selected disabled>Number of Meetings</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <label for="numberOfMeetings">Number of Meetings</label>
                        @error('numberOfMeetings')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-check mt-3">
                        <label class="form-label" for="weekNo">
                            Number of Weeks
                        </label>
                        @error('weekNo')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo1" name="weekNo[]"
                                    value="Week 1">
                                <label class="form-check-label" for="weekNo1">
                                    Week 1
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo2" name="weekNo[]"
                                    value="Week 2">
                                <label class="form-check-label" for="weekNo2">
                                    Week 2
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo3" name="weekNo[]"
                                    value="Week 3">
                                <label class="form-check-label" for="weekNo3">
                                    Week 3
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo4" name="weekNo[]"
                                    value="Week 4">
                                <label class="form-check-label" for="weekNo4">
                                    Week 4
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                            id="start_date" name="start_date" placeholder="Start Date" required>
                        <label for="start_date">Start Date</label>
                        @error('start_date')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>  
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date"
                            name="end_date" placeholder="End Date" required>
                        <label for="end_date">End Date</label>
                        @error('end_date')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
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
    $(document).ready(function () {
        $('input[name="weekNo[]"]').change(function () {
            var checkedCount = $('input[name="weekNo[]"]:checked').length;
            if (checkedCount >= 2) {
                $('input[name="weekNo[]"]:not(:checked)').prop('disabled', true);
            } else {
                $('input[name="weekNo[]"]').prop('disabled', false);
            }
        });

        $('#circletypeId').change(function () {
            var circleType = $('#circletypeId').val();
            console.log('circle type id', circleType);
            if (circleType === '1') {
                $('input[name="weekNo[]"]').prop('disabled', false);
                var checkedCount = $('input[name="weekNo[]"]:checked').length;
                console.log('checkedCount', checkedCount);
                if (checkedCount >= 2) {
                    $('input[name="weekNo[]"]:not(:checked)').prop('disabled', true);
                }
            } else if (circleType === '4') {
                $('input[name="weekNo[]"]').prop('disabled', false);
                var checkedCount = $('input[name="weekNo[]"]:checked').length;
                if (checkedCount >= 1) {
                    $('input[name="weekNo[]"]:not(:checked)').prop('disabled', true);
                }
            } else if (circleType === '2') {
                $('input[name="weekNo[]"]').prop('disabled', false);
                $('input[name="weekNo[]"]').change(function () {
                    var checkedCount = $('input[name="weekNo[]"]:checked').length;
                    if (checkedCount >= 1) {
                        $('input[name="weekNo[]"]:not(:checked)').prop('disabled', true);
                    } else {
                        $('input[name="weekNo[]"]').prop('disabled', false);
                    }
                });
            }
        }).trigger('change'); // Triggering the change event to set initial state
    });
</script>


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