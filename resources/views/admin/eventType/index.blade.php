@extends('layouts.master')

@section('header', 'Trainer Master')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Event Type</h4>
                    <a href="{{ route('eventType.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add New Event Type</span>
                    </a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Event Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($eventType as $eventTypeData)
                                <tr>
                                    <th>{{ ($eventType->currentPage() - 1) * $eventType->perPage() + $loop->index + 1 }}
                                    <td>{{ $eventTypeData->eventTypeName }}</td>
                                    <td>{{ $eventTypeData->status }}</td>
                                    <td>
                                        <a href="{{ route('eventType.edit', $eventTypeData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('eventType.delete', $eventTypeData->id) }}"
                                            class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $eventType->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
