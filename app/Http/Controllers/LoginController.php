<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    /**
     * Menampilkan halaman/view login.
     */
    public function showLoginForm(): View
    {

        return view('login');
    }

    /**
     * Menangani upaya autentikasi (proses login).
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        // 2. Coba lakukan login
        // 'name' adalah nama kolom di tabel 'users' Anda
        if (Auth::attempt(['name' => $credentials['name'], 'password' => $credentials['password']])) {

            // 3a. Jika berhasil, regenerate session
            $request->session()->regenerate();

            // Arahkan ke halaman 'dashboard'
            return redirect()->intended('/');
        }

        // 3b. Jika gagal, kembalikan ke halaman login
        return back()->withErrors([
            'name' => 'name atau Password yang Anda masukkan salah.',
        ])->onlyInput('name'); // Kembalikan input 'username' saja
    }

    /**
     * Menangani proses logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Arahkan kembali ke halaman login
    }
}
