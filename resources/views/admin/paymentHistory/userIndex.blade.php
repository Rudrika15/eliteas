@extends('layouts.master')

@section('title', 'UBN - Payment History')
@section('content')


    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">My Payment History</h4>
                {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Payment Mode</th>
                            <th>Date</th>
                            <th>Payment Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myAllPayments as $payment)
                            <tr>
                                <th>{{ ($myAllPayments->currentPage() - 1) * $myAllPayments->perPage() + $loop->index + 1 }}
                                <td>{{ $payment->paymentType ?? '-' }}</td>
                                <td>{{ $payment->date ? date('d-m-Y', strtotime($payment->date)) : '-' }}</td>
                                <td>{{ $payment->paymentMode ?? '-' }}</td>
                                <td>{{ $payment->amount ?? '-' }}</td>
                                {{-- <td>{{ number_format($payment->amount ?? 0, 2) ?? '-'}}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $myAllPayments->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>

@endsection
