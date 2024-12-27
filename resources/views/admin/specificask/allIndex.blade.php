@extends('layouts.master')

@section('header', 'Circle')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Specific Asks by All Members</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('specificask.index') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Cards -->
        <div class="row mt-4">
            @forelse ($specificasks as $specificask)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center" style="border-top: 4px solid #e76a35;">
                            <h6 class="card-title font-weight-bold" style="color: #1d3268;">
                                {{ $specificask->users->firstName ?? 'N/A' }} {{ $specificask->users->lastName ?? '' }}
                            </h6>
                            <p class="card-text text-muted small">
                                <strong>Ask:</strong> {{ $specificask->ask ?? 'No ask available' }}
                            </p>
                            {{-- <a href="#" class="btn btn-sm text-white" style="background-color: #e76a35;">View
                                Details</a> --}}
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No specific asks found.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        {{-- @if ($specificasks->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $specificasks->links('pagination::bootstrap-4') }}
            </div>
        @endif --}}
    </div>

@endsection
