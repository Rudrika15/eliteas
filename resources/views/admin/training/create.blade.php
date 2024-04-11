@extends('layouts.master')

@section('header', 'Training')
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
        <h5 class="card-title">Create Training</h5>
        <a href="{{ route('training.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="trainingForm" enctype="multipart/form-data" method="post"
        action="{{ route('training.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Trainer Name Field is required' required name="trainerId"
                        id="trainerId">
                        <option value="" selected disabled> Select Trainer </option>
                        @foreach ($trainer as $trainerData)
                        <option value="{{ $trainerData->id }}">{{ $trainerData->trainerName }}</option>
                        @endforeach
                    </select>
                    @error('trainerId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('trainerName') is-invalid @enderror"
                        id="trainerName" name="trainerName" placeholder="trainerName"
                        required>
                    <label for="trainerName">Trainer Name</label>
                    @error('trainerName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        id="title" name="title" placeholder="title"
                        required>
                    <label for="title">Title</label>
                    @error('title')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                        <option value="" selected disabled>Select Type</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>
                    {{-- <label for="type">Select Type</label> --}}
                    @error('type')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('fees') is-invalid @enderror"
                        id="fees" name="fees" placeholder="fees"
                        required>
                    <label for="fees">Fees</label>
                    @error('fees')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('venue') is-invalid @enderror"
                        id="venue" name="venue" placeholder="venue"
                        required>
                    <label for="venue">Venue</label>
                    @error('venue')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                        id="date" name="date" placeholder="date"
                        required>
                    <label for="date">Date</label>
                    @error('date')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="time" class="form-control @error('time') is-invalid @enderror"
                        id="time" name="time" placeholder="time"
                        required>
                    <label for="time">Time</label>
                    @error('time')
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