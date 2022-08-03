<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        // dd('hello');
        session()->put('token', $request->_token);
        Validator::make(
            $request->all(),
            [
                'keynum' => 'required|numeric',
            ],
            [
                'keynum.required' => 'Nomor Pencarian tidak boleh kosong',
                'keynum.numeric' => 'Nomor Pencarian harus berupa angka',
            ]
        )->validate();

        $guestLand = \App\Models\GuestLand::where('nomor_sertifikat', '=', $request['keynum'])->first();
        if (is_null($guestLand)) {
            $guestLand = \App\Models\GuestLand::where('nib', '=', $request['keynum'])->first();
        }

        if (isset($guestLand)) {
            $id = Crypt::encryptString($guestLand->nomor_sertifikat);
            return redirect()->route('SearchShow', ['id' => $id, 'token' => $request->_token]);
        }
        // dd($guestLand);
        return redirect()->route('welcome')->withErrors('Nomor Pencarian tidak ditemukan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token, $id)
    {
        // dd($id);
        try {
            $id = Crypt::decryptString($id);
        } catch (DecryptException $e) {
            return back()
                ->withErrors("Data Pemohon tidak ditemukan");
        }
        // dd($id);
        if (!is_null(session('token')) && $token == session('token')) {
            session()->forget('token');
            $guestLand = \App\Models\GuestLand::firstWhere('nomor_sertifikat', '=', $id);
            return view('search.show')->with(compact('guestLand'));
        }
        return redirect()->route('welcome');
        // $items =  \App\Models\guestLand::find($id)->first();
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
