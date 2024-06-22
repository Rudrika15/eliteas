@extends('layouts.master')

@section('header', 'Circle')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Circle Member</h4>
            <a href="{{ route('circlemember.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a>
        </div>

    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('circlemember.export') }}" method="GET">
            <div class="d-flex align-items-center">
                <select name="circleId" id="circleId" class="form-select me-3">
                    <option value="">Select Circle</option>
                    @foreach ($circle as $circleData)
                    <option value="{{ $circleData->id }}">{{ $circleData->circleName }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-file-earmark-excel"></i> Download Excel
                </button>
            </div>
        </form>
    </div>

        <!-- Dropdown for filtering by Circle and Category side by side -->

        <div class="d-flex align-items-center mb-3">
            <small class="text-muted me-3"><strong>Filter By:</strong></small>

            <select name="circleId" id="circleId" class="form-select mt-3 me-3">
                <option value="">Select Circle</option>
                @foreach ($circle as $circleData)
                <option value="{{$circleData->id}}">{{$circleData->circleName}}</option>
                @endforeach
            </select>

            <select name="categoryId" id="categoryId" class="form-select mt-3 me-3">
                <option value="">Select Category</option>
                @foreach ($bCategory as $categoryData)
                <option value="{{$categoryData->id}}">{{$categoryData->categoryName}}</option>
                @endforeach
            </select>

            <select name="membershipType" id="membershipType" class="form-select mt-3">
                <option value="" selected>Select Membership</option>
                <option value="Monthly">Monthly</option>
                <option value="Yearly">Yearly</option>
                <option value="LifeTime">LifeTime</option>
            </select>
        </div>


        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable table-responsive">
                <thead>
                    <tr>
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
                        <td>{{$circlememberData->circle->circleName ?? '-'}}</td>
                        <td>{{$circlememberData->firstName ?? '-'}} {{$circlememberData->lastName
                            ?? ''}}</td>
                        <td>{{$circlememberData->bCategory->categoryName ?? '-'}}</td>
                        <td>{{$circlememberData->membershipType ?? '-'}} </td>
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
                                class="btn btn-bg-orange btn-sm">
                                <i class="bi bi-info-circle"></i>
                            </a>
                            <a href="{{ route('circlemember.edit', $circlememberData->id) }}"
                                class="btn btn-bg-blue btn-sm">
                                <i class="bi bi-pen"></i>
                            </a>
                            <a href="{{ route('circlemember.delete') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>
                            <a href="{{ route('circlemember.edit', $circlememberData->id) }}"
                                class="btn btn-bg-blue btn-sm">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-bg-blue btn-sm" data-bs-toggle="modal"
                                data-bs-target="#assignRoleModal{{ $circlememberData->id }}"><i
                                    class="bi bi-person-plus"></i>
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
                                                    @foreach($roles as $role)
                                                    @if (!in_array($role->name, ['Franchise Admin', 'Member', 'Admin']))
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- //remove role --}}

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#removeRoleModal{{ $circlememberData->id }}"><i
                                    class="bi bi-trash"></i>
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
                                                    @foreach($circlememberData->user->roles as $role)
                                                    @if (!in_array($role->name, ['Member', 'Trainer', 'Admin']))
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
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
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    console.log('Script loaded for circle');

    $(document).ready(function() {
        console.log('Document ready for circle - jQuery version:', $.fn.jquery);

        // Function to filter table rows based on selected Circle
        function filterTable() {
            console.log('Filtering table... of circle');
            var circleId = $('#circleId').val().trim();
            console.log('Selected circle ID:', circleId);

            // Show all rows initially
            $('tbody tr').show();

            // Filter rows based on selected Circle
            if (circleId !== '') {
                $('tbody tr').each(function() {
                    var circleName = $(this).find('td:first').text().trim();
                    console.log('Row circle name:', circleName);

                    // Check if row matches the selected Circle
                    if (circleName !== $('#circleId option:selected').text().trim()) {
                        $(this).hide();
                    } else {
                        $(this).show(); // Ensure row is shown if matched
                    }
                });
            }
        }

        // Trigger filter on Circle dropdown change
        $('#circleId').change(function() {
            console.log('Dropdown selection changed');
            filterTable();
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    console.log('Script loaded for category');  

    $(document).ready(function() {
        console.log('Document ready for category - jQuery version:', $.fn.jquery);

        // Function to filter table rows based on selected Category
        function filterTable() {
            console.log('Filtering table... of category');
            var categoryId = $('#categoryId').val().trim();
            console.log('Selected category ID:', categoryId);

            // Show all rows initially
            $('tbody tr').show();

            // Filter rows based on selected Category
            if (categoryId !== '') {
                $('tbody tr').each(function() {
                    var categoryName = $(this).find('td:nth-child(3)').text().trim();
                    console.log('Row category name:', categoryName);

                    // Check if row matches the selected Category
                    if (categoryName !== $('#categoryId option:selected').text().trim()) {
                        $(this).hide();
                    } else {
                        $(this).show(); // Ensure row is shown if matched
                    }
                });
            }
        }

        // Trigger filter on Category dropdown change
        $('#categoryId').change(function() {
            console.log('Dropdown selection changed');
            filterTable();
        });
    });

</script>


<script>
    $(document).ready(function() {

        // Function to filter table rows based on selected Category and Circle
        function filterTable() {
            console.log('Filtering table... of category and circle');
            var categoryId = $('#categoryId').val().trim();
            var circleId = $('#circleId').val().trim();

            console.log('Selected category ID:', categoryId);
            console.log('Selected circle ID:', circleId);

            // Show all rows initially
            $('tbody tr').show();

            // Filter rows based on selected Category and Circle
            if (categoryId !== '' || circleId !== '') {
                $('tbody tr').each(function() {
                    var categoryName = $(this).find('td:nth-child(3)').text().trim();
                    var circleName = $(this).find('td:first').text().trim();

                    console.log('Row category name:', categoryName);
                    console.log('Row circle name:', circleName);

                    // Check if row matches the selected Category and Circle
                    if ((categoryId !== '' && categoryName !== $('#categoryId option:selected').text().trim()) ||
                        (circleId !== '' && circleName !== $('#circleId option:selected').text().trim())) {
                        $(this).hide();
                    } else {
                        $(this).show(); // Ensure row is shown if matched
                    }
                });
            }
        }

        // Trigger filter on both dropdown change
        $('#categoryId,#circleId').change(function() {
            console.log('Dropdown selection changed');
            filterTable();
        });
    });

</script>



<script>
    $(document).ready(function() {
        // Function to filter table rows based on selected Membership Type
        function filterTableByMembershipType() {
            var membershipType = $('#membershipType').val().trim();

            console.log('Selected membership type:', membershipType);

            // Show all rows initially
            $('tbody tr').show();

            // Filter rows based on selected Membership Type
            if (membershipType !== '') {
                $('tbody tr').each(function() {
                    var membershipTypeText = $(this).find('td:nth-child(4)').text().trim();

                    console.log('Row membership type:', membershipTypeText);

                    // Check if row matches the selected Membership Type
                    if (membershipTypeText !== $('#membershipType option:selected').text().trim()) {
                        $(this).hide();
                    } else {
                        $(this).show(); // Ensure row is shown if matched
                    }
                });
            }
        }

        // Trigger filter on Membership Type dropdown change
        $('#membershipType').change(function() {
            console.log('Dropdown selection changed');
            filterTableByMembershipType();
        });
    });

</script>



@endsection