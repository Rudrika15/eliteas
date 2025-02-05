@extends('layouts.master')

@section('header', 'Training Feedback')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Training Feedback</h4>
                    {{-- <h4 class="card-title">Training Feedback for {{ $trainingFeedback->first()->trainingMaster->trainingName ?? 'N/A' }}</h4> --}}
                    <a href="{{ route('training.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Feedback</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingFeedback as $feedback)
                                <tr>
                                    <th>{{ ($trainingFeedback->currentPage() - 1) * $trainingFeedback->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $feedback->feedback }}</td>
                                    @role('Admin')
                                        <td>{{ $feedback->users->firstName ?? 'N/A' }} {{ $feedback->users->lastName ?? 'N/A' }}</td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination for feedback list -->
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $trainingFeedback->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
