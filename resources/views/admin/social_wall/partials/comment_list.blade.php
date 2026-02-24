@foreach ($comments as $comment)
    @php
        $commentMember = optional($comment->user->member);
        $commentPhoto = $commentMember->profilePhoto ?? null;
        $canDelete = Auth::id() === $comment->userId || Auth::user()->role === 'Admin';
        $canEdit = Auth::id() === $comment->userId;
        $pfx = isset($prefix) ? $prefix : '';
    @endphp
    <div class="single-comment" id="{{ $pfx }}comment-container-{{ $comment->id }}">
        <img src="{{ $commentPhoto ? asset($commentPhoto) : asset('profile.png') }}" class="comment-avatar" onerror="this.src='{{ asset('profile.png') }}'">
        <div class="comment-bubble">
            <h6>{{ $comment->user->firstName }} {{ $comment->user->lastName }}</h6>
            <p id="{{ $pfx }}comment-text-{{ $comment->id }}">{{ $comment->comment }}</p>
            @if ($canEdit)
                <div id="{{ $pfx }}edit-comment-area-{{ $comment->id }}" style="display: none;">
                    <input type="text" class="form-control form-control-sm mb-1" id="{{ $pfx }}edit-comment-input-{{ $comment->id }}" value="{{ $comment->comment }}">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm py-0 px-2" onclick="saveComment({{ $comment->id }}, '{{ $pfx }}')">Save</button>
                        <button class="btn btn-secondary btn-sm py-0 px-2" onclick="cancelEditComment({{ $comment->id }}, '{{ $pfx }}')">Cancel</button>
                    </div>
                </div>
            @endif
        </div>
        @if ($canDelete || $canEdit)
            <div class="comment-options">
                <button class="comment-options-btn" onclick="toggleCommentOptions(event, {{ $comment->id }}, '{{ $pfx }}')">
                    <i class="bi bi-three-dots"></i>
                </button>
                <div class="comment-options-dropdown" id="{{ $pfx }}comment-options-{{ $comment->id }}">
                    @if ($canEdit)
                        <button class="comment-option-item" onclick="enableEditComment({{ $comment->id }}, '{{ $pfx }}')">Edit</button>
                    @endif
                    @if ($canDelete)
                        <button class="comment-option-item delete" onclick="deleteComment({{ $comment->id }}, '{{ $pfx }}')">Delete</button>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endforeach