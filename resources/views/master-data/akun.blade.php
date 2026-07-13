    @extends('layouts.app')

    @section('content')
        {{-- ========================================================== --}}
        {{-- BAGIAN HEADER UMUM                                         --}}
        {{-- ========================================================== --}}
        <div class="font-inter flex flex-col mt-2 mb-6 px-1">
            <h2 class="text-xl font-bold text-[#006EC4] leading-tight">Master Data</h2>
            <p class="text-[13px] font-light text-[#6B7280] ml-1">Kelola Parameter Ruangan, Kategori Aset, dan Hak Akses
                Pengguna
            </p>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div id="alert-sukses"
                class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-6 text-sm font-medium transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pesan Error Validasi --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative mb-6 text-sm font-medium">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Navigasi Tab (Pills) --}}
        <div class="flex items-center justify-start gap-2 mb-6 px-1 overflow-x-auto scrollbar-hide font-inter">
            {{-- Tab Akun (Aktif) --}}
            <a href="{{ route('master.akun') }}"
                class="px-6 py-2 text-xs font-bold bg-[#D5E7FD] text-[#006EC4] rounded-full shadow-sm transition-transform active:scale-95">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Akun
                </div>
            </a>
            {{-- Tab Ruangan --}}
            <a href="{{ route('master.ruangan') }}"
                class="px-6 py-2 text-xs font-bold bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 rounded-full transition-colors active:scale-95">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Ruangan
                </div>
            </a>
            {{-- Tab Kategori --}}
            <button
                class="px-6 py-2 text-xs font-bold bg-white border border-gray-200 text-gray-500 hover:bg-gray-50 rounded-full transition-colors cursor-not-allowed">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Kategori
                </div>
            </button>
        </div>

        {{-- ========================================================== --}}
        {{-- TAMPILAN MOBILE (Layar Kecil)                              --}}
        {{-- ========================================================== --}}
        <div class="block lg:hidden px-4 mt-4">
            <form method="GET" action="{{ route('master.akun') }}">
                <div class="flex gap-3 mb-6 items-stretch h-[46px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                        class="flex-1 rounded-full border border-gray-200 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:border-blue-500" />
                    <button type="button" onclick="toggleModal('modalTambahAkun')"
                        class="cursor-pointer rounded-[1.5rem] bg-[#D5E7FD] flex flex-col items-center justify-center px-4 transition-colors hover:bg-blue-200">
                        <span class="text-base font-bold leading-none text-[#006EC4]">+</span>
                        <span class="text-[11px] font-bold text-[#006EC4] leading-none">Tambah</span>
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-2 gap-3 font-inter">
                @forelse ($users as $user)
                    <div
                        class="min-h-[140px] flex flex-col justify-between rounded-lg bg-white p-3 shadow-sm border border-gray-100 relative">
                        <div>
                            <div class="flex justify-between items-start gap-1">
                                <div class="overflow-hidden">
                                    <div class="text-sm font-bold text-black truncate">{{ $user->name }}</div>
                                    <div class="text-[10px] text-[#006EC4] mt-0.5 truncate">{{ $user->email }}</div>
                                </div>
                                <div class="relative">
                                    <button type="button" onclick="toggleDropdown('dropdown-{{ $user->id }}')"
                                        class="p-1 text-gray-400 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="1" />
                                            <circle cx="12" cy="5" r="1" />
                                            <circle cx="12" cy="19" r="1" />
                                        </svg>
                                    </button>
                                    <div id="dropdown-{{ $user->id }}"
                                        class="hidden absolute right-0 top-6 mt-1 w-32 bg-white rounded-lg shadow-lg border border-gray-100 z-50 overflow-hidden">
                                        <div class="py-1">
                                            {{-- Tombol Edit Mobile --}}
                                            <button type="button" data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                data-role="{{ $user->role }}"
                                                onclick="openEditUserModal(this); toggleDropdown('dropdown-{{ $user->id }}')"
                                                class="w-full text-left px-3 py-2 text-xs font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                    <path d="m15 5 4 4" />
                                                </svg>
                                                Edit
                                            </button>
                                            {{-- Tombol Hapus Mobile --}}
                                            <button type="button" data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                onclick="openDeleteUserModal(this); toggleDropdown('dropdown-{{ $user->id }}')"
                                                class="w-full text-left px-3 py-2 text-xs font-medium text-gray-600 hover:bg-red-50 hover:text-red-600 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center justify-center rounded-full px-2 py-0.5 text-[9px] font-bold bg-blue-100 text-blue-700">
                                    {{ $user->role ?? 'Staff' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-[10px] text-gray-400 mt-4 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum Login' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center text-sm text-gray-500 py-4">Data akun tidak ditemukan.</div>
                @endforelse
            </div>

            {{-- Pagination Mobile: Sembunyikan jika <= 10 --}}
            @if ($users->hasPages())
                <div class="mt-6 mb-4 custom-pagination">
                    {{ $users->links() }}
                </div>
            @else
                <div class="mt-4 mb-4 text-xs text-gray-400 text-center">
                    Menampilkan {{ $users->count() }} dari {{ $users->total() }} data akun
                </div>
            @endif
        </div>

        {{-- ========================================================== --}}
        {{-- TAMPILAN DESKTOP (Layar Besar)                             --}}
        {{-- ========================================================== --}}
        <div class="hidden lg:block">
            {{-- Form Pencarian dan Tombol Tambah --}}
            <form method="GET" action="{{ route('master.akun') }}"
                class="flex items-center justify-start mb-6 gap-4 font-inter">

                {{-- Container Pencarian --}}
                <div
                    class="flex items-center gap-2 rounded-full border border-[#D5E7FD] bg-white px-3 py-2 shadow-sm w-80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#006EC4]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search akun..."
                        class="w-full text-sm text-gray-700 placeholder:text-gray-400 bg-transparent focus:outline-none" />
                </div>

                {{-- Tombol Tambah dengan margin-left (ml-8) agar terlihat seimbang --}}
                <button type="button" onclick="toggleModal('modalTambahAkun')"
                    class="cursor-pointer ml-125 inline-flex items-center gap-2 text-sm font-bold text-[#006EC4] hover:text-blue-800 transition-all">
                    <span class="text-[#FFCD29] text-lg">+</span> Tambah Akun
                </button>
            </form>

            <div class="border border-gray-200 rounded-lg overflow-hidden bg-white shadow-sm font-inter">
                <table class="w-full text-sm text-center">
                    <thead class="bg-gray-50 text-gray-700 border-b border-gray-200 uppercase text-[11px] tracking-wider">
                        <tr>
                            <th class="py-4 font-bold text-gray-900 w-16">No</th>
                            <th class="py-4 font-bold text-gray-900 text-left pl-6">Nama Pengguna</th>
                            <th class="py-4 font-bold text-gray-900 text-left">Email</th>
                            <th class="py-4 font-bold text-gray-900">Role</th>
                            <th class="py-4 font-bold text-gray-900">Last Login</th>
                            <th class="py-4 font-bold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 divide-y divide-gray-100">
                        @forelse ($users as $index => $user)
                            <tr
                                class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50/50' }} hover:bg-blue-50/50 transition-colors">
                                <td class="py-4">{{ $users->firstItem() + $index }}</td>
                                <td class="py-4 text-left font-semibold text-gray-800 pl-6">{{ $user->name }}</td>
                                <td class="py-4 text-left">{{ $user->email }}</td>
                                <td class="py-4">
                                    <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-blue-100 text-blue-700">
                                        {{ $user->role ?? 'Staff' }}
                                    </span>
                                </td>
                                <td class="py-4 text-xs text-gray-500">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum Pernah' }}
                                </td>
                                <td class="py-4">
                                    <div class="flex justify-center gap-3 text-gray-500">
                                        {{-- Tombol Edit Desktop --}}
                                        <button type="button" title="Edit Profil" data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                            data-role="{{ $user->role }}" onclick="openEditUserModal(this)"
                                            class="cursor-pointer hover:text-blue-600 transition-colors focus:outline-none p-1 rounded hover:bg-blue-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                        </button>
                                        {{-- Tombol Hapus Desktop --}}
                                        <button type="button" title="Hapus Akun" data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}" onclick="openDeleteUserModal(this)"
                                            class="cursor-pointer hover:text-red-600 transition-colors focus:outline-none p-1 rounded hover:bg-red-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-gray-500">Data akun tidak tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination Desktop Menggunakan Laravel Links --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 custom-pagination">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- BAGIAN MODAL (TAMBAH, EDIT, HAPUS)                         --}}
        {{-- ========================================================== --}}

        {{-- MODAL TAMBAH AKUN --}}
        <x-modal id="modalTambahAkun" title="Tambah Akun Baru">
            <form action="{{ route('master.akun.store') ?? '#' }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                        placeholder="Masukkan nama lengkap..." />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                        placeholder="nama@email.com" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Role / Hak Akses</label>
                    <select name="role" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="Super Admin">Super Admin</option>
                        <option value="Store Manager">Store Manager</option>
                        <option value="Staff IT">Staff IT</option>
                        <option value="Staff Gudang">Staff Gudang</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                        placeholder="Minimal 8 karakter..." />
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t mt-4">
                    <button type="button" onclick="toggleModal('modalTambahAkun')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#006EC4] text-white rounded text-sm hover:bg-blue-700 transition-colors">Simpan
                        Akun</button>
                </div>
            </form>
        </x-modal>

        {{-- MODAL EDIT AKUN --}}
        <x-modal id="modalEditAkun" title="Edit Profil Akun">
            <form id="formEditAkun" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="edit_user_name" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Email</label>
                    <input type="email" name="email" id="edit_user_email" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500" />
                </div>
                <div>
                    <label class="block text-sm text-gray-600 mb-1">Role / Hak Akses</label>
                    <select name="role" id="edit_user_role" required
                        class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500">
                        <option value="Super Admin">Super Admin</option>
                        <option value="Store Manager">Store Manager</option>
                        <option value="Staff IT">Staff IT</option>
                        <option value="Staff Gudang">Staff Gudang</option>
                    </select>
                </div>
                <p class="text-[10px] text-gray-400">*Abaikan password jika tidak ingin mengubahnya</p>
                <div class="flex items-center justify-end gap-3 pt-4 border-t mt-4">
                    <button type="button" onclick="toggleModal('modalEditAkun')"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[#006EC4] text-white rounded text-sm hover:bg-blue-700">Simpan
                        Perubahan</button>
                </div>
            </form>
        </x-modal>

        {{-- MODAL HAPUS AKUN --}}
        <x-modal id="modalHapusAkun" title="Konfirmasi Hapus Akun">
            <form id="formHapusAkun" method="POST">
                @csrf
                @method('DELETE')
                <div class="py-4 text-center flex flex-col items-center">
                    <div class="bg-red-100 p-3 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Hapus Akun Ini?</h3>
                    <p class="text-sm text-gray-500">Anda akan menghapus akun <br><strong id="delete_user_name"
                            class="text-red-600"></strong></p>
                    <p class="text-[11px] text-gray-400 mt-2">Data yang dihapus tidak dapat dikembalikan.</p>
                </div>
                <div class="flex items-center justify-center gap-3 pt-4 border-t mt-2">
                    <button type="button" onclick="toggleModal('modalHapusAkun')"
                        class="px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded text-sm hover:bg-gray-200 transition-colors">Batal</button>
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white font-medium rounded text-sm hover:bg-red-700 transition-colors">Ya,
                        Hapus</button>
                </div>
            </form>
        </x-modal>

        {{-- SCRIPT JAVASCRIPT --}}
        <script>
            // Fungsi untuk mengisi data di Modal Edit Akun
            window.openEditUserModal = function(button) {
                try {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const email = button.getAttribute('data-email');
                    const role = button.getAttribute('data-role');

                    const form = document.getElementById('formEditAkun');
                    if (form) form.action = `/master-data/akun/${id}`;

                    document.getElementById('edit_user_name').value = name;
                    document.getElementById('edit_user_email').value = email;
                    document.getElementById('edit_user_role').value = role || 'Staff'; // Default fallback

                    window.toggleModal('modalEditAkun');
                } catch (error) {
                    console.error("Gagal membuka modal edit:", error);
                }
            };

            // Fungsi untuk Modal Hapus Akun
            window.openDeleteUserModal = function(button) {
                try {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');

                    const form = document.getElementById('formHapusAkun');
                    if (form) form.action = `/master-data/akun/${id}`;

                    document.getElementById('delete_user_name').innerText = name;

                    window.toggleModal('modalHapusAkun');
                } catch (error) {
                    console.error("Gagal membuka modal hapus:", error);
                }
            };
        </script>
    @endsection
