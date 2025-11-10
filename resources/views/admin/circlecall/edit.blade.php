@extends('layouts.master')

@section('title', 'UBN - IBM')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit IBM</h5>
            <a href="{{ route('circlecall.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr>
        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="callForm" enctype="multipart/form-data" method="post" action="{{ route('circlecall.update', $circlecall->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $circlecall->id }}">

            {{-- @include('circleMemberMaster') --}}

            <div class="row mb-3 mt-3">

                @if (auth()->user()->hasRole('Member'))
                    <!-- Circle Dropdown -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                <option value="" disabled>Select Circle</option>
                                @foreach ($circles as $circle)
                                    <option value="{{ $circle->id }}" {{ $circle->id == old('circleId', $circlecall->meetingPerson->circleId) ? 'selected' : '' }}>
                                        {{ $circle->circleName }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="circleId">Circle</label>
                            @error('circleId')
                                <div class="invalid-tooltip">This field is required.</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Member Dropdown -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                <option value="" disabled>Select Member</option>
                                @foreach ($circleMember as $member)
                                    <option value="{{ $member->id }}" {{ $member->id == old('memberId', $circlecall->meetingPersonId) ? 'selected' : '' }} data-user-id="{{ $member->userId ?? ($member->user_id ?? $member->id) }}" data-first-name="{{ $member->firstName ?? ($member->first_name ?? '') }}" data-last-name="{{ $member->lastName ?? ($member->last_name ?? '') }}">
                                        {{ $member->firstName }} {{ $member->lastName }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="memberId">Member</label>
                            @error('memberId')
                                <div class="invalid-tooltip">This field is required.</div>
                            @enderror
                        </div>
                    </div>
                @endif

                @if (auth()->user()->hasRole('Digital Member'))
                    <!-- City Dropdown -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                                <option value="" disabled>Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ $city->id == old('city', $circlecall->cityId) ? 'selected' : '' }}>
                                        {{ $city->cityName }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="city">City</label>
                            @error('city')
                                <div class="invalid-tooltip">This field is required.</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Member Dropdown -->
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                <option value="" disabled>Select Member</option>
                                @foreach ($circleMember as $member)
                                    <option value="{{ $member->id }}" {{ (old('memberId') ? $member->id == old('memberId') : ($member->userId ?? ($member->user_id ?? '')) == $circlecall->meetingPersonId) ? 'selected' : '' }} data-user-id="{{ $member->userId ?? ($member->user_id ?? $member->id) }}" data-first-name="{{ $member->firstName ?? ($member->first_name ?? '') }}" data-last-name="{{ $member->lastName ?? ($member->last_name ?? '') }}">
                                        {{ $member->firstName }} {{ $member->lastName }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="memberId">Member</label>
                            @error('memberId')
                                <div class="invalid-tooltip">This field is required.</div>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>


            <div class="row mb-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="hidden" id="meetingPersonId" name="meetingPersonId" value="{{ $circlecall->meetingPersonId }}" required>
                        <input type="text" class="form-control " readonly id="meetingPersonName" placeholder="Select Member" value="{{ $circlecall->meetingPerson->firstName }} {{ $circlecall->meetingPerson->lastName }}" disabled required>
                        <label for="memberName">Meeting Person Name</label>
                        @error('meetingPersonId')
                            <div class="invalid-tooltip">
                                This field is required.
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="meetingPlace" name="meetingPlace" placeholder="Meeting Place Name" required value="{{ old('meetingPlace', $circlecall->meetingPlace) }}">
                        <label for="meetingPlace">Meeting Place Name</label>
                        <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('meetingImage') is-invalid @enderror" id="meetingImage" name="meetingImage" accept="image/*" onchange="previewPhoto(event)" {{ ($oldMeetingImage = old('meetingImage')) ? 'data-old-value="' . $oldMeetingImage . '"' : '' }}>
                        <label for="meetingImage">Upload Meeting Image</label>
                        <span class="text-danger mt-1 d-block">*
                            File size:Max 2MB</span>
                        @error('meetingImage')
                            <div class="invalid-tooltip">
                                The Maximum file size is 2MB
                            </div>
                        @enderror
                    </div>

                    <!-- Photo Preview Section -->
                    <div class="mt-1">
                        <img id="photoPreview" src="{{ $circlecall->meetingImage ? asset('meetingImage/' . $circlecall->meetingImage) : asset('img/profile.png') }}" alt="Meeting Image" style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
                    </div>
                </div>

                <script>
                    function previewPhoto(event) {
                        const file = event.target.files[0];
                        const preview = document.getElementById('photoPreview');

                        if (file) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block'; // Show the image
                            }

                            reader.readAsDataURL(file); // Read the file as a data URL
                        }
                    }
                </script>

                {{-- @if (auth()->user()->hasRole('Member'))
                    @php
                        // $scheduleDate is a Collection (from pluck). Safe check:
                        $nearestDate = $scheduleDate->isNotEmpty() ? \Illuminate\Support\Carbon::parse($scheduleDate->min())->subDay()->format('Y-m-d') : \Illuminate\Support\Carbon::now()->format('Y-m-d');

                        $selectedDate = old('date', $circlecall->date);
                        $minDate = $lastDate ?? '';
                    @endphp

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="date" class="form-control" id="date" name="date" placeholder="Meeting Date" required min="{{ $minDate }}" max="{{ $nearestDate }}" value="{{ $selectedDate }}">
                            <label for="date">Date</label>
                        </div>
                    </div>
                @endif --}}


                @if (auth()->user()->hasRole('Member'))
                    <!-- Date -->
                    <div class="col-md-6 mt-3">
                        {{-- <div class="form-floating">
                            <label for="date" class="form-label fw-bold color-blue required">
                                Date <span class="text-danger">*</span>
                            </label>
                        </div> --}}
                        <?php
                        // Calculate allowed range
                        $today = \Illuminate\Support\Carbon::today()->format('Y-m-d');
                        $pastLimit = \Illuminate\Support\Carbon::today()->subDays(15)->format('Y-m-d');
                        
                        // Default selected date
                        $selectedDate = old('date', request()->input('date') ?? $today);
                        ?>
                        <input type="date" class="form-control" id="date" name="date" min="{{ $pastLimit }}" max="{{ $today }}" value="{{ $selectedDate }}" required>
                    </div>
                @endif

                @if (auth()->user()->hasRole('Digital Member'))
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="date" class="form-control" id="date" name="date" placeholder="Meeting Date" required value="{{ old('date', $circlecall->date) }}">
                            <label for="date">Date</label>
                        </div>
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="remarks" name="remarks" required placeholder="Remarks" value="{{ old('remarks', $circlecall->remarks) }}">
                        <label for="remarks">Remarks</label>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                {{-- <button type="reset" class="btn btn-bg-orange">Reset</button> --}}
            </div>
        </form><!-- End floating Labels Form -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Function to load members for a selected circle
            function loadMembers(circleId, selectedMemberId = null) {
                // Clear the member dropdown
                $('#memberId').empty().append('<option value="">Select Member</option>');

                if (circleId) {
                    $.ajax({
                        url: '{{ route('members.byCircle') }}',
                        method: 'GET',
                        data: {
                            circleId: circleId
                        },
                        success: function(response) {
                            if (response.members && response.members.length > 0) {
                                response.members.forEach(function(member) {
                                    $('#memberId').append('<option value="' + (member.id ?? '') +
                                        '" data-user-id="' + (member.userId ?? member.user_id ?? member.id ?? '') +
                                        '" data-first-name="' + (member.firstName ?? member.first_name ?? '') +
                                        '" data-last-name="' + (member.lastName ?? member.last_name ?? '') + '">' +
                                        (((member.firstName ?? member.first_name ?? '') + ' ' + (member.lastName ?? member.last_name ?? '')).trim()) +
                                        '</option>');
                                });

                                // Pre-select the member if one is passed to the function
                                if (selectedMemberId) {
                                    $('#memberId').val(selectedMemberId).trigger('change');
                                }
                            } else {
                                $('#memberId').append('<option value="">No Members Found</option>');
                            }
                        },
                        error: function(xhr) {
                            $('#memberId').append('<option value="">Error loading members</option>');
                        }
                    });
                }
            }

            // Handle member selection and update meeting person fields
            $('#memberId').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var memberId = selectedOption.val();
                var userId = selectedOption.data('user-id') || memberId;
                var firstName = selectedOption.data('first-name');
                var lastName = selectedOption.data('last-name');

                var displayName = ((firstName ? firstName : '') + ' ' + (lastName ? lastName : '')).trim();
                if (!displayName) {
                    displayName = selectedOption.text().trim();
                }

                // Check if a valid member is selected
                if (memberId) {
                    $('#meetingPersonId').val(userId); // Use userId if available, fallback to memberId
                    $('#meetingPersonName').val(displayName); // Use data attributes or fallback to option text
                } else {
                    $('#meetingPersonId').val(''); // Clear the fields if no member is selected
                    $('#meetingPersonName').val('');
                }
            });

            // On page load, set the circle and member dropdown values if they exist
            var defaultCircleId = '{{ old('circleId', $circlecall->circleId) }}'; // Get the default circle ID
            var defaultMemberId =
                '{{ old('memberId', $circlecall->meetingPerson->memberId) }}'; // Get the default member ID

            // If there's a default circle, load members for that circle and set the default member
            if (defaultCircleId) {
                loadMembers(defaultCircleId,
                    defaultMemberId); // Load members for the default circle and pre-select the default member
            }

            // Handle circle dropdown change event
            $('#circleId').on('change', function() {
                var circleId = $(this).val();
                loadMembers(circleId); // Load members based on the selected circle
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            console.log("✅ Document Ready");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function loadMembers(cityId) {
                console.log("🏙️ loadMembers() called with cityId:", cityId);

                $('#memberId').empty().append('<option value="">Select Member</option>');

                if (cityId) {
                    let url = '/get-members-by-city/' + cityId;
                    console.log("🚀 Sending AJAX to:", url);

                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(response) {
                            console.log("✅ Response received:", response);
                            console.log("🔢 Member count:", response?.length ?? 0);

                            if (response && response.length > 0) {
                                response.forEach(function(member, index) {
                                    console.log(`👤 Member [${index}]:`, member);
                                    $('#memberId').append(
                                        `<option value="${member.id ?? ''}"
                                    data-user-id="${member.userId ?? member.user_id ?? member.id ?? ''}"
                                    data-first-name="${member.firstName ?? member.first_name ?? ''}"
                                    data-last-name="${member.lastName ?? member.last_name ?? ''}">
                                    ${(member.firstName ?? member.first_name ?? '')} ${(member.lastName ?? member.last_name ?? '')}
                                </option>`
                                    );
                                });
                            } else {
                                console.warn("⚠️ No members found for cityId:", cityId);
                                $('#memberId').append('<option value="">No Members Found</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("❌ AJAX Error:", {
                                status,
                                error,
                                responseText: xhr.responseText
                            });
                            $('#memberId').append('<option value="">Error loading members</option>');
                        }
                    });
                } else {
                    console.warn("⚠️ No cityId provided");
                }
            }

            var defaultCityId = '{{ auth()->user()->member->city_id ?? '' }}';

            if (defaultCityId) {
                loadMembers(defaultCityId);
            }

            $('#city').on('change', function() {
                var cityId = $(this).val();
                console.log("🏙️ City changed:", cityId);
                loadMembers(cityId);
            });

            $('#memberId').on('change', function() {
                var selected = $(this).find('option:selected');
                var memberId = selected.val();
                var userId = selected.data('user-id') || memberId;
                var firstName = selected.data('first-name');
                var lastName = selected.data('last-name');

                var displayName = ((firstName ? firstName : '') + ' ' + (lastName ? lastName : '')).trim();
                if (!displayName) {
                    displayName = selected.text().trim();
                }

                if (memberId) {
                    $('#meetingPersonId').val(userId);
                    $('#meetingPersonName').val(displayName);
                } else {
                    $('#meetingPersonId').val('');
                    $('#meetingPersonName').val('');
                }
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#callForm').validate({
                rules: {
                    meetingPersonId: {
                        required: true
                    },
                    meetingPlace: {
                        required: true
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    remarks: {
                        required: true
                    }
                },
                messages: {
                    meetingPersonId: {
                        required: "Please select a meeting person."
                    },
                    meetingPlace: {
                        required: "Please enter the meeting place."
                    },
                    date: {
                        required: "Please select a date."
                    },
                    remarks: {
                        required: "Please enter remarks."
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-tooltip');
                    element.closest('.form-floating').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
