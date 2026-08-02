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
    protected ?string $replyEmail;

    public function __construct(string $title, string $message, string $actionUrl, string $icon = 'fa-bell', string $color = 'text-primary', ?string $replyEmail = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->icon = $icon;
        $this->color = $color;
        $this->replyEmail = $replyEmail;
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
            'reply_email' => $this->replyEmail,
        ];
    }
}
