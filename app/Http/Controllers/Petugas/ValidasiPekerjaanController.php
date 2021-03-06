<?php

namespace App\Http\Controllers\Petugas;

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

        $guestLands = \App\Models\GuestLand::where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->where('status_proses', '=', '1')->get();
        // dd()
        return view('pages.petugas.proses-pekerjaan.validasi-pekerjaan.index')->with(compact('guestLands'));
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
        ]);

        $guestLand = \App\Models\GuestLand::find($id);

        if ($guestLand->status_proses > $validated['status_proses']) {
            // $user_id = Null;
            if ($validated['status_proses'] == 1) {
                foreach ($guestLand->buktiPekerjaans as $buktiPekerjaan) {
                    $buktiPekerjaan->delete();
                }
            }
            $status_label = "Terjadi Kesalahan, Pekerjaan ditinjau ulang";
        } else {
            // $user_id = \Illuminate\Support\Facades\Auth::user()->id;
            $status_label = "Pekerjaan ditinjau oleh Koordinator";
        }

        // $guestLand->user_id = $user_id;
        $guestLand->judul_status_proses = $status_label;
        $guestLand->status_proses = $validated['status_proses'];
        $guestLand->updated_at = now();
        $guestLand->save();

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'judul_pekerjaan' => $status_label,
            'status_pekerjaan' => $validated['status_proses'],
            'batas_waktu_pekerjaan' => $guestLand->batas_waktu_proses,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($guestLand);

        // session(['success' => 'Berhasil Menambahkan Pekerjaan']);

        if ($guestLand->status_proses < 3) {
            // dd('ulang');
            session(['success' => 'Berhasil Mengulang Pekerjaan']);
            return redirect()->route('petugasDaftarTugas');
        } else {
            // dd('Berhasil');
            session(['success' => 'Berhasil Menyelesaikan Pekerjaaan']);
            return redirect()->route('petugasDaftarTugas');
        }
        // dd('tak terkoneksi');
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
