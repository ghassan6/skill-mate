<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

        public function store(Request $request)
{
    $authId = Auth::id();
    $otherUserId = $request->input('recipient_id');

    $conversation = Conversation::where(function ($query) use ($authId, $otherUserId) {
        $query->where('user_one_id', $authId)
              ->where('user_two_id', $otherUserId);
    })->orWhere(function ($query) use ($authId, $otherUserId) {
        $query->where('user_one_id', $otherUserId)
              ->where('user_two_id', $authId);
    })->first();

    if (!$conversation) {
        $conversation = Conversation::create([
            'user_one_id' => $authId,
            'user_two_id' => $otherUserId,
        ]);
    }

    if ($request->filled('message')) {
       $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id'       => $authId,
            'message'         => $request->input('message'),
        ]);
    }
    $message->load('sender');
    broadcast(new MessageSent($message))->toOthers();

    // Return JSON response with message and sender info for immediate UI update
    return response()->json([
        'message' => $message->message,
        'sender' => [
            'id' => $message->sender->id,
            'username' => $message->sender->username,
        ],
    ]);
}



    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $messages)
    {
        //
    }
}
