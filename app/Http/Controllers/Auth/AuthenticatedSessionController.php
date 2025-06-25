<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     * Mengarahkan ke view 'layouts.guest' yang berisi desain custom Anda.
     */
    public function create(): View
    {
        return view('layouts.guest');
    }

    /**
     * Menangani permintaan otentikasi (proses login).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Coba lakukan login dengan guard 'admins' menggunakan username dan password.
        if (! Auth::guard('admins')->attempt($request->only('username', 'password'), $request->boolean('remember'))) {
            
            // JIKA GAGAL: Redirect kembali ke halaman login dengan pesan error untuk Toastify.js.
            return redirect()->route('login')
                         ->with('error', 'Username atau Password salah!');
        }

        // JIKA BERHASIL: Lanjutkan ke baris di bawah ini.
        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard');
    }

    /**
     * Menghancurkan sesi otentikasi (proses logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        // === PERBAIKAN UTAMA ADA DI SINI ===
        // Secara eksplisit menyuruh Laravel untuk logout dari guard 'admins'.
        Auth::guard('admins')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
