@extends('layouts.master')

@section('header', 'Coupon')
@section('content')

    {{-- Message --}}

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Coupon</h4>
                    <a href="{{ route('coupon.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Coupon</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Event Name</th>
                                <th>Coupon Name</th>
                                <th>Coupon Code</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupon as $couponData)
                                <tr>
                                    <th>{{ ($coupon->currentPage() - 1) * $coupon->perPage() + $loop->index + 1 }}
                                    <td>{{ $couponData->events->title ?? '-'}}</td>
                                    <td>{{ $couponData->couponName ?? '-'}}</td>
                                    <td>{{ $couponData->couponCode ?? '-'}}</td>
                                    <td>{{ $couponData->amount ?? '-'}}</td>
                                    <td>{{ $couponData->status }}</td>
                                    <td>
                                        <a href="{{ route('coupon.edit', $couponData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('coupon.delete', $couponData->id) }}"
                                            class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $coupon->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
