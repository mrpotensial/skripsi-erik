<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request as FacadesRequest;
use PharIo\Manifest\Url;

use function PHPUnit\Framework\isNull;

class GuestLandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        // dd($type);
        // $guestLands = \App\Models\GuestLand::where('status_pengerjaan', '=', '0')->get();
        if ($type == 'proses') {
            $guestLands = \App\Models\GuestLand::where('status_proses', '<', 5)->where('status_proses', '>', 0)->get();
        } elseif ($type == 'selesai') {
            $guestLands = \App\Models\GuestLand::where('status_proses', '=', 5)->get();
        } else {
            abort(404);
        }


        $users = \App\Models\User::where('level', '=', '2')->get();

        $total_pekerjaans = [];
        foreach ($users as $index => $user) {
            $count = 0;
            foreach ($user->guestLands as $guestLand) {
                // dd($guestLand->status_proses);
                if ($guestLand->status_proses < 5) {
                    $count++;
                }
            }
            $total_pekerjaans[$index] = $count;
            if ($count == 25) {
                Arr::except($users, $index);
                Arr::except(
                    $total_pekerjaans,
                    $index
                );
            }
        }
        // dd($users);
        return view('pages.admin.guest-land.index')->with(compact('guestLands', 'users', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $desa = \App\Models\Village::get();
        $users = \App\Models\User::where('level', '=', '2')->get();

        $total_pekerjaans = [];
        foreach ($users as $index => $user) {
            $count = 0;
            foreach ($user->guestLands as $guestLand) {
                // dd($guestLand->status_proses);
                if ($guestLand->status_proses < 5) {
                    $count++;
                }
            }
            $total_pekerjaans[$index] = $count;
            if ($count == 25) {
                Arr::except($users, $index);
                Arr::except(
                    $total_pekerjaans,
                    $index
                );
            }
        }
        $petugas = $users;
        return view('pages.admin.guest-land.create')->with(compact('desa', 'petugas', 'total_pekerjaans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'nama_pemilik' => 'required|string|max:255',
                'nomor_sertifikat' => 'required|numeric|unique:guest_lands',
                'nib' => 'required|numeric|unique:guest_lands',
                'desa' => 'required|numeric',
                'nomor_telpon' => 'required|numeric|min:10',
                'nomor_hak' => 'nullable|numeric',
                'petugas' => 'nullable|numeric|exists:users,id',
            ],
            [
                'nama_pemilik.required' => 'Nama pemilik tidak boleh kosong',
                'nama_pemilik.string' => 'Nama pemilik harus berupa string',
                'nama_pemilik.max' => 'Nama pemilik maksimal 255 karakter',
                'nomor_sertifikat.required' => 'Nomor sertifikat tidak boleh kosong',
                'nomor_sertifikat.numeric' => 'Nomor sertifikat harus berupa angka',
                'nomor_sertifikat.unique' => 'Nomor sertifikat sudah terdaftar',
                'nib.required' => 'NIB tidak boleh kosong',
                'nib.numeric' => 'NIB harus berupa angka',
                'nib.unique' => 'NIB sudah terdaftar',
                'desa.required' => 'Desa tidak boleh kosong',
                'desa.numeric' => 'Desa harus berupa angka',
                'nomor_telpon.required' => 'Nomor telepon tidak boleh kosong',
                'nomor_telpon.numeric' => 'Nomor telepon harus berupa angka',
                'nomor_telpon.min' => 'Nomor telepon minimal 10 digit',
                'nomor_hak.numeric' => 'Nomor hak berupa angka',
                'petugas.numeric' => 'Petugas tidak terdaftar',
                'petugas.exists' => 'Petugas tidak terdaftar',
            ]
        )->validate();

        $status = 0;
        $status_label = "Pendaftaran Berkas";
        $batas_waktu = now();
        if ($validated['petugas'] !== null) {
            $status = 1;
            $status_label = "Pemilihan Petugas";
            $batas_waktu = \Carbon\Carbon::now()->addDays(14);
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
            'batas_waktu_proses' => $batas_waktu,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // dd($guestLand);

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'status_pekerjaan' => $status,
            'judul_pekerjaan' => $status_label,
            'batas_waktu_pekerjaan' => $batas_waktu,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($status > 0) {
            \App\Models\StatusPekerjaan::create([
                'guest_land_id' => $guestLand->id,
                'judul_pekerjaan' => $status_label,
                'status_pekerjaan' => $status,
                'batas_waktu_pekerjaan' => $batas_waktu,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            session(['success' => 'Berhasil Menambahkan Data Pemohon']);
            return redirect()->route('adminGuestLand', ['type' => 'proses']);
        }
        session(['success' => 'Berhasil Menambahkan Data Pemohon']);
        return redirect()->route('adminPemilihanPetugas');
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
        // $validated = $request->validate([
        //     'nama_pemilik' => 'required|string|max:255',
        //     'nomor_sertifikat' => 'required|numeric',
        //     'nib' => 'required|numeric',
        //     'desa' => 'required|string|max:255',
        //     'nomor_telpon' => 'required|numeric|min:10',
        //     'nomor_hak' => 'nullable|numeric|min:10',
        //     // 'petugas' => 'nullable|numeric',
        //     // 'batas_waktu_pekerjaan' => 'nullable|date',
        // ]);

        Validator::make($request->all(), [
            'nomor_sertifikat' => 'sometimes|required|numeric|unique:guest_lands,nomor_sertifikat,' . $id,
            'nib' => 'sometimes|required|numeric|unique:guest_lands,nib,' . $id,
            'nomor_telpon' => 'required|numeric|min:10',
            'nomor_hak' => 'nullable|numeric',
        ], [
            'nomor_sertifikat.required' => 'Nomor sertifikat tidak boleh kosong',
            'nomor_sertifikat.numeric' => 'Nomor sertifikat harus berupa angka',
            'nomor_sertifikat.unique' => 'Nomor sertifikat sudah terdaftar',
            'nib.required' => 'NIB tidak boleh kosong',
            'nib.unique' => 'NIB sudah terdaftar',
            'nib.numeric' => 'NIB harus berupa angka',
            'nomor_telpon.required' => 'Nomor telepon tidak boleh kosong',
            'nomor_telpon.numeric' => 'Nomor telepon harus berupa angka',
            'nomor_telpon.min' => 'Nomor telepon minimal 10 digit',
            'nomor_hak.numeric' => 'Nomor hak berupa angka',
        ])->validate();

        $guestLand = \App\Models\GuestLand::find($id);

        // if (isset($validated['petugas'])) {
        //     if (!is_Null($validated['petugas']) && $guestLand->status_proses == 0) {
        //         $guestLand->status_proses = 1;
        //         $guestLand->judul_status_proses = "Pemilihan Petugas";
        //     }
        //     $guestLand->user_id = $validated['petugas'];
        // }

        // dd($status_label);
        $guestLand->nama_pemilik = $request['nama_pemilik'];
        $guestLand->nomor_sertifikat = $request['nomor_sertifikat'];
        $guestLand->nib = $request['nib'];
        $guestLand->village_id = $request['desa'];
        $guestLand->nomor_telpon = $request['nomor_telpon'];
        $guestLand->nomor_hak = $request['nomor_hak'];
        // $guestLand->batas_waktu_proses = $validated['batas_waktu_pekerjaan'];
        $guestLand->created_at = now();
        $guestLand->save();

        \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'judul_pekerjaan' => "Perubahan Data Masyarakat",
            'status_pekerjaan' => $guestLand->status_proses,
            'batas_waktu_pekerjaan' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['success' => 'Berhasil Mengubah Data Pemohon']);

        return redirect()->route('adminGuestLand', ['type' => 'proses']);
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
        $title = $guestLand->nama_pemilik;
        $status = $guestLand->status_proses;
        foreach ($guestLand->statusPekerjaans as $statusPekerjaan) {
            $statusPekerjaan->delete();
        }
        foreach ($guestLand->buktiPekerjaans as $buktiPekerjaan) {
            $buktiPekerjaan->delete();
        }
        $guestLand->delete();
        // session(['success' => 'Berhasil Menghapus Data Pemohon ' . $title]);
        if ($status = 0) {
            return redirect()->route('adminPemilihanPetugas')->with('success', 'Berhasil Menghapus Data Pemohon ' . $title);
        } elseif ($status > 1 && $status < 5) {
            return redirect()->route('adminGuestLand', ['proses'])->with('success', 'Berhasil Menghapus Data Pemohon ' . $title);
        } else {
            return redirect()->route('adminGuestLand', ['selesai'])->with('success', 'Berhasil Menghapus Data Pemohon ' . $title);
        }
    }
}
