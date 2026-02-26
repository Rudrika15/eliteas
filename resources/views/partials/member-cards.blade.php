<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />


<style>
    .keyword-pill {
        display: inline-block;
        background-color: #f3f5fb;
        color: #3a3a3a;
        font-size: 12px;
        padding: 6px 12px;
        margin: 5px 5px;
        border-radius: 20px;
        border: 1px solid #e0e4f0;
        cursor: default;
    }
</style>


<style>
    .tags span {
        background: #eef1f7;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        margin: 2px;
        display: inline-block;
    }
</style>

<style>
    .fb-card {
        background-color: #ffffff;
        border-radius: 10px;
        overflow: hidden;
        border: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .fb-card-img-wrapper {
        width: 100%;
        padding-top: 100%;
        position: relative;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }

    .fb-card-img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .fb-card-body {
        padding: 16px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        background-color: #ffffff;
    }

    .fb-card-title {
        color: #1d3268;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .fb-card-subtitle {
        color: #65676b;
        font-size: 15px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .fb-card-info {
        color: #65676b;
        font-size: 14px;
        margin-bottom: 16px;
        line-height: 1.5;
    }

    .fb-card-info i {
        color: #e76a35;
    }

    .fb-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #e76a35;
        color: #fff;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .fb-btn {
        width: 100%;
        border: none;
        border-radius: 6px;
        padding: 8px 0;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        justify-content: center;
        align-items: center;
        text-decoration: none;
    }

    .fb-btn:hover {
        text-decoration: none;
    }

    .fb-btn-primary {
        background-color: #1d3268;
        color: #fff;
    }

    .fb-btn-primary:hover {
        background-color: #15244d;
        color: #fff;
    }

    .fb-btn-secondary {
        background-color: #e4e6eb;
        color: #1d3268;
        margin-top: 10px;
    }

    .fb-btn-secondary:hover {
        background-color: #d8dadf;
        color: #1d3268;
    }

    .fb-btn-disabled {
        background-color: #e4e6eb;
        color: #bcc0c4;
        cursor: default;
    }
</style>


<div class="row g-4">
    @forelse ($members as $member)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="fb-card shadow-sm h-100">
                <div class="fb-card-img-wrapper">
                    <span class="fb-badge">Member</span>
                    <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                </div>
                <div class="fb-card-body">
                    <h5 class="fb-card-title">{{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}</h5>
                    <div class="fb-card-subtitle">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $member->circle->circleName ?? 'N/A' }}
                    </div>
                    <div class="fb-card-info">
                        @php
                            $isConnected = in_array($member->connection_status, ['Accepted', 'Connected']) || (isset($authCircleId) && $authCircleId !== null && $member->circleId === null);
                        @endphp
                        <div><i class="bi bi-envelope-fill"></i> {{ $isConnected ? $member->user->email ?? 'N/A' : '****' }}</div>
                        <div><i class="bi bi-telephone-fill"></i> {{ $isConnected ? $member->user->contactNo ?? 'N/A' : '****' }}</div>
                        @if (!empty($member->companyName) || !empty($member->bCategory->categoryName))
                            <div class="fb-card-info">
                                @if (!empty($member->companyName))
                                    <div><i class="bi bi-building"></i> {{ $member->companyName }}</div>
                                @endif
                                @if (!empty($member->bCategory->categoryName))
                                    <div><i class="bi bi-tag"></i> {{ $member->bCategory->categoryName }}</div>
                                @endif
                            </div>
                        @endif
                        @php
                            $keyWords = json_decode($member->keyWords ?? '[]', true);
                        @endphp
                        @if (is_array($keyWords) && count($keyWords) > 0)
                            <div>
                                @foreach ($keyWords as $keyWord)
                                    <span class="keyword-pill">{{ $keyWord }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-auto">
                            <a href="{{ route('foundPersonDetails', $member->id) }}" class="text-decoration-none d-block w-100">
                            <button class="fb-btn fb-btn-primary w-100">View Profile</button>
                        </a>

                        <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                            Inductions - {{ $member->sponsored_count ?? $member->sponsored->count() }}
                        </div>

                        @if ($member->connection_status == 'Connected' || $member->connection_status == 'Accepted')
                                <button type="button" class="fb-btn fb-btn-secondary fb-btn-disabled w-100 mt-2">
                                    <i class="bi bi-check-circle-fill me-2"></i> Connected
                                </button>
                            @elseif ($member->connection_status == 'Pending')
                                <button type="button" class="fb-btn fb-btn-secondary fb-btn-disabled w-100 mt-2">
                                    <i class="bi bi-clock me-2"></i> Requested
                                </button>
                            @else
                                {{-- Not Connected or Rejected --}}
                                <form action="{{ route('connect') }}" class="connectForm d-inline-block w-100 mt-2" method="POST">
                                    @csrf
                                    <input type="hidden" name="memberId" value="{{ $member->id }}">
                                    <button type="submit" class="fb-btn fb-btn-secondary w-100">
                                        <i class="bi bi-person-plus-fill me-2"></i> Connect
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">No active members found.</div>
        </div>
    @endforelse
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    $(document).ready(function() {
        $(document).on('submit', '.connectForm', function(e) {
            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(() => {
                            location.reload(); // Optional: update UI instead
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Info',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.'
                    });
                }
            });
        });
    });
</script>
