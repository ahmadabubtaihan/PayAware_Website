<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CreditorNotification extends Notification
{
    use Queueable;

    private $data;

    /**
     * Create a new notification instance.
     * * @param array $dataArray [title, message, icon, color, url]
     */
    public function __construct($dataArray)
    {
        $this->data = $dataArray;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'icon' => $this->data['icon'] ?? 'bell', 
            'color' => $this->data['color'] ?? 'text-slate-500', 
            'url' => $this->data['url'] ?? '#',
        ];
    }
}