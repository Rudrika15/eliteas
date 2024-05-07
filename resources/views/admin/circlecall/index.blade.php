@extends('layouts.master')

@section('title', 'UBN - 1:1 Meeting')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="mb-0 mt-3 text-blue">1:1 Meeting</h4>
            <a href="{{ route('circlecall.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i class="bi bi-plus-circle"></i></a>
        </div>
        <hr class="mb-5">
        <!-- Table with stripped rows -->
        <table class="table datatable mb-5">
            <thead>
                <tr>
                    <th>Circle Member</th>
                    <th>Meeting Person</th>
                    <th>Meeting Place</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($circlecall as $circlecallData)
                <tr>
                    <td>{{ $circlecallData->member->firstName ?? '-' }}</td>
                    <td>{{ $circlecallData->meetingPerson->firstName ?? '-' }}
                        {{ $circlecallData->meetingPerson->lastName ?? '-' }}</td>
                    <td>{{ $circlecallData->meetingPlace ?? '-' }}</td>
                    <td>{{ $circlecallData->remarks ?? '-' }}</td>
                    <td>{{ $circlecallData->status }}</td>
                    <td>
                        <a href="{{ route('circlecall.edit', $circlecallData->id) }}" class="btn btn-bg-blue btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>
                        <a onclick="return confirm('Do You Want To Delete It')"
                            href="{{ route('circlecall.delete', $circlecallData->id) }}"
                            class="btn btn-bg-orange btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>
@endsection