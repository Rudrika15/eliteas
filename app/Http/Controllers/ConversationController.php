<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $conversations = Conversation::where(function ($query) use ($userId) {
            $query->where('user_one_id', $userId)
                ->orWhere('user_two_id', $userId);
        })->get();

        return response()->json($conversations);
    }

    public function store(Request $request)
    {
        $conversation = Conversation::create([
            'user_one_id' => $request->input('user_one_id'),
            'user_two_id' => $request->input('user_two_id'),
        ]);

        return response()->json(['id' => $conversation->id]);
    }
}
