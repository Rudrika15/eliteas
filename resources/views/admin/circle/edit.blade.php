@extends('layouts.master')

@section('header', 'Edit Circle')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
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
    @endif

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title" style="color: #1d2856;">Edit Circle</h5>
            <a href="{{ route('circle.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr>
        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="circleForm" enctype="multipart/form-data" method="post"
            action="{{ route('circle.update', $circle->id) }}" novalidate>
            @csrf
            @method('POST')

            <input type="hidden" name="id" value="{{ $circle->id }}">

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('circleName') is-invalid @enderror" id="circleName"
                            name="circleName" placeholder="Circle Name" value="{{ old('circleName', $circle->circleName) }}"
                            readonly>
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
                        <select class="form-select @error('countryId') is-invalid @enderror" id="countryId" name="countryId"
                            required>
                            <option value="" selected disabled>Select Country</option>
                            @foreach ($countries as $countryData)
                                <option value="{{ $countryData->id }}"
                                    {{ old('countryId', $circle->city->state->countryId) == $countryData->id ? 'selected' : '' }}>
                                    {{ $countryData->countryName }}
                                </option>
                            @endforeach
                        </select>
                        @error('countryId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <select class="form-select @error('stateId') is-invalid @enderror" id="stateId" name="stateId"
                            required>
                            <option value="" selected disabled>Select State</option>
                            @foreach ($states as $stateData)
                                <option value="{{ $stateData->id }}"
                                    {{ old('stateId', $circle->city->stateId) == $stateData->id ? 'selected' : '' }}>
                                    {{ $stateData->stateName }}
                                </option>
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
                        <select class="form-select @error('cityId') is-invalid @enderror" id="cityId" name="cityId"
                            required>
                            <option value="" selected disabled>Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}"
                                    {{ old('cityId', $circle->cityId) == $city->id ? 'selected' : '' }}>
                                    {{ $city->cityName }}
                                </option>
                            @endforeach
                        </select>
                        @error('cityId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <select class="form-control" name="franchiseId" id="franchiseId">
                            <option value="" selected disabled> Select Franchise</option>
                            @foreach ($franchise as $franchiseData)
                                <option value="{{ $franchiseData->id }}"
                                    {{ $circle->franchiseId == $franchiseData->id ? 'selected' : '' }}>
                                    {{ $franchiseData->franchiseName }}</option>
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
                        <select class="form-control" name="circletypeId" id="circletypeId">
                            <option value="" selected disabled> Select Circle Type</option>
                            @foreach ($circletype as $circletypeData)
                                <option value="{{ $circletypeData->id }}"
                                    {{ $circle->circletypeId == $circletypeData->id ? 'selected' : '' }}>
                                    {{ $circletypeData->circleTypeName }}</option>
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
                            <option value="0" {{ $circle->meetingDay == 0 ? 'selected' : '' }}>Sunday</option>
                            <option value="1" {{ $circle->meetingDay == 1 ? 'selected' : '' }}>Monday</option>
                            <option value="2" {{ $circle->meetingDay == 2 ? 'selected' : '' }}>Tuesday</option>
                            <option value="3" {{ $circle->meetingDay == 3 ? 'selected' : '' }}>Wednesday</option>
                            <option value="4" {{ $circle->meetingDay == 4 ? 'selected' : '' }}>Thursday</option>
                            <option value="5" {{ $circle->meetingDay == 5 ? 'selected' : '' }}>Friday</option>
                            <option value="6" {{ $circle->meetingDay == 6 ? 'selected' : '' }}>Saturday</option>
                        </select>
                        @error('meetingDay')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <select class="form-select" id="numberOfMeetings" name="numberOfMeetings">
                            <option selected disabled>Number of Meetings</option>
                            <option value="1" {{ $circle->numberOfMeetings == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ $circle->numberOfMeetings == 2 ? 'selected' : '' }}>2</option>
                            {{-- <option value="3" {{ $circle->numberOfMeetings == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $circle->numberOfMeetings == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $circle->numberOfMeetings == 5 ? 'selected' : '' }}>5</option> --}}
                        </select>
                        <label for="numberOfMeetings">Number of Meetings</label>
                        @error('numberOfMeetings')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-control">
                <div class="row">
                    <div class="col-md-6">
                        <div class=" mt-3">
                            <label class="form-label" for="weekNo">
                                Number of Weeks
                            </label>
                            @error('weekNo')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo1" name="weekNo[]"
                                    value="Week 1"
                                    {{ is_array(old('weekNo', $circle->weekNo)) && in_array('Week 1', old('weekNo', $circle->weekNo)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="weekNo1">
                                    Week 1
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo2" name="weekNo[]"
                                    value="Week 2"
                                    {{ is_array(old('weekNo', $circle->weekNo)) && in_array('Week 2', old('weekNo', $circle->weekNo)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="weekNo2">
                                    Week 2
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo3" name="weekNo[]"
                                    value="Week 3"
                                    {{ is_array(old('weekNo', $circle->weekNo)) && in_array('Week 3', old('weekNo', $circle->weekNo)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="weekNo3">
                                    Week 3
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="weekNo4" name="weekNo[]"
                                    value="Week 4"
                                    {{ is_array(old('weekNo', $circle->weekNo)) && in_array('Week 4', old('weekNo', $circle->weekNo)) ? 'checked' : '' }}>
                                <label class="form-check-label" for="weekNo4">
                                    Week 4
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue">Update</button>
                <a href="{{ route('circle.index') }}" class="btn btn-bg-orange">Cancel</a>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to enable/disable checkboxes based on the number of checked checkboxes
            function updateWeekNoCheckboxes() {
                var checkedCount = $('input[name="weekNo[]"]:checked').length;
                if (checkedCount >= 2) {
                    $('input[name="weekNo[]"]:not(:checked)').prop('disabled', true);
                } else {
                    $('input[name="weekNo[]"]').prop('disabled', false);
                }
            }

            // Initial call to set the correct state of checkboxes
            updateWeekNoCheckboxes();

            // Event listener for changes on weekNo checkboxes
            $('input[name="weekNo[]"]').change(function() {
                updateWeekNoCheckboxes();
            });

            // Event listener for changes on circletypeId select
            $('#circletypeId').change(function() {
                var circleType = $('#circletypeId').val();
                console.log('circle type id', circleType);

                // Enable all checkboxes when circle type changes
                $('input[name="weekNo[]"]').prop('disabled', false);

                // Call the function to update the state of checkboxes based on the number of checked checkboxes
                updateWeekNoCheckboxes();
            }).trigger('change'); // Trigger the change event to set initial state
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            // Initialize state and city dropdowns to be empty on page load
            $('#state').html('<option value="">Select State</option>');
            $('#cityId').html('<option value="">Select City</option>');

            // Handle country change event
            $('#country').change(function() {
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
                        success: function(data) {
                            console.log('States data: ', data);
                            $('#state').html(
                                '<option value="">Select State</option>'); // Default option
                            $('#state').append(data); // Append states to dropdown
                            $('#cityId').html(
                                '<option value="">Select City</option>'); // Reset city dropdown
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching states: ', error);
                        }
                    });
                } else {
                    console.log('No country selected, resetting state and city dropdowns');
                    $('#state').html('<option value="">Select State</option>');
                    $('#cityId').html('<option value="">Select City</option>');
                }
            });

            // Handle state change event
            $('#state').change(function() {
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
                        success: function(data) {
                            console.log('Cities data: ', data);
                            $('#cityId').html(
                                '<option value="">Select City</option>'); // Default option
                            $('#cityId').append(data); // Append cities to dropdown
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching cities: ', error);
                        }
                    });
                } else {
                    console.log('No state selected, resetting city dropdown');
                    $('#cityId').html('<option value="">Select City</option>');
                }
            });

            // Trigger change events on page load if values are pre-selected
            $('#country').trigger('change');
            $('#state').trigger('change');
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#countryId').change(function() {
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
                            $('#stateId').html(data);
                            $('#cityId').html('<option value="">Select City</option>');
                        }
                    });
                } else {
                    $('#stateId').html('<option value="">Select State</option>');
                    $('#cityId').html('<option value="">Select City</option>');
                }
            });

            $('#stateId').change(function() {
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
                            $('#cityId').html(data);
                        }
                    });
                } else {
                    $('#cityId').html('<option value="">Select City</option>');
                }
            });
        });
    </script>


@endsection
