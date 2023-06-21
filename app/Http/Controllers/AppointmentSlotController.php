<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentSlotRequest;
use App\Http\Requests\UpdateAppointmentSlotRequest;
use App\Models\AppointmentSlot;

class AppointmentSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentSlotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentSlotRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return \Illuminate\Http\Response
     */
    public function show(AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentSlotRequest  $request
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentSlotRequest $request, AppointmentSlot $appointmentSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppointmentSlot  $appointmentSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppointmentSlot $appointmentSlot)
    {
        //
    }
}
