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
                                <span class="badge
                                        @if($ticket->priority === 'High') bg-danger
                                        @elseif($ticket->priority === 'Medium') bg-warning
                                        @else bg-secondary @endif">
                                    {{ $ticket->priority }}
                                </span>
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
    const selects = document.querySelectorAll('.ticket-status-select');
    const url = '{{ route('support.adminUpdateStatus') }}';
    const tokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrf = tokenMeta ? tokenMeta.getAttribute('content') : '';

    function updateBadge(badge, status) {
        badge.textContent = status;
        badge.classList.remove('bg-success', 'bg-info', 'bg-primary');
        if (status === 'Closed') badge.classList.add('bg-success');
        else if (status === 'In Progress') badge.classList.add('bg-info');
        else badge.classList.add('bg-primary');
    }

    selects.forEach(function (select) {
        select.addEventListener('change', async function (e) {
            const newStatus = e.target.value;
            const id = e.target.getAttribute('data-id');
            e.target.disabled = true;
            const cardBody = e.target.closest('.card-body');
            const badge = cardBody.querySelector('.ticket-status-badge');
            try {
                const resp = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id, status: newStatus })
                });
                if (!resp.ok) throw new Error('Network error');
                const data = await resp.json();
                if (data && data.success) {
                    updateBadge(badge, newStatus);
                } else {
                    throw new Error('Update failed');
                }
            } catch (err) {
                alert('Failed to update status');
                // revert
                const current = badge.textContent.trim();
                e.target.value = current;
            } finally {
                e.target.disabled = false;
            }
        });
    });
});
</script>
@endsection