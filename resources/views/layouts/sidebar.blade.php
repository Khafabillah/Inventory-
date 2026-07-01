<aside class="w-[225px] bg-[#C8DEEF] h-screen flex-shrink-0 flex flex-col hidden lg:flex border-r border-[#b5cce0]">
    <div class="h-30 px-8 bg-[#9FC7E7] flex items-center gap-3.5 border-b border-[#8eb5d5]/50 shadow-[0_4px_15px_rgba(0,0,0,0.03)] flex-shrink-0 z-10">
        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="#FFCD29">
            <path d="M9.367 2.25h5.266c1.092 0 1.958 0 2.655.057c.714.058 1.317.18 1.869.46a4.75 4.75 0 0 1 2.075 2.077c.281.55.403 1.154.461 1.868c.057.697.057 1.563.057 2.655v5.266c0 1.092 0 1.958-.057 2.655c-.058.714-.18 1.317-.46 1.869a4.75 4.75 0 0 1-2.076 2.075c-.552.281-1.155.403-1.869.461c-.697.057-1.563.057-2.655.057H9.367c-1.092 0-1.958 0-2.655-.057c-.714-.058-1.317-.18-1.868-.46a4.75 4.75 0 0 1-2.076-2.076c-.281-.552-.403-1.155-.461-1.869c-.057-.697-.057-1.563-.057-2.655V9.367c0-1.092 0-1.958.057-2.655c.058-.714.18-1.317.46-1.868a4.75 4.75 0 0 1 2.077-2.076c.55-.281 1.154-.403 1.868-.461c.697-.057 1.563-.057 2.655-.057M6.834 3.802c-.62.05-1.005.147-1.31.302a3.25 3.25 0 0 0-1.42 1.42c-.155.305-.251.69-.302 1.31c-.051.63-.052 1.434-.052 2.566v5.2c0 1.133 0 1.937.052 2.566c.05.62.147 1.005.302 1.31a3.25 3.25 0 0 0 1.42 1.42c.305.155.69.251 1.31.302c.392.032.851.044 1.416.05V3.752c-.565.005-1.024.017-1.416.049" />
        </svg>
        <h1 class="text-[26px] font-nunito font-medium tracking-tight text-[#071437] flex items-center">
            Inventor<span class="text-[#FFCD29] ml-0.5">+</span>
        </h1>
    </div>

    <nav class="flex flex-col px-4 pt-8 space-y-2">
        <a href="/dashboard" class="flex items-center gap-4 px-5 py-4 {{ request()->is('dashboard') ? 'bg-white shadow-[0_4px_10px_rgba(0,0,0,0.05)] text-[#071437]' : 'text-[#6388a7] hover:bg-white/50 hover:text-[#071437]' }} rounded-2xl font-bold transition-all">
            <svg class="w-6 h-6 {{ request()->is('dashboard') ? 'text-[#FFCD29]' : 'text-[#006EC4]' }}" viewBox="0 0 24 24"><path fill="currentColor" d="M3 13h8V3H3zm0 8h8v-6H3zm10 0h8V11h-8zm0-18v6h8V3z"/></svg>
            <span class="text-base">Dashboard</span>
        </a>

        <a href="/manajemen-aset" class="flex items-center gap-4 px-5 py-4 {{ request()->is('manajemen-aset') ? 'bg-white shadow-[0_4px_10px_rgba(0,0,0,0.05)] text-[#071437]' : 'text-[#6388a7] hover:bg-white/50 hover:text-[#071437]' }} rounded-2xl font-semibold transition-all">
            <svg class="w-6 h-6 {{ request()->is('manajemen-aset') ? 'text-[#FFCD29]' : 'text-[#006EC4]' }}" viewBox="0 0 24 24"><path fill="currentColor" d="M11 16H3v5h8zm2 0v5h8v-5zm-2-2V9H3v5zm2 0h8V9h-8zM3 7h18V3H3z"/></svg>
            <span class="text-base">Manajemen Aset</span>
        </a>

        <a href="#" class="flex items-center gap-4 px-5 py-4 rounded-2xl text-[#6388a7] hover:bg-white/50 hover:text-[#071437] font-semibold transition-all">
            <svg class="w-6 h-6 text-[#006EC4]" viewBox="0 0 24 24"><path fill="currentColor" d="M19.704 8.588C17.64 9.276 14.917 9.667 12 9.667s-5.64-.391-7.704-1.08C3.47 8.313 2.674 7.965 2 7.526v4.305c0 1.841 4.477 3.333 10 3.333s10-1.492 10-3.333V7.525c-.674.44-1.469.787-2.297 1.063"/><path fill="currentColor" d="M22 15.022c-.674.439-1.469.787-2.297 1.062c-2.063.688-4.786 1.08-7.703 1.08s-5.64-.392-7.704-1.08C3.47 15.81 2.674 15.462 2 15.022v4.645C2 21.507 6.477 23 12 23s10-1.492 10-3.333zM12 7.667c-5.523 0-10-1.493-10-3.334V4.33C2.005 2.49 6.48 1 12 1c4.142 0 7.696.84 9.214 2.036c.506.399.786.837.786 1.297c0 1.841-4.477 3.334-10 3.334"/></svg>
            <span class="text-base">Master Data</span>
        </a>

        <a href="#" class="flex items-center gap-4 px-5 py-4 rounded-2xl text-[#6388a7] hover:bg-white/50 hover:text-[#071437] font-semibold transition-all">
            <svg class="w-6 h-6 text-[#006EC4]" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21q-3.45 0-6.012-2.287T3.05 13H5.1q.35 2.6 2.313 4.3T12 19q2.925 0 4.963-2.037T19 12t-2.037-4.962T12 5q-1.725 0-3.225.8T6.25 8H9v2H3V4h2v2.35q1.275-1.6 3.113-2.475T12 3q1.875 0 3.513.713t2.85 1.924t1.925 2.85T21 12t-.712 3.513t-1.925 2.85t-2.85 1.925T12 21m2.8-4.8L11 12.4V7h2v4.6l3.2 3.2z"/></svg>
            <span class="text-base">Log Aktivitas</span>
        </a>
    </nav>
</aside>
