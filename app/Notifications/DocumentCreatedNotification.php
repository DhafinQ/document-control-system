<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentCreatedNotification extends Notification
{
    use Queueable;
    private $docCreated;

    /**
     * Create a new notification instance.
     */
    public function __construct($docCreated)
    {
        $this->docCreated = $docCreated;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->docCreated->name,
            'message' => 'Dokumen baru telah dibuat oleh '.$this->docCreated->name.'!',
            'link' => 'javascript:void()' 
        ];
    }
}
