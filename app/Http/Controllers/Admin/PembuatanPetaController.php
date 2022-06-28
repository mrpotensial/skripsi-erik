<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembuatanPetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where('status_proses', '=', '4')->get();
        // dd($guestLands);
        return view('pages.admin.proses-pekerjaan.pembuatan-peta.index')->with(compact('guestLands'));
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
        $guestLand = \App\Models\GuestLand::find($id);
        return view('pages.admin.proses-pekerjaan.pembuatan-peta.show')->with(compact(
            'guestLand'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'status_proses' => 'required|numeric',
            'batas_waktu_pekerjaan' => 'required|date',
        ]);
        $guestLand = \App\Models\GuestLand::find($id);

        if ($validated['status_proses'] > $guestLand->status_proses) {
            $guestLand->judul_status_proses = "Penetapan Batas Waktu Pembuatan Peta";
            session(['success' => 'Berhasil Menetapkan Batas Waktu Pembuatan Peta']);
        } else {
            $guestLand->judul_status_proses = "Pengukuran Bidang Tanah Ulang";
            session(['success' => 'Berhasil Menetapkan Batas Waktu Pengukurang Bidang Ulang']);
            foreach ($guestLand->buktiPekerjaans as $pengukuranbidang) {
                $pengukuranbidang->delete();
            }
        }
        $guestLand->status_proses = $validated['status_proses'];
        $guestLand->batas_waktu_proses = $validated['batas_waktu_pekerjaan'];
        $guestLand->created_at = now();
        $guestLand->save();
        // dd($guestLand);
        // dd($status);

        \App\Models\StatusPekerjaan::store_perubahan_data($guestLand);

        return redirect()->route('adminPembuatanPeta');
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
