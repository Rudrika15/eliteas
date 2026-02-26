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
    .fb-card-body { padding: 16px; flex-grow: 1; display: flex; flex-direction: column; background-color: #ffffff; }
    .fb-card-title { color: #1d3268; font-size: 20px; font-weight: 700; margin-bottom: 4px; line-height: 1.2; }
    .fb-card-subtitle { color: #65676b; font-size: 15px; margin-bottom: 16px; display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .fb-card-info { color: #65676b; font-size: 14px; margin-bottom: 16px; line-height: 1.5; }
    .fb-card-info i { color: #e76a35; }
    .fb-badge { position: absolute; top: 10px; left: 10px; background: #e76a35; color: #fff; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; z-index: 10; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); }
    .fb-btn { width: 100%; border: none; border-radius: 6px; padding: 8px 0; font-weight: 600; font-size: 15px; cursor: pointer; transition: background 0.2s; display: flex; justify-content: center; align-items: center; text-decoration: none; }
    .fb-btn:hover { text-decoration: none; }
    .fb-btn-primary { background-color: #1d3268; color: #fff; }
    .fb-btn-primary:hover { background-color: #15244d; color: #fff; }
    .fb-btn-secondary { background-color: #e4e6eb; color: #1d3268; margin-top: 10px; }
    .fb-btn-secondary:hover { background-color: #d8dadf; color: #1d3268; }
    .fb-btn-disabled { background-color: #e4e6eb; color: #bcc0c4; cursor: default; }
</style>

<div class="row row-cols-3 g-4">
    @forelse ($connections ?? [] as $member)
        <div class="col">
            <div class="fb-card shadow-sm h-100">
                <div class="fb-card-img-wrapper">
                    <span class="fb-badge">Member</span>
                    <img src="{{ asset('ProfilePhoto/' . ($member->connectedMember->profilePhoto ?? 'profile.png')) }}" class="fb-card-img" alt="Profile Image">
                </div>
                <div class="fb-card-body">
                    <h5 class="fb-card-title">{{ $member->connectedUser->firstName ?? 'N/A' }} {{ $member->connectedUser->lastName ?? 'N/A' }}</h5>
                    <div class="fb-card-subtitle">
                        <i class="bi bi-geo-alt-fill"></i>
                        {{ $member->connectedMember->circle->circleName ?? ($member->connectedMember->city->cityName ?? 'N/A') }}
                    </div>
                    <div class="fb-card-info">
                        <div><i class="bi bi-envelope-fill"></i> {{ $member->connectedUser->email ?? 'N/A' }}</div>
                        <div><i class="bi bi-telephone-fill"></i> {{ $member->connectedUser->contactNo ?? 'N/A' }}</div>
                    </div>
                    @if(!empty($member->connectedMember->companyName) || !empty($member->connectedMember->bCategory->categoryName))
                        <div class="fb-card-info">
                            @if(!empty($member->connectedMember->companyName))
                                <div><i class="bi bi-building"></i> {{ $member->connectedMember->companyName }}</div>
                            @endif
                            @if(!empty($member->connectedMember->bCategory->categoryName))
                                <div><i class="bi bi-tag"></i> {{ $member->connectedMember->bCategory->categoryName }}</div>
                            @endif
                        </div>
                    @endif
                    @php
                        $keyWords = json_decode($member->connectedMember->keyWords ?? '[]', true);
                    @endphp
                    @if (is_array($keyWords) && count($keyWords) > 0)
                        <div>
                            @foreach ($keyWords as $keyWord)
                                <span class="keyword-pill">{{ $keyWord }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="mt-auto">
                        <a href="{{ route('foundPersonDetails', $member->connectedMember->id) }}" class="fb-btn fb-btn-primary w-100 text-decoration-none">View Profile</a>
                        
                        <div class="mt-2 text-center fw-bold" style="color: #1d3268;">
                            Inductions - {{ $member->connectedMember->sponsored_count ?? $member->connectedMember->sponsored->count() }}
                        </div>

                        <button type="button" class="fb-btn fb-btn-secondary fb-btn-disabled w-100 mt-2">
                            <i class="bi bi-check-circle-fill me-2"></i> Connected
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
</div>
