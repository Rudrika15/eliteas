@extends('layouts.master')

@section('title', 'UBN - Template')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Add Template Details</h5>
                <a href="{{ route('template.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>
            <hr>

            <form action="{{ route('templateDetail.store') }}" enctype="multipart/form-data" method="post" class="m-3 needs-validation" novalidate>
                @csrf

                <input type="hidden" name="templateId" value="{{ request('id') }}">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <select name="title" id="title" class="form-control" required>
                                <option selected disabled>Select title</option>
                                <option value="ProfilePhoto">Profile Photo</option>
                                <option value="title1">Title 1</option>
                                <option value="title2">Title 2</option>
                            </select>
                            <label for="title">Title</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="file" accept='image/*' onchange="previewPhoto(event)" class="form-control @error('templateIcon') is-invalid @enderror" id="templateIcon" name="templateIcon" required>
                            <label for="templateIcon">Upload Icon</label>
                            <div class="text-danger mt-1">* File size: Max 2MB</div>
                            @error('templateIcon')
                                <div class="invalid-tooltip">The Maximum file size is 2MB</div>
                            @enderror
                        </div>
                        <div class="mt-1">
                            <img id="photoPreview" src="{{ url('images/default.jpg') }}" alt="Icon Preview" style="width: 100px; height: 100px; object-fit: contain;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @php
                        $fields = [
                            'bottom' => 'Bottom',
                            'left' => 'Left',
                            'height' => 'Height',
                            'width' => 'Width',
                            'fontSize' => 'Font Size',
                            'textWidth' => 'Text Width',
                            'textLength' => 'Text Length',
                            'frameHeight' => 'Frame Height',
                        ];
                    @endphp
                    @foreach ($fields as $field => $label)
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" required>
                                <label for="{{ $field }}">{{ $label }}</label>
                            </div>
                        </div>
                    @endforeach

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="textColor">Text Color</label>
                            <input type="color" class="form-control-color form-control" id="textColor" name="textColor" required>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                </div>
            </form>

            <div class="table-responsive p-3">
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Bottom</th>
                            <th>Left</th>
                            <th>Height</th>
                            <th>Width</th>
                            <th>Font Size</th>
                            <th>Text Width</th>
                            <th>Text Color</th>
                            <th>Text Length</th>
                            <th>Frame Height</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tempDetail as $template)
                            <tr>
                                <td>{{ $template->title }}</td>

                                <td>
                                    @if ($template->templateIcon)
                                        <img src="{{ url('templateIcon/' . basename($template->templateIcon)) }}" alt="Template Icon" style="width: 100px; height: auto; border-radius: 5px;">
                                    @else
                                        <span></span>
                                    @endif
                                </td>

                                <td>{{ $template->bottom }}</td>
                                <td>{{ $template->left }}</td>
                                <td>{{ $template->height }}</td>
                                <td>{{ $template->width }}</td>
                                <td>{{ $template->fontSize }}</td>
                                <td>{{ $template->textWidth }}</td>
                                <td>{{ $template->textColor }}</td>
                                <td>{{ $template->textLength }}</td>
                                <td>{{ $template->frameHeight }}</td>
                                <td>
                                    <a href="{{ route('templateDetail.edit', $template->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                        <span class="btn-text">Edit Template Details</span>
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-tooltip" onclick="deleteRow('{{ route('templateDetail.delete', $template->id) }}')">
                                        <span class="btn-text">Delete</span>
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <script>
                                        function deleteRow(url) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#1d2856',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = url;
                                                }
                                            })
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                };
                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
