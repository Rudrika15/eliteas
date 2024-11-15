@extends('layouts.master')

@section('header', 'Conquer Event')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Conquer Events</h4>
                    <a href="{{ route('conquer.events.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Create Conquer Event</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Event Date</th>
                                <th>Event Image</th>
                                <th>UBN Fees</th>
                                <th>Outsiders Fees</th>
                                <th>Venue</th>
                                <th>Slot Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event as $eventData)
                                <tr>
                                    {{-- <td>{{ $loop->index + 1 }}</td> --}}
                                    <th>{{ ($event->currentPage() - 1) * $event->perPage() + $loop->index + 1 }}

                                    <td>{{ $eventData->title ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($eventData->event_date)->format('d-m-Y') ?? '-' }}</td>
                                    <td>
                                        @if ($eventData->eventImage)
                                            <img src="{{ url('conEventImage/' . basename($eventData->eventImage)) }}"
                                                alt="Event Image"
                                                style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td>{{ $eventData->ubn_fees ?? '-' }}</td>
                                    <td>{{ $eventData->outsiders_fees ?? '-' }}</td>
                                    <td>{{ $eventData->venue ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($eventData->slot_date)->format('d-m-Y') ?? '-' }}</td>
                                    <td>
                                        {{-- <a href="{{ route('event.eventRegisterList', $eventData->id) }}"
                                            class="btn btn-bg-orange btn-sm btn-tooltip">
                                            <i class="bi bi-eye"></i>
                                            <span class="btn-text">List of Registred User</span>
                                        </a> --}}
                                        <a href="{{ route('conquer.events.edit', $eventData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <form action="{{ route('conquer.events.delete', $eventData->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-tooltip">
                                                <i class="bi bi-trash"></i>
                                                <span class="btn-text">Delete</span>
                                                <!-- Icon for delete -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $event->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
