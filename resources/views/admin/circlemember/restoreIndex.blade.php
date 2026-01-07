@extends('layouts.master')

@section('header', 'Circle')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Deleted Circle Member</h4>
                    <a href="{{ route('circlemember.index') }}" class="btn btn-bg-orange btn-sm mt-3">BACK</a>
                </div>

                <form method="GET" id="searchForm" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search member or circle" value="{{ request('search') }}">

                        <a href="{{ route('circlemember.deletedMemberList') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                <!-- Loader -->
                <div id="loader" class="text-center my-3" style="display:none;">
                    <div class="spinner-border text-primary"></div>
                </div>



                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Created By</th>
                                <th>Sponsored By</th>
                                <th>Circle Name</th>
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
                                    <td>{{ $circlememberData->members->firstName ?? '' }} {{ $circlememberData->members->lastName ?? '' }}</td>
                                    <td>{{ $circlememberData->circle->circleName ?? '-' }}</td>
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
        let timer;
        const input = document.getElementById('searchInput');
        const form = document.getElementById('searchForm');
        const loader = document.getElementById('loader');

        input.addEventListener('keyup', function() {
            clearTimeout(timer);
            loader.style.display = 'block';

            timer = setTimeout(() => {
                form.submit();
            }, 500); // delay for typing
        });
    </script>


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
                    window.location.href = '{{ route('circlemember.restore', '') }}/' + memberId;
                }
            })
        }
    </script>


@endsection
