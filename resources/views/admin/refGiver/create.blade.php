@extends('layouts.master')

@section('header', 'Circle Meeting Member Refference')
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
        <h5 class="card-title">Circle Meeting Member Refference</h5>
        <a href="{{ route('refGiver.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="post"
        action="{{ route('refGiver.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Circle Meeting Field is required' required name="memberId"
                        id="memberId">
                        <option value="" selected disabled> Select Circle Member </option>
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
                <div class="form-floating mt-6">
                    <input type="text" class="form-control @error('referenceGiver') is-invalid @enderror"
                        id="referenceGiver" name="referenceGiver" placeholder="Reference Giver" required>
                    <label for="referenceGiver">Reference Giver</label>
                    @error('referenceGiver')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('contactName') is-invalid @enderror" id="contactName"
                        name="contactName" placeholder="Contact Name" required>
                    <label for="contactName">Contact Person Name</label>
                    @error('contactName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="contactNo"
                        name="contactNo" placeholder="Contact No" required>
                    <label for="contactNo">Contact No</label>
                    @error('contactNo')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        placeholder="email" required>
                    <label for="email">Email</label>
                    @error('email')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('scale') is-invalid @enderror" id="scale" name="scale"
                        placeholder="scale" required>
                    <label for="scale">Scale [1-5]</label>
                    @error('scale')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                        name="description" placeholder="description" required>
                    <label for="description">Description</label>
                    @error('description')
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