<?php

// namespace App\Http\Controllers;

// use App\Models\Message;
// use Illuminate\Http\Request;

// class MessageController extends Controller
// {
//     public function index($conversationId)
//     {
//         $messages = Message::where('conversation_id', $conversationId)
//             ->orderBy('created_at')
//             ->get();

//         return response()->json($messages);
//     }

//     public function store(Request $request)
//     {
//         $message = Message::create([
//             'conversation_id' => $request->input('conversation_id'),
//             'sender_id' => $request->input('sender_id'),
//             'message' => $request->input('message'),
//         ]);

//         return response()->json(['status' => 'Message sent']);
//     }
// }

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Conversation;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Retrieve messages for a conversation
    public function index($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->orderBy('created_at')
            ->get();

        // Decrypt each message before sending it to the client
        $messages->transform(function ($message) {
            try {
                $message->message = Crypt::decryptString($message->message);
            } catch (DecryptException $e) {
                $message->message = '[Message corrupted]';  // Handle corrupted message case
            }

            return $message;
        });

        return response()->json($messages);
    }

    // Store a new message with encryption
    public function store(Request $request)
    {
        // Encrypt the message before saving
        $encryptedMessage = Crypt::encryptString($request->input('message'));

        $message = Message::create([
            'conversation_id' => $request->input('conversation_id'),
            'sender_id' => $request->input('sender_id'),
            'message' => $encryptedMessage,
        ]);

        $conversation = Conversation::find($request->input('conversation_id'));
        $senderId = $request->input('sender_id');
        $receiverId = ($conversation->user_one_id == $senderId)
            ? $conversation->user_two_id
            : $conversation->user_one_id;

        $sender = User::find($senderId);
        $receiver = User::find($receiverId);
        if ($receiver) {
            Notifications::create([ // 👈 IMPORTANT
                'title' => 'New Message',
                'body' => $sender->firstName . ' ' . $sender->lastName . ' sent you a message',
                'data' => json_encode([
                    'type' => 'chat_message',
                    'userId' => $senderId,       // sender
                    'memberId' => $receiverId,   // receiver
                    'conversation_id' => $conversation->id,
                    'message_id' => $message->id,
                    'message' => $request->input('message') // optional preview
                ])
            ]);
        }


        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'Message sent']);
    }
}
