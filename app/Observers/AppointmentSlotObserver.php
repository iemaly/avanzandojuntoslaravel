<?php

namespace App\Observers;

use App\Models\AppointmentSlot;

class AppointmentSlotObserver
{
    /**
     * Handle the AppointmentSlot "created" event.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return void
     */
    public function created(AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Handle the AppointmentSlot "updated" event.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return void
     */
    public function updated(AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Handle the AppointmentSlot "deleted" event.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return void
     */
    public function deleted(AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Handle the AppointmentSlot "restored" event.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return void
     */
    public function restored(AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Handle the AppointmentSlot "force deleted" event.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return void
     */
    public function forceDeleted(AppointmentSlot $appointmentSlot)
    {
        //
    }
}
