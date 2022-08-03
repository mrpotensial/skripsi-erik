<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Nette\Schema\Expect;

class PemilihanPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\Models\User::where('level', '=', '2')->get();
        // dd($users[0]->guestLands->status_proses);
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
                Arr::except($total_pekerjaans, $index);
            }
        }
        // dd($users);
        $guestLands = \App\Models\GuestLand::orderby('id', 'ASC')->where('status_proses', '=', 0)->get();
        // dd($guestLands);

        // dd(\Carbon\Carbon::now()->addDays(-6)->format('Y-m-d'));

        return view('pages.admin.proses-pekerjaan.pemilihan-petugas.index')->with(compact('guestLands', 'users', 'total_pekerjaans'));
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
        $guestLand = \App\Models\GuestLand::find($id);
        $petugas = \App\Models\User::where('level', '=', '1')->get();
        return view('pages.admin.proses-pekerjaan.pemilihan-petugas.edit')->with(compact('guestLand', 'petugas'));
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
        // $date = now();
        // $batas_waktu = date('Y-m-d', strtotime($date . ' + 14 days'));
        // $data_pemohon->batas_waktu_proses = \Carbon\Carbon::now()->addDays(14);
        // $data_pemohon->save();
        // dd($request->all());
        $validated = $request->validate([
            'petugas' => 'required|numeric',
            // 'batas_waktu_pekerjaan' => 'required|date',
        ]);
        // dd($request->all());
        // dd($validated);

        $guestLand = \App\Models\GuestLand::find($id);
        $guestLand->user_id = $validated['petugas'];
        $guestLand->status_proses = ($guestLand->status_proses + 1);
        $guestLand->judul_status_proses = "Pemilihan Petugas";
        $guestLand->batas_waktu_proses = \Carbon\Carbon::now()->addDays(14);

        $guestLand->save();

        // dd($guestLand);

        $status_pekerjaan = \App\Models\StatusPekerjaan::create([
            'guest_land_id' => $guestLand->id,
            'judul_pekerjaan' => $guestLand->judul_status_proses,
            'status_pekerjaan' => $guestLand->status_proses,
            'batas_waktu_pekerjaan' => \Carbon\Carbon::now()->addDays(14),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // session(['success' => 'Berhasil Menambahkan Petugas']);
        return redirect()->back()->with('success', 'Berhasil Menambahkan Petugas');
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
