<div class="row">
    <div class="col-md-4">
        <a href="{{ route('schedule.dashIndex') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Upcoming Circle Meetings</b>
                    <i class="bi bi-calendar3" style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- <h2>{{ $count }}</h2> --}}
                </div>
            </div>
        </a>
    </div>

    {{-- <div class="col-md-4">
            <a href="{{ route('pendingPayments.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Pending Payments</b>
                        <i class="bi bi-credit-card"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </a>
        </div> --}}

    {{-- <div class="col-md-4">
            <a href="{{ route('maxMeetings.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Meetings Leaderboard</b>
                        <i class="bi bi-bookmark-star"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                    </div>
                </div>
            </a>
        </div> --}}

    {{-- <div class="col-md-4">
            <a href="{{ route('maxBusiness.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Business Leaderboard</b>
                        <i class="bi bi-bookmark-star"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </a>
        </div> --}}

    {{-- <div class="col-md-4">
            <a href="{{ route('maxReference.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Reference Leaderboard</b>
                        <i class="bi bi-bookmark-star"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </a>
        </div> --}}

    {{-- <div class="col-md-4">
            <a href="{{ route('maxRefferal.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Referral Leaderboard</b>
                        <i class="bi bi-bookmark-star"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </a>
        </div> --}}

    {{-- <div class="col-md-4">
            <a href="{{ route('maxVisitor.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Visitors</b>
                        <i class="bi bi-people"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <h2>{{ $count }}</h2>
                    </div>
                </div>
            </a>
        </div> --}}
</div>
