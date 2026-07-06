@extends('layouts.app')

@section('content')
    <div class="font-inter flex flex-col mt-2 mb-6 px-1">
        <h2 class="text-xl font-bold text-[#006EC4] leading-tight">Dashboard</h2>
        <p class="text-[13px] font-light text-[#B9B9BE] ml-1">Visualisasi Data</p>
    </div>

    {{-- FILTER CABANG (Pills) --}}
    <div class="flex flex-wrap gap-2 mb-6">
        @php $selectedCabang = request('cabang', 'Semua'); @endphp

        @foreach (['Semua', 'WML', 'WLD', 'WLS', 'TOSS', 'WLP'] as $cabang)
            <a href="{{ route('dashboard', ['cabang' => $cabang]) }}"
                class="px-5 py-1.5 text-xs font-bold rounded-full shadow-sm transition-all active:scale-95 inline-block text-center
           {{ $selectedCabang === $cabang ? 'bg-[#006EC4] text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $cabang }}
            </a>
        @endforeach
    </div>

    {{-- Statistics Dinamis --}}
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 lg:gap-6 mb-6">
        @foreach ([['Total Aset', $stats['totalAset'] ?? 0, 'text-gray-900'], ['Kategori', $stats['totalKategori'] ?? 0, 'text-gray-900'], ['Total Ruangan', $stats['totalRuangan'] ?? 0, 'text-gray-900'], ['Total Mutasi', $stats['totalMutasi'] ?? 0, 'text-gray-900'], ['Kondisi Baik', $stats['kondisiBaik'] ?? 0, 'text-green-600'], ['Aset Rusak', $stats['asetRusak'] ?? 0, 'text-red-600']] as $stat)
            <div class="text-center p-3 bg-white rounded-2xl shadow-sm border border-gray-100">
                <p class="text-[10px] lg:text-xs font-regular text-gray-400">{{ $stat[0] }}</p>
                <h3 class="text-lg lg:text-xl font-bold {{ $stat[2] }} mt-1">{{ $stat[1] }}</h3>
            </div>
        @endforeach
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        <div
            class="col-span-1 lg:col-span-8 p-6 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col h-full">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $chartTitle }}</h3>
            <div class="flex-grow relative min-h-[250px]">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <div
            class="col-span-1 lg:col-span-4 p-6 bg-white rounded-2xl shadow-sm border border-gray-200 flex flex-col h-full justify-between">
            <h3 class="font-inter text-lg font-semibold text-gray-900 mb-4">Distribusi Kondisi</h3>
            <div class="relative w-full flex-grow flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
            <div id="donutLegend" class="flex flex-wrap justify-center gap-4 mt-6"></div>
        </div>
    </div>

   {{-- Lempar Data ke JavaScript --}}
<script>
    window.dashboardData = {
        // Menggunakan $barLabels dan $barCounts yang sudah disiapkan di route web.php
        barLabels: {!! json_encode($barLabels) !!},
        barData: {!! json_encode($barCounts) !!},
        donutData: {!! json_encode(array_values($kondisiChart)) !!}
    };
</script>
@endsection
