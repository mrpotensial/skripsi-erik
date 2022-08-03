<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaftarTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(session()->all());
        $guestLands = \App\Models\GuestLand::where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->where('status_proses', '=', 5)->get();
        return view('pages.petugas.proses-pekerjaan.daftar-tugas.index')->with(compact('guestLands'));
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

        // dd($id);
        $guestLand = \App\Models\GuestLand::find($id);

        return view('pages.petugas.proses-pekerjaan.daftar-tugas.show')->with(compact(
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
        // dd($request->input());
        $validated = $request->validate([
            'user' => '',
            'status_pengerjaan' => 'required',
        ]);
        $guesland = \App\Models\GuestLand::find($id);

        $guesland->user_id = $validated['user'];
        $guesland->status_pengerjaan = $validated['status_pengerjaan'];

        $guesland->save();

        session(['success' => 'Berhasil Menambahkan Peta Bidang Tanah']);
        return redirect()->route('petugasPembuatanPeta');
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
