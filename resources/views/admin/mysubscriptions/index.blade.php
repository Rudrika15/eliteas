@extends('layouts.master')
@section('title', 'UBN - Subscriptions')
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

@role('Member')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">My Subscriptions</h4>
            {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Membership Type</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscriptions as $subscription)
                    <tr>
                        <td>{{ $subscription->membershipType ?? '-' }}</td>
                        <td>{{ $subscription->allPayments->amount ?? '-' }}</td>
                        <td>
                            @php
                            $validityDate = $subscription->validity ? \Carbon\Carbon::parse($subscription->validity) :
                            null;
                            @endphp
                            <span class="badge
                                {{ $validityDate && $validityDate->isPast() ? 'bg-danger' : ($validityDate ? 'bg-success' : 'bg-secondary') }}
                                ">
                                {{ $validityDate ? $validityDate->format('d-M-Y') : '-' }}
                            </span>
                        </td>
                        <td>{{ $subscription->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end custom-pagination">
                {!! $subscriptions->links() !!}
            </div>
        </div>
        <!-- End Table with stripped rows -->
    </div>
</div>
@endrole

@endsection