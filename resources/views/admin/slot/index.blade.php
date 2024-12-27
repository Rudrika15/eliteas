@extends('layouts.master')

@section('header', 'Slot')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Slot</h4>
                    <a href="{{ route('slot.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add New Slot</span>
                    </a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slot as $slotData)
                                <tr>
                                    <th>{{ ($slot->currentPage() - 1) * $slot->perPage() + $loop->index + 1 }}
                                    <td>{{ $slotData->start_time }}</td>
                                    <td>{{ $slotData->end_time }}</td>
                                    <td>{{ $slotData->status }}</td>
                                    <td>
                                        <a href="{{ route('slot.edit', $slotData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('slot.delete', $slotData->id) }}"
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
                        {!! $slot->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
