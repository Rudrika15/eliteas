@extends('layouts.master')
@section('header', 'Rising Stars')
@section('content')
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Rising Star</h5>
            <a href="{{ route('risingstar.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <form class="m-3 needs-validation" enctype="multipart/form-data" method="POST" action="{{ route('risingstar.update', $risingStar->id) }}" novalidate>
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <select name="member_id" class="form-select">
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ $risingStar->member_id == $member->id ? 'selected' : '' }}>
                                    {{ $member->firstName }} {{ $member->lastName }}
                                </option>
                            @endforeach
                        </select>
                        <label>Member</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control" name="title" value="{{ $risingStar->title }}">
                        <label>Title</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <select name="status" class="form-select">
                            <option value="Active" {{ $risingStar->status == 'Active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="Deleted" {{ $risingStar->status == 'Deleted' ? 'selected' : '' }}>
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
                    Update
                </button>
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
