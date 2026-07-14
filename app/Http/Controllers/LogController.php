<?php

namespace App\Http\Controllers;

use App\Models\MutationLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data log mutasi terbaru beserta relasi User dan Asset-nya (Eager Loading)
        $query = MutationLog::with(['user', 'asset', 'fromRoom', 'toRoom'])->latest();

        // 2. Logika Pencarian (Search) jika user mengetik di kolom pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan detail deskripsi log
                $q->where('description', 'like', "%{$search}%")
                  // Atau cari berdasarkan nama user yang melakukan aksi
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 3. Batasi data 10 per halaman (Pagination) dan pertahankan query string di URL
        $logs = $query->paginate(10)->withQueryString();

        // 4. Kirim data ke halaman view log-aktivitas.blade.php
        return view('log-aktivitas', compact('logs'));
    }
}
