<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Connection;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostMedia;
use App\Utils\Utils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // Assuming Utils exists based on previous context

class SocialWallService
{
    /**
     * Get the feed for the authenticated user.
     * Rules:
     * - Only connected members can see each other's posts
     * - User can see their own posts
     * - Order by latest first
     * - Count only active likes and comments
     * - Return isLikedByCurrentUser
     */
    public function getFeed($perPage = 10)
    {
        $userId = Auth::id();

        // 1. Get connected user IDs
        // Logic: (userId = authId AND memberId = postUserId) OR (userId = postUserId AND memberId = authId)
        // status = 'Accepted', recordStatus = 'Active' (implied connection status)
        // We need to find all userIds that are connected to the current user.

        // Get connections where current user is sender (userId)
        $connectedUserIds1 = Connection::where('userId', $userId)
            ->where('status', 'Accepted')
            ->where('recordStatus', 'Active')
            ->pluck('memberId')
            ->toArray();

        // Get connections where current user is receiver (memberId)
        $connectedUserIds2 = Connection::where('memberId', $userId)
            ->where('status', 'Accepted')
            ->where('recordStatus', 'Active')
            ->pluck('userId')
            ->toArray();

        $allowedUserIds = array_unique(array_merge($connectedUserIds1, $connectedUserIds2));

        // Add current user to allowed list (can see own posts)
        $allowedUserIds[] = $userId;

        // 2. Fetch Posts
        $posts = Post::where('status', 'Active')
            ->where(function ($q) use ($allowedUserIds) {
                $q->whereIn('userId', $allowedUserIds)
                    ->orWhereHas('user.roles', function ($rq) {
                        $rq->where('name', 'Admin');
                    });
            })
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'firstName', 'lastName');
                },
                'user.member' => function ($q) {
                    $q->select('id', 'userId', 'profilePhoto');
                },
                'media' => function ($q) {
                    $q->where('status', 'Active');
                },
                'likes' => function ($q) {
                    $q->where('status', 'Active');
                },
                'comments' => function ($q) {
                    $q->where('status', 'Active')->orderBy('created_at', 'desc');
                },
                'comments.user' => function ($q) {
                    $q->select('id', 'firstName', 'lastName');
                },
                'comments.user.member' => function ($q) {
                    $q->select('id', 'userId', 'profilePhoto');
                },
            ])
            ->withCount(['likes' => function ($query) {
                $query->where('status', 'Active');
            }])
            ->withCount(['comments' => function ($query) {
                $query->where('status', 'Active');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // 3. Add isLikedByCurrentUser flag
        $posts->getCollection()->transform(function ($post) use ($userId) {
            $post->isLikedByCurrentUser = $post->likes->contains(function ($like) use ($userId) {
                return $like->userId == $userId && $like->status == 'Active';
            });

            return $post;
        });

        return $posts;
    }

    /**
     * Create a new post.
     */
    public function createPost($data)
    {
        DB::beginTransaction();
        try {
            $post = new Post;
            $post->userId = Auth::id();
            if (! $post->userId) {
                throw new \Exception('User ID not found');
            }
            $post->caption = $data['caption'] ?? null;
            $post->status = 'Active';

            // Legacy single attachment support (optional, can be removed if fully migrated)
            if (isset($data['attachment']) && ! is_array($data['attachment'])) {
                $post->attachment = $data['attachment'];
            }

            $post->save();

            // Handle multiple attachments
            if (isset($data['attachments']) && is_array($data['attachments']) && Schema::hasTable('post_media')) {
                foreach ($data['attachments'] as $fileData) {
                    PostMedia::create([
                        'postId' => $post->id,
                        'file_path' => $fileData['path'],
                        'file_type' => $fileData['type'], // image or video
                        'status' => 'Active',
                    ]);
                }
            }

            DB::commit();

            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Toggle Like status.
     */
    public function toggleLike($postId)
    {
        $userId = Auth::id();

        $like = Like::where('postId', $postId)
            ->where('userId', $userId)
            ->first();

        if ($like) {
            // If record exists
            if ($like->status == 'Active') {
                $like->status = 'Deleted'; // Unlike
            } else {
                $like->status = 'Active'; // Like again
            }
            $like->save();

            return $like;
        } else {
            // If record does NOT exist
            $newLike = new Like;
            $newLike->postId = $postId;
            $newLike->userId = $userId;
            $newLike->status = 'Active';
            $newLike->save();

            return $newLike;
        }
    }

    /**
     * Add a comment.
     */
    public function addComment($postId, $commentText)
    {
        $comment = new Comment;
        $comment->postId = $postId;
        $comment->userId = Auth::id();
        $comment->comment = $commentText;
        $comment->status = 'Active';
        $comment->save();

        return $comment->load([
            'user' => function ($q) {
                $q->select('id', 'firstName', 'lastName');
            },
            'user.member' => function ($q) {
                $q->select('id', 'userId', 'profilePhoto');
            },
        ]);
    }

    /**
     * Get comments for a post.
     */
    public function getComments($postId)
    {
        return Comment::where('postId', $postId)
            ->where('status', 'Active')
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'firstName', 'lastName');
                },
                'user.member' => function ($q) {
                    $q->select('id', 'userId', 'profilePhoto');
                },
            ])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Delete a post (soft delete).
     */
    public function deletePost($postId)
    {
        $userId = Auth::id();
        $user = Auth::user();

        $query = Post::where('id', $postId);

        // Only restrict to owner if not Admin
        if ($user->role !== 'Admin') {
            $query->where('userId', $userId);
        }

        $post = $query->first();

        if ($post) {
            $post->status = 'Deleted';
            $post->save();

            return true;
        }

        return false;
    }

    /**
     * Get post details.
     */
    public function getPost($postId)
    {
        return Post::with(['media' => function ($q) {
            $q->where('status', 'Active');
        }])->findOrFail($postId);
    }

    /**
     * Update a post.
     */
    public function updatePost($postId, $data)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::id();
            $post = Post::where('id', $postId)
                ->where('userId', $userId)
                ->first();

            if (! $post) {
                throw new \Exception('Post not found or unauthorized');
            }

            if (isset($data['caption'])) {
                $post->caption = $data['caption'];
            }
            $post->save();

            // Handle deleted media
            if (isset($data['deleted_media']) && is_array($data['deleted_media'])) {
                PostMedia::whereIn('id', $data['deleted_media'])
                    ->where('postId', $postId)
                    ->update(['status' => 'Deleted']);
            }

            // Handle new attachments
            if (isset($data['attachments']) && is_array($data['attachments']) && Schema::hasTable('post_media')) {
                foreach ($data['attachments'] as $fileData) {
                    PostMedia::create([
                        'postId' => $post->id,
                        'file_path' => $fileData['path'],
                        'file_type' => $fileData['type'], // image or video
                        'status' => 'Active',
                    ]);
                }
            }

            DB::commit();

            return $post;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get recent notifications (likes and comments) on the authenticated user's posts.
     */
    public function getNotifications($limit = 10)
    {
        $userId = Auth::id();
        if (! $userId) {
            return collect([]);
        }

        $postIds = Post::where('userId', $userId)
            ->where('status', 'Active')
            ->pluck('id');

        if ($postIds->isEmpty()) {
            return collect([]);
        }

        $likes = Like::whereIn('postId', $postIds)
            ->where('status', 'Active')
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'firstName', 'lastName');
                },
                'user.member' => function ($q) {
                    $q->select('id', 'userId', 'profilePhoto');
                },
            ])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($like) {
                return [
                    'id' => 'like-'.$like->id,
                    'type' => 'like',
                    'postId' => $like->postId,
                    'actor' => $like->user,
                    'created_at' => $like->created_at,
                ];
            });

        $comments = Comment::whereIn('postId', $postIds)
            ->where('status', 'Active')
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'firstName', 'lastName');
                },
                'user.member' => function ($q) {
                    $q->select('id', 'userId', 'profilePhoto');
                },
            ])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => 'comment-'.$comment->id,
                    'type' => 'comment',
                    'postId' => $comment->postId,
                    'actor' => $comment->user,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at,
                ];
            });

        return $likes->concat($comments)
            ->sortByDesc('created_at')
            ->take($limit)
            ->values();
    }
}
