<div class="fb-card shadow-sm h-100">
    <div class="fb-card-img-wrapper">
        <span class="fb-badge">{{ $badge }}</span>
        <img src="{{ asset('ProfilePhoto/' . ($member->profilePhoto ?? 'profile.png')) }}" class="fb-card-img"
            alt="Profile Image">
    </div>
    <div class="fb-card-body">
        <h5 class="fb-card-title">{{ $member->firstName }} {{ $member->lastName }}</h5>

        <div class="fb-card-subtitle">
            <i class="bi bi-people-fill"></i>
            {{ $member->circle->circleName ?? 'N/A' }}
        </div>

        <div class="fb-card-info">
            <div class="text-primary fw-bold mb-2">
                <i class="bi bi-star-fill text-warning me-1"></i> {{ $extraInfo }}
            </div>
            @if (!empty($member->companyName))
            <div class="text-truncate" title="{{ $member->companyName }}"><i class="bi bi-building me-1"></i> {{
                $member->companyName }}</div>
            @endif
            @if (!empty($member->bCategory->categoryName))
            <div class="text-truncate" title="{{ $member->bCategory->categoryName }}"><i class="bi bi-tag me-1"></i> {{
                $member->bCategory->categoryName }}</div>
            @endif
        </div>

        <div class="mt-auto">
            <!-- View Profile -->
            <a href="{{ route('foundPersonDetails', $member->id) }}"
                class="fb-btn fb-btn-primary w-100 text-decoration-none">View Profile</a>
        </div>
    </div>
</div>