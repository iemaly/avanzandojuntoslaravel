<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookBedRequest;
use App\Http\Requests\UpdateBookBedRequest;
use App\Models\BookBed;

class BookBedController extends Controller
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
     * @param  \App\Http\Requests\StoreBookBedRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookBedRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookBed  $bookBed
     * @return \Illuminate\Http\Response
     */
    public function show(BookBed $bookBed)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookBed  $bookBed
     * @return \Illuminate\Http\Response
     */
    public function edit(BookBed $bookBed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookBedRequest  $request
     * @param  \App\Models\BookBed  $bookBed
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookBedRequest $request, BookBed $bookBed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookBed  $bookBed
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookBed $bookBed)
    {
        //
    }
}
