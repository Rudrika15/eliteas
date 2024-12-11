@extends('layouts.master')

@section('header', 'Visitor')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Visitor</h4>
                <a href="{{ route('visitors.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip"><i
                        class="bi bi-plus-circle"></i>
                    <span class="btn-text">Add New Visitor</span>
                </a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Email</th>
                            <th>Business Name</th>
                            <th>City</th>
                            <th>Business Category</th>
                            <th>Reffered By</th>
                            <th>Remarks</th>
                            {{-- <th>Status</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $visitorsData)
                        <tr>
                            <th>{{ ($visitors->currentPage() - 1) * $visitors->perPage() + $loop->index + 1 }}
                            <td>{{ $visitorsData->firstName ?? '' }} {{ $visitorsData->lastName ?? '' }}</td>
                            <td>{{ $visitorsData->mobileNo ?? '' }}</td>
                            <td>{{ $visitorsData->email ?? '' }}</td>
                            <td>{{ $visitorsData->businessName ?? '' }}</td>
                            <td>{{ $visitorsData->city ?? ''}}</td>
                            <td>{{ $visitorsData->bCategory->categoryName ?? ''}}</td>
                            <td>{{ $visitorsData->invitedBy }}</td>
                            <td>{{ $visitorsData->remarks ?? '' }}</td>
                            {{-- <td>{{ $visitorsData->status }}</td> --}}
                            <td>
                                <a href="{{ route('visitors.edit', $visitorsData->id) }}"
                                    class="btn btn-bg-blue btn-sm btn-tooltip">
                                    <i class="bi bi-pen"></i>
                                    <span class="btn-text">Edit</span>
                                </a>

                                <a href="{{ route('visitors.delete', $visitorsData->id) }}"
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
                    {!! $visitors->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>
</div>
@endsection