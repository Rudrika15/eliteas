@extends('layouts.master')

@section('title', 'UBN - Network Feed')

@section('content')
    <style>
        #preview-container {
            max-height: 80px;
        }

        /* Custom scrollbar for preview container */
        #preview-container::-webkit-scrollbar {
            height: 6px;
        }

        #preview-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        #preview-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        #preview-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .social-wall-layout {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 12px;
        }

        @media (min-width: 992px) {
            .social-wall-layout {
                padding: 0 24px;
            }
        }

        .social-wall-container {
            width: 100%;
            margin: 0;
        }

        .social-wall-sidebar {
            position: sticky;
            top: 90px;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 16px;
        }

        .sidebar-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .sidebar-title {
            font-weight: 700;
            font-size: 14px;
            color: #222;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .sidebar-title i {
            color: #0d6efd;
        }

        .sidebar-badge {
            font-size: 12px;
            font-weight: 700;
            color: #0d6efd;
            background: rgba(13, 110, 253, 0.1);
            padding: 3px 10px;
            border-radius: 999px;
        }

        .sidebar-scroll {
            max-height: 320px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 3px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #a9a9a9;
        }

        .sidebar-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        .recent-post-item {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
            transition: background-color .15s ease, box-shadow .15s ease;
        }

        .recent-post-item:hover {
            background: #f7f9ff;
            box-shadow: inset 0 0 0 1px rgba(13, 110, 253, .15);
        }

        .recent-post-item:active {
            background: #eef4ff;
        }

        .recent-post-snippet {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-highlight {
            box-shadow: 0 0 0 2px rgba(13, 110, 253, .35), 0 6px 18px rgba(0, 0, 0, 0.08);
            scroll-margin-top: 90px;
        }

        .create-post-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px;
        }

        .post-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .post-header {
            padding: 15px;
            display: flex;
            align-items: center;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .post-user-info h6 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .post-user-info span {
            font-size: 12px;
            color: #777;
        }

        .post-content {
            padding: 0 15px 15px;
        }

        .post-text {
            margin-bottom: 10px;
            white-space: pre-wrap;
        }

        .post-media-grid {
            display: grid;
            gap: 2px;
            width: 100%;
            overflow: hidden;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .post-media-grid.grid-1 {
            grid-template-columns: 1fr;
            height: clamp(260px, 45vw, 420px);
        }

        .post-media-grid.grid-2 {
            grid-template-columns: 1fr 1fr;
            height: 240px;
        }

        .post-media-grid.grid-3 {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 320px;
        }

        .post-media-grid.grid-3 .media-item:first-child {
            grid-row: span 2;
        }

        .post-media-grid.grid-4 {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 320px;
        }

        .post-media-grid.grid-5-plus {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            height: 320px;
        }

        /* Removed span 2 for grid-5-plus to allow 2x2 grid for 4 items */

        .media-item {
            position: relative;
            width: 100%;
            height: 100%;
            background: #000;
            cursor: pointer;
            overflow: hidden;
        }

        .media-item img,
        .media-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .more-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            pointer-events: none;
        }

        /* Lightbox Modal */
        #lightbox-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
        }

        #lightbox-content {
            max-width: 90%;
            max-height: 90%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #lightbox-content img,
        #lightbox-content video {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
        }

        #lightbox-close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10000;
        }

        #lightbox-close:hover,
        #lightbox-close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .post-actions {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 10px 15px;
            display: flex;
            justify-content: space-around;
        }

        .action-btn {
            background: none;
            border: none;
            color: #555;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn:hover {
            background-color: #f0f2f5;
            border-radius: 4px;
        }

        .action-btn.liked {
            color: #007bff;
            /* Use site theme color here */
        }

        .post-stats {
            padding: 10px 15px;
            font-size: 13px;
            color: #777;
            display: flex;
            justify-content: space-between;
        }

        .comment-section {
            padding: 10px 15px;
            background: #fcfcfc;
            display: none;
            /* Hidden by default, toggled via JS */
        }

        .comment-input-area {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            position: relative;
            align-items: center;
        }

        .comment-input-wrapper {
            flex: 1;
            position: relative;
            display: flex;
            align-items: center;
        }

        .comment-input-area input {
            width: 100%;
            border-radius: 20px;
            padding: 8px 35px 8px 15px;
            /* Added right padding for send button */
            border: 1px solid #ddd;
            background: #f0f2f5;
            outline: none;
        }

        .comment-send-btn {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            color: #0d6efd;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .comment-send-btn:hover {
            color: #0056b3;
        }

        .comment-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .single-comment {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .single-comment:hover .comment-options {
            display: block;
        }

        .comment-options {
            display: none;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .comment-options-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #65676b;
            padding: 2px 6px;
            font-size: 14px;
        }

        /* Dropdown style for options */
        .comment-options-dropdown {
            position: absolute;
            right: 10px;
            top: 25px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 100;
            display: none;
            min-width: 100px;
            overflow: hidden;
        }

        .comment-options-dropdown.show {
            display: block;
        }

        .comment-option-item {
            display: block;
            width: 100%;
            padding: 8px 12px;
            text-align: left;
            background: none;
            border: none;
            font-size: 13px;
            color: #333;
            cursor: pointer;
        }

        .comment-option-item:hover {
            background-color: #f0f2f5;
        }

        .comment-option-item.delete {
            color: #dc3545;
        }

        .comment-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        .comment-bubble {
            background: #f0f2f5;
            border-radius: 15px;
            padding: 8px 12px;
            flex: 1;
        }

        .comment-bubble h6 {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
        }

        .comment-bubble p {
            margin: 0;
            font-size: 13px;
        }

        /* Validation & Progress */
        #validation-errors {
            display: none;
            margin-bottom: 10px;
        }

        #progress-container {
            display: none;
            margin-top: 10px;
        }

        .progress {
            height: 20px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #0d6efd;
            transition: width .6s ease;
        }

        #success-animation {
            display: none;
            text-align: center;
            margin-top: 10px;
            color: #28a745;
        }

        .preview-item {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .preview-item img,
        .preview-item video {
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
        }
    </style>

    <div class="social-wall-layout">
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-lg-8 col-xl-7">
                <div class="social-wall-container">
                    {{-- Create Post --}}
                    <div class="create-post-card">
                        <form id="create-post-form" onsubmit="uploadPost(event)" enctype="multipart/form-data">
                            <div class="mb-3">
                                <textarea name="caption" class="form-control border-0" rows="2" placeholder="What's on your mind?"></textarea>
                            </div>

                            {{-- Validation Errors --}}
                            <div id="validation-errors"></div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                <div>
                                    <label class="btn btn-sm btn-light text-primary mb-0" style="cursor: pointer;">
                                        <i class="bi bi-image"></i> Photo
                                        <input type="file" name="attachments[]" accept="image/*" multiple hidden onchange="previewFiles(this)">
                                    </label>
                                    <span id="file-count" class="ms-2 text-muted small"></span>
                                </div>
                                <button type="submit" id="upload-btn" class="btn btn-primary btn-sm px-4">Post</button>
                            </div>

                            {{-- Previews --}}
                            <div id="preview-container" class="mt-2" style="display:none; white-space: nowrap; overflow-x: auto;">
                                {{-- Previews will be injected here --}}
                            </div>

                            {{-- Progress Bar --}}
                            <div id="progress-container">
                                <div class="progress">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                                <small class="text-muted text-center d-block mt-1">Uploading...</small>
                            </div>

                            {{-- Success Animation --}}
                            <div id="success-animation">
                                <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                                <p>Post created successfully!</p>
                            </div>
                        </form>
                    </div>

                    {{-- Posts Feed --}}
                    @foreach ($posts as $post)
                        <div class="post-card" id="post-{{ $post->id }}">
                            <div class="post-header">
                                @php
                                    $postUserMember = optional($post->user->member);
                                    $postUserPhoto = $postUserMember->profilePhoto ?? null;
                                @endphp
                                <img src="{{ $postUserPhoto ? asset($postUserPhoto) : asset('profile.png') }}" alt="User" class="post-avatar" onerror="this.src='{{ asset('profile.png') }}'">
                                <div class="post-user-info">
                                    <h6>{{ $post->user->firstName }} {{ $post->user->lastName }}</h6>
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>

                                @if (Auth::id() === $post->userId || Auth::user()->role === 'Admin')
                                    <div class="ms-auto dropdown">
                                        <button class="btn btn-link text-dark p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @if (Auth::id() === $post->userId)
                                                <li><a class="dropdown-item" href="javascript:void(0)" onclick="openEditPostModal({{ $post->id }})"><i class="bi bi-pencil me-2"></i>Edit Post</a></li>
                                            @endif
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deletePost({{ $post->id }})"><i class="bi bi-trash me-2"></i>Delete Post</a></li>
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            <div class="post-content">
                                @if ($post->caption)
                                    <div class="post-text">{{ $post->caption }}</div>
                                @endif

                                {{-- Multiple Media Support --}}
                                @if ($post->media && $post->media->count() > 0)
                                    @php
                                        $mediaCount = $post->media->count();
                                        $gridClass = '';
                                        if ($mediaCount == 1) {
                                            $gridClass = 'grid-1';
                                        } elseif ($mediaCount == 2) {
                                            $gridClass = 'grid-2';
                                        } elseif ($mediaCount == 3) {
                                            $gridClass = 'grid-3';
                                        } elseif ($mediaCount == 4) {
                                            $gridClass = 'grid-4';
                                        } else {
                                            $gridClass = 'grid-5-plus';
                                        }

                                        $mediaList = $post->media->map(function ($m) {
                                            return [
                                                'src' => asset($m->file_path),
                                                'type' => $m->file_type,
                                                'ext' => pathinfo($m->file_path, PATHINFO_EXTENSION),
                                            ];
                                        });

                                        $displayMedia = $post->media->take(4);
                                    @endphp
                                    <div class="post-media-grid {{ $gridClass }}" data-media="{{ json_encode($mediaList) }}">
                                        @foreach ($displayMedia as $index => $media)
                                            @php
                                                $isLast = $index === 3;
                                                $remaining = $mediaCount - 4;
                                            @endphp
                                            <div class="media-item" onclick="openGallery(this, {{ $index }})">
                                                @if ($media->file_type === 'image' || in_array(strtolower(pathinfo($media->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <img src="{{ asset($media->file_path) }}" alt="Post Attachment">
                                                @else
                                                    <video>
                                                        <source src="{{ asset($media->file_path) }}" type="video/{{ pathinfo($media->file_path, PATHINFO_EXTENSION) }}">
                                                    </video>
                                                @endif

                                                @if ($isLast && $remaining > 0)
                                                    <div class="more-overlay">+{{ $remaining }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- Legacy Single Attachment Support --}}
                                @elseif ($post->attachment)
                                    <div class="post-media-grid grid-1">
                                        <div class="media-item" onclick="openLightbox('{{ asset($post->attachment) }}', '{{ pathinfo($post->attachment, PATHINFO_EXTENSION) }}')">
                                            @php
                                                $ext = pathinfo($post->attachment, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            @endphp
                                            @if ($isImage)
                                                <img src="{{ asset($post->attachment) }}" alt="Post Attachment">
                                            @else
                                                <video>
                                                    <source src="{{ asset($post->attachment) }}" type="video/{{ $ext }}">
                                                </video>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="post-stats">
                                <span id="like-count-{{ $post->id }}">{{ $post->likes_count }} Likes</span>
                                <span onclick="toggleComments({{ $post->id }})" style="cursor: pointer;">{{ $post->comments_count }} Comments</span>
                            </div>

                            <div class="post-actions">
                                <button type="button" class="action-btn {{ $post->isLikedByCurrentUser ? 'liked' : '' }}" onclick="toggleLike({{ $post->id }}, this)">
                                    <i class="bi {{ $post->isLikedByCurrentUser ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i> Like
                                </button>
                                <button type="button" class="action-btn" onclick="toggleComments({{ $post->id }})">
                                    <i class="bi bi-chat"></i> Comment
                                </button>
                            </div>

                            <div class="comment-section" id="comments-{{ $post->id }}">
                                <div class="comment-input-area">
                                    @php
                                        $authMember = optional(Auth::user()->member);
                                        $authPhoto = $authMember->profilePhoto ?? null;
                                    @endphp
                                    <img src="{{ $authPhoto ? asset($authPhoto) : asset('profile.png') }}" class="comment-avatar" onerror="this.src='{{ asset('profile.png') }}'">
                                    <div class="comment-input-wrapper">
                                        <input type="text" placeholder="Write a comment..." id="comment-input-{{ $post->id }}" onkeypress="handleCommentSubmit(event, {{ $post->id }})">
                                        <button class="comment-send-btn" onclick="submitComment({{ $post->id }})">
                                            <i class="bi bi-send-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="comment-list" id="comment-list-{{ $post->id }}">
                                    @include('admin.social_wall.partials.comment_list', ['comments' => $post->comments->take(3), 'prefix' => ''])
                                    @if ($post->comments->count() > 3)
                                        <div class="text-center mt-2">
                                            <button class="btn btn-link btn-sm" onclick="showAllComments({{ $post->id }})">See more comments</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block col-lg-4 col-xl-4 col-xxl-3">
                <div class="social-wall-sidebar">
                    <div class="sidebar-card">
                        <div class="sidebar-card-header">
                            <div class="sidebar-title"><i class="bi bi-bell"></i> Notifications</div>
                            @php
                                $items = isset($notifications) ? $notifications : collect();
                            @endphp
                            <div class="sidebar-badge">{{ $items->count() }}</div>
                        </div>
                        <div class="sidebar-scroll">
                            @forelse ($items as $n)
                                @php
                                    $actor = $n['actor'] ?? null;
                                    $actorMember = optional($actor?->member);
                                    $actorPhoto = $actorMember->profilePhoto ?? null;
                                    $name = 'Someone';
                                    if ($actor) {
                                        $name = $actor->id === Auth::id() ? 'You' : $actor->firstName . ' ' . $actor->lastName;
                                    }
                                    $message = $n['type'] === 'comment' ? 'commented on your post' : 'liked your post';
                                    $time = \Carbon\Carbon::parse($n['created_at'])->diffForHumans();
                                @endphp
                                <a class="recent-post-item mb-2" href="#post-{{ $n['postId'] }}" onclick="openPostFromSidebar({{ $n['postId'] }}, '{{ $n['type'] }}')">
                                    <img src="{{ $actorPhoto ? asset($actorPhoto) : asset('profile.png') }}" alt="User" class="sidebar-avatar" onerror="this.src='{{ asset('profile.png') }}'">
                                    <div class="flex-grow-1" style="min-width: 0;">
                                        <div class="small"><span class="fw-semibold">{{ $name }}</span> {{ $message }}</div>
                                        @if (($n['type'] ?? '') === 'comment' && !empty($n['comment'] ?? ''))
                                            <div class="text-muted small recent-post-snippet">"{{ \Illuminate\Support\Str::limit($n['comment'], 80) }}"</div>
                                        @endif
                                        <div class="text-muted" style="font-size: 11px;">{{ $time }}</div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-muted small">No notifications yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <div class="sidebar-card-header">
                            <div class="sidebar-title"><i class="bi bi-newspaper"></i> Network Feed</div>
                        </div>
                        <div class="text-muted small">Share photos, like posts, and comment to connect with your circle.</div>
                        <div class="text-muted small mt-2">Tip: Use a clear caption and upload a high-quality photo.</div>
                    </div>

                    <div class="sidebar-card">
                        <div class="sidebar-card-header">
                            <div class="sidebar-title"><i class="bi bi-clock-history"></i> Recent Posts</div>
                            @php
                                $recentPosts = $posts
                                    ->getCollection()
                                    ->filter(function ($p) {
                                        return $p->created_at && $p->created_at->gte(now()->subMinutes(15));
                                    })
                                    ->take(12);
                            @endphp
                            <div class="sidebar-badge">{{ $recentPosts->count() }}</div>
                        </div>
                        <div class="sidebar-scroll">
                            @forelse ($recentPosts as $p)
                                @php
                                    $pUserMember = optional($p->user->member);
                                    $pUserPhoto = $pUserMember->profilePhoto ?? null;
                                    $snippet = $p->caption ? \Illuminate\Support\Str::limit($p->caption, 70) : 'Photo post';
                                @endphp
                                <a class="recent-post-item mb-2" href="#post-{{ $p->id }}" onclick="scrollToPost({{ $p->id }})">
                                    <img src="{{ $pUserPhoto ? asset($pUserPhoto) : asset('profile.png') }}" alt="User" class="sidebar-avatar" onerror="this.src='{{ asset('profile.png') }}'">
                                    <div class="flex-grow-1" style="min-width: 0;">
                                        <div class="small fw-semibold text-truncate">{{ $p->user->firstName }} {{ $p->user->lastName }}</div>
                                        <div class="text-muted small recent-post-snippet">{{ $snippet }}</div>
                                        <div class="text-muted" style="font-size: 11px;">{{ $p->created_at->diffForHumans() }}</div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-muted small">No posts in last 15 minutes.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="lightbox-modal">
        <span id="lightbox-close" onclick="closeLightbox()">&times;</span>
        <span id="lightbox-prev" class="lightbox-nav" onclick="changeSlide(-1)">&#10094;</span>
        <div id="lightbox-content"></div>
        <span id="lightbox-next" class="lightbox-nav" onclick="changeSlide(1)">&#10095;</span>
    </div>

    {{-- Comment Modal --}}
    <div id="comment-modal" class="modal fade" tabindex="-1" aria-hidden="true" style="z-index: 10002;">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comments</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeCommentModal()"></button>
                </div>
                <div class="modal-body" id="comment-modal-body">
                    <!-- Comments will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Post Modal -->
    <div id="edit-post-modal" class="modal fade" tabindex="-1" aria-hidden="true" style="z-index: 10003;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-post-form" onsubmit="updatePost(event)">
                        <input type="hidden" id="edit-post-id" name="postId">
                        <div class="mb-3">
                            <textarea id="edit-post-caption" name="caption" class="form-control" rows="3" placeholder="What's on your mind?"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Media</label>
                            <div id="edit-current-media" class="d-flex flex-wrap gap-2">
                                <!-- Existing media items will be injected here -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="btn btn-sm btn-outline-primary" style="cursor: pointer;">
                                <i class="bi bi-plus-lg"></i> Add More Photos
                                <input type="file" id="edit-post-attachments" name="attachments[]" accept="image/*" multiple hidden onchange="handleEditFiles(this)">
                            </label>
                            <div id="edit-new-media-preview" class="d-flex flex-wrap gap-2 mt-2">
                                <!-- New media previews -->
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .lightbox-nav {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: white;
            font-weight: bold;
            font-size: 30px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            z-index: 10001;
        }

        #lightbox-prev {
            left: 0;
            border-radius: 3px 0 0 3px;
        }

        #lightbox-next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .lightbox-nav:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>

    <script>
        var currentMediaList = [];
        var currentIndex = 0;

        function openGallery(element, index) {
            // Find the closest parent with data-media
            var container = element.closest('.post-media-grid');
            if (container && container.dataset.media) {
                currentMediaList = JSON.parse(container.dataset.media);
                currentIndex = index;
                showLightbox();
            }
        }

        // Maintain compatibility for single attachments
        function openLightbox(src, type) {
            currentMediaList = [{
                src: src,
                type: type,
                ext: type
            }];
            currentIndex = 0;
            showLightbox();
        }

        function showLightbox() {
            var modal = document.getElementById('lightbox-modal');
            modal.style.display = 'flex';
            updateLightboxContent();
        }

        function closeLightbox() {
            document.getElementById('lightbox-modal').style.display = 'none';
            document.getElementById('lightbox-content').innerHTML = ''; // Stop video
        }

        function changeSlide(n) {
            currentIndex += n;
            if (currentIndex >= currentMediaList.length) {
                currentIndex = 0;
            } else if (currentIndex < 0) {
                currentIndex = currentMediaList.length - 1;
            }
            updateLightboxContent();
        }

        function updateLightboxContent() {
            var content = document.getElementById('lightbox-content');
            content.innerHTML = '';

            var media = currentMediaList[currentIndex];
            var src = media.src;
            var type = (media.type || media.ext || '').toLowerCase().replace('.', '');

            var isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'image'].includes(type);
            // Fallback extension check
            if (!isImage && (src.match(/\.(jpeg|jpg|gif|png|webp)($|\?)/i) != null)) {
                isImage = true;
            }

            if (isImage) {
                var img = document.createElement('img');
                img.src = src;
                content.appendChild(img);
            } else {
                var video = document.createElement('video');
                video.src = src;
                video.controls = true;
                video.autoplay = true;
                content.appendChild(video);
            }

            // Show/Hide nav buttons
            var prevBtn = document.getElementById('lightbox-prev');
            var nextBtn = document.getElementById('lightbox-next');
            if (currentMediaList.length > 1) {
                prevBtn.style.display = 'block';
                nextBtn.style.display = 'block';
            } else {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
            }
        }

        document.addEventListener('click', function(event) {
            var modal = document.getElementById('lightbox-modal');
            if (event.target == modal) {
                closeLightbox();
            }
        });

        function previewFiles(input) {
            var files = input.files;
            var previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Clear previous

            if (files.length > 0) {
                previewContainer.style.display = 'block';
                document.getElementById('file-count').textContent = files.length + ' file(s) selected';

                Array.from(files).forEach(file => {
                    var reader = new FileReader();
                    var div = document.createElement('div');
                    div.className = 'preview-item';

                    if (file.type.startsWith('image/')) {
                        reader.onload = function(e) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            div.appendChild(img);
                            previewContainer.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            } else {
                previewContainer.style.display = 'none';
                document.getElementById('file-count').textContent = '';
            }
        }

        function uploadPost(event) {
            event.preventDefault();

            var form = document.getElementById('create-post-form');
            var formData = new FormData(form);

            // Reset UI
            document.getElementById('validation-errors').style.display = 'none';
            document.getElementById('progress-container').style.display = 'block';
            document.getElementById('progress-bar').style.width = '0%';
            document.getElementById('upload-btn').disabled = true;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('social-wall.store') }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progress-bar').style.width = percentComplete + '%';
                    document.getElementById('progress-bar').textContent = Math.round(percentComplete) + '%';
                }
            };

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Success
                    document.getElementById('progress-container').style.display = 'none';
                    document.getElementById('success-animation').style.display = 'block';
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    // Error
                    document.getElementById('progress-container').style.display = 'none';
                    document.getElementById('upload-btn').disabled = false;

                    try {
                        var response = JSON.parse(xhr.responseText);
                        var errorHtml = '';
                        if (response.errors) {
                            for (var key in response.errors) {
                                // Specific check for file size error to make it red and clear
                                var errorMsg = response.errors[key][0];
                                errorHtml += '<div class="text-danger"><i class="bi bi-exclamation-circle-fill"></i> ' + errorMsg + '</div>';
                            }
                        } else if (response.error) {
                            errorHtml = '<div class="text-danger"><i class="bi bi-exclamation-circle-fill"></i> ' + response.error + '</div>';
                        } else {
                            errorHtml = '<div class="text-danger">An error occurred. Please try again.</div>';
                        }
                        document.getElementById('validation-errors').innerHTML = errorHtml;
                        document.getElementById('validation-errors').style.display = 'block';
                    } catch (e) {
                        document.getElementById('validation-errors').innerHTML = '<div class="text-danger">An unexpected error occurred.</div>';
                        document.getElementById('validation-errors').style.display = 'block';
                    }
                }
            };

            xhr.onerror = function() {
                document.getElementById('progress-container').style.display = 'none';
                document.getElementById('upload-btn').disabled = false;
                Swal.fire('Upload failed', 'Please check your connection and try again.', 'error');
            };

            xhr.send(formData);
        }

        function toggleLike(postId, btn) {
            // Optimistic UI Update
            var icon = btn.querySelector('i');
            var isLiked = btn.classList.contains('liked');
            var likeCountSpan = document.getElementById('like-count-' + postId);
            var currentCount = parseInt(likeCountSpan.innerText) || 0;

            if (isLiked) {
                // Optimistically unlike
                btn.classList.remove('liked');
                icon.classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
                likeCountSpan.innerText = Math.max(0, currentCount - 1) + ' Likes';
            } else {
                // Optimistically like
                btn.classList.add('liked');
                icon.classList.replace('bi-hand-thumbs-up', 'bi-hand-thumbs-up-fill');
                likeCountSpan.innerText = (currentCount + 1) + ' Likes';
            }

            fetch('{{ route('social-wall.like') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        postId: postId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Sync with server response to be sure
                    if (data.status === 'liked') {
                        btn.classList.add('liked');
                        icon.classList.replace('bi-hand-thumbs-up', 'bi-hand-thumbs-up-fill');
                    } else {
                        btn.classList.remove('liked');
                        icon.classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
                    }
                    document.getElementById('like-count-' + postId).innerText = data.count + ' Likes';
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revert UI on error
                    if (isLiked) {
                        // Re-like
                        btn.classList.add('liked');
                        icon.classList.replace('bi-hand-thumbs-up', 'bi-hand-thumbs-up-fill');
                        likeCountSpan.innerText = currentCount + ' Likes';
                    } else {
                        // Re-unlike
                        btn.classList.remove('liked');
                        icon.classList.replace('bi-hand-thumbs-up-fill', 'bi-hand-thumbs-up');
                        likeCountSpan.innerText = currentCount + ' Likes';
                    }
                });
        }

        function toggleComments(postId) {
            var section = document.getElementById('comments-' + postId);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }

        function handleCommentSubmit(event, postId) {
            if (event.key === 'Enter') {
                submitComment(postId);
            }
        }

        function submitComment(postId) {
            var input = document.getElementById('comment-input-' + postId);
            var comment = input.value.trim();
            if (comment) {
                fetch('{{ route('social-wall.comment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            postId: postId,
                            comment: comment
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            Swal.fire('Error', data.error, 'error');
                        } else {
                            input.value = '';
                            // Append new comment
                            var commentList = document.getElementById('comment-list-' + postId);

                            // Insert the HTML returned from server
                            if (data.html) {
                                commentList.insertAdjacentHTML('afterbegin', data.html);
                            }

                            // If modal is open, reload it to show new comment
                            if (currentModalPostId === postId) {
                                showAllComments(postId);
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Global click to close comment options dropdowns
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.comment-options')) {
                document.querySelectorAll('.comment-options-dropdown').forEach(function(el) {
                    el.classList.remove('show');
                });
            }
        });

        function toggleCommentOptions(event, commentId, prefix = '') {
            event.stopPropagation();
            var dropdown = document.getElementById(prefix + 'comment-options-' + commentId);

            // Close all other dropdowns
            document.querySelectorAll('.comment-options-dropdown').forEach(function(el) {
                if (el.id !== prefix + 'comment-options-' + commentId) {
                    el.classList.remove('show');
                }
            });

            if (dropdown) dropdown.classList.toggle('show');
        }

        function deleteComment(commentId, prefix = '') {
            Swal.fire({
                title: 'Are you sure?',
                text: "This comment will be removed.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Optimistic UI update
                    var mainEl = document.getElementById('comment-container-' + commentId);
                    var modalEl = document.getElementById('modal-comment-container-' + commentId);
                    if (mainEl) mainEl.remove();
                    if (modalEl) modalEl.remove();

                    fetch("{{ route('social-wall.comment.delete') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                comment_id: commentId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (!data.success) {
                                Swal.fire('Error', data.message || 'Error deleting comment', 'error')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Deleted!', 'Comment deleted successfully.', 'success');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        });
                }
            });
        }

        function enableEditComment(commentId, prefix = '') {
            document.getElementById(prefix + 'comment-text-' + commentId).style.display = 'none';
            document.getElementById(prefix + 'edit-comment-area-' + commentId).style.display = 'block';
            document.getElementById(prefix + 'comment-options-' + commentId).classList.remove('show');
        }

        function cancelEditComment(commentId, prefix = '') {
            document.getElementById(prefix + 'comment-text-' + commentId).style.display = 'block';
            document.getElementById(prefix + 'edit-comment-area-' + commentId).style.display = 'none';
        }

        function saveComment(commentId, prefix = '') {
            var newText = document.getElementById(prefix + 'edit-comment-input-' + commentId).value.trim();
            if (!newText) return;

            // Optimistic UI
            var mainText = document.getElementById('comment-text-' + commentId);
            var modalText = document.getElementById('modal-comment-text-' + commentId);

            if (mainText) mainText.innerText = newText;
            if (modalText) modalText.innerText = newText;

            cancelEditComment(commentId, prefix);

            fetch("{{ route('social-wall.comment.edit') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        comment_id: commentId,
                        comment: newText
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        Swal.fire('Error', (data.message || 'Error updating comment'), 'error')
                            .then(() => location.reload());
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Something went wrong.', 'error')
                        .then(() => location.reload());
                });
        }

        var currentModalPostId = null;

        // Add event listener for modal close to reset state
        document.getElementById('comment-modal').addEventListener('hidden.bs.modal', function() {
            currentModalPostId = null;
            document.getElementById('comment-modal-body').innerHTML = '';
        });

        function closeCommentModal() {
            currentModalPostId = null;
            // Bootstrap handles the hiding via data-bs-dismiss, 
            // but if called programmatically:
            var modalEl = document.getElementById('comment-modal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        }

        function showAllComments(postId) {
            currentModalPostId = postId;
            var modalBody = document.getElementById('comment-modal-body');

            // Only show spinner if we are opening it fresh, not refreshing
            if (!modalBody.innerHTML.trim() || modalBody.innerHTML.includes('spinner-border')) {
                modalBody.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            }

            var modalEl = document.getElementById('comment-modal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.show();

            var url = "{{ route('social-wall.comments', ['postId' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', postId);

            fetch(url)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalBody.innerHTML = '<div class="text-danger">Error loading comments.</div>';
                });
        }

        function closeCommentModal() {
            var modalEl = document.getElementById('comment-modal');
            var modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            } else {
                // Fallback
                $(modalEl).modal('hide');
            }
            currentModalPostId = null;
        }

        // Edit Post Functions
        var deletedMediaIds = [];

        function openEditPostModal(postId) {
            deletedMediaIds = [];
            document.getElementById('edit-post-id').value = postId;
            document.getElementById('edit-post-caption').value = '';
            document.getElementById('edit-current-media').innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>';
            document.getElementById('edit-new-media-preview').innerHTML = '';
            document.getElementById('edit-post-attachments').value = ''; // Clear file input

            var modal = new bootstrap.Modal(document.getElementById('edit-post-modal'));
            modal.show();

            // Fetch post details
            fetch("{{ route('social-wall.post.details', ['postId' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', postId))
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('edit-post-caption').value = data.post.caption || '';

                        var mediaContainer = document.getElementById('edit-current-media');
                        mediaContainer.innerHTML = '';

                        if (data.post.media && data.post.media.length > 0) {
                            data.post.media.forEach(media => {
                                var div = document.createElement('div');
                                div.className = 'position-relative';
                                div.style.width = '100px';
                                div.style.height = '100px';

                                var mediaEl;
                                // Use asset base url + file path, mirroring how it's done in the feed (asset($media->file_path))
                                // We use asset('') to get the base URL.
                                var baseUrl = "{{ asset('') }}";
                                var assetPath = media.file_path.startsWith('http') ? media.file_path : baseUrl + media.file_path;

                                if (media.file_type === 'video') {
                                    mediaEl = document.createElement('video');
                                    mediaEl.src = assetPath;
                                    mediaEl.style.objectFit = 'cover';
                                } else {
                                    mediaEl = document.createElement('img');
                                    mediaEl.src = assetPath;
                                    mediaEl.style.objectFit = 'cover';
                                }
                                mediaEl.style.width = '100%';
                                mediaEl.style.height = '100%';
                                mediaEl.className = 'rounded border';

                                var removeBtn = document.createElement('button');
                                removeBtn.type = 'button';
                                removeBtn.className = 'btn btn-danger btn-sm position-absolute top-0 end-0 p-0 rounded-circle';
                                removeBtn.style.width = '20px';
                                removeBtn.style.height = '20px';
                                removeBtn.style.lineHeight = '1';
                                removeBtn.innerHTML = '&times;';
                                removeBtn.onclick = function() {
                                    deletedMediaIds.push(media.id);
                                    div.remove();
                                };

                                div.appendChild(mediaEl);
                                div.appendChild(removeBtn);
                                mediaContainer.appendChild(div);
                            });
                        } else {
                            mediaContainer.innerHTML = '<span class="text-muted small">No media</span>';
                        }
                    } else {
                        Swal.fire('Error', data.message || 'Error fetching post details', 'error');
                        modal.hide && modal.hide();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Error fetching post details', 'error');
                });
        }

        function handleEditFiles(input) {
            var container = document.getElementById('edit-new-media-preview');
            container.innerHTML = '';

            if (input.files && input.files.length > 0) {
                Array.from(input.files).forEach(file => {
                    var reader = new FileReader();
                    var div = document.createElement('div');
                    div.className = 'position-relative';
                    div.style.width = '80px';
                    div.style.height = '80px';

                    reader.onload = function(e) {
                        if (!file.type.startsWith('image/')) {
                            return;
                        }
                        var mediaEl = document.createElement('img');
                        mediaEl.src = e.target.result;
                        mediaEl.style.width = '100%';
                        mediaEl.style.height = '100%';
                        mediaEl.style.objectFit = 'cover';
                        mediaEl.className = 'rounded border opacity-75';
                        div.appendChild(mediaEl);
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        function openPostFromSidebar(postId, type) {
            scrollToPost(postId);
            if (type === 'comment') {
                setTimeout(function() {
                    try {
                        toggleComments(postId);
                    } catch (e) {}
                }, 350);
            }
        }

        function scrollToPost(postId) {
            var el = document.getElementById('post-' + postId);
            if (!el) return;

            document.querySelectorAll('.post-card.post-highlight').forEach(function(card) {
                card.classList.remove('post-highlight');
            });

            el.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

            el.classList.add('post-highlight');
            setTimeout(function() {
                el.classList.remove('post-highlight');
            }, 2500);
        }

        function updatePost(event) {
            event.preventDefault();
            var form = document.getElementById('edit-post-form');
            var formData = new FormData(form);

            deletedMediaIds.forEach(id => {
                formData.append('deleted_media[]', id);
            });

            fetch("{{ route('social-wall.post.edit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal first
                        var modalEl = document.getElementById('edit-post-modal');
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) {
                            modal.hide();
                        }

                        Swal.fire('Updated!', 'Post updated successfully.', 'success')
                            .then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message || 'Error updating post', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Error updating post', 'error');
                });
        }

        function deletePost(postId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('social-wall.post.delete') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                postId: postId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your post has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || 'Error deleting post',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Something went wrong.',
                                'error'
                            );
                        });
                }
            })
        }
    </script>
@endsection
