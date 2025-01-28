<?php

namespace App\Listeners;

use App\Events\NewApprovalDocument;
use App\Notifications\DocumentApprovalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendApprovalDocumentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewApprovalDocument $event): void
    {
        Notification::send($event->ApprovalDocument, new DocumentApprovalNotification($event->ApprovalDocument));
    }
}
