<?php

namespace App\Providers;

use App\Events\AboutTheUser;
use App\Listeners\AboutTheUser as ListenersAboutTheUser;
use App\Listeners\AlertForNewMessage;
use App\Listeners\SendMailForNewMessage;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AboutTheUser::class=>[
            AlertForNewMessage::class,
            ListenersAboutTheUser::class,
            // SendMailForNewMessage::class,
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];



    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
