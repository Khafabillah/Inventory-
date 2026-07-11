<div id="mobileSidebar" class="fixed inset-0 z-[1000] hidden">
    <div onclick="toggleMobileSidebar()" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

    <div class="absolute left-0 top-0 h-full w-[80%] max-w-[280px] bg-[#C8DEEF] shadow-2xl p-6 transition-transform">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-nunito font-extrabold text-lg text-[#071437]">Inventor<span class="text-[#FFCD29]">+</span></h1>
            <button onclick="toggleMobileSidebar()" class="text-2xl text-gray-600 active:scale-75 transition-transform">✕</button>
        </div>

        <div class="flex items-center gap-3 mb-10 pb-6 border-b border-gray-300">
            <img src="https://ui-avatars.com/api/?name=Mathias+W&background=006EC4&color=fff&bold=true" class="w-10 h-10 rounded-full">
            <div class="flex-1">
                <p class="text-sm font-bold text-gray-900">Mathias W.</p>
                <p class="text-[10px] text-gray-600">Store Manager</p>
            </div>
            <button onclick="showLogoutModal(); toggleMobileSidebar();" class="text-xl text-gray-600 active:scale-75 transition-transform">➔</button>
        </div>

        <nav class="space-y-1">
            {{-- Dashboard --}}
            <a href="/dashboard" class="flex items-center gap-4 py-3 {{ request()->is('dashboard') ? 'border-l-4 border-[#FFCD29] bg-white/40' : 'border-l-4 border-transparent' }} rounded-r-lg active:scale-[0.98] transition-transform">
                <span class="ml-4 {{ request()->is('dashboard') ? 'text-[#FFCD29]' : 'text-[#006EC4]' }}">■</span>
                <span class="font-bold text-gray-900">Dashboard</span>
            </a>

            {{-- Manajemen Aset --}}
            <a href="/manajemen-aset" class="flex items-center gap-4 py-3 {{ request()->is('manajemen-aset') ? 'border-l-4 border-[#FFCD29] bg-white/40' : 'border-l-4 border-transparent' }} rounded-r-lg active:scale-[0.98] transition-all">
                <span class="ml-4 {{ request()->is('manajemen-aset') ? 'text-[#FFCD29]' : 'text-[#006EC4]' }}">■</span>
                <span class="font-medium {{ request()->is('manajemen-aset') ? 'text-gray-900 font-bold' : 'text-gray-700' }}">Manajemen Aset</span>
            </a>

            {{-- Master Data --}}
            <a href="/master-data/akun" class="flex items-center gap-4 py-3 {{ request()->is('master-data*') ? 'border-l-4 border-[#FFCD29] bg-white/40' : 'border-l-4 border-transparent' }} rounded-r-lg active:scale-[0.98] transition-all">
                <span class="ml-4 {{ request()->is('master-data*') ? 'text-[#FFCD29]' : 'text-[#006EC4]' }}">■</span>
                <span class="font-medium {{ request()->is('master-data*') ? 'text-gray-900 font-bold' : 'text-gray-700' }}">Master Data</span>
            </a>

            {{-- Log Aktivitas --}}
            <a href="#" class="flex items-center gap-4 py-3 border-l-4 border-transparent text-[#006EC4] active:bg-blue-300/30 active:scale-[0.98] transition-all">
                <span class="ml-4 text-[#006EC4]">■</span>
                <span class="font-medium text-gray-700">Log Aktivitas</span>
            </a>

            {{-- Scanner --}}
            <a href="#" class="flex items-center gap-4 py-3 border-l-4 border-transparent text-[#006EC4] active:bg-blue-300/30 active:scale-[0.98] transition-all">
                <span class="ml-4 text-[#006EC4]">■</span>
                <span class="font-medium text-gray-700">Scanner</span>
            </a>
        </nav>
    </div>
</div>
