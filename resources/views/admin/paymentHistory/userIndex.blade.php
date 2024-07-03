@extends('layouts.master')

@section('header', 'My Payment History')
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
            <h4 class="card-title">My Payment History</h4>
            {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Payment Mode</th>
                        <th>Date</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myAllPayments as $payment)
                    <tr>
                        <td>{{ $payment->paymentType ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($payment->date)->format('d-m-Y') ?? '-' }}</td>
                        <td>{{ $payment->paymentMode ?? '-' }}</td>
                        <td>{{ $payment->amount ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection