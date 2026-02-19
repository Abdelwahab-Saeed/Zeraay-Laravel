<?php

namespace App\Notifications;

use DevKandil\NotiFire\Enums\MessagePriority;
use DevKandil\NotiFire\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $title, private string $body)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['fcm'];
    }

    /**
     * Get the FCM representation of the notification.
     */
    public function toFcm(object $notifiable): FcmMessage
    {
        return FcmMessage::create($this->title, $this->body)
            ->image('https://example.com/notification-image.jpg')
            ->sound('default')
            ->clickAction('OPEN_ACTIVITY')
            ->icon('notification_icon')
            ->color('#FF5733')
            ->priority(MessagePriority::HIGH)
            ->data([
                'notification_id' => uniqid('notification_'),
                'timestamp' => now()->toIso8601String(),
            ]);
    }
}
