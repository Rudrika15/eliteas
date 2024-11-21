@extends('layouts.master')

@section('header', 'Slot')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Slot</h5>
            <a href="{{ route('slot.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="slotForm" enctype="multipart/form-data" method="post"
            action="{{ route('slot.store') }}" novalidate>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="startTime" name="startTime" placeholder="Start Time"
                            required>
                        <label for="startTime">Start Time</label>
                        @error('startTime')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="time" class="form-control" id="endTime" name="endTime" placeholder="End Time"
                            required>
                        <label for="endTime">End Time</label>
                        @error('endTime')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                </div>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

@endsection
