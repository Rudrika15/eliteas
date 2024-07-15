@extends('layouts.master')

@section('header', 'Membership Type')
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


<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Membership Type</h4>
                <a href="{{ route('membershipType.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip"><i
                        class="bi bi-plus-circle"></i>
                    <span class="btn-text">Add Membership Type</span></a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Membership Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($membershipType as $membershipTypeData)
                        <tr>
                            <td>{{$membershipTypeData->membershipType ?? '-'}}</td>
                            <td>{{$membershipTypeData->amount ?? '-'}}</td>
                            <td>{{$membershipTypeData->status ?? '-'}}</td>
                            <td>
                                <a href="{{ route('membershipType.edit', $membershipTypeData->id) }}"
                                    class="btn btn-bg-blue btn-sm btn-tooltip">
                                    <i class="bi bi-pen"></i>
                                    <span class="btn-text">Edit</span>
                                </a>

                                {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                <a href="{{ route('membershipType.delete', $membershipTypeData->id) }}"
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
                    {!! $membershipType->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>
</div>
@endsection