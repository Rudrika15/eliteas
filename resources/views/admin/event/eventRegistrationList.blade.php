@extends('layouts.master')

@section('header', 'Event')
@section('content')


<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Event Registraion List</h4>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Member Name</th>
                            <th>Person Name</th>
                            <th>Person Email</th>
                            <th>Person Contact</th>
                            <th>Payment Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registerList as $registerListData)
                        <tr>
                            <td>{{$registerListData->events->title ?? ''}}</td>
                            <td>{{$registerListData->members->firstName ?? ''}} {{$registerListData->members->lastName
                                ??
                                ''}}</td>
                            <td>{{$registerListData->personName ?? ''}}</td>
                            <td>{{$registerListData->personEmail ?? ''}}</td>
                            <td>{{$registerListData->personContact ?? ''}}</td>
                            <td>{{$registerListData->PaymentStatus ?? ''}}</td>

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