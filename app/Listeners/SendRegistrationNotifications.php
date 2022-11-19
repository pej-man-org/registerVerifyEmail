<?php

namespace App\Listeners;

use App\Events\NewRegistered;
use App\Notifications\SendVerificationCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegistrationNotifications implements ShouldQueue
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
     * @param  \App\Events\NewRegistered  $event
     * @return void
     */
    public function handle(NewRegistered $event)
    {
        $event->user->notify(new SendVerificationCode($event->user, $event->verification_code));
    }
}
