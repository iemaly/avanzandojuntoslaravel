<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareHomeMediaRequest;
use App\Http\Requests\UpdateCareHomeMediaRequest;
use App\Models\CareHomeMedia;

class CareHomeMediaController extends Controller
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
     * @param  \App\Http\Requests\StoreCareHomeMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCareHomeMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CareHomeMedia  $careHomeMedia
     * @return \Illuminate\Http\Response
     */
    public function show(CareHomeMedia $careHomeMedia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CareHomeMedia  $careHomeMedia
     * @return \Illuminate\Http\Response
     */
    public function edit(CareHomeMedia $careHomeMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCareHomeMediaRequest  $request
     * @param  \App\Models\CareHomeMedia  $careHomeMedia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCareHomeMediaRequest $request, CareHomeMedia $careHomeMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CareHomeMedia  $careHomeMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareHomeMedia $careHomeMedia)
    {
        //
    }
}
