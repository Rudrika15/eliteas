@extends('layouts.master')

@section('header', 'Event')
@section('content')



<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Event</h5>
        <a href="{{ route('event.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="eventForm" enctype="multipart/form-data" method="post"
        action="{{ route('event.store') }}" novalidate>
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" name="circleId"
                        id="circleId">
                        <option value="" selected disabled> Select Circle </option>
                        @foreach ($circle as $circlesData)
                        <option value="{{ $circlesData->id }}">{{ $circlesData->circleName }}</option>
                        @endforeach
                    </select>
                    @error('circleId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" placeholder="Title" required>
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
                    <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue"
                        name="venue" placeholder="venue" required>
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
                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date"
                        name="event_date" placeholder="Event Date" required>
                    <label for="event_date">Event Date</label>
                    @error('event_date')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                        name="start_time" placeholder="Start Time" required>
                    <label for="start_time">Start Time</label>
                    @error('start_time')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                        name="end_time" placeholder="End Time" required>
                    <label for="end_time">End Time</label>
                    @error('end_time')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                        name="amount" placeholder="amount" required>
                    <label for="amount">Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


        </div>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection