@extends('layouts.master')

@section('header', 'Circle Member List')
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
            <h4 class="mb-0 mt-3">Circle Wise Member List</h4>
            <div class="">
                <a href="{{ route('circle.index') }}" class="btn btn-bg-orange btn-sm mt-3 mr-2 ">Back</a>
            </div>
        </div>


        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Member First Name</th>
                        <th>Member Last Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                    <tr>
                        <td>{{ $member->firstName ?? '-' }} </td>
                        <td>{{ $member->lastName ?? '-' }} </td>
                        <td>{{ $member->user->contactNo ?? '-' }} </td>
                        <td>{{ $member->user->email ?? '-' }} </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table with stripped rows -->
    </div>
    @endsection