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
            <h4 class="mb-0 mt-3">City</h4>
            <a href="{{ route('city.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i class="bi bi-plus-circle"></i></a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>City Name</th>
                    <th>Amount</th>
                    <th>Member Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($city as $cityData)
                <tr>
                    <td>{{$cityData->country->countryName ?? '-'}}</td>
                    <td>{{$cityData->state->stateName ?? '-'}}</td>
                    <td>{{$cityData->cityName}}</td>
                    <td>{{$cityData->amount}}</td>
                    <td>{{$cityData->memberAmount}}</td>
                    <td>{{$cityData->status}}</td>
                    <td>
                        <a href="{{ route('city.edit', $cityData->id) }}" class="btn btn-bg-blue btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>

                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                        <form action="{{ route('city.delete', $cityData->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mt-3">
                                <i class="bi bi-trash"></i> <!-- Icon for delete -->
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection