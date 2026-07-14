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
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('asset_code', 'like', "%{$search}%");
            });
        }

        // 3. Logika filter berdasarkan kode cabang penempatan
        if ($request->filled('branch') && $request->branch !== 'Semua') {
            $branch = $request->branch;
            $query->whereHas('room.branch', function ($q) use ($branch) {
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
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'room_id' => 'required|exists:rooms,id',
            'condition' => 'required|in:Baik,Kurang Baik,Rusak',
        ]);

        // 2. Pembuatan kode aset otomatis berdasarkan kode cabang penempatan
        $room = Room::with('branch')->find($validated['room_id']);
        $branchCode = $room->branch->code ?? 'UNK';

        // CARI KODE TERAKHIR DI CABANG INI
        // Menggunakan where('asset_code', 'like', $branchCode . '-%') agar hanya mencari di cabang terkait
        $lastAsset = Asset::where('asset_code', 'like', $branchCode . '-%')
            ->orderBy('asset_code', 'desc')
            ->first();

        if ($lastAsset) {
            // Pecah string "WLD-061" menjadi array ["WLD", "061"]
            $parts = explode('-', $lastAsset->asset_code);
            // Ambil bagian terakhir dan konversi ke integer
            $lastSeq = (int) end($parts);
            $nextSeq = $lastSeq + 1;
        } else {
            $nextSeq = 1;
        }

        $seq = str_pad($nextSeq, 3, '0', STR_PAD_LEFT);
        $validated['asset_code'] = "{$branchCode}-{$seq}";

        // 3. Menyimpan entitas data baru ke dalam database (Ditampung di $asset agar ID-nya bisa diambil)
        $asset = Asset::create($validated);

        // --- MENCATAT LOG TAMBAH ---
        $roomName = $room ? $room->name . ' (' . ($room->branch->code ?? '') . ')' : 'Unknown';
        \App\Models\MutationLog::create([
            'asset_id' => $asset->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'new_room_id' => $request->room_id,
            'description' => "Menambahkan aset baru: {$asset->name} ({$asset->asset_code}) ke {$roomName}",
            'mutation_date' => now(),
            'action' => 'Tambah',
        ]);

        // 4. Mengembalikan pengguna ke halaman sebelumnya dengan membawa indikator sukses
        return back()->with('success', 'Aset baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi data yang diubah
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'room_id' => 'required|exists:rooms,id',
            'condition' => 'required|in:Baik,Kurang Baik,Rusak',
        ]);

        // 2. Cari data aset berdasarkan ID
        $asset = Asset::findOrFail($id);

        // 3. Eksekusi pembaruan data ke database
        $asset->update($validated);

        // --- MENCATAT LOG EDIT ---
        \App\Models\MutationLog::create([
            'asset_id' => $asset->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'description' => "Memperbarui informasi aset: {$asset->name}. Kondisi diset menjadi {$request->condition}",
            'mutation_date' => now(),
            'action' => 'Edit',
        ]);

        // 4. Kembali dengan pesan sukses
        return back()->with('success', 'Data aset berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        // --- MENCATAT LOG HAPUS SEBELUM ASET BENAR-BENAR HILANG ---
        \App\Models\MutationLog::create([
            'asset_id' => null, // Null karena aset ini sebentar lagi musnah dari database
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'description' => "Menghapus aset: {$asset->name} ({$asset->asset_code}) secara permanen.",
            'mutation_date' => now(),
            'action' => 'Hapus',
        ]);

        // Eksekusi hapus
        $asset->delete();

        return back()->with('success', 'Data aset berhasil dihapus secara permanen!');
    }

    public function mutasi(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'keterangan' => 'required|string',
        ]);

        // Ambil data aset lengkap dengan relasi ruangan untuk nama otomatis
        $asset = Asset::with('room.branch')->findOrFail($id);

        // 2. Simpan Ruangan Lama Sebelum Diubah
        $oldRoomId = $asset->room_id;
        $oldRoomName = $asset->room ? $asset->room->name . ' (' . ($asset->room->branch->code ?? '') . ')' : 'Ruangan Lama';

        // 3. Update Ruangan Aset ke Ruangan Baru
        $asset->update([
            'room_id' => $request->room_id,
        ]);

        // Ambil data ruangan baru untuk dirangkai kalimatnya
        $newRoom = Room::with('branch')->find($request->room_id);
        $newRoomName = $newRoom ? $newRoom->name . ' (' . ($newRoom->branch->code ?? '') . ')' : 'Ruangan Baru';

        // --- MENCATAT RIWAYAT MUTASI DENGAN KALIMAT OTOMATIS ---
        $deskripsiOtomatis = "Mutasi {$asset->name} dari {$oldRoomName} ke {$newRoomName}. Alasan: {$request->keterangan}";

        \App\Models\MutationLog::create([
            'asset_id' => $asset->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'old_room_id' => $oldRoomId,
            'new_room_id' => $request->room_id,
            'description' => $deskripsiOtomatis,
            'mutation_date' => now(),
            'action' => 'Mutasi',
        ]);

        return back()->with('success', 'Aset berhasil dimutasi dan riwayat telah dicatat!');
    }
}
