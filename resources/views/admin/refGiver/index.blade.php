@extends('layouts.master')

@section('title', 'UBN - Referance Giver')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div id="successMessage" class="alert alert-success alert-dismissible" role="alert">
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" id="error-alert" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h4 class="card-title">Reference Giver</h4>
                        <a href="{{ route('refGiver.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                            <i class="bi bi-plus-circle"></i>
                            <span class="btn-text">Add Reference Details</span>
                        </a>
                    </div>
                    <hr>
                    <!-- Table with stripped rows -->
                    <div class="table-responsive mt-5">
                        <table class="table datatable mb-5">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Ex.Contact Name</th>
                                    <th>Ex.Contact No</th>
                                    <th>Ex.Email</th>
                                    <th>Scale</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($refGiver as $refGiverData)
                                <tr>
                                    <td>{{ $refGiverData->members->firstName ?? '-' }}
                                        {{ $refGiverData->members->lastName ?? '-' }}</td>
                                    <td>{{ $refGiverData->contactName ?? '-' }}</td>
                                    <td>{{ $refGiverData->contactNo ?? '-' }}</td>
                                    <td>{{ $refGiverData->email ?? '-' }}</td>
                                    <td>{{ $refGiverData->scale ?? '-' }}</td>
                                    {{-- <td>{{ $refGiverData->description ?? '-' }}</td> --}}
                                    <td>{{ $refGiverData->status }}</td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('refGiver.edit', $refGiverData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit Reference Details</span>
                                        </a>
                                        <a id="deleteRefGiver{{ $refGiverData->id }}"
                                            href="{{ route('refGiver.delete', $refGiverData->id) }}"
                                            class="btn btn-danger btn-sm btn-tooltip" data-toggle="tooltip"
                                            data-placement="top" title="Delete Reference Giver">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>

                                        <script>
                                            $(document).ready(function() {
                                                $('#deleteRefGiver{{ $refGiverData->id }}').click(function(e) {
                                                    e.preventDefault();
                                                    Swal.fire({
                                                        title: 'Are you sure?',
                                                        text: "You won't be able to revert this!",
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#1d2856',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Yes, delete it!'
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            window.location.href = $(this).attr('href');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection