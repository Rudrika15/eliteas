@extends('layouts.master')

@section('title', 'UBN - Payment History')
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

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">All Payments</h4>
                    {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                        class="bi bi-plus-circle"></i></a> --}}
                </div>


                {{-- <div class="d-flex align-items-center mb-3">
                <small class="text-muted me-1"><strong>Filter By:</strong></small>
                <div class="d-flex align-items-center">
                    <select name="paymentType" id="paymentType" class="form-select form-select-sm">
                        <option value="" selected>Select Payment Type</option>
                        <option value="Member Subscription">Member Subscription</option>
                        <option value="Training Register">Training Register</option>
                        <option value="LifeTime">LifeTime</option>
                    </select>
                </div>
            </div> --}}

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Member Name</th>
                                <th>Payment Mode</th>
                                <th>Date</th>
                                <th>Payment Type</th>
                                <th>Amount</th>
                                <th>Payment ID</th>
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $paymentsData)
                                <tr>
                                    <th>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $paymentsData->user->firstName ?? '-' }}
                                        {{ $paymentsData->user->lastName ?? '-' }}</td>
                                    <td>{{ $paymentsData->paymentType ?? '-' }}</td>
                                    <td>{{ $paymentsData->date ?? '-' }}</td>
                                    <td>{{ $paymentsData->paymentMode }}</td>
                                    <td>{{ $paymentsData->amount }}</td>
                                    <td>{{ $paymentsData->remarks }}</td>
                                    {{-- <td>{{$paymentsData->status}}</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $payments->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentTypeSelect = document.getElementById('paymentType');
        const table = document.getElementById('subscriptionsTable');
        const rows = table.getElementsByTagName('tr');

        paymentTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const paymentType = cells[1].innerText;

                if (selectedType === "" || paymentType === selectedType) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script> --}}

@endsection
