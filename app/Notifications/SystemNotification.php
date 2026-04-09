<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public string $title;
    public string $message;
    public string $type;
    public string $url;

    public function __construct(string $title, string $message, string $type = 'info', string $url = '#')
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url;
    }

    /**
     * Only store notifications in the database (displayed in navbar).
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->url,
        ];
    }
}
