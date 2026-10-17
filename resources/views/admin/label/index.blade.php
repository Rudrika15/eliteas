@extends('layouts.master')

@section('header', 'Label Master')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Label Master</h4>
                    <a href="{{ route('label.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip">
                        <i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add New Label</span>
                    </a>
                </div>

                <!-- Search Filter Form -->
                <form method="GET" action="{{ route('label.index') }}" class="mb-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by label name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-bg-blue btn-sm">Search</button>
                            <a href="{{ route('label.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </div>
                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 80px;">S.No</th>
                                <th>Label Name</th>
                                <th>Status</th>
                                <th style="width: 180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($labels as $label)
                                <tr>
                                    <th>{{ ($labels->currentPage() - 1) * $labels->perPage() + $loop->index + 1 }}</th>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $label->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $label->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $label->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('label.edit', $label->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('label.delete', $label->id) }}"
                                           onclick="return confirm('Are you sure you want to delete this label?');"
                                           class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No Labels Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $labels->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
