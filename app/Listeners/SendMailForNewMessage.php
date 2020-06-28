<?php

namespace App\Listeners;

use App\Events\AboutTheUser;
use App\Mail\MailForNewMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendMailForNewMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AboutTheUser  $event
     * @return void
     */
    public function handle(AboutTheUser $event)
    {
        $user = Auth::user();
        Mail::to($user->email)->send(new MailForNewMessage());
    }
}
