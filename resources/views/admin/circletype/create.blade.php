@extends('layouts.master')

@section('header', 'Circle Type')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif


<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Circle Type</h5>
        <a href="{{ route('circletype.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circletypeForm" enctype="multipart/form-data" method="post"
        action="{{ route('circletype.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="circleTypeName" name="circleTypeName">
                        <option selected disabled>Select Type</option>
                        <option value="1">Online</option>
                        <option value="2">Offline</option>
                        <option value="3">Hybrid</option>
                    </select>
                    {{-- <label for="circleTypeName">Select Type</label> --}}
                    @error('circleTypeName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection