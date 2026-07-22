@extends('layouts.master')

@section('header', 'Birthday Management')
@section('content')

    <div class="container">

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h4 class="card-title mb-0">Member Birthdays</h4>
                    
                    <div class="d-flex align-items-center gap-2">
                        <form method="GET" action="{{ route('birthday.index') }}" class="d-flex me-2">
                            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search Member..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i></button>
                            @if(request('search'))
                                <a href="{{ route('birthday.index') }}" class="btn btn-secondary btn-sm ms-1"><i class="bi bi-x-circle"></i></a>
                            @endif
                        </form>

                        <a href="{{ route('birthday.create') }}" class="btn btn-bg-orange btn-sm btn-tooltip">
                            <i class="bi bi-plus-circle"></i>
                            <span class="btn-text">Add Birthday</span>
                        </a>
                    </div>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Member Name</th>
                                <th>Birth Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($birthday as $memberData)
                                <tr>
                                    <td>{{ ($birthday->currentPage() - 1) * $birthday->perPage() + $loop->index + 1 }}</td>
                                    
                                    <td>
                                        <strong>{{ $memberData->firstName }} {{ $memberData->lastName }}</strong>
                                       
                                    </td>
                                
                                    <td>
                                        @if ($memberData->birthDate)
                                            <span class="badge bg-success font-monospace" style="font-size: 0.9rem;">
                                                <i class="bi bi-cake2 me-1"></i>{{ \Carbon\Carbon::parse($memberData->birthDate)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Not Set</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($memberData->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">{{ $memberData->status ?? 'Inactive' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('birthday.edit', $memberData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        @if ($memberData->birthDate)
                                            <a href="{{ route('birthday.delete', $memberData->id) }}" class="btn btn-danger btn-sm btn-tooltip" onclick="return confirm('Are you sure you want to remove birthday for this member?')">
                                                <i class="bi bi-trash"></i>
                                                <span class="btn-text">Remove</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No members found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $birthday->appends(request()->input())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
