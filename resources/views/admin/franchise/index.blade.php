@extends('layouts.master')

@section('header', 'Franchise')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Franchise</h4>
            <a href="{{ route('franchise.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                    class="bi bi-plus-circle"></i>
                <span class="btn-text">Add Franchise</span>
                </a>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Franchise Name</th>
                        <th>Owner Name</th>
                        <th>City Name</th>
                        <th>Franchise Contact Details</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($franchises as $franchiseData)
                    <tr>
                        <td>{{$franchiseData->franchiseName}}</td>
                        <td>{{ $franchiseData->user ? $franchiseData->user->firstName.' '.$franchiseData->user->lastName
                            : '-' }}</td>
                        <td>{{$franchiseData->city->cityName ?? '-'}}</td>
                        <td>{{$franchiseData->franchiseContactDetails}}</td>
                        <td>{{$franchiseData->status}}</td>
                        <td>
                            {{-- <div class="btn-group" role="group"> --}}
                                <a href="{{ route('franchise.edit', $franchiseData->id) }}"
                                    class="btn btn-bg-blue btn-sm btn-tooltip">
                                    <i class="bi bi-pen"></i>
                                    <span class="btn-text">Edit Franchise</span>
                                </a>

                                {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                <a href="{{ route('franchise.delete', $franchiseData->id) }}"
                                    class="btn btn-danger btn-sm btn-tooltip">
                                    <i class="bi bi-trash"></i>
                                    <span class="btn-text">Delete</span>
                                </a>
                                {{--
                            </div> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $franchises->links() !!}
            </div>
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection