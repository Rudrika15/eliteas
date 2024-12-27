@extends('layouts.master')

@section('header', 'Slot')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Slot</h5>
            <a href="{{ route('slot.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="slotForm" enctype="multipart/form-data" method="post"
            action="{{ route('slot.update', $slot->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $slot->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="start_time" name="start_time"
                            placeholder="Start Time" value="{{ old('start_time', $slot->start_time) }}" required>
                        <label for="start_time">Start Time</label>
                        @error('start_time')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="end_time" name="end_time" placeholder="End Time"
                            value="{{ old('end_time', $slot->end_time) }}" required>
                        <label for="end_time">End Time</label>
                        @error('end_time')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

@endsection
