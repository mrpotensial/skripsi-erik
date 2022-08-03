<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // dd(Auth::user());
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // LoginRequest
    public function store(LoginRequest $request)
    {
        // dd($request->all());
        $request->authenticate();
        $request->session()->regenerate();
        // return redirect()->intended(RouteServiceProvider::HOME);
        // dd(Auth::user());
        if (Auth::user()->level == 0) {
            return redirect()->intended(RouteServiceProvider::ADMIN);
        } elseif (Auth::user()->level == 1) {
            return redirect()->intended(RouteServiceProvider::KOORDINATOR);
        } elseif (Auth::user()->level == 2) {
            return redirect()->intended(RouteServiceProvider::PETUGAS);
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
