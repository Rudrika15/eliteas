<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Utils\Utils;


class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $authId = Auth::id();

        // Validate the request
        $request->validate([
            'message' => 'required|string',
            'userId' => 'required|integer|exists:users,id',
        ]);

        try {
            // Create a new message
            $message = new Message;
            $message->senderId = $authId;
            $message->receiverId = $request->userId;
            $message->content = encrypt($request->message);
            $message->save();

            $decryptedMessage = decrypt($message->content);
            $response = [
                'message' => $decryptedMessage,
                'senderId' => $authId,
                'receiverId' => $request->userId,
            ];
            return Utils::sendResponse($response, 'Message sent successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function getMessages()
    {

        $userId = Auth::id();

        try {
            $messages = Message::where(function ($query) use ($userId) {
                $query->where('senderId', $userId)
                    ->orWhere('receiverId', $userId);
            })->orderBy('created_at', 'asc')->get();
            foreach ($messages as $key => $value) {
                $messages[$key]->content = decrypt($value->content);
            }

            return Utils::sendResponse(['messages' => $messages], 'Messages retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
