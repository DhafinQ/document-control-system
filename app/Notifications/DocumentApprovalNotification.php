<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentApprovalNotification extends Notification
{
    use Queueable;

    private $docRevision;

    /**
     * Create a new notification instance.
     * @return void
     */
    public function __construct($docRevision)
    {
        $this->docRevision = $docRevision;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    
     public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->docRevision->document->title} dokumen menunggu persetujuan",
            // 'count' => $this->docRevision,
        ];
    }
}
