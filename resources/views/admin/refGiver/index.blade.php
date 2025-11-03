@extends('layouts.master')

@section('title', 'UBN - Referance')
@section('content')

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


    <div class="tab-navigation mb-3">
        <a href="#" class="tab-btn active" data-target="#tabByMe">Received ({{ $busGiver->count() }})</a>
        <a href="#" class="tab-btn" data-target="#tabByOther">Given ({{ $refGiver->count() }})</a>
        {{-- <a href="{{ route('circlecall.create') }}" class="float-end btn btn-sm btn-bg-orange">
        <i class="bi bi-plus-circle"></i> Create IBM
    </a> --}}

        <button type="button" class="float-end btn btn-bg-orange" data-bs-toggle="modal" data-bs-target="#createIBMModal">
            Create Reference
        </button>
    </div>



    <div id="tabByMe" class="tab-content active" style="display: block;">
        <div class="row">
            @foreach ($busGiver as $busGiverData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            {{-- <img src="https://picsum.photos/700/200?random={{ rand(1, 1000) }}" class="card-img-top" alt="cover"> --}}
                            <img src="{{ asset('img/header_img.jpeg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ optional($busGiverData->businessGiverMember)->profilePhoto ? asset('ProfilePhoto/' . $busGiverData->businessGiverMember->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                            </div>
                            {{-- <div class="dropdown position-absolute top-0 end-0 m-2">
                                <a href="#" class="text-black" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item color-blue" href="{{ route('circlecall.edit', $busGiverData->id) }}"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item text-danger" onclick="deleteRow('{{ route('circlecall.delete', $busGiverData->id) }}')"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            {{-- Meeting Person Name --}}
                            <h5 class="card-title mb-0">
                                {{ $busGiverData->businessGiver->firstName ?? '-' }} {{ $busGiverData->businessGiver->lastName ?? '-' }}
                            </h5>

                            {{-- Circle Name and Date --}}
                            <div class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1 color-blue"></i> <span class="color-blue"> {{ $busGiverData->businessGiverMember->circle->circleName ?? '-' }} </span>
                                <span class="me-4"></span>
                                <i class="bi bi-calendar3 me-1 color-blue"></i> <span class="color-blue">{{ $busGiverData->date ? date('d-m-Y', strtotime($busGiverData->date)) : '-' }} </span>
                            </div>

                            {{-- Amount --}}
                            <div class="text-muted small mb-2">
                                <strong class="color-blue"> ₹ {{ $busGiverData->amount ?? '-' }} </strong>
                            </div>

                            {{-- Remarks --}}
                            <div class="card-remark text-muted small mb-2">
                                <span class="color-blue">{{ Str::limit($busGiverData->remarks ?? '', 25) }}{{ strlen($busGiverData->remarks ?? '') > 25 ? '...' : '' }} </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <div id="tabByOther" class="tab-content active" style="display: none;">
        <div class="d-flex justify-content-end align-items-center mb-2">
            {{-- <a href="{{ route('refGiver.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                <i class="bi bi-plus-circle"></i>
                <span class="btn-text">Add Reference Details</span>
            </a> --}}
        </div>
        <div class="row mt-4">
            @foreach ($refGiver as $refGiverData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="{{ asset('img/header_img.jpeg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ optional($refGiverData->members)->profilePhoto ? asset('ProfilePhoto/' . $refGiverData->members->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                            </div>
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <a href="#" class="text-black" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item color-blue" href="{{ route('refGiver.edit', $refGiverData->id) }}">
                                            <i class="bi bi-pencil-square me-2"></i>Edit
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete('{{ route('refGiver.delete', $refGiverData->id) }}')">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            {{-- Referred Person Name --}}
                            <h5 class="card-title mb-0">{{ $refGiverData->members->firstName ?? '-' }} {{ $refGiverData->members->lastName ?? '-' }} </h5>

                            {{-- Member Name & Date --}}
                            <div class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1 color-blue"></i>
                                <span class="color-blue">
                                    {{ $refGiverData->members->circle->circleName ?? '-' }}
                                </span>
                                <span class="me-4"></span>
                                <i class="bi bi-calendar3 me-1 color-blue"></i>
                                <span class="color-blue">
                                    {{ \Carbon\Carbon::parse($refGiverData->created_at)->format('d-m-Y') ?? '-' }}
                                </span>
                            </div>

                            {{-- Contact & Email
                                    <div class="text-muted small mb-2">
                                        <div><strong class="color-blue">📞 {{ $refGiverData->contactNo ?? ($refGiverData->members->user->contactNo ?? '-') }}</strong></div>
                                        <div><strong class="color-blue">✉️ {{ $refGiverData->email ?? ($refGiverData->members->user->email ?? '-') }}</strong></div>
                                    </div> --}}

                            {{-- Scale & Status --}}
                            <div class="text-muted small mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $refGiverData->scale >= $i ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>


                @include('admin.refGiver.edit_form', ['refGiver' => $refGiver]) {{-- if you're using partials --}}
            @endforeach
        </div>

        {{-- Pagination --}}
        {{-- <div class="d-flex justify-content-end custom-pagination">
            {!! $refGiver->links() !!}
        </div> --}}
    </div>

    <!-- Modal -->
    <div class="modal fade right" id="createIBMModal" tabindex="-1" aria-labelledby="createIBMModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg-custom">
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light border-bottom-0 rounded-top">
                    <h5 class="modal-title color-blue fw-bold" id="createIBMModalLabel">Circle Meeting Member Reference</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">


                    <!-- Circle & Member Dropdowns -->
                    <form class="m-3 needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="POST" action="{{ route('refGiver.store') }}" novalidate>
                        @csrf

                        <div class="card p-3 shadow-sm border-0 rounded">
                            <div class="row mb-3">
                                <!-- Internal / External Radio -->
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="group" id="internal" value="internal" checked>
                                        <label class="form-check-label" for="internal">Internal</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="group" id="external" value="external">
                                        <label class="form-check-label" for="external">External</label>
                                    </div>
                                </div>
                            </div>

                            @if (auth()->user()->hasRole('Member'))
                                <!-- Circle Dropdown -->
                                <div class="mb-3">
                                    <div class="col-md-12">
                                        <label for="circleId" class="form-label fw-bold color-blue required">Circle <span class="text-danger">*</span></label>
                                        {{-- <div class="form-floating"> --}}
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
                                            <div class="invalid-tooltip">This field is required.</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Member Dropdown -->
                                <div class="col-md-12">
                                    <label for="memberId" class="form-label fw-bold color-blue required">Member <span class="text-danger">*</span></label>
                                    {{-- <div class="form-floating"> --}}
                                    <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                        <option value="" disabled>Select Member</option>
                                    </select>
                                    @error('memberId')
                                        <div class="invalid-tooltip">This field is required.</div>
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


                            <!-- Member Name (readonly) -->
                            <input type="hidden" id="meetingPersonId" name="memberId">
                            <div class="mt-3">
                                <label for="meetingPersonName" class="form-label fw-bold color-blue required">Member Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="meetingPersonName" name="memberName" placeholder="Select Member" readonly disabled>
                                @error('memberId')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- External Contact Person Fields -->
                            <div id="memberListInput" style="display:none;">
                                <h4 class="mt-3 text-blue">Contact Person Details</h4>

                                <div class="mt-3">
                                    <label for="contactName" class="form-label fw-bold color-blue">Contact Person Name</label>
                                    <input type="text" class="form-control @error('contactName') is-invalid @enderror" name="contactNameExternal" placeholder="Contact Name">
                                    @error('contactName')
                                        <div class="invalid-tooltip">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label for="contactNo" class="form-label fw-bold color-blue">Contact No</label>
                                    <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="contactPersonContact" name="contactNo" placeholder="Contact No" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    @error('contactNo')
                                        <div class="invalid-tooltip">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <label for="email" class="form-label fw-bold color-blue">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="contactPersonEmail" name="email" placeholder="Email">
                                    @error('email')
                                        <div class="invalid-tooltip">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mt-3">
                                <label for="description" class="form-label fw-bold color-blue">Description</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">
                                @error('description')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Scale -->
                            <div class="mt-4">
                                <label for="scale" class="form-label fw-bold color-blue">Scale [1-5] </label>
                                <input type="range" class="form-range @error('scale') is-invalid @enderror" id="scale" name="scale" min="1" max="5" step="1" required>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    @foreach (range(1, 5) as $num)
                                        <span class="badge btn-bg-blue rounded-pill">{{ $num }}</span>
                                    @endforeach
                                </div>
                                @error('scale')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="reset" class="cancel-btn">Reset</button>
                                <button type="submit" class="create-btn">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const internalRadio = document.getElementById('internal');
            const externalRadio = document.getElementById('external');
            const externalFields = document.getElementById('memberListInput');

            function toggleFields() {
                if (externalRadio.checked) {
                    externalFields.style.display = 'block';
                } else {
                    externalFields.style.display = 'none';
                }
            }

            internalRadio.addEventListener('change', toggleFields);
            externalRadio.addEventListener('change', toggleFields);
            toggleFields(); // Initial state on page load
        });
    </script>



    {{-- <script>
        $(document).ready(function() {
            $('#deleteRefGiver{{ $refGiverData->id }}').click(function(e) {
                e.preventDefault();
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
                        window.location.href = $(this).attr('href');
                    }
                });
            });
        });
    </script> --}}


    <script>
        $(document).ready(function() {
            $('.tab-btn').click(function(e) {
                e.preventDefault();

                // Remove active class from all buttons and hide all content
                $('.tab-btn').removeClass('active');
                $('.tab-content').hide();

                // Add active class to clicked tab
                $(this).addClass('active');

                // Show target tab content
                let target = $(this).data('target');
                $(target).show();
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


    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Function to load members for a selected city
            function loadMembersByCity(cityId) {
                // Clear the member dropdown
                $('#memberId').empty().append('<option value="" disabled>Select Member</option>');

                if (cityId) {
                    $.ajax({
                        url: '/get-members-by-city/' + cityId,
                        method: 'GET',
                        data: {
                            cityId: cityId
                        },
                        success: function(response) {
                            // Controller returns a plain array of members. Support both formats.
                            var members = Array.isArray(response) ? response : (response.members || []);

                            if (members.length > 0) {
                                members.forEach(function(member) {
                                    $('#memberId').append(
                                        '<option value="' + member.id +
                                        '" data-user-id="' + (member.userId || member.id) +
                                        '" data-first-name="' + (member.firstName || '') +
                                        '" data-last-name="' + (member.lastName || '') + '">' +
                                        ((member.firstName || '') + ' ' + (member.lastName || '')).trim() +
                                        '</option>'
                                    );
                                });

                                // Pre-select the authenticated member if exists in the list
                                var defaultMemberId = '{{ auth()->user()->member->id ?? '' }}';
                                if (defaultMemberId) {
                                    $('#memberId').val(defaultMemberId).trigger('change');
                                }
                            } else {
                                $('#memberId').append('<option value="">No Members Found</option>');
                            }
                        },
                        error: function() {
                            $('#memberId').append('<option value="">Error loading members</option>');
                        }
                    });
                }
            }

            // Load members on page load if a city is selected by default
            var defaultCityId = '{{ auth()->user()->member->cityId ?? '' }}';
            if (defaultCityId) {
                loadMembersByCity(defaultCityId);
            }

            // Handle city dropdown change event
            $('#city').on('change', function() {
                var cityId = $(this).val();
                loadMembersByCity(cityId);
            });

            // Handle member dropdown change event
            $('#memberId').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var memberId = selectedOption.val();
                var userId = selectedOption.data('user-id');
                var firstName = selectedOption.data('first-name');
                var lastName = selectedOption.data('last-name');

                if (memberId) {
                    $('#meetingPersonId').val(userId);
                    $('#meetingPersonName').val((firstName || '') + ' ' + (lastName || ''));
                } else {
                    $('#meetingPersonId').val('');
                    $('#meetingPersonName').val('');
                }

                console.log('Selected Member ID:', memberId);
                console.log('Selected Member User ID:', userId);
                console.log('Selected Member Name:', (firstName || '') + ' ' + (lastName || ''));
            });
        });
    </script>




    {{-- //ref by other --}}


@endsection
