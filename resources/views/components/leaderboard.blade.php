<style>
    .leaderBoard .profile-card {
        width: 250px;
        height: 300px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: auto;
        padding: 15px 0;
        position: relative;
        border: 2px solid #e76a35;
    }

    .leaderBoard .card-body {
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .leaderBoard .profile-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 3px solid #1d3268;
    }

    .leaderBoard .profile-title {
        font-size: 14px;
        font-weight: bold;
        color: #e76a35;
        margin-bottom: 5px;
    }

    .leaderBoard .profile-name {
        font-size: 16px;
        font-weight: bold;
        color: #1d3268;
        margin-bottom: 5px;
    }

    .leaderBoard {
        display: flex;
        justify-content: center;
        gap: 20px;
    }
</style>





<div>
    @if ((isset($circlecalls) && count($circlecalls) > 0) || (isset($busGiver) && count($busGiver) > 0) || (isset($refGiver) && count($refGiver) > 0))
    <div class="card-header text-center">
        <b style="color: #1d3268; font-size: 18px;">Leader Board - {{ \Carbon\Carbon::now()->subMonth()->format('F Y') }}</b>
    </div>

    <div class="row g-4 mt-3 leaderBoard">
        @if ($circlecalls)
        <div class="col">
            <div class="profile-card">
                <div class="card-body">
                    <img src="{{ asset('ProfilePhoto/' . ($circlecalls['member']->profilePhoto ?? 'profile.png')) }}" alt="Profile Photo" class="profile-img mb-3 ">
                    <p class="profile-title mb-3">Max Business Meets</p>
                    <h3 class="profile-name mb-3">{{ $circlecalls['member']->firstName }} {{ $circlecalls['member']->lastName }}</h3>
                    <p style="font-size: 14px; color: #1d3268;">Circle: <b>{{ $circlecalls['member']->circle->circleName }}</b></p>
                    <p style="font-size: 14px; color: #1d3268;">Meetings Count: <b>{{ $circlecalls['count'] }}</b></p>
                </div>
            </div>
        </div>
        @endif

        @if ($busGiver)
        <div class="col">
            <div class="profile-card">
                <div class="card-body">
                    <img src="{{ asset('ProfilePhoto/' . ($busGiver['member']->profilePhoto ?? 'profile.png')) }}" alt="Profile Photo" class="profile-img mb-3">
                    <p class="profile-title mb-3">Max Business Leader</p>
                    <h3 class="profile-name mb-3">{{ $busGiver['user']->firstName }} {{ $busGiver['user']->lastName }}</h3>
                    <p style="font-size: 14px; color: #1d3268;">Circle: <b>{{ $busGiver['circle']['circleName'] }}</b></p>
                    <p style="font-size: 14px; color: #1d3268;">Meetings Count: <b>{{ $busGiver['count'] }}</b></p>
                    <p style="font-size: 14px; color: #1d3268;">Amount: <b>{{ $busGiver['amount'] }}</b></p>
                </div>
            </div>
        </div>
        @endif

        @if ($refGiver)
        <div class="col">
            <div class="profile-card">
                <div class="card-body">
                    <img src="{{ asset('ProfilePhoto/' . ($refGiver['profilePhoto'] ?? 'profile.png')) }}" alt="Profile Photo" class="profile-img mb-3">
                    <p class="profile-title mb-3">Top Reference Giver</p>
                    <h3 class="profile-name mb-3">{{ $refGiver['user']->firstName ?? 'N/A' }} {{ $refGiver['user']->lastName ?? 'N/A' }}</h3>
                    <p style="font-size: 14px; color: #1d3268;">Circle: <b>{{ $refGiver['circle'] ?? 'N/A' }}</b></p>
                    <p style="font-size: 14px; color: #1d3268;">References Count: <b>{{ $refGiver['count'] ?? '0' }}</b></p>
                    {{-- <p style="font-size: 14px; color: #1d3268;">Business Category: <b>{{ $refGiver['businessCategory'] ?? 'N/A' }}</b></p> --}}
                    <p style="font-size: 14px; color: #1d3268;"><b>{{ $refGiver['businessCategory'] ?? 'N/A' }}</b></p>
                </div>
            </div>
        </div>
        @endif
    </div>
    @endif


</div>