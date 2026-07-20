<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\DB;
use App\Models\Asset;
use App\Models\Category;
use App\Models\Room;
use App\Models\Branch;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\LogController;

// --- RUTE PUBLIK ---
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

// --- RUTE TERLINDUNGI (WAJIB LOGIN) ---
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        $cabang = request('cabang', 'Semua');
        $assetQuery = Asset::query();
        if ($cabang !== 'Semua') {
            $assetQuery->whereHas('room.branch', function ($query) use ($cabang) {
                $query->where('code', $cabang)->orWhere('name', $cabang);
            });
        }

        $barLabels = [];
        $barCounts = [];
        $chartTitle = '';
        if ($cabang === 'Semua') {
            $chartTitle = 'Distribusi Aset per Cabang';
            foreach (Branch::all() as $b) {
                $barLabels[] = $b->code ?? $b->name;
                $barCounts[] = Asset::whereHas('room', fn($q) => $q->where('branch_id', $b->id))->count();
            }
        } else {
            $chartTitle = 'Distribusi Aset per Ruangan';
            $ruanganData = Room::whereHas('branch', fn($q) => $q->where('code', $cabang)->orWhere('name', $cabang))->withCount('assets')->get();
            $barLabels = $ruanganData->pluck('name')->toArray();
            $barCounts = $ruanganData->pluck('assets_count')->toArray();
        }

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

        // INI VARIABEL YANG HILANG DAN BIKIN ERROR
        $kondisiChart = [
            'Baik' => (clone $assetQuery)->where('condition', 'Baik')->count(),
            'Kurang Baik' => (clone $assetQuery)->where('condition', 'Kurang Baik')->count(),
            'Rusak' => (clone $assetQuery)->where('condition', 'Rusak')->count(),
        ];

        // KONDISICHART SUDAH DIMASUKKAN KEMBALI KE SINI
        return view('dashboard', compact('stats', 'kondisiChart', 'barLabels', 'barCounts', 'chartTitle'));
    })->name('dashboard');

    // Manajemen Aset
    Route::get('/manajemen-aset', [AssetController::class, 'index'])->name('manajemen-aset');
    Route::post('/manajemen-aset', [AssetController::class, 'store'])->name('manajemen-aset.store');
    Route::put('/manajemen-aset/{id}', [AssetController::class, 'update'])->name('manajemen-aset.update');
    Route::post('/manajemen-aset/{id}/mutasi', [AssetController::class, 'mutasi'])->name('manajemen-aset.mutasi');
    Route::delete('/manajemen-aset/{id}', [AssetController::class, 'destroy'])->name('manajemen-aset.destroy');
    Route::get(
        '/aset/qr/{code}',
        fn($code) => response(
            // Ukuran dibesarkan jadi 250 agar tajam, dan HANYA generate $code saja
            QrCode::size(250)->margin(1)->generate($code),
        )->header('Content-Type', 'image/svg+xml'),
    );

    // Master Data - Akun
    Route::get('/master-data/akun', [UserController::class, 'index'])->name('master.akun');
    Route::post('/master-data/akun', [UserController::class, 'store'])->name('master.akun.store');
    Route::put('/master-data/akun/{id}', [UserController::class, 'update'])->name('master.akun.update');
    Route::delete('/master-data/akun/{id}', [UserController::class, 'destroy'])->name('master.akun.destroy');

    // Master Data - Ruangan
    Route::get('/master-data/ruangan', [RuanganController::class, 'index'])->name('master.ruangan');
    Route::post('/master-data/ruangan', [RuanganController::class, 'store'])->name('master.ruangan.store');
    Route::put('/master-data/ruangan/{id}', [RuanganController::class, 'update']);
    Route::delete('/master-data/ruangan/{id}', [RuanganController::class, 'destroy']);

    // Master Data - Kategori
    Route::get('/master-data/kategori', [CategoryController::class, 'index'])->name('master.kategori');
    Route::post('/master-data/kategori', [CategoryController::class, 'store'])->name('master.kategori.store');
    Route::put('/master-data/kategori/{id}', [CategoryController::class, 'update']);
    Route::delete('/master-data/kategori/{id}', [CategoryController::class, 'destroy']);

    // Log Aktivitas
    Route::get('/log-aktivitas', [LogController::class, 'index'])->name('log-aktivitas');

    // Scanner (Khusus Mobile)
    Route::get('/scanner', function () {
        return view('scanner');
    })->name('scanner');
});
