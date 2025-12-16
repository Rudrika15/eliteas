@extends('layouts.master')

@section('title', 'UBN - Testimonial')
{{-- <title>UBN - Testimonial</title> --}}
@section('content')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="card-title">Create Testimonial</h4>
            <a href="{{ route('testimonial.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr class="mb-5">
        <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post"
            action="{{ route('testimonial.store') }}" novalidate>
            @csrf
            <div class="row mb-3 mt-3">
                <!-- Circle Dropdown -->
                @if (auth()->user()->hasRole('Member'))
                <div class="col-md-6">

                    <div class="form-floating">
                        <select class="form-select @error('circleId') is-invalid @enderror" id="circleId"
                            name="circleId" required>
                            <option value="" selected disabled>Select Circle</option>
                            @if (old('circleId'))
                            <option value="{{ old('circleId') }}" selected>{{ old('circleName') }}</option>
                            @else
                            <option value="{{ auth()->user()->member->circle->id ?? '' }}" selected>
                                {{ auth()->user()->member->circle->circleName ?? '-' }}
                            </option>
                            @endif
                            @foreach ($circles as $circle)
                            <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                            @endforeach
                        </select>
                        <label for="circleId">Circle</label>
                        @error('circleId')
                        <div class="invalid-tooltip">
                            This field is required.
                        </div>
                        @enderror
                    </div>
                </div>
                @endif

                @if (auth()->user()->hasRole('Digital Member'))
                <!-- City Dropdown -->
                <div class="col-md-6">

                    <div class="form-floating">
                        {{-- <label for="city" class="form-label fw-bold color-blue required">
                            City <span class="text-danger">*</span>
                        </label> --}}
                        <select class="form-select" id="city" name="city" required>
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                            @endforeach
                        </select>
                        @error('circleId')
                        <div class="invalid-tooltip">
                            This field is required.
                        </div>
                        @enderror
                    </div>
                </div>

                @endif

                <!-- Member Dropdown -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('memberId') is-invalid @enderror" id="memberId"
                            name="memberIdSelect" required>
                            <option value="" selected disabled>Select Member</option>
                            @if (old('memberId'))
                            <option value="{{ old('memberId') }}" selected> {{ old('memberName') }}</option>
                            @else

                            @endif
                            <!-- Options will be populated dynamically -->
                        </select>
                        <label for="memberId">Member</label>
                        @error('memberId')
                        <div class="invalid-tooltip">
                            This field is required.
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <div class="col-md-12">
                    <div class="form-floating mt-3">
                        <input type="hidden" id="circlePersonId" name="circlePersonId" required>
                        <input type="text" class="form-control @error('circlePersonId') is-invalid @enderror"
                            id="circlePersonName" placeholder="Select Member" required disabled>
                        <label for="meetingPersonName"><span style="color:red">*</span> Member Name</label>
                        @error('circlePersonId')
                        <div class="invalid-tooltip">
                            This field is required.
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-floating mt-3">
                        <textarea class="form-control @error('message') is-invalid @enderror" id="message"
                            name="message" placeholder="Enter Message" required></textarea>
                        <label for="message"><span style="color:red">*</span> Message</label>
                        @error('message')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!-- Hidden field to store the selected member's ID -->

                {{-- <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror"
                            id="meetingPlace" name="meetingPlace" placeholder="Meeeting Place Name" required>
                        <label for="meetingPlace">Meeting Place Name</label>
                        @error('meetingPlace')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div> --}}

            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-bg-blue" onclick="return validateForm()">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>
</div>


<script>
    function validateForm() {
            let circlePersonId = document.getElementById('circlePersonId').value;
            let message = document.getElementById('message').value;
            if (circlePersonId == '' || message == '') {
                alert('Please fill all the required fields.');
                return false;
            }
            return true;
        }
</script>


<script>
    $(document).ready(function() {
            // CSRF token setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

                        // Load members by city
                        function loadMembersByCity(cityId) {
                $('#memberId').empty().append('<option value="" disabled selected>Select Member</option>');

                if (cityId) {
                    $.ajax({
                        url: '/get-members-by-city/' + cityId,
                        method: 'GET',
                        data: {
                            cityId: cityId
                        },
                        success: function(response) {
                            var members = Array.isArray(response) ? response : (response.members || []);

                            if (members.length > 0) {
                                members.forEach(function(member) {
                                    $('#memberId').append(
                                        '<option value="' + member.id +
                                        '" data-user-id="' + (member.userId || member.id) +
                                        '" data-first-name="' + (member.firstName || '') +
                                        '" data-last-name="' + (member.lastName || '') + '">' +
                                        ((member.firstName || '') + ' ' + (member.lastName || '')).trim() +
                                        '</option>'
                                    );
                                });
                            } else {
                                $('#memberId').append('<option value="">No Members Found</option>');
                            }
                        },
                        error: function() {
                            $('#memberId').append('<option value="">Error loading members</option>');
                        }
                    });
                }
                        }

                        // Load members by circle
                        function loadMembersByCircle(circleId) {
                            $('#memberId').empty().append('<option value="" disabled selected>Select Member</option>');

                            if (circleId) {
                                $.ajax({
                                    url: '/members/byCircle',
                                    method: 'GET',
                                    data: { circleId: circleId },
                                    success: function(response) {
                                        var members = (response && response.members) ? response.members : [];

                                        if (members.length > 0) {
                                            members.forEach(function(member) {
                                                $('#memberId').append(
                                                    '<option value="' + (member.id) +
                                                    '" data-user-id="' + (member.userId || member.id) +
                                                    '" data-first-name="' + (member.firstName || '') +
                                                    '" data-last-name="' + (member.lastName || '') + '">' +
                                                    ((member.firstName || '') + ' ' + (member.lastName || '')).trim() +
                                                    '</option>'
                                                );
                                            });

                                            var oldMemberId = '{{ old('memberId') }}';
                                            if (oldMemberId) {
                                                $('#memberId').val(oldMemberId).trigger('change');
                                            }
                                        } else {
                                            $('#memberId').append('<option value="">No Members Found</option>');
                                        }
                                    },
                                    error: function() {
                                        $('#memberId').append('<option value="">Error loading members</option>');
                                    }
                                });
                            }
                        }

                        // Load members on page load if city is already selected
                        var defaultCityId = '{{ auth()->user()->member->cityId ?? '' }}';
                        if (defaultCityId) {
                            loadMembersByCity(defaultCityId);
                        }

                        // Load circle members on page load if circle is already selected
                        var defaultCircleId = $('#circleId').val();
                        if (defaultCircleId) {
                            loadMembersByCircle(defaultCircleId);
                        }

                        // When city changes, reload members
                        $('#city').on('change', function() {
                            var cityId = $(this).val();
                            loadMembersByCity(cityId);
                        });

                        // When circle changes, reload members
                        $('#circleId').on('change', function() {
                            var circleId = $(this).val();
                            loadMembersByCircle(circleId);
                        });

            // When member is selected
            $('#memberId').on('change', function() {
                var selected = $(this).find('option:selected');
                var userId = selected.data('user-id');
                var firstName = selected.data('first-name');
                var lastName = selected.data('last-name');

                if (userId) {
                    $('#circlePersonId').val(userId);
                    $('#circlePersonName').val((firstName || '') + ' ' + (lastName || ''));
                } else {
                    $('#circlePersonId').val('');
                    $('#circlePersonName').val('');
                }

                console.log('Selected Member User ID:', userId);
                console.log('Selected Member Name:', (firstName || '') + ' ' + (lastName || ''));
            });
                    });
</script>



@endsection
