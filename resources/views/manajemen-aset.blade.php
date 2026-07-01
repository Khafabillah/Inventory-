@extends('layouts.app')

@section('content')
    <div class="font-inter flex flex-col mt-2 mb-6 px-1">
        <h2 class="text-xl font-bold text-[#006EC4] leading-tight">Daftar Aset</h2>
        <p class="text-[13px] font-light text-[#6B7280] ml-1">Kelola Informasi, Kondisi, dan Mutasi Aset</p>
    </div>

    <div class="flex items-center justify-start mb-6 gap-4 flex-wrap">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 rounded-full border border-[#D5E7FD] bg-white px-3 py-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#006EC4]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                </svg>
                <input type="text" placeholder="Search"
                    class="w-40 text-sm text-gray-700 placeholder:text-gray-400 bg-transparent focus:outline-none" />
            </div>


            <div class=" ml-7 flex flex-wrap gap-2">
                @foreach (['Semua', 'WML', 'WLD', 'WLS', 'TOSS', 'WLP'] as $index => $cabang)
                    <button
                        class="px-5 py-1.5 text-xs font-bold {{ $index === 0 ? 'bg-[#006EC4] text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }} rounded-full shadow-sm transition-all active:scale-95">
                        {{ $cabang }}
                    </button>
                @endforeach
            </div>
        </div>
        <button type="button" class="ml-25 inline-flex items-center gap-2 text-sm font-bold text-[#006EC4]">
            <span class="text-[#FFCD29]">+</span>
            Tambah Aset
        </button>
    </div>

    <div class="border border-gray-200 rounded-lg overflow-hidden mt-6">
        <table class="w-full text-sm text-center">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 font-bold text-gray-900">ID</th>
                    <th class="py-3 font-bold text-gray-900">Kategori</th>
                    <th class="py-3 font-bold text-gray-900">Nama Aset</th>
                    <th class="py-3 font-bold text-gray-900">Ruangan</th>
                    <th class="py-3 font-bold text-gray-900">Kondisi</th>
                    <th class="py-3 font-bold text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @php
                    $dataAset = [
                        ['WML-001', 'Elektronik', 'AC Sharp 2 PK', 'Showroom', 'Baik'],
                        ['WML-002', 'Alat Bengkel', 'Tool Kit Set', 'Bengkel', 'Kurang Baik'],
                        ['WLD-001', 'Mebel', 'Meja Front Office', 'Showroom', 'Baik'],
                        ['WLD-002', 'Elektronik', 'TV LED 50"', 'Showroom', 'Baik'],
                        ['WLS-001', 'Furniture', 'Kursi Tunggu', 'Lounge', 'Rusak'],
                        ['WLS-002', 'Elektronik', 'Dispenser', 'Showroom', 'Baik'],
                        ['TOSS-001', 'Elektronik', 'Komputer Kasir', 'Office 1', 'Baik'],
                        ['TOSS-002', 'Furniture', 'Lemari Arsip', 'Gudang', 'Rusak'],
                        ['WLP-006', 'Elektronik', 'Printer Canon', 'Office 2', 'Baik'],
                        ['WLP-008', 'Mebel', 'Meja Kerja', 'Office 2', 'Baik'],
                    ];
                @endphp

                @foreach ($dataAset as $index => $item)
                    <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition-colors">
                        <td class="py-4 text-sm">{{ $item[0] }}</td>
                        <td class="py-4 text-sm">{{ $item[1] }}</td>
                        <td class="py-4 text-sm">{{ $item[2] }}</td>
                        <td class="py-4 text-sm">{{ $item[3] }}</td>
                        <td class="py-4">
                            <span
                                class="px-3 py-1 text-xs font-bold rounded-full
                {{ $item[4] == 'Baik'
                    ? 'bg-green-100 text-green-700'
                    : ($item[4] == 'Kurang Baik'
                        ? 'bg-yellow-100 text-yellow-700'
                        : 'bg-red-100 text-red-700') }}">
                                {{ $item[4] }}
                            </span>
                        </td>
                        <td class="py-4">
                            <div class="flex justify-center gap-3 text-gray-500">
                                {{-- Edit (Pencil) --}}
                                <button title="Edit" class="hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil">
                                        <path
                                            d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                {{-- Mutasi (Truck) --}}
                                <button title="Mutasi" class="hover:text-green-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck">
                                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" />
                                        <path d="M15 18H9" />
                                        <path
                                            d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14" />
                                        <circle cx="17" cy="18" r="2" />
                                        <circle cx="7" cy="18" r="2" />
                                    </svg>
                                </button>
                                {{-- Hapus (Trash) --}}
                                <button title="Hapus" class="hover:text-red-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </tbody>
        </table>

        <div class="flex items-center justify-between bg-[#9FC7E7] py-3 px-4 text-sm text-gray-900">
            <div>Menampilkan 1-10 dari 868 aset</div>
            <div class="inline-flex items-center gap-2">
                <span
                    class="inline-flex h-9 w-9 items-center justify-center rounded border border-black bg-white text-black">&lt;</span>
                <span class="inline-flex h-9 w-9 items-center justify-center rounded border border-black bg-white"></span>
                <span class="inline-flex h-9 w-9 items-center justify-center rounded border border-black bg-white"></span>
                <span class="inline-flex h-9 w-9 items-center justify-center rounded border border-black bg-white"></span>
                <span
                    class="inline-flex h-9 w-9 items-center justify-center rounded border border-black bg-white text-black">&gt;</span>
            </div>
        </div>
    </div>
@endsection
