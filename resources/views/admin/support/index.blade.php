@extends('layouts.master')

@section('title', 'UBN - Support Tickets')

@section('content')

    <style>
        /* Layout spacing */
        .ticket-wrapper {
            padding: 0 20px;
        }

        /* Card */
        .ticket-card {
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            transition: 0.3s;
        }

        .ticket-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        /* Colors */
        .bg-primary-custom {
            background-color: #1d3268 !important;
            color: #fff;
        }

        .bg-accent {
            background-color: #e76a35 !important;
            color: #fff;
        }

        .ticket-status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .priority-select {
            font-size: 13px;
            border: 1px solid #e76a35;
            color: #e76a35;
        }

        .priority-select:focus {
            border-color: #1d3268;
            box-shadow: none;
        }

        .card-body {
            padding: 18px;
        }

        .filter-bar select {
            width: 160px;
        }

        .loader {
            display: none;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Support Tickets</h4>

                <!-- FILTERS -->
                <div class="d-flex gap-2 filter-bar">

                    <!-- Status -->
                    <select id="filterStatus" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Closed">Closed</option>
                    </select>

                    <!-- Priority -->
                    <select id="filterPriority" class="form-select form-select-sm">
                        <option value="">All Priority</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>

                    <!-- Date Filter -->
                    <input type="date" id="filterDate" class="form-control form-control-sm">
                </div>

            </div>

            <!-- Loader -->
            {{-- <div id="filterLoader" class="px-4 mt-2" style="display:none;">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width:100%"></div>
                </div>
            </div> --}}

            <div id="filterLoader" class="text-center my-3" style="display:none;">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>


            <div class="card-body ticket-wrapper">
                <div class="row g-3" id="ticketContainer">

                    @forelse ($tickets as $ticket)
                        <div class="col-md-4 ticket-item" data-status="{{ $ticket->status }}" data-priority="{{ $ticket->priority }}" data-date="{{ $ticket->created_at->format('Y-m-d') }}">

                            <div class="card ticket-card h-100">
                                <div class="card-body d-flex flex-column">

                                    <h6>{{ $ticket->subject }}</h6>

                                    <div class="d-flex gap-2 mt-2">

                                        <!-- STATUS DROPDOWN -->
                                        <select class="form-select form-select-sm ticket-status-select" data-id="{{ $ticket->id }}" style="width:auto; ">

                                            <option value="" disabled {{ $ticket->status == '' ? 'selected' : '' }}></option>
                                            <option value="Open" {{ $ticket->status == 'Open' ? 'selected' : '' }}>Open</option>
                                            <option value="In Progress" {{ $ticket->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="Closed" {{ $ticket->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                                        </select>

                                        <!-- PRIORITY DROPDOWN -->
                                        <select class="form-select form-select-sm priority-select" data-id="{{ $ticket->id }}" style="width:auto; ">
                                            <option value="" disabled {{ $ticket->priority == '' ? 'selected' : '' }}></option>
                                            <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                            <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                                        </select>

                                    </div>


                                    <p class="text-muted mt-2">
                                        {{ \Illuminate\Support\Str::limit($ticket->description, 120) }}
                                    </p>

                                    <div class="mt-auto">
                                        <small>
                                            <strong>By:</strong> {{ $ticket->user?->firstName }}
                                            <strong class="ms-2">Circle:</strong> {{ $ticket->user?->member?->circle?->circleName ?? '-' }}
                                        </small>

                                        <small class="d-block ">
                                            <strong>Created At:</strong> {{ $ticket->created_at->format('d M Y, h:i A') }}
                                        </small>

                                        <div class="mt-2">
                                            <a href="{{ route('support.delete', $ticket->id) }}" class="btn btn-sm" style="background:#e76a35;color:#fff;" onclick="return confirm('Delete this ticket?')">
                                                Delete
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <div class="alert alert-info">No tickets found</div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // STATUS CHANGE
            document.querySelectorAll('.ticket-status-select').forEach(select => {
                select.addEventListener('change', function() {
                    const ticketId = this.dataset.id;
                    const status = this.value;

                    fetch("{{ route('support.adminUpdateStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrf
                            },
                            body: JSON.stringify({
                                id: ticketId,
                                status
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Request failed');
                            return response.json().catch(() => ({})); // 👈 prevents crash
                        })
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Status updated successfully.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update status.'
                            });
                        });
                });
            });

            // PRIORITY CHANGE
            document.querySelectorAll('.priority-select').forEach(select => {
                select.addEventListener('change', function() {
                    const ticketId = this.dataset.id;
                    const priority = this.value;

                    fetch("{{ route('support.adminUpdatePriority') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrf
                            },
                            body: JSON.stringify({
                                id: ticketId,
                                priority
                            })
                        })
                        .then(response => {
                            if (!response.ok) throw new Error();
                            return response.json().catch(() => ({}));
                        })
                        .then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Priority updated successfully.',
                                timer: 1200,
                                showConfirmButton: false
                            });
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update priority.'
                            });
                        });
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const statusFilter = document.getElementById('filterStatus');
            const priorityFilter = document.getElementById('filterPriority');
            const dateFilter = document.getElementById('filterDate'); // ✅ NEW
            const cards = document.querySelectorAll('.ticket-item');
            const loader = document.getElementById('filterLoader');

            function applyFilters() {
                loader.style.display = 'block';

                setTimeout(() => {
                    const status = statusFilter.value;
                    const priority = priorityFilter.value;
                    const date = dateFilter.value; // ✅ NEW

                    cards.forEach(card => {
                        const cardStatus = card.dataset.status;
                        const cardPriority = card.dataset.priority;
                        const cardDate = card.dataset.date; // yyyy-mm-dd

                        let show = true;

                        if (status && cardStatus !== status) show = false;
                        if (priority && cardPriority !== priority) show = false;
                        if (date && cardDate !== date) show = false; // ✅ date filter

                        card.style.display = show ? 'block' : 'none';
                    });

                    loader.style.display = 'none';
                }, 300);
            }

            statusFilter.addEventListener('change', applyFilters);
            priorityFilter.addEventListener('change', applyFilters);
            dateFilter.addEventListener('change', applyFilters);
        });
    </script>




@endsection
