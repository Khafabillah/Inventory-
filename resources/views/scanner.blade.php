@extends('layouts.app')

@section('content')
    {{-- ================= KANVAS SCANNER CUSTOM (FIGMA DESIGN) ================= --}}
    <div class="relative bg-black h-[calc(100vh-60px)] min-h-[85vh] w-full overflow-hidden flex flex-col items-center">

        {{-- Tempat Video Kamera Dirender --}}
        <div id="reader" class="absolute inset-0 w-full h-full object-cover"></div>

        {{-- Overlay Gelap di Luar Kotak Scan (Efek Fokus) --}}
        <div class="absolute inset-0 pointer-events-none border-[50px] border-black/60 z-10"></div>

        {{-- Tombol Ikon Atas (Flash, Gallery, Switch Camera) --}}
        <div class="absolute top-8 w-full flex justify-center gap-4 z-20">
            <button class="bg-gray-800/80 p-2.5 rounded-lg border border-gray-600 text-[#38BDF8] hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </button>
            <button class="bg-gray-800/80 p-2.5 rounded-lg border border-gray-600 text-[#38BDF8] hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </button>
            <button class="bg-gray-800/80 p-2.5 rounded-lg border border-gray-600 text-[#38BDF8] hover:bg-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </button>
        </div>

        {{-- Kotak Area Target & Garis Merah Laser --}}
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-20">
            <div class="w-60 h-60 border-2 border-[#38BDF8] rounded-xl relative overflow-hidden flex flex-col justify-center">
                <div class="w-full h-[2px] bg-red-600 shadow-[0_0_8px_3px_rgba(220,38,38,0.8)]"></div>
            </div>
        </div>

        {{-- Slider Zoom (Tampilan Visual Saja) --}}
        <div class="absolute bottom-28 w-full flex items-center justify-center px-12 gap-3 z-20 text-white font-bold">
            <span>-</span>
            <input type="range" class="w-full h-1 bg-gray-600 rounded-lg appearance-none cursor-pointer accent-[#38BDF8]">
            <span>+</span>
        </div>

        {{-- Tombol Scan Bawah --}}
        <div class="absolute bottom-10 z-20">
            <button class="bg-[#38BDF8] p-4 rounded-xl shadow-[0_0_15px_rgba(56,189,248,0.5)]">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
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

            // Lanjutkan (resume) kamera setelah modal ditutup
            if (window.html5QrCodeInstance && window.html5QrCodeInstance.getState() === 3) {
                window.html5QrCodeInstance.resume();
            }
        }

        function showSuccessModal(decodedText) {
            hideAllModals();
            overlay.classList.remove('hidden');
            modalSuccess.classList.remove('hidden');

            // Memasukkan kode hasil scan ke dalam Modal
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
            }, 3000);
        }

        // === LOGIKA SCANNER CUSTOM (CAMERA BELAKANG) ===
        document.addEventListener('DOMContentLoaded', function() {

            // Menggunakan Class Inti Html5Qrcode (Bukan Scanner)
            const html5QrCode = new Html5Qrcode("reader");

            function onScanSuccess(decodedText, decodedResult) {
                // Pause kamera seketika saat barcode terbaca
                if (html5QrCode.getState() !== 3) {
                    html5QrCode.pause();
                }

                // Logika: Jika mengandung kata 'INV' tampilkan modal sukses
                if (decodedText.includes('INV')) {
                    showSuccessModal(decodedText);
                } else {
                    showErrorToast();
                    // Jika gagal/error, nyalakan lagi kameranya setelah 3 detik
                    setTimeout(() => html5QrCode.resume(), 3000);
                }
            }

            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            // Memaksa penggunaan kamera belakang (environment)
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess
            ).catch((err) => {
                console.error("Gagal memulai kamera: ", err);
                alert("Kamera belakang tidak ditemukan, atau izin akses ditolak.");
            });

            // Menyimpan instance ke window agar bisa diakses oleh fungsi closeModal()
            window.html5QrCodeInstance = html5QrCode;
        });
    </script>
@endsection
