@php
    // contoh: $active bisa 'dashboard','pegawai','lembur','golongan','gaji'
    $user = auth()->user();
    $role = $user->role ?? 'user'; // asumsi ada kolom role, contoh: 'admin' atau 'user'
@endphp

<aside id="sidebar"
    class="fixed md:static inset-y-0 left-0 w-64 glass shadow-xl flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-40">
    <div class="flex items-center gap-3 p-6 border-b border-slate-700">
        <div
            class="w-10 h-10 rounded-md bg-gradient-to-tr from-primary to-accent flex items-center justify-center text-slate-900 font-bold">
            KP</div>
        <h1 class="font-semibold text-lg">Kantor Papoy</h1>
    </div>

    <nav class="flex-1 p-4">
        <ul class="space-y-2 text-slate-300">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 rounded-xl transition
             {{ ($active ?? '') === 'dashboard' ? 'bg-slate-700 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
                    🏠 Dashboard
                </a>
            </li>

            <li>
                <a href="" class="block px-4 py-2 rounded-xl transition
             {{ ($active ?? '') === 'pegawai' ? 'bg-slate-700 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
                    👨‍💼 Pegawai
                </a>
            </li>

            <li>
                <a href="" class="block px-4 py-2 rounded-xl transition
             {{ ($active ?? '') === 'lembur' ? 'bg-slate-700 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
                    🕒 Lembur
                </a>
            </li>

            <li>
                <a href="" class="block px-4 py-2 rounded-xl transition
             {{ ($active ?? '') === 'golongan' ? 'bg-slate-700 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
                    📊 Golongan
                </a>
            </li>

            <li>
                <a href="" class="block px-4 py-2 rounded-xl transition
             {{ ($active ?? '') === 'gaji' ? 'bg-slate-700 text-white' : 'hover:bg-slate-700 hover:text-white' }}">
                    💰 Gaji
                </a>
            </li>

            {{-- contoh menu khusus admin --}}
            @if($role === 'admin')
                <li class="mt-4">
                    <span class="text-xs text-slate-400 px-4 block">Administrator</span>
                </li>
                <li>
                    <a href=""
                        class="block px-4 py-2 rounded-xl hover:bg-slate-700 hover:text-white transition">
                        ⚙️ Pengaturan
                    </a>
                </li>
            @endif
        </ul>
    </nav>

    <div class="p-4 border-t border-slate-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full py-2 rounded-xl bg-gradient-to-r from-primary to-accent text-slate-900 font-semibold hover:scale-[1.02] transition">
                Keluar
            </button>
        </form>
    </div>
</aside>