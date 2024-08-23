<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
