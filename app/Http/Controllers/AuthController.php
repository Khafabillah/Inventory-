<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // BARIS AJAIB PEMBUAT KARCIS SESI PERMANEN:
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login berhasil',
                'user' => Auth::user()
            ], 200);
        }

        // 4. Jika gagal
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }
}
