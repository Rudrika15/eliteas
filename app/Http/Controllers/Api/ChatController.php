<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Utils\Utils;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class ChatController extends Controller
{
    // public function sendMessage(Request $request)
    // {
    //     $authId = Auth::id();

    //     // Validate the request
    //     $request->validate([
    //         'message' => 'required|string',
    //         'userId' => 'required|integer|exists:users,id',
    //     ]);

    //     try {
    //         // Find or create a conversation between the authenticated user and the target user
    //         $conversation = Conversation::firstOrCreate([
    //             'user_one_id' => $authId,
    //             'user_two_id' => $request->userId,
    //         ], [
    //             'user_one_id' => $authId,
    //             'user_two_id' => $request->userId,
    //         ]);

    //         // Encrypt and save the message
    //         $message = new Message;
    //         $message->conversation_id = $conversation->id;
    //         $message->sender_id = $authId;
    //         $message->message = Crypt::encryptString($request->message);  // Encrypt the message
    //         $message->save();

    //         // Decrypt the message for the response (decrypted only for displaying)
    //         $decryptedMessage = Crypt::decryptString($message->message);
    //         $response = [
    //             'message' => $decryptedMessage, // Send decrypted version
    //             'senderId' => $authId,
    //             'receiverId' => $request->userId,
    //             'conversationId' => $conversation->id,
    //         ];

    //         broadcast(new MessageSent($message))->toOthers();

    //         return Utils::sendResponse($response, 'Message sent successfully', 200);
    //     } catch (\Throwable $th) {
    //         // throw $th;
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }

    // public function sendMessage(Request $request)
    // {
    //     $authId = Auth::id();

    //     // Validate the request
    //     $request->validate([
    //         'message' => 'required|string',
    //         'userId' => 'required|integer|exists:users,id',
    //     ]);

    //     try {
    //         // Find an existing conversation between the authenticated user and the target user
    //         $conversation = Conversation::where(function ($query) use ($authId, $request) {
    //             $query->where('user_one_id', $authId)
    //                 ->where('user_two_id', $request->userId);
    //         })->orWhere(function ($query) use ($authId, $request) {
    //             $query->where('user_one_id', $request->userId)
    //                 ->where('user_two_id', $authId);
    //         })->first();

    //         // If no conversation exists, create a new one
    //         if (!$conversation) {
    //             $conversation = Conversation::create([
    //                 'user_one_id' => $authId,
    //                 'user_two_id' => $request->userId,
    //             ]);
    //         }

    //         // Encrypt and save the message
    //         $message = new Message;
    //         $message->conversation_id = $conversation->id;
    //         $message->sender_id = $authId;
    //         $message->message = Crypt::encryptString($request->message); // Encrypt the message
    //         $message->save();

    //         // Decrypt the message for the response (decrypted only for displaying)
    //         $decryptedMessage = Crypt::decryptString($message->message);
    //         $response = [
    //             'message' => $decryptedMessage, // Send decrypted version
    //             'senderId' => $authId,
    //             'receiverId' => $request->userId,
    //             'conversationId' => $conversation->id,
    //         ];

    //         // Broadcast the message using Laravel Echo
    //         broadcast(new MessageSent($message))->toOthers();

    //         return Utils::sendResponse($response, 'Message sent successfully', 200);
    //     } catch (\Throwable $th) {
    //         // Return an error response in case of an exception
    //         return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
    //     }
    // }


    public function sendMessage(Request $request)
    {
        $authId = Auth::id();

        // Validate the request
        $request->validate([
            'message' => 'required|string',
            'userId' => 'required|integer|exists:users,id',
        ]);

        try {
            // Find an existing conversation between the authenticated user and the target user
            $conversation = Conversation::where(function ($query) use ($authId, $request) {
                $query->where('user_one_id', $authId)
                    ->where(
                        'user_two_id',
                        $request->userId
                    );
            })->orWhere(function ($query) use ($authId, $request) {
                $query->where('user_one_id', $request->userId)
                    ->where('user_two_id', $authId);
            })->first();

            // If no conversation exists, create a new one
            if (!$conversation) {
                $conversation = Conversation::create([
                    'user_one_id' => $authId,
                    'user_two_id' => $request->userId,
                ]);
            }

            // Encrypt and save the message
            $message = new Message;
            $message->conversation_id = $conversation->id;
            $message->sender_id = $authId;
            $message->message = Crypt::encryptString($request->message); // Encrypt the message
            $message->save();

            // Decrypt the message for the response (decrypted only for displaying)
            $decryptedMessage = Crypt::decryptString($message->message);
            $response = [
                'message' => $decryptedMessage, // Send decrypted version
                'senderId' => $authId,
                'receiverId' => $request->userId,
                'conversationId' => $conversation->id,
            ];

            // Fetch the receiver's user details
            $receiver = User::find($request->userId);
            $sender = Auth::user();

            if (!$receiver) {
                return Utils::errorResponse(['message' => 'Receiver not found'], 'Not Found', 404);
            }

            // Prepare notification details
            $userName = $sender->firstName . ' ' . $sender->lastName;
            $title = 'New Message';
            $body = 'You received a new message from ' . $userName;

            // Send notification to the specific receiver
            if (!empty($receiver->fcm_token)) {
                $serviceAccountPath = storage_path('app/public/ubn_notification.json');
                $factory = (new Factory)->withServiceAccount($serviceAccountPath);
                $messaging = $factory->createMessaging();

                $notificationMessage = CloudMessage::withTarget('token', $receiver->fcm_token)
                    ->withNotification(Notification::create($title, $body));

                try {
                    $messaging->send($notificationMessage);
                    Log::info('Notification sent to token: ' . $receiver->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\NotFound $e) {
                    Log::error('Token not found: ' . $receiver->fcm_token);
                } catch (\Kreait\Firebase\Exception\Messaging\InvalidArgument $e) {
                    Log::error('Invalid argument error with token: ' . $receiver->fcm_token);
                } catch (\Exception $e) {
                    Log::error('General error sending to token: ' . $receiver->fcm_token . '. Error: ' . $e->getMessage());
                }
            }

            // Broadcast the message using Laravel Echo
            // broadcast(new MessageSent($message))->toOthers();

            return Utils::sendResponse($response, 'Message sent successfully', 200);
        } catch (\Throwable $th) {
            // Return an error response in case of an exception
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }




    public function getMessages(Request $request)
    {
        $userId = Auth::id();
        $receiverId = $request->input('receiverId');

        try {
            // Retrieve the conversation between the authenticated user and the target user
            $conversation = Conversation::where(function ($query) use ($userId, $receiverId) {
                $query->where('user_one_id', $userId)
                    ->where('user_two_id', $receiverId);
            })->orWhere(function ($query) use ($userId, $receiverId) {
                $query->where('user_one_id', $receiverId)
                    ->where('user_two_id', $userId);
            })->first();

            if (!$conversation) {
                return Utils::sendResponse(['messages' => []], 'No conversation found', 200);
            }

            // Retrieve messages for the conversation and decrypt them
            $messages = Message::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'asc')
                ->get();

            foreach ($messages as $key => $value) {
                $messages[$key]->message = Crypt::decryptString($value->message);  // Decrypt the message
            }

            return Utils::sendResponse(['messages' => $messages], 'Messages retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }

    public function getList()
    {
        $userId = Auth::id();

        try {
            // Get distinct user IDs who sent messages to or received messages from the current user
            $userIds = Message::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->get()
                ->map(function ($message) use ($userId) {
                    return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
                })
                ->unique()
                ->values();

            // Fetch user names and profile photos based on the unique user IDs
            $listOfUsers = User::join('members', 'users.id', '=', 'members.user_id')
                ->whereIn('users.id', $userIds)
                ->select('users.id', 'users.first_name', 'users.last_name', 'users.email', 'members.profile_photo')
                ->get();

            return Utils::sendResponse(['listOfUsers' => $listOfUsers], 'List of users retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }


    public function listOfUsers(Request $request)
    {
        $authId = Auth::id();

        try {
            // Retrieve distinct conversations where the authenticated user is a participant (either user_one or user_two)
            $conversationUserIds = Conversation::where('user_one_id', $authId)
                ->orWhere('user_two_id', $authId)
                ->get()
                ->map(function ($conversation) use ($authId) {
                    // Return the other participant's user ID in the conversation
                    return $conversation->user_one_id == $authId ? $conversation->user_two_id : $conversation->user_one_id;
                })
                ->unique()
                ->values();

            // Fetch user names and profile photos based on the unique user IDs
            $listOfUsers = User::join('members', 'users.id', '=', 'members.userId')
                ->whereIn('users.id', $conversationUserIds)
                ->select('users.id', 'users.firstName', 'users.lastName', 'users.email', 'members.profilePhoto')
                ->get();

            return Utils::sendResponse(['listOfUsers' => $listOfUsers], 'List of users retrieved successfully', 200);
        } catch (\Throwable $th) {
            return Utils::errorResponse(['error' => $th->getMessage()], 'Internal Server Error', 500);
        }
    }
}
