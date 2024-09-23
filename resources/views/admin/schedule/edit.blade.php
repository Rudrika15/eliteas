@extends('layouts.master')

@section('header', 'Schedule')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Edit Schedule</h5>
        <a href="{{ route('schedule.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="scheduleForm" enctype="multipart/form-data" method="post"
        action="{{ route('schedule.update', $schedules->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $schedules->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('circleId') is-invalid @enderror" id="circleId"
                        name="circleId" value="{{ $schedules->circle->circleName }}" placeholder="circleId" readonly>
                    <label for="circleId">Circle Name</label>
                    @error('circleId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select" id="day" name="day">
                        <option value="0" {{ old('day', $schedules->day) == 0 ? 'selected' : '' }}>Sunday</option>
                        <option value="1" {{ old('day', $schedules->day) == 1 ? 'selected' : '' }}>Monday</option>
                        <option value="2" {{ old('day', $schedules->day) == 2 ? 'selected' : '' }}>Tuesday</option>
                        <option value="3" {{ old('day', $schedules->day) == 3 ? 'selected' : '' }}>Wednesday</option>
                        <option value="4" {{ old('day', $schedules->day) == 4 ? 'selected' : '' }}>Thursday</option>
                        <option value="5" {{ old('day', $schedules->day) == 5 ? 'selected' : '' }}>Friday</option>
                        <option value="6" {{ old('day', $schedules->day) == 6 ? 'selected' : '' }}>Saturday</option>
                    </select>
                    {{-- <input type="text" class="form-control @error('day') is-invalid @enderror" id="day" name="day"
                        placeholder="Day" value="{{ $schedules->day }}" readonly> --}}
                    <label for="day">Day</label>
                    @error('day')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                        placeholder="Date" value="{{ $schedules->date }}">
                    <label for="date">Date</label>
                    @error('date')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue" name="venue"
                        placeholder="Venue" value="{{ $schedules->venue }}">
                    <label for="venue">Venue</label>
                    @error('venue')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="time" class="form-control @error('meetingTime') is-invalid @enderror" id="meetingTime"
                        name="meetingTime" placeholder="Meeting Time" value="{{ $schedules->meetingTime }}">
                    <label for="meetingTime">Meeting Time</label>
                    @error('meetingTime')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="form-floating">
                    <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks"
                        name="remarks" placeholder="Remarks" value="{{ $schedules->remarks }}">
                    <label for="remarks">Remarks</label>
                    @error('remarks')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            {{-- <button type="reset" class="btn btn-bg-orange">Reset</button> --}}
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection