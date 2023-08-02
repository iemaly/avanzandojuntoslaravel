<?php

namespace App\Listeners;

use App\Events\SendUserEmailVerificationEvent;
use App\Mail\UserEmailVerificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserEmailVerificationListener
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
     * @param  \App\Events\SendUserEmailVerificationEvent  $event
     * @return void
     */
    public function handle(SendUserEmailVerificationEvent $event)
    {
        Mail::to($event->user->email)->send(new UserEmailVerificationMail($event->user));
    }
}
