<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $member->firstName ?? '-' }} {{ $member->lastName ?? '-' }}'s Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f3f2ef;
            font-family: 'Arial', sans-serif;
            margin: ;
        }

        .profile-header {
            background: linear-gradient(5deg, #1d3268, #e76a35);
            color: white;
            position: relative;
            padding: 20px;
        }

        .profile-header .cover-photo {
            height: 200px;
            background: url("{{ asset('') ?? 'https://via.placeholder.com/' }}") repeat center center;
            background-size: cover;
            border-radius: 0 0 10px 10px;
        }

        .profile-header .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 4px solid white;
            position: absolute;
            bottom: -75px;
            left: 20px;
            background: #fff;
            object-fit: cover;
        }

        .profile-header .user-info {
            margin-top: 70px;
            padding-left: 180px;
            padding-right: 20px;
        }

        .profile-header h3 {
            font-weight: bold;
        }

        .profile-header p {
            font-size: 14px;
        }

        .btn-connect {
            background-color: #e76a35;
            color: white;
            border: none;
            font-weight: bold;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
        }

        .btn-connect:hover {
            background-color: #d45a2b;
        }

        .content-section {
            background: white;
            margin-top: 20px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .content-section h5 {
            font-weight: bold;
            color: #1d3268;
        }

        .content-section ul {
            list-style-type: none;
            padding: 0;
        }

        .content-section ul li {
            margin-bottom: 10px;
        }

        .content-section ul li .title {
            font-weight: bold;
        }

        .content-section ul li .value {
            color: #555;
        }

        .bio-section {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
        }

        .top-profile,
        .gains-profile {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 10px;
        }

        .top-profile h3,
        .gains-profile h3 {
            color: #1d3268;
        }

        .top-profile ul,
        .gains-profile ul {
            list-style-type: none;
            padding: 0;
        }

        .top-profile ul li,
        .gains-profile ul li {
            margin-bottom: 10px;
        }

        .top-profile ul li strong,
        .gains-profile ul li strong {
            color: #e76a35;
        }

        /* Add orange color to tabs when active */
        .nav-tabs .nav-link.active {
            background-color: #e76a35;
            color: white;
        }

        .nav-tabs .nav-link {
            color: #555;
        }

        .logged-in {
            font-size: 24px;
            color: green;
            animation: blink 1s infinite;
        }

        .logged-out {
            font-size: 24px;
            color: red;
            animation: blink 1s infinite;
        }

        /* message model css */
        /* Base styles for the modal */
        .modal.fade .modal-dialog {
            transform: translateY(-30px) scale(0.95);
            /* Initial position and scale */
            opacity: 0;
            transition: all 0.4s ease-in-out;
            /* Smooth transition */
        }

        .modal.show .modal-dialog {
            transform: translateY(0) scale(1);
            /* Final position and scale */
            opacity: 1;
        }

        /* Backdrop effect for fade-in and fade-out */
        .modal-backdrop {
            opacity: 0;
            transition: opacity 0.4s ease-in-out;
        }

        .modal-backdrop.show {
            opacity: 0.5;
            /* Semi-transparent background */
        }

        /* Modal content styles */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            /* Prevents overflow for better animations */
            animation: popup-effect 0.4s ease-in-out;
            /* Add a popup effect */
        }

        /* Keyframes for popup effect */
        @keyframes popup-effect {
            0% {
                transform: scale(0.9);
                /* Start smaller */
                opacity: 0;
                /* Fully transparent */
            }

            100% {
                transform: scale(1);
                /* Normal size */
                opacity: 1;
                /* Fully visible */
            }
        }

        /* Modal body styles */
        .modal-body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #555;
            text-align: center;
            /* Center-align text */
        }

        .modal-body p {
            margin-bottom: 15px;
        }
    </style>

    <style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            display: none;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .memberName {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;

        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            overflow: hidden;
        }

        .chat-box {
            flex: 1;
            padding: 10px;
            overflow-y: scroll;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            scrollbar-width: none;
            /* For Firefox */
        }

        .chat-box::-webkit-scrollbar {
            display: none;
            /* For Chrome, Safari, and Edge */
        }

        .input-container {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #fff;
        }

        #chatInput {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            margin-right: 10px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        #sendButton {
            padding: 10px 20px;
            background-color: #e76a35;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        #sendButton:hover {
            background-color: #1d3268;
        }

        .message {
            padding: 10px;
            margin: 5px 0;
            border-radius: 20px;
            max-width: 80%;
            /* Adjusts the maximum width of the message box */
            word-wrap: break-word;
            position: relative;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 14px;
            display: block;
            /* Changed to block to ensure each message is on a new line */
            clear: both;
            /* Ensures messages don't appear on the same line */
        }

        .sender {
            background-color: #1d3268;
            color: white;
            text-align: right;
            margin-left: auto;
            border-radius: 20px 20px 0 20px;
            float: right;
            /* Aligns sender messages to the right */
        }

        .receiver {
            background-color: #e76a35;
            color: white;
            text-align: left;
            margin-right: auto;
            border-radius: 20px 20px 20px 0;
            float: left;
            /* Aligns receiver messages to the left */
        }

        /* Optional: add a small triangle for speech bubble effect */
        .message::after {
            content: "";
            position: absolute;
            border-width: 10px;
            border-style: solid;
        }

        .sender::after {
            border-color: #1d3268 transparent transparent transparent;
            /* right: -15px; */
            top: 10px;
            border-width: 10px 15px 10px 0;
        }

        .receiver::after {
            border-color: #e76a35 transparent transparent transparent;
            left: -5px;
            top: 10px;
            border-width: 10px 0 10px 15px;
        }
    </style>


</head>

<body>
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="cover-photo"></div>
        @php
            $profilePhoto = $member->profilePhoto;
        @endphp
        @if ($profilePhoto && file_exists(public_path('ProfilePhoto/' . $profilePhoto)))
            <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="Profile Picture" class="profile-picture">
        @else
            <img src="{{ asset('ProfilePhoto/profile.png') }}" alt="ProfilePhoto" class="profile-picture">
        @endif
        <div class="user-info">
            <h3>{{ $member->firstName ?? '' }} {{ $member->lastName ?? '' }}</h3>
            <p>{{ $member->companyName ?? '' }}</p>


            <!-- Dynamic Connect Button -->
            <div class="d-flex justify-content-end">
                @php
                    $memberCircleId = $member->circleId;
                    $userCircleId = null;

                    if (auth()->check()) {
                        $userCircleId = \App\Models\Member::where('userId', auth()->user()->id)->value('circleId');
                    }

                    // $memberStatus = \App\Models\Connection::where('memberId', $member->id)
                    //     ->where('userId', auth()->user()->id)
                    //     ->first();

                @endphp

                <!-- Keep the button as it was, just add the logic here -->
                @if ($memberCircleId == $userCircleId)
                    <!-- Display "Connected" button, and disable it -->
                    <button type="submit" class="btn btn-connect shadow-none">
                        Connected &nbsp;<i class="bi bi-check-circle-fill"></i>
                    </button>
                @elseif (!$memberStatus)
                    <!-- Display "Connect" button -->
                    <form action="{{ route('connect') }}" id="connectForm" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $member->user->id }}" name="memberId" id="memberId">
                        <button type="submit" class="btn btn-connect shadow-none" id="connectBtn">
                            Connect &nbsp;<i class="bi bi-person-plus-fill"></i>
                        </button>
                    </form>
                @elseif ($memberStatus->status == 'Accepted')
                    <!-- Display "Connected" button, and disable it -->
                    <button type="submit" class="btn btn-connect shadow-none">
                        Connected &nbsp;<i class="bi bi-check-circle-fill"></i>
                    </button>
                @elseif ($memberStatus->status == 'Rejected')
                    <!-- Display "Connect" button again after rejection -->
                    <form action="{{ route('connect') }}" id="connectForm" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $member->user->id }}" name="memberId" id="memberId">
                        <button type="submit" class="btn btn-connect shadow-none" id="connectBtn">
                            Connect &nbsp;<i class="bi bi-person-plus-fill"></i>
                        </button>
                    </form>
                @else
                    <!-- Display "Requested" button and disable it -->
                    <button type="submit" class="btn btn-connect shadow-none">
                        Requested &nbsp;<i class="bi bi-clock"></i>
                    </button>
                @endif

                {{-- @if (!empty($memberStatus) && $memberStatus->status == 'Accepted')
                    <button id="messageButton" class="btn btn-connect ms-2">
                        Message
                    </button>
                @else
                    <button id="messageButton" class="btn btn-connect ms-2">
                        Message
                    </button>
                @endif --}}


                @if (!empty($memberStatus) && $memberStatus->status == 'Accepted')
                    <button id="messageButton" class="btn btn-connect ms-2">
                        Message
                    </button>
                @else
                    <!-- No button is rendered in the else block -->
                @endif


                <!-- Small Popup Modal -->
                <div id="chatModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <div class="member-image">
                            {{-- <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}"
                                                    alt="profilePhoto" style="height:50px; width:50px;"
                                                    class="rounded-circle"> --}}
                        </div>
                        <span class="memberName">{{ $member->user->firstName }} {{ $member->user->lastName }}</span>

                        <div class="chat-container">
                            <div id="chatBox" class="chat-box"></div>
                            <form id="chatForm" method="POST" action="{{ route('send.message') }}">
                                @csrf
                                <input type="hidden" value="{{ $member->user->id }}" name="memberId" id="memberId">
                                <input type="hidden" id="sender_id" name="sender_id" value="{{ Auth::user()->id }}">
                                <div class="input-container">
                                    <input type="text" id="chatInput" name="message" placeholder="Type a message..." required>
                                    <button type="submit" id="sendButton">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#myProfile" role="tab" aria-controls="myProfile" aria-selected="true">My Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="bio-tab" data-bs-toggle="tab" href="#myBio" role="tab" aria-controls="myBio" aria-selected="false">My Bios</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="top-profile-tab" data-bs-toggle="tab" href="#topProfile" role="tab" aria-controls="topProfile" aria-selected="false">Tops Profile</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="gains-profile-tab" data-bs-toggle="tab" href="#gainsProfile" role="tab" aria-controls="gainsProfile" aria-selected="false">Gains Profile</a>
            </li>
        </ul>

        <!-- Tabs Content -->
        <div class="tab-content mt-3" id="profileTabContent">

            <!-- My Profile Tab -->
            <div class="tab-pane fade show active" id="myProfile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="content-section">
                    <h5>My Profile</h5>
                    <ul>
                        {{-- <li><span class="title">Full Name:</span> <span class="value">{{ $member->firstName ?? '-' }}
                                {{ $member->lastName ?? '-' }}</span></li> --}}
                        @if ($memberCircleId == $userCircleId)
                            <li><span class="title">Email:</span> <span class="value">{{ $member->user->email }}</span>
                            </li>
                            <li><span class="title">Mobile:</span> <span class="value">{{ $member->user->contactNo }}</span>
                            </li>
                        @elseif (isset($memberStatus) && $memberStatus->status == 'Accepted')
                            <li><span class="title">Email:</span> <span class="value">{{ $member->user->email }}</span>
                            </li>
                            <li><span class="title">Mobile:</span> <span class="value">{{ $member->user->contactNo }}</span>
                            </li>
                        @else
                            <li><span class="title">Email:</span> <span class="value">****{{ substr($member->user->email, -8) }}</span>
                            </li>
                            <li><span class="title">Mobile:</span> <span class="value">****{{ substr($member->user->contactNo, -3) }}</span>
                            </li>
                        @endif


                        <li><span class="title">Address:</span> <span class="value">{{ $member->billingAddress->bAddressLine1 ?? '-' }}
                                {{ $member->billingAddress->bAddressLine2 ?? '-' }} <br>
                                {{ $member->billingAddress->bCity ?? '-' }}
                                {{ $member->billingAddress->bState ?? '-' }}
                                {{ $member->billingAddress->bPinCode ?? '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- My Bio Tab -->
            <div class="tab-pane fade" id="myBio" role="tabpanel" aria-labelledby="bio-tab">
                <div class="content-section">
                    <h5>My Bio</h5>
                    <ul>
                        {{-- <li><span class="title">Email:</span> <span
                                class="value">{{ $member->user->email ?? 'Not Specified' }}</span></li> --}}
                        <li><span class="title">Language:</span> <span class="value">{{ $member->language ?? 'Not Specified' }}</span></li>
                        <li><span class="title">Hobbies & Interests:</span> <span class="value">{{ $member->language ?? 'Not Specified' }}</span></li>
                    </ul>
                </div>
            </div>

            <!-- Top Profile Tab -->
            <div class="tab-pane fade" id="topProfile" role="tabpanel" aria-labelledby="top-profile-tab">
                <div class="content-section">
                    <h5>Tops Profile</h5>
                    {{-- <ul>
                        <li><span class="title">Top Skill:</span> <span
                                class="value">{{ $member->topSkill ?? 'Not specified' }}</span></li>
                        <li><span class="title">Location:</span> <span
                                class="value">{{ $member->location ?? 'Not provided' }}</span></li>
                    </ul> --}}
                    Coming Soon

                </div>
            </div>

            <!-- Gains Profile Tab -->
            <div class="tab-pane fade" id="gainsProfile" role="tabpanel" aria-labelledby="gains-profile-tab">
                <div class="content-section">
                    <h5>Gains Profile</h5>
                    {{-- <ul>
                        <li><span class="title">Achievements:</span> <span
                                class="value">{{ $member->achievements ?? 'Not specified' }}</span></li>
                        <li><span class="title">Experience:</span> <span
                                class="value">{{ $member->experience ?? 'Not provided' }}</span></li>
                    </ul> --}}
                    Coming Soon

                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <script>
        // Get elements
        console.log('Getting elements');
        var modal = document.getElementById("chatModal");
        var btn = document.getElementById("messageButton");
        var span = document.getElementsByClassName("close")[0];
        var chatBox = document.getElementById("chatBox");
        var chatInput = document.getElementById("chatInput");
        var sendButton = document.getElementById("sendButton");
        var pollingInterval;
        console.log('Got elements');

        // Open the modal
        btn.onclick = function() {
            console.log('Button clicked');
            modal.style.display = "block";
            console.log('Modal displayed');
            fetchMessages(); // Fetch messages when the modal is opened
            startPolling(); // Start polling for new messages
        }

        // Close the modal
        span.onclick = function() {
            console.log('Close button clicked');
            modal.style.display = "none";
            console.log('Modal hidden');
            stopPolling(); // Stop polling when the modal is closed
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            console.log('Window clicked');
            if (event.target == modal) {
                console.log('Modal clicked');
                modal.style.display = "none";
                console.log('Modal hidden');
                stopPolling(); // Stop polling when clicking outside the modal
            }
        }

        // Handle sending a message
        sendButton.onclick = function() {
            console.log('Send button clicked');
            sendMessage();
        }

        chatInput.addEventListener("keypress", function(event) {
            console.log('Key pressed');
            if (event.key === "Enter") {
                console.log('Enter key pressed');
                sendMessage();
            }
        });



        function startPolling() {
            pollingInterval = setInterval(fetchMessages, 1000); // Poll every 1 second
        }

        function stopPolling() {
            clearInterval(pollingInterval);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there is a success message in the session
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = "{{ route('chat.index') }}";
                });
            @endif
        });
    </script>



    <script>
        // Wait for the DOM to load before running the script
        document.addEventListener('DOMContentLoaded', function() {
            // Get the "Message" button element
            const messageButton = document.getElementById('messageButton');

            // Initialize the modal using Bootstrap's Modal API
            const chatPopupModal = new bootstrap.Modal(document.getElementById('chatPopup'));

            // Add a click event listener to the "Message" button
            messageButton.addEventListener('click', function() {
                // Show the modal popup when the button is clicked
                chatPopupModal.show();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Handle form submission with AJAX
            $('#connectForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                let formData = $(this).serialize(); // Get the form data
                console.log('Form Data:', formData); // Log form data to console

                // Disable the button to prevent multiple submissions
                $('#connectBtn').prop('disabled', true);
                console.log('Button Disabled'); // Log button disabled state

                // Send AJAX request
                $.ajax({
                    url: $(this).attr('action'), // Form action
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Response:', response); // Log the response

                        // Check the response and show the corresponding SweetAlert
                        if (response.status ===
                            'success') { // Adjusted to check response.status
                            Swal.fire({
                                icon: 'success',
                                title: 'Connection Request Sent!',
                                text: 'Your connection request has been sent .',
                            }).then(function() {
                                // After success, update the button to show "Requested"
                                $('#connectBtn').html(
                                    'Requested &nbsp;<i class="bi bi-clock"></i>');
                                $('#connectBtn').prop('disabled', true);
                                console.log(
                                    'Button updated to "Requested"'
                                ); // Log button state
                            });
                        } else {
                            console.log('Response indicates failure:',
                                response); // Log failure case
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'There was a problem with your request.',
                            }).then(function() {
                                // Re-enable the button in case of error
                                $('#connectBtn').prop('disabled', false);
                                console.log(
                                    'Button re-enabled'); // Log button re-enable
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', error); // Log the error message
                        // If AJAX fails
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                        }).then(function() {
                            // Re-enable the button in case of error
                            $('#connectBtn').prop('disabled', false);
                            console.log(
                                'Button re-enabled after AJAX error'
                            ); // Log button re-enable
                        });
                    }
                });
            });
        });
    </script>



</body>

</html>
