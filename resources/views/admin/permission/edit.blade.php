@extends('layouts.master')

@section('header', 'Permission')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Permission</h5>
            <a href="{{ route('permission.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="permissionForm" method="post"
            action="{{ route('permission.update', $permission->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $permission->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $permission->name ?? '-' }}" placeholder="Permission Name" required>
                        <label for="name">Permission Name</label>
                        @error('name')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('heading') is-invalid @enderror" id="heading"
                            name="heading" value="{{ $permission->heading ?? '-' }}" placeholder="Permission Heading">
                        <label for="heading">Permission Heading</label>
                        @error('heading')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>


@endsection
