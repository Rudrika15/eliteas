@extends('layouts.master')

@section('header', 'Payment History')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">All Payments</h4>
            {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable table-striped table-hover">
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
                    @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->user->firstName ?? '-' }} {{ $payment->user->lastName ?? '-' }}</td>
                        {{-- <td>{{ $payment->paymentType ?? '-' }}</td> --}}
                        <td>{{ $payment->date ?? '-' }}</td>
                        <td>{{ $payment->paymentMode }}</td>
                        <td>{{ $payment->amount }}</td>
                        {{-- <td>{{ $payment->remarks }}</td> --}}
                        <td>{{ $payment->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $payment->links() !!}
            </div> --}}
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection