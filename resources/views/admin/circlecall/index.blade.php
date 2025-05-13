@extends('layouts.master')

@section('title', 'UBN - Business Meet')
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
        <a href="#" class="tab-btn active" data-target="#tabByMe">By Me ({{ $circlecall->total() }})</a>
        <a href="#" class="tab-btn" data-target="#tabByOther">By Other ({{ $callWith->total() }})</a>
        <a href="{{ route('circlecall.create') }}" class="float-end btn btn-sm btn-outline-danger">
            <i class="bi bi-plus-circle"></i> Create IBM
        </a>
    </div>

    <!-- Tab Content: By Me -->
    <div id="tabByMe" class="tab-content active">
        <div class="row">
            @foreach ($circlecall as $circlecallData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="position-relative">
                            <img src="{{ asset('images/card-cover.jpg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ $circlecallData->meetingPerson->profileImage ?? asset('images/default-user.png') }}" class="rounded-circle border border-3 border-white" width="80" alt="Profile">
                                <div class="profile-badge">G</div>
                            </div>
                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                <a href="#" class="text-white" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('circlecall.edit', $circlecallData->id) }}">Edit</a></li>
                                    <li><a class="dropdown-item text-danger" onclick="deleteRow('{{ route('circlecall.delete', $circlecallData->id) }}')">Delete</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body text-center pt-5">
                            <h5 class="card-title mb-0">{{ $circlecallData->meetingPerson->firstName ?? '-' }} {{ $circlecallData->meetingPerson->lastName ?? '-' }}</h5>
                            <p class="text-muted">Vice President at UBN</p>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $circlecallData->meetingPlace ?? '-' }}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i>{{ $circlecallData->date ? date('d-m-Y', strtotime($circlecallData->date)) : '-' }}
                            </div>
                            <div class="card-remark">{{ Str::limit($circlecallData->remarks ?? '', 25) }}{{ strlen($circlecallData->remarks ?? '') > 25 ? '...' : '' }}</div>
                            @if ($circlecallData->meetingImage)
                                <a href="{{ url('meetingImage/' . basename($circlecallData->meetingImage)) }}" target="_blank" class="d-block text-decoration-none text-primary small mb-2">
                                    <i class="bi bi-image"></i> View Uploaded Meeting Image
                                </a>
                            @endif
                            {{-- <div class="d-flex justify-content-between">
                                <a href="{{ route('circlecall.show', $circlecallData->meetingPerson->id) }}" class="btn btn-outline-primary btn-sm w-100 me-1">View Profile</a>
                                <a href="#" class="btn btn-outline-secondary btn-sm w-100 ms-1">Connect</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <!-- Tab Content: By Other -->
    <div id="tabByOther" class="tab-content">
        <div class="row">
            @foreach ($callWith as $callWithData)
                <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                    <div class="card shadow-sm">
                        <div class="position-relative">
                            <img src="{{ asset('images/card-cover.jpg') }}" class="card-img-top" alt="cover">
                            <div class="position-absolute top-100 start-50 translate-middle">
                                <img src="{{ $callWithData->member->profileImage ?? asset('images/default-user.png') }}" class="rounded-circle border border-3 border-white" width="80" alt="Profile">
                                <div class="profile-badge">G</div>
                            </div>
                        </div>
                        <div class="card-body text-center pt-5">
                            <h5 class="card-title mb-0">{{ $callWithData->member->firstName ?? '-' }} {{ $callWithData->member->lastName ?? '-' }}</h5>
                            <p class="text-muted">Vice President at UBN</p>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $callWithData->meetingPlace ?? '-' }}
                            </div>
                            <div class="text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i>{{ $callWithData->date ? date('d-m-Y', strtotime($callWithData->date)) : '-' }}
                            </div>
                            <div class="card-remark">{{ Str::limit($circlecallData->remarks ?? '', 25) }}{{ strlen($circlecallData->remarks ?? '') > 25 ? '...' : '' }}</div>

                            @if ($callWithData->meetingImage)
                                <a href="{{ url('meetingImage/' . basename($callWithData->meetingImage)) }}" target="_blank" class="d-block text-decoration-none text-primary small mb-2">
                                    <i class="bi bi-image"></i> View Uploaded Meeting Image
                                </a>
                            @endif
                            {{-- <div class="d-flex justify-content-center">
                                <a href="{{ route('circlecall.show', $callWithData->member->id) }}" class="btn btn-outline-primary btn-sm">View Profile</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-end">
            {!! $callWith->links() !!}
        </div>
    </div>

    <script>
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                const target = document.querySelector(this.getAttribute('data-target'));
                target.classList.add('active');
            });
        });

        function deleteRow(url) {
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
                    window.location.href = url;
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Circle call has been deleted.',
                        icon: 'success',
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.reload();
                        }
                    })
                }
            })
        }
    </script>




@endsection
