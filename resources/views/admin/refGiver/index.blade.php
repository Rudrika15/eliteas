@extends('layouts.master')

@section('title', 'UBN - Referance')
@section('content')

    <style>
        .tab-navigation {
            border-bottom: 2px solid #eaeaea;
            margin-bottom: 1rem;
        }

        .tab-navigation a {
            padding: 10px 20px;
            display: inline-block;
            text-decoration: none;
            font-weight: 600;
            color: #333;
        }

        .tab-navigation a.active {
            color: #ff6600;
            border-bottom: 3px solid #ff6600;
        }

        .profile-badge {
            position: absolute;
            top: 65%;
            left: 58%;
            transform: translate(-50%, -50%);
            background: #ffcc00;
            color: white;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: bold;
        }

        .card-remark {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 10px;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 10px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }
    </style>

    <div class="tab-navigation mb-3">
        <a href="#" class="tab-btn active" data-target="#tabByMe">Received ({{ $busGiver->count() }})</a>
        <a href="#" class="tab-btn" data-target="#tabByOther">Given ({{ $refGiver->count() }})</a>
        {{-- <a href="{{ route('circlecall.create') }}" class="float-end btn btn-sm btn-bg-orange">
        <i class="bi bi-plus-circle"></i> Create IBM
    </a> --}}

        <button type="button" class="float-end btn btn-bg-orange" data-bs-toggle="modal" data-bs-target="#createIBMModal">
            Create Reference
        </button>
    </div>



    <div id="tabByMe" class="tab-content active" style="display: block;">
        <div class="row">
            @foreach ($busGiver as $busGiverData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="https://picsum.photos/700/200?random={{ rand(1, 1000) }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ optional($busGiverData->businessGiverMember)->profilePhoto ? asset('ProfilePhoto/' . $busGiverData->businessGiverMember->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                            </div>
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <a href="#" class="text-black" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                {{-- <ul class="dropdown-menu">
                                    <li><a class="dropdown-item color-blue" href="{{ route('circlecall.edit', $busGiverData->id) }}"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                    <li><a class="dropdown-item text-danger" onclick="deleteRow('{{ route('circlecall.delete', $busGiverData->id) }}')"><i class="bi bi-trash me-2"></i>Delete</a></li>
                                </ul> --}}
                            </div>
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            {{-- Meeting Person Name --}}
                            <h5 class="card-title mb-0">
                                {{ $busGiverData->businessGiver->firstName ?? '-' }} {{ $busGiverData->businessGiver->lastName ?? '-' }}
                            </h5>

                            {{-- Circle Name and Date --}}
                            <div class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1 color-blue"></i> <span class="color-blue"> {{ $busGiverData->businessGiverMember->circle->circleName ?? '-' }} </span>
                                <span class="me-4"></span>
                                <i class="bi bi-calendar3 me-1 color-blue"></i> <span class="color-blue">{{ $busGiverData->date ? date('d-m-Y', strtotime($busGiverData->date)) : '-' }} </span>
                            </div>

                            {{-- Amount --}}
                            <div class="text-muted small mb-2">
                                <strong class="color-blue"> ₹ {{ $busGiverData->amount ?? '-' }} </strong>
                            </div>

                            {{-- Remarks --}}
                            <div class="card-remark text-muted small mb-2">
                                <span class="color-blue">{{ Str::limit($busGiverData->remarks ?? '', 25) }}{{ strlen($busGiverData->remarks ?? '') > 25 ? '...' : '' }} </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>








    <div id="tabByOther" class="tab-content active" style="display: none;">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <a href="{{ route('refGiver.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                <i class="bi bi-plus-circle"></i>
                <span class="btn-text">Add Reference Details</span>
            </a>
        </div>
        <div class="row mt-4">
            @foreach ($refGiver as $refGiverData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow rounded-4 overflow-hidden">
                        <div class="position-relative">
                            <img src="https://picsum.photos/700/200?random={{ rand(1, 1000) }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ optional($refGiverData->members)->profilePhoto ? asset('ProfilePhoto/' . $refGiverData->members->profilePhoto) : asset('ProfilePhoto/profile.png') }}" class="rounded-circle border border-3 border-white" width="110" height="110" alt="Profile">
                            </div>
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <a href="#" class="text-black" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item color-blue" href="{{ route('refGiver.edit', $refGiverData->id) }}"><i class="bi bi-pencil-square me-2"></i>Edit</a></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete('{{ route('refGiver.delete', $refGiverData->id) }}')">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body text-center pt-5 mt-3">
                            {{-- Referred Person Name --}}
                            <h5 class="card-title mb-0">{{ $refGiverData->members->firstName ?? '-' }} {{ $refGiverData->members->lastName ?? '-' }} </h5>

                            {{-- Member Name & Date --}}
                            <div class="text-muted small mb-2">
                                <i class="bi bi-person-circle me-1 color-blue"></i>
                                <span class="color-blue">
                                    {{ $refGiverData->members->circle->circleName ?? '-' }}
                                </span>
                                <span class="me-4"></span>
                                <i class="bi bi-calendar3 me-1 color-blue"></i>
                                <span class="color-blue">
                                    {{ \Carbon\Carbon::parse($refGiverData->created_at)->format('d-m-Y') ?? '-' }}
                                </span>
                            </div>

                            {{-- Contact & Email
                                    <div class="text-muted small mb-2">
                                        <div><strong class="color-blue">📞 {{ $refGiverData->contactNo ?? ($refGiverData->members->user->contactNo ?? '-') }}</strong></div>
                                        <div><strong class="color-blue">✉️ {{ $refGiverData->email ?? ($refGiverData->members->user->email ?? '-') }}</strong></div>
                                    </div> --}}

                            {{-- Scale & Status --}}
                            <div class="text-muted small mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $refGiverData->scale >= $i ? '-fill' : '' }} text-warning"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        {{-- <div class="d-flex justify-content-end custom-pagination">
            {!! $refGiver->links() !!}
        </div> --}}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createIBMModal" tabindex="-1" aria-labelledby="createIBMModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-3 shadow">
                <div class="modal-header bg-light border-bottom-0">
                    <h5 class="modal-title" id="createIBMModalLabel">Circle Meeting Member Reference</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form class="needs-validation" id="meetingMemberRefForm" enctype="multipart/form-data" method="post" action="{{ route('refGiver.store') }}" novalidate>
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="internal" value="internal" checked>
                                    <label class="form-check-label" for="internal">Internal</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group" id="external" value="external">
                                    <label class="form-check-label" for="external">External</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                                        <option value="" selected disabled>Select Circle</option>
                                        <option value="{{ old('circleId', auth()->user()->member->circleId) }}" selected>
                                            {{ $circles->where('id', old('circleId', auth()->user()->member->circleId))->first()->circleName ?? '' }}
                                        </option>
                                        @foreach ($circles as $circle)
                                            <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                                        @endforeach
                                    </select>
                                    <label for="circleId">Circle</label>
                                    @error('circleId')
                                        <div class="invalid-tooltip">This field is required.</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                                        <option value="" disabled>Select Member</option>
                                    </select>
                                    <label for="memberId">Member</label>
                                    @error('memberId')
                                        <div class="invalid-tooltip">This field is required.</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="meetingPersonId" name="memberId">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="meetingPersonName" name="memberName" placeholder="Select Member" readonly disabled>
                            <label for="memberName">Member Name</label>
                            @error('memberId')
                                <div class="invalid-tooltip">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="" id="memberListInput" style="display:none;">
                            <h4 class="mt-3 text-blue">Contact Person Details</h4>

                            <div class="form-floating mt-3">
                                <input type="text" class="form-control @error('contactName') is-invalid @enderror" name="contactNameExternal" placeholder="Contact Name">
                                <label for="contactName">Contact Person Name</label>
                                @error('contactName')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" class="form-control @error('contactNo') is-invalid @enderror selectedMemberContact" id="contactPersonContact" name="contactNo" placeholder="Contact No" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                <label for="contactNo">Contact No</label>
                                @error('contactNo')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="contactPersonEmail" name="email" placeholder="email">
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="description">
                                <label for="description">Description</label>
                                @error('description')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="scale">Scale [1-5]</label>
                            <div class="form-floating mt-3">
                                <input type="range" class="form-range @error('scale') is-invalid @enderror" id="scale" name="scale" placeholder="scale" required min="1" max="5" step="1">
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <span class="badge btn-bg-blue rounded-pill">1</span>
                                    <span class="badge btn-bg-blue rounded-pill">2</span>
                                    <span class="badge btn-bg-blue rounded-pill">3</span>
                                    <span class="badge btn-bg-blue rounded-pill">4</span>
                                    <span class="badge btn-bg-blue rounded-pill">5</span>
                                </div>
                                @error('scale')
                                    <div class="invalid-tooltip">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-bg-blue">Submit</button>
                            <button type="reset" class="btn btn-bg-orange">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('#deleteRefGiver{{ $refGiverData->id }}').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1d2856',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('href');
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.tab-btn').click(function(e) {
                e.preventDefault();

                // Remove active class from all buttons and hide all content
                $('.tab-btn').removeClass('active');
                $('.tab-content').hide();

                // Add active class to clicked tab
                $(this).addClass('active');

                // Show target tab content
                let target = $(this).data('target');
                $(target).show();
            });
        });
    </script>




    {{-- //ref by other --}}


@endsection
