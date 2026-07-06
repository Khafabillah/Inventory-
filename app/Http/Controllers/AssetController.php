<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index(Request $request)
    {
        // 1. Inisialisasi query dasar beserta relasi tabel terkait
        $query = Asset::with(['room.branch', 'category'])->latest();

        // 2. Logika pencarian berdasarkan nama aset atau kode aset
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%");
            });
        }

        // 3. Logika filter berdasarkan kode cabang penempatan
        if ($request->filled('branch') && $request->branch !== 'Semua') {
            $branch = $request->branch;
            $query->whereHas('room.branch', function($q) use ($branch) {
                $q->where('code', $branch);
            });
        }

        // 4. Eksekusi query dengan pagination dan pertahankan parameter di URL
        $assets = $query->paginate(10)->withQueryString();

        // Mengambil data pendukung untuk kebutuhan opsi dropdown pada form
        $rooms = Room::with('branch')->get();
        $categories = Category::all();

        return view('manajemen-aset', compact('assets', 'rooms', 'categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan form untuk memastikan pemenuhan kriteria data
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'room_id'     => 'required|exists:rooms,id',
            'condition'   => 'required|in:Baik,Kurang Baik,Rusak',
        ]);

        // 2. Pembuatan kode aset otomatis berdasarkan kode cabang penempatan
        $room = Room::with('branch')->find($validated['room_id']);
        $branchCode = $room->branch->code ?? 'UNK';

        // Menghitung jumlah aset yang sudah ada di cabang terkait untuk menentukan nomor urut
        $totalAsetCabang = Asset::whereHas('room', function($q) use ($room) {
            $q->where('branch_id', $room->branch_id);
        })->count();

        $seq = str_pad($totalAsetCabang + 1, 3, '0', STR_PAD_LEFT);
        $validated['asset_code'] = "{$branchCode}-{$seq}";

        // 3. Menyimpan entitas data baru ke dalam database
        Asset::create($validated);

        // 4. Mengembalikan pengguna ke halaman sebelumnya dengan membawa indikator sukses
        return back()->with('success', 'Aset baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi data yang diubah
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'room_id'     => 'required|exists:rooms,id',
            'condition'   => 'required|in:Baik,Kurang Baik,Rusak',
        ]);

        // 2. Cari data aset berdasarkan ID
        $asset = Asset::findOrFail($id);

        // 3. Eksekusi pembaruan data ke database
        // Catatan: asset_code tidak diubah karena bersifat permanen sebagai identitas unik unit
        $asset->update($validated);

        // 4. Kembali dengan pesan sukses
        return back()->with('success', 'Data aset berhasil diperbarui!');
    }
}

