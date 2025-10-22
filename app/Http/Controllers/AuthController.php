<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nama' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        // Coba login dengan nama terlebih dahulu
        $attempted = Auth::attempt([
            'nama' => $credentials['nama'],
            'password' => $credentials['password'],
        ], $remember);

        // Jika gagal, coba fallback pakai email
        if (!$attempted) {
            $attempted = Auth::attempt([
                'email' => $credentials['nama'],
                'password' => $credentials['password'],
            ], $remember);
        }

        if ($attempted) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'nama' => 'Nama atau password salah.',
        ])->onlyInput('nama');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
