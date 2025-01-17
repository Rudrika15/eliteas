@extends('layouts.master')

@section('header', 'User Help')
@section('content')

    {{-- Message --}}
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Help</h4>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Video</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($help->count() > 0)
                                @foreach ($help as $helpData)
                                    <tr>
                                        <th>{{ ($help->currentPage() - 1) * $help->perPage() + $loop->index + 1 }}</th>
                                        <td>{{ $helpData->title ?? '' }}</td>
                                        <td>
                                            @if ($helpData->photo)
                                                <img src="{{ asset('help/' . $helpData->photo) }}" alt="Photo Preview" width="100" height="100" style="object-fit: cover;" class="clickable-image" data-image="{{ asset('help/' . $helpData->photo) }}">
                                            @else
                                                <span>No photo available</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($helpData->video)
                                                <video width="100" height="100" controls class="clickable-video" data-video="{{ asset('help/' . $helpData->video) }}">
                                                    <source src="{{ asset('help/' . $helpData->video) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <span>No video available</span>
                                            @endif
                                        </td>
                                        <td>{{ $helpData->description ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Coming soon</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $help->links() !!}
                    </div>
                </div>
                <!-- End Table with stripped rows -->

                <!-- Media Preview Container -->
                <div id="mediaPreviewContainer" class="mt-4">
                    <!-- Image or Video content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Show Image in Preview Container
        document.querySelectorAll('.clickable-image').forEach(image => {
            image.addEventListener('click', function() {
                var imageUrl = this.getAttribute('data-image');
                var mediaPreviewContainer = document.getElementById('mediaPreviewContainer');

                // Clear previous content in the container
                mediaPreviewContainer.innerHTML = '';

                // Add the image to the preview container
                var imgElement = document.createElement('img');
                imgElement.src = imageUrl;
                imgElement.classList.add('img-fluid');
                imgElement.alt = 'Image Preview';

                mediaPreviewContainer.appendChild(imgElement);
            });
        });

        // Play Video in Preview Container
        document.querySelectorAll('.clickable-video').forEach(video => {
            video.addEventListener('click', function() {
                var videoUrl = this.getAttribute('data-video');
                var mediaPreviewContainer = document.getElementById('mediaPreviewContainer');

                // Clear previous content in the container
                mediaPreviewContainer.innerHTML = '';

                // Add the video to the preview container
                var videoElement = document.createElement('video');
                videoElement.width = '100%';
                videoElement.height = 'auto';
                videoElement.controls = true;

                var sourceElement = document.createElement('source');
                sourceElement.src = videoUrl;
                sourceElement.type = 'video/mp4';

                videoElement.appendChild(sourceElement);
                mediaPreviewContainer.appendChild(videoElement);
            });
        });
    </script>
@endsection
