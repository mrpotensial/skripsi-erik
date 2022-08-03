<?php

namespace App\Http\Controllers\Koordinator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KoordinatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = array();

        $desa = \App\Models\Village::get();
        $kecamatan = \App\Models\District::get();

        $guestLands = \App\Models\GuestLand::where('status_proses', '=', '5')->get();
        // dd($guestLands[0]->village);
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        // dd($guestLand);
        // dd($petugas);
        $count = array(
            'total-user' => \App\Models\User::get()->count(),
            'total-admin' => \App\Models\User::where('level', '=', '0')->get()->count(),
            'total-petugas' => \App\Models\User::where('level', '=', '1')->get()->count(),
            'total-pengajuan' => \App\Models\GuestLand::get()->count(),
            'pendaftaran' => \App\Models\StatusPekerjaan::where('status_pekerjaan', '=', '0')->get()->count(),
            'pemilihan-petugas' => \App\Models\StatusPekerjaan::where('status_pekerjaan', '=', '1')->get()->count(),
            'pengukuran-bidang' => \App\Models\StatusPekerjaan::where('status_pekerjaan', '=', '2')->get()->count(),
            'pembuatan-peta' => \App\Models\StatusPekerjaan::where('status_pekerjaan', '=', '3')->get()->count(),
            'pengecekan-pekerjaan' => \App\Models\StatusPekerjaan::where('status_pekerjaan', '=', '4')->get()->count(),
            'pekerjaan-selesai' => \App\Models\StatusPekerjaan::where('status_pekerjaan', '=', '5')->get()->count(),
        );
        // $guestLands = json_encode($guestLands);
        // dd(url());
        // dd($kecamatan->villages);
        return view('pages.admin.dashboard')->with(compact('count', 'guestLands', 'kecamatan', 'desa'));
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
        //
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
