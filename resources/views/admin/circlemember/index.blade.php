@extends('layouts.master')

@section('header', 'Circle')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Circle Member</h4>
                    <a href="{{ route('circlemember.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
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

                <div class="d-flex align-items-center mb-3">
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
                            <option value="{{ $membershipTypeData->id }}">{{ $membershipTypeData->membershipType }}</option>
                        @endforeach
                    </select>

                    {{-- <select name="membershipType" id="membershipType" class="form-select mt-3">
                    <option value="" selected>Select Membership</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Yearly">Yearly</option>
                    <option value="LifeTime">LifeTime</option>
                </select> --}}
                </div>


                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Circle Name</th>
                                <th>Member Name</th>
                                <th>Business Category</th>
                                <th>Membership Type</th>
                                <th>Roles</th> <!-- New column for roles -->
                                <th>Action</th>
                                <th>Role Action</th> <!-- New column for assigning role -->
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{$member}} --}}
                            @foreach ($member as $circlememberData)
                                <tr>
                                    <th>{{ ($member->currentPage() - 1) * $member->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $circlememberData->circle->circleName ?? '-' }}</td>
                                    <td>{{ $circlememberData->firstName ?? '-' }} {{ $circlememberData->lastName ?? '' }}
                                    </td>
                                    <td>{{ $circlememberData->bCategory->categoryName ?? '-' }}</td>
                                    <td>{{ $circlememberData->membershipType ?? '-' }} </td>
                                    <td>
                                        @foreach ($circlememberData->user->roles as $role)
                                            <span class="badge rounded-pill bg-success">{{ $role->name }}</span>
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('circlemember.activity', $circlememberData->id) }}"
                                            class="btn btn-bg-orange btn-sm btn-tooltip">
                                            <i class="bi bi-info-circle"></i>
                                            <span class="btn-text">Activity</span>
                                        </a>
                                        <a href="{{ route('circlemember.edit', $circlememberData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit Member</span>
                                        </a>
                                        <a href="{{ route('circlemember.delete', $circlememberData->id) }}"
                                            class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete Member</span>
                                        </a>
                                        {{-- <a href="{{ route('circlemember.edit', $circlememberData->id) }}"
                                    class="btn btn-bg-blue btn-sm">
                                    <i class="bi bi-envelope"></i>
                                </a> --}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-bg-blue btn-sm btn-tooltip"
                                            data-bs-toggle="modal"
                                            data-bs-target="#assignRoleModal{{ $circlememberData->id }}"><i
                                                class="bi bi-person-plus"></i>
                                            <span class="btn-text">Assign Role</span>
                                        </button>

                                        {{-- Modal --}}

                                        <div class="modal fade" id="assignRoleModal{{ $circlememberData->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="assignRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="assignRoleModalLabel">Assign Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('assign.role') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="memberId"
                                                                value="{{ $circlememberData->id }}">
                                                            <select name="roleId" class="form-select">
                                                                <option value="">Select Role</option>
                                                                @foreach ($roles as $role)
                                                                    @if (
                                                                        !in_array($role->name, ['Franchise Admin', 'Member', 'Admin', 'Trainer']) &&
                                                                            !$circlememberData->user->roles->contains($role->id))
                                                                        <option value="{{ $role->id }}">
                                                                            {{ $role->name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <div class="d-flex justify-content-end mt-3">
                                                                <button type="submit"
                                                                    class="btn btn-bg-blue btn-sm">Assign</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- //remove role --}}

                                        <button type="button" class="btn btn-danger btn-sm btn-tooltip"
                                            data-bs-toggle="modal"
                                            data-bs-target="#removeRoleModal{{ $circlememberData->id }}"><i
                                                class="bi bi-trash"></i>
                                            <span class="btn-text">Remove Role</span>
                                        </button>
                                        {{-- Modal --}}

                                        <div class="modal fade" id="removeRoleModal{{ $circlememberData->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="removeRoleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="removeRoleModalLabel">Remove Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('remove.role') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="memberId"
                                                                value="{{ $circlememberData->id }}">
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
                                                                <button type="submit"
                                                                    class="btn btn-bg-orange btn-sm">Remove</button>
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
    <script>
        $(document).ready(function() {


            function filterTable() {
                var circleId = $('#filtercircleId').val().trim();

                // console.log("circleId", circleId);

                $('tbody tr').show();

                if (circleId !== '') {
                    $('tbody tr').each(function() {
                        var circleName = $(this).find('td:first').text().trim();

                        if (circleName !== $('#filtercircleId option:selected').text().trim()) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                }
            }


            $('#filtercircleId').change(function() {
                filterTable();
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        console.log('Script loaded for category');

        $(document).ready(function() {
            console.log('Document ready for category - jQuery version:', $.fn.jquery);


            function filterTable() {
                console.log('Filtering table... of category');
                var categoryId = $('#categoryId').val().trim();
                console.log('Selected category ID:', categoryId);


                $('tbody tr').show();


                if (categoryId !== '') {
                    $('tbody tr').each(function() {
                        var categoryName = $(this).find('td:nth-child(3)').text().trim();
                        console.log('Row category name:', categoryName);


                        if (categoryName !== $('#categoryId option:selected').text().trim()) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                }
            }


            $('#categoryId').change(function() {
                console.log('Dropdown selection changed');
                filterTable();
            });
        });
    </script>


    <script>
        $(document).ready(function() {


            function filterTable() {
                console.log('Filtering table... of category and circle');
                var categoryId = $('#categoryId').val().trim();
                var circleId = $('#circleId').val().trim();

                console.log('Selected category ID:', categoryId);
                console.log('Selected circle ID:', circleId);


                $('tbody tr').show();


                if (categoryId !== '' || circleId !== '') {
                    $('tbody tr').each(function() {
                        var categoryName = $(this).find('td:nth-child(3)').text().trim();
                        var circleName = $(this).find('td:first').text().trim();

                        console.log('Row category name:', categoryName);
                        console.log('Row circle name:', circleName);


                        if ((categoryId !== '' && categoryName !== $('#categoryId option:selected').text()
                                .trim()) ||
                            (circleId !== '' && circleName !== $('#circleId option:selected').text().trim())
                        ) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                }
            }


            $('#categoryId,#circleId').change(function() {
                console.log('Dropdown selection changed');
                filterTable();
            });
        });
    </script>



    <script>
        $(document).ready(function() {

            function filterTableByMembershipType() {
                var membershipType = $('#membershipType').val().trim();

                console.log('Selected membership type:', membershipType);


                $('tbody tr').show();


                if (membershipType !== '') {
                    $('tbody tr').each(function() {
                        var membershipTypeText = $(this).find('td:nth-child(4)').text().trim();

                        console.log('Row membership type:', membershipTypeText);


                        if (membershipTypeText !== $('#membershipType option:selected').text().trim()) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                }
            }


            $('#membershipType').change(function() {
                console.log('Dropdown selection changed');
                filterTableByMembershipType();
            });
        });
    </script>



@endsection
