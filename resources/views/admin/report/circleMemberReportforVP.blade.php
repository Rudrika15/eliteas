@extends('layouts.master')

@section('title', 'UBN - Circle Member Report')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Circle Member Report</h4>

                    <form method="GET" action="{{ route('admin.report.vpcircleMember') }}">
                        <button type="submit" name="export" value="1" class="btn btn-success btn-sm">
                            Export Excel
                        </button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">

                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Circle</th>
                                <th>Member Name</th>
                                <th>Company</th>
                                <th>Category</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($members as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->circleName }}</td>
                                    <td>{{ $member->memberName }}</td>
                                    <td>{{ $member->companyName }}</td>
                                    <td>{{ $member->categoryName }}</td>
                                    <td>{{ $member->phone }}</td>
                                    <td>{{ $member->email }}</td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $members->links() !!}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
