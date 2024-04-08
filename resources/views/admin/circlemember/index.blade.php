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
            <a href="{{ route('circlemember.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a>
        </div>

        <!-- Dropdown for filtering by Circle -->
        <div class="d-flex align-items-center">
            <select name="circleId" id="circleId" class="form-control mt-3 w-25">
                <option value="">Select Circle</option>
                @foreach ($circle as $circleData)
                <option value="{{$circleData->id}}">{{$circleData->circleName}}</option>
                @endforeach
            </select>
        </div>

        <!-- Dropdown for filtering by Category -->
        <div class="d-flex align-items-center ml-3">
            <select name="categoryId" id="categoryId" class="form-control mt-3 w-25">
                <option value="">Select Category</option>
                @foreach ($bCategory as $categoryData)
                <option value="{{$categoryData->id}}">{{$categoryData->categoryName}}</option>
                @endforeach
            </select>
        </div>


        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Circle Name</th>
                    <th>Member Name</th>
                    <th>Business Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($circlemember as $circlememberData)
                <tr>
                    <td>{{$circlememberData->circle->circleName ?? '-'}}</td>
                    <td>{{$circlememberData->member->firstName ?? '-'}} {{$circlememberData->member->lastName
                        ?? 'not found'}}</td>
                    <td>{{$circlememberData->member->bCategory->categoryName ?? '-'}}</td>
                    <td>{{$circlememberData->status}}</td>
                    <td>
                        <a href="{{ route('circlemember.edit', $circlememberData->id) }}"
                            class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>
                        <a href="{{ route('circlemember.delete', $circlememberData->id) }}"
                            class="btn btn-danger btn-sm">
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
<script>
    console.log('Script loaded for category');

    $(document).ready(function() {
        console.log('Document ready for category - jQuery version:', $.fn.jquery);

        // Function to filter table rows based on selected Circle
        function filterTable() {
            console.log('Filtering table... of category');
            var categoryId = $('#categroyId').val().trim();
            console.log('Selected category ID:', categoryId);

            // Show all rows initially
            $('tbody tr').show();

            // Filter rows based on selected Circle
            if (categoryId !== '') {
                $('tbody tr').each(function() {
                    var categoryName = $(this).find('td:first').text() || ''; // Handle cases where text is undefined or null
                    categoryName = categoryName.trim();
                    console.log('Row Category name:', categoryName);

                    // Check if row matches the selected Circle
                    if (categoryName !== $('#categoryId option:selected').text().trim()) {
                        $(this).hide();
                    } else {
                        $(this).show(); // Ensure row is shown if matched
                    }
                });
            }
        }

        // Trigger filter on Circle dropdown change
        $('#categoryId').change(function() {
            console.log('Dropdown selection changed');
            filterTable();
        });
    });
</script>

@endsection