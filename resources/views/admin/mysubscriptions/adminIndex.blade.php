@extends('layouts.master')

@section('title', 'UBN - Subscriptions')
@section('content')

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
                        <select name="membershipType" id="filterMembershipType" class="form-select form-select-sm">
                            <option value="" selected>Select Membership</option>
                            @foreach ($membershipType as $membershipTypeData)
                                <option value="{{ $membershipTypeData->id }}">{{ $membershipTypeData->membershipType }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <form action="{{ route('subscriptions.export') }}" method="POST" id="exportForm" class="ms-3">
                        @csrf
                        <input type="hidden" name="membershipType" id="exportMembershipType">
                        {{-- <button type="submit" class="btn btn-bg-blue btn-sm">Download Excel</button> --}}
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="subscriptionsTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Joining Date</th>
                                <th>Membership Type</th>
                                <th>Amount</th>
                                <th>Validity</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allSubscriptions as $subscriptionData)
                                <tr>
                                    <th>{{ ($allSubscriptions->currentPage() - 1) * $allSubscriptions->perPage() + $loop->index + 1 }}
                                    </th>
                                    <td>{{ $subscriptionData->user->firstName ?? '-' }}
                                        {{ $subscriptionData->user->lastName ?? '-' }}
                                    </td>
                                    <td>
                                        {{ optional($subscriptionData->user->member)->created_at?->format('d M Y') }}
                                    </td>
                                    <td>{{ $subscriptionData->membershipType ?? '-' }}</td>
                                    <td>{{ number_format($subscriptionData->allPayments->amount ?? 0, 2) ?? '-' }}</td>
                                    <td>
                                        @php
                                            $validityDate = \Carbon\Carbon::parse($subscriptionData->validity);
                                            $today = \Carbon\Carbon::now();
                                            $warningThreshold = $today->copy()->addDays(10);
                                        @endphp
                                        <span class="badge {{ $validityDate->isPast() ? 'bg-danger' : ($validityDate->between($today, $warningThreshold) ? 'bg-warning' : 'bg-success') }}">
                                            {{ $subscriptionData->validity ? $validityDate->format('d-M-Y') : '-' }}
                                        </span>
                                    </td>
                                    {{-- <td>{{ $subscriptionData->status ?? '-' }}</td> --}}
                                    <td>
                                        <button type="button" class="btn btn-bg-blue btn-sm renew-btn" data-url="{{ route('renewMembership.mail', $subscriptionData->userId) }}">
                                            Renew Subscription
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $allSubscriptions->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const membershipTypeSelect = document.getElementById('filterMembershipType');
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.renew-btn').forEach(btn => {
                btn.addEventListener('click', function() {

                    let url = this.dataset.url;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you want to renew this membership?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Renew',
                    }).then((result) => {

                        if (result.isConfirmed) {

                            fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(async res => {

                                    let text = await res.text();
                                    console.log("RAW RESPONSE:", text);

                                    let data;

                                    try {
                                        data = JSON.parse(text);
                                    } catch (e) {
                                        throw new Error("Invalid JSON: " + text);
                                    }

                                    if (!res.ok) {
                                        throw new Error(data.message || "Server error");
                                    }

                                    return data;
                                })
                                .then(data => {

                                    console.log("SUCCESS DATA:", data); // 👈 NOW IT WILL PRINT

                                    Swal.fire('Success', data.message, 'success')
                                        .then(() => location.reload());

                                })
                                .catch((error) => {

                                    console.error("ERROR:", error); // 👈 VERY IMPORTANT

                                    Swal.fire('Warning', 'Updated but response failed', 'warning')
                                        .then(() => location.reload());

                                });
                        }
                    });
                });
            });

        });
    </script>


@endsection
