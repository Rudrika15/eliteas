@extends('layouts.master')

@section('header', 'Event')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Events</h4>
                </div>

                <input type="hidden" id="visitorId" value="{{ session('visitor_id') }}">

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Circle</th>
                                <th>Event Date</th>
                                <th>Slot Date</th>
                                <th>Event Image</th>
                                <th>Event Banner</th>
                                <th>Venue</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Fees</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event as $eventData)
                                <tr>
                                    {{-- <td>{{ $loop->index + 1 }}</td> --}}
                                    <th>{{ ($event->currentPage() - 1) * $event->perPage() + $loop->index + 1 }}

                                    <td>{{ $eventData->title ?? '-' }}</td>
                                    <td>{{ $eventData->circle->circleName ?? '-' }}</td>
                                    <td>{{ $eventData->event_date }}</td>
                                    <td>{{ $eventData->slot_date }}</td>
                                    <td>
                                        @if ($eventData->event_thumb)
                                            <img src="{{ url('Event/' . basename($eventData->event_thumb)) }}"
                                                alt="Event Image"
                                                style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($eventData->event_banner)
                                            <img src="{{ url('Event/' . basename($eventData->event_banner)) }}"
                                                alt="Event Banner"
                                                style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td>{{ $eventData->venue }}</td>
                                    <td>{{ $eventData->start_time }}</td>
                                    <td>{{ $eventData->end_time }}</td>
                                    <td>{{ $eventData->fees }}</td>

                                    <td>
                                        <input type="hidden" id="visitorId" value="{{ session('visitor_id') }}">
                                        <a href="{{ route('memberSlotBooking.list', $eventData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-list"></i>
                                            <span class="btn-text">Slot Booking Requests</span>
                                        </a>
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
