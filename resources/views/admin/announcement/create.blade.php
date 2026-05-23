@extends('layouts.master')

@section('header', 'Announcement')

@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"></button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif

    <div class="card">

        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Announcement</h5>

            <a href="{{ route('announcement.index') }}" class="btn btn-bg-orange btn-sm">
                BACK
            </a>
        </div>

        <!-- Form -->
        <form class="m-3 needs-validation" method="POST" action="{{ route('announcement.store') }}" novalidate>

            @csrf

            <div class="row">

                {{-- Title --}}
                <div class="col-md-6">
                    <div class="form-floating mt-3">

                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Announcement Title" required>

                        <label for="title">Announcement Title</label>

                        @error('title')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                </div>

                {{-- Start Date --}}
                <div class="col-md-3">
                    <div class="form-floating mt-3">

                        <input type="date" class="form-control" id="start_date" name="start_date">

                        <label for="start_date">Start Date</label>

                    </div>
                </div>

                {{-- End Date --}}
                <div class="col-md-3">
                    <div class="form-floating mt-3">

                        <input type="date" class="form-control" id="end_date" name="end_date">

                        <label for="end_date">End Date</label>

                    </div>
                </div>

                {{-- Description --}}
                <div class="col-md-12">
                    <div class="form-floating mt-3">

                        <textarea class="form-control @error('description') is-invalid @enderror" placeholder="Announcement Description" id="description" name="description" style="height: 150px" required></textarea>

                        <label for="description">Announcement Description</label>

                        @error('description')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <div class="form-floating mt-3">

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

            </div>

            {{-- Buttons --}}
            <div class="text-center mt-4">

                <button type="submit" class="btn btn-bg-blue">
                    Submit
                </button>

                <button type="reset" class="btn btn-bg-orange">
                    Reset
                </button>

            </div>

        </form>

    </div>

@endsection
