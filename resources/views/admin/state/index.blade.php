@extends('layouts.master')

@section('header', 'State')
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

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">State</h4>
                <a href="{{ route('state.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                        class="bi bi-plus-circle"></i></a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table datatable table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Country Name</th>
                            <th>State Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($state as $stateData)
                        <tr>
                            <td>{{$stateData->country->countryName ?? '-'}}</td>
                            <td>{{$stateData->stateName}}</td>
                            <td>{{$stateData->status}}</td>
                            <td>
                                <a href="{{ route('state.edit', $stateData->id) }}" class="btn btn-bg-blue btn-sm">
                                    <i class="bi bi-pen"></i>
                                </a>

                                {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                <a href="{{ route('state.delete', $stateData->id) }}" class="btn btn-danger btn-sm">
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
    </div>
</div>
@endsection