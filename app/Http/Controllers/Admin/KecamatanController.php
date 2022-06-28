<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kecamatan = \App\Models\District::get();
        return view('pages.admin.kecamatan.index')->with(compact('kecamatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.kecamatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kecamatan' => 'required|string|max:255|unique:districts',
            // 'koordinat_bidang_kecamatan' => 'file',
        ]);
        // dd($request->koordinat_bidang_kecamatan);
        // $koordinat_bidang_kecamatan = null;
        // if (isset($request->koordinat_bidang_kecamatan)) {
        //     $array = explode('.', $request->koordinat_bidang_kecamatan->getClientOriginalName());
        //     if ($array['1'] !== "geojson") {
        //         return back()
        //             ->withErrors("file koordinat bidang kecamatan not geojson format")
        //             ->withInput();
        //     }
        //     $koordinat_bidang_kecamatan = \Illuminate\Support\Facades\Storage::disk('public')->put('koordinat-bidang-kecamatan', $validated['koordinat_bidang_kecamatan']);
        // }
        // dd($koordinat_bidang_kecamatan);
        $kecamatan = \App\Models\District::create([
            'nama_kecamatan' => $validated['nama_kecamatan'],
            // 'koordinat_bidang_kecamatan' => $koordinat_bidang_kecamatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($kecamatan);s
        session(['success' => 'Berhasil Menambahkan Data Kecamatan']);
        return redirect()->route('adminKecamatan');
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
        $kecamatan = \App\Models\District::find($id);
        // dd($kecamatan);
        if ($kecamatan->koordinat_bidang_kecamatan !== null) {
            return view('pages.admin.kecamatan.show')->with(compact('kecamatan'));
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
        $kecamatan = \App\Models\District::find($id);
        // dd($kecamatan);
        return view('pages.admin.kecamatan.edit')->with(compact('kecamatan'));
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
        $validated = $request->validate([
            'nama_kecamatan' => 'required|string|max:255|unique:districts',
            // 'koordinat_bidang_kecamatan' => 'file',
        ]);
        // dd($request->koordinat_bidang_kecamatan);
        // $koordinat_bidang_kecamatan = null;
        // if (isset($request->koordinat_bidang_kecamatan)) {
        //     $array = explode('.', $request->koordinat_bidang_kecamatan->getClientOriginalName());
        //     if ($array['1'] !== "geojson") {
        //         return back()
        //             ->withErrors("file koordinat bidang kecamatan not geojson format")
        //             ->withInput();
        //     }
        //     $koordinat_bidang_kecamatan = \Illuminate\Support\Facades\Storage::disk('public')->put('koordinat-bidang-kecamatan', $validated['koordinat_bidang_kecamatan']);
        // }
        // dd($koordinat_bidang_kecamatan);
        $kecamatan = \App\Models\District::where('id', '=', $id)->update([
            'nama_kecamatan' => $validated['nama_kecamatan'],
            // 'koordinat_bidang_kecamatan' => $koordinat_bidang_kecamatan,
            'updated_at' => now(),
        ]);
        // dd($kecamatan);s
        session(['success' => 'Berhasil Mengubah Data Kecamatan']);
        return redirect()->route('adminKecamatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kecamatan = \App\Models\District::find($id);

        foreach ($kecamatan->villages as $desa) {
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
        }
        $kecamatan->delete();
        session(['success' => 'Berhasil Menghapus Data Kecamatan']);
        return back();
    }
}
