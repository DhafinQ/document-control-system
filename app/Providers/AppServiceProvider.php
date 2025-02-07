<?php

namespace App\Providers;

use App\Listeners\SendCreatedDocumentNotification;
use App\Listeners\SendNewUserNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if(config('app.env') === 'local')
        // {
        //     URL::forceScheme('https');
        // }
        Event::listen(SendNewUserNotification::class);
        Event::listen(SendCreatedDocumentNotification::class);
    }
}
