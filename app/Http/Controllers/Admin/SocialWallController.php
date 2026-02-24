<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SocialWallService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SocialWallController extends Controller
{
    protected $socialWallService;

    public function __construct(SocialWallService $socialWallService)
    {
        $this->socialWallService = $socialWallService;
        // Apply middleware if needed, e.g., auth
    }

    public function index()
    {
        $posts = $this->socialWallService->getFeed(10);
        return view('admin.social_wall.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'caption' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240', // Max 10MB
        ], [
            'attachments.*.max' => 'The file size must not be greater than 10 MB.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hasCaption = trim((string) $request->input('caption')) !== '';
        $hasAttachment = $request->hasFile('attachments') && count($request->file('attachments')) > 0;

        if (!$hasCaption && !$hasAttachment) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Post must have a caption or attachment.'], 422);
            }
            return redirect()->back()->withErrors(['error' => 'Post must have a caption or attachment.']);
        }

        $data = [
            'caption' => $hasCaption ? $request->input('caption') : null,
        ];
        $attachmentsData = [];

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $extension = $file->getClientOriginalExtension();
                $type = 'video'; // Default to video if not image
                $finalPath = '';

                // Ensure directory exists
                if (!file_exists(public_path('posts'))) {
                    mkdir(public_path('posts'), 0777, true);
                }

                // If image, convert to WebP
                if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
                    $type = 'image';
                    try {
                        $image = imagecreatefromstring(file_get_contents($file));
                        if ($image) {
                            $filename = uniqid() . '_' . time() . '.webp';
                            $path = public_path('posts/' . $filename);
                            imagewebp($image, $path, 80); // 80% quality
                            imagedestroy($image);
                            $finalPath = 'posts/' . $filename;
                        } else {
                            // Fallback if image creation fails
                            $filename = uniqid() . '_' . time() . '.' . $extension;
                            $file->move(public_path('posts'), $filename);
                            $finalPath = 'posts/' . $filename;
                        }
                    } catch (\Exception $e) {
                        // Fallback on error
                        $filename = uniqid() . '_' . time() . '.' . $extension;
                        $file->move(public_path('posts'), $filename);
                        $finalPath = 'posts/' . $filename;
                    }
                } else {
                    // Video or other allowed types
                    $filename = uniqid() . '_' . time() . '.' . $extension;
                    $file->move(public_path('posts'), $filename);
                    $finalPath = 'posts/' . $filename;
                }

                if ($finalPath) {
                    $attachmentsData[] = [
                        'path' => $finalPath,
                        'type' => $type
                    ];
                }
            }
        }

        $data['attachments'] = $attachmentsData;
        // For backward compatibility
        if (!empty($attachmentsData)) {
            $data['attachment'] = $attachmentsData[0]['path'];
        }

        $post = $this->socialWallService->createPost($data);

        if ($request->ajax()) {
            return response()->json(['success' => 'Post created successfully!', 'post' => $post]);
        }

        return redirect()->route('social-wall.index')->with('success', 'Post created successfully!');
    }

    public function toggleLike(Request $request)
    {
        try {
            $postId = $request->input('postId');
            $like = $this->socialWallService->toggleLike($postId);

            // Return JSON for AJAX
            return response()->json([
                'status' => $like->status == 'Active' ? 'liked' : 'unliked',
                'count' => \App\Models\Like::where('postId', $postId)->where('status', 'Active')->count()
            ]);
        } catch (\Exception $e) {
            \Log::error('Social Wall Like Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to like post', 'message' => $e->getMessage()], 500);
        }
    }

    public function addComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postId' => 'required|exists:posts,id',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $comment = $this->socialWallService->addComment($request->postId, $request->comment);

        // Load relationship for view
        $comment->load('user.member');

        $html = view('admin.social_wall.partials.comment_list', [
            'comments' => collect([$comment]),
            'prefix' => ''
        ])->render();

        // Return JSON for AJAX
        return response()->json([
            'comment' => $comment,
            'html' => $html,
            'count' => \App\Models\Comment::where('postId', $request->postId)->where('status', 'Active')->count()
        ]);
    }

    public function editComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|exists:comments,id',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $comment = \App\Models\Comment::find($request->comment_id);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found.'], 404);
        }

        if ($comment->userId !== \Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['success' => true, 'comment' => $comment]);
    }

    public function deleteComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|exists:comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $comment = \App\Models\Comment::find($request->comment_id);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found.'], 404);
        }

        // Allow admin or owner to delete
        if ($comment->userId !== \Auth::id() && \Auth::user()->role !== 'Admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $comment->status = 'Deleted'; // Soft delete
        $comment->save();

        return response()->json(['success' => true]);
    }

    public function getComments($postId)
    {
        $post = \App\Models\Post::findOrFail($postId);
        // Ensure we load the user member relationship for avatars
        $comments = $post->comments()
            ->where('status', 'Active')
            ->with('user.member')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.social_wall.partials.comment_list', [
            'comments' => $comments,
            'prefix' => 'modal-'
        ])->render();
    }

    public function deletePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postId' => 'required|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $result = $this->socialWallService->deletePost($request->postId);

        if ($result) {
            return response()->json(['success' => true, 'message' => 'Post deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthorized or post not found.'], 403);
        }
    }

    public function getPostDetails($postId)
    {
        try {
            $post = $this->socialWallService->getPost($postId);
            // Check authorization
            if ($post->userId !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
            }
            return response()->json(['success' => true, 'post' => $post]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Post not found.'], 404);
        }
    }

    public function editPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postId' => 'required|exists:posts,id',
            'caption' => 'nullable|string',
            'attachments.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,wmv|max:10240', // 10MB
            'deleted_media' => 'nullable|array',
            'deleted_media.*' => 'integer|exists:post_media,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $data = $request->only(['caption', 'deleted_media']);

            // Handle file uploads
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('social_wall_media', 'public');
                    $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
                    $attachments[] = ['path' => $path, 'type' => $type];
                }
                $data['attachments'] = $attachments;
            }

            $post = $this->socialWallService->updatePost($request->postId, $data);
            return response()->json(['success' => true, 'message' => 'Post updated successfully.', 'post' => $post]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating post: ' . $e->getMessage()], 500);
        }
    }
}
