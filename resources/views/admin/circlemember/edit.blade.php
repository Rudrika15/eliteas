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
        <h5 class="card-title">Edit Circle Member</h5>
        <a href="{{ route('circlemember.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circlememberForm" enctype="multipart/form-data" method="post"
        action="{{ route('circlemember.update', $circlemember->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $circlemember->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Circle Name Field is required' required name="circleId"
                        id="circleId">
                        <option value="" selected disabled> Select Circle </option>
                        @foreach ($circle as $circleData)
                        <option value="{{ $circleData->id }}" {{$circleData->id ==
                            old('circleId',$circleData->circleId)?
                            'selected':''}}>{{ $circleData->circleName }}</option>
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
                    <select class="form-control" data-error='Member Name Field is required' required name="memberId"
                        id="memberId">
                        <option value="" selected disabled> Select Member </option>
                        @foreach ($circle as $circleData)
                        <option value="{{ $circleData->id }}" {{$circleData->id ==
                            old('circleId',$circleData->circleId)?
                            'selected':''}}>{{ $circleData->circleName }}</option>
                        @endforeach
                    </select>
                    @error('circleId')
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