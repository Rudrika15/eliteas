@extends('layouts.master')

@section('title', 'UBN - My Support Tickets')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h4 class="card-title">My Tickets</h4>
            <a href="{{ route('support.create') }}" class="btn btn-bg-orange btn-sm">Create Ticket</a>
        </div>

        <div>
            <div class="row">
                @forelse ($tickets as $index => $ticket)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start">
                                <h5 class="card-title mb-0">{{ $ticket->subject }}</h5>
                                <span class="badge
                                    @if($ticket->priority === 'High') bg-danger
                                    @elseif($ticket->priority === 'Medium') bg-warning
                                    @else bg-secondary @endif">
                                    {{ $ticket->priority }}
                                </span>
                            </div>
                            <div class="mt-2">
                                <span class="badge
                                    @if($ticket->status === 'Closed') bg-success
                                    @elseif($ticket->status === 'In Progress') bg-info
                                    @else bg-primary @endif">
                                    {{ $ticket->status }}
                                </span>
                            </div>
                            <p class="mt-3 text-muted">
                                {{ \Illuminate\Support\Str::limit($ticket->description, 120) }}
                            </p>
                            <div class="mt-auto">
                                <div class="small mb-2">
                                    <strong>Created:</strong> {{ $ticket->created_at?->format('d M Y') }}
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if($ticket->attachment)
                                    <a href="{{ asset('support_attachments/' . $ticket->attachment) }}" target="_blank"
                                        class="btn btn-outline-secondary btn-sm">Attachment</a>
                                    @endif
                                    <a href="{{ route('support.edit', $ticket->id) }}"
                                        class="btn btn-primary btn-sm">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">No tickets found</div>
                </div>
                @endforelse
            </div>
        </div>

        <div class="d-flex justify-content-end custom-pagination">
            {!! $tickets->links() !!}
        </div>
    </div>
</div>
@endsection
