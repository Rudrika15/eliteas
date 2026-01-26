@extends('layouts.master')

@section('header', 'City')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Business Category</h4>
                    <a href="{{ route('bCategory.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Business Category</span>
                    </a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Category Name</th>
                                <th>Member's Count</th>
                                <th>Photo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($businessCategory as $businessCategoryData)
                                <tr>
                                    <th>{{ ($businessCategory->currentPage() - 1) * $businessCategory->perPage() + $loop->index + 1 }}

                                    <td>{{ $businessCategoryData->categoryName ?? '-' }}</td>
                                    <td>{{ $businessCategoryData->members_count ?? 0 }}</td>
                                    <td>
                                        @if ($businessCategoryData->categoryIcon)
                                            <img src="{{ asset('public/BusinessCategory/' . $businessCategoryData->categoryIcon) }}" alt="{{ $businessCategoryData->categoryIcon }}" width="50" height="50">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $businessCategoryData->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info btn-tooltip" onclick="showMembers({{ $businessCategoryData->id }})">
                                            <i class="bi bi-eye"></i>
                                            <span class="btn-text">View Members</span>
                                        </button>
                                        <a href="{{ route('bCategory.edit', $businessCategoryData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                        <a href="{{ route('bCategory.delete', $businessCategoryData->id) }}" class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>

                                        {{-- <form action="{{ route('city.delete', $cityData->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> <!-- Icon for delete -->
                                    </button>
                                </form> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $businessCategory->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <!-- Members Modal -->
    <div class="modal fade" id="membersModal" tabindex="-1" aria-labelledby="membersModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="membersModalLabel">Category Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="membersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Circle</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="membersTableBody">
                                <!-- Data will be populated here -->
                            </tbody>
                        </table>
                    </div>
                    <div id="noMembersMessage" class="text-center p-3 d-none">
                        <p class="text-muted">No members found in this category.</p>
                    </div>
                    <div id="loadingSpinner" class="text-center p-3 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showMembers(categoryId) {
            const modal = new bootstrap.Modal(document.getElementById('membersModal'));
            const tableBody = document.getElementById('membersTableBody');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const noMembersMessage = document.getElementById('noMembersMessage');
            const membersTable = document.getElementById('membersTable');

            // Reset state
            tableBody.innerHTML = '';
            membersTable.classList.add('d-none');
            noMembersMessage.classList.add('d-none');
            loadingSpinner.classList.remove('d-none');

            modal.show();

            fetch(`{{ url('bCategory/members') }}/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    loadingSpinner.classList.add('d-none');

                    if (data.members && data.members.length > 0) {
                        membersTable.classList.remove('d-none');
                        data.members.forEach(member => {
                        let statusBadge = '';
                        if (member.status === 'Active') {
                            statusBadge = '<span class="badge bg-success">Active</span>';
                        } else {
                            statusBadge = `<span class="badge bg-danger">${member.status}</span>`;
                        }

                        const row = `
                            <tr>
                                <td>${member.firstName} ${member.lastName}</td>
                                <td>${member.user ? member.user.email : '-'}</td>
                                <td>${member.user ? member.user.contactNo : '-'}</td>
                                <td>${member.circle ? member.circle.circleName : '-'}</td>
                                <td>${statusBadge}</td>
                            </tr>
                        `;
                        tableBody.innerHTML += row;
                    });
                    } else {
                        noMembersMessage.classList.remove('d-none');
                    }
                })
                .catch(error => {
                    loadingSpinner.classList.add('d-none');
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error loading members</td></tr>';
                    membersTable.classList.remove('d-none');
                });
        }
    </script>

@endsection



{{-- @extends('layouts.master')

@section('header', 'City')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Business Category</h4>
                <a href="{{ route('bCategory.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                        class="bi bi-plus-circle"></i>
                    <span class="btn-text">Add Business Category</span>
                </a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Category Name</th>
                            <th>Member's Count</th>
                            <th>Photo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businessCategory as $businessCategoryData)
                        <tr>
                            <th>{{ ($businessCategory->currentPage() - 1) * $businessCategory->perPage() + $loop->index
                                + 1 }}

                            <td>{{ $businessCategoryData->categoryName ?? '-' }}</td>
                          	<td>{{ $businessCategoryData->members_count ?? 0 }}</td>
                            <td>
                                @if ($businessCategoryData->categoryIcon)
                                <img src="{{ asset('public/BusinessCategory/' . $businessCategoryData->categoryIcon) }}"
                                    alt="{{ $businessCategoryData->categoryIcon }}" width="50" height="50">
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ $businessCategoryData->status }}</td>
                            <td>
                                <a href="{{ route('bCategory.edit', $businessCategoryData->id) }}"
                                    class="btn btn-bg-blue btn-sm btn-tooltip">
                                    <i class="bi bi-pen"></i>
                                    <span class="btn-text">Edit</span>
                                </a>

                                {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                {{-- <a href="{{ route('bCategory.delete', $businessCategoryData->id) }}"
                                    class="btn btn-danger btn-sm btn-tooltip">
                                    <i class="bi bi-trash"></i>
                                    <span class="btn-text">Delete</span>
                                </a> --}}

                                {{-- <form action="{{ route('city.delete', $cityData->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> <!-- Icon for delete -->
                                    </button>
                                </form> --}}
                            {{-- </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $businessCategory->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>
</div>
@endsection --}} 