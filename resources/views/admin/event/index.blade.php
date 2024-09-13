@extends('layouts.master')

@section('header', 'Event')
@section('content')


<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Events</h4>
                <a href="{{ route('event.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                        class="bi bi-plus-circle"></i>
                    <span class="btn-text">Create Event</span></a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Circle</th>
                            <th>Event Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event as $eventData)
                        <tr>
                            <td>{{$eventData->title ?? '-'}}</td>
                            <td>{{$eventData->circle->circleName ?? '-'}}</td>
                            <td>{{$eventData->event_date}}</td>
                            <td>{{$eventData->start_time}}</td>
                            <td>{{$eventData->end_time}}</td>
                            <td>{{$eventData->amount}}</td>
                            <td>
                                <a href="{{ route('event.edit', $eventData->id) }}"
                                    class="btn btn-bg-blue btn-sm btn-tooltip">
                                    <i class="bi bi-pen"></i>
                                    <span class="btn-text">Edit</span>
                                </a>

                                <form action="{{ route('event.delete', $eventData->id) }}" method="POST"
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