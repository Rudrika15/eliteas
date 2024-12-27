@extends('layouts.master')

@section('header', 'State')
@section('content')

    {{-- Message --}}

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">State</h4>
                    <a href="{{ route('state.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add State</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Country Name</th>
                                <th>State Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($state as $stateData)
                                <tr>
                                    <th>{{ ($state->currentPage() - 1) * $state->perPage() + $loop->index + 1 }}
                                    <td>{{ $stateData->country->countryName ?? '-' }}</td>
                                    <td>{{ $stateData->stateName }}</td>
                                    <td>{{ $stateData->status }}</td>
                                    <td>
                                        <a href="{{ route('state.edit', $stateData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                        <a href="{{ route('state.delete', $stateData->id) }}"
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
                        {!! $state->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
