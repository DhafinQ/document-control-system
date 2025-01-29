<?php

namespace App\Listeners;

use App\Events\DocumentCreated;
use App\Notifications\DocumentCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\User;

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
        $user = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();
        Notification::send($user, new DocumentCreatedNotification($event->createdDocumen));
    }
}
