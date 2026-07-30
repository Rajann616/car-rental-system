<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminNotification extends Notification
{
    use Queueable;

    protected string $title;
    protected string $message;
    protected string $actionUrl;
    protected string $icon;
    protected string $color;

    public function __construct(string $title, string $message, string $actionUrl, string $icon = 'fa-bell', string $color = 'text-primary')
    {
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->icon = $icon;
        $this->color = $color;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->actionUrl,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }
}
