@extends('layouts.master')

@section('header', 'Circle')
@section('content')

    <style>
        #loader {
            display: none;
            transition: opacity 0.3s ease;
        }
    </style>


    <div class="container">
        <div class="card">

            @if (request()->anyFilled(['categoryId', 'membershipType']))
                <div class="alert alert-info">
                    <strong>Filters Applied:</strong><br>
                    @if (request('categoryId'))
                        Category: {{ $bCategory->where('id', request('categoryId'))->first()?->categoryName }}<br>
                    @endif
                    @if (request('membershipType'))
                        Membership Type: {{ request('membershipType') }}
                    @endif
                </div>
            @endif


            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Digital Member</h4>
                    <a href="{{ route('digitalMember.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Member</span>
                    </a>
                </div>


                {{-- <form method="GET" action="{{ route('digitalMember.index') }}" id="filterForm">
                <div class="d-flex align-items-center mb-3">
                    <small class="text-muted me-3"><strong>Filter By:</strong></small>

                    <select name="categoryId" id="categoryId" class="form-select mt-3 me-3">
                        <option value="">Select Category</option>
                        @foreach ($bCategory as $categoryData)
                        <option value="{{ $categoryData->id }}" {{ request('categoryId')==$categoryData->id ? 'selected'
                            : '' }}>
                            {{ $categoryData->categoryName }}
                        </option>
                        @endforeach
                    </select>

                    <select name="membershipType" id="membershipType" class="form-select mt-3">
                        <option value="">Select MembershipType</option>
                        @foreach ($membershipType as $membershipTypeData)
                        <option value="{{ $membershipTypeData->membershipType }}" {{
                            request('membershipType')==$membershipTypeData->membershipType ? 'selected' : '' }}>
                            {{ $membershipTypeData->membershipType }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form> --}}


                <form method="GET" action="{{ route('digitalMember.index') }}" id="filterForm">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <small class="text-muted me-3"><strong>Filter By:</strong></small>

                        <!-- Category Filter -->
                        <select name="categoryId" id="categoryId" class="form-select mt-3 me-3">
                            <option value="">Select Category</option>
                            @foreach ($bCategory as $categoryData)
                                <option value="{{ $categoryData->id }}" {{ request('categoryId') == $categoryData->id ? 'selected' : '' }}>
                                    {{ $categoryData->categoryName }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Membership Type Filter -->
                        <select name="membershipType" id="membershipType" class="form-select mt-3 me-3">
                            <option value="">Select Membership Type</option>
                            @foreach ($membershipType as $membershipTypeData)
                                <option value="{{ $membershipTypeData->membershipType }}" {{ request('membershipType') == $membershipTypeData->membershipType ? 'selected' : '' }}>
                                    {{ $membershipTypeData->membershipType }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Global Search -->
                        <input type="text" name="search" id="search" class="form-control mt-3 ms-3" placeholder="Search by name, circle, etc.." value="{{ request('search') }}">

                        <!-- ✅ Reset Button -->
                        
                        <a href="{{ route('circlemember.index') }}" class="btn btn-secondary mt-3">
                            Reset
                        </a>
                    </div>
                </form>



                <!-- Loader -->
                <div id="loader" class="text-center my-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading members...</p>
                </div>



                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Created By</th>
                                <th>Sponsored By</th>
                                <th>City</th>
                                <th>Member Name</th>
                                <th>Business Category</th>
                                <th>Membership Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- {{$member}} --}}
                            @foreach ($member as $circlememberData)
                                <tr>
                                    <th>{{ ($member->currentPage() - 1) * $member->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $circlememberData->users->firstName ?? '' }}
                                        {{ $circlememberData->users->lastName ?? '' }}</td>
                                    <td>{{ $circlememberData->members->firstName ?? '' }} {{ $circlememberData->members->lastName ?? '' }}</td>
                                    <td>{{ $circlememberData->city->cityName ?? '-' }}</td>
                                    <td>{{ $circlememberData->firstName ?? '-' }} {{ $circlememberData->lastName ?? '' }}
                                    </td>
                                    <td>{{ $circlememberData->bCategory->categoryName ?? '-' }}</td>
                                    <td>{{ $circlememberData->membershipType ?? '-' }} </td>
                                    <td>
                                        <a href="{{ route('digitalMember.edit', $circlememberData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit Member</span>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm btn-tooltip" onclick="confirmDelete({{ $circlememberData->id }})">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete Member</span>
                                        </button>

                                        <script>
                                            function confirmDelete(memberId) {
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: "You won't be able to revert this!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        window.location.href = '{{ route('digitalMember.delete', '') }}/' + memberId;
                                                    }
                                                })
                                            }
                                        </script>
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

    {{-- <script>
        $(document).ready(function() {
            $(' #categoryId, #membershipType').on('change', function() {
                $('#filterForm').submit();
            });
        });
    </script> --}}


    <script>
        $(document).ready(function() {
            // Show loader before submitting
            function showLoader() {
                $('#loader').show();
            }

            // Auto submit on dropdown change
            $('#categoryId, #membershipType').on('change', function() {
                showLoader();
                $('#filterForm').submit();
            });

            // Auto submit on typing (global search)
            let timer;
            $('#search').on('keyup', function() {
                clearTimeout(timer);
                timer = setTimeout(function() {
                    showLoader();
                    $('#filterForm').submit();
                }, 500);
            });
        });
    </script>




@endsection
