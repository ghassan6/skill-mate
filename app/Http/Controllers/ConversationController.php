<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversation;
use App\Models\Message;

class ConversationController extends Controller
{
    public function index() {
        $user = Auth::user();
        $conversations = Conversation::where('user_one_id', $user->id)
        ->orWhere('user_two_id' , $user->id)
        ->with(['userOne', 'userTwo', 'messages' => fn($q) => $q->latest()->take(1)])
        ->latest()
        ->get();
        

        return view('user.conversations', compact('conversations'));
    }


    public function show(Conversation $conversation) {

        // $messages = $conversation->messages()->with('sender')->oldest()->get();
        // Authorization: ensure the auth user is a participant
        if (!in_array(Auth::id(), [$conversation->user_one_id, $conversation->user_two_id])) {
            abort(403);
        }

        $messages = $conversation->messages()->get();

        return view('user.conversationsShow', compact('messages', 'conversation'));
    }

    public function store(Request $request) {
        $authId = Auth::id() ; // current user
        $otherUserId = $request->input('recipient_id'); // the user you're messaging

        $conversation = Conversation::where(function ($query) use ($authId, $otherUserId) {
            $query->where('user_one_id', $authId)
                  ->where('user_two_id', $otherUserId);
        })->orWhere(function ($query) use ($authId, $otherUserId) {
            $query->where('user_one_id', $otherUserId)
                  ->where('user_two_id', $authId);
        })->first();

        // incase the is no conversation this will create a new one btween two users
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $authId,
                'user_two_id' => $otherUserId,
            ]);
        }

        if ($request->filled('message')) {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id'       => $authId,
                'message'         => $request->input('message'),
            ]);
        }

        return redirect()->route('conversations.show', $conversation);

    }
}
