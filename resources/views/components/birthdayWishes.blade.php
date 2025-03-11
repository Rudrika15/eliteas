<div class="row">

    @if (!empty($birthdaysToday) && $birthdaysToday->count() > 0)
    <div class="col-md-12">
        <style>
            .birthday-card {
                width: 100%;
                /* Full width of the card container */
                height: 500px;
                position: relative;
                border: 12px solid #fff;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 10px;
                overflow: hidden;
                text-align: center;
            }

            .birthday-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                position: absolute;
                top: 0;
                left: 0;
                z-index: 1;
            }

            .birthday-overlay {
                width: 100%;
                height: 600px;
                position: absolute;
                top: 0;
                left: 0;
                z-index: 2;
                object-fit: cover;
                background-color: rgba(0, 0, 0, 0.2);
                /* Optional semi-transparent overlay */
            }

            .birthday-text {
                position: absolute;
                bottom: -20px;
                left: 0;
                right: 0;
                color: white;
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                background-color: rgba(0, 0, 0, 0.6);
                padding: 0px;
                z-index: 3;
                border-radius: 5px;
            }
        </style>
        <div class="row">
            @foreach ($birthdaysToday as $birthday)
            <div class="col-md-4">
                <div class="card shadow w-100">
                    <div class="card-header">
                        <b style="color: #1d2856;">Birthday reminders</b>
                        <i class="bi bi-balloon" style="color: rgb(255, 187, 0);"></i>
                    </div>
                    <div class="card-body">
                        <div class="birthday-card">
                            <img class="birthday-image" src="{{ asset('ProfilePhoto') }}/{{ $birthday->profilePhoto }}" alt="Birthday Image">
                            <img class="birthday-overlay" src="{{ asset('templateImage') }}/{{ $templates->templateImage }}" alt="Template Overlay">
                        </div>
                        <div class="birthday-text mt-5">
                            <p>{{ $birthday->firstName }}'s Birthday</p>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>