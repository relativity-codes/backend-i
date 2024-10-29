<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\AwsSns\SnsChannel;
use NotificationChannels\AwsSns\SnsMessage;

class BillCreatedSmsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return [SnsChannel::class];
    }

    public function toSns($notifiable)
    {
        return new SnsMessage("Your bill has been created");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
