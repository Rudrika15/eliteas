@extends('layouts.master')

@section('header', 'Training')
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
        <h5 class="card-title">Edit Training</h5>
        <a href="{{ route('training.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="trainingForm" enctype="multipart/form-data" method="post"
        action="{{ route('training.update') }}" novalidate>
        @csrf

        {{-- Trainer 1 Start --}}

        <h3><b>Trainer 1</b></h3>
        <hr>

        <div class="row-col-12">
            <div class="col-md-6">

                {{-- get old value of radio button --}}
                @php($radioValue = old('groupMember', ''))

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="groupMember" id="internalMember"
                                value="internalMember" {{ $radioValue=='internalMember' ? 'checked' : '' }}>
                            <label class="form-check-label" for="internalMember">
                                Internal
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="groupMember" id="externalMember"
                                value="externalMember" {{ $radioValue=='externalMember' ? 'checked' : '' }}>
                            <label class="form-check-label" for="externalMember">
                                External
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row pt-5">
                <div class="col-md-4" id="memberListDropdownMember" style="">
                    <div class="col-md-12">
                        @include('TrainerPerson1')
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" id="trainerId" name="memberId" value="{{ old('trainerId') }}">
                        <div class="form-floating">

                            <!-- Searchable input field -->
                            <input type="text" name="memberName" class="form-control" id="trainerName" name="memberName"
                                placeholder="Select Member" value="{{ $trainer->memberName }}">
                            <label for="memberName">Trainer Name</label>
                            @error('memberId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="col-md-12" id="memberListInputMember" style="display:none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('contactName') is-invalid @enderror"
                            id="trainerNameExternal" name="memberNameExternal" placeholder="Contact Name"
                            value="{{ $training->memberNameExternal }}">
                        <label for="contactName">Trainer Name External</label>
                        @error('contactName')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('contactNo') is-invalid @enderror"
                            id="trainerContact" placeholder="Contact No" value="{{ $training->contactNo }}">
                        <label for="contactNo">Contact No</label>
                        @error('contactNo')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="trainerEmail"
                            name="email" placeholder="email" value="{{ $training->email }}">
                        <label for="email">Email</label>
                        @error('email')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
</div>

{{-- Triainer 1 End --}}

{{-- Trainer 2 Start --}}
<br>
<br>
<h3><b>Trainer 2</b></h3>
<hr>
<br>
<br>


<div class="col-md-6  border-start">
    {{-- get old value of radio button --}}
    @php($radioValue = old('group', ''))

    <div class="row">
        <div class="col-sm-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="group" id="internal" value="internal" {{
                    $radioValue=='internal' ? 'checked' : '' }}>
                <label class="form-check-label" for="internal">
                    Internal
                </label>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="group" id="external" value="external" {{
                    $radioValue=='external' ? 'checked' : '' }}>
                <label class="form-check-label" for="external">
                    External
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id="memberListDropdown" style="display:none;">
            <div class="form-floating mt-3">
                <div class="row">
                    <div class="col-md-4">
                        @include('trainerPerson2')
                    </div>
                    <div class="col-md-8">
                        <input type="hidden" class="form-control" name="trainerMemberId2" id="trainerId2"
                            value="{{ old('trainerMemberId2') }}">
                        <div class="form-floating">
                            <input type="text" class="form-control contactName" id="trainerName2"
                                name="trainerNameInternal" placeholder="Trainer Name Internal"
                                value="{{ $training->trainerName }}">
                            <label for="trainerName">Trainer Name</label>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-md-12" id="memberListInput" style="display:none;">
            <div class="form-floating mt-3">
                <input type="text" class="form-control @error('trainerName') is-invalid @enderror"
                    id="trainerNameExternal" name="trainerNameExternal" placeholder="Trainer Name"
                    value="{{ $training->trainerName }}">
                <label for="trainerName">Trainer Name</label>
                @error('trainerName')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-floating mt-3">
                <input type="text" class="form-control @error('contactNo') is-invalid @enderror selectedMemberContact"
                    id="trainerContact2" name="contactNo" placeholder="Contact No" value="{{ $training->contactNo }}">
                <label for="contactNo">Contact No</label>
                @error('contactNo')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-floating mt-3">
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="trainerEmail2"
                    name="email2" placeholder="email2" value="{{ $training->email }}">
                <label for="email2">Email</label>
                @error('email')
                <div class="invalid-tooltip">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>


{{-- Trianer 2 End --}}

<div class="col-md-12">
    <div class="accordion-item mt-3">
        <h2 class="accordion-header" id="headingSix">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix"
                aria-expanded="true" aria-controls="collapseSix">
                Training Details
            </button>
        </h2>
        <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix"
            data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" placeholder="Title" value="{{ $training->title }}">
                            <label for="title">Title</label>
                            @error('title')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('fees') is-invalid @enderror" id="fees"
                                name="fees" placeholder="Fees" value="{{ $training->fees }}">
                            <label for="fees">Fees</label>
                            @error('fees')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                <option value="" disabled>Select Meeting Type</option>
                                <option value="Online" {{ old('type')=='Online' ? 'selected' : '' }}>Online
                                </option>
                                <option value="Offline" {{ old('type')=='Offline' ? 'selected' : '' }}>Offline
                                </option>
                            </select>
                            <label for="type">Meeting Type</label>
                            @error('type')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('meetingLink') is-invalid @enderror"
                                id="meetingLink" name="meetingLink" placeholder="Meeting Link"
                                value="{{ $training->meetingLink }}">
                            <label for="meetingLink">Meeting Link</label>
                            @error('meetingLink')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue"
                                name="venue" placeholder="Venue" value="{{ $training->venue }}">
                            <label for="venue">Venue</label>
                            @error('venue')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" placeholder="Date" value="{{ old('date', $training->date) }}">
                            <label for="date">Date</label>
                            @error('date')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="time" class="form-control @error('time') is-invalid @enderror" id="time"
                                name="time" placeholder="Time" value="{{ old('time', $training->time) }}">
                            <label for="time">Time</label>
                            @error('time')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control @error('duration') is-invalid @enderror"
                                id="duration" name="duration" placeholder="Duration" value="{{ $training->duration }}">
                            <label for="duration">Duration</label>
                            @error('duration')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating mt-3">
                            <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                                placeholder="Note" rows="3">{{ $training->note }}</textarea>
                            <label for="note">Note</label>
                            @error('note')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




</div>

<div class="text-center mt-3">
    <button type="submit" class="btn btn-primary">Submit</button>
    <button type="reset" class="btn btn-secondary">Reset</button>
</div>
</form><!-- End floating Labels Form -->
</div>


<script type="text/javascript">
    $(document).ready(function(){

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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>




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
                                firstName: item.firstName // Adding firstName attribute to the option data
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

<script>
    $(document).ready(function() {
            // Show the internal portion by default
            $("#memberListDropdownMember").show();

            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("id");
                if (inputValue === "internalMember") {
                    $("#memberListDropdownMember").show();
                    $("#memberListInputMember").hide();
                    // $('.contactName').val('');
                    // $('.contactEmail').val('');
                } else if (inputValue === "externalMember") {
                    $("#memberListDropdownMember").hide();
                    $("#memberListInputMember").show();
                }
            });
        });
</script>

@endsection