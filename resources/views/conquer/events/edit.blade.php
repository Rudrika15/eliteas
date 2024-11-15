@extends('layouts.master')

@section('header', 'Event')
@section('content')



    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Event</h5>
            <a href="{{ route('conquer.events.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="eventForm" enctype="multipart/form-data" method="post"
            action="{{ route('conquer.events.update', $event->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $event->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating ">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" placeholder="Title" value="{{ $event->title }}" required>
                        <label for="title">Title</label>
                        @error('title')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control @error('event_date') is-invalid @enderror" id="event_date"
                            name="event_date" placeholder="Event Date" value="{{ $event->event_date }}" required>
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
                        <input type="date" class="form-control @error('slot_date') is-invalid @enderror" id="slot_date"
                            name="slot_date" placeholder="Event Date" value="{{ $event->slot_date }}" required>
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
                        <input type="text" class="form-control @error('venue') is-invalid @enderror" id="venue"
                            name="venue" placeholder="venue" value="{{ $event->venue }}" required>
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
                        <input type="number" class="form-control @error('ubn_fees') is-invalid @enderror" id="ubn_fees"
                            name="ubn_fees" placeholder="ubn_fees" value="{{ $event->ubn_fees }}" required>
                        <label for="ubn_fees">UBN Fees</label>
                        @error('ubn_fees')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="number" class="form-control @error('outsiders_fees') is-invalid @enderror"
                            id="outsiders_fees" name="outsiders_fees" placeholder="outsiders_fees"
                            value="{{ $event->outsiders_fees }}" required>
                        <label for="outsiders_fees">Outsiders Fees</label>
                        @error('outsiders_fees')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>



            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('eventImage') is-invalid @enderror" id="eventImage"
                            name="eventImage" accept="image/*" onchange="previewPhoto(event)"
                            {{ ($eventImage = $event->eventImage) ? 'data-old-value="' . $eventImage . '"' : '' }}>
                        <label for="eventImage">Event Image</label>
                        <div class="mt-1">
                            <img id="photoPreview"
                                src="{{ $eventImage ? asset('conEventImage/' . $eventImage) : asset('img/profile.png') }}"
                                alt="Event Image"
                                style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
                        </div>
                        <span style="color: red;">*Max Upload Size is 2 MB</span> <br>
                        <span style="color: red;">*Must Upload 500x300 Image</span>


                        @error('eventImage')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <textarea class="form-control @error('event_details') is-invalid @enderror" id="event_details" name="event_details"
                            placeholder="Event Details" required> {{ $event->event_details }} </textarea>
                        <label for="event_details">Event Details</label>
                        @error('event_details')
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

    <script>
        function previewPhoto(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photoPreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

@endsection
