@extends('layouts.master')

@section('header', 'Event')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Event Registraion List</h4>
                    <a href="{{ route('event.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Member Name</th>
                                <th>Person Name</th>
                                <th>Person Email</th>
                                <th>Person Contact</th>
                                <th>Reference By</th>
                                {{-- <th>Action</th> --}}
                                {{-- <th>Payment Status</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registerLists as $registerListsData)
                                <tr>
                                    <th>{{ ($registerLists->currentPage() - 1) * $registerLists->perPage() + $loop->index + 1 }}

                                    <td>{{ $registerListsData->events->title ?? '' }}</td>
                                    <td>{{ $registerListsData->members->firstName ?? '' }}
                                        {{ $registerListsData->members->lastName ?? '' }}
                                    </td>
                                    <td>{{ $registerListsData->visitors->firstName ?? '' }}</td>
                                    <td>{{ $registerListsData->visitors->lastName ?? '' }}</td>
                                    <td>{{ $registerListsData->visitors->mobileNo ?? '' }}</td>
                                    <td>{{ $registerListsData->refMembers->firstName ?? '' }}
                                        {{ $registerListsData->refMembers->lastName ?? '' }} </td>
                                    {{-- <td>{{$registerListsData->PaymentStatus ?? ''}}</td> --}}

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $registerList->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
