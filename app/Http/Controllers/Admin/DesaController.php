<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $desa = \App\Models\Village::get();
        // dd($desa->district->nama_kecamatan);
        return view('pages.admin.desa.index')->with(compact('desa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = \App\Models\District::get();
        return view('pages.admin.desa.create')->with(compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $validated = $request->validate([
            'nama_desa' => 'required|string|max:255|unique:villages',
            'kecamatan_id' => 'required',
            'koordinat_bidang_desa' => 'file',
        ]);
        // dd($request->koordinat_bidang_kecamatan);
        $koordinat_bidang_desa = null;
        if (isset($request->koordinat_bidang_desa)) {
            $array = explode('.', $request->koordinat_bidang_desa->getClientOriginalName());
            if ($array['1'] !== "geojson") {
                return back()
                    ->withErrors("file koordinat bidang desa not geojson format")
                    ->withInput();
            }
            $koordinat_bidang_desa = \Illuminate\Support\Facades\Storage::disk('public')->put('koordinat-bidang-desa', $validated['koordinat_bidang_desa']);
        }
        // dd($koordinat_bidang_kecamatan);
        $kecamatan = \App\Models\Village::create([
            'nama_desa' => $validated['nama_desa'],
            'district_id' => $validated['kecamatan_id'],
            'koordinat_bidang_desa' => $koordinat_bidang_desa,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($kecamatan);s
        session(['success' => 'Berhasil Menambahkan Data Desa']);
        return redirect()->route('adminDesa');
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
        $desa = \App\Models\Village::find($id);
        // dd($desa);
        if ($desa->koordinat_bidang_desa !== null) {
            return view('pages.admin.desa.show')->with(compact('desa'));
        }
        session(['warning' => 'Data Peta Tidak Ada']);
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kecamatan = \App\Models\District::get();
        $desa = \App\Models\Village::find($id);
        // dd($kecamatan);
        return view('pages.admin.desa.edit')->with(compact('kecamatan', 'desa'));
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
            'nama_desa' => 'required|string|max:255',
            'kecamatan_id' => 'required',
            'koordinat_bidang_desa' => 'file',
        ]);
        // dd($request->koordinat_bidang_kecamatan);
        $koordinat_bidang_desa = null;
        if (isset($request->koordinat_bidang_desa)) {
            $array = explode('.', $request->koordinat_bidang_desa->getClientOriginalName());
            if ($array['1'] !== "geojson") {
                return back()
                    ->withErrors("file koordinat bidang desa not geojson format")
                    ->withInput();
            }
            $koordinat_bidang_desa = \Illuminate\Support\Facades\Storage::disk('public')->put('koordinat-bidang-desa', $validated['koordinat_bidang_desa']);
        }
        // dd($koordinat_bidang_desa);
        $desa = \App\Models\Village::where('id', '=', $id)->update([
            'nama_desa' => $validated['nama_desa'],
            'district_id' => $validated['kecamatan_id'],
            'koordinat_bidang_desa' => $koordinat_bidang_desa,
            'updated_at' => now(),
        ]);
        // dd($kecamatan);s
        session(['success' => 'Berhasil Mengubah Data Desa']);
        return redirect()->route('adminDesa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $desa = \App\Models\Village::find($id);

        foreach ($desa->guestLands as $guestLand) {
            $guestLand->delete();
            foreach ($guestLand->statusPekerjaans as $statusPekerjaan) {
                $statusPekerjaan->delete();
            }
            foreach ($guestLand->buktiPekerjaans as $buktiPekerjaan) {
                $buktiPekerjaan->delete();
            }
        }
        $desa->delete();

        session(['success' => 'Berhasil Menghapus Data Desa']);
        return back();
    }
}
