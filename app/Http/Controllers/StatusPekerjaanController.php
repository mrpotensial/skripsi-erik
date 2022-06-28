<?php

namespace App\Http\Controllers;

use App\Models\StatusPekerjaan;
use App\Http\Requests\StoreStatusPekerjaanRequest;
use App\Http\Requests\UpdateStatusPekerjaanRequest;

class StatusPekerjaanController extends Controller
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
     * @param  \App\Http\Requests\StoreStatusPekerjaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusPekerjaanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatusPekerjaan  $statusPekerjaan
     * @return \Illuminate\Http\Response
     */
    public function show(StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatusPekerjaan  $statusPekerjaan
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusPekerjaanRequest  $request
     * @param  \App\Models\StatusPekerjaan  $statusPekerjaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusPekerjaanRequest $request, StatusPekerjaan $statusPekerjaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusPekerjaan  $statusPekerjaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusPekerjaan $statusPekerjaan)
    {
        //
    }
}
