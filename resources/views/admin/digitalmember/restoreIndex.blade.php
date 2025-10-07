@extends('layouts.master')

@section('header', 'Circle')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Deleted Digital Member</h4>
                    <a href="{{ route('digitalMember.index') }}" class="btn btn-bg-orange btn-sm mt-3">BACK</a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Created By</th>
                                <th>Member Name</th>
                                <th>Business Category</th>
                                <th>Membership Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($member as $circlememberData)
                                <tr>
                                    <th>{{ ($member->currentPage() - 1) * $member->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $circlememberData->users->firstName ?? '' }}
                                        {{ $circlememberData->users->lastName ?? '' }}</td>
                                    <td>{{ $circlememberData->firstName ?? '-' }} {{ $circlememberData->lastName ?? '' }}
                                    </td>
                                    <td>{{ $circlememberData->bCategory->categoryName ?? '-' }}</td>
                                    <td>{{ $circlememberData->membershipType ?? '-' }} </td>

                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm btn-tooltip" onclick="confirmRestore({{ $circlememberData->id }})">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                            <span class="btn-text">Restore Member</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $member->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function confirmRestore(memberId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('digitalMember.restore', '') }}/' + memberId;
                }
            })
        }
    </script>


@endsection
