<?php

namespace App\Listeners;

use App\Events\NewApprovalDocument;
use App\Notifications\DocumentApprovalNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\User;

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
        $user = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();

        Notification::send($user, new DocumentApprovalNotification($event->UserApprovalDoc));
    }
}
