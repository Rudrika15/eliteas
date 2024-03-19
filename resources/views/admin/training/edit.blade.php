@extends('layouts.master')

@section('header', 'State')
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
        <h5 class="card-title">Edit Training</h5>
        <a href="{{ route('training.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
<form class="m-3 needs-validation" id="trainingForm" enctype="multipart/form-data" method="post"
        action="{{ route('training.update', $training->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $training->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Trainer Name Field is required' required name="trainerId"
                        id="trainerId">
                        <option value="" selected disabled> Select Trainer </option>
                        @foreach ($trainer as $trainerData)
                        <option value="{{ $trainerData->id }}" {{$trainerData->id == old('trainerId',$trainerData->trainerId)?
                            'selected':''}}>{{ $trainerData->trainerName }}</option>
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
                    <input type="text" class="form-control @error('topic') is-invalid @enderror" id="topic"
                        name="topic" value="{{$training->topic}}" placeholder="Topic Name" required>
                    <label for="topic">Topic Name</label>
                    @error('topic')
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