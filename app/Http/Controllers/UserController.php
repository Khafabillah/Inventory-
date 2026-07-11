<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Fitur pencarian berdasarkan nama atau email
        $search = $request->search;

        $users = User::when($search, function($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->latest() // Mengurutkan dari akun terbaru
        ->paginate(10)
        ->withQueryString();

        // Melempar data ke view
        return view('master-data.akun', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        // Enkripsi password sebelum disimpan (Standar keamanan Laravel)
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return back()->with('success', 'Akun baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
        ]);

        // Cek jika user mengisi password baru (jika kosong, abaikan)
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return back()->with('success', 'Profil akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus permanen!');
    }
}
