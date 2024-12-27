@extends('layouts.master')

@section('header', 'Help')
@section('content')

    {{-- Message --}}

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Help</h5>
            <a href="{{ route('help.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="helpForm" enctype="multipart/form-data" method="post" action="{{ route('help.store') }}" novalidate>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" required>
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
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*" required onchange="previewImage(event, 'photoPreview')">
                    <img id="photoPreview" class="mt-2" width="100px" height="100px" src="#" alt="Photo Preview" style="display: none;">
                    @error('photo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="video" class="form-label">Video</label>
                    <input type="file" class="form-control @error('video') is-invalid @enderror" id="video" name="video" accept="video/*" required onchange="previewVideo(event, 'videoPreview')">
                    <video id="videoPreview" class="mt-2" width="100px" height="100px" controls style="display: none;">
                        <source src="#" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    @error('video')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <script>
                    function previewImage(event, previewId) {
                        var reader = new FileReader();
                        reader.onload = function() {
                            var output = document.getElementById(previewId);
                            output.src = reader.result;
                            output.style.display = 'block';
                        };
                        reader.readAsDataURL(event.target.files[0]);
                    }

                    function previewVideo(event, previewId) {
                        var video = document.getElementById(previewId);
                        var source = video.getElementsByTagName('source')[0];
                        source.src = URL.createObjectURL(event.target.files[0]);
                        video.style.display = 'block';
                        video.load();
                    }
                </script>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description" style="height: 100px" required></textarea>
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
