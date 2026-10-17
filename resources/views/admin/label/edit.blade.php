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

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Label</h5>
            <a href="{{ route('label.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <form class="m-3 needs-validation" id="labelForm" method="post" action="{{ route('label.update', $label->id) }}" novalidate>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Label Name" value="{{ old('name', $label->name) }}" required>
                        <label for="name">Label Name <span class="text-danger">*</span></label>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="Active" {{ old('status', $label->status) == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('status', $label->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <label for="status">Status</label>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue">Update</button>
                <a href="{{ route('label.index') }}" class="btn btn-bg-orange">Cancel</a>
            </div>
        </form>
    </div>

@endsection
