@extends('layouts.master')
@section('content')
{{-- <style>
    .profile-card {
        width: 100%;
        max-width: 320px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        margin: auto;
    }

    .header-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #fff;
        margin-top: -45px;
    }

    .category-title {
        color: #e76a35;
        font-weight: bold;
    }

    .info-section {
        display: flex;
        justify-content: center;
        text-align: center;
        margin-top: 10px;
    }

    .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 14px;
    }

    .icon-text i {
        font-size: 20px;
        color: #5f6368;
        margin-bottom: 4px;
    }

    .member-count {
        color: #1d3268;
        font-weight: bold;
    }

    .bottom-actions {
        text-align: center;
        padding: 10px;
        border-top: 1px solid #f0f0f0;
    }

    .btn-message {
        background-color: #1d3268;
        color: white;
        border-radius: 50px;
        padding: 6px 14px;
        border: none;
    }

    .card-title {
        font-size: 28px;
        font-weight: bold;
        color: #1d3268;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .profile-card {
            max-width: 100%;
        }
    }
</style> --}}


<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="bg-white p-4 rounded-4 shadow-sm mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="fw-bold text-dark mb-0">
                            <i class="bi bi-grid-fill text-primary me-2"></i> Connection Categories
                        </h4>
                        <p class="text-muted small mb-0 mt-1">Select a category to view associated members</p>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group shadow-sm">
                            <span class="input-group-text bg-primary text-white border-0">
                                <i class="bi bi-filter"></i>
                            </span>
                            <select id="categorySelect" class="form-select border-0 bg-light py-2"
                                aria-label="Select Category" style="cursor: pointer;">
                                <option value="" selected disabled>Choose a Category...</option>
                                @foreach ($categories as $categoryData)
                                <option value="{{ $categoryData->id }}">
                                    {{ $categoryData->categoryName ?? 'N/A' }} ({{ $categoryData->members_count ?? '0'
                                    }} Members)
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Members Section -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                        <h5 class="fw-bold text-muted mb-0">Members List</h5>
                        <span class="badge bg-light text-primary rounded-pill px-3 py-2" id="selectedCategoryBadge">No
                            Category Selected</span>
                    </div>

                    <div id="memberCardsContainer" class="row g-3">
                        <div class="col-12 text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-people display-1 mb-3 text-secondary opacity-25"></i>
                                <h5 class="fw-normal">No Members Displayed</h5>
                                <p class="text-muted small">Please select a category from the dropdown above.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        // Handle dropdown change
        $('#categorySelect').on('change', function() {
            var categoryId = $(this).val();
            var categoryName = $(this).find("option:selected").text().trim();

            if(categoryId) {
                // Update badge text
                $('#selectedCategoryBadge').text(categoryName);
                loadCategoryMembers(categoryId);
            }
        });
    });
</script>


<script>
    // Global function so it's accessible from inline onclick
    function loadCategoryMembers(categoryId) {
        console.log('Loading members for category:', categoryId);
        $('#memberCardsContainer').html('<p class="text-center">Loading...</p>');

        $.ajax({
            url: `/connection/${categoryId}/categoryList`,
            method: 'GET',
            success: function(response) {
                console.log('Members loaded successfully.');
                $('#memberCardsContainer').html(response);
            },
            error: function() {
                console.log('Failed to load members.');
                $('#memberCardsContainer').html('<div class="alert alert-danger">Failed to load members.</div>');
            }
        });
    }
</script>

@endsection
