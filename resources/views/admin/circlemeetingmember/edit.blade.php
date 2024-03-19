@extends('layouts.master')

@section('header', 'City')
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
        <h5 class="card-title">Edit Circle Meeting</h5>
        <a href="{{ route('meetingmember.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circlemeetingForm" enctype="multipart/form-data" method="post"
        action="{{ route('meetingmember.update', $meetingmember->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $meetingmember->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Circle Field is required' required name="memberId"
                        id="memberId">
                        <option value="" selected disabled> Select Member </option>
                        @foreach ($member as $memberData)
                        <option value="{{ $memberData->id }}">{{ $memberData->firstName }} {{
                            $memberData->lastName }}</option>
                        @endforeach
                    </select>
                    @error('memberId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <select class="form-select" id="attandance" aria-label="attandance" name="attandance">
                        <option selected>Attandance</option>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                    </select>
                    <label for="attandance">Attandance</label>
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