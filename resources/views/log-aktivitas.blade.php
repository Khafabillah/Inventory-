@extends('layouts.app')

@section('content')
    {{-- ========================================================== --}}
    {{-- BAGIAN HEADER UMUM (Tampil di Desktop & Mobile)            --}}
    {{-- ========================================================== --}}
    <div class="font-inter flex flex-col mt-2 mb-6 px-1">
        <h2 class="text-xl font-bold text-[#006EC4] leading-tight">Log Aktivitas</h2>
        <p class="text-[13px] font-light text-[#6B7280] ml-1">Riwayat Perubahan Data dan Jejak Audit</p>
    </div>

    {{-- ========================================================== --}}
    {{-- TAMPILAN MOBILE (Layar Kecil)                              --}}
    {{-- ========================================================== --}}
    <div class="block lg:hidden px-4 mt-4 font-inter">

        {{-- Form Pencarian Mobile --}}
        <form method="GET" action="{{ route('log-aktivitas') }}">
            <div class="flex gap-3 mb-6 items-stretch h-[46px]">
                <div class="flex-1 flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search histori..."
                        class="w-full text-sm text-gray-700 focus:outline-none bg-transparent" />
                </div>
            </div>
        </form>

        {{-- Grid Daftar Kartu Log Mobile --}}
        <div class="flex flex-col gap-3">
            @forelse ($logs as $log)
                {{-- Penentuan Warna Badge Aktivitas --}}
                @php
                    $badgeClass = match(strtolower($log->action ?? '')) {
                        'tambah' => 'bg-green-100 text-green-700',
                        'edit' => 'bg-blue-100 text-blue-700',
                        'hapus' => 'bg-red-100 text-red-700',
                        'mutasi' => 'bg-orange-100 text-orange-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp

                <div class="rounded-xl bg-white p-4 shadow-sm border border-gray-100 relative">
                    <div class="flex justify-between items-start mb-2">
                        <div class="font-bold text-sm text-gray-900">{{ $log->user->name ?? 'Sistem' }}</div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] text-gray-500 font-medium">Aktivitas:</span>
                            <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full {{ $badgeClass }}">
                                {{ ucfirst($log->action ?? 'Unknown') }}
                            </span>
                        </div>
                    </div>

                    <div class="text-xs text-gray-600 leading-relaxed mb-3">
                        {{ $log->description }}
                    </div>

                    <div class="text-[10px] text-gray-400 font-medium border-t border-gray-50 pt-2">
                        {{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y | H:i') }}
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-gray-500 py-8 bg-white rounded-xl border border-gray-100">
                    Tidak ada histori aktivitas.
                </div>
            @endforelse
        </div>

        {{-- Pagination Mobile --}}
        <div class="mt-6 mb-4 custom-pagination">
            {{ $logs->links() }}
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- TAMPILAN DESKTOP (Layar Besar)                             --}}
    {{-- ========================================================== --}}
    <div class="hidden lg:block font-inter">

        {{-- Form Pencarian Desktop --}}
        <form method="GET" action="{{ route('log-aktivitas') }}" class="flex items-center justify-start mb-6">
            <div class="flex items-center gap-2 rounded-full border border-[#D5E7FD] bg-white px-3 py-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#006EC4]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.5 10.5a7.5 7.5 0 0013.15 6.15z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                    class="w-64 text-sm text-gray-700 placeholder:text-gray-400 bg-transparent focus:outline-none" />
                <button type="submit" class="hidden"></button>
            </div>
        </form>

        {{-- Tabel Log Aktivitas --}}
        <div class="border border-[#B3D4F5] rounded-xl overflow-hidden bg-white shadow-sm">
            <table class="w-full text-sm text-center">
                <thead class="bg-[#F0F7FF] text-[#006EC4] border-b border-[#B3D4F5]">
                    <tr>
                        <th class="py-4 font-bold w-16">No</th>
                        <th class="py-4 font-bold">Waktu & Tanggal</th>
                        <th class="py-4 font-bold">User</th>
                        <th class="py-4 font-bold text-left pl-4">Detail</th>
                        <th class="py-4 font-bold w-32">Aktivitas</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-100">
                    @forelse ($logs as $index => $log)
                        {{-- Penentuan Warna Badge Aktivitas --}}
                        @php
                            $badgeClass = match(strtolower($log->action ?? '')) {
                                'tambah' => 'bg-green-100 text-green-700',
                                'edit' => 'bg-blue-100 text-blue-700',
                                'hapus' => 'bg-red-100 text-red-700',
                                'mutasi' => 'bg-orange-100 text-orange-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp

                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-[#F8FBFF]' }} hover:bg-blue-50 transition-colors">
                            <td class="py-4 font-medium">{{ $logs->firstItem() + $index }}</td>
                            <td class="py-4">{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d F Y | H:i') }}</td>
                            <td class="py-4 font-semibold">{{ $log->user->name ?? 'Sistem' }}</td>
                            <td class="py-4 text-left pl-4 pr-6 leading-relaxed max-w-md">{{ $log->description }}</td>
                            <td class="py-4">
                                <span class="px-4 py-1 text-[11px] font-bold rounded-full {{ $badgeClass }}">
                                    {{ ucfirst($log->action ?? 'Unknown') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-gray-500">Tidak ada histori aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Desktop --}}
            <div class="px-4 py-3 border-t border-[#B3D4F5] bg-[#F0F7FF] custom-pagination">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
