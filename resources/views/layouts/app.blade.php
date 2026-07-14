<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventor+</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Lexend:wght@300;400;500;600;700;800&family=Nunito:wght@700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#C8DEEF] lg:bg-[#F8FAFC] text-gray-900 font-['Lexend',sans-serif] antialiased">

    <div class="flex h-screen w-full overflow-hidden">
        {{-- Sidebar (Desktop) --}}
        <div class="hidden lg:block flex-shrink-0">
            @include('layouts.sidebar')
        </div>

        <div class="flex-1 flex flex-col h-full overflow-hidden">

            <div class="flex-1 flex flex-col h-full overflow-hidden">
                {{-- Header Mobile (Panggil file header-mobile.blade.php) --}}
                @include('layouts.header-mobile')

                {{-- Header Desktop (Panggil file header.blade.php) --}}
                <div class="hidden lg:block">
                    @include('layouts.header')
                </div>

                {{-- Main Content --}}
                <main class="flex-1 overflow-y-auto p-4 lg:p-8 bg-[#C8DEEF] lg:bg-[#F8FAFC]">
                    @yield('content')
                </main>
            </div>

            {{-- Modal Logout --}}
            <div id="logoutModal"
                class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900/40 backdrop-blur-sm">
                <div class="bg-white p-8 rounded-3xl shadow-xl w-[360px] text-center border border-gray-100">
                    <div class="text-[#FFCD29] mb-6 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-[#006EC4] mb-2">Keluar dari sistem?</h2>
                    <p class="text-sm text-gray-500 mb-8">Apakah Anda yakin ingin mengakhiri sesi dan keluar dari
                        sistem?</p>
                    <div class="flex gap-3">
                        <button onclick="closeLogoutModal()"
                            class="flex-1 py-3 border-2 border-[#006EC4] text-[#006EC4] font-bold rounded-2xl hover:bg-blue-50 transition cursor-pointer">Tidak</button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 bg-[#006EC4] text-white font-bold rounded-2xl hover:bg-[#005bb5] transition cursor-pointer">Ya</button>
                        </form>
                    </div>
                </div>
            </div>

            @include('layouts.sidebar-mobile')

            <script>
                // Fungsi Toggle Sidebar
                function toggleMobileSidebar() {
                    document.getElementById('mobileSidebar').classList.toggle('hidden');
                }

                // Pasang event listener ke tombol hamburger di header-mobile
                // Catatan: Pastikan ID tombol hamburger di header-mobile.blade.php adalah 'mobileMenuBtn'
                document.addEventListener('DOMContentLoaded', () => {
                    const menuBtn = document.getElementById('mobileMenuBtn');
                    if (menuBtn) {
                        menuBtn.addEventListener('click', toggleMobileSidebar);
                    }
                });

                // Fungsi Modal Logout (dari sebelumnya)
                function showLogoutModal() {
                    document.getElementById('logoutModal').classList.remove('hidden');
                }

                function closeLogoutModal() {
                    document.getElementById('logoutModal').classList.add('hidden');
                }
            </script>

            <script>
                function showLogoutModal() {
                    document.getElementById('logoutModal').classList.remove('hidden');
                }

                function closeLogoutModal() {
                    document.getElementById('logoutModal').classList.add('hidden');
                }
            </script>
</body>

</html>
