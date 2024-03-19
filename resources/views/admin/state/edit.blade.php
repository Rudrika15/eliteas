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
        <h5 class="card-title">Edit State</h5>
        <a href="{{ route('state.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
<form class="m-3 needs-validation" id="stateForm" enctype="multipart/form-data" method="post"
        action="{{ route('state.update', $state->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $state->id }}">f
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='State Name Field is required' required name="countryId"
                        id="countryId">
                        <option value="" selected disabled> Select Country </option>
                        @foreach ($country as $countryData)
                        <option value="{{ $countryData->id }}" {{$countryData->id == old('countryId',$state->countryId)?
                            'selected':''}}>{{ $countryData->stateName }}</option>
                        @endforeach
                    </select>
                    @error('countryId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('stateName') is-invalid @enderror" id="stateName"
                        name="stateName" value="{{$state->stateName}}" placeholder="State Name" required>
                    <label for="stateName">State Name</label>
                    @error('stateName')
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