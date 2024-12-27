@extends('layouts.master')

@section('header', 'Visitor')
@section('content')

    {{-- <style>
        .status-dropdown {
            border: none;
            background: transparent;
            color: inherit;
            font-size: inherit;
            width: 100%;
        }
    </style> --}}

    <style>
        .truncated-text {
            display: inline-block;
            max-width: 120px;
            /* Adjust this width as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: middle;
        }
    </style>


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Visitor</h4>
                    <a href="{{ route('visitors.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip">
                        <i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add New Visitor</span>
                    </a>
                </div>

                <div class="mb-4">
                    <form action="{{ route('visitors.index') }}" method="GET" class="d-flex align-items-end gap-2">
                        <div class="form-group">
                            <label for="name"><b>Name</b></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ request('name') }}" placeholder="Search by name">
                        </div>
                        <div class="form-group">
                            <label for="business_category"><b>Business Category</b></label>
                            <select id="business_category" name="business_category" class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $id => $categoryName)
                                    <option value="{{ $categoryName }}" {{ request('business_category') == $categoryName ? 'selected' : '' }}>
                                        {{ $categoryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city"><b>City</b></label>
                            <select id="city" name="city" class="form-select">
                                <option value="" selected>Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-bg-blue">Filter</button>
                        <a href="{{ route('visitors.index') }}" class="btn btn-bg-orange">Reset</a>
                    </form>
                </div>


                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Mobile No</th>
                                <th>Email</th>
                                <th>Business Name</th>
                                <th>City</th>
                                <th>Business Category</th>
                                <th>Reffered By</th>
                                <th>Other Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $visitorsData)
                                <tr>
                                    <th>{{ ($visitors->currentPage() - 1) * $visitors->perPage() + $loop->index + 1 }}
                                    <td>{{ $visitorsData->firstName ?? '' }} {{ $visitorsData->lastName ?? '' }}</td>
                                    <td>{{ $visitorsData->mobileNo ?? '' }}</td>
                                    <td>
                                        <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $visitorsData->email ?? '' }}">
                                            {{ Str::limit($visitorsData->email ?? '', 12) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $visitorsData->businessName ?? '' }}">
                                            {{ Str::limit($visitorsData->businessName ?? '', 12) }}
                                        </span>
                                    </td>
                                    <td>{{ $visitorsData->city ?? '' }}</td>
                                    {{-- <td>{{ $visitorsData->bCategory->categoryName ?? '' }}</td> --}}
                                    <td>
                                        <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $visitorsData->bCategory->categoryName ?? '' }}">
                                            {{ Str::limit($visitorsData->bCategory->categoryName ?? '', 12) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if (is_numeric($visitorsData->invitedBy))
                                            <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ optional($visitorsData->member)->firstName ?? '' }} {{ optional($visitorsData->member)->lastName ?? '' }}">
                                                {{ Str::limit(optional($visitorsData->member)->firstName . ' ' . optional($visitorsData->member)->lastName, 12) }}
                                            </span>
                                        @else
                                            <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $visitorsData->invitedBy }}">
                                                {{ Str::limit($visitorsData->invitedBy, 12) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="truncated-text" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $visitorsData->otherDetails ?? '' }}">
                                            {{ Str::limit($visitorsData->otherDetails ?? '', 12) }}
                                        </span>
                                    </td>

                                    {{-- <td>{{ $visitorsData->invitedBy }}</td> --}}
                                    {{-- <td>{{ $visitorsData->remarks ?? '' }}</td> --}}
                                    {{-- <td>{{ $visitorsData->status ?? '' }}</td> --}}
                                    <td>
                                        <select class="form-select status-dropdown" data-id="{{ $visitorsData->id }}" style="
            background-color: 
            {{ $visitorsData->status == 'Active'
                ? '#28a745' // Green for Active
                : ($visitorsData->status == 'Inactive'
                    ? '#dc3545' // Red for Inactive
                    : ($visitorsData->status == 'Hold'
                        ? '#ff8c00' // Orange for Hold
                        : ($visitorsData->status == 'Converted'
                            ? '#007bff' // Blue for Converted
                            : ($visitorsData->status == 'Interested'
                                ? '#6f42c1' // Purple for Interested
                                : '')))) }};
            color: #fff; /* White text for better readability */
        ">
                                            <option value="Active" {{ $visitorsData->status == 'Active' ? 'selected' : '' }} style="background-color: #28a745; color: #fff;">Active</option>
                                            <option value="Inactive" {{ $visitorsData->status == 'Inactive' ? 'selected' : '' }} style="background-color: #dc3545; color: #fff;">Inactive</option>
                                            <option value="Hold" {{ $visitorsData->status == 'Hold' ? 'selected' : '' }} style="background-color: #ff8c00; color: #fff;">Hold</option>
                                            <option value="Converted" {{ $visitorsData->status == 'Converted' ? 'selected' : '' }} style="background-color: #007bff; color: #fff;">Converted</option>
                                            <option value="Interested" {{ $visitorsData->status == 'Interested' ? 'selected' : '' }} style="background-color: #6f42c1; color: #fff;">Interested</option>
                                        </select>
                                    </td>


                                    <td>
                                        <a href="{{ route('visitors.remarksView', $visitorsData->id) }}" class="btn btn-bg-orange btn-sm btn-tooltip">
                                            <i class="bi bi-chat-square"></i>
                                            <span class="btn-text">Remarks</span>
                                        </a>

                                        <a href="{{ route('visitors.edit', $visitorsData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('visitors.delete', $visitorsData->id) }}" class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $visitors->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $(document).on('change', '.status-dropdown', function() {
            const visitorId = $(this).data('id');
            const newStatus = $(this).val();

            $.ajax({
                url: "{{ route('visitors.updateStatus') }}", // The route for updating status
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    id: visitorId,
                    status: newStatus,
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Status updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error updating status.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the status.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    </script>


@endsection
