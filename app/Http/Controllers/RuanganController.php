<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;   // Pastikan nama model ruangan Anda benar
use App\Models\Branch; // Pastikan nama model cabang Anda benar

class RuanganController extends Controller
{
    /**
     * Menampilkan halaman daftar ruangan
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil data ruangan, gabung dengan pencarian jika ada
        $rooms = Room::with('branch') // Memanggil relasi cabang agar tidak N+1 query problem
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10);

        // Ambil data cabang untuk dimasukkan ke opsi dropdown di modal Tambah/Edit
        $branches = Branch::all();

        return view('master-data.ruangan', compact('rooms', 'branches'));
    }

    /**
     * Menyimpan data ruangan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);

        Room::create([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Memperbarui data ruangan
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $room = Room::findOrFail($id);

        $room->update([
            'name' => $request->name,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui!');
    }

    /**
     * Menghapus data ruangan
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        // Opsional: Anda bisa menambahkan pengecekan di sini
        // "Apakah ada aset yang masih menggunakan ruangan ini?" sebelum menghapus.

        $room->delete();

        return redirect()->back()->with('success', 'Ruangan berhasil dihapus!');
    }
}
