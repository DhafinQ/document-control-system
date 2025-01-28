<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentApprovalNotification extends Notification
{
    use Queueable;
    private $docApproval;

    /**
     * Create a new notification instance.
     * @return void
     */
    public function __construct($docApproval)
    {
        $this->docApproval = $docApproval;
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
            'name' => $this->docApproval->document,
            'message' => 'Dokumen '.$this->docApproval->name.'Menunggu Persetujuan',
            'link' => 'javascript:void()'
        ];
    }
}
