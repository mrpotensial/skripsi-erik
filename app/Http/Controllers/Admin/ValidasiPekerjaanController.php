<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidasiPekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where('status_proses', '=', '6')->get();
        // dd($guestLands);
        return view('pages.admin.proses-pekerjaan.validasi-pekerjaan.index')->with(compact('guestLands'));
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
        // dd($guestLand);
        return view('pages.admin.proses-pekerjaan.validasi-pekerjaan.show')->with(compact('guestLand'));
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
        // dd($type);
        $validated = $request->validate([
            'status_proses' => 'required|numeric'
        ]);
        // dd($request->all());
        $guestLand = \App\Models\GuestLand::find($id);
        // dd($guestLand, $validated['status_proses']);
        if ($validated['status_proses'] > $guestLand->status_proses) {
            $guestLand->judul_status_proses = "Pekerjaan Selesai";
            $guestLand->status_proses = $validated['status_proses'];
            $guestLand->batas_waktu_proses = now()->format('Y-m-d');
            $guestLand->save();
            session(['success' => 'Pekerjaan Selesai']);
        } else {
            $validated = $request->validate([
                'status_proses' => 'required|numeric',
                'batas_waktu_pekerjaan' => 'required|date'
            ]);
            $guestLand->judul_status_proses = "Pembuatan Map Ulang";
            $guestLand->status_proses = $validated['status_proses'];
            $guestLand->batas_waktu_proses = $validated['batas_waktu_pekerjaan'];
            $guestLand->save();
            session(['success' => 'Berhasil Menambahkan Batas Waktu Pembuatan Map Ulang']);
        }
        \App\Models\StatusPekerjaan::store_perubahan_data($guestLand);

        return redirect()->route('adminValidasiPekerjaan');
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
