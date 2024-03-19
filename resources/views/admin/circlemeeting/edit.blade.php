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
        <a href="{{ route('circlemeeting.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circlemeetingForm" enctype="multipart/form-data" method="post"
        action="{{ route('circlemeeting.update', $circlemeeting->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $circlemeeting->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="datetime" class="form-control @error('dateTime') is-invalid @enderror" id="dateTime"
                        name="dateTime" placeholder="Date & Time" value="{{$circlemeeting->dateTime}}" required>
                    <label for="dateTime">Date & Time</label>
                    @error('dateTime')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('hotelName') is-invalid @enderror" id="hotelName"
                        name="hotelName" placeholder="Hotel Name" value="{{$circlemeeting->hotelName}}" required>
                    <label for="hotelName">Hotel Name</label>
                    @error('hotelName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('totalMeeting') is-invalid @enderror"
                        id="totalMeeting" name="totalMeeting" placeholder="Total Meeting"
                        value="{{$circlemeeting->totalMeeting}}" required>
                    <label for="totalMeeting">Total Meeting</label>
                    @error('totalMeeting')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('refGiven') is-invalid @enderror" id="refGiven"
                        name="refGiven" placeholder="Total Reference Given" value="{{$circlemeeting->refGiven}}"
                        required>
                    <label for="refGiven">Total Reference Given</label>
                    @error('refGiven')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('refTaken') is-invalid @enderror" id="refTaken"
                        name="refTaken" placeholder="Total Reference Taken" value="{{$circlemeeting->refTaken}}"
                        required>
                    <label for="refGiven">Total Reference Taken</label>
                    @error('refTaken')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('busGiven') is-invalid @enderror" id="busGiven"
                        name="busGiven" placeholder="Total Business Given" value="{{$circlemeeting->busGiven}}"
                        required>
                    <label for="busGiven">Total Business Given</label>
                    @error('busGiven')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('busTaken') is-invalid @enderror" id="busTaken"
                        name="busTaken" placeholder="Total Business Taken" value="{{$circlemeeting->busTaken}}"
                        required>
                    <label for="busTaken">Total Business Taken</label>
                    @error('busTaken')
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