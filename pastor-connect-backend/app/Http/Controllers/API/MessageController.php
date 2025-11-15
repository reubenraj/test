<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::where('sender_id', $request->user()->id)
            ->orWhere('receiver_id', $request->user()->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    public function conversations(Request $request)
    {
        $userId = $request->user()->id;

        // Get unique conversation partners
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->get()
            ->map(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->receiver : $message->sender;
            })
            ->unique('id')
            ->values();

        return response()->json($conversations);
    }

    public function conversation(Request $request, $userId)
    {
        $currentUserId = $request->user()->id;

        $messages = Message::where(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $currentUserId)
                  ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($currentUserId, $userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $currentUserId);
        })->with(['sender', 'receiver'])
          ->orderBy('created_at', 'asc')
          ->get();

        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        if ($request->receiver_id == $request->user()->id) {
            return response()->json([
                'message' => 'You cannot send a message to yourself',
            ], 400);
        }

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        $message->load(['sender', 'receiver']);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ], 201);
    }

    public function markAsRead($id)
    {
        $message = Message::where('receiver_id', auth()->id())->findOrFail($id);
        $message->markAsRead();

        return response()->json([
            'message' => 'Message marked as read',
        ]);
    }

    public function unreadCount(Request $request)
    {
        $count = Message::where('receiver_id', $request->user()->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
