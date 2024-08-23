<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Utils\Utils;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


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
    public function getMessages(Request $request)
    {
        $userId = Auth::id();
        $receiverId = $request->input('receiverId');

        try {
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

            return Utils::sendResponse(['messages' => $messages], 'Messages retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    // public function getMessages(Request $request)
    // {
    //     $request->validate([
    //         'senderId' => 'required|integer|exists:users,id',
    //         'receiverId' => 'required|integer|exists:users,id',
    //     ]);

    //     $userId = Auth::id();
    //     $senderId = $request->senderId;
    //     $receiverId = $request->receiverId;

    //     try {
    //         $messages = Message::where(function ($query) use ($userId, $senderId, $receiverId) {
    //             $query->where(function ($query) use ($senderId, $receiverId) {
    //                 $query->where('senderId', $senderId)
    //                     ->where('receiverId', $receiverId);
    //             })->orWhere(function ($query) use ($senderId, $receiverId) {
    //                 $query->where('senderId', $receiverId)
    //                     ->where('receiverId', $senderId);
    //             })->where(function ($query) use ($userId) {
    //                 $query->where('senderId', $userId)
    //                     ->orWhere('receiverId', $userId);
    //             });
    //         })->orderBy('created_at', 'asc')->get();

    //         foreach ($messages as $key => $value) {
    //             $messages[$key]->content = decrypt($value->content);
    //         }

    //         return Utils::sendResponse(['messages' => $messages], 'Messages retrieved successfully', 200);
    //     } catch (\Throwable $th) {
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }



    public function getList()
    {
        $userId = Auth::id();

        try {
            // Get distinct user IDs who sent messages to or received messages from the current user
            $userIds = Message::where('senderId', $userId)
                ->orWhere('receiverId', $userId)
                ->get()
                ->map(function ($message) use ($userId) {
                    return $message->senderId == $userId ? $message->receiverId : $message->senderId;
                })
                ->unique()
                ->values();

            // Include also the users who have sent messages to the logged-in user
            $userIdsFromSender = Message::where('receiverId', $userId)
                ->pluck('senderId')
                ->unique();

            // Merge both lists of user IDs and remove duplicates
            $allUserIds = $userIds->merge($userIdsFromSender)->unique();

            // Fetch user names based on the unique user IDs
            $listOfUser = User::whereIn('id', $allUserIds)->get(['id', 'firstName', 'lastName']);

            return Utils::sendResponse(['listOfUser' => $listOfUser], 'List of users retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
