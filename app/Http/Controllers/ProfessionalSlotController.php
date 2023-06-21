<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalSlotRequest;
use App\Http\Requests\UpdateProfessionalSlotRequest;
use App\Models\ProfessionalSlot;

class ProfessionalSlotController extends Controller
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
     * @param  \App\Http\Requests\StoreProfessionalSlotRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessionalSlotRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfessionalSlot  $professionalSlot
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessionalSlot $professionalSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfessionalSlot  $professionalSlot
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionalSlot $professionalSlot)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessionalSlotRequest  $request
     * @param  \App\Models\ProfessionalSlot  $professionalSlot
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessionalSlotRequest $request, ProfessionalSlot $professionalSlot)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfessionalSlot  $professionalSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionalSlot $professionalSlot)
    {
        //
    }
}
