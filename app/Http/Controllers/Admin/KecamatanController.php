<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        Validator::make(
            $request->all(),
            [
                'nama_kecamatan' => 'required|string|max:255|unique:districts',
                // 'koordinat_bidang_kecamatan' => 'file',
            ],
            [
                'nama_kecamatan.required' => 'Nama kecamatan tidak boleh kosong',
                'nama_kecamatan.string' => 'Nama kecamatan harus berupa string',
                'nama_kecamatan.max' => 'Nama kecamatan tidak boleh lebih dari 255 karakter',
                'nama_kecamatan.unique' => 'Nama kecamatan sudah ada',
                // 'koordinat_bidang_kecamatan.file' => 'File koordinat bidang kecamatan harus berupa geojson',
            ]
        )->validate();
        $kecamatan = \App\Models\District::create([
            'nama_kecamatan' => $request['nama_kecamatan'],
            // 'koordinat_bidang_kecamatan' => $koordinat_bidang_kecamatan,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($kecamatan);s
        // session(['success' => 'Berhasil Menambahkan Data Kecamatan']);
        return redirect()->route('adminKecamatan')->with('success', 'Berhasil Menambahkan Data Kecamatan ' . $kecamatan->nama_kecamatan);
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
        // session(['warning' => 'Data Peta Tidak Ada']);
        return back()->withErrors('Data Peta Tidak Ada');
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
        Validator::make(
            $request->all(),
            [
                'nama_kecamatan' => 'required|string|max:255',
                // 'koordinat_bidang_kecamatan' => 'file',
            ],
            [
                'nama_kecamatan.required' => 'Nama kecamatan tidak boleh kosong',
                'nama_kecamatan.string' => 'Nama kecamatan harus berupa string',
                'nama_kecamatan.max' => 'Nama kecamatan tidak boleh lebih dari 255 karakter',
                // 'koordinat_bidang_kecamatan.file' => 'File koordinat bidang kecamatan harus berupa geojson',
            ]
        )->validate();
        $kecamatan = \App\Models\District::where('id', '=', $id)->update([
            'nama_kecamatan' => $request['nama_kecamatan'],
            // 'koordinat_bidang_kecamatan' => $koordinat_bidang_kecamatan,
            'updated_at' => now(),
        ]);
        // dd($kecamatan);s
        // session(['success' => 'Berhasil Mengubah Data Kecamatan']);
        return redirect()->route('adminKecamatan')->with('success', 'Berhasil Mengubah Data Kecamatan ' . $request['nama_kecamatan']);
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
        $title = $kecamatan->nama_kecamatan;
        foreach ($kecamatan->Villages as $desa) {
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
        // session(['success' => 'Berhasil Menghapus Data Kecamatan']);
        return back()->with('success', 'Berhasil Menghapus Data Kecamatan ' . $title);
    }
}
