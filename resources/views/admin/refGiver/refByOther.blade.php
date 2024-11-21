@extends('layouts.master')

@section('title', 'UBN - Referance')
@section('content')


    <style>
        input[type=range]::-webkit-slider-thumb {

            background-color: #1d2856;
        }
    </style>



    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="card-title">Circle Meeting Member Refference</h4>
                <a href="{{ route('refGiver.index') }}" class="btn btn-bg-orange btn-sm ">BACK</a>
            </div>
            <hr class="mb-5">
            <!-- Floating Labels Form -->
            <form class="m-3 needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="post"
                action="{{ route('refGiver.refByOtherStore') }}" novalidate>
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="group" id="internal" value="internal"
                                checked="">
                            <label class="form-check-label" for="internal">
                                Internal
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="group" id="external" value="external">
                            <label class="form-check-label" for="external">
                                External
                            </label>
                        </div>
                    </div>
                </div>
                {{-- <div class="row "> --}}
                {{-- <div class="col-md-6"> --}}
                {{-- <div class="row pt-5"> --}}
                {{-- <div class="col-md-4 mb-3 mt-3">
                    @include('circleMemberMaster')

                </div> --}}

                <div class="row mb-3 mt-3">
                    <!-- Circle Dropdown -->
                    <div class="col-md-6">

                        <div class="form-floating">
                            <select class="form-select @error('circleId') is-invalid @enderror" id="circleId"
                                name="circleId" required>
                                <option value="" selected disabled>Select Circle</option>
                                <option value="{{ old('circleId', auth()->user()->member->circleId) }}" selected>
                                    {{ $circles->where('id', old('circleId', auth()->user()->member->circleId))->first()->circleName ?? '' }}
                                </option>
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
                            <select class="form-select @error('memberId') is-invalid @enderror" id="memberId"
                                name="memberId" required>
                                <option value="" disabled>Select Member</option>
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

                {{-- <div class="col-md-8"> --}}
                <input type="hidden" id="meetingPersonId" name="memberId">
                <div class="form-floating">

                    <!-- Searchable input field -->
                    <input type="text" class="form-control" id="meetingPersonName" name="memberName"
                        placeholder="Select Member" readonly disabled>
                    <label for="memberName">Member Name</label>
                    @error('memberId')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{--
                        </div> --}}
                {{-- <div class="row"> --}}

                {{-- <div class="">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('contactNo') is-invalid @enderror"
                            id="meetingPersonContact" placeholder="Contact No" readonly disabled required>
                        <label for="contactNo">Contact No</label>
                        @error('contactNo')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                            id="meetingPersonEmail" placeholder="email" required disabled readonly>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div> --}}
                <div class="mt-3">
                    <div class="form-floating ">
                        <input type="text" class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" placeholder="description" required>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{--
                        </div> --}}
                {{--
                    </div> --}}
                {{-- </div> --}}

                {{-- <div class="col-md-6  border-start"> --}}



                {{-- <div class="row"> --}}
                {{-- <div class="" id="memberListDropdown" style="display:none;">
                            <div class="form-floating mt-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        @include('circleContactPerson')

                                    </div>
                                    <div class="col-md-8">
                                        <input type="hidden" class="form-control" id="contactPersonId">
                                        <div class="form-floating">
                                            <input type="text" class="form-control contactName" id="contactPersonName"
                                                name="contactNameInternal" placeholder="Contact Person Name">
                                            <label for="contactPersonName">Contact Person Name</label>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div> --}}
                <div class="" id="memberListInput" style="display:none;">
                    <h4 class="mt-3 text-blue">Contact Person Details</h4>


                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('contactName') is-invalid @enderror" id=""
                            name="contactNameExternal" placeholder="Contact Name">
                        <label for="contactName">Contact Person Name</label>
                        @error('contactName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="">
                        <div class="form-floating mt-3">
                            <input type="text"
                                class="form-control @error('contactNo') is-invalid @enderror selectedMemberContact"
                                id="contactPersonContact" name="contactNo" placeholder="Contact No" maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            <label for="contactNo">Contact No</label>
                            @error('contactNo')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                id="contactPersonEmail" name="email" placeholder="email">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                {{--
                    </div> --}}



                {{-- </div> --}}



                <div class="mt-3  ">
                    <label for="scale">Scale [1-5]</label>
                    <div class="form-floating mt-3">
                        <input type="range" class="form-range  @error('scale') is-invalid @enderror" id="scale"
                            name="scale" placeholder="scale" required min="1" max="5" step="1">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="badge btn-bg-blue rounded-pill">1</span>
                            <span class="badge btn-bg-blue rounded-pill">2</span>
                            <span class="badge btn-bg-blue rounded-pill">3</span>
                            <span class="badge btn-bg-blue rounded-pill">4</span>
                            <span class="badge btn-bg-blue rounded-pill">5</span>
                        </div>
                        @error('scale')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form><!-- End floating Labels Form -->
        </div>
    </div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var scaleInput = document.getElementById("scale");
            var scaleOutput = document.getElementById("scaleOutput");

            scaleInput.addEventListener("input", function() {
                scaleOutput.textContent = scaleInput.value;
            });
        });
    </script>



    <script type="text/javascript">
        var path = "{{ route('getMemberForRef') }}";

        $('#search').select2({
            placeholder: 'Select Member',
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.firstName,
                                id: item.id,
                                firstName: item
                                    .firstName // Adding firstName attribute to the option data
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Update the hidden input field with the selected member's ID
        $('#search').on('select2:select', function(e) {
            var data = e.params.data;
            $('#selectedMemberId').val(data.id);
            $('#memberName').val(data.firstName);
        });
    </script>


    {{-- toggle between internal and external --}}

    <script>
        $(document).ready(function() {
            // Show the internal portion by default
            $("#memberListDropdown").show();

            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("id");
                if (inputValue === "internal") {
                    $("#memberListDropdown").show();
                    $("#memberListInput").hide();
                    // $('.contactName').val('');
                    // $('.contactEmail').val('');
                } else if (inputValue === "external") {
                    $("#memberListDropdown").hide();
                    $("#memberListInput").show();
                }
            });
        });
    </script>


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
            function loadMembers(circleId) {
                // Clear the member dropdown
                $('#memberId').empty().append('<option value="" disabled>Select Member</option>');

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

                                // Pre-select the authenticated member if exists in the list
                                var defaultMemberId =
                                    '{{ auth()->user()->member->id }}'; // Assuming memberId is available
                                if (defaultMemberId) {
                                    $('#memberId').val(defaultMemberId).trigger(
                                        'change'
                                    ); // Set the default selected member and trigger the change event
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

            // Load members on page load if a circle is selected by default
            var defaultCircleId =
                '{{ auth()->user()->member->circleId }}'; // Get the default circle ID from the authenticated user
            if (defaultCircleId) {
                loadMembers(defaultCircleId); // Load members for the default circle
            }

            // Handle circle dropdown change event
            $('#circleId').on('change', function() {
                var circleId = $(this).val();
                loadMembers(circleId); // Load members based on the selected circle
            });

            // Handle member dropdown change event
            $('#memberId').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var memberId = selectedOption.val();
                var userId = selectedOption.data('user-id'); // Retrieve the userId here
                var firstName = selectedOption.data('first-name');
                var lastName = selectedOption.data('last-name');

                // Check if a valid member is selected
                if (memberId) {
                    // Update the meetingPersonId field with userId and name fields
                    $('#meetingPersonId').val(userId); // Set the correct userId here
                    $('#meetingPersonName').val(firstName + ' ' + lastName); // Set the name
                } else {
                    // Reset the meeting person fields when no member is selected
                    $('#meetingPersonId').val('');
                    $('#meetingPersonName').val('');
                }

                console.log('Selected Member ID:', memberId);
                console.log('Selected Member User ID:', userId); // Log the correct userId
                console.log('Selected Member Name:', firstName + ' ' + lastName);
            });
        });
    </script>


    <!-- Your JavaScript code to trigger inclusion of circleMemberMaster -->

@endsection
