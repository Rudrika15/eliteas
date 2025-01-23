@extends('layouts.master')

@section('header', 'Training Master')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Training Feedback List</h4>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Feedback</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingFeedback as $trainingFeedbackData)
                                <tr>
                                    <th>{{ ($trainingFeedback->currentPage() - 1) * $trainingFeedback->perPage() + $loop->index + 1 }}
                                    <td>{{ $trainingFeedbackData->trainingMaster->trainingName ?? '' }}</td>
                                    <td>{{ $trainingFeedbackData->users->firstName ?? '' }} {{ $trainingFeedbackData->users->lastName ?? '' }}</td>
                                    <td>{{ $trainingFeedbackData->feedback ?? '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $trainingFeedback->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
