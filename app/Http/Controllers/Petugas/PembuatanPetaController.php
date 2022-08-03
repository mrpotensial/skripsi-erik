<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembuatanPetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::where([['user_id', '=', \Illuminate\Support\Facades\Auth::user()->id], ['status_proses', '=', '2']])->get();
        return view('pages.petugas.proses-pekerjaan.pembuatan-peta.index')->with(compact('guestLands'));
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
        $guestLand = \App\Models\GuestLand::where('id', '=', $id)->first();
        // dd($guestLand);
        return view('pages.petugas.proses-pekerjaan.pembuatan-peta.edit')->with(compact('guestLand'));
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
                'luas_bidang' => 'required|numeric',
                'koordinat_bidang' => 'required|file',
                'peta_bidang' => 'required|file|mimetypes:application/pdf',
                'status_pengerjaan' => 'required',
            ],
            [
                'luas_bidang.required' => 'Luas bidang tidak boleh kosong',
                'luas_bidang.numeric' => 'Luas bidang harus berupa angka',
                'koordinat_bidang.required' => 'Koordinat bidang tidak boleh kosong',
                'koordinat_bidang.file' => 'File koordinat bidang tidak boleh kosong',
                'peta_bidang.required' => 'Peta bidang tidak boleh kosong',
                'peta_bidang.file' => 'File peta bidang tidak boleh kosong',
                'peta_bidang.mimetypes' => 'File peta bidang harus berformat PDF',
                'status_pengerjaan.required' => 'Status pengerjaan tidak boleh kosong',
            ]
        );
        // dd($validated);

        try {
            $array = explode('.', $request->koordinat_bidang->getClientOriginalName());
        } catch (\Throwable $th) {
            return back()
                ->withErrors("file koordinat bidang kosong")
                ->withInput();
        }

        if ($array['1'] !== "geojson") {
            return back()
                ->withErrors("file koordinat bidang bukan format geojson")
                ->withInput();
        }

        $koordinat_bidang = \Illuminate\Support\Facades\Storage::disk('public')->put('koordinat-bidang', $request['koordinat_bidang']);
        $peta_bidang = \Illuminate\Support\Facades\Storage::disk('public')->put('peta-bidang', $request['peta_bidang']);
        // dd($peta_bidang);

        $guestland = \App\Models\GuestLand::find($id);
        $guestland->luas_tanah = $request['luas_bidang'];
        $guestland->koordinat_bidang = $koordinat_bidang;
        $guestland->peta_bidang = $peta_bidang;
        $guestland->judul_status_proses = "Pembuatan Peta Selesai";
        $guestland->status_proses = $request['status_pengerjaan'];
        $guestland->updated_at = now();
        $guestland->save();

        // dd($guestland);

        \App\Models\StatusPekerjaan::store_perubahan_data($guestland);

        return redirect()->route('petugasDaftarTugasShow', ['id' => $guestland->id]);
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
