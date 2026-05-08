@extends('layouts.master')

@section('header', 'Circle')
@section('content')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title" style="color: #1d2856;">Create Circle</h5>
            <a href="{{ route('circle.index') }}" class="btn btn-bg-orange  btn-sm">BACK</a>
        </div>
        <hr>
        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="circleForm" enctype="multipart/form-data" method="post" action="{{ route('circle.store') }}" novalidate>
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('circleName') is-invalid @enderror" id="circleName" name="circleName" placeholder="Circle Name" value="{{ old('circleName') }}" required>
                        <label for="circleName">Circle Name</label>
                        <small class="form-text text-muted"><span style="color:red">* Note: Fill Up Carefully, You can't
                                Change Circle Name after Submit.</span></small>
                        @error('circleName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <select class="form-select @error('country') is-invalid @enderror" id="country" name="country" required>
                            <option value="" selected disabled>Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->countryName }}
                                </option>
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
                        <select class="form-select @error('state') is-invalid @enderror" id="state" name="state" required>
                            <option value="" disabled>Select State</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" {{ old('state') == $state->id ? 'selected' : '' }}>
                                    {{ $state->stateName }}
                                </option>
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
                        <select class="form-select @error('cityId') is-invalid @enderror" id="cityId" name="cityId" required>
                            <option value="" disabled>Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('cityId') == $city->id ? 'selected' : '' }}>
                                    {{ $city->cityName }}
                                </option>
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
                        <select class="form-control" data-error="Franchise Name Field is required" required name="franchiseId" id="franchiseId">
                            <option value="" selected disabled> Select Franchise</option>
                            @foreach ($franchise as $franchiseData)
                                <option value="{{ $franchiseData->id }}" {{ old('franchiseId') == $franchiseData->id ? 'selected' : '' }}>
                                    {{ $franchiseData->franchiseName }}
                                </option>
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
                        <select class="form-control" data-error="Circle Name Field is required" required name="circletypeId" id="circletypeId">
                            <option value="" selected disabled> Select Circle Type</option>
                            @foreach ($circletype as $circletypeData)
                                <option value="{{ $circletypeData->id }}" {{ old('circletypeId') == $circletypeData->id ? 'selected' : '' }}>
                                    {{ $circletypeData->circleTypeName }}
                                </option>
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
                        <select class="form-select" id="meetingDay" name="meetingDay" required>
                            <option selected disabled>Select Day</option>
                            <option value="0" {{ old('meetingDay') == '0' ? 'selected' : '' }}>Sunday</option>
                            <option value="1" {{ old('meetingDay') == '1' ? 'selected' : '' }}>Monday</option>
                            <option value="2" {{ old('meetingDay') == '2' ? 'selected' : '' }}>Tuesday</option>
                            <option value="3" {{ old('meetingDay') == '3' ? 'selected' : '' }}>Wednesday</option>
                            <option value="4" {{ old('meetingDay') == '4' ? 'selected' : '' }}>Thursday</option>
                            <option value="5" {{ old('meetingDay') == '5' ? 'selected' : '' }}>Friday</option>
                            <option value="6" {{ old('meetingDay') == '6' ? 'selected' : '' }}>Saturday</option>
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
                        <select class="form-select" id="numberOfMeetings" name="numberOfMeetings" required>
                            <option selected disabled>Number of Meetings</option>
                            <option value="1" {{ old('numberOfMeetings') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('numberOfMeetings') == '2' ? 'selected' : '' }}>2</option>
                            <!-- Option values for more meetings can be added here -->
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control @error('launchDate') is-invalid @enderror" id="launchDate" name="launchDate" value="{{ old('launchDate', date('Y-m-d')) }}">
                        <label for="launchDate">Launch Date</label>

                        @error('launchDate')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-control mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class=" mt-3">
                            <label class="form-label" for="weekNo">Number of Weeks</label>
                            @error('weekNo')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        @foreach (['Week 1', 'Week 2', 'Week 3', 'Week 4'] as $week)
                            <div class="col-md-3">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="weekNo{{ substr($week, -1) }}" name="weekNo[]" value="{{ $week }}" {{ in_array($week, old('weekNo', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="weekNo{{ substr($week, -1) }}">{{ $week }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-12 mt-3">
                <div class="form-floating">
                    <select class="form-select select2 js-example-basic-multiple-limit" style="height: 150px" id="businessCategoryId" name="businessCategoryId[]" multiple>
                        @foreach ($bCategory as $bCategoryData)
                            <option value="{{ $bCategoryData->id }}" {{ in_array($bCategoryData->id, old('businessCategoryId', [])) ? 'selected' : '' }}>
                                {{ $bCategoryData->categoryName }}
                            </option>
                        @endforeach
                    </select>
                    @error('businessCategoryId')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div> --}}



            {{-- <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('circleName') is-invalid @enderror" id="circleName" name="circleName" placeholder="Circle Name" required>
                        <label for="circleName">Circle Name</label>
                        <small class="form-text text-muted"><span style="color:red">* Note: Fill Up Carefully, You can't
                                Change Circle Name after Submit.</span></small>
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
                            <option value="" selected disabled>Select Country</option>
                            @foreach ($countries as $country)
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
                            <option value="" selected disabled>Select State</option>
                            @foreach ($states as $state)
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
                            <option value="" selected disabled>Select City</option>
                            @foreach ($cities as $city)
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
                        <select class="form-control" data-error='Franchise Name Field is required' required name="franchiseId" id="franchiseId">
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
                        <select class="form-control" data-error='Circle Name Field is required' required name="circletypeId" id="circletypeId">
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
            {{-- @error('meetingDay')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
    </div>
    </div> --}}


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
            {{-- <div class="col-md-6 mt-3">
        <div class="form-floating">
            <select class="form-select" id="numberOfMeetings" name="numberOfMeetings">
                <option selected disabled>Number of Meetings</option>
                <option value="1">1</option>
                <option value="2">2</option> --}}
            {{-- <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option> --}}
            {{-- </select>
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
                        <input class="form-check-input" type="checkbox" id="weekNo1" name="weekNo[]" value="Week 1">
                        <label class="form-check-label" for="weekNo1">
                            Week 1
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="weekNo2" name="weekNo[]" value="Week 2">
                        <label class="form-check-label" for="weekNo2">
                            Week 2
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="weekNo3" name="weekNo[]" value="Week 3">
                        <label class="form-check-label" for="weekNo3">
                            Week 3
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="weekNo4" name="weekNo[]" value="Week 4">
                        <label class="form-check-label" for="weekNo4">
                            Week 4
                        </label>
                    </div>
                </div>
            </div> --}}
            {{--
            </div> --}}
            {{-- </div>
    </div>


    <div class="col-md-12 mt-3">
        <div class="form-floating">
            <select class="form-select select2 js-example-basic-multiple-limit" style="height: 150px" id="businessCategoryId" name="businessCategoryId[]" multiple>
                @foreach ($bCategory as $bCategoryData)
                    <option value="{{ $bCategoryData->id }}">{{ $bCategoryData->categoryName }}</option>
                @endforeach
            </select> --}}
            {{-- <label for="bCategoryId">Business Category</label> --}}
            {{-- @error('bCategoryId')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div> --}}




            {{-- <div class="row">
    <div class="col-md-6 mt-3">
        <div class="form-floating">
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                name="start_date" placeholder="Start Date" required>
            <label for="start_date">Start Date</label>
            <span class="date-input-icon">
                <!-- Icon HTML -->
            </span>
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
    </div> --}}
            {{-- </div> --}}

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue ">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
    </div>
    </div>
    </form><!-- End floating Labels Form -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Initialize Select2 with search and selection limit
        $(document).ready(function() {
            $(".js-example-basic-multiple-limit").select2({
                placeholder: "Select Business Category", // Placeholder for the dropdown
                allowClear: true, // Adds a clear button to the dropdown
                maximumSelectionLength: 5, // Limits selection to 2 items
                width: '100%' // Ensures it takes the full width of the container
            });
        });
    </script>


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



    <script>
        $(document).ready(function() {
            var userRole = "{{ Auth::user()->getRoleNames()->first() }}";

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
                        role: userRole,
                        data: {
                            countryId: countryId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log('States data: ', data);
                            $('#state').html('<option value="">Select State</option>'); // Default option
                            $('#state').append(data); // Append states to dropdown
                            $('#cityId').html('<option value="">Select City</option>'); // Reset city dropdown
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
                            role: userRole,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log('Cities data: ', data);
                            $('#cityId').html('<option value="">Select City</option>'); // Default option
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
        });
    </script>


@endsection
