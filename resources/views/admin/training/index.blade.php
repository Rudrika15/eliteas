@extends('layouts.master')

@section('header', 'State')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Trainings</h4>
            <a href="{{ route('training.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                    class="bi bi-plus-circle"></i>
                <span class="btn-text">Create Training</span>
            </a>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        {{-- <th>Trainer Name</th> --}}
                        <th>Title</th>
                        {{-- <th>External Trainer</th> --}}
                        <th>Type</th>
                        <th>Fees</th>
                        <th>Meeting Link</th>
                        <th>Venue</th>
                        <th>Date</th>
                        <th>Time</th>
                        {{-- <th>Status</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($training as $trainingData)
                    <tr>
                        {{-- <td>
                            @php
                            $trainerIds = explode(',', $trainingData->trainerId);
                            $trainerNames = [];
                            foreach ($trainerIds as $trainerId) {
                            $trainer = App\Models\Member::find($trainerId);
                            if ($trainer) {
                            $trainerNames[] = $trainer->firstName . ' ' . $trainer->lastName;
                            }
                            }
                            echo implode(', ', $trainerNames) ?: '-';
                            @endphp
                        </td> --}}
                        <td>{{$trainingData->title ?? '-'}}</td>
                        {{-- <td>
                            @php
                            $externalTrainerIds = explode(',', $trainingData->externalTrainerId);
                            $externalTrainerNames = [];
                            foreach ($externalTrainerIds as $externalTrainerId) {
                            $externalTrainer = App\Models\User::find($externalTrainerId);
                            if ($externalTrainer) {
                            $externalTrainerNames[] = $externalTrainer->firstName . ' ' . $externalTrainer->lastName;
                            }
                            }
                            echo implode(', ', $externalTrainerNames) ?: '-';
                            @endphp
                        </td> --}}
                        {{-- <td>{{$trainingData->user->firstName ?? '-'}} {{$trainingData->user->lastName ?? '-'}}</td>
                        --}}
                        <td>{{$trainingData->type ?? '-'}}</td>
                        <td>{{ number_format($trainingData->fees, 2, '.', ',') }}</td>
                        <td>{{$trainingData->meetingLink}}</td>
                        <td>{{$trainingData->venue ?? '-'}}</td>
                        <td>{{ \Carbon\Carbon::parse($trainingData->date)->format('d-m-Y') ?? '-' }}</td>
                        <td>{{$trainingData->time ?? '-'}}</td>
                        {{-- <td>{{$trainingData->status ?? '-'}}</td> --}}
                        <td>
                            <a href="{{ route('training.edit', $trainingData->id) }}"
                                class="btn btn-bg-blue btn-sm btn-tooltip">
                                <i class="bi bi-pen"></i>
                                <span class="btn-text">Edit</span>
                            </a>

                            {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                            </a> --}}

                            <a href="{{ route('training.delete', $trainingData->id) }}"
                                class="btn btn-danger btn-sm btn-tooltip">
                                <i class="bi bi-trash"></i>
                                <span class="btn-text">Delete</span>
                            </a>


                            {{-- <form action="{{ route('training.delete', $trainingData->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> <!-- Icon for delete -->
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end custom-pagination">
                {!! $training->links() !!}
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
    @endsection