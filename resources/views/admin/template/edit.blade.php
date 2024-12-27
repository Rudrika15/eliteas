@extends('layouts.master')

@section('title', 'UBN - Template')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Template</h5>
            <a href="{{ route('template.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr>
        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="callForm" enctype="multipart/form-data" method="post"
            action="{{ route('template.update', $template->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $template->id }}">



            <div class="row mb-3 mt-3">

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('templateImage') is-invalid @enderror"
                            id="templateImage" name="templateImage" accept="image/*" required onchange="previewPhoto(event)"
                            {{ ($oldtemplateImage = old('templateImage')) ? 'data-old-value="' . $oldtemplateImage . '"' : '' }}>
                        <label for="templateImage">Upload Meeting Image</label>
                        <span class="text-danger mt-1 d-block">*
                            File size:Max 2MB</span>
                        @error('templateImage')
                            <div class="invalid-tooltip">
                                The Maximum file size is 2MB
                            </div>
                        @enderror
                    </div>

                    <!-- Photo Preview Section -->
                    <div class="mt-1">
                        <img id="photoPreview"
                            src="{{ $template->templateImage ? asset('templateImage/' . $template->templateImage) : asset('img/profile.png') }}"
                            alt="Meeting Image"
                            style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
                    </div>
                </div>

                <script>
                    function previewPhoto(event) {
                        const file = event.target.files[0];
                        const preview = document.getElementById('photoPreview');

                        if (file) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.style.display = 'block'; // Show the image
                            }

                            reader.readAsDataURL(file); // Read the file as a data URL
                        }
                    }
                </script>
            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>


@endsection
