<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * Get chat history for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $chat = Chat::firstOrCreate(
            ['user_id' => $user->id],
            ['last_message_at' => now()]
        );

        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        // Reset unread count for user
        $chat->update(['unread_count_user' => 0]);

        return response()->json([
            'success' => true,
            'chat' => $chat,
            'messages' => $messages
        ]);
    }

    /**
     * Send a message from user to admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240', // 10MB limit
            'message_type' => 'required|in:text,image,file'
        ]);

        $user = $request->user();
        $chat = Chat::firstOrCreate(['user_id' => $user->id]);

        $content = $request->message;
        
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('chat_files', 'public');
            $content = Storage::url($path);
        }

        if (!$content && $request->message_type === 'text') {
            return response()->json([
                'success' => false,
                'message' => 'Message content is required for text messages'
            ], 422);
        }

        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'sender_type' => 'user',
            'message_type' => $request->message_type,
            'content' => $content,
        ]);

        $chat->update([
            'last_message_at' => now(),
            'unread_count_admin' => $chat->unread_count_admin + 1
        ]);

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Mark messages as read by user.
     */
    public function markRead(Request $request)
    {
        $user = $request->user();
        $chat = Chat::where('user_id', $user->id)->first();

        if ($chat) {
            $chat->update(['unread_count_user' => 0]);
        }

        return response()->json(['success' => true]);
    }
}
