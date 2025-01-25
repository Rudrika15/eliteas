@extends('layouts.master')

@section('header', 'Training Feedback')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Training Feedback</h5>
            <a href="{{ route('trainingFeedback.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="trainingFeedback" enctype="multipart/form-data" method="post" action="{{ route('trainingFeedback.store') }}" novalidate>
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <textarea class="form-control" id="feedback" name="feedback" placeholder="Feedback" required></textarea>
                        <label for="feedback">Feedback</label>
                        @error('feedback')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('feedback')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

@endsection
