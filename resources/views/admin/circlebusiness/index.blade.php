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
            @php
                $isCreationLocked = false;
                if (isset($isLocked) && $isLocked && isset($lockedEndDate)) {
                    if (now()->lte(\Carbon\Carbon::parse($lockedEndDate))) {
                        $isCreationLocked = true;
                    }
                }
            @endphp

            @if (!$isCreationLocked)
                <a href="javascript:void(0);" class="btn btn-sm btn-bg-orange" data-bs-toggle="modal" data-bs-target="#businessSlipModal">
                    <i class="bi bi-plus-circle"></i> Create Business Slip
                </a>
            @else
                <button class="btn btn-sm btn-secondary" disabled>
                    <i class="fas fa-lock"></i> Locked
                </button>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Business Slips</h4>
                </div>

                <!-- Tab Content: Business Slip Received -->
                <div class="tab-content active" id="tabReceived">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Giver Name</th>
                                    <th>Reference Description</th>
                                    {{-- <th>Profile</th> --}}
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($busGiver as $busGiverData)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($busGiverData->businessGiver)->firstName ?? '-' }} {{ optional($busGiverData->businessGiver)->lastName ?? '-' }}</td>
                                        <td>{{ optional($busGiverData->reference)->description ?? '-' }}</td>
                                        {{-- <td>
                                            <img src="{{ optional($busGiverData->businessGiver)->profilePhoto ? asset('ProfilePhoto/' . $busGiverData->businessGiver->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle" width="50" height="50" alt="Profile">
                                        </td> --}}
                                        <td>{{ \Carbon\Carbon::parse($busGiverData->date)->format('d-m-Y') ?? '-' }}</td>
                                        <td>₹ {{ $busGiverData->amount ?? '-' }}</td>
                                        <td>{{ $busGiverData->remarks ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('busGiver.edit', $busGiverData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                                <i class="bi bi-pen"></i>
                                                <span class="btn-text">Edit</span>
                                            </a>
                                            <a href="{{ route('busGiver.delete', $busGiverData->id) }}" class="btn btn-danger btn-sm btn-tooltip">
                                                <i class="bi bi-trash"></i>
                                                <span class="btn-text">Delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3 custom-pagination">
                        {!! $busGiver->appends(['tab' => 'received'])->links() !!}
                    </div>
                </div>

                <!-- Tab Content: Business Slip Given -->
                <div id="tabGiven" class="tab-content" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Member Name</th>
                                    <th>Reference Description</th>
                                    {{-- <th>Profile</th> --}}
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($busGiveByOther as $busGiveByOtherData)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($busGiveByOtherData->loginMember)->firstName ?? '-' }} {{ optional($busGiveByOtherData->loginMember)->lastName ?? '-' }}</td>
                                        <td>{{ optional($busGiveByOtherData->reference)->description ?? '-' }}</td>
                                        {{-- <td>
                                            <img src="{{ optional($busGiveByOtherData->loginMember)->profilePhoto ? asset('ProfilePhoto/' . $busGiveByOtherData->loginMember->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle" width="50" height="50" alt="Profile">
                                        </td> --}}
                                        <td>{{ \Carbon\Carbon::parse($busGiveByOtherData->date)->format('d-m-Y') ?? '-' }}</td>
                                        <td>₹ {{ $busGiveByOtherData->amount ?? '-' }}</td>
                                        <td>{{ $busGiveByOtherData->remarks ?? '-' }}</td>
                                        {{-- <td>
                                            <a href="{{ route('refGiver.edit', $busGiveByOtherData->id) }}" class="btn btn-sm btn-bg-blue">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3 custom-pagination">
                        {!! $busGiveByOther->appends(['tab' => 'given'])->links() !!}
                    </div>
                </div>
            </div>
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
                    <form class="needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="post" action="{{ route('busGiver.store') }}" novalidate>
                        {{-- action="{{ route('refGiver.refByOtherStore') }}" --}}
                        @csrf
                        <!-- Circle and Member Selection -->
                        <div class="card p-3 shadow-sm border-0 rounded">
                            @if (auth()->user()->hasRole(['Member', 'Digital Member']))
                                <div class="mb-3">
                                    <label for="circleId" class="form-label fw-bold color-blue required">Circle <span class="text-danger">*</span></label>
                                    <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                        <option value="" selected disabled>Select Circle</option>
                                        <option value="all">All Members (Circle + Digital)</option>
                                        <option value="digital">Digital Members</option>
                                        @foreach ($circles as $circle)
                                            <option value="{{ $circle->id }}" {{ old('circleId', auth()->user()->member?->circleId) == $circle->id ? 'selected' : '' }}>
                                                {{ $circle->circleName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- <label for="circleId">Circle</label> --}}
                                    @error('circleId')
                                        <div class="invalid-tooltip">This field is required.</div>
                                    @enderror
                                </div>
                            @endif
                            {{-- @if (auth()->user()->hasRole('Member'))
                                <div class="mb-3">
                                    <label for="circleId" class="form-label fw-bold color-blue required">
                                        Circle <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                        <option value="" selected disabled>Select Circle</option>
                                        @foreach ($circles as $circle)
                                            <option value="{{ $circle->id }}" {{ old('circleId') == $circle->id ? 'selected' : '' }}>
                                                {{ $circle->circleName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('circleId')
                                        <div class="invalid-tooltip">This field is required.</div>
                                    @enderror
                                </div>
                            @endif --}}


                            <div class="mb-3" id="memberListDropdown">
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
                                <input type="text" class="form-control" id="meetingPersonName" name="memberName" placeholder="Select Member" readonly>
                                <input type="hidden" id="meetingPersonId" name="meetingPersonId">
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


                            <!-- Date -->
                            <div class="mb-3">
                                <label for="date" class="form-label fw-bold color-blue required">
                                    Date <span class="text-danger">*</span>
                                </label>
                                <?php
                                // Calculate allowed range
                                $today = \Illuminate\Support\Carbon::today()->format('Y-m-d');
                                // $pastLimit = \Illuminate\Support\Carbon::today()->format('Y-m-d');
                                
                                if (isset($isLocked) && $isLocked && isset($lockedEndDate)) {
                                    $lockedEnd = \Illuminate\Support\Carbon::parse($lockedEndDate);
                                    // If locked, start from the day AFTER the lock ends
                                    $minDate = $lockedEnd->addDay()->format('Y-m-d');
                                    // Ensure we don't go back further than 15 days anyway (though lock usually covers it)
                                    $pastLimit = $minDate > $pastLimit ? $minDate : $pastLimit;
                                }
                                
                                // Default selected date
                                $selectedDate = old('date', request()->input('date') ?? $today);
                                ?>
                                <input type="date" class="form-control" id="date" name="date" min="{{ $allowedStartDate }}" max="{{ $today }}" value="{{ $selectedDate }}" required>
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

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="createReference" name="create_reference" value="1">
                                <label class="form-check-label fw-bold" for="createReference">
                                    Also create Reference
                                </label>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Check for tab parameter in URL
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');

            if (activeTab === 'given') {
                const givenTabBtn = document.querySelector('.tab-btn[data-tab="tabGiven"]');
                if (givenTabBtn) givenTabBtn.click();
            } else if (activeTab === 'received') {
                const receivedTabBtn = document.querySelector('.tab-btn[data-tab="tabReceived"]');
                if (receivedTabBtn) receivedTabBtn.click();
            }
        });

        document.querySelectorAll('.tab-btn').forEach(function(tabBtn) {
            tabBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

                // Hide all tab contents
                document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');

                // Activate clicked tab
                this.classList.add('active');
                const targetTab = this.getAttribute('data-tab');
                document.getElementById(targetTab).style.display = 'block';
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var scaleInput = document.getElementById("scale");
            var scaleOutput = document.getElementById("scaleOutput");

            // Guard against missing elements to avoid runtime errors
            if (scaleInput && scaleOutput) {
                scaleInput.addEventListener("input", function() {
                    scaleOutput.textContent = scaleInput.value;
                });
            }
        });
    </script>



    <script type="text/javascript">
        // Select2 member search was removed. Member selection is handled by the #memberId dropdown
        // populated via Circle/City AJAX. This block intentionally left blank to avoid errors from
        // referencing a non-existent #search element.
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
                $('#memberId').empty().append('<option value="" selected disabled>Select Member</option>');

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
                                    let fullName = '';

                                    if (member.firstName === 'UBN') {
                                        fullName = 'UBN';
                                    } else {
                                        fullName = (member.firstName || '') + ' ' + (member.lastName || '');
                                        fullName = fullName.trim();
                                    }
                                    $('#memberId').append('<option value="' + member.userId +
                                        '" data-user-id="' + member.userId +
                                        '" data-first-name="' + member.firstName +
                                        '" data-last-name="' + member.lastName + '">' +
                                        member.firstName + ' ' + member.lastName +
                                        '</option>');
                                });
                            }
                        },
                        error: function(xhr) {
                            $('#memberId').append('<option value="">Error loading members</option>');
                        }
                    });
                }
            }

            // Load members on page load if a circle is selected by default
            var defaultCircleId = '{{ auth()->user()->member?->circleId ?? "digital" }}';
            if (defaultCircleId) {
                loadMembers(defaultCircleId);
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
