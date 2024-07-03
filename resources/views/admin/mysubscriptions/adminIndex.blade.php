@extends('layouts.master')

@section('header', 'Subscriptions')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">All Subscriptions</h4>
                <div class="d-flex align-items-center mb-3">
                    <div class="d-flex flex-column small">
                        <span class="badge bg-danger me-1 mt-2">Validity of Membership - Expired</span>
                        <span class="badge bg-warning me-1 mt-2">Validity of Membership - Expiring Soon</span>
                        <span class="badge bg-success me-1 mt-2">Validity of Membership - Valid</span>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center mb-3">
                <small class="text-muted me-1"><strong>Filter By:</strong></small>
                <div class="d-flex align-items-center">
                    <select name="membershipType" id="membershipType" class="form-select form-select-sm">
                        <option value="" selected>Select Membership</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>
                        <option value="LifeTime">LifeTime</option>
                    </select>
                </div>
                <form action="{{ route('subscriptions.export') }}" method="POST" id="exportForm" class="ms-3">
                    @csrf
                    <input type="hidden" name="membershipType" id="exportMembershipType">
                    <button type="submit" class="btn btn-bg-blue btn-sm">Download Excel</button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table datatable" id="subscriptionsTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Membership Type</th>
                            <th>Amount</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allSubscriptions as $subscriptionData)
                        <tr>
                            <td>{{ $subscriptionData->user->firstName ?? '-' }} {{ $subscriptionData->user->lastName ??
                                '-' }}
                            </td>
                            <td>{{ $subscriptionData->membershipType ?? '-' }}</td>
                            <td>{{ $subscriptionData->allPayments->amount ?? '-' }}</td>
                            <td>
                                @php
                                $validityDate = \Carbon\Carbon::parse($subscriptionData->validity);
                                $today = \Carbon\Carbon::now();
                                $warningThreshold = $today->copy()->addDays(10);
                                @endphp
                                <span
                                    class="badge {{ $validityDate->isPast() ? 'bg-danger' : ($validityDate->between($today, $warningThreshold) ? 'bg-warning' : 'bg-success') }}">
                                    {{ $subscriptionData->validity ? $validityDate->format('d-M-Y') : '-' }}
                                </span>
                            </td>
                            <td>{{ $subscriptionData->status ?? '-' }}</td>
                            <td>
                                <form action="{{ route('renewMembership.mail', $subscriptionData->userId) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-bg-blue btn-sm">
                                        <i class="bi bi-envelope"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const membershipTypeSelect = document.getElementById('membershipType');
        const table = document.getElementById('subscriptionsTable');
        const rows = table.getElementsByTagName('tr');
        const exportForm = document.getElementById('exportForm');
        const exportMembershipType = document.getElementById('exportMembershipType');

        membershipTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            exportMembershipType.value = selectedType; // Set the selected type in the hidden input

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const membershipType = cells[1].innerText;

                if (selectedType === "" || membershipType === selectedType) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>

@endsection