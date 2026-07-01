<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LoginLog;

class AuthController extends Controller
{
    /**
     * Menangani proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Perekaman aktivitas login ke tabel login_logs
            LoginLog::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return response()->json([
                'message' => 'Login berhasil',
                'user' => Auth::user(),
            ], 200);
        }

        return response()->json([
            'message' => 'Email atau password salah',
        ], 401);
    }

    /**
     * Menangani proses logout pengguna.
     */
    public function logout(Request $request)
    {
        // 1. Keluar dari sesi autentikasi
        Auth::logout();

        // 2. Menghapus data sesi yang tersimpan
        $request->session()->invalidate();

        // 3. Membuat token CSRF baru untuk keamanan
        $request->session()->regenerateToken();

        // 4. Arahkan kembali ke halaman login
        return redirect('/login');
    }
}
