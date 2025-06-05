<form class="circlecallForm" id="callForm" enctype="multipart/form-data" method="post" action="{{ route('circlecall.update', $circlecall->id) }}" novalidate>
    @csrf
    <input type="hidden" name="id" value="{{ $circlecall->id }}">

    {{-- @include('circleMemberMaster') --}}

    <div class="card p-3 shadow-sm border-0 rounded">

        <!-- Circle Dropdown -->

        <div class="mb-3">
            <label for="circleId" class="form-label fw-bold color-blue required">Circle <span class="text-danger">*</span></label>
            <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                <option value="" selected disabled>Select Circle</option>
                @if (old('circleId'))
                    <option value="{{ old('circleId') }}" selected>{{ old('circleName') }}</option>
                @else
                    <option value="{{ $circlecall->circleId }}" selected>
                        {{ $circlecall->meetingPerson->circle->circleName }}
                    </option>
                @endif
                @foreach ($circles as $circle)
                    <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                @endforeach
            </select>
            {{-- <label for="circleId">Circle</label> --}}
            @error('circleId')
                <div class="invalid-tooltip">
                    This field is required.
                </div>
            @enderror
        </div>

        <!-- Member Dropdown -->
        <div class="mb-3">
            <label for="memberId" class="form-label fw-bold color-blue required">Member <span class="text-danger">*</span></label>
            <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                <option value="" selected disabled>Select Member</option>
                @if (old('memberId'))
                    <option value="{{ old('memberId') }}" selected> {{ old('memberName') }}</option>
                @else
                    <option value="{{ $circlecall->meetingPersonId }}" selected>
                        {{ $circlecall->meetingPerson->firstName }} {{ $circlecall->meetingPerson->lastName }}
                    </option>
                @endif
                <!-- Options will be populated dynamically -->
            </select>
            {{-- <label for="memberId">Member</label> --}}
            @error('memberId')
                <div class="invalid-tooltip">
                    This field is required.
                </div>
            @enderror
        </div>

        <div class="row mb-3 mt-3">
            <div class="mb-3">
                <label for="meetingPersonName" class="form-label fw-bold color-blue required">Meeting Person Name <span class="text-danger">*</span></label>
                <input type="hidden" id="meetingPersonId" name="meetingPersonId" value="{{ $circlecall->meetingPersonId }}" required>
                <input type="text" class="form-control " readonly id="meetingPersonName" placeholder="Select Member" value="{{ $circlecall->meetingPerson->firstName }} {{ $circlecall->meetingPerson->lastName }}" disabled required>
                {{-- <label for="memberName">Meeting Person Name</label> --}}
                @error('meetingPersonId')
                    <div class="invalid-tooltip">
                        This field is required.
                    </div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="meetingPlace" class="form-label fw-bold color-blue required">Meeting Place Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="meetingPlace" name="meetingPlace" placeholder="Meeting Place Name" required value="{{ old('meetingPlace', $circlecall->meetingPlace) }}">
            {{-- <label for="meetingPlace">Meeting Place Name</label> --}}
            <span class="error-message text-danger"></span> <!-- Error message placeholder -->
        </div>


        <div class="mb-3">
            <label class="form-label fw-bold color-blue required">Upload Meeting Image <span class="text-danger">*</span></label>
            <input type="file" class="form-control @error('meetingImage') is-invalid @enderror" id="meetingImage" name="meetingImage" accept="image/*" required onchange="previewPhoto(event)" {{ ($oldMeetingImage = old('meetingImage')) ? 'data-old-value="' . $oldMeetingImage . '"' : '' }}>
            {{-- <label for="meetingImage">Upload Meeting Image</label> --}}
            <span class="text-danger mt-1 d-block">*
                File size:Max 2MB</span>
            @error('meetingImage')
                <div class="invalid-tooltip">
                    The Maximum file size is 2MB
                </div>
            @enderror
        </div>

        <!-- Photo Preview Section -->
        <div class="mt-1">
            <img id="photoPreview" src="{{ $circlecall->meetingImage ? asset('meetingImage/' . $circlecall->meetingImage) : asset('img/profile.png') }}" alt="Meeting Image" style="width: 100px; height: 100px; object-fit: contain; aspect-ratio: 1/1;" />
        </div>

        <script>
            function previewPhoto(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('photoPreview');

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block'; // Show the image
                    }

                    reader.readAsDataURL(file); // Read the file as a data URL
                }
            }
        </script>


        <div class="mb-3">
            <div class="form-floating mt-3">
                <?php
                use Illuminate\Support\Carbon;
                
                $nearestDate = $scheduleDate->min();
                $nearestDate = $nearestDate ? Carbon::parse($nearestDate)->subDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');
                $selectedDate = request()->input('date') ?? (Carbon::now()->format('Y-m-d') == $nearestDate ? Carbon::now()->format('Y-m-d') : $nearestDate);
                ?>
                <input type="date" class="form-control" id="date" name="date" placeholder="Meeting Date" required min="{{ $lastDate }}" max="{{ $nearestDate }}" value="{{ old('date', $circlecall->date) }}" disabled>
                <label for="date">Date</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="remarks" class="form-label fw-bold color-blue">Remarks <span class="text-danger">*</span> </label>

            <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks" required>{{ old('remarks', $circlecall->remarks) }}</textarea>
            {{-- <label for="remarks">Remarks</label> --}}
        </div>
        <div class="text-center mt-5">
            {{-- <button type="submit" class="btn btn-bg-blue">Submit</button> --}}

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="cancel-btn" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="create-btn">Edit IBM</button>
            </div>

            {{-- <button type="reset" class="btn btn-bg-orange">Reset</button> --}}
        </div>
    </div>
</form><!-- End floating Labels Form -->



