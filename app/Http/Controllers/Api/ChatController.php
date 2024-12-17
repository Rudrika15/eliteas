<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate the request
        $request->validate([
            'message' => 'required|string',
        ]);

        // Create a new message
        $conversation = new Conversation();
        $conversation->user_one_id = Auth::id(); // Current authenticated user's ID
        $conversation->user_two_id = $request->memberId; // Receiver's user ID from the request
        $conversation->save();

        // Create a new message
        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->sender_id = $request->sender_id;
        $message->message = Crypt::encryptString($request->message);
        $message->save();

        return redirect()->back()->with('success', 'Message sent Successfully. You can now chat from My Chats Section.');
    }

    // public function getMessages()
    // {
    //     // Get the current authenticated user's ID
    //     $userId = Auth::id();

    //     // Fetch messages where the current user is either the sender or receiver, and they are communicating with each other
    //     $messages = Message::where(function ($query) use ($userId) {
    //         $query->where('senderId', $userId)
    //             ->whereIn('receiverId', function ($subQuery) use ($userId) {
    //                 $subQuery->select('senderId')->from('messages')->where('receiverId', $userId);
    //             })
    //             ->orWhere('receiverId', $userId)
    //             ->whereIn('senderId', function ($subQuery) use ($userId) {
    //                 $subQuery->select('receiverId')->from('messages')->where('senderId', $userId);
    //             });
    //     })
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     foreach ($messages as $key => $value) {
    //         $messages[$key]->content = decrypt($value->content);
    //     }

    //     return response()->json($messages);
    // }

    public function getMessages(Request $request)
    {
        // Get the current authenticated user's ID
        $userId = Auth::id();

        // Get the receiverId from the request body
        $receiverId = $request->input('receiverId');

        // Fetch messages where the current user is either the sender or the receiver
        $messages = Message::where(function ($query) use ($userId, $receiverId) {
            $query->where('senderId', $userId)
                ->where('receiverId', $receiverId)
                ->orWhere(function ($subQuery) use ($userId, $receiverId) {
                    $subQuery->where('senderId', $receiverId)
                        ->where('receiverId', $userId);
                });
        })->orderBy('created_at', 'asc')->get();

        foreach ($messages as $key => $value) {
            $messages[$key]->content = decrypt($value->content);
        }

        // Return the filtered messages as JSON response
        return response()->json($messages);
    }


    public function getList()
    {
        $userId = Auth::id();

        try {
            // Get distinct user IDs who sent messages to or received messages from the current user
            $userIds = Message::where('senderId', $userId)
                ->orWhere('receiverId', $userId)
                ->pluck('senderId', 'receiverId')
                ->flatten()
                ->unique()
                ->filter(function ($id) use ($userId) {
                    return $id != $userId; // Filter out the current user ID
                });

            // Fetch user names based on the unique user IDs
            $listOfUser = User::whereIn('id', $userIds)->get(['id', 'firstName', 'lastName']);

            // Return the view with the list of users
            return view('home', ['listOfUser' => $listOfUser]);
        } catch (\Throwable $th) {
            // Handle the error by returning the view with an error message
            return view('home', ['error' => $th->getMessage()]);
        }
    }

    // public function myChatList()
    // {
    //     return view('chat.index');
    // }

    public function myChatList()
    {
        $userId = Auth::id();

        try {
            // Get conversations where the authenticated user is a participant
            $conversations = Conversation::where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId)
                ->get();

            // Collect distinct user IDs from these conversations
            $userIds = $conversations->map(function ($conversation) use ($userId) {
                return $conversation->user_one_id == $userId ? $conversation->user_two_id : $conversation->user_one_id;
            })->unique()->values();

            // Fetch user details based on the unique user IDs
            $listOfUsers = User::join('members', 'users.id', '=', 'members.userId')
                ->whereIn('users.id', $userIds)
                ->select('users.id', 'users.firstName', 'users.lastName', 'users.email', 'members.profilePhoto')
                ->get();

            // Pass the data to the view
            return view('chat.index', ['listOfUsers' => $listOfUsers]);
        } catch (\Throwable $th) {
            // Handle the error appropriately
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }




    // public function typing(Request $request)
    // {
    //     $receiverId = $request->receiverId;
    //     // Store typing status in session or database
    //     session()->put("typing_{$receiverId}", true);
    // }

    // public function stoppedTyping(Request $request)
    // {
    //     $receiverId = $request->receiverId;
    //     // Remove typing status from session or database
    //     session()->forget("typing_{$receiverId}");
    // }

    // public function typingStatus(Request $request)
    // {
    //     $receiverId = $request->receiverId;
    //     // Check typing status
    //     $isTyping = session()->get("typing_{$receiverId}", false);
    //     return response()->json($isTyping);
    // }

    public function getChat($userId)
    {
        $authUserId = Auth::id();
        $user = User::find($userId);

        // Find the conversation between the authenticated user and the target user
        $conversation = Conversation::where(function ($query) use ($authUserId, $userId) {
            $query->where('user_one_id', $authUserId)
                ->where('user_two_id', $userId);
        })->orWhere(function ($query) use ($authUserId, $userId) {
            $query->where('user_one_id', $userId)
                ->where('user_two_id', $authUserId);
        })->first();

        if (!$conversation) {
            return response()->json([
                'user' => $user,
                'messages' => []
            ]);
        }

        // Retrieve messages for the conversation
        $messages = Message::where('conversation_id', $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) use ($authUserId) {
                return [
                    'text' => $message->message,
                    'sentByUser' => $message->sender_id == $authUserId
                ];
            });

        return response()->json([
            'user' => $user,
            'messages' => $messages
        ]);
    }
}
