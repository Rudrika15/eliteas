<style>
    .workshopCard {
        position: relative;
    }

    .workshopCard::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-top: 2px solid transparent;
        border-bottom: 2px solid transparent;
        border-left: 2px solid #007bff;
        /* Left border */
        border-right: 2px solid #007bff;
        /* Right border */
        z-index: 1;
        transition: box-shadow 0.3s ease-in-out;
        /* Add transition for smooth effect */
    }

    .workshopCard:hover::before {
        box-shadow: 0 0 20px rgba(88, 168, 253, 0.4);
        /* Shadow effect on hover */
    }

    .workshopCard .card-body {
        position: relative;
        z-index: 2;
    }

    .p-testimonial-message {
        width: 70%;
        /* this code clamps based on specified lines */
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        display: -webkit-box;
    }
</style>


@if (count($nearestEvents) != 0)
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card-title"><b>Upcoming Events</b></div>
            <div class="card border-0 shadow workshopCard">
                <div class="container mt-4">
                    <div class="row">
                        @foreach ($nearestEvents as $event)
                            @php
                                $evMode = $event->event_mode ?? 'UBN Event';
                                $isSponsor = $evMode === 'Sponsor Event';
                            @endphp
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('events.details', $event->id) }}" class="text-decoration-none">
                                    <div class="card shadow text-center h-100" style="position: relative; overflow: hidden;">
                                        <div style="position: relative;">
                                            <img src="{{ $event->event_banner ? url('Event/' . $event->event_banner) : asset('images/event_default.png') }}" alt="{{ $event->title }}" class="img-fluid rounded-top">
                                            <span style="position: absolute; top: 10px; left: 10px; background: {{ $isSponsor ? '#e76a35' : '#1d2368' }}; color: #ffffff; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.3); display: inline-flex; align-items: center; gap: 4px;">
                                                <i class="bi {{ $isSponsor ? 'bi-award-fill' : 'bi-building-fill' }}" style="font-size: 11px;"></i> {{ $evMode }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title text-center text-dark">{{ $event->title }}</h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-md-12">
            <div class="card-title"><b>Upcoming Events</b></div>
            <div class="card border-0 shadow workshopCard">
                <div class="container mt-3">
                    <div class="row">
                        <p class="text-muted text-center"><b>No Events for now.</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
