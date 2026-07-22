@extends('layouts.master')
@section('header', 'Rising Stars')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">
                        Rising Stars
                    </h4>
                    <a href="{{ route('risingstar.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                        <i class="bi bi-plus-circle"></i>
                        <span class="btn-text">
                            Add Rising Star
                        </span>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Member</th>
                                <th>Title</th>
                              
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($risingStars as $risingStar)
                                <tr>
                                    <td>
                                        {{ ($risingStars->currentPage() - 1) * $risingStars->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ ($risingStar->member->firstName ?? '') . ' ' . ($risingStar->member->lastName ?? '') }}
                                    </td>
                                    <td>
                                        {{ Str::limit($risingStar->title, 25) ?? '-' }}
                                    </td>
                                    <td>
                                        @if ($risingStar->status == 'Active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Deleted
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('risingstar.edit', $risingStar->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">
                                                Edit
                                            </span>
                                        </a>
                                        <form action="{{ route('risingstar.delete', $risingStar->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-tooltip" onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                                <span class="btn-text">
                                                    Delete
                                                </span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No data found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $risingStars->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
