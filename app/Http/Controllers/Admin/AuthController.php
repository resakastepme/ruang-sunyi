<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.index');
        }

        return view('admin.login');
    }

    /**
     * Proses percobaan login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.index'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau kata sandi tidak cocok.']);
    }

    /**
     * Keluar sesi admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
