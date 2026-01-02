<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />


<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        /* spacing between cards */
    }

    .profile-card {
        width: 100%;
        /* fit to column */
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        margin-bottom: 20px;
        /* changed from centered to spaced for flexbox */
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
    }

    .header-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-top: -50px;
    }

    h5 {
        margin-top: 10px;
        margin-bottom: 4px;
        font-weight: 700;
        color: #1d3268;
    }

    .position {
        color: #1d3268;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .info-section {
        display: flex;
        justify-content: space-around;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .icon-text {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 13px;
        flex: 1;
    }

    .icon-text i {
        font-size: 22px;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .company-category-section {
        display: flex;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        gap: 20px;
    }

    .company-section,
    .category-section {
        flex: 1;
        min-width: 0;
        /* prevents overflow issues */
        text-align: center;
        word-wrap: break-word;
    }

    .company-section h2,
    .category-section h3 {
        white-space: normal;
        /* Allows text to wrap */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* Limits to 2 lines */
        -webkit-box-orient: vertical;
        word-wrap: break-word;
        line-height: 1.4;
        /* Adjust for better readability */
        max-width: 100%;
    }

    .B-divider {
        width: 1px;
        background-color: #dcdcdc;
        height: 60px;
    }


    .logo-section {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 8px;
    }

    .logo-section img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e0e0e0;
    }

    .company-section h2,
    .category-section h3 {
        margin: 6px 0;
        color: #1d2951;
        font-size: 16px;
        font-weight: bold;
    }

    .category-section .label {
        color: gray;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .keywords-container {
        text-align: center;
        margin: 15px 20px 10px;
    }

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

    .bottom-actions {
        display: flex;
        justify-content: space-between;
        /* Move buttons to corners */
        align-items: center;
        border-top: 1px solid #e6e6e6;
        padding: 10px 0;
        text-align: center;
        width: 100%;

    }

    .action-button {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        color: #1d2951;
        transition: color 0.2s;
        text-decoration: none;
        padding: 10px;
        gap: 8px;
        /* Space between icon and text */
    }

    .action-button.connected {
        color: #e76a35 !important;
        /* Orange color for connected users */
    }


    .action-button i {
        font-size: 16px;
        /* Adjust icon size if needed */
    }

    .divider {
        width: 1px;
        background-color: #e6e6e6;
        height: 100px;
    }


    .bottom-actions div:hover {
        color: #e76a35;
    }

    .bottom-divider {
        width: 1px;
        background-color: #e0e0e0;
        height: 25px;
    }

    /* Responsive adjustments handled by Bootstrap grid */
    @media screen and (max-width: 768px) {
        .icon-text {
            font-size: 10px;
        }
    }

    @media screen and (max-width: 320px) {
        .icon-text {
            font-size: 9px;
        }
    }


    .initials {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #c1c1c1;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        /* mix-blend-mode: color-burn; */

    }
</style>


<style>
    body {
        background-color: #f8f9fa;
    }

    .circle-logo-sm {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
    }

    .member-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .member-card-header {
        background-color: #f1f3f5;
        position: relative;
        height: 70px;
    }

    .profile-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid #fff;
        background-color: #fff;
        /* position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%); */
        object-fit: cover;
    }

    .member-card-body {
        padding: 1.5rem 1rem 1rem;
    }

    .member-card-footer {
        padding: 0.75rem 1rem;
        border-top: 1px solid #e9ecef;
    }

    .tags span {
        background: #eef1f7;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        margin: 2px;
        display: inline-block;
    }

    @media (max-width: 768px) {
        .profile-img {
            top: -30px;
            width: 60px;
            height: 60px;
        }
    }

    .circle-card.active {
        border: 2px solid #4F46E5;
        background-color: #EEF2FF;
        transition: 0.2s ease-in-out;
    }
</style>


<div class="row g-4">
    @forelse ($members as $member)
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="profile-card shadow-sm rounded border-0">
            {{-- <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image"> --}}
            <img src="{{ asset('img/header_img.jpeg') }}" class="header-image" alt="Header Image">
            <div class="text-center p-3">
                <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'logo2.jpg')) }}"
                    class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">
                <h5 class="member-name" style="color: #1d3268; font-weight: bold;">
                    {{ $member->firstName ?? 'N/A' }} {{ $member->lastName ?? 'N/A' }}
                </h5>
                {{-- <p class="position">{{ $member->users->roles ?? 'Position' }}</p> --}}
                <div class="info-section">
                    @php
                    $isConnected = in_array($member->connection_status, ['Accepted', 'Connected']) ||
                    (isset($authCircleId)
                    && $authCircleId !== null && $member->circleId === null);
                    @endphp
                    <div class="icon-text" title="{{ $isConnected ? $member->user->email ?? 'N/A' : '****' }}">
                        {{-- <i class="bi bi-envelope-fill text-muted"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#787C80">
                            <path
                                d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                        </svg>
                        <span>{{ $isConnected ? Str::limit($member->user->email ?? 'N/A', 15) : '****' }}</span>
                    </div>
                    <div class="icon-text" title="{{ $isConnected ? $member->user->contactNo ?? 'N/A' : '****' }}">
                        {{-- <i class="bi bi-telephone-fill text-muted"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#787C80">
                            <path
                                d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                        </svg>
                        <span>{{ $isConnected ? Str::limit($member->user->contactNo ?? 'N/A', 10) : '****' }}</span>
                    </div>
                    <div class="icon-text">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#787C80">
                            <path
                                d="M412-168q45-91 120-121.5T660-320q23 0 45 4t43 10q24-38 38-82t14-92q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 45 11.5 86t34.5 76q41-20 85-31t89-11q32 0 61.5 5.5T500-340q-23 12-43.5 28T418-278q-12-2-20.5-2H380q-32 0-63.5 7T256-252q32 32 71.5 53.5T412-168Zm68 88q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80ZM380-420q-58 0-99-41t-41-99q0-58 41-99t99-41q58 0 99 41t41 99q0 58-41 99t-99 41Zm0-80q25 0 42.5-17.5T440-560q0-25-17.5-42.5T380-620q-25 0-42.5 17.5T320-560q0 25 17.5 42.5T380-500Zm280 120q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM480-480Z" />
                        </svg>
                        {{-- <i class="bi bi-people-fill text-muted"></i> --}}
                        <span>{{ $member->circle->circleName ?? 'N/A' }}</span>
                    </div>
                </div>
                <div class="company-category-section">
                    <div class="company-section">
                        <div class="logo-section">
                            @if (!empty($member->companyLogo))
                            <img src="{{ asset('CompanyLogo/' . $member->companyLogo) }}" class="company-logo"
                                alt="Company Logo">
                            @endif
                            <div class="initials"
                                style="{{ empty($member->companyLogo) ? 'display:flex;' : 'display:none;' }}">
                                {{ strtoupper(substr($member->companyName ?? 'C', 0, 1)) }}
                            </div>
                        </div>
                        <h2 title="{{ $member->companyName ?? 'Company Name' }}">
                            {{ $member->companyName ?? 'Company Name' }}
                        </h2>
                    </div>
                    <div class="divider"></div>
                    <div class="category-section">
                        <div class="label">Category</div>
                        <h3>{{ $member->bCategory->categoryName ?? 'N/A' }}</h3>
                    </div>
                </div>
                <div class="keywords-container row">
                    @php
                    $keyWords = json_decode($member->keyWords ?? '[]', true);
                    @endphp
                    @if (is_array($keyWords) && count($keyWords) > 0)
                    @foreach ($keyWords as $keyWord)
                    <span class="keyword-pill col" style="color: #1d3268; font-weight: bold;">{{ $keyWord }}</span>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="bottom-actions">
                <div id="viewProfile" class="action-button left-action">
                    <a href="{{ route('foundPersonDetails', $member->id) }}">
                        <i class="bi bi-person-lines-fill" style="color: #1d3268;"></i><span
                            style="color: #1d3268;">View
                            Profile</span>
                    </a>
                </div>
                <div class="B-divider"></div>
                <div id="connectButton" class="action-button right-action btn w-100">
                    @php
                    $sameCircleConnected = ($authCircleId !== null && $member->circleId !== null && $member->circleId ==
                    $authCircleId);
                    $actuallyConnected = ($member->connection_status == 'Connected' || $member->connection_status ==
                    'Accepted');
                    $showConnected = $sameCircleConnected || $actuallyConnected;
                    @endphp
                    @if ($showConnected)
                    <button type="button" class="btn btn-connect fw-bold shadow-none" style="color: #e76a35;">
                        Connected &nbsp;<i class="bi bi-check-circle-fill" style="color: #e76a35;"></i>
                    </button>
                    @elseif ($member->connection_status == 'Not Connected')
                    <form action="{{ route('connect') }}" class="connectForm d-inline-block" method="POST"
                        class="d-inline-block">
                        @csrf
                        <input type="hidden" name="memberId" value="{{ $member->id }}">
                        <button type="submit" class="btn btn-connect shadow-none fw-bold" style="color: #1d3268;">
                            Connect &nbsp;<i class="bi bi-person-plus-fill fw-bold" style="color: #1d3268;"></i>
                        </button>
                    </form>
                    @elseif ($member->connection_status == 'Pending')
                    <button type="button" class="btn btn-connect fw-bold shadow-none" style="color: #e76a35;">
                        Requested &nbsp;<i class="bi bi-clock" style="color: #e76a35;"></i>
                    </button>
                    @elseif ($member->connection_status == 'Rejected')
                    <form action="{{ route('connect') }}" class="connectForm d-inline-block" method="POST"
                        class="d-inline-block">
                        @csrf
                        <input type="hidden" name="memberId" value="{{ $member->id }}">
                        <button type="submit" class="btn btn-connect shadow-none fw-bold" style="color: #1d3268;">
                            Connect &nbsp;<i class="bi bi-person-plus-fill fw-bold" style="color: #1d3268;"></i>
                        </button>
                    </form>
                    @endif
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
