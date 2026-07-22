@extends('layouts.master')

@section('header', 'Edit Birthday')
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
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit Birthday for {{ $birthday->firstName }} {{ $birthday->lastName }}</h5>
                <a href="{{ route('birthday.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>

            <!-- Form -->
            <form class="m-3 needs-validation" method="POST" action="{{ route('birthday.update', $birthday->id) }}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $birthday->id }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="memberName" value="{{ $birthday->firstName }} {{ $birthday->lastName }} ({{ $birthday->username }})" readonly disabled>
                            <label for="memberName">Member Name</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" class="form-control @error('birthDate') is-invalid @enderror" id="birthDate" name="birthDate" value="{{ old('birthDate', $birthday->birthDate) }}" required>
                            <label for="birthDate">Birth Date</label>
                            @error('birthDate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-bg-blue">Update Birthday</button>
                    <a href="{{ route('birthday.index') }}" class="btn btn-bg-orange">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection
