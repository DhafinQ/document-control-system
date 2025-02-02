<?php

namespace App\Listeners;

use App\Events\NewApprovalDocument;
use App\Models\User;
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
        $user = User::whereHas('roles', function ($query) use ($event) {
            $query->whereIn('id', $event->roles);
        })->get();

        Notification::send($user, new DocumentApprovalNotification($event->document,$event->message,$event->link));
    }
}
