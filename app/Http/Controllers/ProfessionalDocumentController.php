<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfessionalDocumentRequest;
use App\Http\Requests\UpdateProfessionalDocumentRequest;
use App\Models\ProfessionalDocument;

class ProfessionalDocumentController extends Controller
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
     * @param  \App\Http\Requests\StoreProfessionalDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProfessionalDocumentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfessionalDocument  $professionalDocument
     * @return \Illuminate\Http\Response
     */
    public function show(ProfessionalDocument $professionalDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfessionalDocument  $professionalDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfessionalDocument $professionalDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProfessionalDocumentRequest  $request
     * @param  \App\Models\ProfessionalDocument  $professionalDocument
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfessionalDocumentRequest $request, ProfessionalDocument $professionalDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfessionalDocument  $professionalDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfessionalDocument $professionalDocument)
    {
        //
    }
}
