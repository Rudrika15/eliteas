@extends('layouts.master')

@section('header', 'Train Master')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Event Type</h5>
            <a href="{{ route('eventType.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="eventTypeForm" enctype="multipart/form-data" method="post"
            action="{{ route('eventType.update', $eventType->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $eventType->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="eventTypeName" name="eventTypeName"
                            placeholder="Event Type Name" value="{{ $eventType->eventTypeName }}" required>
                        <label for="eventTypeName">Event Type Name</label>
                        @error('eventTypeName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('eventTypeName')
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
