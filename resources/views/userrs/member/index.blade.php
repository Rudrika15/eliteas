@extends('layouts.master')

@section('header', 'Franchise')
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
            <h4 class="card-title">Member</h4>
            <a href="{{ route('circlemember.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Circle Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($member as $memberData)
                    <tr>
                        <td>{{$memberData->circle->circleName ?? '-'}}</td>
                        <td>{{$memberData->firstName ?? '-'}}</td>
                        <td>{{$memberData->lastName ?? '-'}}</td>
                        <td>{{$memberData->username ?? '-'}}</td>
                        <td>{{$memberData->user->email ?? '-'}}</td>
                        <td>{{$memberData->contact->mobileNo ?? '-'}}</td>
                        <td>{{$memberData->status}}</td>
                        <td>
                            <a href="{{ route('members.edit', $memberData->id) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>

                            <a href="{{ route('members.delete', $memberData->id) }}" class="btn btn-danger btn-sm ">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Table with stripped rows -->
    </div>
    @endsection