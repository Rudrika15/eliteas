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
    <div class="row">
        <!-- Left: Categories (col-3) -->
        <div class="col-md-3">
            <h6 class="fw-semibold text-muted mb-3">Categories</h6>

            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input type="text" id="categorySearch" class="form-control" placeholder="Search Categories"
                    aria-label="Search Categories" aria-describedby="basic-addon1">

            </div>

            @foreach ($categories as $index => $categoryData)
            <div class="category-card d-flex justify-content-between align-items-center bg-white rounded shadow-sm p-2 mb-2"
                data-name="{{ strtolower($categoryData->categoryName ?? '') }}" style="cursor: pointer;"
                onclick="loadCategoryMembers({{ $categoryData->id }})">


                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold text-muted">{{ $index + 1 }}.</span>
                    <img src="{{ $categoryData->categoryIcon ? asset('BusinessCategory/' . $categoryData->categoryIcon) : asset('img/profile.png') }}"
                        class="rounded-circle" width="40" height="40" alt="Category Icon">
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
            <!-- You can dynamically load members here based on selected category -->
            <h6 class="fw-semibold text-muted mb-3">Members</h6>

            {{-- Example member cards can go here --}}
            <div class="alert alert-info">
                Select a category to view its members.
            </div>

            <div id="memberCardsContainer" class="row">

            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
            function debounce(fn, ms) {
                let t;
                return function() {
                    clearTimeout(t);
                    const args = arguments;
                    const ctx = this;
                    t = setTimeout(function(){ fn.apply(ctx, args); }, ms);
                };
            }

            const runFilter = debounce(function() {
                const q = ($('#categorySearch').val() || '').toLowerCase().trim();
                $('.category-card').each(function() {
                    const dataName = (($(this).data('name')) || '').toString().toLowerCase();
                    const textName = ($(this).find('.fw-semibold').text() || '').toLowerCase();
                    const match = q === '' || dataName.includes(q) || textName.includes(q);
                    $(this).toggleClass('d-none', !match);
                });
            }, 150);

            $('#categorySearch').on('input', runFilter);
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
