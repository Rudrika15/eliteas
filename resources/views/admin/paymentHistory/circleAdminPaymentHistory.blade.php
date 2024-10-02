@extends('layouts.master')

@section('title', 'UBN - Payment History')
@section('content')

    <style>
        /* Add these styles to your CSS file */
        .custom-pagination .pagination a {
            color: #1d3268;
            /* Change this to your desired text color */
        }

        .custom-pagination .pagination a:hover {
            color: #ff0000;
            /* Change this to your desired hover text color */
        }

        .custom-pagination .pagination .page-item.active .page-link {
            background-color: #e76a35;
            /* Change this to your desired active background color */
            border-color: #e76a35;
            /* Change this to match the active background color */
            color: white;
            /* Change this to your desired active text color */
        }

        .custom-pagination .pagination .page-link {
            background-color: #f8f9fa;
            /* Change this to your desired background color */
            border-color: #dee2e6;
            /* Change this to your desired border color */
        }

        .custom-pagination .pagination .page-link:hover {
            background-color: #e9ecef;
            /* Change this to your desired hover background color */
        }
    </style>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">All Payments</h4>
                {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a> --}}
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
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
                                <th>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->index + 1 }}</th>
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
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $payments->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>

@endsection
