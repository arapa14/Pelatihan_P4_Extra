<header class="p-4 md:p-6 border-b border-slate-700 glass flex justify-between items-center">
    <div class="flex items-center gap-3">
        <button id="menuBtn" class="md:hidden p-2 rounded-lg hover:bg-slate-700" aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div>
            <h2 class="text-xl md:text-2xl font-semibold">{{ $title ?? 'Dashboard' }}</h2>
            <p class="text-slate-400 text-sm">Selamat datang kembali di sistem manajemen Kantor Papoy.</p>
        </div>
    </div>

    @php $user = auth()->user(); @endphp

    <div class="flex items-center gap-3">
        {{-- Nama & Role (vertical stack) --}}
        <div class="flex flex-col leading-tight">
            <span class="text-sm font-medium text-slate-100">
                {{ $user?->name ?? 'Tamu' }}
            </span>
            <span class="text-xs text-slate-400">
                {{ ucfirst($user?->email ?? '-') }}
            </span>
        </div>
    </div>

</header>