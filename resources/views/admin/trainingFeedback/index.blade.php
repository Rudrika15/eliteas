@extends('layouts.master')

@section('header', 'Training')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Trainings</h4>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Master Title</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Fees</th>
                            <th>Meeting Link</th>
                            <th>Venue</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainings as $trainingData)
                            <tr>
                                <th>{{ ($trainings->currentPage() - 1) * $trainings->perPage() + $loop->index + 1 }}</th>
                                <td>{{ $trainingData->trainingMaster->trainingName ?? '-' }}</td>
                                <td>{{ $trainingData->title ?? '-' }}</td>
                                <td>{{ $trainingData->type ?? '-' }}</td>
                                <td>{{ number_format($trainingData->fees, 2, '.', ',') }}</td>
                                <td>{{ $trainingData->meetingLink }}</td>
                                <td>{{ $trainingData->venue ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trainingData->date)->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trainingData->end_date)->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ $trainingData->time ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('trainingFeedback.create', $trainingData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                        <i class="bi bi-plus"></i>
                                        <span class="btn-text"> Add Feedback </span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $trainings->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>
@endsection
