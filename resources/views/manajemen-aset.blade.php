@extends('layouts.app')

@section('content')
    {{-- ========================================================== --}}
    {{-- BAGIAN HEADER UMUM (Tampil di Desktop & Mobile)            --}}
    {{-- ========================================================== --}}
    <div class="font-inter flex flex-col mt-2 mb-6 px-1">
        <h2 class="text-xl font-bold text-[#006EC4] leading-tight">Daftar Aset</h2>
        <p class="text-[13px] font-light text-[#6B7280] ml-1">Kelola Informasi, Kondisi, dan Mutasi Aset</p>
    </div>

    {{-- Notifikasi Sukses dengan ID untuk ditangkap oleh JavaScript --}}
    @if (session('success'))
        <div id="alert-sukses"
            class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative mb-6 text-sm font-medium transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    {{-- ========================================================== --}}
    {{-- TAMPILAN MOBILE (Layar Kecil)                              --}}
    {{-- ========================================================== --}}
    <div class="block lg:hidden px-4 mt-4">

        {{-- Form Pencarian dan Filter Mobile --}}
        <form method="GET" action="{{ route('manajemen-aset') }}">
            @php $currentBranch = request('branch', 'Semua'); @endphp
            {{-- Hidden input agar saat menekan Enter di pencarian, filter cabang saat ini tidak hilang --}}
            <input type="hidden" name="branch" value="{{ $currentBranch }}">

            {{-- 1. Navigasi Filter Cabang --}}
            <div class="flex overflow-x-auto gap-2 pb-2 scrollbar-hide">
                @foreach (['Semua', 'WML', 'WLD', 'WLS', 'TOSS', 'WLP'] as $index => $cabang)
                    <button type="submit" name="branch" value="{{ $cabang }}"
                        class="cursor-pointer px-5 py-1.5 text-xs font-bold {{ $currentBranch === $cabang ? 'bg-[#D5E7FD] text-[#006EC4]' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} rounded-full shadow-sm transition-all active:scale-95">
                        {{ $cabang }}
                    </button>
                @endforeach
            </div>

            {{-- 2. Kolom Pencarian & Tombol Tambah --}}
            <div class="flex gap-3 mb-6 items-stretch h-[46px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                    class="flex-1 rounded-full border border-gray-200 px-3 py-2 text-sm text-gray-700 focus:outline-none" />
                <button type="button" onclick="toggleModal('modalTambahAset')"
                    class="cursor-pointer rounded-[1.5rem] bg-[#D5E7FD] flex flex-col items-center justify-center px-4">
                    <span class="text-base font-bold leading-none text-[#006EC4]">+</span>
                    <span class="text-[11px] font-bold text-[#006EC4] leading-none">Tambah</span>
                </button>
            </div>
        </form>

        {{-- 3. Grid Daftar Kartu Aset --}}
        <div class="grid grid-cols-2 gap-3">
            @forelse ($assets as $item)
                <div
                    class="min-h-[140px] flex flex-col justify-between rounded-lg bg-white p-3 shadow-sm border border-gray-100 relative">
                    <div>
                        {{-- Header Card: Berisi Nama Aset dan Tombol Titik Tiga --}}
                        <div class="flex justify-between items-start gap-1">
                            <div class="overflow-hidden">
                                <div class="text-sm font-bold text-black truncate">{{ $item->name }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $item->asset_code }}</div>
                            </div>

                            {{-- Container Tombol Titik Tiga & Menu Dropdown --}}
                            <div class="relative">
                                <button type="button" onclick="toggleDropdown('dropdown-{{ $item->id }}')"
                                    class="p-1 text-gray-400 hover:text-gray-700 transition-colors focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="1" />
                                        <circle cx="12" cy="5" r="1" />
                                        <circle cx="12" cy="19" r="1" />
                                    </svg>
                                </button>

                                {{-- Kotak Dropdown (Sembunyi secara default) --}}
                                <div id="dropdown-{{ $item->id }}"
                                    class="hidden absolute right-0 top-6 mt-1 w-32 bg-white rounded-lg shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-gray-100 z-50 overflow-hidden">
                                    <div class="py-1">
                                        {{-- Cetak QR --}}
                                        <button type="button"
                                            onclick="openQrModal('{{ $item->asset_code }}', '{{ $item->name }}', '{{ $item->room->branch->code ?? '' }} - {{ $item->room->branch->name ?? 'Cabang' }}'); toggleDropdown('dropdown-{{ $item->id }}')"
                                            class="w-full text-left px-3 py-2 text-xs font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <rect width="5" height="5" x="3" y="3" rx="1" />
                                                <rect width="5" height="5" x="16" y="3" rx="1" />
                                                <rect width="5" height="5" x="3" y="16" rx="1" />
                                                <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
                                                <path d="M21 21v.01" />
                                                <path d="M12 7v3a2 2 0 0 1-2 2H7" />
                                                <path d="M3 12h.01" />
                                                <path d="M12 3h.01" />
                                                <path d="M12 16v.01" />
                                                <path d="M16 12h1" />
                                                <path d="M21 12v.01" />
                                                <path d="M12 21v-1" />
                                            </svg>
                                            Cetak QR
                                        </button>

                                        {{-- Edit Mobile --}}
                                        <button type="button" data-id="{{ $item->id }}"
                                            data-code="{{ $item->asset_code }}" data-name="{{ $item->name }}"
                                            data-category="{{ $item->category_id }}" data-room="{{ $item->room_id }}"
                                            data-condition="{{ $item->condition }}"
                                            onclick="openEditModal(this); toggleDropdown('dropdown-{{ $item->id }}')"
                                            class="w-full text-left px-3 py-2 text-xs font-medium text-gray-600 hover:bg-blue-50 hover:text-blue-600 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                                <path d="m15 5 4 4" />
                                            </svg>
                                            Edit
                                        </button>

                                        {{-- Mutasi Mobile --}}
                                        <button type="button" data-id="{{ $item->id }}"
                                            data-code="{{ $item->asset_code }}" data-name="{{ $item->name }}"
                                            data-room-name="{{ $item->room->name ?? '-' }} ({{ $item->room->branch->code ?? '-' }})"
                                            onclick="openMutasiModal(this); toggleDropdown('dropdown-{{ $item->id }}')"
                                            class="w-full text-left px-3 py-2 text-xs font-medium text-gray-600 hover:bg-green-50 hover:text-green-600 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                                <path d="M15 18H9" />
                                                <path
                                                    d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                                <circle cx="17" cy="18" r="2" />
                                                <circle cx="7" cy="18" r="2" />
                                            </svg>
                                            Mutasi
                                        </button>

                                        {{-- Hapus Mobile --}}
                                        <button type="button" data-id="{{ $item->id }}"
                                            data-name="{{ $item->asset_code }} - {{ $item->name }}"
                                            onclick="openDeleteModal(this); toggleDropdown('dropdown-{{ $item->id }}')"
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

                        <div class="text-xs text-gray-500 mt-0.5">{{ $item->category->name ?? 'N/A' }}</div>

                        <div class="mt-2">
                            <span
                                class="inline-flex items-center justify-center text-center rounded-full px-2 py-0.5 text-[10px] font-bold {{ $item->condition == 'Baik' ? 'bg-green-100 text-green-700' : ($item->condition == 'Kurang Baik' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ $item->condition }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 text-xs text-gray-500 mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 11.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Zm0 0C8.5 13.5 5 16.5 5 20h14c0-3.5-3.5-6.5-7-8.5Z" />
                        </svg>
                        <span>{{ $item->room->branch->code ?? '' }} - {{ $item->room->name ?? 'N/A' }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-sm text-gray-500 py-4">Pencarian tidak ditemukan.</div>
            @endforelse
        </div>

        {{-- Pagination Mobile --}}
        <div class="mt-6 mb-4 custom-pagination">
            {{ $assets->links() }}
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- TAMPILAN DESKTOP (Layar Besar)                             --}}
    {{-- ========================================================== --}}
    <div class="hidden lg:block">

        {{-- Form Pencarian dan Filter Desktop --}}
        <form method="GET" action="{{ route('manajemen-aset') }}"
            class="flex items-center justify-start mb-6 gap-4 flex-wrap">
            @php $currentBranch = request('branch', 'Semua'); @endphp
            {{-- Hidden input agar saat menekan Enter di pencarian, filter cabang saat ini tidak hilang --}}
            <input type="hidden" name="branch" value="{{ $currentBranch }}">

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 rounded-full border border-[#D5E7FD] bg-white px-3 py-2 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#006EC4]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search"
                        class="w-40 text-sm text-gray-700 placeholder:text-gray-400 bg-transparent focus:outline-none" />
                </div>

                <div class=" ml-7 flex flex-wrap gap-2">
                    @foreach (['Semua', 'WML', 'WLD', 'WLS', 'TOSS', 'WLP'] as $index => $cabang)
                        <button type="submit" name="branch" value="{{ $cabang }}"
                            class="cursor-pointer px-5 py-1.5 text-xs font-bold {{ $currentBranch === $cabang ? 'bg-[#006EC4] text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} rounded-full shadow-sm transition-all active:scale-95">
                            {{ $cabang }}
                        </button>
                    @endforeach
                </div>
            </div>
            <button type="button" onclick="toggleModal('modalTambahAset')"
                class="cursor-pointer ml-25 inline-flex items-center gap-2 text-sm font-bold text-[#006EC4] hover:text-blue-800">
                <span class="text-[#FFCD29]">+</span> Tambah Aset
            </button>
        </form>

        <div class="border border-gray-200 rounded-lg overflow-hidden mt-6 bg-white">
            <table class="w-full text-sm text-center">
                <thead class="bg-gray-100 text-gray-700 border-b border-gray-200">
                    <tr>
                        <th class="py-3 font-bold text-gray-900">ID</th>
                        <th class="py-3 font-bold text-gray-900">Kategori</th>
                        <th class="py-3 font-bold text-gray-900">Nama Aset</th>
                        <th class="py-3 font-bold text-gray-900">Ruangan (Cabang)</th>
                        <th class="py-3 font-bold text-gray-900">Kondisi</th>
                        <th class="py-3 font-bold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y divide-gray-100">
                    @forelse ($assets as $index => $item)
                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition-colors">
                            <td class="py-4 text-sm font-medium">{{ $item->asset_code }}</td>
                            <td class="py-4 text-sm">{{ $item->category->name ?? '-' }}</td>
                            <td class="py-4 text-sm font-semibold text-gray-800">{{ $item->name }}</td>
                            <td class="py-4 text-sm">{{ $item->room->name ?? '-' }}
                                ({{ $item->room->branch->code ?? '-' }})
                            </td>
                            <td class="py-4">
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full {{ $item->condition == 'Baik' ? 'bg-green-100 text-green-700' : ($item->condition == 'Kurang Baik' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $item->condition }}
                                </span>
                            </td>
                            <td class="py-4">
                                <button type="button" title="Cetak QR"
                                    onclick="openQrModal('{{ $item->asset_code }}', '{{ $item->name }}', '{{ $item->room->branch->code ?? '' }} - {{ $item->room->branch->name ?? 'Cabang' }}')"
                                    class="cursor-pointer hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="5" height="5" x="3" y="3" rx="1" />
                                        <rect width="5" height="5" x="16" y="3" rx="1" />
                                        <rect width="5" height="5" x="3" y="16" rx="1" />
                                        <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
                                        <path d="M21 21v.01" />
                                        <path d="M12 7v3a2 2 0 0 1-2 2H7" />
                                        <path d="M3 12h.01" />
                                        <path d="M12 3h.01" />
                                        <path d="M12 16v.01" />
                                        <path d="M16 12h1" />
                                        <path d="M21 12v.01" />
                                        <path d="M12 21v-1" />
                                    </svg>
                                </button>
                                <div class="flex justify-center gap-3 text-gray-500">
                                    {{-- Edit Desktop --}}
                                    <button type="button" title="Edit" data-id="{{ $item->id }}"
                                        data-code="{{ $item->asset_code }}" data-name="{{ $item->name }}"
                                        data-category="{{ $item->category_id }}" data-room="{{ $item->room_id }}"
                                        data-condition="{{ $item->condition }}" onclick="openEditModal(this)"
                                        class="cursor-pointer hover:text-blue-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                            <path d="m15 5 4 4" />
                                        </svg>
                                    </button>
                                    {{-- Mutasi Desktop --}}
                                    <button type="button" title="Mutasi Aset" data-id="{{ $item->id }}"
                                        data-code="{{ $item->asset_code }}" data-name="{{ $item->name }}"
                                        data-room-name="{{ $item->room->name ?? '-' }} ({{ $item->room->branch->code ?? '-' }})"
                                        onclick="openMutasiModal(this)"
                                        class="cursor-pointer hover:text-green-600 transition-colors focus:outline-none p-1 rounded hover:bg-green-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                            <path d="M15 18H9" />
                                            <path
                                                d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                            <circle cx="17" cy="18" r="2" />
                                            <circle cx="7" cy="18" r="2" />
                                        </svg>
                                    </button>

                                    {{-- Hapus Desktop --}}
                                    <button type="button" title="Hapus Aset" data-id="{{ $item->id }}"
                                        data-name="{{ $item->asset_code }} - {{ $item->name }}"
                                        onclick="openDeleteModal(this)"
                                        class="cursor-pointer hover:text-red-600 transition-colors focus:outline-none p-1 rounded hover:bg-red-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                            <td colspan="6" class="py-8 text-gray-500">Pencarian tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Desktop Menggunakan Laravel Links --}}
            <div class="px-4 py-3 border-t border-gray-200 custom-pagination">
                {{ $assets->links() }}
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH ASET --}}
    <x-modal id="modalTambahAset" title="Tambah Aset Baru">
        <form action="{{ route('manajemen-aset.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-600 mb-1">Kode Aset</label>
                <input type="text" disabled
                    class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed"
                    placeholder="Otomatis Digenerate Sistem" />
                <p class="text-[10px] text-gray-400 mt-1">*Kode aset dibuat otomatis oleh sistem</p>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                <select name="category_id" required
                    class="cursor-pointer w-full border border-gray-200 rounded px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Nama Aset</label>
                <input type="text" name="name" required
                    class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                    placeholder="Contoh: Komputer Kasir" />
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Ruangan Penempatan</label>
                <select name="room_id" required class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Ruangan Penempatan</option>
                    @foreach ($rooms->groupBy('branch.code') as $branchCode => $branchRooms)
                        <optgroup label="Cabang {{ $branchCode }}">
                            @foreach ($branchRooms as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-600 mb-1">Kondisi</label>
                <select name="condition" required
                    class="cursor-pointer w-full border border-gray-200 rounded px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Kondisi</option>
                    <option value="Baik">Baik</option>
                    <option value="Kurang Baik">Kurang Baik</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="toggleModal('modalTambahAset')"
                    class="cursor-pointer px-4 py-2 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="cursor-pointer px-4 py-2 bg-[#006EC4] text-white rounded text-sm hover:bg-blue-700">Simpan
                    Aset</button>
            </div>
        </form>
    </x-modal>

    {{-- MODAL CETAK QR --}}
    <x-modal id="modalCetakQR" title="Cetak Label QR Code">
        <div class="flex flex-col items-center justify-center p-4">
            <div id="printArea"
                class="bg-white border border-gray-200 shadow-sm rounded-xl p-8 flex flex-col items-center justify-center w-[280px] mb-6">
                <div class="font-bold text-gray-800 text-sm mb-4">Inventor<span class="text-[#FFCD29]">+</span></div>
                <img id="qrImage" src="" alt="QR Code" class="mb-6 w-[120px] h-[120px]">
                <div id="qrAssetCode" class="text-sm font-bold text-gray-900"></div>
                <div id="qrAssetName" class="text-xs text-gray-500 mt-1"></div>
                <div id="qrAssetBranch" class="text-xs text-[#006EC4] mt-2 font-medium"></div>
            </div>
            <div class="flex items-center justify-between gap-4 w-full px-2">
                <button type="button" onclick="toggleModal('modalCetakQR')"
                    class="cursor-pointer w-1/2 py-2.5 bg-[#A1A1AA] text-white font-bold rounded-md text-sm hover:bg-gray-500 transition-colors">
                    Batal
                </button>
                <button type="button" onclick="printQR()"
                    class="cursor-pointer w-1/2 py-2.5 bg-[#006EC4] text-white font-bold rounded-md text-sm hover:bg-blue-700 transition-colors">
                    Cetak Label
                </button>
            </div>
        </div>
    </x-modal>

    {{-- MODAL EDIT DATA ASET --}}
    <x-modal id="modalEditAset" title="Edit Data Aset">
        <form id="formEditAset" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-600 mb-1">Kode Aset</label>
                <input type="text" id="edit_asset_code" disabled
                    class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed" />
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Kategori</label>
                <select name="category_id" id="edit_category_id" required
                    class="cursor-pointer w-full border border-gray-200 rounded px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Nama Aset</label>
                <input type="text" name="name" id="edit_name" required
                    class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500" />
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Ruangan Penempatan</label>
                <select name="room_id" id="edit_room_id" required class="w-full border rounded px-3 py-2">
                    <option value="">Pilih Ruangan Penempatan</option>
                    @foreach ($rooms->groupBy('branch.code') as $branchCode => $branchRooms)
                        <optgroup label="Cabang {{ $branchCode }}">
                            @foreach ($branchRooms as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Kondisi</label>
                <select name="condition" id="edit_condition" required
                    class="cursor-pointer w-full border border-gray-200 rounded px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-500">
                    <option value="">Pilih Kondisi</option>
                    <option value="Baik">Baik</option>
                    <option value="Kurang Baik">Kurang Baik</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="toggleModal('modalEditAset')"
                    class="cursor-pointer px-4 py-2 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="cursor-pointer px-4 py-2 bg-[#006EC4] text-white rounded text-sm hover:bg-blue-700">Simpan
                    Perubahan</button>
            </div>
        </form>
    </x-modal>

    {{-- MODAL MUTASI ASET --}}
    <x-modal id="modalMutasiAset" title="Mutasi / Pindah Ruangan Aset">
        <form id="formMutasiAset" method="POST" class="space-y-4">
            @csrf
            {{-- Gunakan POST, nanti di route kita sesuaikan --}}

            <div class="bg-blue-50 p-3 rounded-lg border border-blue-100 mb-4">
                <div class="text-xs text-blue-500 mb-1">Aset yang akan dimutasi:</div>
                <div id="mutasi_asset_code" class="font-bold text-blue-700"></div>
                <div id="mutasi_asset_name" class="text-sm text-blue-900"></div>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Ruangan Saat Ini</label>
                <input type="text" id="mutasi_current_room" disabled
                    class="w-full border border-gray-200 rounded px-3 py-2 text-sm bg-gray-100 text-gray-500 cursor-not-allowed" />
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Pindah Ke Ruangan Baru <span
                        class="text-red-500">*</span></label>
                <select name="room_id" required
                    class="cursor-pointer w-full border border-gray-300 rounded px-3 py-2 text-sm bg-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">Pilih Ruangan Tujuan</option>
                    @foreach ($rooms->groupBy('branch.code') as $branchCode => $branchRooms)
                        <optgroup label="Cabang {{ $branchCode }}">
                            @foreach ($branchRooms as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm text-gray-600 mb-1">Keterangan / Alasan Mutasi <span
                        class="text-red-500">*</span></label>
                <textarea name="keterangan" required rows="3"
                    class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:border-blue-500"
                    placeholder="Contoh: Dipindahkan karena ruangan direnovasi..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t mt-4">
                <button type="button" onclick="toggleModal('modalMutasiAset')"
                    class="cursor-pointer px-4 py-2 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="cursor-pointer px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700">Proses
                    Mutasi</button>
            </div>
        </form>
    </x-modal>

    {{-- MODAL HAPUS ASET --}}
    <x-modal id="modalHapusAset" title="Konfirmasi Hapus Aset">
        <form id="formHapusAset" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex flex-col items-center justify-center py-4 text-center">
                <div class="bg-red-100 p-3 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Hapus Aset Ini?</h3>
                <p class="text-sm text-gray-500">Anda akan menghapus <br><strong id="delete_asset_name"
                        class="text-red-600"></strong></p>
                <p class="text-xs text-gray-400 mt-2">Tindakan ini tidak dapat dibatalkan dan data akan hilang permanen.
                </p>
            </div>

            <div class="flex items-center justify-center gap-3 pt-4 border-t mt-2">
                <button type="button" onclick="toggleModal('modalHapusAset')"
                    class="cursor-pointer px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded text-sm hover:bg-gray-200">Batal</button>
                <button type="submit"
                    class="cursor-pointer px-6 py-2 bg-red-600 text-white font-medium rounded text-sm hover:bg-red-700">Ya,
                    Hapus Aset</button>
            </div>
        </form>
    </x-modal>

    {{-- SCRIPT MODAL EDIT (DEBUG MODE) --}}
    <script>
        window.openEditModal = function(button) {
            // Kita pindahkan logika ke dalam fungsi yang memastikan elemen siap
            try {
                const id = button.getAttribute('data-id');
                const code = button.getAttribute('data-code');
                const name = button.getAttribute('data-name');
                const categoryId = button.getAttribute('data-category');
                const roomId = button.getAttribute('data-room');
                const condition = button.getAttribute('data-condition');

                const form = document.getElementById('formEditAset');
                if (form) form.action = `/manajemen-aset/${id}`;

                // Gunakan pengecekan elemen sebelum mengisi value
                const fields = {
                    'edit_asset_code': code,
                    'edit_name': name,
                    'edit_category_id': categoryId,
                    'edit_room_id': roomId,
                    'edit_condition': condition
                };

                for (const [id, value] of Object.entries(fields)) {
                    const el = document.getElementById(id);
                    if (el) el.value = value;
                }

                window.toggleModal('modalEditAset');

            } catch (error) {
                // Cukup log ke konsol, jangan pakai alert agar tidak mengganggu pengguna
                console.error("Gagal membuka modal:", error);
            }
        };

        // Fungsi untuk membuka Modal Mutasi
        window.openMutasiModal = function(button) {
            try {
                const id = button.getAttribute('data-id');
                const code = button.getAttribute('data-code');
                const name = button.getAttribute('data-name');
                const currentRoom = button.getAttribute('data-room-name');

                const form = document.getElementById('formMutasiAset');
                if (form) form.action = `/manajemen-aset/${id}/mutasi`; // Route tujuan mutasi

                document.getElementById('mutasi_asset_code').innerText = code;
                document.getElementById('mutasi_asset_name').innerText = name;
                document.getElementById('mutasi_current_room').value = currentRoom;

                window.toggleModal('modalMutasiAset');
            } catch (error) {
                console.error("Gagal membuka modal mutasi:", error);
            }
        };

        // Fungsi untuk membuka Modal Hapus
        window.openDeleteModal = function(button) {
            try {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');

                const form = document.getElementById('formHapusAset');
                if (form) form.action = `/manajemen-aset/${id}`; // Route tujuan hapus

                document.getElementById('delete_asset_name').innerText = name;

                window.toggleModal('modalHapusAset');
            } catch (error) {
                console.error("Gagal membuka modal hapus:", error);
            }
        };
    </script>
@endsection
