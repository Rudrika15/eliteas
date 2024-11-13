@extends('layouts.master')

@section('header', 'Permission')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Specific Ask</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('specificask.allIndex') }}" class="btn btn-bg-blue btn-sm mt-3 btn-tooltip">View
                            Asks
                            by
                            Others</a>&nbsp;&nbsp;&nbsp;
                        <a href="{{ route('specificask.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                                class="bi bi-plus-circle"></i>
                            <span class="btn-text">Add Specific Ask</span></a>
                    </div>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                {{-- <th>Ask By</th> --}}
                                <th>Asks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($specificasks as $specificaskData)
                                <tr>
                                    <th>{{ ($specificasks->currentPage() - 1) * $specificasks->perPage() + $loop->index + 1 }}
                                        {{-- <td>{{ $specificaskData->users->firstName ?? '-' }}
                                        {{ $specificaskData->users->lastName ?? '-' }}</td> --}}
                                    <td>{{ $specificaskData->ask ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('specificask.edit', $specificaskData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>
                                        <a href="{{ route('specificask.delete', $specificaskData->id) }}"
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
                        {!! $specificasks->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
