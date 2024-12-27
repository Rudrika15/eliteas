@extends('layouts.master')

@section('header', 'Permission')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Permission</h4>
                    <a href="{{ route('permission.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Permission</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Permission Name</th>
                                <th>Heading</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permissionsData)
                                <tr>
                                    <th>{{ ($permissions->currentPage() - 1) * $permissions->perPage() + $loop->index + 1 }}
                                    <td>{{ $permissionsData->name ?? '-' }}</td>
                                    <td>{{ $permissionsData->heading }}</td>
                                    <td>
                                        <a href="{{ route('permission.edit', $permissionsData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        {{-- <a href="{{ route('permission.show', $permissionsData->id) }}" class="btn btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a> --}}

                                        <a href="{{ route('permission.delete', $permissionsData->id) }}"
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
                        {!! $permissions->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
