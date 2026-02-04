<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /**
     * List all chats for admins.
     */
    public function index(Request $request)
    {
        $chats = Chat::with('user')
            ->orderBy('last_message_at', 'desc')
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'chats' => $chats
            ]);
        }

        return view('admin.chats.index', compact('chats'));
    }

    /**
     * Show history for a specific chat.
     */
    public function show(Request $request, $id)
    {
        $chat = Chat::with('user')->findOrFail($id);
        $messages = $chat->messages()->orderBy('created_at', 'asc')->get();

        // Mark as read by admin
        $chat->update(['unread_count_admin' => 0]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'chat' => $chat,
                'messages' => $messages
            ]);
        }

        return view('admin.chats.show', compact('chat', 'messages'));
    }

    /**
     * Send a reply from admin to user.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'message_type' => 'required|in:text,image,file'
        ]);

        $chat = Chat::findOrFail($id);
        $adminId = auth()->id();

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
            'sender_id' => $adminId,
            'sender_type' => 'admin',
            'message_type' => $request->message_type,
            'content' => $content,
        ]);

        $chat->update([
            'last_message_at' => now(),
            'unread_count_user' => $chat->unread_count_user + 1
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        }

        return redirect()->back()->with('success', 'تم إرسال الرد بنجاح');
    }

    /**
     * Mark messages in a chat as read by admin.
     */
    public function markRead(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);
        $chat->update(['unread_count_admin' => 0]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }
}
