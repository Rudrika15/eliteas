@auth
@if (!auth()->user()->hasRole('Admin'))
@if (count($testimonials) > 0)
<div class="row">
    <div class="col-md-12">
        <div class="card-title text-center text"><b>Testimonials</b></div>
    </div>
</div>
<div class="row" style=" position: relative;">
    <div class="col-md-9" style="position: relative; left: 50%; transform: translateX(-50%);">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style=" position: relative;">
            <div class="carousel-inner">
                @foreach ($testimonials as $key => $testimonial)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="position: relative;">
                    <div class="card" style="border-radius:10px; height:250px; box-shadow: 0 4px 6px rgba(0,0,0,.1);">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            {{-- {{asset('/')}} --}}
                            {{-- {{$testimonial->member->profilePhoto}} --}}
                            <img src="{{ asset('ProfilePhoto/' . $testimonial->sender->profilePhoto) }}" alt="Profile" class="rounded-circle img-thumbnail object-fit-cover" style="height: 100px;width:100px;">
                            <h3>{{ $testimonial->sender->firstName . ' ' . $testimonial->sender->lastName }}
                            </h3>
                            <p class="text-center text-muted text-wrap p-testimonial-message"><i class="bi bi-quote text-dark" style="font-size: 20px;"></i>{{ $testimonial->message }}<i class="bi bi-quote text-dark" style="font-size: 20px;display:inline-block;transform:rotate(180deg);"></i>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
@endif
@endauth

@endif