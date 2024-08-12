<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils; // Assuming you have a Utils class for response handling


class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $authId = Auth::id();

        // Validate the request
        $request->validate([
            'message' => 'required|string',
            'userId' => 'required|integer|exists:users,id', // Ensure the userId exists in the users table
        ]);

        try {
            // Create a new message
            $message = new Message;
            $message->senderId = $authId; // Current authenticated user's ID
            $message->receiverId = $request->userId; // Receiver's user ID from the request
            $message->content = encrypt($request->message);
            $message->save();

            return Utils::sendResponse(['message' => $message], 'Message sent successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function getMessages()
    {
        // Get the current authenticated user's ID
        $userId = Auth::id();

        try {
            // Fetch messages where the current user is either the sender or receiver
            $messages = Message::where(function ($query) use ($userId) {
                $query->where('senderId', $userId)
                    ->orWhere('receiverId', $userId);
            })->orderBy('created_at', 'asc')->get();

            // Decrypt each message content
            foreach ($messages as $key => $value) {
                $messages[$key]->content = decrypt($value->content);
            }

            return Utils::sendResponse(['messages' => $messages], 'Messages retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
