@extends('layouts.master')

@section('header', 'Resources')
@section('content')

    {{-- Message --}}
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Resources</h4>
                </div>

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ empty($selectedCategoryId) ? 'active' : '' }}" href="{{ route('help.userView') }}" style="{{ empty($selectedCategoryId) ? 'background-color: #e76a35; color: white;' : 'color: #1d2856;' }}">
                            Show All
                        </a>
                    </li>
                    @foreach ($categories ?? [] as $category)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link {{ (string) ($selectedCategoryId ?? '') === (string) $category->id ? 'active' : '' }}" href="{{ route('help.userView', ['resourceCatId' => $category->id]) }}" style="{{ (string) ($selectedCategoryId ?? '') === (string) $category->id ? 'background-color: #e76a35; color: white;' : 'color: #1d2856;' }}">
                                {{ $category->categoryName }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>Video</th>
                                <th>PDF</th>
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
                                                <img src="{{ asset('help/' . $helpData->photo) }}" alt="Photo Preview" width="100" height="100" style="object-fit: cover; cursor: pointer;" class="clickable-image" data-image="{{ asset('help/' . $helpData->photo) }}" data-bs-toggle="modal" data-bs-target="#imageModal">
                                            @else
                                                <span>No photo available</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($helpData->video)
                                                <button type="button" class="btn btn-primary btn-sm play-video-btn" data-video="{{ asset('help/' . $helpData->video) }}" data-bs-toggle="modal" data-bs-target="#videoModal">
                                                    Play Video
                                                </button>
                                            @else
                                                <span>No video available</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($helpData->pdf)
                                                <button type="button" class="btn btn-info btn-sm view-pdf-btn" data-pdf="{{ asset('help/' . $helpData->pdf) }}" data-bs-toggle="modal" data-bs-target="#pdfModal">
                                                    View PDF
                                                </button>
                                            @else
                                                <span>No PDF available</span>
                                            @endif
                                        </td>
                                        <td>{{ $helpData->description ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Coming soon</td>
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
                    <!-- Image content will be loaded here -->
                </div>

                <!-- Modals -->
                <!-- Image Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center p-0">
                                <img id="modalImagePreview" src="" class="img-fluid" alt="Full Preview">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Modal (Plyr) -->
                <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="videoModalLabel">Video Player</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0">
                                <video id="plyr-video-player" playsinline controls>
                                    <source src="" type="video/mp4" />
                                </video>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PDF Modal (PDF.js) -->
                <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document" style="height: 90vh;">
                        <div class="modal-content h-100">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pdfModalLabel">PDF Viewer</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0 d-flex flex-column" style="background: #525659; overflow: hidden;">
                                <!-- PDF Toolbar -->
                                <div class="pdf-toolbar d-flex justify-content-between align-items-center p-2 text-white" style="background: #323639;">
                                    <div>
                                        <button class="btn btn-sm btn-secondary" id="pdf-prev">Previous</button>
                                        <button class="btn btn-sm btn-secondary" id="pdf-next">Next</button>
                                        <span class="ms-2">Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-secondary" id="pdf-zoom-out">-</button>
                                        <span class="mx-2" id="pdf-scale-display">100%</span>
                                        <button class="btn btn-sm btn-secondary" id="pdf-zoom-in">+</button>
                                    </div>
                                </div>
                                <!-- PDF Canvas Container -->
                                <div id="pdf-render-container" style="overflow: auto; flex: 1; text-align: center; padding: 20px;">
                                    <canvas id="pdf-render"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles for Plyr and Custom -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <style>
        .pdf-toolbar button {
            background-color: #555;
            border: none;
        }

        .pdf-toolbar button:hover {
            background-color: #777;
        }

        #pdf-render {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            max-width: 100%;
        }
    </style>

@endsection

@section('scripts')
    <!-- Plyr JS -->
    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Shared close handler
            function handleModalClose(modalId) {
                var modalEl = document.getElementById(modalId);
                if (modalEl) {
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                }
            }

            // Image Modal Logic
            const imageModal = document.getElementById('imageModal');
            imageModal.addEventListener('show.bs.modal', function(event) {
                const triggerElement = event.relatedTarget;
                const imageUrl = triggerElement.getAttribute('data-image');
                const modalImage = document.getElementById('modalImagePreview');
                modalImage.src = imageUrl;
            });
            imageModal.addEventListener('hidden.bs.modal', function() {
                const modalImage = document.getElementById('modalImagePreview');
                modalImage.src = '';
            });
        });

        // --- Plyr Video Player Setup ---
        const player = new Plyr('#plyr-video-player', {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
            // Disable download button in controls
            listeners: {
                seek: function(e) {
                    return true;
                }
            }
        });

        // Handle Play Video Click
        document.querySelectorAll('.play-video-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const videoUrl = this.dataset.video;
                player.source = {
                    type: 'video',
                    sources: [{
                        src: videoUrl,
                        type: 'video/mp4',
                    }, ],
                };
                // Wait for source to update then play
                setTimeout(() => player.play(), 100);
            });
        });

        // Stop video on modal close
        const videoModalEl = document.getElementById('videoModal');
        if (videoModalEl) {
            videoModalEl.addEventListener('hidden.bs.modal', function() {
                player.stop();
            });
        }


        // --- PDF.js Setup ---
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.0, // Initial scale
            canvas = document.getElementById('pdf-render'),
            ctx = canvas.getContext('2d');

        /**
         * Get page info from document, resize canvas accordingly, and render page.
         * @param num Page number.
         */
        function renderPage(num) {
            pageRendering = true;
            // Fetch page
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({
                    scale: scale
                });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                // Render PDF page into canvas context
                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);

                // Wait for render to finish
                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        // New page rendering is pending
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            // Update page counters
            document.getElementById('page-num').textContent = num;
            document.getElementById('pdf-scale-display').textContent = Math.round(scale * 100) + '%';
        }

        /**
         * If another page rendering in progress, waits until the rendering is
         * finised. Otherwise, executes rendering immediately.
         */
        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        /**
         * Displays previous page.
         */
        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('pdf-prev').addEventListener('click', onPrevPage);

        /**
         * Displays next page.
         */
        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('pdf-next').addEventListener('click', onNextPage);

        /**
         * Zoom controls
         */
        document.getElementById('pdf-zoom-in').addEventListener('click', function() {
            scale += 0.25;
            renderPage(pageNum);
        });

        document.getElementById('pdf-zoom-out').addEventListener('click', function() {
            if (scale <= 0.5) return;
            scale -= 0.25;
            renderPage(pageNum);
        });

        // Handle View PDF Click
        document.querySelectorAll('.view-pdf-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const pdfUrl = this.dataset.pdf;

                // Reset state
                pageNum = 1;
                scale = 1.0;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                document.getElementById('page-count').textContent = '...';

                // Asynchronously download PDF
                pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
                    pdfDoc = pdfDoc_;
                    document.getElementById('page-count').textContent = pdfDoc.numPages;

                    // Initial/first page rendering
                    renderPage(pageNum);
                }).catch(function(error) {
                    console.error('Error loading PDF:', error);
                    // Handle error (e.g. show message in canvas container)
                });
            });
        });

        // Reset PDF on close (optional, mainly just to clear memory or reset view)
        const pdfModalEl = document.getElementById('pdfModal');
        if (pdfModalEl) {
            pdfModalEl.addEventListener('hidden.bs.modal', function() {
                if (pdfDoc) {
                    pdfDoc.destroy();
                    pdfDoc = null;
                }
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });
        }
    </script>
@endsection
