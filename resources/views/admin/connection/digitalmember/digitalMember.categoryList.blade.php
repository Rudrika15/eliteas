@extends('layouts.master')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Left: Categories (col-3) -->
            <div class="col-md-3">
                <h6 class="fw-semibold text-muted mb-3">Categories</h6>

                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" id="categorySearch" class="form-control" placeholder="Search Categories" aria-label="Search Categories" aria-describedby="basic-addon1">
                </div>

                @foreach ($categories as $index => $categoryData)
                    <div class="category-card d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2" data-name="{{ strtolower($categoryData->categoryName ?? '') }}" style="cursor: pointer;" onclick="loadCategoryMembers({{ $categoryData->id }})">

                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-bold text-muted">{{ $index + 1 }}.</span>
                            <img src="{{ $categoryData->categoryIcon ? asset('BusinessCategory/' . $categoryData->categoryIcon) : asset('img/logo2.jpg') }}" class="rounded-circle" width="40" height="40" alt="Category Icon">
                            <div>
                                <div class="fw-semibold">{{ $categoryData->categoryName ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-1 text-muted">
                            <i class="bi bi-people"></i>
                            <span>{{ $categoryData->members_count ?? '0' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Right: Members (col-9) -->
            <div class="col-md-9">
                <h6 class="fw-semibold text-muted mb-3">Members</h6>

                <div id="memberCardsContainer" class="row">
                    <div class="alert alert-info">
                        Select a category to view its members.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Category search filter
            $('#categorySearch').on('keyup', function() {
                const value = $(this).val().toLowerCase();

                $('.category-card').each(function() {
                    const name = $(this).data('name');
                    $(this).toggle(name.includes(value));
                });
            });
        });

        // Load members for selected category (Digital Member route)
        function loadCategoryMembers(categoryId) {
            $('#memberCardsContainer').html('<p class="text-center">Loading...</p>');

            $.ajax({
                url: `/digital-member/connection/${categoryId}/categoryList`, // Updated route
                method: 'GET',
                success: function(response) {
                    if (response.trim() === '') {
                        $('#memberCardsContainer').html('<div class="alert alert-warning">No members found in this category.</div>');
                    } else {
                        $('#memberCardsContainer').html(response);
                    }
                },
                error: function() {
                    $('#memberCardsContainer').html('<div class="alert alert-danger">Failed to load members.</div>');
                }
            });
        }
    </script>
@endsection
