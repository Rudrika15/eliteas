@extends('layouts.master')

@section('header', 'City')
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
            <h5 class="card-title">Edit Testimonial</h5>
            <a href="{{ route('testimonial.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation row g-3" id="testimonialForm" enctype="multipart/form-data" method="post" action="{{ route('testimonial.update', $myTestimonial->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $myTestimonial->id }}">

            {{-- MEMBER ROLE --}}
            @if (auth()->user()->hasRole('Member'))
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                            <option value="" disabled>Select Circle</option>
                            @foreach ($circles as $circle)
                                <option value="{{ $circle->id }}" {{ old('circleId', $refGiver->circleId ?? ($myTestimonial->circleId ?? '')) == $circle->id ? 'selected' : '' }}>
                                    {{ $circle->circleName }}
                                </option>
                            @endforeach
                        </select>
                        <label for="circleId">Circle</label>
                        @error('circleId')
                            <div class="invalid-tooltip">This field is required.</div>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- DIGITAL MEMBER ROLE --}}
            @if (auth()->user()->hasRole('Digital Member'))
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required>
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city', $myTestimonial->city ?? '') == $city->id ? 'selected' : '' }}>
                                    {{ $city->cityName }}
                                </option>
                            @endforeach
                        </select>
                        <label for="city">City</label>
                        @error('city')
                            <div class="invalid-tooltip">This field is required.</div>
                        @enderror
                    </div>
                </div>
            @endif

            {{-- MEMBER DROPDOWN --}}
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberIdSelect" required>
                        <option value="" disabled>Select Member</option>

                        {{-- Preload selected member if available --}}
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" data-user-id="{{ $member->userId ?? $member->id }}" data-first-name="{{ $member->firstName }}" data-last-name="{{ $member->lastName }}" {{ old('memberIdSelect', $myTestimonial->circlePersonId ?? '') == ($member->userId ?? $member->id) ? 'selected' : '' }}>
                                {{ $member->firstName }} {{ $member->lastName }}
                            </option>
                        @endforeach
                    </select>
                    <label for="memberId">Member</label>
                    @error('memberId')
                        <div class="invalid-tooltip">This field is required.</div>
                    @enderror
                </div>
            </div>

            {{-- MEMBER NAME (readonly) --}}
            <div class="col-md-12">
                <div class="form-floating mt-3">
                    <input type="hidden" id="circlePersonId" name="circlePersonId" value="{{ old('circlePersonId', $myTestimonial->circlePersonId ?? '') }}" required>
                    <input type="text" class="form-control @error('circlePersonId') is-invalid @enderror" id="circlePersonName" value="{{ old('circlePersonName', $myTestimonial->circlePersonName ?? '') }}" placeholder="Select Member" required disabled>
                    <label for="meetingPersonName"><span style="color:red">*</span> Member Name</label>
                    @error('circlePersonId')
                        <div class="invalid-tooltip">This field is required.</div>
                    @enderror
                </div>
            </div>

            {{-- MESSAGE --}}
            <div class="col-md-12">
                <div class="form-floating mt-3">
                    <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Enter Message" id="message" name="message" style="height: 100px" required>{{ old('message', $myTestimonial->message) }}</textarea>
                    <label for="message"><span style="color:red">*</span> Message</label>
                    @error('message')
                        <div class="invalid-tooltip">This field is required.</div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form>



    </div>

    <script>
        $(function() {
            // CSRF
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Server-side values (blade -> JS)
            var defaultCityId = {!! json_encode(old('city', $myTestimonial->city ?? (auth()->user()->member->cityId ?? ''))) !!};
            var defaultCircleId = {!! json_encode(old('circleId', $refGiver->circleId ?? ($myTestimonial->circleId ?? ''))) !!};
            var preselectedUserId = {!! json_encode(old('circlePersonId', $myTestimonial->circlePersonId ?? '')) !!};

            // Utility: populate #memberId from array of members and select matching user-id
            function populateMembersList(members, selectedUserId) {
                var $member = $('#memberId');
                $member.empty().append('<option value="" disabled>Select Member</option>');

                if (!members || members.length === 0) {
                    $member.append('<option value="">No Members Found</option>');
                    // clear name fields
                    $('#circlePersonId').val('');
                    $('#circlePersonName').val('');
                    return;
                }

                members.forEach(function(m) {
                    // each member object from server should have: id, userId (optional), firstName, lastName
                    var optValue = m.id;
                    var userId = m.userId || m.id;
                    var selected = (selectedUserId && selectedUserId.toString() === userId.toString()) ? 'selected' : '';
                    var display = ((m.firstName || '') + ' ' + (m.lastName || '')).trim();

                    $member.append(
                        '<option value="' + optValue + '"' +
                        ' data-user-id="' + userId + '"' +
                        ' data-first-name="' + (m.firstName || '') + '"' +
                        ' data-last-name="' + (m.lastName || '') + '"' +
                        ' ' + selected + '>' +
                        (display || '—') +
                        '</option>'
                    );
                });

                // Trigger change so fillSelectedMember runs
                $member.trigger('change');
            }

            // Load members by city (AJAX)
            function loadMembersByCity(cityId, selectedUserId) {
                $('#memberId').empty().append('<option value="" disabled selected>Loading...</option>');

                if (!cityId) {
                    $('#memberId').empty().append('<option value="" disabled selected>Select Member</option>');
                    $('#circlePersonId').val('');
                    $('#circlePersonName').val('');
                    return;
                }

                $.get('/get-members-by-city/' + cityId)
                    .done(function(response) {
                        var members = Array.isArray(response) ? response : (response.members || []);
                        populateMembersList(members, selectedUserId);
                    })
                    .fail(function() {
                        $('#memberId').empty().append('<option value="">Error loading members</option>');
                        $('#circlePersonId').val('');
                        $('#circlePersonName').val('');
                    });
            }

            // Load members by circle (AJAX) - for Member role if you have this endpoint
            function loadMembersByCircle(circleId, selectedUserId) {
                $('#memberId').empty().append('<option value="" disabled selected>Loading...</option>');

                if (!circleId) {
                    $('#memberId').empty().append('<option value="" disabled selected>Select Member</option>');
                    $('#circlePersonId').val('');
                    $('#circlePersonName').val('');
                    return;
                }

                // change URL if your route differs
                $.get('/get-members-by-circle/' + circleId)
                    .done(function(response) {
                        var members = Array.isArray(response) ? response : (response.members || []);
                        populateMembersList(members, selectedUserId);
                    })
                    .fail(function() {
                        $('#memberId').empty().append('<option value="">Error loading members</option>');
                        $('#circlePersonId').val('');
                        $('#circlePersonName').val('');
                    });
            }

            // Fill hidden and visible name from selected option
            function fillSelectedMember() {
                var selected = $('#memberId').find('option:selected');
                var userId = selected.data('user-id') || '';
                var firstName = selected.data('first-name') || '';
                var lastName = selected.data('last-name') || '';

                $('#circlePersonId').val(userId);
                $('#circlePersonName').val(((firstName || '') + ' ' + (lastName || '')).trim());
            }

            // Bind change
            $('#memberId').on('change', fillSelectedMember);

            // If circle dropdown exists, bind change to load members by circle
            if ($('#circleId').length) {
                $('#circleId').on('change', function() {
                    var cid = $(this).val();
                    loadMembersByCircle(cid, null); // user manually changed, no preselect
                });
            }

            // If city dropdown exists, bind change to load members by city
            if ($('#city').length) {
                $('#city').on('change', function() {
                    var city = $(this).val();
                    loadMembersByCity(city, null);
                });
            }

            // ON LOAD logic:
            // 1) If circleId exists and has a value -> load members by circle with preselectedUserId
            // 2) Else if city exists and has a value -> load members by city with preselectedUserId
            // 3) Else: try to keep any option Blade pre-rendered and fill name
            var circleVal = $('#circleId').length ? $('#circleId').val() || defaultCircleId : '';
            var cityVal = $('#city').length ? $('#city').val() || defaultCityId : '';

            if (circleVal) {
                loadMembersByCircle(circleVal, preselectedUserId);
            } else if (cityVal) {
                loadMembersByCity(cityVal, preselectedUserId);
            } else {
                // no AJAX source; try to use existing <option selected> (Blade-generated)
                var sel = $('#memberId').find('option:selected');
                if (sel.length && sel.val() !== '') {
                    // if option has data-user-id use that else use its value
                    $('#circlePersonId').val(sel.data('user-id') || sel.val());
                    $('#circlePersonName').val(((sel.data('first-name') || '') + ' ' + (sel.data('last-name') || '')).trim());
                } else if (preselectedUserId) {
                    // attempt to find option with matching data-user-id and select it
                    var found = $('#memberId option').filter(function() {
                        return $(this).data('user-id') && $(this).data('user-id').toString() === preselectedUserId.toString();
                    });
                    if (found.length) {
                        found.prop('selected', true);
                        $('#memberId').trigger('change');
                    }
                }
            }
        });
    </script>




@endsection
