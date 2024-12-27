@extends('layouts.master')

@section('header', 'Help')
@section('content')

    {{-- Message --}}
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Help</h5>
            <a href="{{ route('help.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="helpForm" enctype="multipart/form-data" method="post" action="{{ route('help.update', $help->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $help->id }}">

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{ $help->title }}" required>
                        <label for="title">Title</label>
                        @error('title')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" value="{{ old('photo', $help->photo) }}">
                    <!-- Display existing photo preview -->
                    <img id="photoPreview" src="{{ $help->photo ? asset('help/' . $help->photo) : '' }}" class="mt-2" width="100px" height="100px" style="display: {{ $help->photo ? '' : 'none' }};">
                    @error('photo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="video" class="form-label">Video</label>
                    <input type="file" class="form-control @error('video') is-invalid @enderror" id="video" name="video" accept="video/*" value="{{ old('video', $help->video) }}">
                    <!-- Display existing video preview -->
                    <video id="videoPreview" class="mt-2" width="100px" height="100px" controls style="display: {{ $help->video ? '' : 'none' }};">
                        <source src="{{ $help->video ? asset('help/' . $help->video) : '' }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @error('video')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" style="height: 100px" required>{{ old('description', $help->description) }}</textarea>
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

@endsection

@section('scripts')
    <script>
        // Preview photo
        document.getElementById("photo").addEventListener("change", function(e) {
            const photoPreview = document.getElementById("photoPreview");
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    photoPreview.src = event.target.result;
                    photoPreview.style.display = "block"; // Show the preview
                };
                reader.readAsDataURL(file);
            } else {
                photoPreview.style.display = "none"; // Hide the preview if no file is selected
            }
        });

        // Preview video
        document.getElementById("video").addEventListener("change", function(e) {
            const videoPreview = document.getElementById("videoPreview");
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    videoPreview.src = event.target.result;
                    videoPreview.style.display = "block"; // Show the preview
                };
                reader.readAsDataURL(file);
            } else {
                videoPreview.style.display = "none"; // Hide the preview if no file is selected
            }
        });
    </script>
@endsection
