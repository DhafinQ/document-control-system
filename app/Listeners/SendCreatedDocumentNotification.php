<?php

namespace App\Listeners;

use App\Events\DocumentCreated;
use App\Notifications\DocumentCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendCreatedDocumentNotification
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
    public function handle(object $event): void
    {
        Notification::send($event->createdDocumen, new DocumentCreatedNotification($event->createdDocumen));
    }
}
