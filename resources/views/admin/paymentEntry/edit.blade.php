@extends('layouts.master')

@section('header', 'Payment Entry')
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
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Edit Payment Entry</h5>
        {{-- <a href="{{ route('payments.index') }}" class="btn btn-bg-orange btn-sm">BACK</a> --}}
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="paymentEntryForm" enctype="multipart/form-data" method="post" action=""
        novalidate>
        {{-- //{{ route('paymentEntryEdit.update') }} --}}
        @csrf

        {{-- //passs hidden id --}}

        <div class="row mb-3">

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <select class="form-select @error('paymentMode') is-invalid @enderror" id="paymentMode"
                        name="paymentMode" required>
                        <option value="" selected disabled>Choose Payment Mode</option>
                        <option value="Online" {{ old('paymentMode', $paymentEntry->paymentMode) == 'Online' ? 'selected' : '' }}>Online</option>
                        <option value="Cash" {{ old('paymentMode', $paymentEntry->paymentMode) == 'Cash' ? 'selected' : '' }}>Cash</option>
                    </select>
                    @error('paymentMode')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                        name="amount" placeholder="Membership Amount" value="{{ old('amount', $paymentEntry->amount) }}" required>
                    <label for="amount">Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mt-3">
                    <input type="date" class="form-control @error('paymentDate') is-invalid @enderror" id="paymentDate"
                        name="paymentDate" placeholder="Payment Date" value="{{ old('paymentDate', $paymentEntry->paymentDate) }}" required>
                    <label for="paymentDate">Payment Date</label>
                    @error('paymentDate')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            </div>

        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection