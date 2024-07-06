@extends('layouts.master')

@section('header', 'Pending Payments')
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
            <h4 class="card-title">Pending Payment</h4>
            <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm mt-3">Back</a>
        </div>

        <!-- Table with stripped rows -->
        <div class="responsive">
            <table class="table datatable table-striped table-hover">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        {{-- <th></th> --}}
                        <th>Payment Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($myAllPayments as $myAllPaymentsData)
                    <tr>
                        <td>{{$myAllPaymentsData->paymentType ?? '-'}}</td>
                        <td>{{ \Carbon\Carbon::parse($myAllPaymentsData->date)->format('d-m-Y') ?? '-' }}</td>
                        <td>{{$myAllPaymentsData->paymentMode ?? '-'}}</td>
                        <td>{{$myAllPaymentsData->amount ?? '-'}}</td>
                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>


    @endsection