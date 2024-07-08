@extends('layouts.master')

@section('title', 'Edit Payment')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mt-3 mb-5">
            <h4 class="card-title">Edit Payment</h4>
            <a href="{{ route('busGiver.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr class="mb-5">
        <form class="m-3 needs-validation" enctype="multipart/form-data" method="post"
            action="{{ route('busGiver.paymentUpdate.save', $payment->id) }}" novalidate>
            @csrf
            <div class="">

                <input type="hidden" name="businessAmountId" id="businessAmountId" value="{{ $payment->id }}">

                <input type="hidden" name="circleMeetingMemberBusinessId" id="circleMeetingMemberBusinessId"
                    value="{{ $payment->circleMeetingMemberBusinessId }}">



                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                        name="amount" placeholder="Amount"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    <label for="amount">Add Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="removeAmount"
                        name="removeAmount" placeholder="Amount"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    <label for="amount">Remove Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="">
                <div class="form-floating mt-3">
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                        value="{{ old('date', $payment->date) }}" placeholder="Date" required>
                    <label for="date">Date</label>
                    @error('date')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="text-center mt-5">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form>
    </div>
</div>
@endsection