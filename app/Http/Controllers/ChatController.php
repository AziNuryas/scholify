<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;

class ChatController extends Controller
{
    public function fetch(Request $request, $partnerId)
    {
        $authId = auth()->id();
        
        if (!$authId) {
            return response()->json(['messages' => []]);
        }

        // Fetch messages between auth user and partner
        $messages = Chat::with('sender')
            ->where(function($q) use ($authId, $partnerId) {
                $q->where('sender_id', $authId)->where('receiver_id', $partnerId);
            })
            ->orWhere(function($q) use ($authId, $partnerId) {
                $q->where('sender_id', $partnerId)->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) use ($authId) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'is_mine' => $msg->sender_id == $authId,
                    'role' => $msg->sender->role ?? 'siswa',
                    'time' => $msg->created_at->format('H:i')
                ];
            });

        // Mark incoming messages as read if accessed by the receiver
        Chat::where('sender_id', $partnerId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'receiver_id' => 'required'
        ]);

        $chat = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'chat' => [
                'id' => $chat->id,
                'message' => $chat->message,
                'is_mine' => true,
                'role' => auth()->user()->role ?? 'siswa',
                'time' => $chat->created_at->format('H:i')
            ]
        ]);
    }
    
    public function unreadCount()
    {
        if(!auth()->check()) return response()->json(['count' => 0]);
        
        $count = Chat::where('receiver_id', auth()->id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
}
