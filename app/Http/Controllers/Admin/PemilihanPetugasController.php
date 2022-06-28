<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemilihanPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where('status_proses', '=', 0)->get();
        // dd($guestLands);
        return view('pages.admin.proses-pekerjaan.pemilihan-petugas.index')->with(compact('guestLands'));
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
        // dd($request->all());
        $validated = $request->validate([
            'petugas' => 'required|numeric',
            'batas_waktu_pekerjaan' => 'required|date',
        ]);

        // dd($validated);
        $guestLand = \App\Models\GuestLand::find($id);

        $guestLand->user_id = $validated['petugas'];
        $guestLand->status_proses = ($guestLand->status_proses + 1);
        $guestLand->judul_status_proses = "Pemilihan Petugas";
        $guestLand->batas_waktu_proses = $validated['batas_waktu_pekerjaan'];

        $guestLand->save();

        // dd($guestLand);s

        $status_pekerjaan = \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'judul_pekerjaan' => $guestLand->judul_status_proses,
            'status_pekerjaan' => $guestLand->status_proses,
            'batas_waktu_pekerjaan' => $validated['petugas'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['success' => 'Berhasil Menambahkan Petugas']);
        return redirect()->route('adminPemilihanPetugas');
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
