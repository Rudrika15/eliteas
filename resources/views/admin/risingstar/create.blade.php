@extends('layouts.master')
@section('header', 'Rising Stars')
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <strong>Success!</strong>
            {{ session('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <strong>Error!</strong>
            {{ session('error') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">
                Add Rising Star
            </h5>
            <a href="{{ route('risingstar.index') }}" class="btn btn-bg-orange btn-sm">
                BACK
            </a>
        </div>
        <form class="m-3" method="POST" action="{{ route('risingstar.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <select name="member_id" class="form-select" required>
                            <option value="">
                                Select Member
                            </option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->firstName }} {{ $member->lastName }}
                                </option>
                            @endforeach
                        </select>
                        <label>
                            Member
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" name="title" placeholder="Title">
                        <label>
                            Title
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <select class="form-select" name="status">
                            <option value="Active">
                                Active
                            </option>
                            <option value="Deleted">
                                Deleted
                            </option>
                        </select>
                        <label>
                            Status
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-bg-blue">
                    Submit
                </button>
                <button type="reset" class="btn btn-bg-orange">
                    Reset
                </button>
            </div>
        </form>
    </div>
    <script>
        function previewPhoto(event) {
            let reader = new FileReader();
            reader.onload = function() {
                document
                    .getElementById('photoPreview')
                    .src = reader.result;
            };
            reader.readAsDataURL(
                event.target.files[0]
            );
        }
    </script>
@endsection
