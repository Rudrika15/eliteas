@extends('layouts.master')

@section('header', 'Sponsors')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif


    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Sponsors</h5>
            <a href="{{ route('sponsors.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="cityForm" enctype="multipart/form-data" method="POST" action="{{ route('sponsors.store') }}" novalidate>
            @csrf
            <div class="row ">

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Sponsor Title" required>
                        <label for="title">Sponsor Title</label>
                        @error('title')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6 ">
                    <div class="form-label-group ">
                        <label for="image" class="fw-bold">Sponsor Image<sup class="text-danger"></sup></label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewPhoto(event)">
                        <img id="photoPreview" src="{{ asset('images/default.jpg') }}" class="mt-2" width="250px" height="200px">
                        @error('image')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Deleted">Deleted</option>
                        </select>
                        <label for="status">Status</label>
                        @error('status')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
        </form><!-- End floating Labels Form -->
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        function previewPhoto(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var img = document.getElementById('photoPreview');
                img.src = dataURL;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>

@endsection
