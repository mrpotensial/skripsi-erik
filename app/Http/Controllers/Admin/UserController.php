<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($select)
    {
        switch ($select) {
            case 'all':
                $users = \App\Models\User::get();
                break;

            case 'admin':
                $users = \App\Models\User::where('level', '=', '0')->get();
                break;

            case 'petugas':
                $users = \App\Models\User::where('level', '=', '1')->get();
                break;

            default:
                abort(404);;
                break;
        }
        return view('pages.admin.user.index')->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'level' => ['required'],
        ]);

        \Illuminate\Support\Facades\DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
            'remember_token' => \Illuminate\Support\Str::random(10),
            'level' => $request->level,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session(['success' => 'Berhasil Menambahkan User']);
        return back();
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
        $user = \App\Models\User::find($id);
        return view('pages.admin.user.edit')->with(compact('user'));
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'level' => ['required'],
        ]);
        \Illuminate\Support\Facades\DB::table('users')->where('id', '=', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'updated_at' => now(),
        ]);

        session(['success' => 'Berhasil Mengubah User']);
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $type)
    {
        if ($type == 'reset') {
            \Illuminate\Support\Facades\DB::table('users')->where('id', '=', $id)->update([
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'updated_at' => now(),
            ]);
            session(['success' => 'Berhasil Me-Reset Password User']);
            return back();
        } else {
            \App\Models\User::find($id)->delete();
            session(['success' => 'Berhasil Menghapus User']);
            return back();
        }
    }
}
