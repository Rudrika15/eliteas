@extends('layouts.master')

@section('title', 'UBN - Business Meet')
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

    {{-- file upload style end --}}

    {{-- modal style end --}}


    @php
        $activeTab = request('tab', 'by_me');
    @endphp

    <div class="tab-navigation mb-3" id="ibm-tabs">
        <a href="#" class="tab-btn {{ $activeTab == 'by_me' ? 'active' : '' }}" data-target="#tabByMe">By Me ({{ $circlecall->total() }})</a>
        <a href="#" class="tab-btn {{ $activeTab == 'by_other' ? 'active' : '' }}" data-target="#tabByOther">By Other ({{ $callWith->total() }})</a>
        {{-- <a href="{{ route('circlecall.create') }}" class="float-end btn btn-sm btn-bg-orange">
        <i class="bi bi-plus-circle"></i> Create IBM
    </a> --}}

        @php
            $isCreationLocked = false;
            if (isset($isLocked) && $isLocked && isset($lockedEndDate)) {
                if (now()->lte(\Carbon\Carbon::parse($lockedEndDate))) {
                    $isCreationLocked = true;
                }
            }
        @endphp

        @if (!$isCreationLocked)
            <button type="button" class="float-end btn btn-bg-orange" data-bs-toggle="modal" data-bs-target="#createIBMModal">
                Create IBM
            </button>
        @else
            <button type="button" class="float-end btn btn-secondary" disabled>
                <i class="fas fa-lock"></i> Locked
            </button>
        @endif
    </div>

    <!-- Tab Content: By Me -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">IBM</h4>
                </div>
                <div id="tabByMe" class="tab-content {{ $activeTab == 'by_me' ? 'active' : '' }}">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>IBM With</th>
                                    <th>IBM Place</th>
                                    <th>IBM Image</th>
                                    <th>IBM Date</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($circlecall as $circlecallData)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($circlecallData->meetingPerson)->firstName ?? '-' }} {{ optional($circlecallData->meetingPerson)->lastName ?? '-' }}</td>
                                        <td>{{ $circlecallData->meetingPlace ?? '-' }}</td>
                                        <td>
                                            @if ($circlecallData->meetingImage)
                                                <div class="meeting-image-wrapper" style="position: relative;">
                                                    <img src="{{ url('meetingImage/' . basename($circlecallData->meetingImage)) }}" alt="Meeting Image" style="width: 100px; height: auto; border-radius: 5px;" onclick="openImage(this)">
                                                    <div class="meeting-image-overlay" onclick="closeImage(event)"></div>
                                                </div>
                                            @else
                                                <span></span>
                                            @endif
                                        </td>
                                        <td>{{ $circlecallData->date ? \Carbon\Carbon::parse($circlecallData->date)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $circlecallData->remarks ?? '-' }}</td>
                                        <td>
                                            @php
                                                $isLockedRecord = $lastDate ?? false;
                                            @endphp

                                            @if (!$isLockedRecord)
                                                <a href="{{ route('circlecall.edit', $circlecallData->id) }}" class="btn btn-sm btn-bg-blue" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <a href="{{ route('circlecall.delete', $circlecallData->id) }}" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            @else
                                                <span class="badge bg-secondary"><i class="fas fa-lock"></i> Locked</span>
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3 custom-pagination">
                            {!! $circlecall->appends(['tab' => 'by_me'])->links() !!}
                        </div>
                    </div>
                </div>

                <!-- Tab Content: By Other -->
                <div id="tabByOther" class="tab-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>IBM By</th>
                                    <th>IBM Place</th>
                                    <th>IBM Image</th>
                                    <th>IBM Date</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($callWith as $callWithData)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($callWithData->member)->firstName ?? '-' }} {{ optional($callWithData->member)->lastName ?? '-' }}</td>
                                        <td>{{ $callWithData->meetingPlace ?? '-' }}</td>
                                        <td>
                                            @if ($callWithData->meetingImage)
                                                <div class="meeting-image-wrapper" style="position: relative;">
                                                    <img src="{{ url('meetingImage/' . basename($callWithData->meetingImage)) }}" alt="Meeting Image" style="width: 100px; height: auto; border-radius: 5px;" onclick="openImage(this)">
                                                    <div class="meeting-image-overlay" onclick="closeImage(event)"></div>
                                                </div>
                                            @else
                                                <span></span>
                                            @endif
                                        </td>
                                        <td>{{ $callWithData->date ? \Carbon\Carbon::parse($callWithData->date)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ $callWithData->remarks ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3 custom-pagination">
                            {!! $callWith->appends(request()->query())->appends(['tab' => 'by_other'])->fragment('ibm-tabs')->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- modal for create ibm --}}

    <!-- Trigger Button (Optional) -->


    <!-- Modal -->
    <div class="modal fade right" id="createIBMModal" tabindex="-1" aria-labelledby="createIBMModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-custom">
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light border-bottom-0 rounded-top">
                    <h5 class="modal-title color-blue fw-bold" id="createIBMModalLabel">Create IBM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="circlecallForm" enctype="multipart/form-data" method="post" action="{{ route('circlecall.store') }}">
                        @csrf

                        <div class="card p-3 shadow-sm border-0 rounded">
                            <!-- Circle Dropdown -->
                            {{-- For Member Role --}}
                            {{-- @if (auth()->user()->hasRole('Member'))
                        <!-- Circle Dropdown -->
                        <div class="mb-3">
                            <label for="circleId" class="form-label fw-bold color-blue required">
                                Circle <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('circleId') is-invalid @enderror" id="circleId"
                                name="circleId" required>
                                <option value="" selected disabled>Select Circle</option>
                                <option value="{{ old('circleId', auth()->user()->member->circleId) }}" selected>
                                    {{ $circles->where('id', old('circleId',
                                    auth()->user()->member->circleId))->first()->circleName ?? '' }}
                                </option>
                                @foreach ($circles as $circle)
                                <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                                @endforeach
                            </select>
                            @error('circleId')
                            <div class="invalid-feedback">This field is required.</div>
                            @enderror
                        </div>

                        <!-- Member Dropdown -->
                        <div class="mb-3">
                            <label for="memberId" class="form-label fw-bold color-blue required">
                                Member <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('memberId') is-invalid @enderror" id="memberId"
                                name="memberId" required>
                                <option value="">Select Member</option>
                                @foreach ($circleMember as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
                            @error('memberId')
                            <div class="invalid-feedback">This field is required.</div>
                            @enderror
                        </div>
                        @endif --}}


                            @if (auth()->user()->hasRole('Member'))
                                <!-- Circle Dropdown -->
                                <div class="mb-3">
                                    <label for="circleId" class="form-label fw-bold color-blue required">
                                        Circle <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                        <option value="" selected disabled>Select Circle</option>
                                        @foreach ($circles as $circle)
                                            <option value="{{ $circle->id }}" {{ old('circleId', auth()->user()->member->circleId) == $circle->id ? 'selected' : '' }}>
                                                {{ $circle->circleName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('circleId')
                                        <div class="invalid-feedback">This field is required.</div>
                                    @enderror
                                </div>

                                <!-- Member Dropdown -->
                                <div class="mb-3">
                                    <label for="memberId" class="form-label fw-bold color-blue required">
                                        Member <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                        <option value="" selected disabled>Select Member</option>
                                        @foreach ($circleMember as $member)
                                            <option value="{{ $member->id }}" {{ old('memberId') == $member->id ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('memberId')
                                        <div class="invalid-feedback">This field is required.</div>
                                    @enderror
                                </div>
                            @endif



                            <!-- Meeting Person -->
                            <div class="mb-3">
                                <label for="meetingPersonName" class="form-label fw-bold color-blue required">Meeting Person
                                    Name <span class="text-danger">*</span></label>
                                <input type="hidden" id="meetingPersonId" name="meetingPersonId" required value="{{ old('meetingPersonId') }}">
                                <input type="text" class="form-control @error('meetingPersonId') is-invalid @enderror" id="meetingPersonName" placeholder="Select Member" readonly disabled value="{{ old('meetingPersonName') }}">
                                @error('meetingPersonId')
                                    <div class="invalid-feedback">This field is required.</div>
                                @enderror
                            </div>

                            <!-- Meeting Place -->
                            <div class="mb-3">
                                <label for="meetingPlace" class="form-label fw-bold color-blue required">Meeting Place Name
                                    <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="meetingPlace" name="meetingPlace" placeholder="Enter place" required value="{{ old('meetingPlace') }}">
                            </div>

                            <!-- Meeting Image Upload -->
                            <div class="mb-3">
                                <label class="form-label fw-bold color-blue required">Upload Meeting Image <span class="text-danger">*</span></label>
                                <label for="meetingImage" class="upload-box @error('meetingImage') border-danger @enderror">
                                    <div class="upload-content">
                                        <i class="fas fa-image upload-icon"></i>
                                        <span>Upload Meeting Image</span>
                                    </div>
                                    <input type="file" class="file-input" id="meetingImage" name="meetingImage" accept="image/*" onchange="previewPhoto(event)" required>
                                </label>
                                <span class="text-danger mt-1 d-block">* File size: Max 2MB</span>
                                @error('meetingImage')
                                    <div class="invalid-feedback d-block">The Maximum file size is 2MB</div>
                                @enderror

                                <!-- Image Preview -->
                                <div class="mt-2">
                                    <img id="photoPreview" src="{{ old('meetingImage') ? url('storage/' . old('meetingImage')) : asset('img/profile.png') }}" alt="Preview" style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
                                </div>
                            </div>


                            {{-- @if (auth()->user()->hasRole('Member'))
                        <!-- Date -->
                        <div class="mb-3">
                            <label for="date" class="form-label fw-bold color-blue required">
                                Date <span class="text-danger">*</span>
                            </label>
                            <?php
                            $nearestDate = $scheduleDate->min();
                            $nearestDate = $nearestDate ? \Illuminate\Support\Carbon::parse($nearestDate)->subDay()->format('Y-m-d') : \Illuminate\Support\Carbon::now()->format('Y-m-d');
                            $selectedDate = request()->input('date') ?? (\Illuminate\Support\Carbon::now()->format('Y-m-d') == $nearestDate ? \Illuminate\Support\Carbon::now()->format('Y-m-d') : $nearestDate);
                            ?>
                            <input type="date" class="form-control" id="date" name="date" min="{{ $lastDate }}"
                                max="{{ $nearestDate }}" value="{{ old('date', $selectedDate) }}" required>
                        </div>
                        @endif --}}


                            @if (auth()->user()->hasRole('Member'))
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
                            @endif





                            {{-- @if (auth()->user()->hasRole('Member'))
                        <!-- Date -->
                        <div class="mb-3">
                            <label for="date" class="form-label fw-bold color-blue required">
                                Date <span class="text-danger">*</span>
                            </label>

                            <input type="date" class="form-control" id="date" name="date" value="" required>
                        </div>
                        @endif --}}


                            <!-- Remarks -->
                            <div class="mb-3">
                                <label for="remarks" class="form-label fw-bold color-blue">Remarks <span class="text-danger">*</span> </label>
                                <textarea class="form-control" id="remarks" name="remarks" placeholder="Enter remarks" required>{{ old('remarks') }}</textarea>
                            </div>

                            <!-- Button Row -->
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="cancel-btn" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="create-btn">Create IBM</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit model start --}}

    <div class="modal fade right" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-custom">
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light border-bottom-0 rounded-top">
                    <h5 class="modal-title color-blue fw-bold" id="editModalLabel">Edit IBM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id="editModalBody">
                    <!-- AJAX-loaded form will go here -->
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script>
        $(document).ready(function() {
            $('.open-edit-modal').click(function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const modalBody = $('#editModalBody');

                modalBody.html('<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>');

                $('#editModal').modal('show');

                $.ajax({
                    url: '/circlecall/edit/' + id,
                    type: 'GET',
                    success: function(response) {
                        modalBody.html(response);
                    },
                    error: function(xhr, status, error) {
                        // Log to console
                        console.error("AJAX Error:", {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            errorThrown: error
                        });

                        // Display detailed error in the modal
                        modalBody.html(`
                            <div class="text-danger">
                                <strong>Failed to load form.</strong><br>
                                Status: ${xhr.status} ${xhr.statusText}<br>
                                Error: ${error}<br>
                                Message: ${xhr.responseText}
                            </div>
                        `);
                    }
                });
            });
        });
    </script>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const modal = new bootstrap.Modal('#createIBMModal');
                modal.show();
            });
        </script>
    @endif


    {{-- edit model end --}}


    <!-- JS for Image Preview -->
    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photoPreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }
    </script>



    {{-- modal for create ibm end --}}


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
                                    if (
                                        member.firstName?.toLowerCase().trim() === 'ubn' &&
                                        member.lastName?.toLowerCase().trim() === '-'
                                    ) {
                                        return;
                                    }
                                    $('#memberId').append('<option value="' + member.id +
                                        '" data-user-id="' + member.userId +
                                        '" data-first-name="' + member.firstName +
                                        '" data-last-name="' + member.lastName + '">' +
                                        member.firstName + ' ' + member.lastName +
                                        '</option>');
                                });

                                // Pre-select the authenticated member if exists in the list
                                /*
                                var defaultMemberId =
                                    '{{ auth()->user()->member->id }}'; // Assuming memberId is available
                                if (defaultMemberId) {
                                    $('#memberId').val(defaultMemberId).trigger(
                                        'change'
                                    ); // Set the default selected member and trigger the change event
                                }
                                */
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

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // Update UI immediately
                switchTab(this);
            });
        });

        function switchTab(clickedBtn) {
            // Deactivate all
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

            // Activate current
            clickedBtn.classList.add('active');
            const target = document.querySelector(clickedBtn.getAttribute('data-target'));
            if (target) target.classList.add('active');

            // Update URL
            const tabName = clickedBtn.getAttribute('data-target') === '#tabByOther' ? 'by_other' : 'by_me';
            const url = new URL(window.location);
            url.searchParams.set('tab', tabName);
            window.history.pushState({}, '', url);
        }

        // Initialize tab from URL on page load
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');

            if (activeTab === 'by_other') {
                const tabBtn = document.querySelector('[data-target="#tabByOther"]');
                if (tabBtn) {
                    // We manually trigger the UI switch without pushState (or with it, doesn't matter much on load)
                    // But better to just set classes directly to avoid history pollution if needed,
                    // though reusing switchTab is cleaner.

                    // Deactivate defaults
                    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

                    // Activate desired
                    tabBtn.classList.add('active');
                    const target = document.querySelector(tabBtn.getAttribute('data-target'));
                    if (target) target.classList.add('active');
                }
            }
        });

        function deleteRow(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1d2856',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Circle call has been deleted.',
                        icon: 'success',
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.reload();
                        }
                    })
                }
            })
        }
    </script>

@endsection
