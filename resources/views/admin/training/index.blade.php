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
                <a href="{{ route('training.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i class="bi bi-plus-circle"></i>
                    <span class="btn-text">Create Training Transactions</span>
                </a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            {{-- <th>Trainer Name</th> --}}
                            <th>Master Title</th>
                            <th>Title</th>
                            {{-- <th>External Trainer</th> --}}
                            <th>Type</th>
                            <th>Fees</th>
                            <th>Meeting Link</th>
                            <th>Training Banner</th>
                            <th>Training Thumbnail</th>
                            <th>Venue</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Time</th>
                            <th>Status</th>
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
                                <th>{{ ($training->currentPage() - 1) * $training->perPage() + $loop->index + 1 }}

                                <td>{{ $trainingData->trainingMaster->trainingName ?? '-' }}</td>
                                <td>{{ $trainingData->title ?? '-' }}</td>
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
                                <td>{{ $trainingData->type ?? '-' }}</td>
                                <td>{{ number_format($trainingData->fees, 2, '.', ',') }}</td>
                                <td>
                                    <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $trainingData->meetingLink }}">
                                        {{ Str::limit($trainingData->meetingLink, 12) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($trainingData->training_thumb)
                                        <img src="{{ url('Training/' . basename($trainingData->training_thumb)) }}" alt="Event Image" style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                    @else
                                        <span></span>
                                    @endif
                                </td>
                                <td>
                                    @if ($trainingData->training_banner)
                                        <img src="{{ url('Training/' . basename($trainingData->training_banner)) }}" alt="Event Banner" style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                    @else
                                        <span></span>
                                    @endif
                                </td>

                                <td>{{ $trainingData->venue ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trainingData->date)->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($trainingData->end_date)->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ $trainingData->time ?? '-' }}</td>
                                <td>
                                    <select class="form-select form-select-sm" onchange="updateStatus({{ $trainingData->id }}, this.value)">
                                        <option value="Publish" {{ $trainingData->trainingStatus == 'Publish' ? 'selected' : '' }} style="background-color: #28a745; color: white;">
                                            Publish
                                        </option>
                                        <option value="Draft" {{ $trainingData->trainingStatus == 'Draft' ? 'selected' : '' }} style="background-color: #ffc107; color: white;">
                                            Draft
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <a href="{{ route('trainingFeedback.adminIndex', $trainingData->id) }}" class="btn btn-bg-orange btn-sm btn-tooltip">
                                        <i class="bi bi-eye"></i>
                                        <span class="btn-text">View Feedback</span>
                                    </a>
                                    <a href="{{ route('training.edit', $trainingData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                        <i class="bi bi-pen"></i>
                                        <span class="btn-text">Edit</span>
                                    </a>

                                    {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                            </a> --}}

                                    <a href="#" onclick="confirmDelete('{{ route('training.delete', $trainingData->id) }}')" class="btn btn-danger btn-sm btn-tooltip">
                                        <i class="bi bi-trash"></i>
                                        <span class="btn-text">Delete</span>
                                    </a>
                                    <script>
                                        function confirmDelete(url) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = url;
                                                }
                                            })
                                        }
                                    </script>


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
    </div>

    <script>
        function updateStatus(trainingId, newStatus) {
            // console.log(`Updating status of training ${trainingId} to ${newStatus}`);
            fetch(`/training/update-status/${trainingId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        trainingStatus: newStatus
                    })
                })
                .then(response => {
                    // console.log('Response:', response);
                    return response.json();
                })
                .then(data => {
                    // console.log('Data:', data);
                    if (data.success) {
                        Swal.fire('Success', 'Status updated successfully!', 'success');
                    } else {
                        Swal.fire('Error', 'Failed to update status.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'An error occurred while updating status.', 'error');
                });
        }
    </script>

@endsection
