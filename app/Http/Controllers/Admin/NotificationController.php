<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\CustomNotification;
use Illuminate\Http\Request;
use \App\Notifications;


class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('is_custom', true)
            ->latest()
            ->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:255',
        ]);

        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            if ($user->fcm_token) {
                $user->notify(new CustomNotification($request->title, $request->body));
                Notification::create([
                    'title' => $request->title,
                    'body' => $request->body,
                    'is_custom' => true,
                    'user_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification sent to all users successfully.');
    }
}
