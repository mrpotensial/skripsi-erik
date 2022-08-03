<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = \App\Models\User::where('level', '=', '2')->get();
        $guestLands = \App\Models\GuestLand::where('status_proses', '<', '5')->get();
        return view('pages.admin.petugas.index')->with(compact(
            'staffs',
            'guestLands'
        ));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = \App\Models\User::where('id', '=', $id)->first();
        $guestLands = \App\Models\GuestLand::where('user_id', '=', $staff->id)->get();
        return view('pages.admin.petugas.show')->with(compact('staff', 'guestLands'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $staff = \App\Models\User::where('id', '=', $id)->first();
        $guestLands = \App\Models\GuestLand::where('user_id', '=', null)->get();
        return view('pages.admin.petugas.edit')->with(compact('staff', 'guestLands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->input());

        $validated = $request->validate([
            'id' => 'required',
        ]);
        $guestLand = \App\Models\GuestLand::find($validated['id'])->first();
        \App\Models\GuestLand::find($validated['id'])->update([
            'user_id' => $id,
            'status_pengerjaan' => $guestLand->status_pengerjaan++,
            'updated_at' => now(),
        ]);
        session(['success' => 'Berhasil Menambahkan Data']);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
