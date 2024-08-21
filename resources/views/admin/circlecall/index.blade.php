@extends('layouts.master')

@section('title', 'UBN - Business Meet')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title">Business Meets by Me</h4>
            <a href="{{ route('circlecall.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                <i class="bi bi-plus-circle"></i>
                <span class="btn-text">Create Circle Call</span>
            </a>
        </div>
        <hr class="mb-4">
        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>Meeting Person</th>
                        {{-- <th>Meeting With</th> --}}
                        <th>Meeting Place</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($circlecall as $circlecallData)
                    <tr>
                        <td>{{ $circlecallData->meetingPerson->firstName ?? '-' }}
                            {{ $circlecallData->meetingPerson->lastName ?? '-' }}</td>
                        <td>{{ $circlecallData->meetingPlace ?? '-' }}</td>
                        <td>{{ $circlecallData->date ? date('d-m-Y', strtotime($circlecallData->date)) : '-' }}</td>
                        <td>{{ $circlecallData->remarks ?? '-' }}</td>
                        <td>
                            <a href="{{ route('circlecall.edit', $circlecallData->id) }}"
                                class="btn btn-bg-blue btn-sm btn-tooltip">
                                <span class="btn-text">Edit Circle Call</span>
                                <i class="bi bi-pen"></i>
                            </a>
                            <button class="btn btn-danger btn-sm btn-tooltip"
                                onclick="deleteRow('{{ route('circlecall.delete', $circlecallData->id) }}')">
                                <span class="btn-text">Delete</span>
                                <i class="bi bi-trash"></i>
                            </button>
                            <script>
                                function deleteRow(url) {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You won't be able to revert this!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#1d2856',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = url;
                                        }
                                    })
                                }
                            </script>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $circlecall->links() !!}
            </div>
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>

{{-- //meeting With --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="card-title">Business Meets by Other</h4>
            {{-- <a href="{{ route('circlecall.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                <i class="bi bi-plus-circle"></i>
                <span class="btn-text">Create Circle Call</span>
            </a> --}}
        </div>
        <hr class="mb-4">
        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-4">
                <thead>
                    <tr>
                        <th>Meeting Person</th>
                        {{-- <th>Meeting With</th> --}}
                        <th>Meeting Place</th>
                        <th>Date</th>
                        <th>Remarks</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($callWith as $callWithData)
                    <tr>
                        <td>{{ $callWithData->member->firstName ?? '-' }}
                            {{ $callWithData->member->lastName ?? '-' }}</td>
                        <td>{{ $callWithData->meetingPlace ?? '-' }}</td>
                        <td>{{ $callWithData->date ? date('d-m-Y', strtotime($callWithData->date)) : '-' }}</td>
                        <td>{{ $callWithData->remarks ?? '-' }}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $callWith->links() !!}
            </div>
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>




@endsection