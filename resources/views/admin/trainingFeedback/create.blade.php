@extends('layouts.master')

@section('header', 'Training Feedback')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Create Training Feedback</h5>
            <a href="{{ route('trainingFeedback.memberIndex') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="trainingFeedback" enctype="multipart/form-data" method="post" action="{{ route('trainingFeedback.store') }}" novalidate>
            @csrf

            <input type="hidden" name="trainingId" value="{{ $id }}">

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


    {{-- My Feedback --}}

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">My Feedback</h4>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Feedback</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainingFeedback as $trainingFeedbackData)
                            <tr>
                                <td>{{ $trainingFeedbackData->feedback ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-tooltip" onclick="confirmDelete({{ $trainingFeedbackData->id }})">
                                        <i class="bi bi-trash"></i>
                                        <span class="btn-text"> Delete Feedback </span>
                                    </button>
                                </td>

                                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    function confirmDelete(feedbackId) {
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
                                                window.location.href = '{{ route('trainingFeedback.delete', '') }}/' + feedbackId;
                                            }
                                        })
                                    }
                                </script>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $trainings->links() !!} --}}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>



@endsection
