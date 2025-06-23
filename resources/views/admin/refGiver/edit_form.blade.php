<!-- Edit Modal -->
<div class="modal fade right" id="editRefGiverModal_{{ $refGiverData->id }}" tabindex="-1" aria-labelledby="editRefGiverModalLabel_{{ $refGiverData->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="width: 800px !important;">
                <h5 class="modal-title">Edit Reference Giver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form class="needs-validation" method="POST" action="{{ route('refGiver.update', $refGiverData->id) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group" id="internal_{{ $refGiverData->id }}" value="internal" {{ !$refGiverData->contactName ? 'checked' : '' }}>
                                <label class="form-check-label" for="internal_{{ $refGiverData->id }}">Internal</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group" id="external_{{ $refGiverData->id }}" value="external" {{ $refGiverData->contactName ? 'checked' : '' }}>
                                <label class="form-check-label" for="external_{{ $refGiverData->id }}">External</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select circle-select" id="circleId_{{ $refGiverData->id }}" data-id="{{ $refGiverData->id }}" name="circleId" required>
                                    <option value="" disabled>Select Circle</option>
                                    <option value="{{ $refGiverData->circleId }}" selected>
                                        {{ $refGiverData->members->circle->circleName ?? '-' }}
                                    </option>
                                    @foreach ($circles as $circle)
                                        <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                                    @endforeach
                                </select>
                                <label for="circleId_{{ $refGiverData->id }}">Circle</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <select class="form-select member-select" id="memberId_{{ $refGiverData->id }}" data-id="{{ $refGiverData->id }}" name="memberId">
                                    <option value="{{ $refGiverData->meetingPersonId }}" selected>
                                        {{ $refGiverData->members->firstName ?? '-' }} {{ $refGiverData->members->lastName ?? '-' }}
                                    </option>
                                    <!-- Dynamic members via JS or preloaded -->
                                </select>
                                <label for="memberId_{{ $refGiverData->id }}">Member</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="meeting-person-id" id="meetingPersonId_{{ $refGiverData->id }}" name="memberId" value="{{ $refGiverData->memberId }}">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control meeting-person-name" id="meetingPersonName_{{ $refGiverData->id }}" value="{{ $refGiverData->members->firstName . ' ' . $refGiverData->members->lastName ?? '-' }}" readonly>
                        <label>Member Name</label>
                    </div>

                    <div id="memberListInput_{{ $refGiverData->id }}" style="display: {{ $refGiverData->contactName ? 'block' : 'none' }};">
                        <h5 class="mt-3 text-blue">Contact Person Details</h5>
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" name="contactNameExternal" placeholder="Contact Name" value="{{ $refGiverData->contactName }}">
                            <label>Contact Person Name</label>
                        </div>
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" name="contactNo" value="{{ $refGiverData->contactNo }}" placeholder="Contact No" maxlength="10">
                            <label>Contact No</label>
                        </div>
                        <div class="form-floating mt-3">
                            <input type="text" class="form-control" name="email" value="{{ $refGiverData->email }}" placeholder="Email">
                            <label>Email</label>
                        </div>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" id="description_{{ $refGiverData->id }}" name="description" value="{{ $refGiverData->description }}" placeholder="Description">
                        <label for="description_{{ $refGiverData->id }}">Description</label>
                    </div>

                    <div class="mt-4">
                        <label for="scale_{{ $refGiverData->id }}">Scale [1–5]</label>
                        <input type="range" class="form-range" id="scale_{{ $refGiverData->id }}" name="scale" value="{{ $refGiverData->scale }}" min="1" max="5">
                        <div class="d-flex justify-content-between mt-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="badge btn-bg-blue rounded-pill">{{ $i }}</span>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="create-btn">Update</button>
                    <button type="button" class="cancel-btn" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Since you have multiple modals (with unique IDs), select all relevant radio buttons by name pattern
        // Your radios have name="group" but in multiple modals, so better to target per modal container

        // Find all modals with editRefGiverModal prefix
        document.querySelectorAll('[id^="editRefGiverModal_"]').forEach(function(modal) {
            const internalRadio = modal.querySelector('input[type="radio"][value="internal"]');
            const externalRadio = modal.querySelector('input[type="radio"][value="external"]');
            const contactDetailsDiv = modal.querySelector('[id^="memberListInput_"]');

            // Function to toggle contact details visibility
            function toggleContactDetails() {
                if (externalRadio.checked) {
                    contactDetailsDiv.style.display = 'block';
                } else {
                    contactDetailsDiv.style.display = 'none';
                }
            }

            // Attach change event listeners
            internalRadio.addEventListener('change', toggleContactDetails);
            externalRadio.addEventListener('change', toggleContactDetails);

            // Initialize on page load
            toggleContactDetails();
        });
    });
</script>


<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load members based on circle
        function loadMembers(circleId, containerId, selectedMemberId = null) {
            let memberSelect = $('#memberId_' + containerId);
            memberSelect.empty().append('<option value="">Select Member</option>');

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
                                memberSelect.append(`<option value="${member.id}" data-user-id="${member.userId}" data-first-name="${member.firstName}" data-last-name="${member.lastName}">${member.firstName} ${member.lastName}</option>`);
                            });

                            if (selectedMemberId) {
                                memberSelect.val(selectedMemberId).trigger('change');
                            }
                        } else {
                            memberSelect.append('<option value="">No Members Found</option>');
                        }
                    },
                    error: function() {
                        memberSelect.append('<option value="">Error loading members</option>');
                    }
                });
            }
        }

        // Change event for circle dropdown
        $('.circle-select').on('change', function() {
            const containerId = $(this).data('id');
            const circleId = $(this).val();
            loadMembers(circleId, containerId);
        });

        // Change event for member dropdown
        $('.member-select').on('change', function() {
            const containerId = $(this).data('id');
            const selectedOption = $(this).find('option:selected');
            const userId = selectedOption.data('user-id') || '';
            const firstName = selectedOption.data('first-name') || '';
            const lastName = selectedOption.data('last-name') || '';

            $('#meetingPersonId_' + containerId).val(userId);
            $('#meetingPersonName_' + containerId).val(firstName + ' ' + lastName);
        });
    });
</script>
