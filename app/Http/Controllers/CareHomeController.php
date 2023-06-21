<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareHomeRequest;
use App\Http\Requests\UpdateCareHomeRequest;
use App\Models\CareHome;

class CareHomeController extends Controller
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
     * @param  \App\Http\Requests\StoreCareHomeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCareHomeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CareHome  $careHome
     * @return \Illuminate\Http\Response
     */
    public function show(CareHome $careHome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CareHome  $careHome
     * @return \Illuminate\Http\Response
     */
    public function edit(CareHome $careHome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCareHomeRequest  $request
     * @param  \App\Models\CareHome  $careHome
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCareHomeRequest $request, CareHome $careHome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CareHome  $careHome
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareHome $careHome)
    {
        //
    }
}
