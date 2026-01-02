@extends('layouts.master')

@section('title', 'UBN - My Support Tickets')
@section('content')

    <style>
        .ticket-card {
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            transition: 0.3s;
        }

        .ticket-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .badge-priority {
            background-color: #e76a35;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .badge-status {
            background-color: #1d3268;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .ticket-title {
            font-weight: 600;
            color: #1d3268;
        }

        .ticket-footer small {
            color: #666;
        }

        .ticket-wrapper {
            padding: 0 20px;
            /* left & right space */
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="card-title">My Tickets</h4>
                <a href="{{ route('support.create') }}" class="btn btn-bg-orange btn-sm">Create Ticket</a>
            </div>

            <div>
                <div class="ticket-wrapper">
                    <div class="row">
                        @forelse ($tickets as $ticket)
                            <div class="col-md-4 mb-4">
                                <div class="card ticket-card h-100">
                                    <div class="card-body d-flex flex-column">

                                        <!-- Header -->
                                        <div class="d-flex justify-content-between align-items-start mb-2 mt-4">
                                            <h5 class="ticket-title">{{ $ticket->subject }}</h5>
                                            <span class="badge badge-priority text-white">
                                                {{ $ticket->priority }}
                                            </span>
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-2">
                                            <span class="badge badge-status text-white">
                                                {{ $ticket->status }}
                                            </span>
                                        </div>

                                        <!-- Description -->
                                        <p class="text-muted small mb-3">
                                            {{ \Illuminate\Support\Str::limit($ticket->description, 120) }}
                                        </p>

                                        <!-- Footer -->
                                        <div class="mt-auto d-flex justify-content-between align-items-center">
                                            <small>
                                                <strong>Created:</strong> {{ $ticket->created_at?->format('d M Y') }}
                                            </small>

                                            <div class="d-flex gap-2">
                                                @if ($ticket->attachment)
                                                    <a href="{{ asset('support_attachments/' . $ticket->attachment) }}" class="btn btn-sm btn-outline-secondary">
                                                        File
                                                    </a>
                                                @endif

                                                <a href="{{ route('support.edit', $ticket->id) }}" class="btn btn-sm" style="background:#1d3268;color:#fff;">
                                                    Edit
                                                </a>
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
            </div>

            <div class="d-flex justify-content-end custom-pagination">
                {!! $tickets->links() !!}
            </div>
        </div>
    </div>
@endsection
