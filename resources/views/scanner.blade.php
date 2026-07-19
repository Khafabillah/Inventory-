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

    {{-- ================= OVERLAY MODAL ================= --}}
    <div id="modal-overlay"
        class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center px-4 font-inter backdrop-blur-sm transition-opacity">

        {{-- 1. MODAL: SCANNING BERHASIL --}}
        <div id="modal-success" class="hidden bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl relative">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-[#006EC4] font-bold text-sm leading-tight pr-4">Scanning Berhasil,<br>Aset Ditemukan!</h3>
                <div class="bg-green-100 p-1.5 rounded-full text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <div class="space-y-3 mb-6 text-sm">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kode Aset</label>
                    <div class="bg-gray-100 p-2.5 rounded-lg text-gray-700 font-medium" id="txt-kode">INV-001</div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Nama Aset</label>
                    <div class="bg-gray-100 p-2.5 rounded-lg text-gray-700 font-medium" id="txt-nama">Laptop ASUS ROG</div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Merek</label>
                    <div class="bg-gray-100 p-2.5 rounded-lg text-gray-700 font-medium" id="txt-merek">ASUS</div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kondisi</label>
                    <div class="bg-gray-100 p-2.5 rounded-lg text-gray-700 font-medium" id="txt-kondisi">Baik</div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button onclick="openEditModal()"
                    class="w-full bg-[#006EC4] text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition">Edit</button>
                <button onclick="openMutasiModal()"
                    class="w-full bg-[#FBBF24] text-white py-2.5 rounded-lg font-bold text-sm hover:bg-yellow-500 transition">Mutasi</button>
            </div>
        </div>

        {{-- 2. MODAL: EDIT DETAIL ASET --}}
        <div id="modal-edit" class="hidden bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl relative">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-yellow-500 hover:text-yellow-600 font-bold">X</button>
            <h3 class="text-[#006EC4] font-bold text-base mb-5">Edit Detail Aset</h3>

            <div class="space-y-4 mb-6 text-sm">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kode Aset (Read Only)</label>
                    <input type="text"
                        class="w-full bg-gray-100 p-2.5 rounded-lg text-gray-500 border border-gray-200 outline-none"
                        value="INV-001" readonly>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Nama Aset</label>
                    <input type="text"
                        class="w-full bg-white p-2.5 rounded-lg text-gray-800 border border-gray-300 focus:border-[#006EC4] outline-none"
                        value="Laptop ASUS ROG">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Merek</label>
                    <select
                        class="w-full bg-white p-2.5 rounded-lg text-gray-800 border border-gray-300 focus:border-[#006EC4] outline-none appearance-none">
                        <option>ASUS</option>
                        <option>Lenovo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kondisi</label>
                    <select
                        class="w-full bg-white p-2.5 rounded-lg text-gray-800 border border-gray-300 focus:border-[#006EC4] outline-none appearance-none">
                        <option>Baik</option>
                        <option>Rusak</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button onclick="backToSuccessModal()"
                    class="w-full bg-gray-400 text-white py-2.5 rounded-lg font-bold text-sm hover:bg-gray-500 transition">Batal</button>
                <button onclick="closeModal()"
                    class="w-full bg-[#006EC4] text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition">Simpan</button>
            </div>
        </div>

        {{-- 3. MODAL: MUTASI LOKASI --}}
        <div id="modal-mutasi" class="hidden bg-white rounded-2xl w-full max-w-sm p-6 shadow-xl relative">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-yellow-500 hover:text-yellow-600 font-bold">X</button>
            <h3 class="text-[#006EC4] font-bold text-base mb-5">Mutasi/Lokasi Aset</h3>

            <div class="space-y-4 mb-6 text-sm">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Kode Aset</label>
                    <input type="text"
                        class="w-full bg-gray-100 p-2.5 rounded-lg text-gray-500 border border-gray-200 outline-none"
                        value="INV-001" readonly>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Nama Aset</label>
                    <input type="text"
                        class="w-full bg-gray-100 p-2.5 rounded-lg text-gray-500 border border-gray-200 outline-none"
                        value="Laptop ASUS ROG" readonly>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Penanggung Jawab</label>
                    <input type="text"
                        class="w-full bg-white p-2.5 rounded-lg text-gray-800 border border-gray-300 focus:border-[#006EC4] outline-none"
                        value="Budi Santoso">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">Pindah Lokasi</label>
                    <select
                        class="w-full bg-white p-2.5 rounded-lg text-gray-800 border border-gray-300 focus:border-[#006EC4] outline-none appearance-none">
                        <option>R. Komputer 1</option>
                        <option>R. Guru</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button onclick="backToSuccessModal()"
                    class="w-full bg-gray-400 text-white py-2.5 rounded-lg font-bold text-sm hover:bg-gray-500 transition">Batal</button>
                <button onclick="closeModal()"
                    class="w-full bg-[#FBBF24] text-white py-2.5 rounded-lg font-bold text-sm hover:bg-yellow-500 transition">Mutasi</button>
            </div>
        </div>
    </div>

    {{-- TOAST ERROR: Aset Tidak Ditemukan --}}
    <div id="toast-error"
        class="hidden fixed bottom-10 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50 transition-all font-inter font-medium text-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Aset Tidak Ditemukan!
    </div>

    {{-- Script HTML5-QRCode via CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        // === FUNGSI KONTROL MODAL ===
        const overlay = document.getElementById('modal-overlay');
        const modalSuccess = document.getElementById('modal-success');
        const modalEdit = document.getElementById('modal-edit');
        const modalMutasi = document.getElementById('modal-mutasi');
        const toastError = document.getElementById('toast-error');

        function hideAllModals() {
            modalSuccess.classList.add('hidden');
            modalEdit.classList.add('hidden');
            modalMutasi.classList.add('hidden');
        }

        function closeModal() {
            overlay.classList.add('hidden');
            hideAllModals();
            // Lanjutkan scanner jika modal ditutup
            if (window.html5QrcodeScanner) {
                window.html5QrcodeScanner.resume();
            }
        }

        function showSuccessModal(decodedText) {
            hideAllModals();
            overlay.classList.remove('hidden');
            modalSuccess.classList.remove('hidden');

            // Dummy: Memasukkan hasil scan ke modal
            document.getElementById('txt-kode').innerText = decodedText;
        }

        function openEditModal() {
            hideAllModals();
            modalEdit.classList.remove('hidden');
        }

        function openMutasiModal() {
            hideAllModals();
            modalMutasi.classList.remove('hidden');
        }

        function backToSuccessModal() {
            hideAllModals();
            modalSuccess.classList.remove('hidden');
        }

        function showErrorToast() {
            toastError.classList.remove('hidden');
            setTimeout(() => {
                toastError.classList.add('hidden');
            }, 3000); // Hilang otomatis setelah 3 detik
        }

        // === LOGIK SCANNER ===
        document.addEventListener('DOMContentLoaded', function() {
            function onScanSuccess(decodedText, decodedResult) {
                // Pause scanner sementara saat modal terbuka
                if (window.html5QrcodeScanner.getState() !== 3) { // 3 = PAUSED
                    window.html5QrcodeScanner.pause();
                }

                // Logika sederhana: Jika teks mengandung "INV", anggap sukses
                if (decodedText.includes('INV')) {
                    showSuccessModal(decodedText);
                } else {
                    showErrorToast();
                    // Resume scanner otomatis jika gagal
                    setTimeout(() => window.html5QrcodeScanner.resume(), 3000);
                }
            }

            function onScanFailure(error) {
                // Biarkan kosong
            }

            window.html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    aspectRatio: 1.0
                },
                false
            );

            window.html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });
    </script>

    {{-- CSS Kustom agar tombol library bawaan terlihat rapi dan menyatu dengan tema Inventor+ --}}
    <style>
        #reader__dashboard_section_csr span {
            color: #ef4444 !important;
            /* text-red-500 */
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
