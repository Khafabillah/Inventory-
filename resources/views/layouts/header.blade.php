<header class="h-24 px-8 flex items-center justify-between bg-[#F8FAFC] border-b border-gray-100 flex-shrink-0">
    <div>
        <h1 class="text-xl font-bold text-gray-900 tracking-tight">Hello Mathias!</h1>
        <p class="text-xs font-medium text-gray-400 mt-0.5">Good Morning</p>
    </div>

    <div class="flex items-center gap-5">

        {{-- Lonceng --}}
        <button class="p-2 text-gray-400 hover:text-gray-900 transition-colors cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        </button>

        {{-- Profile & Logout Trigger --}}
        <div class="flex items-center gap-3 pl-2 pr-4 py-1.5 bg-white border border-gray-200 rounded-xl shadow-sm">
            <img src="https://ui-avatars.com/api/?name=Mathias+W&background=006EC4&color=fff&bold=true" alt="Avatar" class="w-9 h-9 rounded-lg">
            <div class="text-left">
                <div class="text-xs font-bold text-gray-900">Mathias W.</div>
                <div class="text-[10px] text-gray-500">Store Manager</div>
            </div>
            <button onclick="showLogoutModal()" class="ml-2 text-gray-400 hover:text-red-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
            </button>
        </div>
    </div>
</header>
