<?php

namespace App\Http\Controllers;

use App\Models\district;
use App\Http\Requests\StoredistrictRequest;
use App\Http\Requests\UpdatedistrictRequest;

class DistrictController extends Controller
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
     * @param  \App\Http\Requests\StoredistrictRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoredistrictRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\district  $district
     * @return \Illuminate\Http\Response
     */
    public function show(district $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\district  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(district $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedistrictRequest  $request
     * @param  \App\Models\district  $district
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatedistrictRequest $request, district $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\district  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(district $district)
    {
        //
    }
}
