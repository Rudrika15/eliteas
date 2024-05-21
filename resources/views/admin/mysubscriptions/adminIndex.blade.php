@extends('layouts.master')

@section('header', 'Subscriptions')
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
            <h4 class="mb-0 mt-3">My Subscriptions</h4>
            {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Membership Type</th>
                    <th>Amount</th>
                    <th>Validity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subscriptions as $subscritptionsData)
                <tr>
                    <td>{{$subscritptionsData->membershipType ?? '-'}}</td>
                    <td>{{$subscritptionsData->allPayments->amount ?? '-'}}</td>
                    <td>{{$subscritptionsData->validity ?? '-'}}</td>
                    <td>{{$subscritptionsData->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection