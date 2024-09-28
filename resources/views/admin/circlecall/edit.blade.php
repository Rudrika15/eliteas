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
        <form class="m-3 needs-validation" id="callForm" enctype="multipart/form-data" method="post"
            action="{{ route('circlecall.update', $circlecall->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $circlecall->id }}">

            {{-- @include('circleMemberMaster') --}}

            <div class="row mb-3 mt-3">
                <!-- Circle Dropdown -->
                <div class="col-md-6">

                    <div class="form-floating">
                        <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId"
                            required>
                            <option value="" selected disabled>Select Circle</option>
                            <option value="{{ old('circleId') }}" selected> {{ old('circleName') }}</option>
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

                <!-- Member Dropdown -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId"
                            required>
                            <option value="" selected disabled>Select Member</option>
                            <option value="{{ old('memberId') }}" selected> {{ old('memberName') }}</option>
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

            <div class="row mb-3 mt-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="hidden" id="meetingPersonId" name="meetingPersonId"
                            value="{{ $circlecall->meetingPersonId }}" required>

                        <input type="text" class="form-control " readonly id="meetingPersonName"
                            placeholder="Select Member"
                            value="{{ $circlecall->meetingPerson->firstName }} {{ $circlecall->meetingPerson->lastName }}"
                            disabled required>
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
                        <input type="text" class="form-control" id="meetingPlace" name="meetingPlace"
                            placeholder="Meeting Place Name" pattern="[A-Za-z\s]+" required
                            value="{{ old('meetingPlace', $circlecall->meetingPlace) }}"
                            oninvalid="this.setCustomValidity('Please enter correct details.')"
                            oninput="setCustomValidity('')">
                        <label for="meetingPlace">Meeting Place Name</label>
                        <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('meetingImage') is-invalid @enderror"
                            id="meetingImage" name="meetingImage" accept="image/*" required onchange="previewPhoto(event)"
                            {{ ($oldMeetingImage = old('meetingImage')) ? 'data-old-value="' . $oldMeetingImage . '"' : '' }}>
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
                        <img id="photoPreview" src="{{ $oldMeetingImage ? $oldMeetingImage : asset('img/profile.png') }}"
                            alt="Meeting Image"
                            style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
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


                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <?php
                        use Illuminate\Support\Carbon;
                        
                        $nearestDate = $scheduleDate->min();
                        $nearestDate = $nearestDate ? Carbon::parse($nearestDate)->subDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');
                        $selectedDate = request()->input('date') ?? (Carbon::now()->format('Y-m-d') == $nearestDate ? Carbon::now()->format('Y-m-d') : $nearestDate);
                        ?>
                        <input type="date" class="form-control" id="date" name="date" placeholder="Meeting Date"
                            required min="{{ $lastDate }}" max="{{ $nearestDate }}"
                            value="{{ old('date', $circlecall->date) }}" disabled>
                        <label for="date">Date</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks"
                            required value="{{ old('remarks', $circlecall->remarks) }}">
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
                                    $('#memberId').append('<option value="' + member.id +
                                        '" data-user-id="' + member.userId +
                                        '" data-first-name="' + member.firstName +
                                        '" data-last-name="' + member.lastName + '">' +
                                        member.firstName + ' ' + member.lastName +
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
                var userId = selectedOption.data('user-id');
                var firstName = selectedOption.data('first-name');
                var lastName = selectedOption.data('last-name');

                // Check if a valid member is selected
                if (memberId) {
                    $('#meetingPersonId').val(userId); // Set the correct userId
                    $('#meetingPersonName').val(firstName + ' ' + lastName); // Set the name
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
            $('#circlecallForm').validate({
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
