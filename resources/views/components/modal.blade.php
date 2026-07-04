@props(['id','title'])

<div id="{{ $id }}" class="bg-black/50 fixed inset-0 z-50 hidden items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md relative">
        <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="text-lg font-semibold" style="color: #006EC4">{{ $title }}</h3>
            <button type="button" onclick="toggleModal('{{ $id }}')" class="text-[#FFCD29] text-xl font-bold">&times;</button>
        </div>

        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
