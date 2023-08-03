<?php

namespace App\Listeners;

use App\Events\CarehomeBookingNotifyEvent;
use App\Mail\CarehomeBookingNotifyMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CarehomeBookingNotifyListener
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
     * @param  \App\Events\CarehomeBookingNotifyEvent  $event
     * @return void
     */
    public function handle(CarehomeBookingNotifyEvent $event)
    {
        Mail::to($event->data['carehome']->email)->send(new CarehomeBookingNotifyMail($event->data));
    }
}
