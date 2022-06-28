<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class GuestLandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $guestLands = \App\Models\GuestLand::where('status_pengerjaan', '=', '0')->get();
        $guestLands = \App\Models\GuestLand::get();
        return view('pages.admin.guest-land.index')->with(compact('guestLands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $desa = \App\Models\Village::get();
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        return view('pages.admin.guest-land.create')->with(compact('desa', 'petugas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // \App\Models\StatusPekerjaan::truncate();
        // \App\Models\GuestLand::truncate();

        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_sertifikat' => 'required|numeric|unique:guest_lands',
            'nib' => 'required|numeric|unique:guest_lands',
            'desa' => 'required|numeric',
            'nomor_telpon' => 'required|numeric|min:10',
            'nomor_hak' => 'nullable|numeric',
            'petugas' => 'nullable|numeric',
            'batas_waktu_pekerjaan' => 'required|date',
        ]);

        $status = 0;
        $status_label = "Pendaftaran Berkas";
        if ($validated['petugas'] !== null) {
            $status = 1;
            $status_label = "Pemilihan Petugas";
        }
        // dd($status_label);
        $guestLand = \App\Models\GuestLand::create([
            'user_id' => $validated['petugas'],
            'nama_pemilik' => $validated['nama_pemilik'],
            'nomor_sertifikat' => $validated['nomor_sertifikat'],
            'nib' => $validated['nib'],
            'village_id' => $validated['desa'],
            'nomor_telpon' => $validated['nomor_telpon'],
            'nomor_hak' => $validated['nomor_hak'],
            'judul_status_proses' => $status_label,
            'status_proses' => $status,
            'batas_waktu_proses' => $validated['batas_waktu_pekerjaan'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($guestLand);

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'status_pekerjaan' => $status,
            'judul_pekerjaan' => $status_label,
            'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($status == 1) {
            \App\Models\StatusPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'judul_pekerjaan' => $status_label,
                'status_pekerjaan' => $status,
                'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        session(['success' => 'Berhasil Menambahkan Data Pemohon']);
        return redirect()->route('adminGuestLand');
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
        return view('pages.admin.guest-land.show')->with(compact('guestLand'));
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
        $guestLand = \App\Models\GuestLand::find($id);
        $desa = \App\Models\Village::get();
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        // dd($guestLand);
        return view('pages.admin.guest-land.edit')->with(compact('desa', 'petugas', 'guestLand'));
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

        // dd($guestLand->statusPekerjaans);
        $validated = $request->validate([
            'nama_pemilik' => 'required|string|max:255',
            'nomor_sertifikat' => 'required|numeric',
            'nib' => 'required|numeric',
            'desa' => 'required|string|max:255',
            'nomor_telpon' => 'required|numeric|min:10',
            'nomor_hak' => 'required|numeric|min:10',
            'petugas' => 'nullable|numeric',
            'batas_waktu_pekerjaan' => 'nullable|date',
        ]);
        $guestLand = \App\Models\GuestLand::find($id);

        if (isset($validated['petugas'])) {
            if (!is_Null($validated['petugas']) && $guestLand->status_proses == 0) {
                $guestLand->status_proses = 1;
                $guestLand->judul_status_proses = "Pemilihan Petugas";
            }
            $guestLand->user_id = $validated['petugas'];
        }

        // dd($status_label);
        $guestLand->nama_pemilik = $validated['nama_pemilik'];
        $guestLand->nomor_sertifikat = $validated['nomor_sertifikat'];
        $guestLand->nib = $validated['nib'];
        $guestLand->village_id = $validated['desa'];
        $guestLand->nomor_telpon = $validated['nomor_telpon'];
        $guestLand->nomor_hak = $validated['nomor_hak'];
        $guestLand->batas_waktu_proses = $validated['batas_waktu_pekerjaan'] ?? now()->format('Y-m-d');
        $guestLand->created_at = now();
        $guestLand->save();

        if ($guestLand->status_proses > 1) {
            \App\Models\StatusPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'judul_pekerjaan' => "Perubahan Data",
                'status_pekerjaan' => $guestLand->status_proses,
                'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'] ?? now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            \App\Models\StatusPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'judul_pekerjaan' => $guestLand->judul_status_proses,
                'status_pekerjaan' => $guestLand->status_proses,
                'batas_waktu_pekerjaan' => $validated['batas_waktu_pekerjaan'] ?? now()->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        

        session(['success' => 'Berhasil Mengubah Data Pemohon']);

        return redirect()->route('adminGuestLand');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guestLand = \App\Models\GuestLand::find($id);
        foreach ($guestLand->statusPekerjaans as $statusPekerjaan) {
            $statusPekerjaan->delete();
        }
        foreach ($guestLand->buktiPekerjaans as $buktiPekerjaan) {
            $buktiPekerjaan->delete();
        }
        $guestLand->delete();
        session(['success' => 'Berhasil Menghapus Data Pemohon']);
        return back();
    }
}
