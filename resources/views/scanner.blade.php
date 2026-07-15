@extends('layouts.app')

@section('content')
    <div class="font-inter flex flex-col mt-2 mb-6 px-4">
        <h2 class="text-xl font-bold text-[#006EC4] leading-tight">Scanner QR</h2>
        <p class="text-[13px] font-light text-[#6B7280]">Scan label aset untuk melihat detail</p>
    </div>

    {{-- Container untuk Kamera --}}
    <div class="px-4 pb-8 max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col items-center">

            {{-- Elemen ini yang akan digantikan oleh tampilan kamera --}}
            <div id="reader" class="w-full rounded-xl overflow-hidden border-2 border-[#D5E7FD] mb-4"></div>

            <div class="text-center mt-2">
                <h3 class="text-sm font-bold text-gray-900 mb-1">Arahkan Kamera ke QR Code</h3>
                <p class="text-[11px] text-gray-500 leading-relaxed px-2">
                    Izinkan akses kamera pada browser. Sistem akan otomatis membuka data aset saat QR Code terbaca.
                </p>
            </div>
        </div>
    </div>

    {{-- Script HTML5-QRCode via CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi ketika QR berhasil terbaca
            function onScanSuccess(decodedText, decodedResult) {
                // 1. Hentikan scanner agar tidak membaca berulang kali
                html5QrcodeScanner.clear();

                // 2. Redirect ke halaman manajemen aset sambil membawa parameter 'search'
                window.location.href = "{{ route('manajemen-aset') }}?search=" + encodeURIComponent(decodedText);
            }

            function onScanFailure(error) {
                // Biarkan kosong agar console tidak penuh dengan log error saat kamera sedang mencari QR
            }

            // Konfigurasi Scanner
            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                {
                    fps: 10, // Frame per second (kecepatan baca)
                    qrbox: {width: 250, height: 250}, // Ukuran kotak fokus
                    aspectRatio: 1.0 // Rasio kotak kamera (1:1 / persegi)
                },
                false // Disable verbose logging
            );

            // Jalankan Scanner
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>

    {{-- CSS Kustom agar tombol library bawaan terlihat rapi dan menyatu dengan tema Inventor+ --}}
    <style>
        #reader__dashboard_section_csr span {
            color: #ef4444 !important; /* text-red-500 */
            font-size: 12px;
            font-family: 'Inter', sans-serif;
        }
        #reader__dashboard_section_csr button {
            background-color: #006EC4 !important;
            color: white !important;
            border: none !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            font-size: 12px !important;
            font-weight: bold !important;
            cursor: pointer !important;
            margin-top: 12px !important;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        #reader__dashboard_section_csr button:active {
            transform: scale(0.95);
        }
        #reader__camera_selection {
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            padding: 8px !important;
            font-size: 12px !important;
            margin-bottom: 12px !important;
            width: 100% !important;
            font-family: 'Inter', sans-serif;
            outline: none;
        }
        #reader__dashboard_section_swaplink {
            color: #006EC4 !important;
            text-decoration: none !important;
            font-size: 12px !important;
            font-weight: bold !important;
        }
    </style>
@endsection
