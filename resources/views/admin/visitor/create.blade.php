@extends('layouts.master')

@section('header', 'Visitor')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Visitor</h5>
            <a href="{{ route('visitors.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="visitorForm" enctype="multipart/form-data" method="post" action="{{ route('visitors.store') }}" novalidate>
            @csrf


            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="meetingId" name="meetingId">
                            <option value="">Select Meeting Date</option>
                            @foreach ($meetingList as $meeting)
                                <option value="{{ $meeting->id }}">
                                    {{ \Carbon\Carbon::parse($meeting->date)->format('d-m-Y') }}
                                </option>
                            @endforeach
                        </select>

                        <label for="meetingId">Meeting Date</label>

                        @error('meetingId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>



            {{-- <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                    <label for="firstName">First Name</label>
                    @error('firstName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                    <label for="lastName">Last Name</label>
                    @error('lastName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('mobileNo') is-invalid @enderror" id="mobileNo"
                        name="mobileNo" placeholder="Mobile No" pattern="[0-9]{10}"
                        oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"
                        oninvalid="this.setCustomValidity('Please enter a valid 10-digit mobile number');"
                        oninput="this.setCustomValidity('')">
                    <label for="mobileNo">Mobile No</label>
                    @error('mobileNo')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                    <label for="email">Email</label>
                    @error('email')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="businessName" name="businessName"
                        placeholder="Business Name">
                    <label for="businessName">Business Name</label>
                    @error('businessName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    <label for="city">City</label>
                    @error('city')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="businessCategory" name="businessCategory">
                        <option value="">Select Business Category</option>
                        @foreach ($businessCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                        @endforeach
                    </select>
                    <label for="businessCategory">Business Category</label>
                    @error('businessCategory')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control" id="invitedBy" name="invitedBy" placeholder="Invited By">
                    <label for="invitedBy">Reffered By</label>
                    @error('invitedBy')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-floating">
                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"></textarea>
                    <label for="remarks">Remarks</label>
                    @error('remarks')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-floating">
                    <textarea class="form-control" id="otherDetails" name="otherDetails"
                        placeholder="otherDetails"></textarea>
                    <label for="otherDetails">Other Details</label>
                    @error('otherDetails')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div> --}}

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="firstName" placeholder="First Name">
                        <label>First Name</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="lastName" placeholder="Last Name">
                        <label>Last Name</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="mobileNo" placeholder="Mobile No" maxlength="10">
                        <label>Mobile No</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <label>Email</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="businessName" placeholder="Business Name">
                        <label>Business Name</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <!-- Display City Name -->
                        <input type="text" class="form-control" placeholder="City" value="{{ auth()->user()->member->circle->city->cityName ?? '' }}" readonly>
                        <!-- Store City ID -->
                        <input type="hidden" name="cityId" value="{{ auth()->user()->member->circle->cityId ?? '' }}">
                        <label>City</label>
                    </div>
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="businessCategory">
                            <option value="">Select Business Category</option>
                            @foreach ($businessCategories as $category)
                                <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>
                        <label>Business Category</label>
                    </div>
                </div>

                <!-- Referral Type -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="refType">
                            <option value="">Referred By</option>
                            <option value="member">Member</option>
                            <option value="other">Other</option>
                        </select>
                        <label>Referred Type</label>
                    </div>
                </div>
            </div>

            <!-- Circle & Member (hidden initially) -->
            <div class="row mb-3 d-none" id="memberBox">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" id="circleId" disabled>
                            @foreach ($circles as $circle)
                                <option value="{{ $circle->id }}" {{ auth()->user()->member->circleId == $circle->id ? 'selected' : '' }}>
                                    {{ $circle->circleName }}
                                </option>
                            @endforeach
                        </select>
                        <!-- Hidden field to submit value -->
                        <input type="hidden" name="circleId" value="{{ auth()->user()->member->circleId }}">
                        <label>Circle</label>
                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="memberId" id="memberId">
                            <option value="">Select Member</option>
                        </select>
                        <label>Member</label>
                    </div>
                </div>
            </div>

            <!-- Other Referred By -->
            <div class="row mb-3 d-none" id="otherBox">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="invitedBy" placeholder="Referred By">
                        <label>Referred By</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="remarks"></textarea>
                        <label>Remarks</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" name="otherDetails"></textarea>
                        <label>Other Details</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>


    <script>
        $(document).ready(function() {

            // CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* ===============================
               REFERRAL TYPE (Member / Other)
            =============================== */
            $('#refType').on('change', function() {
                $('#memberBox').addClass('d-none');
                $('#otherBox').addClass('d-none');

                if (this.value === 'member') {
                    $('#memberBox').removeClass('d-none');
                }

                if (this.value === 'other') {
                    $('#otherBox').removeClass('d-none');
                }
            });

            /* ===============================
               LOAD MEMBERS BY CIRCLE
            =============================== */
            function loadMembers(circleId) {
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
                                    $('#memberId').append(
                                        '<option value="' + member.id + '" ' +
                                        'data-user-id="' + member.userId + '" ' +
                                        'data-first-name="' + member.firstName + '" ' +
                                        'data-last-name="' + member.lastName + '">' +
                                        member.firstName + ' ' + member.lastName +
                                        '</option>'
                                    );
                                });

                                let defaultMemberId = '{{ auth()->user()->member->id }}';
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

            /* ===============================
               DEFAULT CIRCLE LOAD
            =============================== */
            let defaultCircleId = '{{ auth()->user()->member->circleId }}';
            if (defaultCircleId) {
                loadMembers(defaultCircleId);
            }

            $('#circleId').on('change', function() {
                loadMembers($(this).val());
            });

            /* ===============================
               MEMBER CHANGE
            =============================== */
            $('#memberId').on('change', function() {
                let opt = $(this).find('option:selected');

                let memberId = opt.val();
                let userId = opt.data('user-id');
                let firstName = opt.data('first-name');
                let lastName = opt.data('last-name');

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


@endsection
