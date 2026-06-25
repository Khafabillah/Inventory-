@extends('layouts.app')

@section('content')
    <div class="font-inter flex flex-col -mt-7 mb-6">
        <h2 class="text-xl font-light text-[#006EC4] leading-tight">Dashboard</h2>
        <p class="text-[13px] font-light text-[#B9B9BE] ml-1 -mt-1">Visualisasi Data</p>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-12 gap-6">
        <div
            class="col-span-12 font-inter grid grid-cols-6 gap-6 p-5 bg-white rounded-2xl shadow-[0_4px_8px_0_rgba(0,0,0,0.25)] border border-gray-100">
            @foreach ([['Total Aset', '868', 'text-gray-900'], ['Kategori', '200', 'text-gray-900'], ['Total Ruangan', '868', 'text-gray-900'], ['Total Mutasi', '200', 'text-gray-900'], ['Kondisi Baik', '868', 'text-green-600'], ['Aset Rusak', '200', 'text-red-600']] as $stat)
                <div class="text-center">
                    <p class="text-xs font-regular text-gray-400">{{ $stat[0] }}</p>
                    <h3 class="text-xl font-bold {{ $stat[2] }} mt-1">{{ $stat[1] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Bar Charts --}}
        <div
            class="col-span-8 p-6 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-200 h-[350px] flex flex-col">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Distribusi Aset per Ruangan</h3>

            <div class="flex-grow relative">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        {{-- Pie Charts --}}
        <div
            class="col-span-4 p-6 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-200 flex flex-col">
            <h3 class="font-inter text-lg font-semibold text-gray-900 mb-6">Distribusi Kondisi</h3>

            <div class="relative w-full h-[250px] flex items-center justify-center">
                <canvas id="donutChart"></canvas>
            </div>
        </div>
    @endsection
