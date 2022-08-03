<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengukuranBidangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->where('status_proses', '=', '1')->get();
        return view('pages.petugas.proses-pekerjaan.pengukuran-bidang.index')->with(compact('guestLands'));
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
        // dd($id);
        $guestLand = \App\Models\GuestLand::where('user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)->find($id);
        return view('pages.petugas.proses-pekerjaan.pengukuran-bidang.edit')->with(compact(
            'guestLand'
        ));
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
        Validator::make(
            $request->all(),
            [
                'status_proses' => 'required|numeric',
                'foto_bukti' => 'required',
                'foto_bukti.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'status_proses.required' => 'Status proses tidak boleh kosong',
                'status_proses.numeric' => 'Status proses harus berupa angka',
                'foto_bukti.required' => 'Foto bukti tidak boleh kosong',
                'foto_bukti.*.required' => 'Foto bukti tidak boleh kosong',
                'foto_bukti.*.image' => 'Foto bukti harus berupa gambar',
                'foto_bukti.*.mimes' => 'Foto bukti harus berupa gambar yang memiliki ekstensi jpeg, png, jpg, gif, svg',
                'foto_bukti.*.max' => 'Foto bukti tidak boleh lebih dari 2MB',
            ]
        )->validate();

        $guestLand = \App\Models\GuestLand::find($id);

        $guestLand->judul_status_proses = "Pengukuran Bidang Tanah Selesai";
        $guestLand->status_proses = $request['status_proses'];
        $guestLand->updated_at = now();
        $guestLand->save();

        \App\Models\StatusPekerjaan::store_perubahan_data($guestLand);

        foreach ($request['foto_bukti'] as $foto_bukti) {
            // dd($foto_bukti);
            $path_foto_bidang = \Illuminate\Support\Facades\Storage::disk('public')->put('foto_bukti', $foto_bukti);

            \App\Models\BuktiPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'path' => $path_foto_bidang,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session(['success' => 'Berhasil Menambahkan Bukti Pengkuran Bidang Tanah']);
        return redirect()->route('petugasPengukuranBidang');
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
