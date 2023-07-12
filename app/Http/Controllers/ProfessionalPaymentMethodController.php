<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalPaymentMethodRequest;
use App\Http\Requests\UpdateProfessionalPaymentMethodRequest;
use App\Models\ProfessionalPaymentMethod;

class ProfessionalPaymentMethodController extends Controller
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
     * @param  \App\Http\Requests\StoreProfessionalPaymentMethodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessionalPaymentMethodRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfessionalPaymentMethod  $professionalPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessionalPaymentMethod $professionalPaymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfessionalPaymentMethod  $professionalPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionalPaymentMethod $professionalPaymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessionalPaymentMethodRequest  $request
     * @param  \App\Models\ProfessionalPaymentMethod  $professionalPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessionalPaymentMethodRequest $request, ProfessionalPaymentMethod $professionalPaymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfessionalPaymentMethod  $professionalPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionalPaymentMethod $professionalPaymentMethod)
    {
        //
    }
}
