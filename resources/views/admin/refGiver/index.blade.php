@extends('layouts.master')

@section('title', 'UBN - Referance')
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

    {{-- <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <h4 class="card-title">Reference Received</h4> --}}
    {{-- <a href="{{ route('refGiver.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                            <i class="bi bi-plus-circle"></i>
                            <span class="btn-text">Add Reference Details</span>
                        </a> --}}
    {{-- </div> --}}
    {{-- <hr> --}}
    <!-- Table with stripped rows -->
    {{-- <div class="table-responsive mt-5">
                        <table class="table table-striped table-hover mb-5">
                            <thead>
                                <tr>
                                    <th>Member Name</th>
                                    <th>Ex.Contact Name</th>
                                    <th>Ex.Contact No</th>
                                    <th>Ex.Email</th>
                                    <th>Scale</th> --}}
    {{-- <th>Description</th> --}}
    {{-- <th>Status</th> --}}
    {{-- <th>Action</th> --}}
    {{--
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($referenceByOther as $referenceByOtherData)
                                <tr>
                                    <td>{{ $referenceByOtherData->refGiverName->firstName ?? '-' }}
                                        {{ $referenceByOtherData->refGiverName->lastName ?? '-' }}</td>
                                    <td>{{ $referenceByOtherData->contactName ?? '-' }}</td>
                                    <td>{{ $referenceByOtherData->contactNo ?? '-' }}</td>
                                    <td>{{ $referenceByOtherData->email ?? '-' }}</td>
                                    <td>{{ $referenceByOtherData->scale ?? '-' }}</td> --}}
    {{-- <td>{{ $referenceByOther->description ?? '-' }}</td> --}}
    {{-- <td>{{ $referenceByOther->status }}</td> --}}
    {{-- </tr> --}}
    {{-- @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end" style="color: #1d3268">
                            {!! $referenceByOther->links() !!}
                        </div>
                    </div> --}}
    <!-- End Table with stripped rows -->
    {{--
                </div>
            </div>
        </div>
    </div>
</div> --}}


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="card-title">References Received </h4>
                            {{-- <a href="{{ route('busGiver.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a> --}}
                        </div>
                        <hr class="mb-5">
                        <!-- Table with stripped rows -->
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered table-striped table-hover mb-5">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Business Giver</th>
                                        {{-- <th>Login Member</th> --}}
                                        <th>Date</th>
                                        <th>Amount</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($busGiver as $busGiverData)
                                        <tr>
                                            <th>{{ ($busGiver->currentPage() - 1) * $busGiver->perPage() + $loop->index + 1 }}
                                            </th>
                                            <td>{{ $busGiverData->businessGiver->firstName . ' ' . $busGiverData->businessGiver->lastName ?? '-' }}
                                            </td>
                                            {{-- <td>{{ $busGiverData->loginMember->firstName . ' ' .
                                        $busGiverData->loginMember->lastName ?? '-' }}</td> --}}
                                            <td>{{ \Carbon\Carbon::parse($busGiverData->date)->format('d-m-Y') ?? '-' }}
                                            </td>
                                            <td>{{ $busGiverData->amount ?? '-' }}</td>
                                            {{-- <td>{{ $busGiverData->status }}</td> --}}
                                            <td>
                                                <a href="{{ route('busGiver.edit', $busGiverData->id) }}"
                                                    class="btn btn-bg-orange btn-sm btn-tooltip">
                                                    <i class="bi bi-plus"></i>
                                                    <span class="btn-text">Add Business Amount</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end custom-pagination">
                                {!! $busGiver->links() !!}
                            </div>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card mt-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h4 class="card-title">Reference Given</h4>
                                    <a href="{{ route('refGiver.create') }}"
                                        class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                                        <i class="bi bi-plus-circle"></i>
                                        <span class="btn-text">Add Reference Details</span>
                                    </a>
                                </div>
                                <hr>
                                <!-- Table with stripped rows -->
                                <div class="table-responsive mt-5">
                                    <table class="table table-bordered table-striped table-hover mb-5">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
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
                                                    <th>{{ ($refGiver->currentPage() - 1) * $refGiver->perPage() + $loop->index + 1 }}
                                                    </th>
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
                                    <div class="d-flex justify-content-end custom-pagination">
                                        {!! $refGiver->links() !!}
                                    </div>
                                </div>
                                <!-- End Table with stripped rows -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- //ref by other --}}


        @endsection
