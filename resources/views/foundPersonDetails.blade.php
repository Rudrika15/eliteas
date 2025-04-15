@extends('layouts.master')
@section('content')
    @extends('components.foundPersonDetailsCSS')


    <style>
        .custom-btn {
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 12px;
            font-weight: 500;
            display: flex;

            align-items: center;
            gap: 8px;
            transition: all 0.2s ease-in-out;
        }

        .message-btn {
            background-color: #fff5e9;
            color: #e65c00;
        }

        .remove-btn {
            background-color: #ffeaea;
            color: #cc0000;
        }

        .custom-btn i {
            font-size: 18px;
        }

        /* Optional hover effect */
        .custom-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="container my-4">
        <div class="profile-wrapper shadow">
            <!-- Header -->
            <div class="cover-bg" style="background-image: url('{{ asset('img/coverImage.png') }}');"></div>

            <div class="text-center relative inline-block">
                @php $profilePhoto = $member->profilePhoto; @endphp

                @if ($profilePhoto && file_exists(public_path('ProfilePhoto/' . $profilePhoto)))
                    <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="Profile Picture" class="profile-image w-32 h-32 rounded-full border-4 border-white shadow-lg" />
                @else
                    <img src="{{ asset('ProfilePhoto/profile.png') }}" alt="ProfilePhoto" class="profile-image w-32 h-32 rounded-full border-4 border-white shadow-lg" />
                @endif


                @if ($memberInduction >= 4)
                    <!-- S Badge using updated SVG -->
                    <div class="absolute bottom-0 right-0 transform translate-x-1/4 translate-y-1/4 w-8 h-8">
                        <img src="{{ asset('img/s-badge.svg') }}" alt="S Badge" class="w-full h-full">
                    </div>
                @elseif ($memberInduction >= 8)
                    <!-- G Badge using updated SVG -->
                    <div class="absolute bottom-0 right-0 transform translate-x-1/4 translate-y-1/4 w-8 h-8">
                        <img src="{{ asset('img/g-badge.svg') }}" alt="G Badge" class="w-full h-full">
                    </div>
                @elseif ($memberInduction >= 25 || $memberInduction > 25)
                    <!-- P Badge using updated SVG -->
                    <div class="absolute bottom-0 right-0 transform translate-x-1/4 translate-y-1/4 w-8 h-8">
                        <img src="{{ asset('img/p-badge.svg') }}" alt="P Badge" class="w-full h-full">
                    </div>
                @endif
            </div>



            <!-- Name & Info -->
            <div class="text-center mt-2">
                <h5 class="mb-0 text-color fw-bold">
                    {{ $member->firstName ?? '' }} {{ $member->lastName ?? '' }} &nbsp;&nbsp;
                    @if ($memberCircleId == $userCircleId || ($connection && $connection->status == 'Accepted'))
                        <i class="bi bi-person-check-fill" style="color: #e76a35;"></i>
                        {{-- <span style="color: #e76a35;">Connected</span> --}}
                    @endif

                </h5>
                <small class="text-muted">{{ $member->companyName ?? '' }}</small>
                <p class="mt-2 px-4 text-muted">
                    {{ $member->bio ?? 'This member has not added a bio yet.' }}
                </p>
                <div class="d-flex justify-content-center gap-2 profile-buttons mb-4">
                    @if ($memberCircleId == $userCircleId || ($connection && $connection->status == 'Accepted'))
                        <button id="messageButton" class="custom-btn message-btn btn"><i class="bi bi-chat-left-text"></i> Message</button>
                        <button class="btn custom-btn remove-btn"><i class="bi bi-trash"></i> Remove</button>
                    @elseif ($connections->isEmpty() || ($connection && $connection->status == 'Rejected'))
                        <form action="{{ route('connect') }}" method="POST">
                            @csrf
                            <input type="hidden" name="memberId" value="{{ $member->id }}">
                            <button type="submit" class="btn btn-warning">Connect</button>
                        </form>
                    @elseif ($connection && $connection->status == 'Pending')
                        <button class="btn btn-secondary">Requested</button>
                    @endif
                </div>
            </div>


            <!-- Small Popup Modal -->
            <div id="chatModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="member-image">
                        {{-- <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}"
                                                    alt="profilePhoto" style="height:50px; width:50px;"
                                                    class="rounded-circle"> --}}
                    </div>
                    <span class="memberName text-color">{{ $member->user->firstName }} {{ $member->user->lastName }}</span>

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

            <!-- Details Section -->
            <div class="row px-4 pb-4 g-3">
                <!-- Contact -->
                <div class="col-md-4">
                    <div class="card-section h-100">
                        <h6 class="mb-3 contact">Contact Details</h6>
                        <div class="{{ $memberCircleId == $userCircleId || ($connection && $connection->status == 'Accepted') ? '' : 'blurred-info' }}">
                            <p><i class="bi bi-envelope me-2 text-muted"></i><strong class="text-muted">Email:</strong> <span class="text-color fw-bold"> {{ $member->user->email ?? 'N/A' }}</span></p>
                            <p><i class="bi bi-phone text-muted me-2"></i><strong class="text-muted">Phone:</strong> <span class="text-color fw-bold"> {{ $member->user->contactNo ?? 'N/A' }} </span></p>
                        </div>

                        <p><i class="bi bi-circle-fill text-muted me-2"></i><strong class="text-muted">Circle:</strong> <span class="text-color fw-bold"> {{ $member->circle->circleName ?? 'N/A' }}</span></p>
                        <div class="{{ $memberCircleId == $userCircleId || ($connection && $connection->status == 'Accepted') ? '' : 'blurred-info' }}">
                            <p><i class="bi bi-building text-muted me-2"></i><strong class="text-muted">Address:</strong> <span class="text-color fw-bold"> {{ $member->billingAddress->bAddressLine1 ?? 'N/A' }}, {{ $member->billingAddress->bAddressLine2 ?? 'N/A' }}, {{ $member->billingAddress->bCity ?? '-' }},
                                    {{ $member->billingAddress->bState ?? '' }},
                                    {{ $member->billingAddress->bPinCode ?? '' }} </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Company -->
                <div class="col-md-4">
                    <div class="card-section h-100">
                        <h6 class="mb-3 company">Company Details</h6>
                        <p><img src="{{ asset('CompanyLogo/' . ($member->companyLogo ?? 'default.jpg')) }}" alt="Logo" class="me-2" style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;"><br><strong class="text-color">{{ $member->companyName ?? 'N/A' }}</strong></p>
                        {{-- <p><strong>Corporate Address:</strong> {{ $member->companyAddress ?? 'N/A' }}</p> --}}
                        <p><i class="bi bi-tag-fill me-2 text-muted"></i><strong class="text-muted">Category:</strong> <span class="text-color fw-bold"> {{ $member->bCategory->categoryName ?? 'N/A' }} </span></p>
                        <p><i class="bi bi-tags-fill me-2 text-muted"></i><strong class="text-muted">Keywords:</strong></p>
                        <div>
                            <div class="keywords-container row">
                                @php
                                    $keyWords = json_decode($member->keyWords ?? '[]', true);
                                @endphp

                                @if (is_array($keyWords) && count($keyWords) > 0)
                                    @foreach ($keyWords as $keyWord)
                                        <span class="keyword-pill col">{{ $keyWord }}</span>
                                    @endforeach
                                @else
                                    {{-- <span class="keyword-pill"></span> --}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="col-md-4">
                    <div class="row g-3 position-relative">
                        <div class="{{ $memberCircleId == $userCircleId || ($connection && $connection->status == 'Accepted') ? '' : 'blurred-info' }}">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-0 text-color fw-bold">{{ $member->totalMeetings ?? 0 }}</h5>
                                        <small class="text-muted">Total Meetings</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-0 text-color fw-bold">₹ {{ $member->businessEarn ?? 0 }}</h5>
                                        <small class="text-muted">Business Amount Earn</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-0 text-color fw-bold">{{ $member->businessGiven ?? 0 }}</h5>
                                        <small class="text-muted">Business Given</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-0 text-color fw-bold">{{ $member->businessReceived ?? 0 }}</h5>
                                        <small class="text-muted">Business Received</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-0 text-color fw-bold">{{ $member->referenceGiven ?? 0 }}</h5>
                                        <small class="text-muted">Reference Given</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card">
                                        <h5 class="mb-0 text-color fw-bold">{{ $member->referenceReceived ?? 0 }}</h5>
                                        <small class="text-muted">Reference Received</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- @if (!($memberCircleId == $userCircleId || ($connection && $connection->status == 'Accepted')))
                            <div style="position: absolute; top: 0; left: 0; background: rgba(255,255,255,0.7); width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; font-weight: bold; z-index: 1;">
                                Connect to view stats
                            </div>
                        @endif --}}
                    </div>
                </div>

            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

        {{-- chat module script start --}}



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


        {{-- chat module script end --}}

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
    @endsection
