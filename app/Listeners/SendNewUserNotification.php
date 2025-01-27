<?php

namespace App\Listeners;

use App\Events\NewCreatedUser;
use App\Notifications\NewUserPasswordChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserNotification
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
    public function handle(NewCreatedUser $event): void
    {
        Notification::send($event->user,new NewUserPasswordChange($event->user));
    }
}
