@extends('layouts.master')

@section('title', 'UBN - Referance Giver')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div id="successMessage" class="alert alert-success alert-dismissible" role="alert">
            {{-- <button type="button" class="close" data-dismiss="alert">
                <i class="bi bi-success"></i>
            </button> --}}
            <strong>Success !</strong> {{ session('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible" id="error-alert" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                {{-- <i class="fa fa-times"></i> --}}
            </button>
            <strong>Error !</strong> {{ session('error') }}
        </div>
    @endif



    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="mb-0 mt-3 text-blue">Reference Giver</h4>
                <a href="{{ route('refGiver.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i class="bi bi-plus-circle"></i></a>
            </div>
            <hr>
            <!-- Table with stripped rows -->
            <div class="table-responsive mt-5 ">
                <table class="table datatable mb-5">
                    <thead>
                        <tr>

                            <th >Member Name</th>
                            {{-- <th>Reference Giver Name</th> --}}
                            <th>Ex.Contact Name</th>
                            <th>Ex.Contact No</th>
                            <th>Ex.Email</th>
                            <th>Scale</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refGiver as $refGiverData)
                            <tr>
                                <td>{{ $refGiverData->members->firstName ?? '-' }}
                                    {{ $refGiverData->members->lastName ?? '-' }}
                                </td>
                                {{-- <td>{{ $refGiverData->refGiverName->firstName ?? '-' }}</td> --}}
                                <td>{{ $refGiverData->contactName ?? '-' }}</td>
                                <td>{{ $refGiverData->contactNo ?? '-' }}</td>
                                <td>{{ $refGiverData->email ?? '-' }}</td>
                                <td>{{ $refGiverData->scale ?? '-' }}</td>
                                <td>{{ $refGiverData->description ?? '-' }}</td>
                                <td>{{ $refGiverData->status }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('refGiver.edit', $refGiverData->id) }}"
                                        class="btn btn-bg-blue btn-sm">
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    <a onclick="return confirm('Do You Want To Delete It')"
                                        href="{{ route('refGiver.delete', $refGiverData->id) }}"
                                        class="btn btn-bg-orange btn-sm">
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
