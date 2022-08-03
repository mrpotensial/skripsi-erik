<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class PekerjaanKadaluarsaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guestLands = \App\Models\GuestLand::orderby('id', 'ASC')->where('status_proses', '=', 0)->get();
        // dd($guestLands);
        $result = [];
        foreach ($guestLands as $index => $guestLand) {
            $date1 = $guestLand->created_at->format('Y-m-d');
            $date2 = now()->addDays(-7)->format('Y-m-d');
            // dd($y1, $y2);
            if ($guestLand->batas_waktu_proses !== null) {
                Arr::except($guestLands, $index);
            }
            if ($date2 < $date1) {
                Arr::except($guestLands, $index);
            }
            // $result[] = $guestLand;
        }
        foreach ($guestLands as $index => $guestLand) {
            array_push($result, $guestLand);
        }
        // $guestLands = Arr::sort($guestLands);
        // dd($result);
        $guestLands = $result;
        return view('pages.admin.proses-pekerjaan.pekerjaan-kadaluarsa.index')->with(compact('guestLands',));
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
    public function update($id)
    {
        // dd($id);
        $guestLand = \App\Models\GuestLand::find($id);
        $guestLand->created_at = \Carbon\Carbon::now();
        $guestLand->save();

        return redirect()->back()->with('success', 'Pekerjaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        // dd(Auth::user()->level);
        if (Auth::user()->level == 0) {
            $guestLands = \App\Models\GuestLand::orderby('id', 'ASC')->where('status_proses', '=', 0)->get();
            // dd($guestLands);
            foreach ($guestLands as $index => $guestLand) {
                $date = $guestLand->created_at->format('Y-m-d');
                $now = \Carbon\Carbon::now()->addDays(-10)->format('Y-m-d');
                if ($date < $now) {
                    // Arr::except($guestLands, $index);
                    $guestLand->delete();
                }
            }
            // dd($guestLands);
            return redirect()->back()->with('success', 'Pekerjaan Kadaluarsa Berhasil Dihapus');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus data');
    }
}
