@extends('layouts.master')

@section('header', 'Due Payment')
@section('title', 'UBN - Due Payment')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <!-- Header with Title and Add Button matching other admin pages -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title mb-0">Due Payment</h4>
                <button type="button" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal" id="openAddModalBtn">
                    <i class="bi bi-plus-circle"></i>
                    <span class="btn-text">Add Due Payment</span>
                </button>
            </div>

            <!-- Filter By Row matching other admin index pages -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <small class="text-muted fw-bold">Filter By:</small>

                    <!-- Circle Filter -->
                    <select class="form-select form-select-sm" id="pageCircleFilter" style="width: auto; min-width: 170px;">
                        <option value="all" selected>All Circles</option>
                        <option value="Digital Member">Digital Member</option>
                        @foreach ($circles as $circle)
                            <option value="{{ $circle->circleName }}">{{ $circle->circleName }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select class="form-select form-select-sm" id="pageStatusFilter" style="width: auto; min-width: 130px;">
                        <option value="all" selected>All Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>

                    <span class="badge" id="filterStatusBadge" style="background-color: #1d2856; font-size: 12px; font-weight: 500; padding: 6px 12px;">
                        Showing: All Circles
                    </span>
                    <span class="text-muted small" id="filteredCountText">({{ count($subscriptions) }} records)</span>
                </div>

                <!-- Search Box -->
                <div class="search-box" style="min-width: 240px;">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" id="tableSearchInput" placeholder="Search member, circle, amount...">
                    </div>
                </div>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="subscriptionTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Circle</th>
                            <th>Member Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="subscriptionTableBody">
                        @forelse ($subscriptions as $index => $sub)
                            <tr data-circle="{{ $sub['circle_name'] }}" data-status="{{ $sub['status'] }}" data-id="{{ $sub['id'] }}">
                                <th>{{ $index + 1 }}</th>
                                <td>{{ $sub['circle_name'] }}</td>
                                <td>
                                    {{ $sub['member_name'] }}
                                    @if ($sub['circle_name'] === 'Digital Member' && !empty($sub['user_id']))
                                        <span class="text-muted small ms-1">(User ID: {{ $sub['user_id'] }})</span>
                                    @endif
                                </td>
                                <td>{{ $sub['amount'] }}</td>
                                <td>{{ $sub['status'] }}</td>
                                <td>
                                    <button type="button" class="btn btn-bg-blue btn-sm btn-tooltip edit-row-btn" data-id="{{ $sub['id'] }}" title="Edit">
                                        <i class="bi bi-pen"></i>
                                        <span class="btn-text">Edit</span>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-tooltip delete-row-btn" data-id="{{ $sub['id'] }}" title="Delete">
                                        <i class="bi bi-trash"></i>
                                        <span class="btn-text">Delete</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Empty State for Table when no rows match or no records created yet -->
            <div id="emptyTableState" class="text-center py-5 {{ count($subscriptions) > 0 ? 'd-none' : '' }}">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h6 class="fw-bold text-muted mt-2">No due payment records found</h6>
                <p class="text-muted small">Click "Add Due Payment" to assign a new due payment.</p>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- ADD DUE PAYMENT MODAL (POP-UP) -->
<!-- ========================================== -->
<div class="modal fade" id="addSubscriptionModal" tabindex="-1" aria-labelledby="addSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header text-white" style="background-color: #1d2856; border-bottom: 3px solid #e76a35;">
                <h5 class="modal-title fw-bold" id="addSubscriptionModalLabel">
                    <i class="bi bi-wallet2 text-orange me-2"></i> Add Due Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body Form -->
            <div class="modal-body p-4">
                <form id="addSubscriptionForm">
                    <!-- Dropdown 1: Circle / Digital Member Select -->
                    <div class="mb-3">
                        <label for="modalCircleSelect" class="form-label fw-bold text-blue small">
                            Select Circle / Digital Member <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="modalCircleSelect" required style="border-color: #cbd5e1;">
                            <option value="" selected disabled>-- Select Circle / Digital Member --</option>
                            <option value="digital_member" data-name="Digital Member">Digital Member</option>
                            @foreach ($circles as $circle)
                                <option value="{{ $circle->id }}" data-name="{{ $circle->circleName }}">{{ $circle->circleName }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Select Circle or Digital Member to load members.</small>
                    </div>

                    <!-- Dropdown 2: Member Select -->
                    <div class="mb-3">
                        <label for="modalMemberSelect" class="form-label fw-bold text-blue small">
                            Select Member <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="modalMemberSelect" required disabled style="border-color: #cbd5e1;">
                            <option value="" selected disabled>-- Select Circle First --</option>
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Select one member from the circle.</small>
                    </div>

                    <!-- Field 3: Amount Label & Input -->
                    <div class="mb-3">
                        <label for="modalAmount" class="form-label fw-bold text-blue small">
                            Amount <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold text-blue" style="background-color: #f1f5f9; border-color: #cbd5e1;">₹</span>
                            <input type="number" class="form-control" id="modalAmount" placeholder="Enter amount (e.g. 15000)" value="15000" min="1" required style="border-color: #cbd5e1; font-weight: 600;">
                        </div>
                        <small class="text-muted" style="font-size: 11px;">Enter the due payment amount.</small>
                    </div>

                    <!-- Dropdown 4: Status Dropdown -->
                    <div class="mb-3">
                        <label for="modalStatus" class="form-label fw-bold text-blue small">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="modalStatus" required style="border-color: #cbd5e1;">
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Select payment status.</small>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light px-4 py-3" style="border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-bg-blue px-4 fw-semibold" id="submitSubscriptionBtn">
                    <i class="bi bi-check2-circle me-1"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- EDIT DUE PAYMENT MODAL (POP-UP) -->
<!-- ========================================== -->
<div class="modal fade" id="editSubscriptionModal" tabindex="-1" aria-labelledby="editSubscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; overflow: hidden;">
            <!-- Modal Header -->
            <div class="modal-header text-white" style="background-color: #1d2856; border-bottom: 3px solid #e76a35;">
                <h5 class="modal-title fw-bold" id="editSubscriptionModalLabel">
                    <i class="bi bi-pencil-square text-orange me-2"></i> Edit Due Payment
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body Form -->
            <div class="modal-body p-4">
                <form id="editSubscriptionForm">
                    <input type="hidden" id="editDuePaymentId">

                    <!-- Dropdown 1: Circle / Digital Member Select -->
                    <div class="mb-3">
                        <label for="editCircleSelect" class="form-label fw-bold text-blue small">
                            Select Circle / Digital Member <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="editCircleSelect" required style="border-color: #cbd5e1;">
                            <option value="" disabled>-- Select Circle / Digital Member --</option>
                            <option value="digital_member" data-name="Digital Member">Digital Member</option>
                            @foreach ($circles as $circle)
                                <option value="{{ $circle->id }}" data-name="{{ $circle->circleName }}">{{ $circle->circleName }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Change circle or keep existing.</small>
                    </div>

                    <!-- Dropdown 2: Member Select -->
                    <div class="mb-3">
                        <label for="editMemberSelect" class="form-label fw-bold text-blue small">
                            Select Member <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="editMemberSelect" required style="border-color: #cbd5e1;">
                            <option value="" disabled>-- Select Member --</option>
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Select member from the circle.</small>
                    </div>

                    <!-- Field 3: Amount Label & Input -->
                    <div class="mb-3">
                        <label for="editAmount" class="form-label fw-bold text-blue small">
                            Amount <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold text-blue" style="background-color: #f1f5f9; border-color: #cbd5e1;">₹</span>
                            <input type="number" class="form-control" id="editAmount" placeholder="Enter amount" min="1" required style="border-color: #cbd5e1; font-weight: 600;">
                        </div>
                        <small class="text-muted" style="font-size: 11px;">Enter the due payment amount.</small>
                    </div>

                    <!-- Dropdown 4: Status Dropdown -->
                    <div class="mb-3">
                        <label for="editStatus" class="form-label fw-bold text-blue small">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="editStatus" required style="border-color: #cbd5e1;">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Paid">Paid</option>
                        </select>
                        <small class="text-muted" style="font-size: 11px;">Select payment status (Active / Inactive / Paid).</small>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer bg-light px-4 py-3" style="border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-bg-blue px-4 fw-semibold" id="updateSubscriptionBtn">
                    <i class="bi bi-save me-1"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Page Styling -->
<style>
    .btn-bg-orange {
        background-color: #e76a35 !important;
        color: #ffffff !important;
        border: none;
        transition: all 0.2s ease-in-out;
    }
    .btn-bg-orange:hover {
        background-color: #d25925 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(231, 106, 53, 0.3);
    }
    .btn-bg-blue {
        background-color: #1d2856 !important;
        color: #ffffff !important;
        border: none;
        transition: all 0.2s ease-in-out;
    }
    .btn-bg-blue:hover {
        background-color: #141d40 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(29, 40, 86, 0.3);
    }
    .text-orange {
        color: #e76a35 !important;
    }
    .text-blue {
        color: #1d2856 !important;
    }
</style>

<!-- Dynamic Interactive JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';
    const membersByCircleRoute = '{{ url("/due-payment/members") }}';
    const storeSubscriptionRoute = '{{ route("admin.duePayment.store") }}';
    const editSubscriptionBaseRoute = '{{ url("/due-payment") }}';
    const updateSubscriptionBaseRoute = '{{ url("/due-payment/update") }}';
    const deleteSubscriptionBaseRoute = '{{ url("/due-payment") }}';

    // Add Modal Elements
    const modalCircleSelect = document.getElementById('modalCircleSelect');
    const modalMemberSelect = document.getElementById('modalMemberSelect');
    const modalStatusSelect = document.getElementById('modalStatus');
    const submitBtn = document.getElementById('submitSubscriptionBtn');

    // Edit Modal Elements
    const editDuePaymentId = document.getElementById('editDuePaymentId');
    const editCircleSelect = document.getElementById('editCircleSelect');
    const editMemberSelect = document.getElementById('editMemberSelect');
    const editAmount = document.getElementById('editAmount');
    const editStatus = document.getElementById('editStatus');
    const updateBtn = document.getElementById('updateSubscriptionBtn');

    // Page Elements
    const pageCircleFilter = document.getElementById('pageCircleFilter');
    const pageStatusFilter = document.getElementById('pageStatusFilter');
    const tableBody = document.getElementById('subscriptionTableBody');
    const tableSearchInput = document.getElementById('tableSearchInput');
    const filterStatusBadge = document.getElementById('filterStatusBadge');
    const filteredCountText = document.getElementById('filteredCountText');
    const emptyTableState = document.getElementById('emptyTableState');

    // Reusable function to fetch and populate members
    function loadMembersForSelect(circleId, selectElement, selectedMemberId = null) {
        if (!circleId) {
            selectElement.innerHTML = '<option value="" selected disabled>-- Select Circle First --</option>';
            selectElement.disabled = true;
            return Promise.resolve();
        }

        selectElement.innerHTML = '<option value="" selected disabled>Loading members...</option>';
        selectElement.disabled = true;

        return fetch(`${membersByCircleRoute}/${circleId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.members && data.members.length > 0) {
                    selectElement.innerHTML = '<option value="" disabled>-- Select Member --</option>';
                    data.members.forEach(member => {
                        const opt = document.createElement('option');
                        opt.value = member.id;
                        opt.setAttribute('data-name', member.name);
                        opt.setAttribute('data-initials', member.initials || 'MB');
                        opt.textContent = member.name;

                        if (selectedMemberId && String(member.id) === String(selectedMemberId)) {
                            opt.selected = true;
                        }
                        selectElement.appendChild(opt);
                    });
                    selectElement.disabled = false;
                } else {
                    selectElement.innerHTML = '<option value="" selected disabled>No active members in this circle</option>';
                    selectElement.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error fetching members:', error);
                selectElement.innerHTML = '<option value="" selected disabled>Failed to load members</option>';
                selectElement.disabled = true;
            });
    }

    // 1. In Add Modal: When Circle is selected -> Fetch members via AJAX dynamically
    modalCircleSelect.addEventListener('change', function () {
        loadMembersForSelect(this.value, modalMemberSelect);
    });

    // 2. In Edit Modal: When Circle is selected -> Fetch members via AJAX dynamically
    editCircleSelect.addEventListener('change', function () {
        loadMembersForSelect(this.value, editMemberSelect);
    });

    // 3. Submit Button Click -> Validate and send AJAX POST to store in DB
    submitBtn.addEventListener('click', function () {
        const circleId = modalCircleSelect.value;
        const memberId = modalMemberSelect.value;
        const paymentTypeEl = document.getElementById('modalPaymentType');
        const paymentType = paymentTypeEl ? paymentTypeEl.value : 'Due Payment';
        const amount = document.getElementById('modalAmount').value;
        const status = modalStatusSelect.value;

        if (!circleId) {
            Swal.fire({ icon: 'warning', title: 'Missing Circle', text: 'Please select a Circle first!' });
            return;
        }
        if (!memberId) {
            Swal.fire({ icon: 'warning', title: 'Missing Member', text: 'Please select a Member!' });
            return;
        }
        if (!amount || Number(amount) <= 0) {
            Swal.fire({ icon: 'warning', title: 'Invalid Amount', text: 'Please enter a valid amount!' });
            return;
        }
        if (!status) {
            Swal.fire({ icon: 'warning', title: 'Missing Status', text: 'Please select a Status!' });
            return;
        }

        // Show loading state on button
        const originalBtnHtml = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...';

        fetch(storeSubscriptionRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                circle_id: circleId,
                member_id: memberId,
                payment_type: paymentType,
                amount: amount,
                status: status
            })
        })
        .then(response => response.json())
        .then(res => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;

            if (res.success && res.data) {
                const item = res.data;
                const isDigital = (item.circle_name === 'Digital Member');
                const effectiveUserId = item.userId || item.user_id;
                const userIdText = (isDigital && effectiveUserId) 
                    ? `<span class="text-muted small ms-1">(User ID: ${effectiveUserId})</span>` 
                    : '';

                // Create new row
                const newRow = document.createElement('tr');
                newRow.setAttribute('data-circle', item.circle_name);
                newRow.setAttribute('data-status', item.status);
                newRow.setAttribute('data-id', item.id);
                newRow.innerHTML = `
                    <th>1</th>
                    <td>${item.circle_name}</td>
                    <td>${item.member_name} ${userIdText}</td>
                    <td>${item.amount}</td>
                    <td>${item.status}</td>
                    <td>
                        <button type="button" class="btn btn-bg-blue btn-sm btn-tooltip edit-row-btn" data-id="${item.id}" title="Edit">
                            <i class="bi bi-pen"></i>
                            <span class="btn-text">Edit</span>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-tooltip delete-row-btn" data-id="${item.id}" title="Delete">
                            <i class="bi bi-trash"></i>
                            <span class="btn-text">Delete</span>
                        </button>
                    </td>
                `;

                // Prepend new row to table
                tableBody.prepend(newRow);

                // Re-index row numbers and filter
                reindexRows();
                filterTable();

                // Close Modal
                const modalElement = document.getElementById('addSubscriptionModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }

                // Reset form
                document.getElementById('addSubscriptionForm').reset();
                modalMemberSelect.innerHTML = '<option value="" selected disabled>-- Select Circle First --</option>';
                modalMemberSelect.disabled = true;
                document.getElementById('modalAmount').value = 15000;
                modalStatusSelect.value = 'Active';

                // SweetAlert2 notification
                Swal.fire({
                    icon: 'success',
                    title: 'Due Payment Added!',
                    text: res.message || `Due payment for ${item.member_name} added successfully.`,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message || 'Failed to save due payment.'
                });
            }
        })
        .catch(err => {
            console.error('Error saving due payment:', err);
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnHtml;
            Swal.fire({
                icon: 'error',
                title: 'Request Failed',
                text: 'Something went wrong while saving the due payment.'
            });
        });
    });

    // 4. Update Button Click -> Validate and send AJAX POST to update in DB
    updateBtn.addEventListener('click', function () {
        const id = editDuePaymentId.value;
        const circleId = editCircleSelect.value;
        const memberId = editMemberSelect.value;
        const amount = editAmount.value;
        const status = editStatus.value;

        if (!id) {
            Swal.fire({ icon: 'warning', title: 'Invalid Record', text: 'Record ID is missing!' });
            return;
        }
        if (!circleId) {
            Swal.fire({ icon: 'warning', title: 'Missing Circle', text: 'Please select a Circle!' });
            return;
        }
        if (!memberId) {
            Swal.fire({ icon: 'warning', title: 'Missing Member', text: 'Please select a Member!' });
            return;
        }
        if (!amount || Number(amount) <= 0) {
            Swal.fire({ icon: 'warning', title: 'Invalid Amount', text: 'Please enter a valid amount!' });
            return;
        }
        if (!status) {
            Swal.fire({ icon: 'warning', title: 'Missing Status', text: 'Please select a Status!' });
            return;
        }

        const originalBtnHtml = updateBtn.innerHTML;
        updateBtn.disabled = true;
        updateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Updating...';

        fetch(`${updateSubscriptionBaseRoute}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                circle_id: circleId,
                member_id: memberId,
                amount: amount,
                status: status
            })
        })
        .then(response => response.json())
        .then(res => {
            updateBtn.disabled = false;
            updateBtn.innerHTML = originalBtnHtml;

            if (res.success && res.data) {
                const item = res.data;
                const isDigital = (item.circle_name === 'Digital Member');
                const effectiveUserId = item.userId || item.user_id;
                const userIdText = (isDigital && effectiveUserId) 
                    ? `<span class="text-muted small ms-1">(User ID: ${effectiveUserId})</span>` 
                    : '';

                // Find corresponding row in table
                const row = tableBody.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.setAttribute('data-circle', item.circle_name);
                    row.setAttribute('data-status', item.status);
                    if (row.cells[1]) row.cells[1].textContent = item.circle_name;
                    if (row.cells[2]) row.cells[2].innerHTML = `${item.member_name} ${userIdText}`;
                    if (row.cells[3]) row.cells[3].textContent = item.amount;
                    if (row.cells[4]) row.cells[4].textContent = item.status;
                }

                filterTable();

                // Close Modal
                const editModalEl = document.getElementById('editSubscriptionModal');
                const editModalInstance = bootstrap.Modal.getInstance(editModalEl);
                if (editModalInstance) {
                    editModalInstance.hide();
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Due Payment Updated!',
                    text: res.message || 'Due payment updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message || 'Failed to update due payment.'
                });
            }
        })
        .catch(err => {
            console.error('Error updating due payment:', err);
            updateBtn.disabled = false;
            updateBtn.innerHTML = originalBtnHtml;
            Swal.fire({
                icon: 'error',
                title: 'Request Failed',
                text: 'Something went wrong while updating the due payment.'
            });
        });
    });

    // 5. Table click listeners (Edit & Delete)
    tableBody.addEventListener('click', function (e) {
        // --- EDIT BUTTON ---
        const editBtn = e.target.closest('.edit-row-btn');
        if (editBtn) {
            const id = editBtn.getAttribute('data-id');
            if (!id) return;

            // Fetch record details
            fetch(`${editSubscriptionBaseRoute}/${id}/edit`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (res.success && res.data) {
                    const data = res.data;
                    editDuePaymentId.value = data.id;

                    // Set Circle
                    let circleVal = data.circle_id;
                    if (data.circle_name === 'Digital Member') {
                        circleVal = 'digital_member';
                    }
                    editCircleSelect.value = circleVal;
                    if (!editCircleSelect.value && data.circle_name) {
                        for (let opt of editCircleSelect.options) {
                            if (opt.getAttribute('data-name') === data.circle_name) {
                                editCircleSelect.value = opt.value;
                                circleVal = opt.value;
                                break;
                            }
                        }
                    }

                    // Populate members and pre-select member_id
                    loadMembersForSelect(circleVal, editMemberSelect, data.member_id);

                    // Set Amount & Status
                    editAmount.value = data.amount;
                    editStatus.value = data.status || 'Active';

                    // Show Modal
                    const editModalEl = document.getElementById('editSubscriptionModal');
                    const editModalInstance = bootstrap.Modal.getOrCreateInstance(editModalEl);
                    editModalInstance.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message || 'Could not fetch due payment details.'
                    });
                }
            })
            .catch(err => {
                console.error('Error fetching due payment for edit:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load due payment details.'
                });
            });
            return;
        }

        // --- DELETE BUTTON ---
        const deleteBtn = e.target.closest('.delete-row-btn');
        if (!deleteBtn) return;

        const row = deleteBtn.closest('tr');
        const id = deleteBtn.getAttribute('data-id') || row.getAttribute('data-id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to remove this due payment entry?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1d2856',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                if (id) {
                    fetch(`${deleteSubscriptionBaseRoute}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            reindexRows();
                            filterTable();
                            Swal.fire({ icon: 'success', title: 'Deleted', text: data.message || 'Entry has been removed.', timer: 1500, showConfirmButton: false });
                        } else {
                            Swal.fire({ icon: 'error', title: 'Failed', text: data.message || 'Could not delete entry.' });
                        }
                    })
                    .catch(err => {
                        console.error('Error deleting due payment:', err);
                        Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while deleting.' });
                    });
                } else {
                    row.remove();
                    reindexRows();
                    filterTable();
                }
            }
        });
    });

    // 6. Page Top Circle Filter listener
    pageCircleFilter.addEventListener('change', function () {
        filterTable();
    });

    // 5. Page Top Status Filter listener
    pageStatusFilter.addEventListener('change', function () {
        filterTable();
    });

    // 6. Search box listener
    tableSearchInput.addEventListener('input', function () {
        filterTable();
    });

    // Helper: Filter Table by Circle, Status, and Search Text
    function filterTable() {
        const selectedCircle = pageCircleFilter.value;
        const selectedStatus = pageStatusFilter.value;
        const searchText = tableSearchInput.value.toLowerCase().trim();
        const rows = tableBody.querySelectorAll('tr');
        let visibleCount = 0;

        rows.forEach(function (row) {
            const rowCircle = row.getAttribute('data-circle') || '';
            const rowStatus = row.getAttribute('data-status') || '';
            const rowText = row.textContent.toLowerCase();

            const matchesCircle = (selectedCircle === 'all' || rowCircle === selectedCircle);
            const matchesStatus = (selectedStatus === 'all' || rowStatus === selectedStatus);
            const matchesSearch = (!searchText || rowText.includes(searchText));

            if (matchesCircle && matchesStatus && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update badge text
        if (selectedCircle === 'all') {
            filterStatusBadge.textContent = 'Showing: All Circles';
        } else {
            filterStatusBadge.textContent = `Showing: ${selectedCircle}`;
        }
        filteredCountText.textContent = `(${visibleCount} records)`;

        // Show/hide empty state
        if (visibleCount === 0) {
            emptyTableState.classList.remove('d-none');
        } else {
            emptyTableState.classList.add('d-none');
        }
    }

    // Helper: Reindex S.No column
    function reindexRows() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach(function (row, index) {
            const firstCell = row.cells[0];
            if (firstCell) {
                firstCell.textContent = index + 1;
            }
        });
    }

    // Initialize row numbering & filtering
    reindexRows();
    filterTable();
});
</script>
@endsection
