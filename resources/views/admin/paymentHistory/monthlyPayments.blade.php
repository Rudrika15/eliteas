@extends('layouts.master')

@section('title', 'UBN - Monthly Payment')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Monthly Payment</h4>
                    @role('Admin')
                        <form action="{{ route('generate.payment') }}" method="GET" class="d-flex align-items-center">
                            <select name="month" class="form-select form-select-sm me-2" required
                                onchange="this.form.querySelector('button').disabled = !this.value;">
                                <option value="" selected disabled>Select Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                            <button type="submit" class="btn btn-bg-orange btn-sm mt-3 w-100" disabled>
                                <i class="bi bi-plus-circle"></i> Generate Monthly Payment
                            </button>
                        </form>
                    @endrole
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Member Name</th>
                                <th>Payment Date</th>
                                <th>Month & Year</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monthlyPayments as $payment)
                                <tr>
                                    <td>{{ $payment->members->firstName ?? '-' }} {{ $payment->members->lastName ?? '-' }}
                                    </td>
                                    <td>{{ $payment->paymentDate ? date('d-m-Y', strtotime($payment->paymentDate)) : '-' }}
                                    </td>
                                    <td>{{ $payment->month ?? '-' }}</td>
                                    <td style="width: 75px;">
                                        <select class="form-control status-select" data-id="{{ $payment->id }}">
                                            <option value="unpaid" {{ $payment->status == 'unpaid' ? 'selected' : '' }}
                                                style="background-color: red; color: white;">Unpaid</option>
                                            <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}
                                                style="background-color: green; color: white;">Paid</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $monthlyPayments->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Handle status change
            $('.status-select').change(function() {
                var paymentId = $(this).data('id');
                var status = $(this).val();

                $.ajax({
                    url: '{{ route('update.payment.status') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: paymentId,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Payment status updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to update payment status.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Handle SweetAlert for payment generation
            @if (session('warning'))
                Swal.fire({
                    title: 'Warning!',
                    text: '{{ session('warning') }}',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            @elseif (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>

@endsection
