@extends('layouts.master')

@section('header', 'Train Master')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Create Train Master</h5>
                <a href="{{ route('trainer.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>

            <!-- Floating Labels Form -->
            <form class="m-3 needs-validation" id="trainmasterForm" enctype="multipart/form-data" method="post"
                action="{{ route('trainer.store') }}" novalidate>
                @csrf



                <div class="row">
                    <div class="col-md-6">
                        <!-- Trainer Selection -->
                        <div class="form-check">
                            <input class="form-check-input trainer-radio" type="radio" name="type" id="internal"
                                value="internalMember"
                                {{ old('type', 'internalMember') == 'internalMember' ? 'checked' : '' }}>
                            <label class="form-check-label" for="internal">Internal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input trainer-radio" type="radio" name="type" id="external"
                                value="externalMember" {{ old('type') == 'externalMember' ? 'checked' : '' }}>
                            <label class="form-check-label" for="external">External</label>
                        </div>

                        <div class="col-md-12 d-flex mt-3">
                            <div class="form-floating flex-fill me-2">
                                <select class="form-select" id="circleId" name="circleId" required>
                                    <option value="" selected disabled>Select Circle</option>
                                    @foreach ($circles as $circle)
                                        <option value="{{ $circle->id }}"
                                            data-members="{{ json_encode($circle->members) }}">
                                            {{ $circle->circleName }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="circleId">Circle</label>
                                @error('circleId')
                                    <div class="invalid-tooltip">This field is required.</div>
                                @enderror
                            </div>

                            <div class="form-floating flex-fill">
                                <select class="form-select @error('memberId') is-invalid @enderror" id="memberId"
                                    name="memberId" required>
                                    <option value="">Select Member</option>
                                    <!-- Options will be populated dynamically -->
                                </select>
                                <label for="memberId">Member</label>
                                @error('memberId')
                                    <div class="invalid-tooltip">This field is required.</div>
                                @enderror
                            </div>
                        </div>


                        <!-- Member Selection -->
                        <div class="member-list mt-3" id="memberListDropdownMember">
                            @include('InternalTrainer')
                            <input type="hidden" name="trainerId" id="trainerId">
                            <input type="text" class="form-control mt-3" id="trainerName" name="memberName"
                                placeholder="Select Member" readonly>
                            <input type="text" class="form-control mt-3" id="trainerContact" name="contactNo"
                                placeholder="Contact No" readonly>
                            <input type="text" class="form-control mt-3" id="trainerEmail" name="email"
                                placeholder="Email" readonly>
                        </div>
                        {{-- Uncomment if using external trainers
                        <div class="externalTrainer mt-3" id="externalTrainer">
                            <input type="hidden" name="externalTrainerId" id="externalTrainerId">
                            <input type="text" class="form-control mt-3" id="trainerNameExternal"
                                name="trainerNameExternal" placeholder="Trainer Name External">
                        </div>
                        --}}
                    </div>
                </div>


                {{-- external Trainers Details --}}



                <div class="row mb-3 externalTrainer">
                    <br>
                    <b>External Trainer Details</b>
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                                id="firstName" name="firstName" placeholder="First Name">
                            <label for="firstName">First Name</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                                id="lastName" name="lastName" placeholder="Last Name">
                            <label for="lastName">Last Name</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Email">
                            <label for="email">Email</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('contactNo') is-invalid @enderror"
                                id="contactNo" name="contactNo" placeholder="Contact No" value="{{ old('contactNo') }}"
                                pattern="[0-9]{10}"
                                oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                                oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');"
                                oninput="this.setCustomValidity('')">
                            <label for="contactNo">Contact No</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('bio') is-invalid @enderror" id="bio"
                                name="bio" placeholder="Bio">
                            <label for="bio">Bio</label>
                        </div>
                    </div>

                    {{-- 
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <label for="trainerImage" class="">Trainer Image <sup
                                    class="text-danger">*</sup></label>
                            <input type="file" class="form-control @error('trainerImage') is-invalid @enderror"
                                id="trainerImage" name="trainerImage" accept="image/*"
                                onchange="previewPhoto(event, 'trainerPreview')">
                            <span class="text-danger mt-1 d-block">*
                                File size:Max 2MB</span>
                            <div style="width: 100px; height: 100px; position: relative;" class="mt-3">
                                <img id="trainerPreview" src="default.jpg"
                                    style="width: 100%; height: 100%; object-fit: contain; aspect-ratio: 1/1;">
                            </div>

                            <!-- Display Company Logo Error -->
                            @error('trainerImage')
                                <span class="text-danger">The Maximum File Size is 2MB</span>
                            @enderror

                            <!-- Note about file size -->

                        </div>
                    </div> --}}



                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="file" class="form-control @error('trainerImage') is-invalid @enderror"
                                id="trainerImage" name="trainerImage" placeholder="Trainer Image"
                                accept=".jpg, .jpeg, .png" onchange="handleFileSelect(event)">
                            <label for="trainerImage">Trainer Image</label>
                            <img id="previewImage" src="{{ asset('img/profile.png') }}" class="mt-2" width="100px"
                                height="100px" style="display: block;">
                            <span class="text-danger">* Image size must be maximum 2MB</span><br>
                            <span class="text-danger">* Upload Photo of Trainer for Identification</span>
                        </div>
                    </div>

                    <script>
                        function handleFileSelect(event) {
                            var input = event.target;
                            var preview = document.getElementById('previewImage');

                            // Validate image size
                            let fileSize = input.files[0] ? input.files[0].size / 1024 / 1024 : 0;
                            if (fileSize > 2) {
                                input.setCustomValidity('Image size must be maximum 2MB');
                                input.reportValidity();
                                // Reset input if size is invalid
                                input.value = '';
                                preview.src = '{{ asset('img/profile.png') }}'; // Reset to default image
                                return;
                            } else {
                                input.setCustomValidity('');
                            }

                            // Preview image
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function() {
                                    var dataURL = reader.result;
                                    preview.src = dataURL; // Update preview with new image
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>

                    <script>
                        window.onload = function() {
                            document.getElementById("previewImage").src = "{{ asset('img/profile.png') }}";
                        }
                    </script>


                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    {{-- <button type="reset" class="btn btn-bg-orange">Reset</button> --}}
                </div>
            </form><!-- End floating Labels Form -->
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                // When a circle is selected, populate the member dropdown
                $('#circleId').change(function() {
                    console.log('Circle selected:', $(this).val());
                    var selectedOption = $(this).find('option:selected');
                    var members = selectedOption.data('members');

                    // Clear the member dropdown
                    $('#memberId').empty();
                    $('#memberId').append('<option value="">Select Member</option>');

                    // Populate the member dropdown with the members of the selected circle
                    if (members && members.length) {
                        console.log('Members of selected circle:', members);
                        members.forEach(function(member) {
                            $('#memberId').append('<option value="' + member.id + '">' + member
                                .firstName + ' ' + member.lastName + '</option>');
                        });
                    }
                });

                // When a member is selected, populate the contact and email fields
                $('#memberId').change(function() {
                    console.log('Member selected:', $(this).val());
                    var selectedOption = $(this).find('option:selected');
                    var memberId = selectedOption.val();

                    if (memberId) {
                        // Make an AJAX request to fetch the member's contact and email if not already present
                        console.log('Fetching member details for member ID:', memberId);
                        $.ajax({
                            url: '/get-member-details/' +
                                memberId, // Define this route in your Laravel controller
                            method: 'GET',
                            success: function(data) {
                                console.log('Member details:', data);
                                if (data.success) {
                                    // Populate the fields with the fetched data
                                    $('#trainerId').val(data.member.userId);
                                    $('#trainerName').val(data.member.firstName + ' ' + data.member
                                        .lastName);
                                    $('#trainerContact').val(data.contactNo || '');
                                    $('#trainerEmail').val(data.email || '');
                                } else {
                                    console.log('Member details not found.');
                                }
                            },
                            error: function() {
                                console.log('Error fetching member details.');
                            }
                        });
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                var selectedVal = '{{ old('type', 'internalMember') }}';
                toggleTrainerSections(selectedVal);

                $('.trainer-radio').change(function() {
                    selectedVal = $(this).val();
                    toggleTrainerSections(selectedVal);
                });

                function toggleTrainerSections(selectedVal) {
                    if (selectedVal == 'externalMember') {
                        $('.member-list').hide();
                        $('.externalTrainer').show();
                    } else {
                        $('.member-list').show();
                        $('.externalTrainer').hide();
                    }
                }
            });
        </script>


    @endsection
