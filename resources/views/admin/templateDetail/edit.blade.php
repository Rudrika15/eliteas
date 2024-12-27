@extends('layouts.master')

@section('title', 'UBN - Template')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit Template Detail</h5>
                <a href="{{ route('template.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>
            <hr>

            <!-- Add padding around the form -->
            <form action="{{ route('templateDetail.update') }}" enctype="multipart/form-data" method="post" class="p-4">
                @csrf
                <input type="hidden" name="templateDetailId" id="id" value="{{ $template->id }}">

                <div class="form-floating mb-3">
                    <select name="title" id="title" class="form-control">
                        <option selected disabled>Select title</option>
                        <option value="email" {{ old('title', $template->title) === 'email' ? 'selected' : '' }}>Email
                        </option>
                        <option value="location" {{ old('title', $template->title) === 'location' ? 'selected' : '' }}>
                            Location</option>
                        <option value="contact" {{ old('title', $template->title) === 'contact' ? 'selected' : '' }}>Contact
                        </option>
                        <option value="website" {{ old('title', $template->title) === 'website' ? 'selected' : '' }}>Website
                        </option>
                    </select>
                    <label for="title">Title</label>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="file" class="form-control @error('templateIcon') is-invalid @enderror"
                            id="templateIcon" name="templateIcon" value="{{ $template->templateIcon }}" accept="image/*"
                            onchange="previewPhoto(event)"
                            {{ ($oldtemplateIcon = old('templateIcon')) ? 'data-old-value="' . $oldtemplateIcon . '"' : '' }}>
                        <label for="templateIcon">Upload Template Icon</label>
                        <span class="text-danger mt-1 d-block">*
                            File size:Max 2MB</span>
                        @error('templateIcon')
                            <div class="invalid-tooltip">
                                The Maximum file size is 2MB
                            </div>
                        @enderror
                    </div>

                    <!-- Photo Preview Section -->
                    <div class="mt-1">
                        <img id="photoPreview"
                            src="{{ $template->templateIcon ? asset('templateIcon/' . $template->templateIcon) : asset('img/profile.png') }}"
                            alt="Template Icon"
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

                <div class="form-floating mb-3 mt-3">
                    <input type="text" class="form-control" id="bottom" name="bottom"
                        value="{{ $template->bottom }}" required>
                    <label for="bottom">Bottom</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="left" name="left" value="{{ $template->left }}"
                        required>
                    <label for="left">Left</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="height" name="height"
                        value="{{ $template->height }}" required>
                    <label for="height">Height</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="width" name="width" value="{{ $template->width }}"
                        required>
                    <label for="width">Width</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="fontSize" name="fontSize"
                        value="{{ $template->fontSize }}" required>
                    <label for="fontSize">Font Size</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="textWidth" name="textWidth"
                        value="{{ $template->textWidth }}" required>
                    <label for="textWidth">Text Width</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="textLength" name="textLength"
                        value="{{ $template->textLength }}" required>
                    <label for="textLength">Text Length</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="frameHeight" name="frameHeight"
                        value="{{ $template->frameHeight }}" required>
                    <label for="frameHeight">Frame Height</label>
                </div>

                <div class="mb-3">
                    <label for="textColor">Text Color</label>
                    <input type="color" class="form-control form-control-color" id="textColor" name="textColor"
                        value="{{ $template->textColor }}" required>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-bg-blue btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function readURL(input, tgt) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector(tgt).setAttribute("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

@endsection
