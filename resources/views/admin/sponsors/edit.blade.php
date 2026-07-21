@extends('layouts.master')

@section('header', 'Edit Sponsor')
@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <strong>Success!</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Sponsor</h5>
            <a href="{{ route('sponsors.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <form class="m-3 needs-validation" enctype="multipart/form-data" method="POST" action="{{ route('sponsors.update', $sponsor->id) }}" novalidate>
            @csrf
            {{-- @method('PUT') --}}

            <div class="row">

                <!-- Title -->
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $sponsor->title) }}" placeholder="Sponsor Title" required>

                        <label for="title">Sponsor Title</label>

                        @error('title')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Image -->
                <div class="col-md-6">
                    <div class="form-label-group">
                        <label for="image" class="fw-bold">Sponsor Image</label>

                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewPhoto(event)">

                        <img id="photoPreview" src="{{ $sponsor->image ? asset('uploads/sponsors/' . $sponsor->image) : asset('images/default.jpg') }}" class="mt-2" width="250" height="200">

                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-6 mt-3">
                    <div class="form-floating">
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>

                            <option value="">Select Status</option>

                            <option value="Active" {{ old('status', $sponsor->status) == 'Active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="Deleted" {{ old('status', $sponsor->status) == 'Deleted' ? 'selected' : '' }}>
                                Deleted
                            </option>

                        </select>

                        <label for="status">Status</label>

                        @error('status')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-bg-blue">
                        Update
                    </button>

                    <a href="{{ route('sponsors.index') }}" class="btn btn-bg-orange">
                        Cancel
                    </a>
                </div>

            </div>
        </form>
    </div>

    <script>
        function previewPhoto(event) {
            let reader = new FileReader();

            reader.onload = function() {
                document.getElementById('photoPreview').src = reader.result;
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

@endsection
