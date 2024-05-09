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
            <h4 class="mb-0 mt-3">Circle Member</h4>
            <a href="{{ route('circlemember.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i class="bi bi-plus-circle"></i></a>
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
                        <th>Status</th>
                        <th>Action</th>
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
                        <td>{{$circlememberData->status}}</td>
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