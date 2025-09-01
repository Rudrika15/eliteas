@forelse ($receivedRequests ?? [] as $member)
    <div class="col-12 col-sm-6 col-lg-6">
        <div class="profile-card shadow-sm rounded border-0">
            {{-- <img src="https://picsum.photos/600/120" class="header-image" alt="Header Image"> --}}
            <img src="{{ asset('img/header_img.jpeg') }}" class="header-image" alt="Header Image">
            <div class="text-center p-3">
                <img src="{{ asset('ProfilePhoto/' . ($member->receiver->profilePhoto ?? 'logo2.jpg')) }}" class="profile-img img-fluid rounded-circle mx-auto d-block" alt="Profile Image">
                <h5 class="member-name" style="color: #1d3268; font-weight: bold;">
                    {{ $member->user->firstName ?? 'N/A' }} {{ $member->user->lastName ?? 'N/A' }}
                </h5>
                {{-- <p class="position">{{ $member->users->roles ?? 'Position' }}</p> --}}
                <div class="info-section">
                    {{-- @php
                                        $isConnected = in_array($member->connection_status, ['Accepted', 'Connected']);
                                    @endphp --}}
                    <div class="icon-text" title="{{ $member->user->email ?? 'N/A' }}">
                        {{-- <i class="bi bi-envelope-fill text-muted"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#787C80">
                            <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                        </svg>
                        <span>{{ Str::limit($member->user->email ?? 'N/A', 15) }}</span>
                    </div>
                    <div class="icon-text" title="{{ $member->user->contactNo ?? 'N/A' }}">
                        {{-- <i class="bi bi-telephone-fill text-muted"></i> --}}
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#787C80">
                            <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                        </svg>
                        <span>{{ Str::limit($member->user->contactNo ?? 'N/A', 10) }}</span>
                    </div>
                    <div class="icon-text">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#787C80">
                            <path d="M412-168q45-91 120-121.5T660-320q23 0 45 4t43 10q24-38 38-82t14-92q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 45 11.5 86t34.5 76q41-20 85-31t89-11q32 0 61.5 5.5T500-340q-23 12-43.5 28T418-278q-12-2-20.5-2H380q-32 0-63.5 7T256-252q32 32 71.5 53.5T412-168Zm68 88q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80ZM380-420q-58 0-99-41t-41-99q0-58 41-99t99-41q58 0 99 41t41 99q0 58-41 99t-99 41Zm0-80q25 0 42.5-17.5T440-560q0-25-17.5-42.5T380-620q-25 0-42.5 17.5T320-560q0 25 17.5 42.5T380-500Zm280 120q-42 0-71-29t-29-71q0-42 29-71t71-29q42 0 71 29t29 71q0 42-29 71t-71 29ZM480-480Z" />
                        </svg>
                        {{-- <i class="bi bi-people-fill text-muted"></i> --}}
                        <span>{{ $member->members->circle->circleName }}</span>
                    </div>
                </div>
                <div class="company-category-section">
                    <div class="company-section">
                        <div class="logo-section">
                            @if (!empty($member->members->companyLogo))
                                <img src="{{ asset('CompanyLogo/' . $member->members->companyLogo) }}" class="company-logo" alt="Company Logo">
                            @endif
                            <div class="initials" style="{{ empty($member->members->companyLogo) ? 'display:flex;' : 'display:none;' }}">
                                {{ strtoupper(substr($member->members->companyName ?? 'C', 0, 1)) }}
                            </div>
                        </div>
                        <h2 title="{{ $member->members->companyName ?? 'Company Name' }}">
                            {{ $member->members->companyName ?? 'Company Name' }}
                        </h2>
                    </div>
                    <div class="divider"></div>
                    <div class="category-section">
                        <div class="label">Category</div>
                        <h3>{{ $member->members->bCategory->categoryName ?? 'N/A' }}</h3>
                    </div>
                </div>
                <div class="keywords-container row">
                    @php
                        $keyWords = json_decode($member->members->keyWords ?? '[]', true);
                    @endphp
                    @if (is_array($keyWords) && count($keyWords) > 0)
                        @foreach ($keyWords as $keyWord)
                            <span class="keyword-pill col" style="color: #1d3268; font-weight: bold;">{{ $keyWord }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="bottom-actions">
                <div id="viewProfile" class="action-button">
                    <a href="{{ route('foundPersonDetails', $member->members->id) }}">
                        <i class="bi bi-person-lines-fill" style="color: #1d3268;"></i><span style="color: #1d3268;">View Profile</span>
                    </a>
                </div>
                <div class="B-divider"></div>
                <div id="connectButton" class=" right-action btn w-100">
                    <div class="action-icons">
                        <a class="reject" title="Reject" href="{{ route('connection.reject', $member->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#EA3323">
                                <path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="B-divider"></div>
                <div id="connectButton" class=" right-action btn w-100">
                    <div class="action-icons">
                        <a class="accept" title="Accept" href="{{ route('connection.accept', $member->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#2e7d32">
                                <path d="m424-296 282-282-56-56-226 226-114-114-56 56 170 170Zm56 216q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@empty
@endforelse
