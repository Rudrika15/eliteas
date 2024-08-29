<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate the request
        $request->validate([
            'message' => 'required|string',
            'userId' => 'required|integer|exists:users,id', // Ensure the userId exists in the users table
        ]);

        // Create a new message
        $message = new Message;
        $message->senderId = Auth::id(); // Current authenticated user's ID
        $message->receiverId = $request->userId; // Receiver's user ID from the request
        $message->content = encrypt($request->message);
        $message->save();

        return response()->json(['status' => 'Message sent']);
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
            // Get distinct user IDs who have sent messages to or received messages from the current user
            $userIds = Message::where('senderId', $userId)
                ->orWhere('receiverId', $userId)
                ->get()
                ->map(function ($message) use ($userId) {
                    return $message->senderId == $userId ? $message->receiverId : $message->senderId;
                })
                ->unique()
                ->values();

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
}
