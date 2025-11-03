@foreach ($members as $member)
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body">
                <img src="{{ asset($member->profilePicture ?? 'img/logo2.jpg') }}" class="rounded-circle mb-2" width="60" height="60" alt="Profile">
                <h6 class="circle-name mb-0">
                    {{ $member->firstName ?? '' }} {{ $member->lastName ?? '' }}
                </h6>
                <small class="text-muted">
                    {{ $member->city->cityName ?? 'N/A' }}
                </small>
            </div>
        </div>
    </div>
@endforeach

@if ($members->isEmpty())
    <p class="text-center text-muted mt-3">No members found for this city.</p>
@endif
