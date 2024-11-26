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

            <div class="col-md-6">
                <div class="form-check mt-3">
                    <input class="form-check-input @error('is_slot') is-invalid @enderror" type="checkbox"
                        value="Yes" id="is_slot" name="is_slot">
                    <label class="form-check-label" for="is_slot">
                        Is Slot ?
                    </label>
                    @error('is_slot')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <select class="form-control" name="circleId" id="circleId">
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
                    <div class="form-floating mt-3">
                        <select class="form-control" name="eventTypeId" id="eventTypeId">
                            <option value="" selected disabled> Select Event Type </option>
                            @foreach ($eventType as $eventTypeData)
                                <option value="{{ $eventTypeData->id }}">{{ $eventTypeData->eventTypeName }}</option>
                            @endforeach
                        </select>
                        @error('eventTypeId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
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

                <div class="col-md-6" id="slotDateField" style="visibility: hidden;">
                    <div class="form-floating mt-3">
                        <input type="date" class="form-control @error('slot_date') is-invalid @enderror" id="slot_date"
                            name="slot_date" placeholder="Event Slot Date">
                        <label for="slot_date">Event Slot Date</label>
                        @error('slot_date')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>





                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('event_banner') is-invalid @enderror"
                            id="event_banner" name="event_banner" accept="image/*" onchange="previewPhoto2(event)" required>
                        <label for="event_banner">Event Banner</label>
                        <div class="mt-1">
                            <img id="photoPreview2" src="{{ asset('img/profile.png') }}" alt="Event Banner"
                                style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
                        </div>
                        @error('event_banner')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('event_thumb') is-invalid @enderror"
                            id="event_thumb" name="event_thumb" accept="image/*" onchange="previewPhoto(event)" required>
                        <label for="event_thumb">Event Thumb</label>
                        <div class="mt-1">
                            <img id="photoPreview1" src="{{ asset('img/profile.png') }}" alt="Event Thumb"
                                style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
                        </div>
                        @error('event_thumb')
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
                        <input type="number" class="form-control @error('fees') is-invalid @enderror" id="fees"
                            name="fees" placeholder="fees">
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
                        <textarea class="form-control @error('event_details') is-invalid @enderror" id="event_details" name="event_details"
                            placeholder="Event Details" required></textarea>
                        <label for="event_details">Event Details</label>
                        @error('event_details')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>


    <script>
        function previewPhoto(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photoPreview1');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function previewPhoto2(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photoPreview2');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script>
   document.addEventListener('DOMContentLoaded', function () {
    const isSlotCheckbox = document.getElementById('is_slot');
    const slotDateField = document.getElementById('slotDateField');
    const slotDateInput = document.getElementById('slot_date');

    // Function to toggle visibility of slot date field and clear its value
    function toggleSlotDateField() {
        if (isSlotCheckbox.checked) {
            slotDateField.style.visibility = 'visible'; // Make the slot date field visible and reserve its space
        } else {
            slotDateField.style.visibility = 'hidden'; // Make the slot date field hidden but still reserve its space
            slotDateInput.value = ''; // Clear the value of the slot date input
        }
    }

    // Call the function on page load to ensure it's in the correct state
    toggleSlotDateField();

    // Add an event listener to the checkbox to handle changes
    isSlotCheckbox.addEventListener('change', toggleSlotDateField);
});
    </script>


@endsection
