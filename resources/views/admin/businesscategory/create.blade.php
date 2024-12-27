@extends('layouts.master')

@section('header', 'Business Category')
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
        <h5 class="card-title">Create Business Category</h5>
        <a href="{{ route('bCategory.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="cityForm" enctype="multipart/form-data" method="post"
        action="{{ route('bCategory.store') }}" novalidate>
        @csrf
        <div class="row mb-3">

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('categoryName') is-invalid @enderror"
                        id="categoryName" name="categoryName" placeholder="Category Name" required>
                    <label for="categoryName">Category Name</label>
                    @error('categoryName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mt-3">
                <div class="form-label-group mt-3">
                    <label for="categoryIcon" class="fw-bold">Category Icon<sup class="text-danger"></sup></label>
                    <input type="file" class="form-control" id="categoryIcon" name="categoryIcon" accept="image/*"
                        onchange="previewPhoto(event)">
                    <img id="photoPreview" src="default.jpg" class="mt-2" width="100px" height="100px">
                    @error('categoryIcon')
                    <span class="error">{{ $message }}</span>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#countryId').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '{{ route("get.states") }}', // Replace with your route for fetching states
                    type: 'POST',
                    data: {
                        countryId: countryId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#stateId').html(data);
                    }
                });
            } else {
                $('#stateId').html('<option value="" selected disabled>Select State</option>');
            }
        });
    });
</script>

<script>
    function previewPhoto(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
    var dataURL = reader.result;
    var img = document.getElementById('photoPreview');
    img.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
    }
</script>

@endsection