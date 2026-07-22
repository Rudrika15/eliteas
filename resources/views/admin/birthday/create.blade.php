@extends('layouts.master')

@section('header', 'Add Birthday')
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
                <h5 class="card-title">Add Member Birthday</h5>
                <a href="{{ route('birthday.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>

            <!-- Form -->
            <form class="m-3 needs-validation" method="POST" action="{{ route('birthday.store') }}" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select @error('member_id') is-invalid @enderror" id="member_id" name="member_id" required>
                                <option value="">Select Member</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                        {{ $member->firstName }} {{ $member->lastName }} 
                                    </option>
                                @endforeach
                            </select>
                            <label for="member_id">Member</label>
                            @error('member_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="date" class="form-control @error('birthDate') is-invalid @enderror" id="birthDate" name="birthDate" value="{{ old('birthDate') }}" required>
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
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form>
        </div>
    </div>

@endsection
