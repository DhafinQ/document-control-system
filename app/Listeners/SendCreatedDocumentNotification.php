<?php

namespace App\Listeners;

use App\Events\NewCreatedDocument;
use App\Models\User;
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
    public function handle(NewCreatedDocument $event): void
    {
        $users = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [1,2]);
        })->get();
        foreach($users as $user){
            Notification::send($user, new DocumentCreatedNotification($event->document,$event->message));
        }
    }
}
