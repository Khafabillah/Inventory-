@extends('layouts.app')

@section('content')
    {{-- CSS Kustom untuk memaksa tampilan --}}
    <style>
        /* Membunuh UI kotak putih bawaan library */
        #qr-shaded-region {
            display: none !important;
        }

        /* Memaksa video agar benar-benar full menutupi layar */
        #reader video {
            object-fit: cover !important;
            width: 100% !important;
            height: 100vh !important;
        }

        /* Menghilangkan border bawaan library jika ada */
        #reader {
            border: none !important;
        }
    </style>

    {{-- Input file tersembunyi untuk fitur Galeri --}}
    <input type="file" id="gallery-input" class="hidden" accept="image/*">

    {{-- ================= KANVAS SCANNER CUSTOM (FIGMA DESIGN) ================= --}}
    <div
        class="fixed top-[60px] bottom-0 left-0 right-0 bg-black z-40 overflow-hidden flex flex-col items-center justify-center">

        {{-- Tempat Video Kamera Dirender --}}
        <div id="reader" class="absolute inset-0 w-full h-full"></div>

        {{-- Overlay Gelap di Luar Kotak Scan (Efek Fokus) --}}
        {{-- FIX TOMBOL NABRAK: Atas-bawah 120px (tebal), kiri-kanan 50px --}}
        <div class="absolute inset-0 pointer-events-none border-x-[50px] border-y-[120px] border-black/70 z-10"></div>

        {{-- Tombol Ikon Atas (Flash, Gallery, Switch Camera) --}}
        {{-- Digeser sedikit ke top-10 biar persis di tengah area gelap atas --}}
        <div class="absolute top-10 w-full flex justify-center gap-5 z-20">
            <button id="btn-flash"
                class="bg-gray-800/80 p-3 rounded-xl border border-gray-600 text-[#38BDF8] hover:bg-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                    </path>
                </svg>
            </button>
            <button id="btn-gallery"
                class="bg-gray-800/80 p-3 rounded-xl border border-gray-600 text-[#38BDF8] hover:bg-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </button>
            <button id="btn-switch"
                class="bg-gray-800/80 p-3 rounded-xl border border-gray-600 text-[#38BDF8] hover:bg-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </button>
        </div>

        {{-- Kotak Area Target & Garis Merah Laser --}}
        <div class="absolute flex items-center justify-center pointer-events-none z-20">
            <div
                class="w-64 h-64 border-2 border-[#38BDF8] rounded-xl relative overflow-hidden flex flex-col justify-center">
                <div class="w-full h-[2px] bg-red-600 shadow-[0_0_10px_3px_rgba(220,38,38,0.9)] animate-pulse"></div>
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
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button
                    class="w-full bg-[#006EC4] text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-700 transition">Edit</button>
                <button
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
        const overlay = document.getElementById('modal-overlay');
        const modalSuccess = document.getElementById('modal-success');
        const toastError = document.getElementById('toast-error');

        function closeModal() {
            overlay.classList.add('hidden');
            modalSuccess.classList.add('hidden');
            if (window.html5QrCodeInstance && window.html5QrCodeInstance.getState() === 3) {
                window.html5QrCodeInstance.resume();
            }
        }

        function showSuccessModal(decodedText) {
            overlay.classList.remove('hidden');
            modalSuccess.classList.remove('hidden');
            document.getElementById('txt-kode').innerText = decodedText;
        }

        function showErrorToast() {
            toastError.classList.remove('hidden');
            setTimeout(() => {
                toastError.classList.add('hidden');
            }, 3000);
        }

        // === LOGIKA SCANNER & FUNGSI TOMBOL ===
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("reader");
            window.html5QrCodeInstance = html5QrCode;

            let currentFacingMode = "environment"; // Default kamera belakang
            let isFlashOn = false;

            const config = {
                fps: 15,
                disableFlip: false
            };

            // FIX LOGIKA DETEKSI SAPU JAGAT (Pasti Muncul Modal)
            function onScanSuccess(decodedText, decodedResult) {
                if (html5QrCode.getState() !== 3) {
                    html5QrCode.pause();
                }

                let kodeAset = decodedText;

                // Jika hasil scan berupa Link/URL panjang, kita potong dan ambil ujungnya saja
                if (kodeAset.includes('http') || kodeAset.includes('/')) {
                    const parts = kodeAset.split('/');
                    kodeAset = parts[parts.length - 1]; // Misal: mengambil "WML-038" dari URL
                }

                // Langsung tampilkan modal sukses, apapun isinya!
                showSuccessModal(kodeAset);
            }

            function startKamera() {
                html5QrCode.start({
                        facingMode: currentFacingMode,
                        width: {
                            ideal: 1280
                        }, // PAKSA KAMERA PAKAI RESOLUSI TINGGI
                        height: {
                            ideal: 720
                        }
                    },
                    config,
                    onScanSuccess
                ).catch((err) => {
                    console.error("Kamera gagal:", err);
                });
            }

            startKamera();

            // 1. FUNGSI SWITCH CAMERA
            document.getElementById('btn-switch').addEventListener('click', async () => {
                try {
                    await html5QrCode.stop();
                    currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                    startKamera();
                } catch (err) {
                    console.error("Gagal menukar kamera", err);
                }
            });

            // 2. FUNGSI GALERI
            const galleryInput = document.getElementById('gallery-input');
            document.getElementById('btn-gallery').addEventListener('click', () => {
                galleryInput.click();
            });

            galleryInput.addEventListener('change', async (e) => {
                if (e.target.files.length === 0) return;
                const file = e.target.files[0];
                try {
                    if (html5QrCode.isScanning) {
                        await html5QrCode.stop();
                    }
                    const decodedText = await html5QrCode.scanFile(file, true);

                    let kodeAset = decodedText;
                    if (kodeAset.includes('http') || kodeAset.includes('/')) {
                        const parts = kodeAset.split('/');
                        kodeAset = parts[parts.length - 1];
                    }
                    showSuccessModal(kodeAset);
                    startKamera();
                } catch (err) {
                    showErrorToast();
                    startKamera();
                }
            });

            // 3. FUNGSI FLASH
            document.getElementById('btn-flash').addEventListener('click', async () => {
                const btnFlash = document.getElementById('btn-flash');
                try {
                    const videoTrack = html5QrCode.getVideoTrack();
                    if (videoTrack && typeof videoTrack.getCapabilities === 'function') {
                        const capabilities = videoTrack.getCapabilities();
                        if (capabilities.torch) {
                            isFlashOn = !isFlashOn;
                            await videoTrack.applyConstraints({
                                advanced: [{
                                    torch: isFlashOn
                                }]
                            });
                            if (isFlashOn) {
                                btnFlash.classList.replace('text-[#38BDF8]', 'text-white');
                                btnFlash.classList.replace('bg-gray-800/80', 'bg-blue-500');
                            } else {
                                btnFlash.classList.replace('text-white', 'text-[#38BDF8]');
                                btnFlash.classList.replace('bg-blue-500', 'bg-gray-800/80');
                            }
                        } else {
                            alert(
                                "Kamera Anda tidak memiliki flash atau tidak diizinkan oleh browser Safari.");
                        }
                    } else {
                        alert("Fitur flash tidak didukung di perangkat ini.");
                    }
                } catch (err) {
                    alert("Gagal menyalakan flash: Sistem operasi membatasi akses.");
                }
            });
        });
    </script>
@endsection
