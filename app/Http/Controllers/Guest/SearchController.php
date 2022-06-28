<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        // dd();
        session()->put('token', $request->_token);
        $validated = $request->validate([
            'keynum' => 'required|numeric',
        ]);
        $guestLand = \App\Models\GuestLand::where('nomor_sertifikat', '=', $request['keynum'])->first();
        if (is_null($guestLand)) {
            $guestLand = \App\Models\GuestLand::where('nib', '=', $request['keynum'])->first();
        }
        if (isset($guestLand)) {
            return redirect()->route('SearchShow', ['id' => $guestLand->id, 'token' => $request->_token]);
        }
        return redirect()->route('welcome');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token, $id)
    {
        // dd(session('token'));
        if (!is_null(session('token')) && $token == session('token')) {
            session()->forget('token');
            $guestLand = \App\Models\GuestLand::find($id);
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
