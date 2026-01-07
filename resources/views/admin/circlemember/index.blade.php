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
            @if (request()->anyFilled(['circleId', 'categoryId', 'membershipType']))
                <div class="alert alert-info">
                    <strong>Filters Applied:</strong><br>
                    @if (request('circleId'))
                        Circle: {{ $circle->where('id', request('circleId'))->first()?->circleName }}<br>
                    @endif
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
                    <h4 class="card-title">Circle Member</h4>
                    <a href="{{ route('circlemember.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Member</span>
                    </a>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <div class="btn-group" role="group">
                        {{-- <button type="button" class="btn btn-primary btn-sm me-2 disabled">
                        <i class="bi bi-file-earmark-excel"></i> Download Excel
                    </button> --}}
                        <form action="{{ route('circlemember.export') }}" method="GET" class="d-flex align-items-center">
                            <h6 class="mb-0"><b>Download Member List: </b></h6>
                            <select name="circleId" id="circleId" class="form-select me-3">
                                <option value="">Select Circle</option>
                                @foreach ($circle as $circleData)
                                    <option value="{{ $circleData->id }}">{{ $circleData->circleName }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-success btn-sm btn-tooltip">
                                <i class="bi bi-filetype-xls"></i>
                                <span class="btn-text">Download Excel</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Dropdown for filtering by Circle and Category side by side -->

                {{-- <div class="d-flex align-items-center mb-3">
                <small class="text-muted me-3"><strong>Filter By:</strong></small>

                <select name="circleId" id="filtercircleId" class="form-select mt-3 me-3">
                    <option value="">Select Circle</option>
                    @foreach ($circle as $circleData)
                    <option value="{{ $circleData->id }}">{{ $circleData->circleName }}</option>
                    @endforeach
                </select>

                <select name="categoryId" id="categoryId" class="form-select mt-3 me-3">
                    <option value="">Select Category</option>
                    @foreach ($bCategory as $categoryData)
                    <option value="{{ $categoryData->id }}">{{ $categoryData->categoryName }}</option>
                    @endforeach
                </select>

                <select name="membershipType" id="membershipType" class="form-select mt-3">
                    <option value="">Select MembershipType</option>
                    @foreach ($membershipType as $membershipTypeData)
                    <option>{{ $membershipTypeData->membershipType }}</option>
                    @endforeach
                </select> --}}

                {{-- <select name="membershipType" id="membershipType" class="form-select mt-3">
                    <option value="" selected>Select Membership</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                    <option value="LifeTime">LifeTime</option>
                </select> --}}
                {{--
            </div> --}}


                {{-- <form method="GET" action="{{ route('circlemember.index') }}" id="filterForm">
                <div class="d-flex align-items-center mb-3">
                    <small class="text-muted me-3"><strong>Filter By:</strong></small>

                    <select name="circleId" id="filtercircleId" class="form-select mt-3 me-3">
                        <option value="">Select Circle</option>
                        @foreach ($circle as $circleData)
                        <option value="{{ $circleData->id }}" {{ request('circleId')==$circleData->id ? 'selected' : ''
                            }}>
                            {{ $circleData->circleName }}
                        </option>
                        @endforeach
                    </select>

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


                <form method="GET" action="{{ route('circlemember.index') }}" id="filterForm">
                    <div class="d-flex align-items-center mb-3 gap-3">
                        <small class="text-muted me-3"><strong>Filter By:</strong></small>

                        <select name="circleId" id="filtercircleId" class="form-select mt-3 me-3">
                            <option value="">Select Circle</option>
                            @foreach ($circle as $circleData)
                                <option value="{{ $circleData->id }}" {{ request('circleId') == $circleData->id ? 'selected' : '' }}>
                                    {{ $circleData->circleName }}
                                </option>
                            @endforeach
                        </select>

                        <select name="categoryId" id="categoryId" class="form-select mt-3 me-3">
                            <option value="">Select Category</option>
                            @foreach ($bCategory as $categoryData)
                                <option value="{{ $categoryData->id }}" {{ request('categoryId') == $categoryData->id ? 'selected' : '' }}>
                                    {{ $categoryData->categoryName }}
                                </option>
                            @endforeach
                        </select>

                        <select name="membershipType" id="membershipType" class="form-select mt-3 me-3">
                            <option value="">Select Membership Type</option>
                            @foreach ($membershipType as $membershipTypeData)
                                <option value="{{ $membershipTypeData->membershipType }}" {{ request('membershipType') == $membershipTypeData->membershipType ? 'selected' : '' }}>
                                    {{ $membershipTypeData->membershipType }}
                                </option>
                            @endforeach
                        </select>

                        <!-- ✅ Global Search -->
                        <input type="text" name="search" id="search" class="form-control mt-3" placeholder="Search by name, circle, etc.." value="{{ request('search') }}">

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
                                <th>Profile Picture</th>
                                <th>Created By</th>
                                <th>Sponsored By</th>
                                <th>Circle Name</th>
                                <th>Member Name</th>
                                <th>Business Category</th>
                                <th>Membership Type</th>
                                <th>Roles</th> <!-- New column for roles -->
                                <th>Action</th>
                                <th>Role Action</th> <!-- New column for assigning role -->
                                <th>Assign Circle</th> <!-- New column for assigning role -->
                            </tr>
                        </thead>

                        <tbody>
                            {{-- {{$member}} --}}
                            @foreach ($member as $circlememberData)
                                <tr>
                                    <th>{{ ($member->currentPage() - 1) * $member->perPage() + $loop->index + 1 }}</th>
                                    <td>
                                        <div style="width: 80px; height: 80px; position: relative;">
                                            <img src="{{ asset('ProfilePhoto/' . ($circlememberData->profilePhoto ?? 'profile.png')) }}" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                                        </div>
                                    </td>

                                    <td>{{ $circlememberData->users->firstName ?? '' }}
                                        {{ $circlememberData->users->lastName ?? '' }}</td>
                                    <td>{{ $circlememberData->sponsors->firstName ?? '' }} {{ $circlememberData->sponsors->lastName ?? '' }}</td>
                                    <td>{{ $circlememberData->circle->circleName ?? '-' }}</td>
                                    <td>{{ $circlememberData->firstName ?? '-' }} {{ $circlememberData->lastName ?? '' }}
                                    </td>
                                    <td>{{ $circlememberData->bCategory->categoryName ?? '-' }}</td>
                                    <td>{{ $circlememberData->membershipType ?? '-' }} </td>
                                    <td>
                                        {{-- @foreach ($circlememberData->user->roles as $role)
                                <span class="badge rounded-pill bg-success">{{ $role->name ?? '' }}</span>
                                @if (!$loop->last)
                                ,
                                @endif
                                @endforeach --}}
                                    </td>

                                    <td>
                                        <a href="{{ route('circlemember.activity', $circlememberData->id) }}" class="btn btn-bg-orange btn-sm btn-tooltip">
                                            <i class="bi bi-info-circle"></i>
                                            <span class="btn-text">Activity</span>
                                        </a>
                                        <a href="{{ route('circlemember.edit', $circlememberData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
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
                                                        window.location.href = '{{ route('circlemember.delete', '') }}/' + memberId;
                                                    }
                                                })
                                            }
                                        </script>
                                        {{-- <a href="{{ route('circlemember.edit', $circlememberData->id) }}"
                                    class="btn btn-bg-blue btn-sm">
                                    <i class="bi bi-envelope"></i>
                                </a> --}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-bg-blue btn-sm btn-tooltip" data-bs-toggle="modal" data-bs-target="#assignRoleModal{{ $circlememberData->id }}"><i class="bi bi-person-plus"></i>
                                            <span class="btn-text">Assign Role</span>
                                        </button>

                                        {{-- Modal --}}

                                        <div class="modal fade" id="assignRoleModal{{ $circlememberData->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="assignRoleModalLabel">Assign Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('assign.role') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="memberId" value="{{ $circlememberData->id }}">
                                                            <select name="roleId" class="form-select">
                                                                <option value="">Select Role</option>
                                                                @foreach ($roles as $role)
                                                                    @if (!in_array($role->name, ['Franchise Admin', 'Member', 'Admin', 'Trainer']) && !$circlememberData->user->roles->contains($role->id))
                                                                        <option value="{{ $role->id }}">
                                                                            {{ $role->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <div class="d-flex justify-content-end mt-3">
                                                                <button type="submit" class="btn btn-bg-blue btn-sm">Assign</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- //remove role --}}

                                        <button type="button" class="btn btn-danger btn-sm btn-tooltip" data-bs-toggle="modal" data-bs-target="#removeRoleModal{{ $circlememberData->id }}"><i class="bi bi-trash"></i>
                                            <span class="btn-text">Remove Role</span>
                                        </button>
                                        {{-- Modal --}}

                                        <div class="modal fade" id="removeRoleModal{{ $circlememberData->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="removeRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="removeRoleModalLabel">Remove Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('remove.role') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="memberId" value="{{ $circlememberData->id }}">
                                                            <select name="roleId" class="form-select">
                                                                <option value="">Select Role</option>
                                                                @foreach ($circlememberData->user->roles as $role)
                                                                    @if (!in_array($role->name, ['Member', 'Trainer', 'Admin']))
                                                                        <option value="{{ $role->id }}">
                                                                            {{ $role->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>

                                                            <div class="d-flex justify-content-end mt-3">
                                                                <button type="submit" class="btn btn-bg-orange btn-sm">Remove</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-bg-blue btn-sm btn-tooltip" data-bs-toggle="modal" data-bs-target="#assignCircleModal{{ $circlememberData->id }}"><i class="bi bi-person-plus"></i>
                                            <span class="btn-text">Assign Circle</span>
                                        </button>

                                        {{-- Modal --}}

                                        <div class="modal fade" id="assignCircleModal{{ $circlememberData->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignCircleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="assignCircleModalLabel">Assign Role
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('assign.circle') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="memberId" value="{{ $circlememberData->id }}">
                                                            <select name="circleId" class="form-select">
                                                                <option value="">Select Circle</option>
                                                                @foreach ($circle as $circles)
                                                                    <option value="{{ $circles->id }}">
                                                                        {{ $circles->circleName }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="d-flex justify-content-end mt-3">
                                                                <button type="submit" class="btn btn-bg-blue btn-sm">Assign
                                                                    Circle</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    {{--
<script>
    $(document).ready(function() {
            $('#filtercircleId, #categoryId, #membershipType').on('change', function() {
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
            $('#filtercircleId, #categoryId, #membershipType').on('change', function() {
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
