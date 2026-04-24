<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Connection;
use App\Models\Like;
use App\Models\Member;
use App\Models\Post;
use App\Utils\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SocialWallController extends Controller
{
    // ================= Social Wall APIs =================

    public function createPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'caption' => 'nullable|string',
                'attachment' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Max 10MB
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            if (! $request->has('caption') && ! $request->hasFile('attachment')) {
                return Utils::errorResponse(['error' => 'Post must have a caption or attachment.'], 'Validation Error', 422);
            }

            $userId = Auth::id();
            $post = new Post;
            $post->userId = $userId;
            $post->caption = $request->caption;
            $post->status = 'Active';

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;

                // If image, convert to WebP
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $image = imagecreatefromstring(file_get_contents($file));
                    $filename = time() . '.webp';
                    $path = public_path('posts/' . $filename);

                    // Ensure directory exists
                    if (! file_exists(public_path('posts'))) {
                        mkdir(public_path('posts'), 0777, true);
                    }

                    imagewebp($image, $path, 80); // 80% quality
                    imagedestroy($image);
                    $post->attachment = 'posts/' . $filename;
                } elseif (in_array(strtolower($extension), ['webp'])) {
                    $filename = time() . '.webp';
                    $file->move(public_path('posts'), $filename);
                    $post->attachment = 'posts/' . $filename;
                }
            }

            $post->save();
            $post->load(['user:id,firstName,lastName', 'user.member:id,userId,profilePhoto']);
            if ($post->attachment) {
                $post->attachmentUrl = url($post->attachment);
            }
            if ($post->user && $post->user->member && $post->user->member->profilePhoto) {
                $post->user->profilePhotoUrl = url('ProfilePhoto/' . $post->user->member->profilePhoto);
            } else {
                $post->user->profilePhotoUrl = null;
            }

            return Utils::sendResponse(['post' => $post], 'Post created successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function getFeed(Request $request)
    {
        try {
            $userId = Auth::id();

            // 1. Get connected user IDs
            // Logic: (userId = authId AND memberId = postUserId) OR (userId = postUserId AND memberId = authId)
            // status = 'Accepted'

            // $connectedUserIds1 = Connection::where('userId', $userId)
            //     ->where('status', 'Accepted')
            //     ->pluck('memberId')
            //     ->toArray();

            // $connectedUserIds2 = Connection::where('memberId', $userId)
            //     ->where('status', 'Accepted')
            //     ->pluck('userId')
            //     ->toArray();

            // $allowedUserIds = array_unique(array_merge($connectedUserIds1, $connectedUserIds2));
            // $allowedUserIds[] = $userId; // Add self

            $posts = Post::where('status', 'Active')
                // ->where(function ($q) use ($allowedUserIds) {
                //     $q->whereIn('userId', $allowedUserIds)
                //         ->orWhereHas('user.roles', function ($rq) {
                //             $rq->where('name', 'Admin');
                //         });
                // })
                ->with(['user:id,firstName,lastName', 'user.member:id,userId,profilePhoto', 'user.member.city:id,name', 'likes' => function ($q) {
                    $q->where('status', 'Active');
                }, 'comments' => function ($q) {
                    $q->where('status', 'Active')->orderBy('created_at', 'desc');
                }, 'comments.user:id,firstName,lastName', 'comments.user.member:id,userId,profilePhoto'])
                ->withCount(['likes' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->withCount(['comments' => function ($query) {
                    $query->where('status', 'Active');
                }])
                ->orderBy('created_at', 'desc')
                ->get();

            // Add isLikedByCurrentUser flag
            $posts->getCollection()->transform(function ($post) use ($userId) {
                $post->isLikedByCurrentUser = $post->likes->contains(function ($like) use ($userId) {
                    return $like->userId == $userId && $like->status == 'Active';
                });

                // Construct full URL for attachment
                if ($post->attachment) {
                    $post->attachmentUrl = url($post->attachment);
                }
                if ($post->user && $post->user->member && $post->user->member->profilePhoto) {
                    $post->user->profilePhotoUrl = url('ProfilePhoto/' . $post->user->member->profilePhoto);
                } else {
                    $post->user->profilePhotoUrl = null;
                }

                // Add user profile photo if available (assuming relationship or column exists)
                // $post->user->profilePhotoUrl = ...

                return $post;
            });

            return Utils::sendResponse(['feed' => $posts], 'Feed retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
    // public function getFeed(Request $request)
    // {
    //     try {
    //         $userId = Auth::id();

    //         $posts = Post::query()
    //             // ✅ Fix: case-insensitive status
    //             ->whereRaw('LOWER(status) = ?', ['active'])

    //             // ✅ Load relationships safely
    //             ->with([
    //                 'user:id,firstName,lastName',
    //                 'user.member:id,userId,profilePhoto,cityId',
    //                 'user.member.city:id,name',

    //                 'likes' => function ($q) {
    //                     $q->whereRaw('LOWER(status) = ?', ['active']);
    //                 },

    //                 'comments' => function ($q) {
    //                     $q->whereRaw('LOWER(status) = ?', ['active'])
    //                         ->orderBy('created_at', 'desc');
    //                 },

    //                 'comments.user:id,firstName,lastName',
    //                 'comments.user.member:id,userId,profilePhoto'
    //             ])

    //             // ✅ Counts
    //             ->withCount([
    //                 'likes' => function ($q) {
    //                     $q->whereRaw('LOWER(status) = ?', ['active']);
    //                 },
    //                 'comments' => function ($q) {
    //                     $q->whereRaw('LOWER(status) = ?', ['active']);
    //                 }
    //             ])

    //             ->orderBy('created_at', 'desc')
    //             ->get()

    //             // ✅ Correct transform (NO getCollection())
    //             ->transform(function ($post) use ($userId) {

    //                 // ✅ Like flag
    //                 $post->isLikedByCurrentUser = $post->likes
    //                     ->where('userId', $userId)
    //                     ->isNotEmpty();

    //                 // ✅ Attachment URL
    //                 $post->attachmentUrl = $post->attachment
    //                     ? url($post->attachment)
    //                     : null;

    //                 // ✅ Safe user/profile handling
    //                 if ($post->user) {

    //                     $member = $post->user->member ?? null;

    //                     $post->user->profilePhotoUrl = ($member && $member->profilePhoto)
    //                         ? url('ProfilePhoto/' . $member->profilePhoto)
    //                         : null;

    //                     // Optional: city name shortcut
    //                     $post->user->cityName = ($member && $member->city)
    //                         ? $member->city->name
    //                         : null;
    //                 }

    //                 return $post;
    //             });

    //         return Utils::sendResponse([
    //             'feed' => $posts
    //         ], 'Feed retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(
    //             $th->getMessage(),
    //             'Internal Server Error',
    //             500
    //         );
    //     }
    // }

    public function toggleLike(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postId' => 'required|exists:posts,id',
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            $userId = Auth::id();
            $postId = $request->postId;

            $like = Like::where('postId', $postId)
                ->where('userId', $userId)
                ->first();

            $message = '';
            $status = '';

            if ($like) {
                if ($like->status == 'Active') {
                    $like->delete();
                    $message = 'Post unliked';
                    $status = 'unliked';
                } else {
                    $like->status = 'Active';
                    $message = 'Post liked';
                    $status = 'liked';
                }
                $like->save();
            } else {
                $like = new Like;
                $like->postId = $postId;
                $like->userId = $userId;
                $like->status = 'Active';
                $like->save();
                $message = 'Post liked';
                $status = 'liked';
            }

            return Utils::sendResponse(['status' => $status], $message, 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function getPostLikes(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postId' => 'required|exists:posts,id',
            ]);

            $postId = $request->postId;

            // Get all active likes with user data
            $likes = Like::where('postId', $postId)
                ->where('status', 'Active')
                ->with(['user:id,firstName,lastName'])
                ->get();

            // Format response
            $likedUsers = $likes->map(function ($like) {

                $member = Member::where('userId', $like->user->id)->first();

                return [
                    'userId' => $like->user->id,
                    'name' => $like->user->firstName . ' ' . $like->user->lastName,
                    'profilePhoto' => (!empty($member->profilePhoto) && file_exists(public_path('ProfilePhoto/' . $member->profilePhoto)))
                        ? asset('ProfilePhoto/' . $member->profilePhoto)
                        : asset('ProfilePhoto/profile.png'),
                ];
            });

            return Utils::sendResponse([
                'totalLikes' => $likedUsers->count(),
                'users' => $likedUsers
            ], 'Post likes fetched successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function addComment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postId' => 'required|exists:posts,id',
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            $comment = new Comment;
            $comment->postId = $request->postId;
            $comment->userId = Auth::id();
            $comment->comment = $request->comment;
            $comment->status = 'Active';
            $comment->save();

            $comment->load('user:id,firstName,lastName');

            return Utils::sendResponse(['comment' => $comment], 'Comment added successfully', 201);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }


    public function getComments(Request $request, $postId)
    {
        try {
            $comments = Comment::where('postId', $postId)
                ->where('status', 'Active')
                ->with('user:id,firstName,lastName')
                ->orderBy('created_at', 'desc')
                ->get();

            return Utils::sendResponse(['comments' => $comments], 'Comments retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function editPost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postId' => 'required|exists:posts,id',
                'caption' => 'nullable|string',
                'attachment' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // Max 10MB
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            if (! $request->has('caption') && ! $request->hasFile('attachment')) {
                return Utils::errorResponse(['error' => 'Post must have a caption or attachment.'], 'Validation Error', 422);
            }

            $userId = Auth::id();
            $post = Post::where('id', $request->postId)->where('userId', $userId)->first();

            if (! $post) {
                return Utils::errorResponse(['error' => 'Post not found or unauthorized.'], 'Authorization Error', 403);
            }

            $post->caption = $request->caption ?? $post->caption;

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;

                // If image, convert to WebP
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $image = imagecreatefromstring(file_get_contents($file));
                    $filename = time() . '.webp';
                    $path = public_path('posts/' . $filename);

                    // Ensure directory exists
                    if (! file_exists(public_path('posts'))) {
                        mkdir(public_path('posts'), 0777, true);
                    }

                    imagewebp($image, $path, 80); // 80% quality
                    imagedestroy($image);
                    $post->attachment = 'posts/' . $filename;
                } elseif (in_array(strtolower($extension), ['webp'])) {
                    $filename = time() . '.webp';
                    $file->move(public_path('posts'), $filename);
                    $post->attachment = 'posts/' . $filename;
                }
            }

            $post->save();

            return Utils::sendResponse(['post' => $post], 'Post updated successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function deletePost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'postId' => 'required|exists:posts,id',
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            $userId = Auth::id();
            $post = Post::where('id', $request->postId)->where('userId', $userId)->first();

            if (! $post) {
                return Utils::errorResponse(['error' => 'Post not found or unauthorized.'], 'Authorization Error', 403);
            }

            $post->status = 'Deleted';
            $post->save();

            return Utils::sendResponse([], 'Post deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function editComment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'commentId' => 'required|exists:comments,id',
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            $userId = Auth::id();
            $comment = Comment::where('id', $request->commentId)->where('userId', $userId)->first();

            if (! $comment) {
                return Utils::errorResponse(['error' => 'Comment not found or unauthorized.'], 'Authorization Error', 403);
            }

            $comment->comment = $request->comment;
            $comment->save();

            return Utils::sendResponse(['comment' => $comment], 'Comment updated successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }

    public function deleteComment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'commentId' => 'required|exists:comments,id',
            ]);

            if ($validator->fails()) {
                return Utils::errorResponse($validator->errors(), 'Validation Error', 422);
            }

            $userId = Auth::id();
            $comment = Comment::where('id', $request->commentId)->where('userId', $userId)->first();

            if (! $comment) {
                return Utils::errorResponse(['error' => 'Comment not found or unauthorized.'], 'Authorization Error', 403);
            }

            $comment->status = 'Deleted';
            $comment->save();

            return Utils::sendResponse([], 'Comment deleted successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse($th->getMessage(), 'Internal Server Error', 500);
        }
    }
}
