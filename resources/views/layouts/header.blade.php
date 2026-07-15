<header class="h-24 px-8 flex items-center justify-between bg-[#F8FAFC] border-b border-gray-100 flex-shrink-0">
    <div>
        <h1 class="...">Hello {{ auth()->user()->name ?? 'Guest' }}!</h1>
        <p class="text-xs font-medium text-gray-400 mt-0.5">Good Morning</p>
    </div>

    <div class="flex items-center gap-5">

        {{-- Profile & Logout Trigger --}}
        <div class="flex items-center gap-3 pl-2 pr-4 py-1.5 bg-white border border-gray-200 rounded-xl shadow-sm">
            {{-- Avatar Dinamis --}}
            {{-- Ganti bagian img src menjadi ini --}}
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Guest') }}&background=006EC4&color=fff&bold=true"
                alt="Avatar" class="w-9 h-9 rounded-lg">

            <div class="text-left">
                {{-- Nama & Email Dinamis --}}
                <div class="text-xs font-bold text-gray-900">{{ auth()->user()->name ?? 'Guest' }}</div>
                <div class="text-[10px] text-gray-500">{{ auth()->user()->email ?? 'No Email' }}</div>
            </div>

            <button onclick="showLogoutModal()"
                class="ml-2 text-gray-400 hover:text-red-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
            </button>
        </div>
    </div>
</header>
