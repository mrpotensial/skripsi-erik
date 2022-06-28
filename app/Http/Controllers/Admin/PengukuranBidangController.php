<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengukuranBidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $guestLands = \App\Models\GuestLand::where('status_proses', '=', '2')->get();
        // dd($guestLands);
        return view('pages.admin.proses-pekerjaan.pengukuran-bidang.index')->with(compact('guestLands'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guestLand = \App\Models\GuestLand::find($id);
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        return view('pages.admin.proses-pekerjaan.pemilihan-petugas.edit')->with(compact('guestLand', 'petugas'));
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
            'status_proses' => 'required|numeric',
            'batas_waktu_pekerjaan' => 'required|date',
        ]);
        $guestLand = \App\Models\GuestLand::find($id);
        $guestLand->judul_status_proses = "Penetapan Batas Waktu Pengukuran Bidang Tanah";
        $guestLand->status_proses = $validated['status_proses'];
        $guestLand->batas_waktu_proses = $validated['batas_waktu_pekerjaan'];
        $guestLand->created_at = now();
        $guestLand->save();

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'judul_pekerjaan' => $guestLand->judul_status_proses,
            'status_pekerjaan' => $guestLand->status_proses,
            'batas_waktu_pekerjaan' => $guestLand->batas_waktu_proses,
            'created_at' => now(),
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
