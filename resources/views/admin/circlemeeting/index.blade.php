@extends('layouts.master')

@section('header', 'City')
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Circle Meeting</h4>
            <a href="{{ route('circlemeeting.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Hotel Name</th>
                    <th>Total Meeting</th>
                    <th>Total Reference Given</th>
                    <th>Total Reference Taken</th>
                    <th>Total Business Given</th>
                    <th>Total Business Taken</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($circlemeeting as $circlemeetingData)
                <tr>
                    <td>{{$circlemeetingData->dateTime ?? '-'}}</td>
                    <td>{{$circlemeetingData->hotelName ?? '-'}}</td>
                    <td>{{$circlemeetingData->totalMeeting ?? '-'}}</td>
                    <td>{{$circlemeetingData->refGiven ?? '-'}}</td>
                    <td>{{$circlemeetingData->refTaken ?? '-'}}</td>
                    <td>{{$circlemeetingData->busTaken ?? '-'}}</td>
                    <td>{{$circlemeetingData->busTaken ?? '-'}}</td>
                    <td>{{$circlemeetingData->status ?? '-'}}</td>
                    <td>
                        <a href="{{ route('circlemeeting.edit', $circlemeetingData->id) }}"
                            class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>

                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                        <a href="{{ route('circlemeeting.delete', $circlemeetingData->id) }}"
                            class="btn btn-danger btn-sm mt-1">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection