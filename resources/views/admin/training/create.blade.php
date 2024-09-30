@extends('layouts.master')

@section('header', 'Training')
@section('content')

    {{-- Message --}}
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                &times;
            </button>
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                &times;
            </button>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card ">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Training</h5>
            <a href="{{ route('training.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>



        <!-- Form -->
        <form class="m-3 needs-validation" id="trainingForm" enctype="multipart/form-data" method="post"
            action="{{ route('training.store') }}" novalidate>
            @csrf

            {{-- Trainer 1 and Trainer 2 --}}
            <div class="row m-3">
                <div class="col-md-6">
                    <!-- Trainer 1 -->
                    <h3><b>Trainer 1</b></h3>
                    <hr>
                    <!-- Trainer selection -->
                    <div class="form-check">
                        <input class="form-check-input trainer-radio" type="radio" name="groupMember" id="internalMember"
                            value="internalMember" checked>
                        <label class="form-check-label" for="internalMember">Internal</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input trainer-radio" type="radio" name="groupMember" id="externalMember"
                            value="externalMember">
                        <label class="form-check-label" for="externalMember">External</label>
                    </div>

                    <!-- Member selection -->
                    <div class="member-list" id="memberListDropdownMember">
                        @include('TrainerPerson1')
                        <div class="form-floating mt-3">
                            <input type="hidden" name="trainerId" id="trainerId">
                            <input type="text" class="form-control" id="trainerName" name="memberName"
                                placeholder="Select Member" readonly required>
                            <label for="trainerName">Select Member</label>
                        </div>
                    </div>
                    <div class="external-trainer-list" id="memberListInputMember" style="display:none;">
                        @include('TrainerPerson1External')
                        <div class="form-floating mt-3">
                            <input type="hidden" name="externalTrainerId" id="externalTrainerId">
                            <input type="text" class="form-control" id="trainerNameExternal" name="trainerNameExternal"
                                placeholder="Trainer Name External" readonly>
                            <label for="trainerNameExternal">Trainer Name External</label>
                        </div>
                    </div>

                    <!-- Contact details -->
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="trainerContact" name="contactNo"
                            placeholder="Contact No" readonly>
                        <label for="trainerContact">Contact No</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="trainerEmail" name="email" placeholder="Email"
                            readonly>
                        <label for="trainerEmail">Email</label>
                    </div>
                </div>

                <div class="col-md-6" id="trainer2Container" style="display:none;">
                    <!-- Trainer 2 -->
                    <h3><b>Trainer 2</b></h3>
                    <hr>
                    <!-- Trainer selection -->
                    <div class="form-check">
                        <input class="form-check-input trainer-radio" type="radio" name="group" id="internal"
                            value="internal" checked>
                        <label class="form-check-label" for="internal">Internal</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input trainer-radio" type="radio" name="group" id="external"
                            value="external">
                        <label class="form-check-label" for="external">External</label>
                    </div>

                    <!-- Member selection -->
                    <div class="member-list" id="memberListDropdown" style="display:none;">
                        @include('TrainerPerson2')
                        <input type="hidden" name="trainerId2" id="trainerId2">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" id="trainerName2" name="trainerNameInternal"
                                placeholder="Trainer Name Internal" readonly>
                            <label for="trainerName2">Trainer Name Internal</label>
                        </div>
                    </div>
                    <div class="member-list" id="memberListInput" style="display:none;">
                        @include('TrainerPerson2External')
                        <input type="hidden" name="externalTrainerId2" id="externalTrainerId2">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" id="trainerNameExternal2"
                                name="trainerNameExternal2" placeholder="Trainer Name External" readonly>
                            <label for="trainerNameExternal2">Trainer Name External</label>
                        </div>
                    </div>

                    <!-- Contact details -->
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="trainerContact2" name="contactNo2"
                            placeholder="Contact No" readonly>
                        <label for="trainerContact2">Contact No</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="trainerEmail2" name="email2"
                            placeholder="Email" readonly>
                        <label for="trainerEmail2">Email</label>
                    </div>
                </div>
            </div>

            <!-- Button to toggle Trainer 2 form -->
            <button type="button" class="btn btn-bg-orange mt-3 m-3" id="toggleTrainer2Button">Add Trainer 2</button>


            {{-- Training Details --}}
            <div class="accordion-item mt-3 m-3">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed show" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        Training Details
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-3" id="title" name="title"
                                            placeholder="Title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-3" id="fees" name="fees"
                                            placeholder="Fees">
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select mt-3" id="type" name="type" required>
                                            <option value="" selected disabled>Select Meeting Type</option>
                                            <option value="Online">Online</option>
                                            <option value="Offline">Offline</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-3" id="meetingLink"
                                            name="meetingLink" placeholder="Meeting Link" style="display:none;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-3" id="venue" name="venue"
                                            placeholder="Venue" style="display:none;">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control mt-3" id="date" name="date"
                                            placeholder="Date" min="{{ date('Y-m-d') }}" onkeydown="return false"
                                            required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="time" class="form-control mt-3" id="time" name="time"
                                            placeholder="Time" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control mt-3" id="duration" name="duration"
                                            placeholder="Duration">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea class="form-control mt-3" id="note" name="note" placeholder="Note" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        document.getElementById('toggleTrainer2Button').addEventListener('click', function() {
            var trainer2Container = document.getElementById('trainer2Container');
            if (trainer2Container.style.display === 'none') {
                trainer2Container.style.display = 'block';
                this.textContent = 'Hide Trainer 2'; // Change button text
            } else {
                trainer2Container.style.display = 'none';
                this.textContent = 'Add Trainer 2'; // Change button text back
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            // Show/hide trainer member lists based on radio button selection
            $('.trainer-radio').click(function() {
                var inputValue = $(this).val();
                if (inputValue === "internalMember") {
                    $('#memberListDropdownMember').show();
                    $('#memberListInputMember').hide();
                } else if (inputValue === "externalMember") {
                    $('#memberListDropdownMember').hide();
                    $('#memberListInputMember').show();
                } else if (inputValue === "internal") {
                    $('#memberListDropdown').show();
                    $('#memberListInput').hide();
                } else if (inputValue === "external") {
                    $('#memberListDropdown').hide();
                    $('#memberListInput').show();
                }
            });

            // Show/hide meeting link or venue input based on meeting type selection
            $('#type').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === "Online") {
                    $('#meetingLink').show();
                    $('#venue').hide();
                } else if (selectedValue === "Offline") {
                    $('#meetingLink').hide();
                    $('#venue').show();
                }
            });

            Initialize Select2
            for member selection
            $('#trainerName, #trainerNameExternal').select2({
                placeholder: 'Select Member',
                ajax: {
                    url: "{{ route('getTrainerDetails') }}",
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

            // Update the hidden input field with the selected member's ID and name
            $('#trainerName, #trainerNameExternal').on('select2:select', function(e) {
                var data = e.params.data;
                $(this).closest('.external-trainer-list').find('input[name="trainerId"]').val(data.id);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Show/hide trainer member lists based on radio button selection
            $('.trainer-radio').change(function() {
                var inputValue = $(this).val();
                if (inputValue === "internalMember") {
                    $('#memberListDropdownMember').show();
                    $('#memberListInputMember').hide();
                } else if (inputValue === "externalMember") {
                    $('#memberListDropdownMember').hide();
                    $('#memberListInputMember').show();
                } else if (inputValue === "internal") {
                    $('#memberListDropdown').show();
                    $('#memberListInput').hide();
                } else if (inputValue === "external") {
                    $('#memberListDropdown').hide();
                    $('#memberListInput').show();
                }
            });

            // show/hide internal or external member based on radio button selection on page load
            $('.trainer-radio:checked').change();

            $('#trainerName, #trainerNameExternal').on('select2:select', function(e) {
                var data = e.params.data;
                $(this).closest('.external-trainer-list').find('input[name="trainerId"]').val(data.id);
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {

            var selectElement = document.getElementById("type");

            selectElement.onchange = function() {

                var selectedValue = selectElement.value;

                var meetingLinkElement = document.getElementById("meetingLink");

                var venueElement = document.getElementById("venue");

                meetingLinkElement.style.display = "none";

                venueElement.style.display = "none";

                if (selectedValue === "Online") {
                    meetingLinkElement.style.display = "block";

                } else if (selectedValue === "Offline") {
                    venueElement.style.display = "block";

                }
            };
            selectElement.onchange();
        });
    </script>




@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
