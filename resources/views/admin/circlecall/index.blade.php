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


    <div class="tab-navigation mb-3">
        <a href="#" class="tab-btn active" data-target="#tabByMe">By Me ({{ $circlecall->total() }})</a>
        <a href="#" class="tab-btn" data-target="#tabByOther">By Other ({{ $callWith->total() }})</a>
        {{-- <a href="{{ route('circlecall.create') }}" class="float-end btn btn-sm btn-bg-orange">
            <i class="bi bi-plus-circle"></i> Create IBM
        </a> --}}

        <button type="button" class="float-end btn btn-bg-orange" data-bs-toggle="modal" data-bs-target="#createIBMModal">
            Create IBM
        </button>
    </div>

    <!-- Tab Content: By Me -->
    <div id="tabByMe" class="tab-content active">
        <div class="row">
            @foreach ($circlecall as $circlecallData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            {{-- <img src="https://picsum.photos/700/200?random={{ rand(1, 1000) }}" class="card-img-top" alt="cover"> --}}
                            <img src="{{ asset('img/header_img.jpeg') }}" class="card-img-top" alt="cover">

                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ $circlecallData->meetingPerson->profilePhoto ? asset('ProfilePhoto/' . $circlecallData->meetingPerson->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                                {{-- <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 12px; transform: translate(25%, 25%);">G</div> --}}
                            </div>
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <a href="#" class="text-black" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item color-blue" href="{{ route('circlecall.edit', $circlecallData->id) }}" data-id="{{ $circlecallData->id }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit
                                        </a>
                                    </li>

                                    <li><a class="dropdown-item text-danger" onclick="deleteRow('{{ route('circlecall.delete', $circlecallData->id) }}')"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            <h5 class="card-title mb-0">{{ $circlecallData->meetingPerson->firstName ?? '-' }} {{ $circlecallData->meetingPerson->lastName ?? '-' }}</h5>
                            {{-- <p class="text-muted small">Vice President at UBN</p> --}}
                            <div class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1"></i>{{ $circlecallData->meetingPerson->circle->circleName ?? '-' }}
                                <span class="me-4"> </span>
                                <i class="bi bi-calendar3 me-1"></i>{{ $circlecallData->date ? date('d-m-Y', strtotime($circlecallData->date)) : '-' }}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $circlecallData->meetingPlace ?? '-' }}
                            </div>
                            <div class="card-remark text-muted small mb-2">{{ Str::limit($circlecallData->remarks ?? '', 25) }}{{ strlen($circlecallData->remarks ?? '') > 25 ? '...' : '' }}</div>
                            @if ($circlecallData->meetingImage)
                                <a href="{{ url('meetingImage/' . basename($circlecallData->meetingImage)) }}" target="_blank" class="d-block text-decoration-none text-primary small mb-2">
                                    <i class="bi bi-image"></i> View Uploaded Meeting Image
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tab Content: By Other -->
    <div id="tabByOther" class="tab-content">
        <div class="row">
            @foreach ($callWith as $callWithData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="{{ asset('img/header_img.jpeg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ $callWithData->member->profilePhoto ? asset('ProfilePhoto/' . $callWithData->member->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                                {{-- <div class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 12px; transform: translate(25%, 25%);">G</div> --}}
                            </div>
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            <h5 class="card-title mb-0">{{ $callWithData->member->firstName ?? '-' }} {{ $callWithData->member->lastName ?? '-' }}</h5>
                            <p class="text-muted small">Vice President at UBN</p>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $callWithData->meetingPlace ?? '-' }}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i>{{ $callWithData->date ? date('d-m-Y', strtotime($callWithData->date)) : '-' }}
                            </div>
                            <div class="card-remark text-muted small mb-2">{{ Str::limit($callWithData->remarks ?? '', 25) }}{{ strlen($callWithData->remarks ?? '') > 25 ? '...' : '' }}</div>
                            @if ($callWithData->meetingImage)
                                <a href="{{ url('meetingImage/' . basename($callWithData->meetingImage)) }}" target="_blank" class="d-block text-decoration-none text-primary small mb-2">
                                    <i class="bi bi-image"></i> View Uploaded Meeting Image
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    {{-- modal for create ibm  --}}

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
                            @if (auth()->user()->hasRole('Member'))
                                <!-- Circle Dropdown -->
                                <div class="mb-3">
                                    <label for="circleId" class="form-label fw-bold color-blue required">
                                        Circle <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                        <option value="" selected disabled>Select Circle</option>
                                        <option value="{{ old('circleId', auth()->user()->member->circleId) }}" selected>
                                            {{ $circles->where('id', old('circleId', auth()->user()->member->circleId))->first()->circleName ?? '' }}
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
                                    <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                        <option value="">Select Member</option>
                                        @foreach ($circleMember as $member)
                                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('memberId')
                                        <div class="invalid-feedback">This field is required.</div>
                                    @enderror
                                </div>
                            @endif


                            {{-- For Digital Member Role --}}
                            @if (auth()->user()->hasRole('Digital Member'))
                                <!-- City Dropdown -->
                                <div class="mb-3">
                                    <label for="city" class="form-label fw-bold color-blue required">
                                        City <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="city" name="city" required>
                                        <option value="">Select City</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->cityName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Member Dropdown -->
                                <div class="mb-3">
                                    <label for="memberId" class="form-label fw-bold color-blue required">
                                        Member <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="memberId" name="memberId" required>
                                        <option value="">Select Member</option>
                                    </select>
                                </div>
                            @endif

                            <!-- Meeting Person -->
                            <div class="mb-3">
                                <label for="meetingPersonName" class="form-label fw-bold color-blue required">Meeting Person Name <span class="text-danger">*</span></label>
                                <input type="hidden" id="meetingPersonId" name="meetingPersonId" required value="{{ old('meetingPersonId') }}">
                                <input type="text" class="form-control @error('meetingPersonId') is-invalid @enderror" id="meetingPersonName" placeholder="Select Member" readonly disabled value="{{ old('meetingPersonName') }}">
                                @error('meetingPersonId')
                                    <div class="invalid-feedback">This field is required.</div>
                                @enderror
                            </div>

                            <!-- Meeting Place -->
                            <div class="mb-3">
                                <label for="meetingPlace" class="form-label fw-bold color-blue required">Meeting Place Name <span class="text-danger">*</span></label>
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


                            @if (auth()->user()->hasRole('Member'))
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
                                    <input type="date" class="form-control" id="date" name="date" min="{{ $lastDate }}" max="{{ $nearestDate }}" value="{{ old('date', $selectedDate) }}" required>
                                </div>
                            @endif

                            @if (auth()->user()->hasRole('Digital Member'))
                                <!-- Date -->
                                <div class="mb-3">
                                    <label for="date" class="form-label fw-bold color-blue required">
                                        Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" class="form-control" id="date" name="date" value="" required>
                                </div>
                            @endif


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

    {{-- edit model start  --}}

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



    {{-- edit model end  --}}


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
                $('#memberId').empty().append('<option value="">Select Member</option>');

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

    @if (auth()->user()->hasRole('Digital Member'))
        {{-- script for digital member --}}
        <script>
            $(document).ready(function() {
                console.log("✅ Document Ready");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function loadMembers(cityId) {
                    console.log("🏙️ loadMembers() called with cityId:", cityId);

                    $('#memberId').empty().append('<option value="">Select Member</option>');

                    if (cityId) {
                        let url = '/get-members-by-city/' + cityId;
                        console.log("🚀 Sending AJAX to:", url);

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                console.log("✅ Response received:", response);
                                console.log("🔢 Member count:", response?.length ?? 0);

                                if (response && response.length > 0) {
                                    response.forEach(function(member, index) {
                                        console.log(`👤 Member [${index}]:`, member);
                                        $('#memberId').append(
                                            `<option value="${member.id}" 
                                        data-user-id="${member.userId}" 
                                        data-first-name="${member.firstName ?? ''}" 
                                        data-last-name="${member.lastName ?? ''}">
                                        ${(member.firstName ?? '')} ${(member.lastName ?? '')}
                                    </option>`
                                        );
                                    });
                                } else {
                                    console.warn("⚠️ No members found for cityId:", cityId);
                                    $('#memberId').append('<option value="">No Members Found</option>');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("❌ AJAX Error:", {
                                    status,
                                    error,
                                    responseText: xhr.responseText
                                });
                                $('#memberId').append('<option value="">Error loading members</option>');
                            }
                        });
                    } else {
                        console.warn("⚠️ No cityId provided");
                    }
                }

                var defaultCityId = '{{ auth()->user()->member->city_id ?? '' }}';

                if (defaultCityId) {
                    loadMembers(defaultCityId);
                }

                $('#city').on('change', function() {
                    var cityId = $(this).val();
                    console.log("🏙️ City changed:", cityId);
                    loadMembers(cityId);
                });

                $('#memberId').on('change', function() {
                    var selected = $(this).find('option:selected');
                    var memberId = selected.val();
                    var userId = selected.data('user-id');
                    var firstName = selected.data('first-name');
                    var lastName = selected.data('last-name');

                    console.log("👤 Member ID changed:", memberId);
                    console.log("👤 Member User ID:", userId);
                    console.log("👤 Member Name:", firstName + ' ' + lastName);


                    if (memberId) {
                        $('#meetingPersonId').val(userId);
                        $('#meetingPersonName').val(firstName + ' ' + lastName);
                    } else {
                        $('#meetingPersonId').val('');
                        $('#meetingPersonName').val('');
                    }
                });
            });
        </script>
    @endif



    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                const target = document.querySelector(this.getAttribute('data-target'));
                target.classList.add('active');
            });
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
