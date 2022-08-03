<?php

namespace App\Http\Controllers;

use App\Models\Village;
use App\Http\Requests\StoreVillageRequest;
use App\Http\Requests\UpdateVillageRequest;

class VillageController extends Controller
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
     * @param  \App\Http\Requests\StoreVillageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVillageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Village  $Village
     * @return \Illuminate\Http\Response
     */
    public function show(Village $Village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Village  $Village
     * @return \Illuminate\Http\Response
     */
    public function edit(Village $Village)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVillageRequest  $request
     * @param  \App\Models\Village  $Village
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVillageRequest $request, Village $Village)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Village  $Village
     * @return \Illuminate\Http\Response
     */
    public function destroy(Village $Village)
    {
        //
    }
}
