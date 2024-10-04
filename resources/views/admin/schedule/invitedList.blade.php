@extends('layouts.master')

@section('header', 'Invited People List')
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
                <h4 class="card-title">Circle Meeting Invited Person List</h4>
                <a href="{{ URL::previous() }}" class="btn btn-bg-orange btn-sm mt-2">Back</a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table mt-3 table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Invited By</th>
                            <th>Person Name</th>
                            <th>Person Email</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invitedPersonList as $invitedPersonListData)
                            <tr>
                                <th>{{ ($invitedPersonList->currentPage() - 1) * $invitedPersonList->perPage() + $loop->index + 1 }}
                                </th>
                                <td>{{ $invitedPersonListData->user->member->firstName ?? '-' }}
                                    {{ $invitedPersonListData->user->member->lastName ?? '-' }}</td>
                                <td>{{ $invitedPersonListData->personName ?? '-' }}</td>
                                <td>{{ $invitedPersonListData->personEmail ?? '-' }}</td>
                                @php
                                    $statusColors = [
                                        'Pending' => 'red',
                                        'Accepted' => 'green',
                                        'Rejected' => 'red',
                                    ];
                                @endphp
                                <td
                                    style="background-color: {{ $statusColors[$invitedPersonListData->paymentStatus] ?? 'red' }}; color: white;">
                                    {{ Str::ucfirst($invitedPersonListData->paymentStatus) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $invitedPersonList->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>





@endsection
