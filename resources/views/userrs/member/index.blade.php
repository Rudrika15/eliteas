@extends('layouts.master')

@section('header', 'Member')
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
            <h4 class="mb-0 mt-3">Member</h4>
            <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
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
                    <td>{{$memberData->firstName ?? '-'}}</td>
                    <td>{{$memberData->lastName ?? '-'}}</td>
                    <td>{{$memberData->username ?? '-'}}</td>
                    <td>{{$memberData->contact->email ?? '-'}}</td>
                    <td>{{$memberData->contact->mobileNo ?? '-'}}</td>
                    <td>{{$memberData->status}}</td>
                    <td>
                        <a href="{{ route('members.edit', $memberData->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>

                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                        <a href="{{ route('members.delete', $memberData->id) }}" class="btn btn-danger btn-sm ">
                            <i class="bi bi-trash"></i>
                        </a>

                        {{-- <form action="{{ route('circle.delete', $circleData->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm mt-1">
                                <i class="bi bi-trash"></i> <!-- Icon for delete -->
                            </button>
                        </form> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection