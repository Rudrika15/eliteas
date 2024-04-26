@extends('layouts.master')

@section('header', 'Membership Type')
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
        <h5 class="card-title">Edit Membership Type</h5>
        <a href="{{ route('membershipType.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="membershipTypeForm" enctype="multipart/form-data" method="post"
        action="{{ route('membershipType.update', $membershipType->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $membershipType->id }}">
        <div class="row mb-3">

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('membershipType') is-invalid @enderror"
                        id="membershipType" name="membershipType" value="{{ $membershipType->membershipType }}"
                        placeholder="Membership Type" required>
                    <label for="membershipType">Membership Type</label>
                    @error('membershipType')
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