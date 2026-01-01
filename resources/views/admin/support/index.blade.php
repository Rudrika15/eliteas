@extends('layouts.master')

@section('title', 'UBN - Support Tickets')

@section('content')
<div class="container">
    <div class="card">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Support Tickets</h4>
            {{-- <a href="{{ route('support.create') }}" class="btn btn-bg-orange btn-sm">Create Ticket</a> --}}
        </div>

        <!-- Body -->
        <div class="card-body px-4 py-3">
            <div class="row g-3">

                @forelse ($tickets as $ticket)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-0">{{ $ticket->subject }}</h6>
                                <select class="form-select form-select-sm priority-select" data-id="{{ $ticket->id }}"
                                    style="width:auto;">
                                    <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High
                                    </option>
                                    <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                </select>
                            </div>

                            <div class="mt-2">
                                <span class="ticket-status-badge badge
                                        @if($ticket->status === 'Closed') bg-success
                                        @elseif($ticket->status === 'In Progress') bg-info
                                        @else bg-primary @endif">
                                    {{ $ticket->status }}
                                </span>
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <select data-id="{{ $ticket->id }}"
                                        class="ticket-status-select form-select form-select-sm" style="width:auto">
                                        <option value="Open" {{ $ticket->status === 'Open' ? 'selected' : '' }}>Open
                                        </option>
                                        <option value="In Progress" {{ $ticket->status === 'In Progress' ? 'selected' :
                                            '' }}>In Progress</option>
                                        <option value="Closed" {{ $ticket->status === 'Closed' ? 'selected' : ''
                                            }}>Closed</option>
                                    </select>
                                </div>
                            </div>

                            <p class="text-muted mt-2">
                                {{ \Illuminate\Support\Str::limit($ticket->description, 120) }}
                            </p>

                            <div class="mt-auto">
                                <small class="d-block mb-2">
                                    <strong>By:</strong> {{ $ticket->user?->firstName }} {{ $ticket->user?->lastName }}
                                    <strong class="ms-2">Circle:</strong> {{
                                    $ticket->user?->member?->circle?->circleName ?? '-' }}
                                </small>

                                <div class="d-flex gap-2">
                                    @if($ticket->attachment)
                                    <a href="{{ asset('support_attachments/' . $ticket->attachment) }}" target="_blank"
                                        class="btn btn-outline-secondary btn-sm">
                                        Attachment
                                    </a>
                                    @endif

                                    <a href="{{ route('support.delete', $ticket->id) }}"
                                        onclick="return confirm('Delete this ticket?')" class="btn btn-danger btn-sm">
                                        Delete
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No tickets found
                    </div>
                </div>
                @endforelse

            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    /* ===============================
       STATUS CHANGE DROPDOWN
    ================================ */
    const statusSelects = document.querySelectorAll('.ticket-status-select');
    const statusUrl = '{{ route('support.adminUpdateStatus') }}';

    statusSelects.forEach(select => {
        select.addEventListener('change', async function () {
            const id = this.dataset.id;
            const status = this.value;
            const badge = this.closest('.card-body').querySelector('.ticket-status-badge');

            this.disabled = true;

            try {
                const res = await fetch(statusUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({ id, status })
                });

                if (!res.ok) throw new Error('Failed');

                // Update badge color
                badge.textContent = status;
                badge.classList.remove('bg-success', 'bg-info', 'bg-primary');

                if (status === 'Closed') badge.classList.add('bg-success');
                else if (status === 'In Progress') badge.classList.add('bg-info');
                else badge.classList.add('bg-primary');

            } catch (error) {
                alert('Failed to update status');
            } finally {
                this.disabled = false;
            }
        });
    });

    /* ===============================
       PRIORITY DROPDOWN CHANGE
    ================================ */
    const prioritySelects = document.querySelectorAll('.priority-select');
    const priorityUrl = '{{ route('support.adminUpdatePriority') }}';

    prioritySelects.forEach(select => {
        select.addEventListener('change', async function () {
            const id = this.dataset.id;
            const priority = this.value;

            this.disabled = true;

            try {
                const res = await fetch(priorityUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({ id, priority })
                });

                if (!res.ok) throw new Error('Failed');
            } catch (error) {
                alert('Failed to update priority');
            } finally {
                this.disabled = false;
            }
        });
    });

});
</script>
@endsection
