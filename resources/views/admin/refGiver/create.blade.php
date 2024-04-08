@extends('layouts.master')

@section('header', 'Circle Meeting Member Refference')
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
            <h5 class="card-title">Circle Meeting Member Refference</h5>
            <a href="{{ route('refGiver.index') }}" class="btn btn-secondary btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="post" action="{{ route('refGiver.store') }}" novalidate>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6 ">
                            <label for="search" class="form-labelv fw-bold">Search member</label>

                        </div>

                    </div>
                    <select class="form-select" style="width: 99%" id="search">
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group" id="internal" value="option1" checked="">
                                <label class="form-check-label" for="internal">
                                    Internal
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group" id="external" value="option2">
                                <label class="form-check-label" for="external">
                                    External
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="hidden" id="selectedMemberId" name="memberId">

                        <!-- Searchable input field -->
                        <input type="text" class="form-control" readonly id="memberName" placeholder="Select Member">
                        <label for="memberName">Member Name</label>
                        @error('memberId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6" id="memberListDropdown" style="display:none;">
                    <div class="form-floating mt-3">

                        <select name="contactName" id="contactName" class="form-select">
                            @foreach ($members as $member)
                                <option value="{{ $member->firstname }}">{{ $member->firstName }}</option>
                            @endforeach
                        </select>
                        @error('contactName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6" id="memberListInput" style="display:none;">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('contactName') is-invalid @enderror" id="contactName" name="contactName" placeholder="Contact Name" required>
                        <label for="contactName">Contact Person Name</label>
                        @error('contactName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="refContactNo" name="contactNo" placeholder="Contact No" required>
                        <label for="contactNo">Contact No</label>
                        @error('contactNo')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="contactEmail" name="email" placeholder="email" required>
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="scale">Scale [1-5]</label>
                    <div class="form-floating mt-3">
                        <input type="range" class="form-range @error('scale') is-invalid @enderror" id="scale" name="scale" placeholder="scale" required min="1" max="5" step="1">
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="badge bg-primary rounded-pill">1</span>
                            <span class="badge bg-primary rounded-pill">2</span>
                            <span class="badge bg-primary rounded-pill">3</span>
                            <span class="badge bg-primary rounded-pill">4</span>
                            <span class="badge bg-primary rounded-pill">5</span>
                        </div>
                        @error('scale')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="description" required>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End floating Labels Form -->
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




    
    
    
    
    
    
    
    
    
    
    
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get radio buttons and member list dropdown div
            var internalRadio = document.getElementById("internal");
            var externalRadio = document.getElementById("external");
            var memberListDropdown = document.getElementById("memberListDropdown");
            var memberListInput = document.getElementById("memberListInput");
            var contactNoInput = document.getElementById("refContactNo");
            var emailInput = document.getElementById("contactEmail");

            // Function to show/hide member list dropdown or input field based on radio button selection
            function toggleMemberInput() {
                if (internalRadio.checked) {
                    memberListDropdown.style.display = "block";
                    memberListInput.style.display = "none";
                } else {
                    memberListDropdown.style.display = "none";
                    memberListInput.style.display = "block";
                }
            }

            // Initial toggle based on default checked radio button
            toggleMemberInput();

            // Add event listeners to radio buttons to toggle member list dropdown or input field
            internalRadio.addEventListener("change", toggleMemberInput);
            externalRadio.addEventListener("change", toggleMemberInput);

            // Add event listener to dropdown change to fetch member details
            // Add event listener to dropdown change to fetch member details
            var dropdown = document.getElementById("contactName");
            dropdown.addEventListener("change", function() {
                var selectedOption = dropdown.options[dropdown.selectedIndex];
                var selectedMember = selectedOption.value;
                console.log("selectedMember", selectedMember);
                // Make AJAX request to get member details
                fetch("/get-member-details?memberName=" + selectedMember)
                    .then(function(response) {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(function(data) {
                        console.log("Member details:", data); // Log the retrieved member details
                        // Update contact number and email inputs with member details
                        contactNoInput.value = data.contactNo;
                        emailInput.value = data.email;
                    })
                    .catch(function(error) {
                        console.error('Error fetching member details:', error);
                    });
            });

        });
    </script>



@endsection
