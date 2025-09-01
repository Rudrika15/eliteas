@extends('layouts.master')

@section('title', 'UBN - Business Slip')
@section('content')



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>
        .tab-navigation {
            border-bottom: 2px solid #eaeaea;
            margin-bottom: 1rem;
        }

        .tab-navigation a {
            padding: 10px 20px;
            display: inline-block;
            text-decoration: none;
            font-weight: 600;
            color: #333;
        }

        .tab-navigation a.active {
            color: #ff6600;
            border-bottom: 3px solid #ff6600;
        }

        .profile-badge {
            position: absolute;
            top: 65%;
            left: 58%;
            transform: translate(-50%, -50%);
            background: #ffcc00;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .card-remark {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 10px;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 10px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>

    {{-- modal style start --}}
    <style>
        /* Slide-in modal from the right */
        .modal.right .modal-dialog {
            position: fixed;
            right: 0;
            margin: 0;
            height: 100%;
            max-width: 500px;
            /* Adjust width */
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        }

        .modal.right .modal-content {
            height: 100%;
            overflow-y: auto;
            border-radius: 0;
        }

        .modal.right.show .modal-dialog {
            transform: translateX(0);
        }

        .modal-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            /* Optional max width */
            margin: auto;
        }

        .button-row {
            display: flex;
            margin-top: 20px;
        }

        .cancel-btn,
        .create-btn {
            flex: 1;
            height: 40px;
            font-weight: 500;
            border-radius: 4px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .cancel-btn {
            background-color: #fff;
            border: 1px solid #223366;
            color: #223366;
            margin-right: 10px;
        }

        .cancel-btn:hover {
            background-color: #f0f0f0;
        }

        .create-btn {
            background: linear-gradient(to right, #223366, #E06836);
            color: white;
            border: none;
        }

        .create-btn:hover {
            opacity: 0.9;
        }

        .modal-lg-custom {
            max-width: 900px;
            /* or any width you prefer */
            width: 90%;
        }
    </style>

    {{-- file upload style start --}}

    <style>
        .upload-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #223366;
        }

        .upload-box {
            border: 2px dashed #ccc;
            border-radius: 8px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            text-align: center;
            transition: border-color 0.3s ease;
            width: 100%;
            position: relative;
            background-color: #fff;
        }

        .upload-box:hover {
            border-color: #223366;
        }

        .upload-content {
            color: #888;
            font-size: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .upload-icon {
            font-size: 24px;
            margin-bottom: 6px;
            color: #888;
        }

        /* Hide actual input */
        .file-input {
            display: none;
        }
    </style>

    <!-- Tab Navigation -->
    <div class="tab-navigation mb-4 d-flex justify-content-between align-items-center">
        <div>
            <a href="#" class="tab-btn active" data-tab="tabReceived">Business Slip Received ({{ $busGiver->total() }})</a>
            <a href="#" class="tab-btn" data-tab="tabGiven">Business Slip Given ({{ $busGiveByOther->total() }})</a>
        </div>
        <div>
            <a href="javascript:void(0);" class="btn btn-sm btn-bg-orange" data-bs-toggle="modal" data-bs-target="#businessSlipModal">
                <i class="bi bi-plus-circle"></i> Create Business Slip
            </a>
        </div>
    </div>


    <!-- Tab Content: Business Slip Received -->
    <div class="tab-content active mt-3" id="tabReceived">
        <div class="row">
            @foreach ($busGiver as $busGiverData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            {{-- <img src="https://picsum.photos/700/200?random={{ rand(1, 1000) }}" class="card-img-top" alt="cover"> --}}
                            <img src="{{ asset('img/header_img.jpeg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ optional($busGiverData->businessGiver)->profilePhoto ? asset('ProfilePhoto/' . $busGiverData->businessGiver->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                            </div>
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            <h5 class="card-title mb-0">
                                {{ optional($busGiverData->businessGiver)->firstName ?? '-' }} {{ optional($busGiverData->businessGiver)->lastName ?? '-' }}
                            </h5>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($busGiverData->date)->format('d-m-Y') ?? '-' }}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-cash-coin me-1"></i> ₹ {{ $busGiverData->amount ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end mt-3 custom-pagination">
            {!! $busGiver->links() !!}
        </div>
    </div>

    <!-- Tab Content: Business Slip Given -->
    <div id="tabGiven" class="tab-content mt-3" style="display: none;">
        <div class="row">
            @foreach ($busGiveByOther as $busGiveByOtherData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            {{-- <img src="https://picsum.photos/700/200?random={{ rand(1, 1000) }}" class="card-img-top" alt="cover"> --}}
                            <img src="{{ asset('img/header_img.jpeg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ optional($busGiveByOtherData->loginMember)->profilePhoto ? asset('ProfilePhoto/' . $busGiveByOtherData->loginMember->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                            </div>
                        </div>
                        
                        <div class="card-body text-center pt-5 mt-3">
                            <h5 class="card-title mb-0">
                                {{ optional($busGiveByOtherData->loginMember)->firstName ?? '-' }} {{ optional($busGiveByOtherData->loginMember)->lastName ?? '-' }}
                            </h5>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($busGiveByOtherData->date)->format('d-m-Y') ?? '-' }}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-cash-coin me-1"></i> ₹ {{ $busGiveByOtherData->amount ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-end mt-3 custom-pagination">
            {!! $busGiveByOther->links() !!}
        </div>
    </div>



    {{-- business create moudule start --}}
    <!-- Modal -->
    <div class="modal fade right" id="businessSlipModal" tabindex="-1" aria-labelledby="businessSlipModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="width: 800px;">
                    <h4 class="modal-title" id="businessSlipModalLabel">Business Slip</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="post" action="{{ route('refGiver.refByOtherStore') }}" novalidate>
                        @csrf

                        <!-- Circle and Member Selection -->
                        <div class="card p-3 shadow-sm border-0 rounded">
                            <div class="mb-3">
                                <label for="circleId" class="form-label fw-bold color-blue required">Circle <span class="text-danger">*</span></label>
                                <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                    <option value="" selected disabled>Select Circle</option>
                                    <option value="{{ old('circleId', auth()->user()->member->circleId) }}" selected>
                                        {{ $circles->where('id', old('circleId', auth()->user()->member->circleId))->first()->circleName ?? '' }}
                                    </option>
                                    @foreach ($circles as $circle)
                                        <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                                    @endforeach
                                </select>
                                {{-- <label for="circleId">Circle</label> --}}
                                @error('circleId')
                                    <div class="invalid-tooltip">This field is required.</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="memberId" class="form-label fw-bold color-blue required">Member <span class="text-danger">*</span></label>
                                <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                    <option value="" selected disabled>Select Member</option>
                                </select>
                                {{-- <label for="memberId">Member</label> --}}
                                @error('memberId')
                                    <div class="invalid-tooltip">This field is required.</div>
                                @enderror
                            </div>


                            <!-- Member Name Display -->
                            <div class="mb-3">
                                <label for="memberName" class="form-label fw-bold color-blue">Member Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="meetingPersonName" name="memberName" placeholder="Select Member" readonly disabled>
                                <input type="hidden" id="meetingPersonId" name="memberId">
                            </div>

                            <!-- Remarks and Amount -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label fw-bold color-blue">Remarks</label>
                                <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" placeholder="Remarks">
                                @error('remarks')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label fw-bold color-blue">Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Amount" required>
                                @error('amount')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Person Section (Hidden initially) -->
                            <div id="memberListInput" style="display:none;">
                                <h5 class="text-blue">Contact Person Details</h5>

                                <div class="form-floating mb-3 mt-3">
                                    <input type="text" class="form-control @error('contactName') is-invalid @enderror" name="contactNameExternal" placeholder="Contact Name">
                                    <label for="contactName">Contact Person Name</label>
                                    @error('contactName')
                                        <div class="invalid-tooltip">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="contactPersonContact" name="contactNo" placeholder="Contact No" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    <label for="contactNo">Contact No</label>
                                    @error('contactNo')
                                        <div class="invalid-tooltip">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="contactPersonEmail" name="email" placeholder="Email">
                                    <label for="email">Email</label>
                                    @error('email')
                                        <div class="invalid-tooltip">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="create-btn">Create Business Slip</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Tab Toggle Script -->
    <script>
        document.querySelectorAll('.tab-btn').forEach(function(tabBtn) {
            tabBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');

                // Add active class to clicked tab
                tabBtn.classList.add('active');

                // Show the selected tab content
                const tabId = tabBtn.getAttribute('data-tab');
                document.getElementById(tabId).style.display = 'block';
            });
        });
    </script>

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




@endsection
