@extends('layouts.master')

@section('header', 'Visitor Form')
@section('content')
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title mb-0" style="color: #1d2368; font-weight: 700;">
                        Visitor Form Config - {{ $circle->circleName }}
                    </h4>
                    <a href="{{ route('circle.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Back to Circles
                    </a>
                </div>

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('circle.visitorForm.store', $circle->id) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Enter form description or event details" required>{{ old('description', $visitorForm->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label fw-bold">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $visitorForm->date ?? '') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="time" class="form-label fw-bold">Time <span class="text-danger">*</span></label>
                            <input type="time" name="time" id="time" class="form-control @error('time') is-invalid @enderror" value="{{ old('time', $visitorForm->time ?? '') }}" required>
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="venue" class="form-label fw-bold">Venue <span class="text-danger">*</span></label>
                            <input type="text" name="venue" id="venue" class="form-control @error('venue') is-invalid @enderror" placeholder="Enter venue location" value="{{ old('venue', $visitorForm->venue ?? '') }}" required>
                            @error('venue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="visitor_registration_fee" class="form-label fw-bold">Visitor Registration Fee (₹) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="visitor_registration_fee" id="visitor_registration_fee" class="form-control @error('visitor_registration_fee') is-invalid @enderror" placeholder="0.00" value="{{ old('visitor_registration_fee', $visitorForm->visitor_registration_fee ?? '0') }}" required>
                            @error('visitor_registration_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary" style="background-color: #1d2368; border-color: #1d2368;">
                            <i class="bi bi-save"></i> Save Visitor Form
                        </button>
                    </div>
                </form>

                @if (isset($shareableUrl) && $shareableUrl)
                    <hr class="my-4">
                    <div class="card p-3" style="background-color: #f8f9fa; border-radius: 8px;">
                        <h5 class="fw-bold" style="color: #d6460d;"><i class="bi bi-link-45deg"></i> Shareable Encrypted Visitor Form Link</h5>
                        <p class="text-muted small mb-2">Copy this link and share it with potential visitors for registration.</p>
                        <div class="input-group">
                            <input type="text" id="shareableLinkInput" class="form-control bg-white" value="{{ $shareableUrl }}" readonly>
                            <button type="button" class="btn btn-outline-secondary" onclick="copyVisitorFormLink()" style="background-color: #d6460d; color: white; border-color: #d6460d;">
                                <i class="bi bi-clipboard"></i> Copy Link
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function copyVisitorFormLink() {
            var copyText = document.getElementById("shareableLinkInput").value;
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Link Copied!',
                        text: 'Visitor Form link has been copied to your clipboard.',
                        confirmButtonColor: '#1d2368'
                    });
                }).catch(function(err) {
                    fallbackCopy(copyText);
                });
            } else {
                fallbackCopy(copyText);
            }
        }

        function fallbackCopy(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                Swal.fire({
                    icon: 'success',
                    title: 'Link Copied!',
                    text: 'Visitor Form link has been copied to your clipboard.',
                    confirmButtonColor: '#1d2368'
                });
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Copy Failed',
                    text: 'Could not copy link. Please copy manually.',
                    confirmButtonColor: '#1d2368'
                });
            }
            document.body.removeChild(textArea);
        }
    </script>
@endsection
