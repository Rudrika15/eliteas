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

<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Training</h5>
        <a href="{{ route('training.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Form -->
    <form class="m-3 needs-validation" id="trainingForm" enctype="multipart/form-data" method="post"
        action="{{ route('training.store') }}" novalidate>
        @csrf

        {{-- Trainer 1 --}}
        <h3><b>Trainer 1</b></h3>
        <hr>
        <div class="row">
            <div class="col-md-6">
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
                    <input type="hidsden" name="trainerId" id="trainerId">
                    <input type="text" class="form-control mt-3" id="trainerName" name="memberName"
                        placeholder="Select Member">
                </div>
                <div class="external-trainer-list" id="memberListInputMember" style="display:none;">
                    @include('TrainerPerson1External')
                    <input type="hidsden" name="externalTrainerId" id="userId">
                    <input type="text" class="form-control mt-3" id="trainerNameExternal" name="trainerNameExternal"
                        placeholder="Trainer Name External">
                </div>

                <!-- Contact details -->
                <input type="text" class="form-control mt-3" id="trainerContact" name="contactNo"
                    placeholder="Contact No">
                <input type="text" class="form-control mt-3" id="trainerEmail" name="email" placeholder="Email">
            </div>
        </div>

        {{-- Trainer 2 --}}
        <h3><b>Trainer 2</b></h3>
        <hr>
        <div class="row">
            <div class="col-md-6">
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
                    <input type="hidsden" name="trainerId2" id="trainerId2">
                    <input type="text" class="form-control mt-3" id="trainerName2" name="trainerNameInternal"
                        placeholder="Trainer Name Internal">
                </div>
                <div class="member-list" id="memberListInput" style="display:none;">
                    @include('TrainerPerson2External')
                    <input type="text" class="form-control mt-3" id="trainerNameExternal2" name="trainerNameExternal2"
                        placeholder="Trainer Name External">
                </div>

                <!-- Contact details -->
                <input type="text" class="form-control mt-3" id="trainerContact2" name="contactNo2"
                    placeholder="Contact No">
                <input type="text" class="form-control mt-3" id="trainerEmail2" name="email2" placeholder="Email">
            </div>
        </div>

        {{-- Training Details --}}
        <div class="accordion-item mt-3">
            <h2 class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                    aria-expanded="false" aria-controls="collapseSix">
                    Training Details
                </button>
            </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix">
                <div class="accordion-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control mt-3" id="title" name="title" placeholder="Title">
                            <input type="text" class="form-control mt-3" id="fees" name="fees" placeholder="Fees">
                            <select class="form-select mt-3" id="type" name="type">
                                <option value="" selected disabled>Select Meeting Type</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                            </select>
                            <input type="text" class="form-control mt-3" id="meetingLink" name="meetingLink"
                                placeholder="Meeting Link" style="display:none;">
                            <input type="text" class="form-control mt-3" id="venue" name="venue" placeholder="Venue"
                                style="display:none;">
                            <input type="date" class="form-control mt-3" id="date" name="date" placeholder="Date">
                            <input type="time" class="form-control mt-3" id="time" name="time" placeholder="Time">
                            <input type="text" class="form-control mt-3" id="duration" name="duration"
                                placeholder="Duration">
                            <textarea class="form-control mt-3" id="note" name="note" placeholder="Note"
                                rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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

        Initialize Select2 for member selection
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
                                firstName: item.firstName // Adding firstName attribute to the option data
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

        $('#trainerName, #trainerNameExternal').on('select2:select', function(e) {
        var data = e.params.data;
        $(this).closest('.external-trainer-list').find('input[name="trainerId"]').val(data.id);
        });
        });

</script>

@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection