<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Pastikan controller di-import
use App\Models\Asset;
use App\Models\Category;
use App\Models\Room;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AssetController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    $cabang = request('cabang', 'Semua');

    // 1. Query Aset Utama
    $assetQuery = Asset::query();
    if ($cabang !== 'Semua') {
        $assetQuery->whereHas('room.branch', function ($query) use ($cabang) {
            $query->where('code', $cabang)->orWhere('name', $cabang);
        });
    }

    // 2. Logika "Bunglon" untuk Bar Chart
    $barLabels = [];
    $barCounts = [];
    $chartTitle = '';

    if ($cabang === 'Semua') {
        // Jika "Semua", tampilkan per Cabang
        $chartTitle = 'Distribusi Aset per Cabang';
        $branches = Branch::all();
        foreach ($branches as $b) {
            $barLabels[] = $b->code ?? $b->name;
            $barCounts[] = Asset::whereHas('room', function ($q) use ($b) {
                $q->where('branch_id', $b->id);
            })->count();
        }
    } else {
        // Jika Cabang Spesifik, tampilkan per Ruangan
        $chartTitle = 'Distribusi Aset per Ruangan';
        $ruanganData = Room::whereHas('branch', function ($query) use ($cabang) {
            $query->where('code', $cabang)->orWhere('name', $cabang);
        })
            ->withCount('assets')
            ->get();

        $barLabels = $ruanganData->pluck('name')->toArray();
        $barCounts = $ruanganData->pluck('assets_count')->toArray();
    }

    // 3. Eksekusi Data Statistik
    $stats = [
        'totalAset' => (clone $assetQuery)->count(),
        'totalKategori' => Category::count(),
        'totalRuangan' => Room::whereHas('branch', function ($q) use ($cabang) {
            if ($cabang !== 'Semua') {
                $q->where('code', $cabang)->orWhere('name', $cabang);
            }
        })->count(),
        'totalMutasi' => DB::table('mutation_logs')->count(),
        'kondisiBaik' => (clone $assetQuery)->where('condition', 'Baik')->count(),
        'asetRusak' => (clone $assetQuery)->whereIn('condition', ['Kurang Baik', 'Rusak'])->count(),
    ];

    $kondisiChart = [
        'Baik' => (clone $assetQuery)->where('condition', 'Baik')->count(),
        'Kurang Baik' => (clone $assetQuery)->where('condition', 'Kurang Baik')->count(),
        'Rusak' => (clone $assetQuery)->where('condition', 'Rusak')->count(),
    ];

    return view('dashboard', compact('stats', 'kondisiChart', 'barLabels', 'barCounts', 'chartTitle'));
})
    ->name('dashboard')
    ->middleware('auth');

// Rute untuk menampilkan halaman dan tabel
Route::get('/manajemen-aset', [AssetController::class, 'index'])->name('manajemen-aset')->middleware('auth');

// Rute untuk menangkap data dari Form (Tombol Simpan)
Route::post('/manajemen-aset', [AssetController::class, 'store'])->name('manajemen-aset.store')->middleware('auth');
Route::get('/', function () {
    return view('auth.login');
});


// Rute Login (POST)
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute Internal untuk Mencetak QR Code
Route::get('/aset/qr/{code}', function ($code) {
    // Tautan yang akan terbuka jika QR di-scan pakai HP (Membuka web Anda & mencari kode tersebut)
    $url = route('manajemen-aset') . '?search=' . $code;

    // Generate QR Code SVG berukuran 150x150
    return response(QrCode::size(150)->margin(1)->generate($url))
            ->header('Content-Type', 'image/svg+xml');
});

// Rute untuk memproses update data aset
Route::put('/manajemen-aset/{id}', [AssetController::class, 'update'])->name('manajemen-aset.update');
Route::post('/manajemen-aset/{id}/mutasi', [AssetController::class, 'mutasi'])->name('manajemen-aset.mutasi');
Route::delete('/manajemen-aset/{id}', [AssetController::class, 'destroy'])->name('manajemen-aset.destroy');


// Halaman Utama Master Data Akun
Route::get('/master-data/akun', [UserController::class, 'index'])->name('master.akun');

// 3 Route ini yang diminta oleh Laravel untuk form di Modal
Route::post('/master-data/akun', [UserController::class, 'store'])->name('master.akun.store');
Route::put('/master-data/akun/{id}', [UserController::class, 'update'])->name('master.akun.update');
Route::delete('/master-data/akun/{id}', [UserController::class, 'destroy'])->name('master.akun.destroy');

// Route Master Data - Ruangan
Route::get('/master-data/ruangan', [RuanganController::class, 'index'])->name('master.ruangan');
Route::post('/master-data/ruangan', [RuanganController::class, 'store'])->name('master.ruangan.store');
Route::put('/master-data/ruangan/{id}', [RuanganController::class, 'update']);
Route::delete('/master-data/ruangan/{id}', [RuanganController::class, 'destroy']);
