@extends('layouts.master')

@section('header', 'Circle 1:1 Meeting')
@section('content')

    <style>
     
    </style>
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
            <h5 class="card-title">Create 1:1 Meeting</h5>
            <a href="{{ route('circlecall.index') }}" class="btn btn-secondary btn-sm">BACK</a>
        </div>

        <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post" action="{{ route('circlecall.store') }}" novalidate>
            @csrf

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Select circle
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">

                        <div class="modal-body ">

                            <div class="row d-flex  justify-content-center ">
                                <div class="col-md-12 border-bottom pb-3">
                                    {{-- <h2> Circles </h2> --}}
                                    <div id="circleCards" class="row row-cols-4 g-4 ">
                                        <!-- Circle cards will be populated dynamically via JavaScript -->
                                    </div>

                                </div>

                                <div class="col-md-12 p-3 ">
                                    <div id="circleMembers">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="hidden" id="selectedMemberId" name="meetingPersonId">
                        <input type="text" class="form-control" readonly id="meetingPersonId" placeholder="Select Member">
                        <label for="memberName">Meeting Person Name</label>
                        @error('memberId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Hidden field to store the selected member's ID -->


                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror" id="meetingPlace" name="meetingPlace" placeholder="Meeeting Place Name" required>
                        <label for="meetingPlace">Meeting Place Name</label>
                        @error('meetingPlace')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <?php
                        use Illuminate\Support\Carbon;
                        $nearestDate = $scheduleDate->min();
                        $nearestDate = $nearestDate ? Carbon::parse($nearestDate)->subDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');
                        $startDate = Carbon::now()->subDay(15)->format('Y-m-d');
                        // $nearestDate = '2024-04-24';
                        // $startDate = '2024-04-07';
                        ?>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" placeholder="Meeting Date" required min="{{ $startDate }}" max="{{ $nearestDate }}">
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
                        <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" placeholder="Remarks" required>
                        <label for="remarks">Remarks</label>
                        @error('remarks')
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


    {{-- script section --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .circle-image {
            width: 30px;
            height: 30px;
            background-color: #144681;
            /* Blue color */
            border-radius: 50%;
            /* Make it round */
            font-size: 18px;
            line-height: 30px;
            /* Center the text vertically */
            color: #fff;
            /* White text color */
            margin: auto;
            /* Center the circle */
        }

        .circle-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .circle-card.active {
            background-color: #144681;
            color: #fff !important;

            .circle-image {
                background-color: #fff;
                color: #144681;
                font-weight: bold;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            // Function to fetch and display circle members
            function showCircleMembers(circleId) {
                $.ajax({
                    url: "/get-circle-members?circleId=" + circleId,
                    dataType: 'json',
                    success: function(data) {
                        if (data.length > 0) {
                            // Display circle members in the designated area
                            var membersList = '<div class="row row-cols-1 row-cols-md-4 g-4">';
                            data.forEach(function(member) {
                                // Create a unique ID for each member card
                                var memberId = member.userId;
                                // console.log("member id", memberId);
                                // Construct the HTML for the member card
                                membersList += '<div class="col">';
                                membersList += '<div id="' + memberId + '" class="card h-90 member-card" data-member-id="' + member.userId + '">';
                                membersList += '<div class="d-flex align-items-center justify-content-center bg-light rounded-circle mx-auto" style="width: 100px; height: 90px;">';
                                membersList += '<img src="{{ asset('ProfilePhoto') }}/' + member.profilePhoto + '" class="card-img-top rounded-circle" alt="' + member.firstName + ' ' + member.lastName + '" style="width: 80px; height: 80px;">';
                                membersList += '</div>';
                                membersList += '<div class="card-body text-center">';
                                membersList += '<h5 class="card-title">' + member.title + ' ' + member.firstName + ' ' + member.lastName + '</h5>';
                                membersList += '<p class="card-text">' + member.user.email + '</p>';
                                membersList += '<p class="card-text">' + member.contact.mobileNo + '</p>';
                                membersList += '<hr>';
                                membersList += '<p class="card-text">' + member.companyName + '</p>';
                                membersList += '</div></div></div>';
                            });
                            membersList += '</div>';
                            $('#circleMembers').html(membersList);

                            // Event listener for member card click
                            $('.member-card').click(function() {
                                var memberId = $(this).data('member-id');
                                var memberName = $(this).find('.card-title').text();

                                // Update the input field with the member's name
                                $('#meetingPersonId').val(memberName);

                                // Update the hidden field with the member's ID
                                $('#selectedMemberId').val(memberId);

                                // Close the modal
                                $('#staticBackdrop').modal('hide');
                            });
                        } else {
                            $('#circleMembers').html('<p>No members found.</p>');
                        }
                    }
                });
            }


            // Function to fetch and display user's circles
            function showUserCircles(userCircleName) {
                $.ajax({
                    url: "/get-circle",
                    dataType: 'json',
                    success: function(data) {
                        var circles = data.circles;
                        var userCircleName = data.userCircleName;

                        // Find the user's circle and move it to the first position in the array
                        var userCircle = null;
                        circles.forEach(function(circle, index) {
                            if (circle.circleName === userCircleName) {
                                userCircle = circle;
                                circles.splice(index, 1); // Remove the user's circle from the array
                            }
                        });
                        if (userCircle) {
                            circles.unshift(userCircle); // Add the user's circle to the beginning of the array
                        }

                        // Populate cards with circle data
                        var circleCards = '';
                        circles.forEach(function(circle) {
                            var initial = circle.circleName.charAt(0).toUpperCase(); // Get the first character and capitalize it
                            var isActive = (circle.circleName === userCircleName) ? 'active' : ''; // Check if the circle is the user's circle

                            circleCards += '<div class="col-md-3" style="cursor: pointer">';
                            circleCards += '<div class="border p-2 text-center circle-card ' + isActive + '" data-circle-id="' + circle.id + '">';
                            circleCards += '<div class=" mb-3">';
                            circleCards += '<div class="circle-image">' + initial + '</div>'; // Placeholder image using first initial
                            circleCards += '<h5 class="text-center">' + circle.circleName + '</h5>';
                            circleCards += '</div></div></div>';
                        });
                        $('#circleCards').html(circleCards);

                        // Event listener for circle card click
                        $('.circle-card').click(function() {
                            var circleId = $(this).data('circle-id');
                            showCircleMembers(circleId);
                        });

                        // If user's circle is found, display its members by default
                        if (userCircle) {
                            showCircleMembers(userCircle.id);
                        }
                    }
                });
            }

            // Call the function to show user's circles when the page loads
            showUserCircles();

            $(document).on('click', '.circle-card', function() {
                // Remove 'active' class from all circle cards
                $('.circle-card').removeClass('active');
                // Add 'active' class to the clicked circle card
                $(this).addClass('active');
            });
        });
    </script>

    {{-- get member name and print into the input field  --}}


@endsection
