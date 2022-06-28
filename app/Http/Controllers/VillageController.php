<?php

namespace App\Http\Controllers;

use App\Models\village;
use App\Http\Requests\StorevillageRequest;
use App\Http\Requests\UpdatevillageRequest;

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
     * @param  \App\Http\Requests\StorevillageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorevillageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\village  $village
     * @return \Illuminate\Http\Response
     */
    public function show(village $village)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\village  $village
     * @return \Illuminate\Http\Response
     */
    public function edit(village $village)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatevillageRequest  $request
     * @param  \App\Models\village  $village
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatevillageRequest $request, village $village)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\village  $village
     * @return \Illuminate\Http\Response
     */
    public function destroy(village $village)
    {
        //
    }
}
