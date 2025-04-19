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
    
        public function store(Request $request, Conversation $conversation)
        {
            // Authorization
            if (!in_array(Auth::id(), [$conversation->user_one_id, $conversation->user_two_id])) {
                abort(403);
            }
    
            $request->validate([
                'message' => 'required|string',
            ]);
    
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id'       => Auth::id(),
                'message'         => $request->input('message'),
            ]);

            broadcast(new MessageSent($message))->toOthers();
    
            return back();
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
