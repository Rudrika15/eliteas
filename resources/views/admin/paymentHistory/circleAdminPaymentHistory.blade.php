@extends('layouts.master')

@section('header', 'Payment History')
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
<div class="card-responsive">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">All Payments</h4>
            {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable table-responsive">
            <thead>
                <tr>
                    <th>Member Name</th>
                    {{-- <th>Payment Mode</th> --}}
                    <th>Date</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    {{-- <th>Payment ID</th> --}}
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $paymentsData)
                <tr>
                    <td>{{$paymentsData->user->firstName ?? '-'}} {{$paymentsData->user->lastName ?? '-'}}</td>
                    {{-- <td>{{$paymentsData->paymentType ?? '-'}}</td> --}}
                    <td>{{$paymentsData->date ?? '-'}}</td>
                    <td>{{$paymentsData->paymentMode}}</td>
                    <td>{{$paymentsData->amount}}</td>
                    {{-- <td>{{$paymentsData->remarks}}</td> --}}
                    <td>{{$paymentsData->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>



    @endsection